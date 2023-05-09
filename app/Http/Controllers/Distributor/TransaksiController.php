<?php

namespace App\Http\Controllers\Distributor;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksi = Transaksi::where('distributor_id', auth()->user()->distributor->id)->get();
        return view('distributor.transaksi.index', compact('transaksi'));
    }
}
