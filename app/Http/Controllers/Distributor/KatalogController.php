<?php

namespace App\Http\Controllers\Distributor;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\DistribusiBuku;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KatalogController extends Controller
{
    protected $page = 6;
    protected $data = [];
    protected $sums = [];
    protected $kodeBuku = [];

    private function bookList()
    {
        // get list book in distribusi_buku table

        // $data = [];
        $distribusi = DistribusiBuku::where('distributor_id', auth()->user()->distributor->id)->get();



        foreach ($distribusi as $key => $value) {
            $data_buku = json_decode($value->data_buku, true);

            foreach ($data_buku as $index => $item) {
                if ($item['status'] == true && $item['terjual'] == 0) {
                    $kode_buku_item = $item['kode_buku'];

                    // If the kode_buku already exists in the sums array, add the kuantitas
                    if (isset($sums[$kode_buku_item])) {
                        $this->sums[$kode_buku_item] += $item['kuantitas'];
                    } else {
                        // If it doesn't exist, initialize it with the kuantitas value
                        $this->sums[$kode_buku_item] = $item['kuantitas'];
                    }
                }
            }
        }

        foreach ($this->sums as $kode_buku_item => $kuantitas_sum) {
            $this->data[] = [
                'kode_buku' => $kode_buku_item,
                'kuantitas' => $kuantitas_sum,
            ];

            $this->kodeBuku[] = $kode_buku_item;
        }
        // dd($this->data);
    }

    public function index(Request $request)
    {
        // $this->bookList();
        $kategori = Kategori::where('status', true)->pluck('nama', 'id')->toArray();
        // $buku = Buku::where('status', true)->whereIn('data_buku->kode_buku', $this->kodeBuku)->paginate($this->page);

        $buku = Buku::where('status', true)->paginate($this->page);
        // dd($buku);
        if ($request->ajax()) {
            return view('distributor.katalog.render')->with([
                'buku' => $buku,
                'kategori' => $kategori
            ])->render();
        }
        return view('distributor.katalog.index', compact('buku', 'kategori'));
    }

    public function render()
    {
        // $this->bookList();
        // $buku = Buku::where('status', true)->whereIn('data_buku->kode_buku', $this->kodeBuku)->paginate($this->page);

        $buku = Buku::where('status', true)->paginate($this->page);
        $view = [
            'data' => view('distributor.katalog.render', compact('buku'))->render(),
        ];

        return response()->json($view);
    }

    // public function search($value)
    // {
    //     $this->bookList();
    //     if ($value != 'null') {
    //         $buku = Buku::where(function ($query) use ($value) {
    //             $query->where('data_buku->judul', 'LIKE', '%' . $value . '%')
    //                 ->orWhere('data_buku->penerbit', 'LIKE', '%' . $value . '%')
    //                 ->orWhere('data_buku->penulis', 'LIKE', '%' . $value . '%');
    //         })
    //             ->where('status', true)
    //             ->whereIn('data_buku->kode_buku', $this->kodeBuku)
    //             ->paginate($this->page);


    //         return view('distributor.katalog.search')->with([
    //             'buku' => $buku
    //         ])->render();
    //     } else {
    //         return view('distributor.katalog.render')->with([
    //             'buku' => Buku::where('status', true)->whereIn('data_buku->kode_buku', $this->kodeBuku)->paginate($this->page)
    //         ])->render();
    //     }
    // }

    public function search($value)
    {
        if ($value != 'null') {
            $buku = Buku::where('data_buku->judul', 'LIKE', '%' . $value . '%')
                ->orWhere('data_buku->penerbit', 'LIKE', '%' . $value . '%')
                ->orWhere('data_buku->penulis', 'LIKE', '%' . $value . '%')
                ->where('status', true)
                ->where('stok_buku', '>', 0)
                ->paginate($this->page);

            return view('distributor.katalog.search')->with([
                'buku' => $buku
            ])->render();
        } else {
            return view('distributor.katalog.render')->with([
                'buku' => Buku::where('status', true)->paginate($this->page)
            ])->render();
        }
    }

    public function filter(Request $request)
    {
        $harga_dari = (int)explode(',', $request->harga)[0];
        $harga_sampai = (int)explode(',', $request->harga)[1];
        // $kategori = $request->kategori;
        // dd($harga_dari);

        if (!$request->has('kategori')) {
            $buku = Buku::where('data_buku->harga', '>=', $harga_dari)
                ->orWhere('data_buku->harga', '=<', $harga_sampai)
                ->where('status', true)
                ->where('stok_buku', '>', 0)
                ->paginate($this->page);

            return view('distributor.katalog.search')->with([
                'buku' => $buku
            ])->render();
        } else {
            $buku = Buku::whereIn('kategori_id', $request->kategori)
                ->orWhere('data_buku->harga', '=', $harga_dari)
                ->orWhere('data_buku->harga', '=<', $harga_sampai)
                ->where('status', true)
                ->where('stok_buku', '>', 0)
                ->paginate($this->page);

            return view('distributor.katalog.search')->with([
                'buku' => $buku
            ])->render();
        }
    }
}
