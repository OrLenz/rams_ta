<h1 class="display-4">Laporan Rangkuman Barang</h1>
<table class="table" border="1">
    <thead>
        <tr>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Ruangan</th>
            <th>Jumlah</th>
            <th>Tanggal Masuk</th>
            <th>Kondisi</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{ $get_all_entries->code_goods }}</td>
            <td>{{ $get_all_entries->good->stuff }}</td>
            <td>{{ $get_all_entries->room->room_name }}</td>
            <td>{{ $get_all_entries->stock }}</td>
            <td>{{ $get_all_entries->date_of_entry }}</td>
            <td>{{ $get_all_entries->condition }}</td>
        </tr>
    </tbody>
</table>