<div class="col-12">
    <div class="modal fade" id="modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Validasi Pesanan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formPesanan">
                    <div class="modal-body">
                        <div class="row mb-4">
                            <input type="hidden" name="id" id="id" class="id">
                            <label for="status" class="col-sm-2 col-form-label">Status</label>
                            <div class="col-md-10">
                                <select class="form-select status" name="status">
                                    <option value="Menunggu Konfirmasi">Menunggu Konfirmasi</option>
                                    <option value="Diterima">Diterima</option>
                                    <option value="Ditolak">Ditolak</option>
                                </select>
                                <div class="invalid-feedback error-status"></div>
                            </div>
                        </div>

                        <div class="row mb-4 group-keterangan"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
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
                        @can('admin')
                        <th></th>
                        @endcan
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
                        @can('admin')
                        <td>
                            <button class="btn btn-success btn-edit" data-id="{{$pembayaran->id}}" data-status="{{$pembayaran->status_pembayaran}}" data-keterangan="{{$pembayaran->keterangan}}">
                                <i class="bx bx-pencil"></i>
                            </button>
                        </td>
                        @endcan
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

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
