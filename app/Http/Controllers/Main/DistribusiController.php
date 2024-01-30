<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\DistribusiBuku;
use App\Models\Distributor;
use App\Models\User;
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
            // $data_buku = [];
            // foreach ($request->kode_buku as $kode_buku) {
            //     $buku = Buku::whereJsonContains('data_buku->kode_buku', $kode_buku)->first();
            //     $data_buku[] = [
            //         'kode_buku' => $kode_buku,
            //         'status' => false,
            //         'total_buku' => $buku->stok_buku,
            //         'terjual' => null,
            //         'kembali' => null,
            //         'kuantitas' => 10,
            //         'updated_at' => null
            //     ];
            // }

            // $distributor = Distributor::all();
            // foreach ($distributor as $key => $item) {
            //     DistribusiBuku::create([
            //         'distributor_id' => $item->id,
            //         'data_buku' => json_encode($data_buku),
            //         'tanggal_distribusi' => date('Y-m-d')
            //     ]);
            // }


            // NEW
            $data_buku = [];
            $originalArray = json_decode($request->data_buku, true);
            $finalArray = collect($originalArray)->flatMap(function ($item) {
                return collect($item['data'])->map(function ($data) use ($item) {
                    return [
                        'distributorId' => $data['distributorId'],
                        'data_buku' => [
                            'kodeBuku' => $item['kodeBuku'],
                            'jumlah' => $data['jumlah'],
                        ],
                    ];
                });
            })->groupBy('distributorId')->map(function ($items, $distributorId) {
                return [
                    'distributorId' => $distributorId,
                    'data_buku' => collect($items)->map(function ($item) {
                        return [
                            'kodeBuku' => $item['data_buku']['kodeBuku'],
                            'jumlah' => $item['data_buku']['jumlah'],
                        ];
                    })->all(),
                ];
            })->values()->all();


            foreach ($finalArray as $index => $distributorData) {
                foreach ($distributorData['data_buku'] as $key => $value) {
                    $buku = Buku::whereJsonContains('data_buku->kode_buku', $value['kodeBuku'])->first();
                    $data_buku[] = [
                        'kode_buku' => $value['kodeBuku'],
                        'status' => false,
                        'total_buku' => $buku->stok_buku,
                        'terjual' => null,
                        'kembali' => null,
                        'kuantitas' => $value['jumlah'],
                        'updated_at' => null
                    ];
                }
                DistribusiBuku::create([
                    'distributor_id' => $distributorData['distributorId'],
                    'data_buku' => json_encode($data_buku),
                    'tanggal_distribusi' => date('Y-m-d')
                ]);
            }
            // dd($data_buku);



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

    public function detail($date)
    {
        $new_date = str_replace('a', '-', $date);
        $distribusi = DistribusiBuku::where('tanggal_distribusi', $new_date)->pluck('distributor_id')->toArray();
        // dd($distribusi);
        $distributor = Distributor::whereIn('id', $distribusi)->get();
        $view = [
            'data' => view('main.distribusi.detail', compact('distributor'))->render()
        ];

        return response()->json($view);
    }

    public function listBuku($param)
    {
        $params = explode('id', str_replace('a', '-', $param));
        // dd($param);
        $distribusi = DistribusiBuku::where('distributor_id', str_replace('id', '', $params[1]))->where('tanggal_distribusi', $params['0'])->first();
        // dd($distribusi);
        $data_buku = json_decode($distribusi->data_buku, true);

        foreach ($data_buku as $key => &$item) {
            $kode_buku = $data_buku[$key]['kode_buku'];

            $existing = Buku::whereJsonContains('data_buku->kode_buku', $kode_buku)->first();

            $item['penulis'] = json_decode($existing->data_buku, true)['penulis'];
            $item['judul'] = json_decode($existing->data_buku, true)['judul'];
            $item['penerbit'] = json_decode($existing->data_buku, true)['penerbit'];
            $item['harga'] = convertToRupiah(json_decode($existing->data_buku, true)['harga']);
            $item['distribusi_id'] = $distribusi->id;
        }

        $view = [
            'data' => view('main.distribusi.list-buku')->with([
                'distribusi' => $data_buku,
                'distributor' => $distribusi->distributor->nama_pt
            ])->render()
        ];

        return response()->json($view);
    }

    public function listDistributor()
    {
        $distributor = User::with('distributor')->where('is_active', true)->where('role', 'Distributor')->get();

        return response()->json($distributor);
    }


    //     Distribusi Buku
    //  - id (pk)
    //  - distributor_id (fk)
    //  - data_buku (json) => id_buku, status, total_buku, terjual, kembali
    //  - tanggal_distribusi (date)


}
