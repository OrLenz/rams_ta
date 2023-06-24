@extends('layouts.admin')

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Data Pemesanan Barang</h1>
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

    @if (session()->has('error'))
    <div class="alert alert-danger">
        {{ session()->get('error') }}
    </div>
    @endif

    <div class="card card-outline card-info">
        <div class="card-header">
        </div>
        <div class="card-body">
            <form action="{{ route('good_loan.store') }}" id="po_form" method="POST">
                @csrf
                <input type="hidden" name="id" value="">
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="rooms_id">Ruangan Tujuan</label>
                        <select name="rooms_id" class="form-control">
                            <option value="">Pilih Ruangan Tujuan</option>
                            @foreach ($rooms as $room)
                            <option value="{{ $room->id }}">
                                {{ $room->room_name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="borrower_name">Nama Peminjam</label>
                        <input type="text" name="borrower_name" class="form-control" placeholder="Nama Peminjam"
                            value="{{ old('borrower_name') }}">
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="date_borrow">Tanggal Pinjam</label>
                        <input type="date" name="date_borrow" class="form-control" placeholder="Tanggal Pinjam"
                            value="{{ old('date_borrow') }}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-striped table-bordered" name="chart">
                            <colgroup>
                                <col width="5%">
                                <col width="60%">
                                <col width="10%">
                            </colgroup>
                            <thead>
                                <tr class="bg-navy disabled">
                                    <th class="px-1 py-1 text-center"></th>
                                    <th class="px-1 py-1 text-center">Nama Barang dan Asal Ruangan</th>
                                    <th class="px-1 py-1 text-center">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="line_items">
                                    <td class="align-middle p-1 text-center">
                                        <button class="row-remove btn btn-sm btn-danger py-0" type="button">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </td>
                                    <td class="align-middle p-1">
                                        <select name="goods_id[]" class="form-control">
                                            <option value="">Pilih Barang</option>
                                            @foreach ($good_entries as $good_entry)
                                            <option value="{{ $good_entry->id }}">
                                                {{ $good_entry->good->stuff }} - {{ $good_entry->room->room_name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="align-middle p-1">
                                        <input type="text" class="text-center w-100 border-0" name="qty[]">
                                    </td>
                                </tr>
                            </tbody>

                            <tfoot>
                                <tr>
                                    <th class="p-1 text-right" colspan="6"><span><button
                                                class="row-add btn btn btn-sm btn-flat btn-primary py-0 mx-1"
                                                type="button">Add Row</button></span></th>
                                </tr>
                            </tfoot>
                        </table>
                        <div class="row">
                            @if (Auth::user()->roles === 'ADMIN')
                            <div class="col-md-6">
                                <label for="status" class="control-label">Status</label>
                                <select name="status" id="status" class="form-control form-control-sm rounded-0">
                                    <option value="DIPINJAM">Dipinjam</option>
                                    <option value="DIKEMBALIKAN">Dikembalikan</option>
                                </select>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-footer">
            <button class="btn btn-flat btn-primary" form="po_form" type="submit">Save</button>
            <a class="btn btn-flat btn-default" href="{{ route('request.index') }}">Cancel</a>
        </div>
    </div>
</div>

@push('loan_script')
<script>
    function autoCalcSetup() {
    $('#po_form').jAutoCalc('destroy');
    $('#po_form .line_items').jAutoCalc({keyEventsFire: true, decimalPlaces: 2, emptyAsZero: true});
    $('#po_form').jAutoCalc({decimalPlaces: 2, keyEventsFire: true, emptyAsZero: true});
    }
    autoCalcSetup();

    $('button.row-remove').on("click", function(e) {
        e.preventDefault();

        var form = $(this).parents('form')
        $(this).parents('tr').remove();
        autoCalcSetup();
    });

    $('button.row-add').on("click", function(e) {
        e.preventDefault();

        var $table = $(this).parents('table');
        var $top = $table.find('.line_items').first();
        var $new = $top.clone(true);

        $new.jAutoCalc('destroy');
        $new.insertAfter($top);
        $new.find('input[type=text]').val('');
        autoCalcSetup();

    });
</script>
@endpush
<!-- /.container-fluid -->



{{--
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Data Peminjaman Barang</h1>
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
            <form action="{{ route('good_loan.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="warehouses_id">Nama Barang</label>
                    <select name="warehouses_id" class="form-control">
                        <option value="">Pilih Barang</option>
                        @foreach ($good_entries as $good_entry)
                        <option value="{{ $good_entry->id }}">
                            {{ $good_entry->good->stuff }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="room_source">Ruangan Asal</label>
                    <select name="room_source" class="form-control">
                        <option value="">Pilih Ruangan Asal</option>
                        @foreach ($good_entries as $good_entry)
                        <option value="{{ $good_entry->rooms_id }}">
                            {{ $good_entry->room->room_name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="rooms_id">Ruangan Tujuan</label>
                    <select name="rooms_id" class="form-control">
                        <option value="">Pilih Ruangan Tujuan</option>
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
                        value="{{ old('borrower_name') }}">
                </div>
                <div class="form-group">
                    <label for="loan_stock">Jumlah Barang</label>
                    <input type="text" name="loan_stock" class="form-control" placeholder="Jumlah Barang"
                        value="{{ old('loan_stock') }}">
                </div>
                <div class="form-group">
                    <label for="date_borrow">Tanggal Pinjam</label>
                    <input type="date" name="date_borrow" class="form-control" placeholder="Tanggal Pinjam"
                        value="{{ old('date_borrow') }}">
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" required class="form-control">
                        <option value="">
                            Status
                        </option>
                        <option value="DIPINJAM">Dipinjam</option>
                    </select>
                </div>
        </div>
        <button type="submit" class="btn btn-primary btn-block">
            Simpan
        </button>
        </form>
    </div>
</div> --}}

<!-- /.container-fluid -->
@endsection