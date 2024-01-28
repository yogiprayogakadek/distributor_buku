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
    public function index()
    {
        return view('main.transaksi.index');
    }

    public function render()
    {
        $transaksi = Transaksi::with('distributor', 'buku', 'pembayaran')->get();

        $view = [
            'data' => view('main.transaksi.render', compact('transaksi'))->render()
        ];

        return response()->json($view);
    }

    public function update(Request $request)
    {
        try {
            $transaksi = Transaksi::find($request->id);
            $transaksi->pembayaran->update([
                'status_pembayaran' => $request->status,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Pembayaran berhasil diubah',
                'title' => 'Berhasil',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Pembayaran gagal diubah',
                'title' => 'Gagal',
            ]);
        }
    }

    public function detail($id)
    {
        $data = DB::table('detail_transaksi')
                    ->select('kategori.nama as nama_kategori', 'buku.data_buku->judul as judul', 'buku.data_buku->penerbit as penerbit', 'buku.data_buku->penulis as penulis', 'buku.data_buku->harga as harga', 'detail_transaksi.kuantitas as kuantitas')
                    ->join('buku', 'buku.id', 'detail_transaksi.buku_id')
                    ->join('kategori', 'kategori.id', 'buku.kategori_id')
                    ->where('detail_transaksi.transaksi_id', $id)
                    ->get();

        return response()->json($data);
    }

    public function print()
    {
        $transaksi = Transaksi::all();

        $view = [
            'data' => view('main.transaksi.print', compact('transaksi'))->render()
        ];

        return response()->json($view);
    }

}
