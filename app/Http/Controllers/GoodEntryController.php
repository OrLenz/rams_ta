<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\GoodEntryRequest;
use App\Models\Good;
use App\Models\Room;
use Illuminate\Http\Request;
use App\Models\GoodEntry;
use App\Models\Supplier;
use App\Models\Warehouse;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\PDF;
use Illuminate\Support\Facades\Validator;

class GoodEntryController extends Controller
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

        if(request('end_date') < request('start_date')) {
            return redirect()->back()->with('error', 'Tanggal akhir tidak boleh kurang dari tanggal awal');
        }

        if (request('start_date') && request('end_date') && request('search')) {
            $filter_items = GoodEntry::with(['good', 'room'])->whereDate('date_of_entry', '>=', $start)
                ->whereDate('date_of_entry', '<=', $end)    
                ->where('code_goods', request('search'))->paginate(10);
        } else if(request('start_date') && request('end_date') && !(request('search'))) {
            $filter_items = GoodEntry::with(['good', 'room'])->whereDate('date_of_entry', '>=', $start)
                ->whereDate('date_of_entry', '<=', $end)->paginate(10);
        } else {
            $filter_items = GoodEntry::with(['good', 'room'])->paginate(10);
        }

        return view('pages.good_entry.index', [
            'filter_items' => $filter_items,
            'now_date' => $now_date
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $filter_items = GoodEntry::all();
        $goods = Good::all();
        $rooms = Room::all();
        $suppliers = Supplier::all();
        return view('pages.good_entry.create', [
            'goods' => $goods,
            'filter_items' => $filter_items,
            'rooms' => $rooms,
            'suppliers' => $suppliers
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GoodEntryRequest $request)
    {
        $data = $request->all();
        $data['slug'] = Str::slug($request->goods_id);

        // $getWarehouse = $request->select('goods_id', 'rooms_id', 'stock', 'condition')->get();

        // Warehouse::create($data);
        GoodEntry::create($data);

        return redirect()->route('good_entry.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $qrcode = GoodEntry::findOrFail($id);

        return view('pages.good_entry.qrcode', [
            'qrcode' => $qrcode
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
        $filter_items = GoodEntry::findOrFail($id);
        $goods = Good::all();
        $rooms = Room::all();
        $suppliers = Supplier::all();

        return view('pages.good_entry.edit', [
            'goods' => $goods,
            'filter_items' => $filter_items,
            'rooms' => $rooms,
            'suppliers' => $suppliers
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(GoodEntryRequest $request, $id)
    {
        $data = $request->all();
        $data['slug'] = Str::slug($request->goods_id);

        $filter_items = GoodEntry::findOrFail($id);

        $filter_items->update($data);

        return redirect()->route('good_entry.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $filter_items = GoodEntry::findOrFail($id);
        $filter_items->delete();

        return redirect()->route('good_entry.index');
    }

    public function summary(Request $request)
    {
        $start = Carbon::parse(request('start_date'));
        $end = Carbon::parse(request('end_date'));
        $now = Carbon::now();

        if(request('end_date') < request('start_date')) {
            return redirect()->back()->with('error', 'Tanggal akhir tidak boleh kurang dari tanggal awal');
        }

        if (request('start_date') && request('end_date') && request('search')) {
            $get_all_entries = GoodEntry::with(['good', 'room'])->whereDate('date_of_entry', '<=', $end)
                ->whereDate('date_of_entry', '>=', $start)
                ->where('code_goods', 'like', '%' . request('search') . '%')->get();
        } else {
            $get_all_entries = GoodEntry::whereDate('date_of_entry', '<=', $now)
                ->whereDate('date_of_entry', '>=', $now)->get();
        }

        $get_array = [];

        foreach ($get_all_entries as $get_all_entry) {
            $get_array = [
                'id' => $get_all_entry->id,
                'code_goods' => $get_all_entry->code_goods,
                'goods_id' => $get_all_entry->good->stuff,
                'rooms_id' => $get_all_entry->room->room_name,
                'stock' => $get_all_entry->stock,
                'condition' => $get_all_entry->condition,
                'date_of_entry' => $get_all_entry->date_of_entry,
                'suppliers_id' => $get_all_entry->supplier->supplier_name
            ];
        }

        return view('pages.good_entry.summary', [
            'get_all_entries' => $get_all_entries,
            'get_array' => $get_array
        ]);
    }

    public function summary_pdf(Request $request)
    {
        $get_entries = $request->data_entries;

        $get_all_entries = json_decode($get_entries[0]);

        // dd($get_all_entries);

        $pdf = PDF::loadview('pages.good_entry.summary_pdf', [
            'get_all_entries' => $get_all_entries
        ])->setPaper('a4', 'potrait');

        return $pdf->download('Laporan Rangkuman Barang.pdf');
    }

    public function depreciation()
    {
        $start = Carbon::parse(request('start_date'));
        $end = Carbon::parse(request('end_date'));
        $now = Carbon::now();

        if (request('start_date') && request('end_date') && request('department') && request('search')) {
            $filter_items = GoodEntry::with(['good', 'room'])->whereDate('date_of_entry', '<=', $end)
                ->whereDate('date_of_entry', '>=', $start)
                ->where('room_name', 'like', request('department') . '%')
                ->where('code_goods', 'like', '%' . request('search') . '%')->get();
        } else {
            $filter_items = GoodEntry::whereDate('date_of_entry', '<=', $now)
                ->whereDate('date_of_entry', '>=', $now)->get();
        }

        return view('pages.good_entry.depreciation', compact('filter_items'));
    }

    public function depreciation_edit($id)
    {
        $filter_items = GoodEntry::findOrFail($id);
        $goods = Good::all();
        $rooms = Room::all();
        $suppliers = Supplier::all();

        return view('pages.good_entry.depreciation_edit', [
            'goods' => $goods,
            'filter_items' => $filter_items,
            'rooms' => $rooms,
            'suppliers' => $suppliers
        ]);
    }
}
