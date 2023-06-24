@extends('layouts.admin')

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Peminjaman</h1>
    </div>

    <!-- Content Row -->
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
            <table class="table table-bordered">
                <tr>
                    <th>ID</th>
                    <td>{{ $item->id }}</td>
                </tr>
                <tr>
                    <th>Ruangan Tujuan</th>
                    <td>{{ $item->room->room_name }}</td>
                </tr>
                <tr>
                    <th>Peminjam</th>
                    <td>{{ $item->borrower_name }}</td>
                </tr>
                <tr>
                    <th>Tanggal Pinjam</th>
                    <td>{{ $item->date_borrow }}</td>
                </tr>
                <tr>
                    <th>Tanggal Kembali</th>
                    <td>{{ $item->date_return }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>{{ $item->status }}</td>
                </tr>
                <tr>
                    <th>Peminjaman</th>
                    <td>
                        <table class="table table-bordered">
                            <tr>
                                <th>Barang</th>
                                <th>Asal Ruangan</th>
                                <th>Jumlah</th>
                            </tr>
                            @foreach($item->details as $detail)
                            <tr>
                                <td>{{ $detail->good_entry->good->stuff }}</td>
                                <td>{{ $detail->good_entry->room->room_name }}</td>
                                <td>{{ $detail->qty }}</td>
                            </tr>
                            @endforeach
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
@endsection