<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\GoodLoanRequest;
use App\Models\Room;
use Illuminate\Http\Request;
use App\Models\GoodLoan;
use App\Models\GoodEntry;
use App\Models\LoanDetail;
use Illuminate\Support\Str;
use Carbon\Carbon;


class GoodLoanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $start = Carbon::parse(request('start_date'));
        $end = Carbon::parse(request('end_date'));
        $now_date = Carbon::now();

        if (request('end_date') < request('start_date')) {
            return redirect()->back()->with('error', 'Tanggal akhir tidak boleh kurang dari tanggal awal');
        }

        if (request('start_date') && request('end_date') && request('status')) {
            $filter_items = GoodLoan::with(['room', 'details'])->whereDate('created_at', '<=', $end)
                ->whereDate('created_at', '>=', $start)
                ->where('status', request('status'))->paginate(10);
        } elseif (request('start_date') && request('end_date') && !(request('status'))) {
            $filter_items = GoodLoan::with(['room', 'details'])->whereDate('created_at', '<=', $end)
                ->whereDate('created_at', '>=', $start)->paginate(10);
        } else {
            $filter_items = GoodLoan::with(['room', 'details'])->whereMonth('created_at', $now_date)
                ->paginate(10);
        }

        // $items = GoodLoan::with(['good_entry', 'room'])->paginate(10);

        return view('pages.good_loan.index', [
            'filter_items' => $filter_items
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $item = GoodLoan::all();
        $good_entries = GoodEntry::all();
        $rooms = Room::all();
        $details = LoanDetail::all();

        return view('pages.good_loan.create', [
            'item' => $item,
            'good_entries' => $good_entries,
            'rooms' => $rooms,
            'details' => $details
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GoodLoanRequest $request)
    {
        $loan = GoodLoan::create([
            'rooms_id' => $request->rooms_id,
            'borrower_name' => $request->borrower_name,
            'date_borrow' => $request->date_borrow,
            'date_return' => null,
            'status' => $request->status,
            'slug' =>  Str::slug($request->rooms_id)
        ]);

        $request->validate([
            'goods_id' => 'required|exists:good_entries,id',
            'qty' => 'required'
        ]);

        $loans_id = $loan->id;
        $qty = $request->qty;
        $created_at = date('Y-m-d H:i:s');

        foreach ($request->goods_id as $key => $goods_id) {
            $data = [
                'goods_id' => $goods_id,
                'loans_id' => $loans_id,
                'entries_id' => $goods_id,
                'qty' => $qty[$key],
                'created_at' => $created_at
            ];
            
            $good_entry = GoodEntry::with('loan_details')->where('id', 'like', $data['goods_id'])->first();

            if ($qty[$key] && $good_entry->stock > 0 && $good_entry->stock >= $qty[$key]) {
                $good_entry->stock -= (int) $qty[$key];
                $good_entry->save();
            } else {
                GoodLoan::where('id', 'like', $loan->id)->delete();
                return redirect()->back()->with(['error' => 'Stok pada barang tersebut sudah habis atau kurang!']);
            }
            LoanDetail::insert($data);
        }

        return redirect()->route('good_loan.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = GoodLoan::with([
            'room', 'details'
        ])->findOrFail($id);

        return view('pages.good_loan.detail', [
            'item' => $item
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $filter_items = GoodLoan::with([
            'room', 'details'
        ])->findOrFail($id);
        $rooms = Room::all();

        return view('pages.good_loan.edit', [
            'filter_items' => $filter_items,
            'rooms' => $rooms
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(GoodLoanRequest $request, $id)
    {
        $data = $request->all();
        $data['slug'] = Str::slug($request->rooms_id);

        $filter_item = GoodLoan::findOrFail($id);

        if($request->date_return <= $request->date_borrow) {
            return redirect()->back()->with(['error' => 'Tanggal pengembalian tidak boleh kurang dari tanggal peminjaman!']);
        }

        $qty = $filter_item->qty;
        foreach ($request->goods_id as $key => $goods_id) {
            $loan = $goods_id;

            $good_entry = GoodEntry::with(['loan_details'])->where('id', 'like', $loan)->first();

            if ($request->status == 'DIKEMBALIKAN' && $request->date_return == TRUE) {
                $good_entry->stock += (int) $qty[$key];
            }
            $good_entry->save();
        }
        $filter_item->update($data);

        return redirect()->route('good_loan.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $filter_item = GoodLoan::findOrFail($id);
        while($loan_details = LoanDetail::where('loans_id', 'like', $id)->first()) {
            $loan_details->delete();
            if(!$loan_details) {
                break;
            }
        }
        $filter_item->delete();

        return redirect()->route('good_loan.index');
    }
}
