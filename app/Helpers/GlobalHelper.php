<?php
function convertToRupiah($jumlah)
{
    return 'Rp ' . number_format($jumlah, 0, '.', '.');
}

function rupiah($jumlah)
{
    return number_format($jumlah, 0, '.', '.');
}

function cart()
{
    return \Cart::session(auth()->user()->id)->getContent();
}

function cartByUserId($user_id)
{
    return \Cart::session($user_id)->getContent();
}

function clearCart()
{
    return \Cart::session(auth()->user()->id)->clear();
}

function subTotal()
{
    $user_id = auth()->user()->id;
    $cart = \Cart::session($user_id)->getContent();
    $subtotal = 0;
    foreach ($cart as $item) {
        $subtotal += $item->price * $item->quantity;
    }

    return convertToRupiah($subtotal);
}

function cartQuantity()
{
    $total = 0;
    foreach (cart() as $key => $value) {
        $total += $value->quantity;
    }

    return $total;
}

function getKuantitas($data, $key)
{
    // $kodeBuku = [];
    // $kuantitas = '';
    foreach ($data as $data) {
        // $kodeBuku[] = $data['kode_buku'];
        // if (in_array($key, $data['kode_buku'])) {
        //     return $data['kuantitas'];
        // }
        if ($data['kode_buku'] == $key) {
            return $data['terjual'] . ' eksemplar';
        }
    }
}
