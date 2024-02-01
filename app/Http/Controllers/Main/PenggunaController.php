<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class PenggunaController extends Controller
{
    public function index()
    {
        return view('main.pengguna.index');
    }

    public function render()
    {
        // $pengguna = User::where('role', 'Admin')->orWhere('role', 'Distributor')->get();
        $pengguna = User::where('role', 'Distributor')->get();

        $view = [
            'data' => view('main.pengguna.render', compact('pengguna'))->render(),
        ];

        return response()->json($view);
    }

    public function print()
    {
        // $pengguna = User::where('role', 'Admin')->orWhere('role', 'Distributor')->get();
        $pengguna = User::where('role', 'Distributor')->get();

        $view = [
            'data' => view('main.pengguna.print', compact('pengguna'))->render(),
        ];

        return response()->json($view);
    }

    public function update(Request $request)
    {
        try {
            $user = User::find($request->id);
            $user->update([
                'is_active' => $request->status
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil di ubah',
                'title' => 'Berhasil'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan',
                'title' => 'Gagal'
            ]);
        }
    }
}
