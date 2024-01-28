@extends('templates.master')

@section('title', 'Transaksi')
@section('sub-title', 'Data')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="modal fade" id="modalDistribusi" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                aria-labelledby="staticBackdropLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white bg-opacity-75">
                            <h5 class="modal-title" id="staticBackdropLabel">Detail Distribusi Buku</h5>
                            {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
                        </div>
                        <div class="modal-body">
                            <table class="table table-stripped table-bordered" id="tableDetail">
                                <thead class="text-center">
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Buku</th>
                                        <th>Nama Buku</th>
                                        <th>Penerbit</th>
                                        <th>Penulis</th>
                                        <th>Harga</th>
                                        <th>Kuantitas</th>
                                        <th>Validasi</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>

                            <!-- Pagination controls -->
                            <nav aria-label="Page navigation example">
                                <ul class="pagination justify-content-end" id="pagination"></ul>
                            </nav>
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
                            <div class="card-title">Data Distribusi Buku</div>
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
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($distribusi as $distribusi)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $distribusi->tanggal_distribusi }}</td>
                                    <td class="text-center">
                                        <button class="btn btn-primary btn-view" data-id="{{ $distribusi->id }}">
                                            <i class="fa fa-eye"></i> Validasi Buku
                                        </button>
                                        {{-- <button class="btn btn-primary btn-view-book" data-id="{{ $distribusi->id }}">
                                            <i class="fa fa-book"></i> List Buku
                                        </button> --}}
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

        const itemsPerPage = 10;

        function getDistribusiDetail(data) {
            // Initialize pagination variables
            let currentPage = 1;
            let totalPages = Math.ceil(data.length / itemsPerPage);

            // Function to update the table content based on the current page
            function updateTable(pageNumber) {
                $('#tableDetail tbody').empty();

                // Calculate the start and end indices for the current page
                let startIndex = (pageNumber - 1) * itemsPerPage;
                let endIndex = Math.min(startIndex + itemsPerPage, data
                    .length);

                // Populate the table with the current page data
                for (let i = startIndex; i < endIndex; i++) {
                    let validate =
                        "<button class='btn btn-rounded btn-success btn-validate' style='margin-right: 10px;' data-id=" +
                        data[i].distribusi_id + " data-kode-buku=" +
                        data[i].kode_buku +
                        " data-status=1><span class='fa fa-check'></span></button>";
                    validate +=
                        "<button class='btn btn-rounded btn-danger btn-validate' data-id=" +
                        data[i].distribusi_id + " data-kode-buku=" +
                        data[i].kode_buku +
                        " data-status=0><i class='fa fa-times'></button>";
                    let tr_list = "<tr>" +
                        '<td>' + (i + 1) + '</td>' +
                        '<td>' + data[i].kode_buku + '</td>' +
                        '<td>' + data[i].judul + '</td>' +
                        '<td>' + data[i].penerbit + '</td>' +
                        '<td>' + data[i].penulis + '</td>' +
                        '<td class="text-end">' + data[i].harga +
                        '</td>' +
                        '<td>' + data[i].kuantitas + " eksemplar" +
                        '</td>' +
                        '<td class="text-center">' + (data[i].updated_at != null ? '<i>updated</i>' : validate) +
                        '</td>' +
                        '<td class="text-center">' + (data[i].updated_at == null ? 'Belum di terima' : (data[i].status == true ? 'Diterima (' + data[i].updated_at +')' : 'Dibatalkan') ) + '</td>' +
                        '</tr>';

                    $('#tableDetail tbody').append(tr_list);
                }
            }

            // Function to update pagination controls
            function updatePagination() {
                $('#pagination').empty();

                for (let i = 1; i <= totalPages; i++) {
                    let liClass = (i === currentPage) ?
                        'page-item active' : 'page-item';
                    let li = '<li class="' + liClass +
                        '"><a class="page-link" href="#">' +
                        i + '</a></li>';
                    $('#pagination').append(li);
                }
            }

            // Initial table and pagination update
            updateTable(currentPage);
            updatePagination();

            // Handle pagination click events
            $('#pagination').on('click', 'a', function(event) {
                event.preventDefault();
                currentPage = parseInt($(this).text());

                updateTable(currentPage);
                updatePagination();
            });
        }

        $(document).ready(function() {
            localStorage.clear();
            $('body').on('click', '.btn-view', function() {
                $('#modalDistribusi').modal('show');
                // get data
                let distribusi_id = $(this).data('id');

                // set session storage
                localStorage.setItem("distribusiId", distribusi_id);

                $.get("/distributor/distribusi/find/" + distribusi_id, function(data) {
                    getDistribusiDetail(data);
                });
            })

            $('body').on('click', '.btn-validate', function() {
                let distribusi_id = $(this).data('id')
                let kode_buku = $(this).data('kode-buku')
                let status = $(this).data('status')
                $(this).closest('tr').find('.btn-validate').remove();

                $.ajaxSetup({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    },
                });
                $.ajax({
                    type: "POST",
                    url: "/distributor/distribusi/validasi",
                    data: {
                        'distribusi_id': distribusi_id,
                        'kode_buku': kode_buku,
                        'status': status,
                    },
                    json: "json",
                    success: function(response) {
                        // get session id
                        let distribusi_id = localStorage.getItem('distribusiId');

                        // Fetch data from the server
                        $.get("/distributor/distribusi/find/" + distribusi_id, function(data) {
                            getDistribusiDetail(data);
                        });
                    }
                });
            })
        });
    </script>
@endpush
