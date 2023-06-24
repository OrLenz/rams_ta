@extends('layouts.admin')

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Data Barang Rusak</h1>
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
            <form action="{{ route('damaged_good.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="warehouses_id">Nama Barang dan Ruangan Asal</label>
                    <select name="warehouses_id" class="form-control">
                        <option value="">Pilih Barang</option>
                        @foreach ($good_entries as $good_entry)
                        <option value="{{ $good_entry->id }}">
                            {{ $good_entry->good->stuff }} - {{ $good_entry->room->room_name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="name_pic">Nama Penanggungjawab</label>
                    <input type="text" name="name_pic" class="form-control" placeholder="Nama Penanggungjawab"
                        value="{{ old('name_pic') }}">
                </div>
                <div class="form-group">
                    <label for="quantity">Jumlah Barang</label>
                    <input type="text" name="quantity" class="form-control" placeholder="Jumlah Barang"
                        value="{{ old('quantity') }}">
                </div>
                <div class="form-group">
                    <label for="date_damaged">Tanggal Rusak</label>
                    <input type="date" name="date_damaged" class="form-control" placeholder="Tanggal Rusak"
                        value="{{ old('date_damaged') }}">
                </div>
                <div class="form-group">
                    <label for="condition">Kondisi</label>
                    <select name="condition" required class="form-control">
                        <option value="">
                            Kondisi
                        </option>
                        <option value="RUSAK">Rusak</option>
                    </select>
                </div>
        </div>
        <button type="submit" class="btn btn-primary btn-block">
            Simpan
        </button>
        </form>
    </div>
</div>

<!-- /.container-fluid -->
@endsection