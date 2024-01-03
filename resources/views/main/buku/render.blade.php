<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-6">
                <div class="card-title">Data Buku</div>
            </div>
            <div class="col-6 text-end">
                <div class="card-options">
                    @can('admin')
                    <button class="btn btn-primary btn-add" style="margin-left: 2px">
                        <i class="bx bx-plus-medical"></i> Tambah
                    </button>
                    @endcan
                    <button class="btn btn-success btn-print ml-2" style="margin-left: 2px">
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
                    <th>Kategori</th>
                    <th>Kode Buku</th>
                    <th>Judul</th>
                    <th>Penerbit</th>
                    <th>Penulis</th>
                    <th>Tahun Terbit</th>
                    <th>Harga</th>
                    <th>Foto</th>
                    <th>Stok Buku</th>
                    <th>Status</th>
                    @can('admin')
                    <th></th>
                    @endcan
                </tr>
            </thead>
            <tbody>
                @foreach ($buku as $buku)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$buku->kategori->nama}}</td>
                    <td>{{json_decode($buku->data_buku, true)['kode_buku']}}</td>
                    <td>{{json_decode($buku->data_buku, true)['judul']}}</td>
                    <td>{{json_decode($buku->data_buku, true)['penerbit']}}</td>
                    <td>{{json_decode($buku->data_buku, true)['penulis']}}</td>
                    <td>{{json_decode($buku->data_buku, true)['tahun_terbit']}}</td>
                    <td>{{convertToRupiah(json_decode($buku->data_buku, true)['harga'])}}</td>
                    <td><img src="{{json_decode($buku->data_buku, true)['foto']}}" width="70px"></td>
                    <td>{{$buku->stok_buku}}</td>
                    <td>{!! $buku->status == true ? '<span class="badge bg-success">Aktif</span>' : '<span class="badge bg-danger">Tidak Aktif</span>' !!}</td>
                    @can('admin')
                    <td>
                        <button class="btn btn-success btn-edit" data-id="{{$buku->id}}">
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
