<?php

namespace App\Http\Controllers\Distributor;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksi = Transaksi::where('distributor_id', auth()->user()->distributor->id)->get();
        return view('distributor.transaksi.index', compact('transaksi'));
    }

    public function pembayaran(Request $request)
    {
        try {
            $transaksi = Transaksi::find($request->transaksi_id);

            $data = [
                'jenis_pembayaran' => $request->jenis_pembayaran,
                'status_pembayaran' => 'Menunggu Konfirmasi'
            ];

            if ($request->hasFile('bukti_pembayaran')) {
                $extension = $request->file('bukti_pembayaran')->getClientOriginalExtension();
                $filenamestore = $transaksi->kode_transaksi . '.' . $extension;
                $save_path = 'assets/uploads/pembayaran';

                if (!file_exists($save_path)) {
                    mkdir($save_path, 666, true);
                }

                $request->file('bukti_pembayaran')->move($save_path, $filenamestore);

                $data['bukti_pembayaran'] = $save_path . '/' . $filenamestore;
            }

            $transaksi->pembayaran->update($data);

            return response()->json([
                'status' => 'success',
                'message' => 'Pembayaran berhasil diproses',
                'title' => 'Berhasil'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
                // 'message' => 'Terjadi kesalahan',
                'title' => 'Gagal'
            ]);
        }
    }

    public function detail($id)
    {
        $data = DB::table('detail_transaksi')
                    ->select('kategori.nama as nama_kategori', 'buku.data_buku->judul as judul', 'buku.data_buku->penerbit as penerbit', 'buku.data_buku->penulis as penulis', 'buku.data_buku->harga as harga', 'detail_transaksi.kuantitas as kuantitas')
                    ->join('buku', 'buku.id', 'detail_transaksi.buku_id')
                    ->join('kategori', 'kategori.id', 'buku.kategori_id')
                    ->join('transaksi', 'transaksi.id', 'detail_transaksi.transaksi_id')
                    ->where('detail_transaksi.transaksi_id', $id)
                    ->where('transaksi.distributor_id', auth()->user()->distributor->id)
                    ->get();

        return response()->json($data);
    }

    public function print()
    {
        $transaksi = Transaksi::where('distributor_id', auth()->user()->distributor->id)->get();

        $view = [
            'data' => view('distributor.transaksi.print', compact('transaksi'))->render()
        ];

        return response()->json($view);
    }
}
