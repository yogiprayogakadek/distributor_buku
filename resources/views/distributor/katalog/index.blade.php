@extends('templates.master')

@section('title', 'Katalog Buku')
@section('sub-title', 'Data')

@push('css')
<link href="{{asset('assets/libs/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="{{asset('assets/css/slider.min.css')}}">
<style>
    .image-container {
        position: relative;
        display: inline-block;
    }

    .middle-button {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        opacity: 0;
        background-color: rgba(0, 0, 0, 0.7);
        color: #fff;
        padding: 10px 20px;
        border-radius: 5px;
        transition: opacity 0.3s;
    }

    .image-container:hover img {
        opacity: 0.7;
    }

    .image-container:hover .middle-button {
        opacity: 1;
    }
</style>
@endpush

@section('content')

<!-- Modal -->
<div class="modal fade" id="modalDetail" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
                <div class="modal-header">
                        <h5 class="modal-title">Detail Buku</h5>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal" >
                                <i class="fa fa-times"></i>
                            </button>
                    </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-6 text-end">
                            <img id="cover-buku" class="img-thumbnail">
                        </div>
                        <div class="col-6">
                            <div class="row">
                                <div class="col-4">Judul Buku</div>
                                <div class="col-1 text-end">:</div>
                                <div class="col-7 judul">Dongeng</div>

                                <div class="col-4">Tahun Terbit</div>
                                <div class="col-1 text-end">:</div>
                                <div class="col-7 tahun">2023</div>

                                <div class="col-4">Penerbit</div>
                                <div class="col-1 text-end">:</div>
                                <div class="col-7 penerbit">2023</div>

                                <div class="col-4">Penulis</div>
                                <div class="col-1 text-end">:</div>
                                <div class="col-7 penulis">2023</div>

                                <div class="col-4">Harga</div>
                                <div class="col-1 text-end">:</div>
                                <div class="col-7 harga">2023</div>

                                <div class="col-4">Deskripsi</div>
                                <div class="col-1 text-end">:</div>
                                <div class="col-7 deskripsi">2023</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-3 div-filter">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Filter</h4>


                <div class="mt-4 pt-3">
                    <div class="row">
                        <div class="col-6">
                            <h5 class="font-size-14 mb-3">Kategori</h5>
                        </div>
                        <div class="col-6 text-end">
                            <button type="button" class="btn btn-secondary btn-clear btn-sm" hidden>Bersihkan</button>
                        </div>
                    </div>
                    <form id="formFilter">
                        <div class="form-control mt-2">
                            <select class="select2 form-control col-12 select2-multiple" multiple="multiple" data-placeholder="Choose ..." name="kategori[]">
                                @foreach ($kategori as $key => $value)
                                    <option value="{{$key}}">{{$value}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mt-1 text-end">
                            <span class="text-end btn-more" style="cursor: pointer">Lainnya</span>
                        </div>
                        <div class="form-group slider">
                            <h5 class="font-size-14 mb-3 text-center">Harga</h5>
                            <input type="text" class="mt-5 " id="sampleSlider" />
                        </div>
                        <div class="form-group text-end mt-2">
                            <button type="button" class="btn btn-primary btn-filter col-12">Filter</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-9 div-katalog">
        <div class="row mb-3">
            <div class="col-xl-4 col-sm-6">
                <div class="mt-2">
                    <h5>Katalog Buku</h5>
                </div>
            </div>
            <div class="col-lg-8 col-sm-6">
                <div class="mt-4 mt-sm-0 float-sm-end d-sm-flex align-items-center">
                    <div class="search-box me-2">
                        <div class="position-relative">
                            <input type="text" class="form-control border-0" id="search" placeholder="Search...">
                            <i class="bx bx-search-alt search-icon"></i>
                        </div>
                    </div>
                    <ul class="nav nav-pills product-view-nav justify-content-end mt-3 mt-sm-0">
                        <li class="nav-item">
                            <button type="button" class="btn btn-primary btn-search">
                                <i class="bx bx-search"></i>
                            </button>
                        </li>
                    </ul>


                </div>
            </div>
        </div>

        <div class="row" id="buku">
            @forelse ($buku as $item)
            <div class="col-xl-4 col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <div class="product-img position-relative">
                            <div class="image-container">
                                <img src="{{asset(json_decode($item->data_buku, true)['foto'])}}" alt="" class="img-fluid mx-auto d-block">
                                <button class="middle-button btn-keranjang" data-id="{{$item->id}}">
                                    <i class="bx bxs-cart-alt"></i> Tambahkan
                                </button>
                                <button class="middle-button btn-detail mt-5" data-buku="{{$item->data_buku}}" data-id="{{$item->id}}" style="background-color: rgb(0,0,128, 0.8) !important;">
                                    <i class="fa fa-eye"></i> Detail
                                </button>
                            </div>
                        </div>
                        <div class="mt-4 text-center">
                            <h5 class="mb-3 text-truncate"><a href="javascript: void(0);" class="text-dark">{{json_decode($item->data_buku, true)['judul']}} - {{json_decode($item->data_buku, true)['penerbit']}}</a></h5>
                            <h5 class="my-0"><b>{{rupiah(json_decode($item->data_buku, true)['harga'])}}</b></h5>

                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center">
                <h2>No Data</h2>
            </div>
            @endforelse

            <div class="col-lg-12">
                {!! $buku->withQueryString()->links('pagination::bootstrap-5') !!}
            </div>
        </div>

        {{-- <div class="row">
                <div class="col-lg-12">
                    {!! $buku->withQueryString()->links('pagination::bootstrap-5') !!}
                </div>
            </div> --}}
    </div>
</div>
@endsection

@push('script')
<script src="{{asset('assets/libs/select2/js/select2.min.js')}}"></script>
<script src="{{asset('assets/js/slider.min.js')}}"></script>
<script>
    function assets(url) {
        var url = '{{ url("") }}/' + url;
        return url;
    }
    function getBuku(url) {
        $.ajax({
            url: url
        }).done(function(data) {
            $('#buku').html(data);
        }).fail(function() {
            alert('Error data tidak dapat di muat.');
        });
    }
    $(document).ready(function() {
        $('.select2-multiple').select2();

        $('body').on('click', '.pagination a', function(e) {
            e.preventDefault();
            var url = $(this).attr('href');
            getBuku(url);
        });

        $('body').on('click', '.btn-keranjang', function() {
            var id = $(this).data('id');
            Swal.fire({
                title: 'Tambah ke keranjang?',
                text: "Tambahkan",
                icon: 'success',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, tambahkan!',
            }).then((result) => {
                var formData = new FormData();
                formData.append('id', id);
                formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "/keranjang/tambah",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            Swal.fire({
                                icon: response.status,
                                title: response.title,
                                text: response.message,
                            })

                            if (response.status == 'success') {
                                getCart();
                            }
                        }
                    });
                }
            })
        });

        $('body').on('click', '.btn-search', function() {
            let value = $('#search').val();

            if (value == '') {
                value = 'null';
            }

            $.get("/distributor/katalog/search/" + value, function(data) {
                $('#buku').html(data)
            });
        })

        // show btn clear
        $('body').on('change', '.select2-multiple', function() {
            let length = $(":selected", '.select2-multiple').length
            if(length > 0) {
                $('.btn-clear').prop('hidden', false)
            } else {
                $('.btn-clear').prop('hidden', true)
            }
        })

        $('body').on('click', '.btn-clear', function() {
            $('.select2-multiple').val('').trigger('change');
        })

        var mySlider = new rSlider({
            target: '#sampleSlider',
            values: [5000, 10000, 50000, 100000, 500000],
            range: true,
            tooltip: true,
            scale: true,
            labels: false,
            set: [5000, 500000]
        });

        $('body').on('click', '.btn-filter', function() {
            // let kategori = $('.select2-multiple').val()
            let harga = mySlider.getValue()
            let kat = []

            if($('.select2-multiple').val().length > 0) {
                $('.select2-multiple').val()
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            let form = $('#formFilter')[0]
            let data = new FormData(form)
            data.append('harga', harga)
            data.append('kat', kat)
            $.ajax({
                type: "POST",
                url: "/distributor/katalog/filter",
                data: data,
                processData: false,
                contentType: false,
                success: function (response) {
                    $('#buku').html(response)
                },
                error: function (error) {
                    console.log(error)
                }
            });
        })

        // hide slider
        $('.slider').prop('hidden', true)
        $('body').on('click', '.btn-more', function() {
            if($('.div-filter').hasClass('col-lg-3')) {
                $('.div-filter').removeClass('col-lg-3').addClass('col-lg-4')
                $('.div-katalog').removeClass('col-lg-9').addClass('col-lg-8')
                $('.slider').prop('hidden', false)
                $(this).text('Tutup')
                $('.select2-container ').css('width', '100%')
            } else {
                $('.div-filter').removeClass('col-lg-4').addClass('col-lg-3')
                $('.div-katalog').removeClass('col-lg-8').addClass('col-lg-9')
                $('.slider').prop('hidden', true)
                $(this).text('Lainnya')
                $('.select2-container ').css('width', '100%')
            }
        })

        $('body').on('click', '.btn-detail', function() {
            $('#modalDetail').modal('show');
            let data = $(this).data('buku');
            let buku = $.parseJSON(JSON.stringify(data))

            console.log(buku)

            $('#cover-buku').attr('src', assets(buku.foto))
            $('.judul').text(buku.judul)
            $('.tahun').text(buku.tahun_terbit)
            $('.penerbit').text(buku.penerbit)
            $('.penulis').text(buku.penulis)
            $('.harga').text(buku.harga.toLocaleString("id-ID", {style: "currency",currency: "IDR",minimumFractionDigits: 0,}))
            $('.deskripsi').text(buku.deskripsi)
        })
    });
</script>
@endpush
