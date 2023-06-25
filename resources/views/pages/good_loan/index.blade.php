@extends('layouts.admin')

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Peminjaman Barang</h1>
        <a href="{{ route('good_loan.create') }}" class="btn btn-primary btn-sm shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Peminjaman Barang
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
                <div class="form-group form-focus">
                    <select name="status" required class="form-control">
                        <option value="">Pilih Status</option>
                        <option value="DIPINJAM">Dipinjam</option>
                        <option value="DIKEMBALIKAN">Dikembalikan</option>
                    </select>
                    <label for="status">Status</label>
                </div>
            </div>
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
                            <th>Ruangan Tujuan</th>
                            <th>Nama Peminjam</th>
                            <th>Tanggal Pinjam</th>
                            <th>Tanggal Kembali</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($filter_items as $filter_item)
                        <tr>
                            <td>{{ $filter_item->id }}</td>
                            <td>{{ $filter_item->room->room_name }}</td>
                            <td>{{ $filter_item->borrower_name }}</td>
                            <td>{{ $filter_item->date_borrow }}</td>
                            <td>{{ $filter_item->date_return }}</td>
                            <td>{{ $filter_item->status }}</td>
                            <td>
                                @if ($filter_item->status === 'DIPINJAM' || $filter_item->date_return == FALSE)
                                <a href="{{ route('good_loan.edit', $filter_item->id) }}" class="btn btn-info">
                                    <i class="fa fa-pencil-alt"></i>
                                </a>
                                @endif
                                <a href="{{ route('good_loan.show', $filter_item->id) }}" class="btn btn-primary">
                                    Detail
                                </a>
                                @if ($filter_item->status === 'DIKEMBALIKAN' && $filter_item->date_return == TRUE)
                                <form action="{{ route('good_loan.destroy', $filter_item->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-danger">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                                @endif
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