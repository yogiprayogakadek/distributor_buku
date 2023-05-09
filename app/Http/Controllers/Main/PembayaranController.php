<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    public function index()
    {
        return view('main.pembayaran.index');
    }

    public function render()
    {
        $pembayaran = Pembayaran::all();

        $view = [
            'data' => view('main.pembayaran.render', compact('pembayaran'))->render()
        ];

        return response()->json($view);
    }

    public function update(Request $request)
    {
        try {
            $pembayaran = Pembayaran::find($request->id);
            $pembayaran->update([
                'status_pembayaran' => $request->status,
                'keterangan' => $request->keterangan,
                'user_id' => auth()->user()->id
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Pembayaran berhasil diubah',
                'title' => 'Berhasil',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Pembayaran gagal diubah',
                'title' => 'Gagal',
            ]);
        }
    }

}

