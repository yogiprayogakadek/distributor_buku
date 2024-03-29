@extends('templates.master')

@section('title', 'Pembayaran')
@section('sub-title', 'Data')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-6">
                        <div class="card-title">Data Pembayaran</div>
                    </div>
                    <div class="col-6 text-end">
                        <div class="card-options">
                            <button class="btn btn-success btn-print" style="margin-left: 2px">
                                <i class="fa fa-print"></i> Print
                            </button>
                        </div>
                    </div>
                </div>
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
                            <th>Status Pembayaran</th>
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
                            <td>
                                @if ($pembayaran->bukti_pembayaran != null)
                                <a href="{{asset($pembayaran->bukti_pembayaran)}}" target="_blank">
                                    <img src="{{asset($pembayaran->bukti_pembayaran)}}" height="70px">
                                </a>
                                @else
                                -
                                @endif
                            </td>
                            <td>{{convertToRupiah($pembayaran->transaksi->total)}}</td>
                            <td>{!! '<span class="badge bg-info">'.$pembayaran->status_pembayaran . '</span>' !!}</td>
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

    $("body").on("click", ".btn-print", function () {
        Swal.fire({
            title: "Cetak data pembayaran?",
            text: "Laporan akan dicetak",
            icon: "success",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, cetak!",
        }).then((result) => {
            if (result.value) {
                var mode = "iframe"; //popup
                var close = mode == "popup";
                var options = {
                    mode: mode,
                    popClose: close,
                    popTitle: "LaporanDataPembayaran",
                    // popOrient: "landscape",
                };
                $.ajax({
                    type: "GET",
                    url: "/distributor/pembayaran/print/",
                    dataType: "json",
                    success: function (response) {
                        document.title =
                            "PT. PANUDUH ATMA WARAS | Distribusi Buku - Print" +
                            new Date().toJSON().slice(0, 10).replace(/-/g, "/");
                        $(response.data)
                            .find("div.printableArea")
                            .printArea(options);
                    },
                });
            }
        });
    });
</script>
@endpush
