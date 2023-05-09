<?php

namespace App\Http\Controllers\Distributor;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    public function index()
    {
        $transaksi = Transaksi::where('distributor_id', auth()->user()->distributor->id)->pluck('id');
        $pembayaran = Pembayaran::whereIn('transaksi_id', $transaksi)->get();
        return view('distributor.pembayaran.index', compact('pembayaran'));
    }
}
