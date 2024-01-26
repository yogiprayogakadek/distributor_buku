<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-6">
                <div class="card-title">Pilih kode buku</div>
            </div>
            <div class="col-6 text-end">
                <div class="card-options">
                    <button class="btn btn-primary btn-data" style="margin-left: 2px">
                        <i class="bx bx-arrow-back"></i> Data
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">
        <form id="formAdd">
            <div class="row">

                {{-- @foreach ($buku as $buku)
                <div class="col-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="kode_buku[]" value="{{json_decode($buku->data_buku, true)['kode_buku']}}" id="kodeBuku">
                        <label class="form-check-label" for="flexCheckDefault">
                            {{json_decode($buku->data_buku, true)['kode_buku']}}
                        </label>
                    </div>
                </div>
                @endforeach --}}

                <div class="col-12">
                    <table class="table table-stripped table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center"><input type="checkbox" class="check-all"></th>
                                <th>Kode Buku</th>
                                <th>Judul Buku</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($buku as $buku)
                                <tr>
                                    <td class="text-center"><input class="form-check-input" type="checkbox"
                                            name="kode_buku[]"
                                            value="{{ json_decode($buku->data_buku, true)['kode_buku'] }}"
                                            id="kodeBuku"></td>
                                    <td>{{ json_decode($buku->data_buku, true)['kode_buku'] }}</td>
                                    <td>{{ json_decode($buku->data_buku, true)['judul'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    </div>
    <div class="card-footer text-end">
        <button class="btn btn-info btn-save pull-right" type="button">
            <i class="fa fa-save"></i> Simpan
        </button>
    </div>
</div>

<script>
    $('.check-all').on('click', function() {
        if (this.checked) {
            $('.form-check-input').each(function() {
                this.checked = true;
            });
        } else {
            $('.form-check-input').each(function() {
                this.checked = false;
            });
        }
    });

    $('.form-check-input').on('click', function() {
        if ($('.form-check-input:checked').length == $('.form-check-input').length) {
            $('.check-all').prop('checked', true);
        } else {
            $('.check-all').prop('checked', false);
        }
    });
</script>
