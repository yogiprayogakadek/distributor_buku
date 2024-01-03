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

    <div class="modal fade" id="modalTransaksi" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" style="display: none;" aria-hidden="true">
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
                        <td>{!! '<span class="badge bg-info">'.$transaksi->status_pesanan . '</span>' !!}</td>
                        <td>{{convertToRupiah($transaksi->total)}}</td>
                        <td>{{$transaksi->keterangan ?? '-'}}</td>
                        <td>{{$transaksi->validator->nama ?? '-'}}</td>
                        <td>
                            <button class="btn btn-success btn-edit" data-pembayaran="{{$transaksi->pembayaran->status_pembayaran}}" data-id="{{$transaksi->id}}" data-status="{{$transaksi->status_pesanan}}" data-keterangan="{{$transaksi->keterangan}}">
                                <i class="bx bx-pencil"></i>
                            </button>
                            <button class="btn btn-rounded btn-primary btn-detail btn-sm" data-id="{{$transaksi->id}}">
                                <i class="bx bx-plus"></i>
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
                previous: "<i class='fa fa-arrow-left'>"
                , next: "<i class='fa fa-arrow-right'>"
            }
            , info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data"
            , infoEmpty: "Menampilkan 0 sampai 0 dari 0 data"
            , lengthMenu: "Menampilkan _MENU_ data"
            , search: "Cari:"
            , emptyTable: "Tidak ada data tersedia"
            , zeroRecords: "Tidak ada data yang cocok"
            , loadingRecords: "Memuat data..."
            , processing: "Memproses..."
            , infoFiltered: "(difilter dari _MAX_ total data)"
        }
        , lengthMenu: [
            [5, 10, 15, 20, -1]
            , [5, 10, 15, 20, "All"]
        ]
    , });

</script>
