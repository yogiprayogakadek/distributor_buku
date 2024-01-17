@extends('templates.master')

@section('title', 'Keranjang')
@section('sub-title', 'Belanja')

@push('css')
    <link href="{{ asset('assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
    <div class="row render"></div>
@endsection

@push('script')
    <script src="{{ asset('assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js') }}"></script>
    <script>
        function getData() {
            $.ajax({
                type: "get",
                url: "/distributor/keranjang/render",
                dataType: "json",
                success: function(response) {
                    $(".render").html(response.data);
                },
                error: function(error) {
                    console.log("Error", error);
                },
            });
        }
        $(document).ready(function() {
            getData();

            $('body').on('click', '.bootstrap-touchspin-up', function() {
                var id = $(this).data('id');
                var qty = parseInt(parseInt($(this).closest('.input-group').find('.kuantitas').val())) + 1;
                var cat = 'plus';
                $.ajax({
                    url: '/distributor/keranjang/update',
                    type: 'POST',
                    data: {
                        id: id,
                        kuantitas: qty,
                        cat: cat,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(result) {
                        Swal.fire(
                            result.title,
                            result.message,
                            result.status
                        )
                        getData()
                    }
                });
            });

            $('body').on('click', '.bootstrap-touchspin-down', function() {
                var id = $(this).data('id');
                var qty = parseInt(parseInt($(this).closest('.input-group').find('.kuantitas').val())) - 1;
                var cat = 'minus';
                $.ajax({
                    url: '/distributor/keranjang/update',
                    type: 'POST',
                    data: {
                        id: id,
                        kuantitas: qty,
                        cat: cat,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(result) {
                        Swal.fire(
                            result.title,
                            result.message,
                            result.status
                        )
                        getData()
                    }
                });
            });

            $('body').on('blur', '.kuantitas', function() {
                var id = $(this).data('id');
                var qty = parseInt($(this).val());
                // var cat = 'plus';
                $.ajax({
                    url: '/distributor/keranjang/update',
                    type: 'POST',
                    data: {
                        id: id,
                        kuantitas: qty,
                        // cat: cat,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(result) {
                        Swal.fire(
                            result.title,
                            result.message,
                            result.status
                        )
                        getData()
                    }
                });
            });

            $('body').on('click', '.btn-proses', function() {
                $('#modalCheckout').modal('show')
                $('.group-bukti').html('')
                $('.pembayaran').val('Tunai')
                $('.btn-checkout').prop('disabled', false)
            })

            $('body').on('change', '.pembayaran', function() {
                let value = $('select[name=pembayaran] option').filter(':selected').val()

                let fill = '<label for="bukti" class="col-sm-2 col-form-label">Bukti</label>' +
                    '<div class="col-md-10">' +
                    '<input type="file" class="form-control bukti" id="bukti" name="bukti">' +
                    '<div class="invalid-feedback error-bukti"></div>' +
                    '</div>';

                if (value == 'Transfer') {
                    $('.group-bukti').append(fill)
                    $('.btn-checkout').prop('disabled', true)
                } else {
                    $('.group-bukti').html('')
                    $('.btn-checkout').prop('disabled', false)
                }
            })

            $('body').on('change', '.bukti', function() {
                var fileInput = $(this)[0];
                var file = fileInput.files[0];

                if (file) {
                    var fileType = file.type;
                    var validImageTypes = ['image/jpeg', 'image/png', 'image/gif'];

                    if (validImageTypes.includes(fileType)) {
                        // Image is valid
                        $('.bukti').removeClass('is-invalid')
                        $('.error-bukti').text('');

                        $('.btn-checkout').prop('disabled', false)
                    } else {
                        // Invalid image file type
                        $('.bukti').addClass('is-invalid')
                        $('.error-bukti').text('Hanya tipe file JPEG, PNG, and GIF yang dapat di unggah');
                        // $('.error-bukti').text('Invalid image file type. Only JPEG, PNG, and GIF are allowed.');
                        // Clear the file input
                        $(this).val('');
                        $('.btn-checkout').prop('disabled', true)
                    }
                } else {
                    // No file selected
                    $('.bukti').addClass('is-invalid')
                    $('.error-bukti').text('No file selected.');
                    $('.btn-checkout').prop('disabled', true)
                }
            });

            $('body').on('click', '.btn-checkout', function(e) {
                let pembayaran = $('select[name=pembayaran] option').filter(':selected').val()
                let error = $('.is-invalid').length

                // if(pembayaran == 'Transfer') {
                //     bukti = $('.bukti')[0].files[0]
                // }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                let form = $('#formCheckout')[0]
                let data = new FormData(form)
                $.ajax({
                    type: 'POST',
                    url: '/distributor/keranjang/checkout',
                    data: data,
                    processData: false,
                    contentType: false,
                    cache: false,
                    beforeSend: function() {
                        $('.btn-checkout').attr('disable', 'disabled')
                        $('.btn-checkout').html('<i class="fa fa-spin fa-spinner"></i>')
                    },
                    complete: function() {
                        $('.btn-checkout').removeAttr('disable')
                        $('.btn-checkout').html('Simpan')
                    },
                    success: function(response) {
                        $('#modalCheckout').modal('hide');
                        Swal.fire(
                            response.title,
                            response.message,
                            response.status
                        );
                        getData();
                        getCart();
                    },
                    error: function(error) {
                        //
                    }
                });
            });

            $("body").on("click", ".btn-hapus-cart", function() {
                var id = $(this).data("id");
                Swal.fire({
                    title: "Anda yakin?",
                    text: "Data yang dihapus tidak dapat dikembalikan!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ya, hapus!",
                    cancelButtonText: "Batal",
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: "/keranjang/remove/" + id,
                            type: "GET",
                            success: function(result) {
                                Swal.fire(result.title, result.message, result.status);
                                getData();
                                getCart();
                            },
                        });
                    }
                });
            });
        });
    </script>
@endpush
