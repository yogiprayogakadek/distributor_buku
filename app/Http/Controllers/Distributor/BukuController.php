<?php

namespace App\Http\Controllers\Distributor;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BukuController extends Controller
{
    protected $page = 6;
    public function index(Request $request)
    {
        $kategori = Kategori::where('status', true)->pluck('nama', 'id')->toArray();
        $buku = Buku::where('status', true)->paginate($this->page);
        if ($request->ajax()) {
            return view('distributor.buku.render')->with([
                'buku' => $buku,
                'kategori' => $kategori
            ])->render();
        }
        return view('distributor.buku.index', compact('buku', 'kategori'));
    }

    public function render()
    {
        $buku = Buku::where('status', true)->paginate($this->page);

        $view = [
            'data' => view('distributor.buku.render', compact('buku'))->render(),
        ];

        return response()->json($view);
    }

    public function search($value)
    {
        if ($value != 'null') {
            $buku = Buku::where('data_buku->judul', 'LIKE', '%' . $value . '%')
                ->orWhere('data_buku->penerbit', 'LIKE', '%' . $value . '%')
                ->orWhere('data_buku->penulis', 'LIKE', '%' . $value . '%')
                ->where('status', true)
                ->where('stok_buku', '>', 0)
                ->paginate($this->page);

            return view('distributor.buku.search')->with([
                'buku' => $buku
            ])->render();
        } else {
            return view('distributor.buku.render')->with([
                'buku' => Buku::where('status', true)->paginate($this->page)
            ])->render();
        }
    }

    public function filter(Request $request) {
        $harga_dari = (int)explode(',', $request->harga)[0];
        $harga_sampai = (int)explode(',', $request->harga)[1];
        // $kategori = $request->kategori;
        // dd($harga_dari);

        if(!$request->has('kategori')) {
            $buku = Buku::where('data_buku->harga', '>=', $harga_dari)
            ->orWhere('data_buku->harga', '=<', $harga_sampai)
            ->where('status', true)
            ->where('stok_buku', '>', 0)
            ->paginate($this->page);

            return view('distributor.buku.search')->with([
                'buku' => $buku
            ])->render();
        } else {
            $buku = Buku::whereIn('kategori_id', $request->kategori)
                    ->orWhere('data_buku->harga', '=', $harga_dari)
                    ->orWhere('data_buku->harga', '=<', $harga_sampai)
                    ->where('status', true)
                    ->where('stok_buku', '>', 0)
                    ->paginate($this->page);

            return view('distributor.buku.search')->with([
                'buku' => $buku
            ])->render();
        }
    }
}
