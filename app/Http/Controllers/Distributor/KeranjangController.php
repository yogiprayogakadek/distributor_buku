<?php

namespace App\Http\Controllers\Distributor;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\DetailTransaksi;
use App\Models\Pembayaran;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KeranjangController extends Controller
{
    protected function kodePesanan()
    {
        return 'trans-' . time();
    }

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
        DB::transaction(function () use ($request) {
            $dataTransaksi = [
                'kode_pesanan' => $this->kodePesanan(),
                'tanggal_pesanan' => date('Y-m-d H:i:s'),
                'distributor_id' => auth()->user()->distributor->id,
                'total' => preg_replace('/[^0-9]/', '', subTotal()),
                'status_pesanan' => 'Menunggu Konfirmasi',
            ];
            $transaksi = Transaksi::create($dataTransaksi);

            foreach (cart() as $cart) {
                $buku = Buku::find($cart->id);
                $dataDetailTransaki = [
                    'transaksi_id' => $transaksi->id,
                    'buku_id' => $cart->id,
                    'kuantitas' => $cart->quantity
                ];

                DetailTransaksi::create($dataDetailTransaki);

                // update stok
                $buku->update([
                    'stok_buku' => $buku->stok_buku - $request->kuantitas
                ]);
            }

            $pembayaran = [
                'transaksi_id' => $transaksi->id,
                'tanggal_pembayaran' => date('Y-m-d H:i:s'),
                'jenis_pembayaran' => $request->pembayaran,
            ];

            if ($request->hasFile('bukti')) {
                $extension = $request->file('bukti')->getClientOriginalExtension();
                $filenamestore = $transaksi->kode_pesanan . '.' . $extension;
                $save_path = 'assets/uploads/pembayaran';

                if (!file_exists($save_path)) {
                    mkdir($save_path, 666, true);
                }

                $request->file('bukti')->move($save_path, $filenamestore);

                $pembayaran['bukti_pembayaran'] = $save_path . '/' . $filenamestore;
            }

            Pembayaran::create($pembayaran);

            clearCart();
        });
        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil disimpan',
            'title' => 'Berhasil'
        ]);
    }
}
