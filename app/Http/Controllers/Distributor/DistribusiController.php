<?php

namespace App\Http\Controllers\Distributor;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\DistribusiBuku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DistribusiController extends Controller
{
    public function index()
    {
        $distribusi = DistribusiBuku::where('distributor_id', Auth::user()->distributor->id)->get();

        return view('distributor.distribusi.index', compact('distribusi'));
    }

    public function find($id)
    {
        $distribusi = DistribusiBuku::find($id);
        $data_buku = json_decode($distribusi->data_buku, true);

        foreach ($data_buku as $key => &$item) {
            $kode_buku = $data_buku[$key]['kode_buku'];

            $existing = Buku::whereJsonContains('data_buku->kode_buku', $kode_buku)->first();

            $item['penulis'] = json_decode($existing->data_buku, true)['penulis'];
            $item['judul'] = json_decode($existing->data_buku, true)['judul'];
            $item['penerbit'] = json_decode($existing->data_buku, true)['penerbit'];
            $item['harga'] = convertToRupiah(json_decode($existing->data_buku, true)['harga']);
            $item['distribusi_id'] = $distribusi->id;
        }

        // $updatedData = json_encode($data_buku);

        return response()->json($data_buku);
    }

    public function validasi(Request $request)
    {
        $distribusi = DistribusiBuku::find($request->distribusi_id);

        $data_buku = json_decode($distribusi->data_buku, true);

        foreach ($data_buku as $key => &$item) {
            $kode_buku = $data_buku[$key]['kode_buku'];

            if($kode_buku == $request->kode_buku) {
                $item['status'] = (int)$request->status;
                $item['updated_at'] = date('Y-m-d H:i:s');
            }
        }

        $distribusi->update([
            'data_buku' => json_encode($data_buku),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil di validasi',
            'title' => 'Berhasil'
        ]);
    }
}
