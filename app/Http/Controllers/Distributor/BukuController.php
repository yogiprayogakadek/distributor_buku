<?php

namespace App\Http\Controllers\Distributor;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BukuController extends Controller
{
    protected $page = 6;
    public function index(Request $request)
    {
        $buku = Buku::where('status', true)->paginate($this->page);
        if ($request->ajax()) {
            return view('distributor.buku.render')->with([
                'buku' => $buku
            ])->render();
        }
        return view('distributor.buku.index', compact('buku'));
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
            return view('dashboard.pelajar.render')->with([
                'buku' => Buku::where('status', true)->paginate($this->page)
            ])->render();
        }
    }
}
