@extends('layouts.admin')

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Ubah Data Peminjaman</h1>
    </div>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="card shadow">
        <div class="card-body">
            <form action="{{ route('good_loan.update', $filter_items->id) }}" method="POST">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label for="rooms_id">Ruangan Tujuan</label>
                    <select name="rooms_id" class="form-control">
                        <option value="{{ $filter_items->rooms_id }}">Jangan Ubah Ruangan</option>
                        @foreach ($rooms as $room)
                        <option value="{{ $room->id }}">
                            {{ $room->room_name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="borrower_name">Nama Peminjam</label>
                    <input type="text" name="borrower_name" class="form-control" placeholder="Nama Peminjam"
                        value="{{ $filter_items->borrower_name }}">
                </div>
                <div class="form-group">
                    <label for="date_borrow">Tanggal Pinjam</label>
                    <input type="date" name="date_borrow" class="form-control" placeholder="Tanggal Pinjam"
                        value="{{ $filter_items->date_borrow }}" readonly>
                </div>
                <div class="form-group">
                    <label for="date_return">Tanggal Kembali</label>
                    <input type="date" name="date_return" class="form-control" placeholder="Tanggal Kembali"
                        value="{{ $filter_items->date_return }}">
                </div>
                <table class="table table-bordered">
                    <thead>
                        <tr class="bg-navy disabled">
                            <th class="px-1 py-1 text-center">Nama Barang dan Asal Ruangan</th>
                            <th class="px-1 py-1 text-center">Jumlah</th>
                        </tr>
                    </thead>
                    @foreach($filter_items->details as $detail)
                    <tbody>
                        <tr class="line_items">
                            <td class="align-middle p-1">
                                <select name="goods_id[]" class="form-control">
                                    <option value="{{ $detail->goods_id }}">
                                        {{
                                        $detail->good_entry->good->stuff }} - {{ $detail->good_entry->room->room_name
                                        }}
                                    </option>
                                </select>
                            </td>
                            <td class="align-middle p-1">
                                <input type="text" class="text-center w-100 border-0" name="qty[]"
                                    value="{{ $detail->qty }}">
                            </td>
                        </tr>
                    </tbody>
                    @endforeach
                </table>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" required class="form-control">
                        <option value="{{ $filter_items->status }}">
                            Dipinjam
                        </option>
                        <option value="DIKEMBALIKAN">Dikembalikan</option>
                    </select>
                </div>
        </div>
        <button type="submit" class="btn btn-primary btn-block">
            Ubah
        </button>
        </form>
    </div>
</div>

<!-- /.container-fluid -->
@endsection