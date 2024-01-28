<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-6">
                        <div class="card-title">Data Distribusi Buku</div>
                    </div>
                    <div class="col-6 text-end">
                        @can('admin')
                        <div class="card-options">
                            <button class="btn btn-primary btn-data" style="margin-left: 2px">
                                <i class="bx bx-arrow-back"></i> Data
                            </button>
                        </div>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 data-distributor">
        <div class="card">
            <div class="card-body">
                <table class="table table-stripped" id="tableData">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <td>Aksi</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($distributor as $distributor)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$distributor->nama_pt}}</td>
                            <td>
                                <button class="btn btn-detail-distribusi btn-info" data-distributor-id="{{$distributor->id}}">
                                    <i class="fa fa-eye"></i> Lihat buku
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-6 data-list-buku" hidden></div>
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

    $('body').on('click', '.btn-detail-distribusi', function() {
        $('.data-distributor').removeClass('col-12').addClass('col-6')
        $('.data-list-buku').prop('hidden', false)
        $('#tableData').removeAttr('style')

        let distributorId = $(this).data('distributor-id')

        $.ajax({
            type: "get",
            url: "/distribusi/list-buku/" + localStorage.getItem('date') + 'id' + distributorId,
            dataType: "json",
            success: function (response) {
                $(".data-list-buku").html(response.data);
            },
            error: function (error) {
                console.log("Error", error);
            },
        });
    });
</script>
