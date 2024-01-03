<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-6">
                <div class="card-title">Data Kategori</div>
            </div>
            <div class="col-6 text-end">
                @can('admin')
                    <div class="card-options">
                        <button class="btn btn-primary btn-add" style="margin-left: 2px">
                            <i class="bx bx-plus-medical"></i> Tambah
                        </button>
                    </div>
                @endcan
            </div>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-stripped" id="tableData">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kategori</th>
                    <th>Status</th>
                    @can('admin')
                        <th></th>
                    @endcan
                </tr>
            </thead>
            <tbody>
                @foreach ($kategori as $kategori)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $kategori->nama }}</td>
                        <td>{!! $kategori->status == true
                            ? '<span class="badge bg-success">Aktif</span>'
                            : '<span class="badge bg-danger">Tidak Aktif</span>' !!}</td>
                        @can('admin')
                            <td>
                                <button class="btn btn-success btn-edit" data-id="{{ $kategori->id }}">
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
