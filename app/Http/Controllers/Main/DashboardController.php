<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        return view('main.dashboard.index');
    }

    public function chartByKategori(Request $request)
    {
        if ($request->kategori == 'Kategori') {
            $sum = 'kategori.nama as nama_kategori, SUM(detail_transaksi.kuantitas) as jumlah_transaksi';
        } else {
            $sum = 'kategori.nama as nama_kategori, SUM(transaksi.total) as jumlah_transaksi';
        }

        $data = DB::table('detail_transaksi')
            ->selectRaw($sum)
            ->join('buku', 'buku.id', 'detail_transaksi.buku_id')
            ->join('kategori', 'kategori.id', 'buku.kategori_id')
            ->join('transaksi', 'transaksi.id', 'detail_transaksi.transaksi_id')
            ->join('pembayaran', 'pembayaran.transaksi_id', 'transaksi.id')
            ->whereBetween('transaksi.tanggal_pesanan', [$request->awal, $request->akhir])
            ->where('kategori.status', true)
            ->where('pembayaran.status_pembayaran', 'Diterima')
            ->when(auth()->user()->role == 'Distributor', function ($query) {
                return $query->where('transaksi.distributor_id', auth()->user()->distributor->id);
            })
            ->groupBy('kategori.id')
            ->get();

        return response()->json($data);
    }
}
