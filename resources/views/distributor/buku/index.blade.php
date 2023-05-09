@extends('templates.master')

@section('title', 'Buku')
@section('sub-title', 'Data')

@push('css')
<link href="{{asset('assets/libs/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
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
<div class="row">
    <div class="col-lg-3">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Filter</h4>


                <div class="mt-4 pt-3">
                    <h5 class="font-size-14 mb-3">Kategori</h5>
                    <div class="form-control mt-2">
                        <select class="select2 form-control select2-multiple" multiple="multiple" data-placeholder="Choose ...">
                            @foreach ($kategori as $key => $value)
                                <option value="{{$key}}">{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-9">
        <div class="row mb-3">
            <div class="col-xl-4 col-sm-6">
                <div class="mt-2">
                    <h5>Buku</h5>
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
<script>
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

            $.get("/distributor/buku/search/" + value, function(data) {
                $('#buku').html(data)
            });
        })
    });
</script>
@endpush
