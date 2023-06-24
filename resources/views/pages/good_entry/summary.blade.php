@extends('layouts.admin')

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Laporan Rangkuman Barang</h1>
        <form action="{{ route('summary_pdf') }}" method="post">
            @csrf
            @foreach ($get_all_entries as $value)
            <input type="hidden" name="data_entries[]" value="{{ $value }}">
            @endforeach
            <button class="btn btn-primary btn-icon-split" type="submit">
                <span class="icon text-white-50">
                    <i class="fas fa-print"></i>
                </span>
                <span class="text">PDF</span>
        </form>
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

    <!-- Page Wrapper -->
    <div class="page-wrapper">

        <!-- Page Content -->
        <div class="content container-fluid">

            <!-- Search Filter -->
            <form action="/summary_report" method="get">
                <div class="row filter-row mb-4">
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group form-focus">
                            <div class="cal-icon">
                                <input class="form-control" type="date" name="start_date" required>
                            </div>
                            <label class="focus-label">From</label>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group form-focus">
                            <div class="cal-icon">
                                <input class="form-control" type="date" name="end_date" required>
                            </div>
                            <label class="focus-label">To</label>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="form-group">
                            <input type="text" name="search" class="form-control" required>
                            <label for="search">Kode Barang</label>
                        </div>
                    </div>
                    {{-- <div class="col-sm-6 col-md-3">
                        <div class="form-group form-focus">
                            <select name="department" required class="form-control">
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
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-striped custom-table mb-0 datatable">
                            <thead>
                                <tr>
                                    <th>Kode Barang</th>
                                    <th>Nama Barang</th>
                                    <th>Ruangan</th>
                                    <th>Jumlah</th>
                                    <th>Supplier</th>
                                    <th>Tanggal Masuk</th>
                                    <th>Kondisi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($get_all_entries as $get_all_entry)
                                <tr>
                                    <td>{{ $get_all_entry->code_goods }}</td>
                                    <td>{{ $get_all_entry->good->stuff }}</td>
                                    <td>{{ $get_all_entry->room->room_name }}</td>
                                    <td>{{ $get_all_entry->stock }}</td>
                                    <td>{{ $get_all_entry->supplier->supplier_name }}</td>
                                    <td>{{ $get_all_entry->date_of_entry }}</td>
                                    <td>{{ $get_all_entry->condition }}</td>
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
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Content -->

    </div>
    <!-- /Page Wrapper -->


</div>

<!-- /.container-fluid -->
@endsection