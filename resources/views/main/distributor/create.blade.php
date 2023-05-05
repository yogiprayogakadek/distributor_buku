<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-6">
                <div class="card-title">Tambah Kategori</div>
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
            <div class="row mb-4">
                <label for="nama" class="col-sm-1 col-form-label">Nama Kategori</label>
                <div class="col-sm-11">
                    <input type="text" class="form-control nama" id="nama" name="nama" placeholder="masukkan nama kategori">
                    <div class="invalid-feedback error-nama"></div>
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