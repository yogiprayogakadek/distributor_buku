<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Http\Requests\TransaksiRequest;
use App\Models\Buku;
use App\Models\DetailTransaksi;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function index()
    {
        return view('main.transaksi.index');
    }

    public function render()
    {
        $transaksi = Transaksi::all();

        $view = [
            'data' => view('main.transaksi.render', compact('transaksi'))->render()
        ];

        return response()->json($view);
    }

    public function update(Request $request)
    {
        try {
            $transaksi = Transaksi::find($request->id);
            $transaksi->update([
                'status_pesanan' => $request->status,
                'keterangan' => $request->keterangan,
                'user_id' => auth()->user()->id
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Transaksi berhasil diubah',
                'title' => 'Berhasil',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Transaksi gagal diubah',
                'title' => 'Gagal',
            ]);
        }
    }

}
