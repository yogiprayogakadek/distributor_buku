<?php

namespace App\Http\Controllers\Distributor;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use Illuminate\Http\Request;

class KeranjangController extends Controller
{
    public function index(Request $request)
    {
        return view('distributor.keranjang.index');
    }

    public function render()
    {
        $view = [
            'data' => view('distributor.keranjang.render')->with([
                'cart' => cart()
            ])->render(),
        ];

        return response()->json($view);
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
                    'value' => $request->kuantitas
                ],
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Kuantitas berhasil diubah',
                'title' => 'Berhasil',
                // 'cart' => cart(),
                // 'subtotal' => subTotal()
            ]);
        }
    }

    public function checkout(Request $request)
    {
        dd($request->all());
    }
}
