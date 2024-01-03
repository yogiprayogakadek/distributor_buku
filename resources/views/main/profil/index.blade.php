@extends('templates.master')

@section('title', 'Profil')
@section('sub-title', 'Data')

@section('content')
<div class="row render p-2">
    <div class="col-4">
        <div class="card">
            <div class="card-header text-center">
                <img src="{{asset(auth()->user()->foto)}}" class="img-fluid">
            </div>
            <div class="card-body pb-2">
                <label class="font-weight-bold">Nama</label>
                <div class="mb-2">{{ $user->nama }}</div>
                <label class="font-weight-bold">Email</label>
                <div class="mb-2">{{ $user->email }}</div>
                <label class="font-weight-bold">Jenis Kelamin</label>
                <div class="mb-2">{{ $user->jenis_kelamin }}</div>
                <label class="font-weight-bold">No. Telp</label>
                <div class="mb-2">{{ $user->telp }}</div>
            </div>
            <div class="card-footer bg-primary text-white text-center btn-profil" style="cursor: pointer">
                Ubah
            </div>
        </div>
    </div>

    <div class="col-8 detail-profil" hidden>
        <div class="card">
            <form id="formProfil">
                <div class="card-body">
                    <div class="form-group row mt-2">
                        <label for="username" class="ul-form__label ul-form--margin col-lg-3 mt-2 col-form-label ">
                            Username
                        </label>
                        <div class="col-lg-9 mt-2">
                            <input type="text" class="form-control username" name="username" id="username"
                                placeholder="masukkan username" value="{{ $user->username }}">
                            <div class="invalid-feedback error-username"></div>
                        </div>
                    </div>
                    <div class="form-group row mt-2">
                        <label for="nama" class="ul-form__label ul-form--margin col-lg-3 mt-2 col-form-label ">
                            Nama
                        </label>
                        <div class="col-lg-9 mt-2">
                            <input type="text" class="form-control nama" name="nama" id="nama"
                                placeholder="masukkan nama" value="{{ $user->nama }}">
                            <div class="invalid-feedback error-nama"></div>
                        </div>
                    </div>
                    <div class="form-group row mt-2">
                        <label for="jenis-kelamin" class="ul-form__label ul-form--margin col-lg-3 mt-2 col-form-label ">
                            Jenis Kelamin
                        </label>
                        <div class="col-lg-9 mt-2">
                            <select name="jenis_kelamin" id="jenis-kelamin" class="form-control jenis_kelamin">
                                <option value="">Pilih jenis kelamin...</option>
                                <option value="Laki - Laki"
                                    {{ $user->jenis_kelamin == 'Laki - Laki' ? 'selected' : '' }}>Laki - Laki</option>
                                <option value="Perempuan" {{ $user->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>
                                    Perempuan</option>
                            </select>
                            <div class="invalid-feedback error-jenis_kelamin"></div>
                        </div>
                    </div>
                    <div class="form-group row mt-2">
                        <label for="telp" class="ul-form__label ul-form--margin col-lg-3 mt-2 col-form-label ">
                            No. telp
                        </label>
                        <div class="col-lg-9 mt-2">
                            <input type="text" class="form-control telp" name="telp" id="telp"
                                placeholder="masukkan no. telp" value="{{ $user->telp }}">
                            <div class="invalid-feedback error-telp"></div>
                        </div>
                    </div>
                    <div class="form-group row mt-2">
                        <label for="email" class="ul-form__label ul-form--margin col-lg-3 mt-2 col-form-label ">
                            Email
                        </label>
                        <div class="col-lg-9 mt-2">
                            <input type="text" class="form-control email" name="email" id="email"
                                placeholder="masukkan email" value="{{ $user->email }}">
                            <div class="invalid-feedback error-email"></div>
                        </div>
                    </div>
                    <div class="form-group row mt-2">
                        <label for="password" class="ul-form__label ul-form--margin col-lg-3 mt-2 col-form-label ">
                            Password
                        </label>
                        <div class="col-lg-9 mt-2">
                            <input type="password" class="form-control password" name="password" id="password"
                                placeholder="masukkan password">
                            <span class="text-muted text-small">*kosongkan apabila tidak ingin mengganti password</span>
                            <div class="invalid-feedback error-password"></div>
                        </div>
                    </div>
                    <div class="form-group row mt-2">
                        <label for="password-confirmation"
                            class="ul-form__label ul-form--margin col-lg-3 mt-2 col-form-label ">
                            Konfirmasi Password
                        </label>
                        <div class="col-lg-9 mt-2">
                            <input type="password" class="form-control password_confirmation"
                                name="password_confirmation" id="password-confirmation"
                                placeholder="masukkan konfirmasi password">
                            <div class="invalid-feedback error-password_confirmation"></div>
                        </div>
                    </div>
                    <div class="form-group row mt-2">
                        <label for="nama_pt" class="ul-form__label ul-form--margin col-lg-3 mt-2 col-form-label ">
                            Nama PT
                        </label>
                        <div class="col-lg-9 mt-2">
                            <input type="text" class="form-control nama_pt" name="nama_pt" id="nama_pt"
                                placeholder="masukkan nama pt" value="{{ $user->distributor->nama_pt ?? '' }}">
                            <div class="invalid-feedback error-nama_pt"></div>
                        </div>
                    </div>
                    <div class="form-group row mt-2">
                        <label for="alamat" class="ul-form__label ul-form--margin col-lg-3 mt-2 col-form-label ">
                            Alamat PT
                        </label>
                        <div class="col-lg-9 mt-2">
                            <input type="text" class="form-control alamat" name="alamat" id="alamat"
                                placeholder="masukkan alamat pt" value="{{ $user->distributor->alamat_pt ?? '' }}">
                            <div class="invalid-feedback error-alamat"></div>
                        </div>
                    </div>
                    <div class="form-group row mt-2">
                        <label for="foto" class="ul-form__label ul-form--margin col-lg-3 mt-2 col-form-label ">
                            Foto
                        </label>
                        <div class="col-lg-9 mt-2">
                            <input type="file" class="form-control foto" name="foto" id="foto"
                                placeholder="masukkan foto">
                            <span class="text-muted text-small">*kosongkan apabila tidak ingin mengganti foto</span>
                            <div class="invalid-feedback error-foto"></div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="card-footer bg-primary text-end">
                <button class="btn btn-secondary btn-save pull-right">Simpan</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
    <script>
        $('body').ready(function() {
            $('body').on('click', '.btn-profil', function() {
                $('.detail-profil').prop('hidden', false).slideDown(500);
            })

            // on save button
            $('body').on('click', '.btn-save', function(e) {
                if($('#password').val() == '' || $('#password-confirmation').val() == '') {
                    $('.password_confirmation').removeClass('is-invalid')
                    $('.error-password_confirmation').html('')
                    $('.password').removeClass('is-invalid')
                    $('.error-password').html('')
                }
                if($('.password_confirmation').hasClass('is-invalid')) {
                    return false;
                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                let form = $('#formProfil')[0]
                let data = new FormData(form)

                $.ajax({
                    type: "POST",
                    url: "/profil/update",
                    data: data,
                    processData: false,
                    contentType: false,
                    cache: false,
                    beforeSend: function() {
                        $('.btn-save').attr('disable', 'disabled')
                        $('.btn-save').html('<i class="fa fa-spin fa-spinner"></i>')
                    },
                    complete: function() {
                        $('.btn-save').removeAttr('disable')
                        $('.btn-save').html('Simpan')
                    },
                    success: function(response) {
                        Swal.fire(
                            response.title,
                            response.message,
                            response.status
                        );
                        if (response.status == 'success') {
                            setTimeout(() => {
                                location.reload();
                            }, 1000)
                        }
                    },
                    error: function (error) {
                        let formName = []
                        let errorName = []

                        $.each($('#formProfil').serializeArray(), function (i, field) {
                            formName.push(field.name.replace(/\[|\]/g, ''))
                        });
                        if (error.status == 422) {
                            if (error.responseJSON.errors) {
                                $.each(error.responseJSON.errors, function (key, value) {
                                    errorName.push(key)
                                    if($('.'+key).val() == '') {
                                        $('.' + key).addClass('is-invalid')
                                        $('.error-' + key).html(value)
                                    }
                                })
                                $.each(formName, function (i, field) {
                                    $.inArray(field, errorName) == -1 ? $('.'+field).removeClass('is-invalid') : $('.'+field).addClass('is-invalid');
                                });
                            }
                        }
                    }
                });
            });

            // on change password
            $('#password').on('keyup', function() {
                let value = $(this).val();
                if (value.length < 8) {
                    $('.password').addClass('is-invalid')
                    $('.error-password').html('Password minimal 8 karakter')

                    $('.password_confirmation').addClass('is-invalid')
                    $('.error-password_confirmation').html('Password konfirmasi tidak boleh kosong')
                } else {
                    if(password !== value) {
                        $('.password_confirmation').addClass('is-invalid')
                        $('.error-password_confirmation').html('Password konfirmasi tidak sama')
                    } else {
                        $('.password_confirmation').removeClass('is-invalid')
                        $('.error-password_confirmation').html('')
                    }
                    $('.password').removeClass('is-invalid')
                    $('.error-password').html('')
                }
            });

            // on change password
            $('#password-confirmation').on('keyup', function() {
                let value = $(this).val();
                let password = $('#password').val()
                if (value.length < 8) {
                    $('.password_confirmation').addClass('is-invalid')
                    $('.error-password_confirmation').html('Password konfirmasi minimal 8 karakter')
                } else {
                    if(password !== value) {
                        $('.password_confirmation').addClass('is-invalid')
                        $('.error-password_confirmation').html('Password konfirmasi tidak sama')
                    } else {
                        $('.password_confirmation').removeClass('is-invalid')
                        $('.error-password_confirmation').html('')
                        $('.password').removeClass('is-invalid')
                        $('.error-password').html('')
                    }
                }
            });
        })
    </script>
@endpush
