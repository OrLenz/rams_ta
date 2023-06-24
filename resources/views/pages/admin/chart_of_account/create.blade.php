@extends('layouts.admin')

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Akun</h1>
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
            <form action="{{ route('chart_of_account.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="account_code">Kode Akun</label>
                    <input type="text" name="account_code" class="form-control" placeholder="Kode Akun"
                        value="{{ old('account_code') }}">
                </div>
                <div class="form-group">
                    <label for="account_name">Nama Akun</label>
                    <input type="text" name="account_name" class="form-control" placeholder="Nama Akun"
                        value="{{ old('account_name') }}">
                </div>
                <button type="submit" class="btn btn-primary btn-block">
                    Simpan
                </button>
            </form>
        </div>
    </div>


</div>
<!-- /.container-fluid -->
@endsection