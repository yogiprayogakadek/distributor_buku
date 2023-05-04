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
