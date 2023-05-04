<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Http\Requests\TransaksiRequest;
use App\Models\Buku;
use App\Models\DetailTransaksi;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    protected function kodePesanan()
    {
        return 'trans-'. time();
    }

    public function index()
    {
        return view('main.transaksi.index');
    }

    public function search($slug)
    {
        $buku = Buku::whereJsonContains('data_buku.judul', '%' . $slug . '%')
                    ->orWhereJsonContains('data_buku.penerbit', '%' . $slug . '%')
                    ->orWhereJsonContains('data_buku.penulis', '%' . $slug . '%')
                    ->where('status', true)->get();

        return response()->json($buku);
    }

    public function checkout(TransaksiRequest $request)
    {
        DB::transaction(function() use($request) {
            $dataTransaksi = [
                'kode_pesanan' => $this->kodePesanan(),
                'tanggal_pesanan' => date('Y-m-d H:i:s'),
                'distributor_id' => auth()->user()->distributor->id,
                'total' => preg_replace('/[^0-9]/', '', $request->total),
            ];
            $transaksi = Transaksi::create($dataTransaksi);

            foreach(cart() as $cart) {
                $buku = Buku::find($cart->id);
                $dataDetailTransaki = [
                    'transaksi_id' => $transaksi->id,
                    'buku_id' => $buku->id,
                    'kuantitas' => $request->kuantitas
                ];

                DetailTransaksi::create($dataDetailTransaki);

                // update stok
                $buku->update([
                    'stok_buku' => $buku->stok_buku - $request->kuantitas
                ]);
            }

            clearCart();

        });
        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil disimpan',
            'title' => 'Berhasil'
        ]);
    }

}
