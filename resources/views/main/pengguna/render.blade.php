<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-6">
                <div class="card-title">Data Pengguna</div>
            </div>
            <div class="col-6 text-end">
                <div class="card-options">
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
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Username</th>
                    <th>Telp</th>
                    <th>Role</th>
                    {{-- <th>Nama PT</th>
                    <th>Alamat PT</th> --}}
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pengguna as $pengguna)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$pengguna->nama}}</td>
                    <td>{{$pengguna->email}}</td>
                    <td>{{$pengguna->username}}</td>
                    <td>{{$pengguna->telp}}</td>
                    <td>{{$pengguna->role}}</td>
                    {{-- <td>{{$pengguna->distributor->nama_pt}}</td>
                    <td>{{$pengguna->distributor->alamat_pt}}</td> --}}
                    <td>
                        <select name="status" class="form-control status" data-id="{{$pengguna->id}}">
                            <option value="1" {{$pengguna->is_active == true ? 'selected' : ''}}>Aktif</option>
                            <option value="0" {{$pengguna->is_active == false ? 'selected' : ''}}>Tidak Aktif</option>
                        </select>
                    </td>
                    {{-- <td>{!! $pengguna->is_active == true ? '<span class="badge bg-success">Aktif</span>' : '<span class="badge bg-danger">Tidak Aktif</span>' !!}</td> --}}
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
