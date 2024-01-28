@extends('templates.master')

@section('title', 'Transaksi')
@section('sub-title', 'Data')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="modal fade" id="modalPembayaran" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                aria-labelledby="staticBackdropLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white bg-opacity-75">
                            <h5 class="modal-title" id="staticBackdropLabel">Pembayaran Transaksi</h5>
                            {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
                        </div>
                        <form id="formPembayaran">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-3">
                                        <p>Total Pembayaran</p>
                                    </div>
                                    <div class="col-9 text-total-pembayaran"></div>

                                    <div class="col-3">
                                        <p>Metode Pembayaran</p>
                                    </div>
                                    <div class="col-9 mb-2">
                                        <select class="form-select pembayaran" name="jenis_pembayaran" id="jenis_pembayaran">
                                            {{-- <option value="Tunai">Tunai</option> --}}
                                            <option value="Transfer">Transfer</option>
                                        </select>
                                        <div class="invalid-feedback error-pembayaran"></div>
                                    </div>

                                    <div class="col-3">
                                        <p>Bukti Pembayaran</p>
                                    </div>
                                    <div class="col-9 mb-2">
                                        <input type="hidden" name="transaksi_id" class="form-control transaksi_id">
                                        <input type="file" name="bukti_pembayaran" id="bukti_pembayaran" class="form-control bukti-pembayaran">
                                        <div class="invalid-feedback error-bukti-pembayaran"></div>
                                    </div>

                                    <div class="col-3 pembayaran-sebelum">
                                        <p>Bukti Pembayaran Sebelumnya</p>
                                    </div>
                                    <div class="col-9 pembayaran-sebelum image-sebelum"></div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Keluar</button>
                                <button type="button" class="btn btn-primary btn-proses-pembayaran">Proses</button>
                            </div>
                        </form>
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
                                <th>No</th>
                                <th>Kode Transaksi</th>
                                <th>Tanggal Transaksi</th>
                                <th>Kode Buku</th>
                                <th>Total Pembayaran</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transaksi as $transaksi)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $transaksi->kode_transaksi }}</td>
                                    <td>{{ $transaksi->tanggal_transaksi }}</td>
                                    <td>{{ json_decode($transaksi->buku->data_buku, true)['kode_buku'] }}</td>
                                    <td class="total-pembayaran">{{ convertToRupiah($transaksi->total_pembayaran) }}</td>
                                    <td>{{ $transaksi->pembayaran->status_pembayaran }}</td>
                                    <td>
                                        @if ($transaksi->pembayaran->status_pembayaran != 'Diterima')
                                        <button class="btn btn-primary btn-pembayaran" data-id="{{$transaksi->id}}" data-pembayaran="{{$transaksi->pembayaran->bukti_pembayaran != '' ? $transaksi->pembayaran->bukti_pembayaran : '-'}}">
                                            <i class="fas fa-money-bill"></i> Pembayaran
                                        </button>
                                        @else
                                        <i>Pembayaran berhasil</i>
                                        @endif
                                    </td>
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
        function assets(url) {
            var url = '{{ url("") }}/' + url;
            return url;
        }
        $(document).ready(function() {
            $('body').on('click', '.btn-pembayaran', function() {
                $('#modalPembayaran').modal('show')

                let totalPembayaran = $(this).closest('tr').find('td.total-pembayaran').text();
                let imageSebelumnya = $(this).data('pembayaran');

                if(imageSebelumnya != '-') {
                    $('#modalPembayaran .image-sebelum').html('<a href='+ assets(imageSebelumnya) +' style="text-decoration: none; font-style: italic" target="_blank">Lihat bukti pembayaran</a>')
                } else {
                    $('#modalPembayaran .pembayaran-sebelum').prop('hidden', true)
                }

                $('#modalPembayaran .transaksi_id').val($(this).data('id'))
                $('#modalPembayaran .text-total-pembayaran').html('<p>' + totalPembayaran + '</p>');
                $('#modalPembayaran .btn-proses-pembayaran').prop('disabled', true)
            })

            $('body').on('change', '.bukti-pembayaran', function() {
                var fileInput = $(this)[0];
                var file = fileInput.files[0];

                if (file) {
                    var fileType = file.type;
                    var validImageTypes = ['image/jpeg', 'image/png', 'image/gif'];

                    if (validImageTypes.includes(fileType)) {
                        // Image is valid
                        $('.bukti-pembayaran').removeClass('is-invalid')
                        $('.error-bukti-pembayaran').text('');

                        $('.btn-proses-pembayaran').prop('disabled', false)
                    } else {
                        // Invalid image file type
                        $('.bukti-pembayaran').addClass('is-invalid')
                        $('.error-bukti-pembayaran').text('Hanya tipe file JPEG, PNG, and GIF yang dapat di unggah');
                        // $('.error-bukti').text('Invalid image file type. Only JPEG, PNG, and GIF are allowed.');
                        // Clear the file input
                        $(this).val('');
                        $('.btn-proses-pembayaran').prop('disabled', true)
                    }
                } else {
                    // No file selected
                    $('.bukti-pembayaran').addClass('is-invalid')
                    $('.error-bukti-pembayaran').text('No file selected.');
                    $('.btn-proses-pembayaran').prop('disabled', true)
                }
            });

            $('body').on('click', '.btn-proses-pembayaran', function(e) {
                let error = $('.is-invalid').length

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                let form = $('#formPembayaran')[0]
                let data = new FormData(form)
                $.ajax({
                    type: 'POST',
                    url: '/distributor/transaksi/pembayaran',
                    data: data,
                    processData: false,
                    contentType: false,
                    cache: false,
                    beforeSend: function() {
                        $('.btn-proses-pembayaran').attr('disable', 'disabled')
                        $('.btn-proses-pembayaran').html('<i class="fa fa-spin fa-spinner"></i>')
                    },
                    complete: function() {
                        $('.btn-proses-pembayaran').removeAttr('disable')
                        $('.btn-proses-pembayaran').html('Simpan')
                    },
                    success: function(response) {
                        $('#modalPembayaran').modal('hide');
                        Swal.fire(
                            response.title,
                            response.message,
                            response.status
                        );
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    },
                    error: function(error) {
                        //
                    }
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
        });

    </script>
@endpush
