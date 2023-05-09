@extends('templates.master')

@section('title', 'Transaksi')
@section('sub-title', 'Data')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Data Transaksi</div>
            </div>
            <div class="card-body">
                <table class="table table-stripped" id="tableData">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Pesanan</th>
                            <th>Tanggal Pesanan</th>
                            <th>Status Pesanaan</th>
                            <th>Total</th>
                            <th>Keterangan</th>
                            <th>Validator</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transaksi as $transaksi)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$transaksi->kode_pesanan}}</td>
                            <td>{{$transaksi->tanggal_pesanan}}</td>
                            <td>{{$transaksi->status_pesanan}}</td>
                            <td>{{convertToRupiah($transaksi->total)}}</td>
                            <td>{{$transaksi->keterangan ?? '-'}}</td>
                            <td>{{$transaksi->validator->nama ?? '-'}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    $('#tableData').DataTable({
        language: {
            paginate: {
                previous: "<i class='fa fa-arrow-left'>",
                next: "<i class='fa fa-arrow-right'>"
            },
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
            lengthMenu: "Menampilkan _MENU_ data",
            search: "Cari:",
            emptyTable: "Tidak ada data tersedia",
            zeroRecords: "Tidak ada data yang cocok",
            loadingRecords: "Memuat data...",
            processing: "Memproses...",
            infoFiltered: "(difilter dari _MAX_ total data)"
        },
        lengthMenu: [
            [5, 10, 15, 20, -1],
            [5, 10, 15, 20, "All"]
        ],
    });
</script>
@endpush