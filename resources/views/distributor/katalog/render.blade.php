@forelse ($buku as $item)
    <div class="col-xl-4 col-sm-6">
        <div class="card">
            <div class="card-body">
                <div class="product-img position-relative">
                    <div class="image-container">
                        <img src="{{ asset(json_decode($item->data_buku, true)['foto']) }}" alt=""
                            class="img-fluid mx-auto d-block">
                        {{-- <button class="middle-button btn-keranjang" data-id="{{ $item->id }}">
                            <i class="bx bxs-cart-alt"></i> Tambahkan
                        </button> --}}
                        <button class="middle-button btn-detail mt-5" data-buku="{{ $item->data_buku }}"
                            data-id="{{ $item->id }}" style="background-color: rgb(0,0,128, 0.8) !important;">
                            <i class="fa fa-eye"></i> Detail
                        </button>
                    </div>
                </div>
                <div class="mt-4 text-center">
                    <h5 class="mb-3 text-truncate"><a href="javascript: void(0);"
                            class="text-dark">{{ json_decode($item->data_buku, true)['judul'] }} -
                            {{ json_decode($item->data_buku, true)['penerbit'] }}</a></h5>
                    <h5 class="my-0"><b>{{ rupiah(json_decode($item->data_buku, true)['harga']) }}</b></h5>

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
