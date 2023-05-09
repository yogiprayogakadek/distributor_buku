@extends('templates.master')

@section('title', 'Pembayaran')
@section('sub-title', 'Data')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Data Pembayaran</div>
            </div>
            <div class="card-body">
                <table class="table table-stripped" id="tableData">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Pesanan</th>
                            <th>Tanggal Pembayaran</th>
                            <th>Jenis Pembayaran</th>
                            <th>Bukti Pembayaran</th>
                            <th>Total Pembayaran</th>
                            <th>Validator</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pembayaran as $pembayaran)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$pembayaran->transaksi->kode_pesanan}}</td>
                            <td>{{$pembayaran->tanggal_pembayaran}}</td>
                            <td>{{$pembayaran->jenis_pembayaran}}</td>
                            <td><img src="{{asset($pembayaran->bukti_pembayaran)}}" height="70px"></td>
                            <td>{{convertToRupiah($pembayaran->transaksi->total)}}</td>
                            <td>{{$pembayaran->validator->nama ?? '-'}}</td>
                            <td>{{$pembayaran->keterangan ?? '-'}}</td>
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
