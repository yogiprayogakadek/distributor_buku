<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use Illuminate\Http\Request;

class KeranjangController extends Controller
{
    public function tambah(Request $request)
    {
        $buku = Buku::find($request->id);
        $user_id = auth()->user()->id;
        try {
            if (\Cart::session($user_id)->get($buku->id)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Produk sudah ada di keranjang',
                    'title' => 'Gagal',
                ]);
            } else {
                if ($buku->stok_buku <= 0) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Tidak ada stok untuk produk ini',
                        'title' => 'Gagal',
                    ]);
                } else {
                    \Cart::session($user_id)->add([
                        'id' => $buku->id,
                        'name' => json_decode($buku->data_buku, true)['judul'],
                        'price' => json_decode($buku->data_buku, true)['harga'],
                        'quantity' => 1,
                        'associatedModel' => $buku,
                    ]);

                    return response()->json([
                        'status' => 'success',
                        'message' => 'Produk berhasil ditambahkan ke keranjang',
                        'title' => 'Berhasil',
                        'cart' => cart(),
                        'subtotal' => subTotal()
                    ]);
                }
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
                'title' => 'Gagal',
            ]);
        }
    }

    public function update(Request $request)
    {
        $user_id = auth()->user()->id;
        $buku = Buku::find($request->id);
        if ($request->kuantitas > $buku->stok_buku) {
            return response()->json([
                'status' => 'info',
                'message' => 'Stok tidak mencukupi, stok yang tersedia ' . $buku->stok_buku,
                'title' => 'Info',
            ]);
        } else {
            \Cart::session($user_id)->update($request->id, [
                'quantity' => [
                    'relative' => false,
                    'value' => $request->qty
                ],
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Kuantitas berhasil diubah',
                'title' => 'Berhasil',
                'cart' => cart(),
                'subtotal' => subTotal()
            ]);
        }
    }

    public function remove($id)
    {
        $user = auth()->user()->id;
        \Cart::session($user)->remove($id);
        return response()->json([
            // 'cart' => cart(),
            // 'subtotal' => subTotal(),
            'status' => 'success',
            'message' => 'Produk berhasil dihapus dari keranjang',
            'title' => 'Berhasil'
        ]);
    }

    public function check()
    {
        dd(\Cart::session(auth()->user()->id)->getContent());
    }
}
