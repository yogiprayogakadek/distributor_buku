<div class="col-12">
    <div class="modal fade" id="modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Validasi Pesanan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formUpdatePembayaran">
                    <div class="modal-body">
                        <div class="row mb-2">
                            <input type="hidden" name="id" id="id" class="id">
                            <label for="status" class="col-sm-3 col-form-label">Status</label>
                            <div class="col-md-9">
                                <select class="form-select status" name="status">
                                    <option value="Menunggu Konfirmasi">Menunggu Konfirmasi</option>
                                    <option value="Diterima">Diterima</option>
                                </select>
                                <div class="invalid-feedback error-status"></div>
                            </div>
                        </div>
                        <div class="row">
                            <label for="buktiPembayaran" class="col-sm-3 col-form-label">Bukti Pembayaran</label>
                            <div class="col-md-9 bukti-pembayaran"></div>
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
                        <th>Nama Distributor</th>
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
                            <td>{{ $transaksi->distributor->user->nama }}</td>
                            <td>{{ $transaksi->tanggal_transaksi }}</td>
                            <td>{{ json_decode($transaksi->buku->data_buku, true)['kode_buku'] }}</td>
                            <td class="total-pembayaran">{{ convertToRupiah($transaksi->total_pembayaran) }}</td>
                            <td class="status-pembayaran">{{ $transaksi->pembayaran->status_pembayaran }}</td>
                            <td>
                                @if ($transaksi->pembayaran->status_pembayaran == 'Menunggu Konfirmasi')
                                <button class="btn btn-primary btn-pembayaran" data-id="{{$transaksi->id}}" data-pembayaran="{{$transaksi->pembayaran->bukti_pembayaran != '' ? $transaksi->pembayaran->bukti_pembayaran : '-'}}">
                                    <i class="fas fa-money-bill"></i> Validasi
                                </button>
                                @elseif ($transaksi->pembayaran->status_pembayaran == 'Belum dibayar')
                                <i>Menunggu pembayaran</i>
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
