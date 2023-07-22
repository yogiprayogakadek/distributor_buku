@extends('templates.master')

@section('title', 'Transaksi')
@section('sub-title', 'Data')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="modal fade" id="modalTransaksi" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                aria-labelledby="staticBackdropLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white bg-opacity-75">
                            <h5 class="modal-title" id="staticBackdropLabel">Detail Transaksi</h5>
                            {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
                        </div>
                        <div class="modal-body">
                            <table class="table table-stripped" id="tableDetail">
                                <thead class="text-center">
                                    <tr>
                                        <th>No</th>
                                        <th>Kategori</th>
                                        <th>Nama Buku</th>
                                        <th>Penerbit</th>
                                        <th>Penulis</th>
                                        <th>Harga</th>
                                        <th>Kuantitas</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                                <tfoot>
                                    <tr style="font-weight: bold; font-style: italic">
                                        <td colspan="7" class="text-end">Grand Total</td>
                                        <td class="grand-total text-end"></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Keluar</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">
                            <div class="card-title">Data Transaksi</div>
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
                                <th></th>
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
                                    <td>
                                        <button class="btn btn-rounded btn-primary btn-detail btn-sm"
                                            data-id="{{ $transaksi->id }}">
                                            <i class="bx bx-plus"></i>
                                        </button>
                                    </td>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $transaksi->kode_pesanan }}</td>
                                    <td>{{ $transaksi->tanggal_pesanan }}</td>
                                    <td>{{ $transaksi->status_pesanan }}</td>
                                    <td>{{ convertToRupiah($transaksi->total) }}</td>
                                    <td>{{ $transaksi->keterangan ?? '-' }}</td>
                                    <td>{{ $transaksi->validator->nama ?? '-' }}</td>
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

        $(document).ready(function() {
            $("body").on("click", ".btn-detail", function() {
                let id = $(this).data("id");
                $("#modalTransaksi").modal("show");

                $("#tableDetail tbody").empty();
                $(".grand-total").empty();
                $.get("/distributor/transaksi/detail/" + id, function(data) {
                    let grandTotal = 0;
                    $.each(data, function(index, value) {
                        let tr_list =
                            "<tr class='text-center'>" +
                            "<td>" +
                            (index + 1) +
                            "</td>" +
                            "<td>" +
                            value.nama_kategori +
                            "</td>" +
                            "<td>" +
                            value.judul +
                            "</td>" +
                            "<td>" +
                            value.penerbit +
                            "</td>" +
                            "<td>" +
                            value.penulis +
                            "</td>" +
                            "<td class='text-end'>" +
                            convertToRupiah(value.harga) +
                            "</td>" +
                            "<td>" +
                            value.kuantitas +
                            "</td>" +
                            "<td class='text-end'>" +
                            convertToRupiah(value.kuantitas * value.harga) +
                            "</td>" +
                            "</tr>";

                        grandTotal += value.kuantitas * value.harga;

                        $("#tableDetail tbody").append(tr_list);
                    });
                    $(".grand-total").text(convertToRupiah(grandTotal));
                });
            });
        });

        $("body").on("click", ".btn-print", function() {
            Swal.fire({
                title: "Cetak data transaksi?",
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
                        popTitle: "LaporanDataTransaksi",
                        // popOrient: "landscape",
                    };
                    $.ajax({
                        type: "GET",
                        url: "/distributor/transaksi/print/",
                        dataType: "json",
                        success: function(response) {
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
