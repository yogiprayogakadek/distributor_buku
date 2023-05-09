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
                                    <option value="Menunggu Konfirmasi" disabled>Menunggu Konfirmasi</option>
                                    <option value="Dikemas">Dikemas</option>
                                    <option value="Dikirim">Dikirim</option>
                                    <option value="Diterima">Diterima</option>
                                    <option value="Dibatalkan">Dibatalkan</option>
                                </select>
                                <div class="invalid-feedback error-status"></div>
                            </div>
                        </div>

                        <div class="row mb-4 group-keterangan">
                            {{-- <label for="keterangan" class="col-sm-2 col-form-label">Keterangan</label> --}}
                        </div>
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
            <div class="card-title">Data Transaksi</div>
        </div>
        <div class="card-body">
            <table class="table table-stripped" id="tableData">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Pesanan</th>
                        <th>Distributor</th>
                        <th>Tanggal Pesanan</th>
                        <th>Status Pesanaan</th>
                        <th>Total</th>
                        <th>Keterangan</th>
                        <th>Validator</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transaksi as $transaksi)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$transaksi->kode_pesanan}}</td>
                        <td>{{$transaksi->distributor->user->nama}}</td>
                        <td>{{$transaksi->tanggal_pesanan}}</td>
                        <td>{{$transaksi->status_pesanan}}</td>
                        <td>{{convertToRupiah($transaksi->total)}}</td>
                        <td>{{$transaksi->keterangan ?? '-'}}</td>
                        <td>{{$transaksi->validator->nama ?? '-'}}</td>
                        <td>
                            <button class="btn btn-success btn-edit" data-id="{{$transaksi->id}}" data-status="{{$transaksi->status_pesanan}}" data-keterangan="{{$transaksi->keterangan}}">
                                <i class="bx bx-pencil"></i>
                            </button>
                        </td>
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