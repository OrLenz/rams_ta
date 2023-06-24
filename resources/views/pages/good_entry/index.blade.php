@extends('layouts.admin')

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Warehouse</h1>
        <a href="{{ route('good_entry.create') }}" class="btn btn-primary btn-sm shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Barang Masuk
        </a>
    </div>

    <!-- Search Filter -->
    <form action="/good_entry" method="get">
        <div class="row filter-row mb-4">
            <div class="col-sm-6 col-md-3">
                <div class="form-group">
                    <input type="date" name="start_date" class="form-control" required>
                    <label for="start_date">From</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="form-group">
                    <input type="date" name="end_date" class="form-control" required>
                    <label for="end_date">To</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="form-group">
                    <input type="text" name="search" class="form-control">
                    <label for="search">Kode Barang</label>
                </div>
            </div>
            {{-- <div class="col-sm-6 col-md-3">
                <div class="form-group form-focus">
                    <select name="department" class="form-control">
                        <option value="">Pilih Department</option>
                        <option value="R01">TK</option>
                        <option value="R02">SD</option>
                        <option value="R03">SMP</option>
                        <option value="R04">SMA</option>
                        <option value="R05">Yayasan</option>
                        <option value="R06">Yayasan Lama</option>
                        <option value="R07">Kantin</option>
                        <option value="R08">Toko Sekolah</option>
                        <option value="R09">Markom</option>
                    </select>
                    <label for="department">Department</label>
                </div>
            </div> --}}
            <div class="col-sm-6 col-md-3">
                <button class="btn btn-success btn-block" type="submit">Cari</button>
            </div>
        </div>
    </form>
    <!-- /Search Filter -->

    <div class="row">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Ruangan</th>
                            <th>Jumlah</th>
                            <th>Supplier</th>
                            <th>Tanggal Masuk</th>
                            <th>Kondisi</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($filter_items as $filter_item)
                        <tr>
                            <td>{{ $filter_item->id }}</td>
                            <td>{{ $filter_item->code_goods }}</td>
                            <td>{{ $filter_item->good->stuff }}</td>
                            <td>{{ $filter_item->room->room_name }}</td>
                            <td>{{ $filter_item->stock }}</td>
                            <td>{{ $filter_item->supplier->supplier_name }}</td>
                            <td>{{ $filter_item->date_of_entry }}</td>
                            <td>{{ $filter_item->condition }}</td>
                            <td>
                                <a href="{{ route('good_entry.edit', $filter_item->id) }}" class="btn btn-info">
                                    <i class="fa fa-pencil-alt"></i>
                                </a>
                                <a href="{{ route('good_entry.show', $filter_item->id) }}" class="btn btn-primary">
                                    QR Code
                                </a>
                                <form action="{{ route('good_entry.destroy', $filter_item->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-danger">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center">
                                Data Kosong
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $filter_items->links() }}
            </div>
        </div>
    </div>


</div>
<!-- /.container-fluid -->
@endsection