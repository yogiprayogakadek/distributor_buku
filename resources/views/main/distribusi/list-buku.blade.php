<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-6">
                <div class="card-title">List Buku - {{$distributor}}</div>
            </div>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-stripped" id="tableListBuku">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Buku</th>
                    <th>Judul Buku</th>
                    <th>Penerbit</th>
                    <th>Penulis</th>
                    <th>Harga</th>
                    <th>Kuantitas</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($distribusi as $distribusi)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$distribusi['kode_buku']}}</td>
                    <td>{{$distribusi['judul']}}</td>
                    <td>{{$distribusi['penerbit']}}</td>
                    <td>{{$distribusi['penulis']}}</td>
                    <td>{{$distribusi['harga']}}</td>
                    <td>{{$distribusi['kuantitas']}}</td>
                    {{-- {{date_format(date_create($distribusi['updated_at']), 'd-m-Y H:i:s')}} --}}
                    <td>{{ ($distribusi['updated_at'] == null ? 'Belum di terima' : ($distribusi['status'] == true ? 'Diterima (' . date_format(date_create($distribusi['updated_at']), 'd-m-Y H:i:s') .')' : 'Dibatalkan') ) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    $('#tableListBuku').DataTable({
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
