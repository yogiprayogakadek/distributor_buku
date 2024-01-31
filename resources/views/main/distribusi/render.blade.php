<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-6">
                <div class="card-title">Data Distribusi Buku</div>
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
                    <th>Tanggal Distribusi</th>
                    {{-- @can('admin') --}}
                    <th>Aksi</th>
                    {{-- @endcan --}}
                </tr>
            </thead>
            <tbody>
                @foreach ($distribusi as $distribusi)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{date_format(date_create($distribusi->tanggal_distribusi), 'd-m-Y')}}</td>
                    {{-- @can('admin') --}}
                    <td>
                        <button class="btn btn-primary btn-detail" data-id="{{$distribusi->id}}" data-date="{{$distribusi->tanggal_distribusi}}">
                            <i class="fa fa-eye"></i>
                        </button>
                    </td>
                    {{-- @endcan --}}
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
