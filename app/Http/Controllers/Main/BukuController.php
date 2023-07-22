<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Http\Requests\BukuRequest;
use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    public function index()
    {
        return view('main.buku.index');
    }

    public function render()
    {
        $buku = Buku::all();

        $view = [
            'data' => view('main.buku.render', compact('buku'))->render(),
        ];

        return response()->json($view);
    }

    public function create()
    {
        $kategori = Kategori::where('status', true)->pluck('nama', 'id')->prepend('Pilih kategori...', '');
        $view = [
            'data' => view('main.buku.create', compact('kategori'))->render(),
        ];

        return response()->json($view);
    }

    public function store(BukuRequest $request)
    {
        try {
            $json = [
                'kode_buku' => $request->kode_buku,
                'judul' => $request->judul,
                'tahun_terbit' => $request->tahun_terbit,
                'penerbit' => $request->penerbit,
                'penulis' => $request->penulis,
                'harga' => preg_replace('/[^0-9]/', '', $request->harga),
                'deskripsi' => $request->deskripsi,
            ];

            if ($request->hasFile('foto')) {
                $extension = $request->file('foto')->getClientOriginalExtension();
                $filenamestore = $request->kode_buku . '.' . $extension;
                $save_path = 'assets/uploads/buku';

                if (!file_exists($save_path)) {
                    mkdir($save_path, 666, true);
                }

                $request->file('foto')->move($save_path, $filenamestore);

                $json['foto'] = $save_path . '/' . $filenamestore;
            }

            $data = [
                'kategori_id' => $request->kategori,
                'data_buku' => json_encode($json),
                'stok_buku' => $request->stok_buku
            ];

            Buku::create($data);

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

    public function edit($id)
    {
        $buku = Buku::find($id);
        $kategori = Kategori::where('status', true)->pluck('nama', 'id')->prepend('Pilih kategori...', '');
        $view = [
            'data' => view('main.buku.edit', compact('buku', 'kategori'))->render()
        ];

        return response()->json($view);
    }

    public function update(BukuRequest $request)
    {
        try {
            $buku = Buku::find($request->id);
            $json = [
                'kode_buku' => $request->kode_buku,
                'judul' => $request->judul,
                'tahun_terbit' => $request->tahun_terbit,
                'penerbit' => $request->penerbit,
                'penulis' => $request->penulis,
                'harga' => preg_replace('/[^0-9]/', '', $request->harga),
                'deskripsi' => $request->deskripsi,
            ];

            if ($request->hasFile('foto')) {
                unlink(json_decode($buku->data_buku, true)['foto']);
                $extension = $request->file('foto')->getClientOriginalExtension();
                $filenamestore = $request->kode_buku . '.' . $extension;
                $save_path = 'assets/uploads/buku';

                if (!file_exists($save_path)) {
                    mkdir($save_path, 666, true);
                }

                $request->file('foto')->move($save_path, $filenamestore);

                $json['foto'] = $save_path . '/' . $filenamestore;
            } else {
                $json['foto'] = json_decode($buku->data_buku, true)['foto'];
            }

            $data = [
                'kategori_id' => $request->kategori,
                'data_buku' => json_encode($json),
                'stok_buku' => $request->stok_buku,
                'status' => $request->status
            ];

            $buku->update($data);

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
        $buku = Buku::all();

        $view = [
            'data' => view('main.buku.print', compact('buku'))->render(),
        ];

        return response()->json($view);
    }
}
