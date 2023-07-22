<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Http\Requests\KategoriRequest;
use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        return view('main.kategori.index');
    }

    public function render()
    {
        $kategori = Kategori::all();

        $view = [
            'data' => view('main.kategori.render', compact('kategori'))->render(),
        ];

        return response()->json($view);
    }

    public function create()
    {
        $view = [
            'data' => view('main.kategori.create')->render(),
        ];

        return response()->json($view);
    }

    public function store(KategoriRequest $request)
    {
        try {
            $data = [
                'nama' => $request->nama,
            ];

            Kategori::create($data);

            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil disimpan',
                'title' => 'Berhasil'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                // 'message' => $e->getMessage(),
                'message' => 'Terjadi kesalahan',
                'title' => 'Gagal'
            ]);
        }
    }

    public function edit($id)
    {
        $kategori = Kategori::find($id);
        $view = [
            'data' => view('main.kategori.edit', compact('kategori'))->render()
        ];

        return response()->json($view);
    }

    public function update(KategoriRequest $request)
    {
        try {
            $kategori = Kategori::find($request->id);
            $data = [
                'nama' => $request->nama,
                'status' => $request->status,
            ];

            $kategori->update($data);

            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil disimpan',
                'title' => 'Berhasil'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                // 'message' => 'Terjadi kesalahan',
                'message' => 'Terjadi kesalahan',
                'title' => 'Gagal'
            ]);
        }
    }

    public function print()
    {
        $kategori = Kategori::all();

        $view = [
            'data' => view('main.kategori.print', compact('kategori'))->render(),
        ];

        return response()->json($view);
    }

}
