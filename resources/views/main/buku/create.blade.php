<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-6">
                <div class="card-title">Tambah Buku</div>
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
                <label for="kategori" class="col-sm-1 col-form-label">Kategori</label>
                <div class="col-md-11">
                    <select class="form-select kategori" name="kategori" id="kategori">
                        @foreach ($kategori as $key => $value)
                        <option value="{{$key}}">{{$value}}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback error-kategori"></div>
                </div>
            </div>

            <div class="row mb-4">
                <label for="kode-buku" class="col-sm-1 col-form-label">Kode Buku</label>
                <div class="col-sm-11">
                    <input type="text" class="form-control kode_buku" id="kode-buku" name="kode_buku" placeholder="masukkan kode buku">
                    <div class="invalid-feedback error-kode_buku"></div>
                </div>
            </div>

            <div class="row mb-4">
                <label for="judul" class="col-sm-1 col-form-label">Judul</label>
                <div class="col-sm-11">
                    <input type="text" class="form-control judul" id="judul" name="judul" placeholder="masukkan judul buku">
                    <div class="invalid-feedback error-judul"></div>
                </div>
            </div>

            <div class="row mb-4">
                <label for="tahun-terbit" class="col-sm-1 col-form-label">Tahun Terbit</label>
                <div class="col-sm-11">
                    <input type="text" class="form-control tahun_terbit" id="tahun-terbit" name="tahun_terbit" placeholder="masukkan tahun terbit">
                    <div class="invalid-feedback error-tahun_terbit"></div>
                </div>
            </div>

            <div class="row mb-4">
                <label for="penerbit" class="col-sm-1 col-form-label">Penerbit</label>
                <div class="col-sm-11">
                    <input type="text" class="form-control penerbit" id="penerbit" name="penerbit" placeholder="masukkan penerbit buku">
                    <div class="invalid-feedback error-penerbit"></div>
                </div>
            </div>

            <div class="row mb-4">
                <label for="penulis" class="col-sm-1 col-form-label">Penulis</label>
                <div class="col-sm-11">
                    <input type="text" class="form-control penulis" id="penulis" name="penulis" placeholder="masukkan penulis buku">
                    <div class="invalid-feedback error-penulis"></div>
                </div>
            </div>

            <div class="row mb-4">
                <label for="harga" class="col-sm-1 col-form-label">Harga</label>
                <div class="col-sm-11">
                    <input type="text" class="form-control harga" id="harga" name="harga" placeholder="masukkan harga buku">
                    <div class="invalid-feedback error-harga"></div>
                </div>
            </div>

            <div class="row mb-4">
                <label for="deskripsi" class="col-sm-1 col-form-label">Deskripsi</label>
                <div class="col-sm-11">
                    <textarea class="form-control deskripsi" id="deskripsi" name="deskripsi" placeholder="masukkan deskripsi buku"></textarea>
                    <div class="invalid-feedback error-deskripsi"></div>
                </div>
            </div>

            <div class="row mb-4">
                <label for="foto" class="col-sm-1 col-form-label">Foto</label>
                <div class="col-sm-11">
                    <input type="file" class="form-control foto" id="foto" name="foto" placeholder="masukkan foto buku">
                    <div class="invalid-feedback error-foto"></div>
                </div>
            </div>

            <div class="row mb-4">
                <label for="stok-buku" class="col-sm-1 col-form-label">Stok Buku</label>
                <div class="col-sm-11">
                    <input type="text" class="form-control stok_buku" id="stok-buku" name="stok_buku" placeholder="masukkan stok buku">
                    <div class="invalid-feedback error-stok_buku"></div>
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
