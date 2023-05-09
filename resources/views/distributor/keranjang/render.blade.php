<div class="col-xl-8">
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle mb-0 table-nowrap">
                    <thead class="table-light">
                        <tr>
                            <th>Buku</th>
                            <th>Judul</th>
                            <th>Penulis</th>
                            <th>Harga</th>
                            <th>Kuantitas</th>
                            <th colspan="2">Total</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($cart as $cart)
                        <tr>
                            <td>
                                <img src="{{asset(json_decode($cart->associatedModel->data_buku, true)['foto'])}}" alt="product-img" title="product-img" class="avatar-md">
                            </td>
                            <td>
                                <h5 class="font-size-14 text-truncate"><a href="ecommerce-product-detail.html" class="text-dark">{{$cart->name}}</a></h5>
                                <p class="mb-0">Tahun terbit : <span class="fw-medium">{{json_decode($cart->associatedModel->data_buku, true)['tahun_terbit']}}</span></p>
                            </td>
                            <td>
                                {{json_decode($cart->associatedModel->data_buku, true)['penulis']}}
                            </td>
                            <td>
                                {{convertToRupiah($cart->price)}}
                            </td>
                            <td>
                                <div class="me-3" style="width: 120px;">
                                    <div class="input-group  bootstrap-touchspin bootstrap-touchspin-injected">
                                        <input type="text" value="{{$cart->quantity}}" name="kuantitas" class="form-control kuantitas" data-id="{{$cart->id}}">
                                        <span class="input-group-btn-vertical">
                                            <button class="btn btn-primary bootstrap-touchspin-up" type="button" data-id="{{$cart->id}}" data-qty="{{$cart->quantity}}">+</button>
                                            <button class="btn btn-primary bootstrap-touchspin-down" type="button" data-id="{{$cart->id}}" data-qty="{{$cart->quantity}}">-</button>
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td colspan="2">
                                {{convertToRupiah($cart->quantity*$cart->price)}}
                            </td>
                            <td>
                                <a href="javascript:void(0);" class="action-icon text-danger"> <i class="mdi mdi-trash-can font-size-18"></i></a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">
                                <h2>No Data</h2>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if (cart()->count() > 0)
            <div class="row mt-4">
                <div class="col-sm-6">
                    <a href="{{route('distributor.buku.index')}}" class="btn btn-secondary">
                        <i class="mdi mdi-arrow-left me-1"></i> Lanjutkan Belanja </a>
                </div> <!-- end col -->
                <div class="col-sm-6">
                    <div class="text-sm-end mt-2 mt-sm-0">
                        <button type="button" class="btn btn-success btn-proses">
                            <i class="mdi mdi-cart-arrow-right me-1"></i> Proses
                        </button>
                    </div>
                </div> <!-- end col -->
            </div>
            @endif
            <!-- end row-->
        </div>
    </div>
</div>

<!-- SUMMARY -->
<div class="col-xl-4">
    {{-- modal --}}
    <div class="modal fade" id="modalCheckout" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formCheckout">
                    <div class="modal-body">
                        <div class="row mb-4">
                            <label for="kode-buku" class="col-sm-2 col-form-label">Total</label>
                            <div class="col-md-10">
                                <input type="text" class="form-control total" id="kode-buku" name="total" value="{{subTotal()}}" disabled>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label for="pembayaran" class="col-sm-2 col-form-label">Pembayaran</label>
                            <div class="col-md-10">
                                <select class="form-select pembayaran" name="pembayaran" id="pembayaran">
                                    <option value="Tunai">Tunai</option>
                                    <option value="Transfer">Transfer</option>
                                </select>
                                <div class="invalid-feedback error-pembayaran"></div>
                            </div>
                        </div>

                        <div class="row mb-4 group-bukti">
                            <label for="bukti" class="col-sm-2 col-form-label">Bukti</label>
                            {{-- <div class="col-md-10">
                                <input type="file" class="form-control bukti" id="bukti" name="bukti">
                                <div class="invalid-feedback error-bukti"></div>
                            </div> --}}
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-primary btn-checkout">Proses</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="card">
        <div class="card-body">
            <h4 class="card-title mb-3">Order Summary</h4>

            <div class="table-responsive">
                <table class="table mb-0">
                    <tbody>
                        <tr>
                            <td>Total item :</td>
                            <td>{{cart()->count()}}</td>
                        </tr>
                        <tr>
                            <td>Kuantitas buku : </td>
                            <td>{{cartQuantity()}}</td>
                        </tr>
                        <tr>
                            <th>Total :</th>
                            <th>{{subTotal()}}</th>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- end table-responsive -->
        </div>
    </div>
    <!-- end card -->
</div>

<script>
    $("input[name=kuantitas]").inputFilter(function(value) {
        return /^\d*$/.test(value);
    }, "Hanya mengandung angka ");
</script>
