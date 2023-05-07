<button type="button" class="btn header-item noti-icon waves-effect" id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <i class="bx bx bx-cart"></i>
    <span class="badge bg-danger rounded-pill">{{cart()->count()}}</span>
</button>
<div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-notifications-dropdown">
    <div class="p-3">
        <div class="row align-items-center">
            <div class="col">
                <h6 class="m-0" key="t-notifications"> Keranjang Belanja </h6>
            </div>
            <div class="col-auto">
                <a href="{{route('distributor.keranjang.index')}}" class="small" key="t-view-all"> View All</a>
            </div>
        </div>
    </div>
    <div data-simplebar="init" style="max-height: 230px;">
        <div class="simplebar-wrapper" style="margin: 0px;">
            <div class="simplebar-height-auto-observer-wrapper">
                <div class="simplebar-height-auto-observer"></div>
            </div>
            <div class="simplebar-mask">
                <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                    <div class="simplebar-content-wrapper" style="height: auto; overflow: hidden;">
                        <div class="simplebar-content" style="padding: 0px;">
                            @forelse ($cart as $cart)
                            <div class="text-reset notification-item">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-xs me-3">
                                        <img src="{{asset(json_decode($cart->associatedModel->data_buku, true)['foto'])}}" class="avatar-title bg-primary rounded-circle font-size-16">
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="row align-items-center">
                                            <div class="col-9">
                                                <h6 class="mb-1" key="t-your-order">{{$cart->name}}</h6>
                                                <div class="font-size-12 text-muted">
                                                    <p class="mb-1" key="t-grammer">Jumlah: {{$cart->quantity}}</p>
                                                    <p class="mb-1" key="t-grammer">{{convertToRupiah($cart->price)}}</p>
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                <button class="btn btn-danger btn-rounded mr-4 btn-hapus-item" data-id="{{$cart->id}}">
                                                    <i class="bx bx-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <p class="text-center p-4" key="t-no-data">No Data</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
            <div class="simplebar-placeholder" style="width: 0px; height: 0px;"></div>
        </div>
        <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
            <div class="simplebar-scrollbar" style="transform: translate3d(0px, 0px, 0px); display: none;"></div>
        </div>
        <div class="simplebar-track simplebar-vertical" style="visibility: hidden;">
            <div class="simplebar-scrollbar" style="transform: translate3d(0px, 0px, 0px); display: none; height: 136px;"></div>
        </div>
    </div>
    <div class="p-2 border-top d-grid">
        <a class="btn btn-sm btn-link font-size-14 text-center" href="{{route('distributor.keranjang.index')}}">
            <i class="mdi mdi-arrow-right-circle me-1"></i> <span key="t-view-more">View More..</span>
        </a>
    </div>
</div>
