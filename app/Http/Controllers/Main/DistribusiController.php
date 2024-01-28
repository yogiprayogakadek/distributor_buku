<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\DistribusiBuku;
use App\Models\Distributor;
use Illuminate\Http\Request;

class DistribusiController extends Controller
{
    public function index()
    {
        return view('main.distribusi.index');
    }

    public function render()
    {
        $distribusi = DistribusiBuku::groupBy('tanggal_distribusi')->get();

        $view = [
            'data' => view('main.distribusi.render', compact('distribusi'))->render(),
        ];

        return response()->json($view);
    }

    public function create()
    {
        $buku = Buku::where('status', true)->get();
        $view = [
            'data' => view('main.distribusi.create', compact('buku'))->render(),
        ];

        return response()->json($view);
    }

    public function store(Request $request)
    {
        try {
            $data_buku = [];
            foreach($request->kode_buku as $kode_buku) {
                $buku = Buku::whereJsonContains('data_buku->kode_buku', $kode_buku)->first();
                $data_buku[] = [
                    'kode_buku' => $kode_buku,
                    'status' => false,
                    'total_buku' => $buku->stok_buku,
                    'terjual' => null,
                    'kembali' => null,
                    'kuantitas' => 10,
                    'updated_at' => null
                ];
            }

            //     DistribusiBuku::create([
            //         'distributor_id' => $item->id,
            //         'data_buku' => json_encode($data_buku),
            //         'tanggal_distribusi' => date('Y-m-d')
            //     ]);

            $distributor = Distributor::all();
            foreach($distributor as $key => $item) {
                DistribusiBuku::create([
                    'distributor_id' => $item->id,
                    'data_buku' => json_encode($data_buku),
                    'tanggal_distribusi' => date('Y-m-d')
                ]);
            }


            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil disimpan',
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


//     Distribusi Buku
//  - id (pk)
//  - distributor_id (fk)
//  - data_buku (json) => id_buku, status, total_buku, terjual, kembali
//  - tanggal_distribusi (date)


}
