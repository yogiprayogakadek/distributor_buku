@extends('templates.master')

@section('title', 'Transaksi')
@section('sub-title', 'Data')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="modal fade" id="modalDetail" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                aria-labelledby="staticBackdropLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white bg-opacity-75">
                            <h5 class="modal-title" id="staticBackdropLabel">Update Data Buku</h5>
                            {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
                        </div>
                        <form id="formAdd">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-3">
                                        <p>Kode Buku</p>
                                    </div>
                                    <div class="col-9 text-kode-buku"></div>

                                    <div class="col-3">
                                        <p>Judul Buku</p>
                                    </div>
                                    <div class="col-9 text-judul-buku"></div>

                                    <div class="col-3">
                                        <p>Harga Buku</p>
                                    </div>
                                    <div class="col-9 text-harga-buku"></div>

                                    <div class="col-3">
                                        <p>Jumlah Buku</p>
                                    </div>
                                    <div class="col-9 text-kuantitas-buku"></div>

                                    <div class="col-3 div-pengembalian">
                                        <p>Jumlah Pengembalian</p>
                                    </div>
                                    <div class="col-9 mb-2 div-pengembalian">
                                        <input type="hidden" name="distribusi_id" id="distribusi_id"
                                            class="form-control distribusi-id">
                                        <input type="text" name="pengembalian" id="pengembalian"
                                            class="form-control pengembalian"
                                            placeholder="masukkan jika ada buku yang di kembalikan">
                                        <div class="invalid-feedback error-pengembalian"></div>
                                    </div>

                                    <div class="col-3 will-hidden">
                                        <p>Jumlah Buku Terjual</p>
                                    </div>
                                    <div class="col-9 text-terjual will-hidden"></div>

                                    <div class="col-3 label-dibayarkan will-hidden">
                                        <p>Jumlah yang Dibayarkan</p>
                                    </div>
                                    <div class="col-9 text-dibayarkan will-hidden"></div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Keluar</button>
                                <button type="button" class="btn btn-primary btn-save">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">
                            <div class="card-title">Data List Distribusi Buku</div>
                        </div>
                        {{-- <div class="col-6 text-end">
                            <div class="card-options">
                                <button class="btn btn-success btn-print" style="margin-left: 2px">
                                    <i class="fa fa-print"></i> Print
                                </button>
                            </div>
                        </div> --}}
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-stripped table-bordered" id="tableData">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal Distribusi</th>
                                <th>Kode Buku</th>
                                <th>Judul</th>
                                <th>Harga</th>
                                <th>Kuantitas</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $data)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $data['tanggal_distribusi'] }}</td>
                                    <td class="kode-buku">{{ $data['kode_buku'] }}</td>
                                    <td class="judul-buku">{{ $data['judul'] }}</td>
                                    <td class="harga-buku">{{ $data['harga'] }}</td>
                                    <td class="kuantitas-buku">{{ $data['kuantitas'] }} eksemplar</td>
                                    <td class="keterangan">{!! $data['terjual'] != null ? 'Buku yang di kembalikan <i><strong>' . $data['kembali'] . ' eksemplar</strong></i>, terjual <i><strong>' . $data['terjual'] . ' eksemplar</strong></i>.</p>' : '-' !!}</td>
                                    <td class="text-center">
                                        <button class="btn btn-primary btn-view" data-id="{{ $data['distribusi_id'] }}">
                                            <i class="fa fa-eye"></i>
                                        </button>
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

        // Numeric only control handler
        jQuery.fn.ForceNumericOnly =
            function() {
                return this.each(function() {
                    $(this).keydown(function(e) {
                        var key = e.charCode || e.keyCode || 0;
                        // allow backspace, tab, delete, enter, arrows, numbers and keypad numbers ONLY
                        // home, end, period, and numpad decimal
                        return (
                            key == 8 ||
                            key == 9 ||
                            key == 13 ||
                            key == 46 ||
                            key == 110 ||
                            key == 190 ||
                            (key >= 35 && key <= 40) ||
                            (key >= 48 && key <= 57) ||
                            (key >= 96 && key <= 105));
                    });
                });
            };

        $(document).ready(function() {
            localStorage.clear();
            $('body').on('click', '.btn-view', function() {
                $('#modalDetail').modal('show');

                // hidden
                $('.will-hidden').hide()
                $('#modalDetail .btn-save').prop('disabled', true);

                // get data
                let distribusi_id = $(this).data('id');

                let kodeBuku = $(this).closest('tr').find('td.kode-buku').text();
                let judulBuku = $(this).closest('tr').find('td.judul-buku').text();
                let hargaBuku = $(this).closest('tr').find('td.harga-buku').text();
                let kuantitasBuku = $(this).closest('tr').find('td.kuantitas-buku').text();
                let keterangan = $(this).closest('tr').find('td.keterangan').text();

                // set localStorage
                localStorage.setItem('kuantitas', kuantitasBuku);
                localStorage.setItem('harga', hargaBuku);
                localStorage.setItem('kodeBuku', kodeBuku);

                console.log(keterangan)
                if(keterangan != '-') {
                    $('#modalDetail .div-pengembalian').hide()
                    $('#modalDetail .btn-save').hide()
                } else {
                    $('#modalDetail .div-pengembalian').show()
                    $('#modalDetail .btn-save').show()
                }

                $('#modalDetail .distribusi-id').val(distribusi_id)
                $('#modalDetail .text-kode-buku').html('<p>: ' + kodeBuku + '</p>')
                $('#modalDetail .text-judul-buku').html('<p>: ' + judulBuku + '</p>')
                $('#modalDetail .text-harga-buku').html('<p>: ' + hargaBuku + '</p>')
                $('#modalDetail .text-kuantitas-buku').html('<p>: ' + kuantitasBuku + '</p>')
            });

            $('body').on('keyup', '.pengembalian', function() {
                $(this).ForceNumericOnly()

                $('.will-hidden').show()

                let pengembalian = $(this).val();
                let kuantitas = localStorage.getItem('kuantitas').split(' ')[0];
                var totalDibayarkan = (parseInt(kuantitas) -
                    pengembalian) * localStorage.getItem('harga').replace(/[^0-9]/gi, '');

                if (pengembalian == '') {
                    $('#modalDetail .text-dibayarkan').html('<p>: Rp. 0</p>')
                    $('#modalDetail .text-terjual').html('<p>: 0</p>')

                    $('#modalDetail .btn-save').prop('disabled', true);

                } else {
                    if (pengembalian > parseInt(kuantitas)) {
                        $(this).val(parseInt(kuantitas))
                        $('#modalDetail .text-dibayarkan').html('<p>: Rp. 0</p>')
                        $('#modalDetail .text-terjual').html('<p>: 0</p>')
                    } else {
                        $('#modalDetail .text-dibayarkan').html('<p>: ' + 'Rp. ' + totalDibayarkan
                            .toLocaleString('id-ID') + '</p>')
                        $('#modalDetail .text-terjual').html('<p>: ' + (kuantitas - pengembalian) + ' </p>')
                    }
                    $('#modalDetail .btn-save').prop('disabled', false);
                }

            });

            // on save button
            $("body").on("click", ".btn-save", function(e) {
                $.ajaxSetup({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    },
                });
                let form = $("#formAdd")[0];
                let data = new FormData(form);
                data.append('kode_buku', localStorage.getItem('kodeBuku'))
                $.ajax({
                    type: "POST",
                    url: "/distributor/distribusi/transaksi-store",
                    data: data,
                    processData: false,
                    contentType: false,
                    cache: false,
                    beforeSend: function() {
                        $(".btn-save").attr("disable", "disabled");
                        $(".btn-save").html('<i class="fa fa-spin fa-spinner"></i>');
                    },
                    complete: function() {
                        $(".btn-save").removeAttr("disable");
                        $(".btn-save").html("Simpan");
                    },
                    success: function(response) {
                        $("#formAdd").trigger("reset");
                        Swal.fire(response.title, response.message, response.status);

                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    },
                    error: function(error) {
                        console.log(error)
                    },
                });
            });
        });
    </script>
@endpush
