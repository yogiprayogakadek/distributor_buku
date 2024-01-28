<?php

namespace App\Http\Controllers\Distributor;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\DistribusiBuku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ListDistribusiController extends Controller
{
    public function index()
    {
        $list = DistribusiBuku::where('distributor_id', Auth::user()->distributor->id)->get();
        $data = [];

        foreach($list as $list) {
            $data_buku = json_decode($list->data_buku, true);
            // dd($data_buku);
            foreach($data_buku as $key => $data_buku) {
                if($data_buku['status'] == true) {
                    $buku = Buku::whereJsonContains('data_buku->kode_buku', $data_buku['kode_buku'])->first();
                    $buku_json = json_decode($buku->data_buku, true);
                    $data[] = [
                        'distribusi_id' => $list->id,
                        'kode_buku' => $buku_json['kode_buku'],
                        'judul' => $buku_json['judul'],
                        'harga' => convertToRupiah($buku_json['harga']),
                        'kuantitas' => $data_buku['kuantitas'],
                        'tanggal_distribusi' => $list->tanggal_distribusi,
                        'terjual' => $data_buku['terjual'],
                        'kembali' => $data_buku['kembali'],
                    ];
                }
            }
        }

        return view('distributor.list-distribusi.index', compact('data'));
    }
}
