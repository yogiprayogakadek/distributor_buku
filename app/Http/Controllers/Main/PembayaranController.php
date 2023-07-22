<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\DetailTransaksi;
use App\Models\Pembayaran;
use Darryldecode\Cart\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PembayaranController extends Controller
{
    public function index()
    {
        return view('main.pembayaran.index');
    }

    public function render()
    {
        $pembayaran = Pembayaran::all();

        $view = [
            'data' => view('main.pembayaran.render', compact('pembayaran'))->render()
        ];

        return response()->json($view);
    }

    public function update(Request $request)
    {
        try {
            DB::beginTransaction();

            // get data pembayaran
            $pembayaran = Pembayaran::find($request->id);

            // get data detail transaksi
            if($request->status == 'Diterima') {
                $detail = DetailTransaksi::where('transaksi_id', $pembayaran->transaksi_id)->get();
                foreach ($detail as $d) {
                    $buku = Buku::find($d->buku_id);
                    // dd($buku->stok_buku - $d->kuantitas);
                    $buku->update([
                        'stok_buku' => $buku->stok_buku - $d->kuantitas
                    ]);
                }
            }

            // update pembayaran
            $pembayaran->update([
                'status_pembayaran' => $request->status,
                'keterangan' => $request->keterangan,
                'user_id' => auth()->user()->id
            ]);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Pembayaran berhasil diubah',
                'title' => 'Berhasil',
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
                // 'message' => 'Pembayaran gagal diubah',
                'title' => 'Gagal',
            ]);
        }
    }

    public function print()
    {
        $pembayaran = Pembayaran::all();

        $view = [
            'data' => view('main.pembayaran.print', compact('pembayaran'))->render()
        ];

        return response()->json($view);
    }

}

