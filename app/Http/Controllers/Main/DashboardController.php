<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\DistribusiBuku;
use App\Models\Distributor;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // $distribusi = DistribusiBuku::all();
        // $total = [];

        // foreach ($distribusi as $distribusi) {
        //     $data_buku = json_decode($distribusi->data_buku, true);

        //     foreach ($data_buku as &$data) {
        //         if ($data['status'] == true) {
        //             $kodeBuku = $data['kode_buku'];

        //             $buku = Buku::whereJsonContains('data_buku->kode_buku', $kodeBuku)->first();

        //             $terjual = $data['terjual'] ?? 0;

        //             if (!isset($total[$buku->kategori->nama])) {
        //                 $total[$buku->kategori->nama] = [
        //                     // 'kode_buku' => $kodeBuku,
        //                     'kategori' => $buku->kategori->nama,
        //                     'total' => 0,
        //                 ];
        //             }

        //             $total[$buku->kategori->nama]['total'] += $terjual;
        //         }
        //     }
        // }

        // $totalValues = array_values($total);

        return view('main.dashboard.index');
    }

    public function chartByKategori(Request $request)
    {
        if ($request->kategori == 'Kategori') {
            $distribusi = DistribusiBuku::whereBetween('tanggal_distribusi', [$request->awal, $request->akhir])->get();
            $total = [];

            foreach ($distribusi as $distribusi) {
                $data_buku = json_decode($distribusi->data_buku, true);

                foreach ($data_buku as &$data) {
                    if ($data['status'] == true) {
                        $kodeBuku = $data['kode_buku'];

                        $buku = Buku::whereJsonContains('data_buku->kode_buku', $kodeBuku)->first();

                        $terjual = $data['terjual'] ?? 0;

                        if (!isset($total[$buku->kategori->nama])) {
                            $total[$buku->kategori->nama] = [
                                // 'kode_buku' => $kodeBuku,
                                'kategori' => $buku->kategori->nama,
                                'total' => 0,
                            ];
                        }

                        $total[$buku->kategori->nama]['total'] += $terjual;
                    }
                }
            }

            $totalValues = array_values($total);
        } elseif($request->kategori == 'Transaksi') {
            $transaksi = Transaksi::whereBetween('tanggal_transaksi', [$request->awal, $request->akhir])->with('pembayaran')->get();
            $total = [];

            foreach($transaksi as $transaksi) {
                $buku = Buku::find($transaksi->buku_id);

                if($transaksi->pembayaran->status_pembayaran == 'Diterima') {
                    $total_transaksi = $transaksi->total_pembayaran ?? 0;
                    if (!isset($total[$buku->kategori->nama])) {
                        $total[$buku->kategori->nama] = [
                            // 'kode_buku' => $kodeBuku,
                            'kategori' => $buku->kategori->nama,
                            'total' => 0,
                        ];
                    }

                    $total[$buku->kategori->nama]['total'] += $total_transaksi;
                }
            }
            $totalValues = array_values($total);
        } else {
            $distribusi = DistribusiBuku::whereBetween('tanggal_distribusi', [$request->awal, $request->akhir])->get();
            $total = [];

            foreach ($distribusi as $distribusi) {
                $data_buku = json_decode($distribusi->data_buku, true);

                foreach ($data_buku as &$data) {
                    if ($data['status'] == true && $data['terjual'] > 0) {
                        $kodeBuku = $data['kode_buku'];

                        $distributor = Distributor::find($distribusi->distributor_id);

                        $terjual = $data['terjual'] ?? 0;

                        if (!isset($total[$distributor->nama_pt])) {
                            $total[$distributor->nama_pt] = [
                                // 'kode_buku' => $kodeBuku,
                                'kategori' => $distributor->nama_pt,
                                'total' => 0,
                            ];
                        }

                        $total[$distributor->nama_pt]['total'] += $terjual;
                    }
                }
            }

            $totalValues = array_values($total);
        }

        // dd($totalValues);

        return response()->json($totalValues);
    }
}
