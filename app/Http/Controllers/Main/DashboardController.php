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

    public function chartByKategori()
    {
        $data = DB::table('detail_transaksi')
                    ->selectRaw('kategori.nama as nama_kategori, SUM(detail_transaksi.kuantitas) as jumlah_transaksi')
                    ->join('buku', 'buku.id', 'detail_transaksi.buku_id')
                    ->join('kategori', 'kategori.id', 'buku.kategori_id')
                    ->where('kategori.status', true)
                    ->groupBy('kategori.id')
                    ->get();

        return response()->json($data);
    }
}
