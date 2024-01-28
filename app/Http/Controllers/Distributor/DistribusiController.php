<?php

namespace App\Http\Controllers\Distributor;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\DistribusiBuku;
use App\Models\Pembayaran;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DistribusiController extends Controller
{
    protected function kodeTransaksi()
    {
        return 'trans-' . time();
    }

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
        try {
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
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                // 'message' => $e->getMessage(),
                'message' => 'Terjadi kesalahan',
                'title' => 'Gagal'
            ]);
        }
    }

    public function transaksiStore(Request $request)
    {
        try {
            DB::beginTransaction();
            // Update on distribusi buku
            $distribusi = DistribusiBuku::find($request->distribusi_id);
            $data_buku = json_decode($distribusi->data_buku, true);
            $buku = Buku::whereJsonContains('data_buku->kode_buku', $request->kode_buku)->first();

            $terjual = 0;

            foreach ($data_buku as $key => &$item) {
                if($item['kode_buku'] == $request->kode_buku) {
                    $item['kembali'] = (int)$request->pengembalian;
                    $item['terjual'] = $item['kuantitas'] - $request->pengembalian;
                    $terjual = $item['terjual'];
                }
            }

            $distribusi->update([
                'data_buku' => json_encode($data_buku),
            ]);

            // insert on transaksi table
            $transaksi = Transaksi::create([
                'kode_transaksi' => $this->kodeTransaksi(),
                'tanggal_transaksi' => date('Y-m-d'),
                'distributor_id' => $distribusi->distributor_id,
                'distribusi_buku_id' => $distribusi->id,
                'buku_id' =>  $buku->id,
                'total_pengembalian' => $request->pengembalian,
                'total_pembayaran' => (json_decode($buku->data_buku, true)['harga'] * $terjual)
            ]);

            $pembayaran = Pembayaran::create([
                'transaksi_id' => $transaksi->id,
                'tanggal_pembayaran' => date('Y-m-d'),
                'jenis_pembayaran' => null,
                'bukti_pembayaran' => null,
                'status_pembayaran' => 'Belum dibayar',
                'total_pembayaran' => (json_decode($buku->data_buku, true)['harga'] * $terjual)
            ]);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil di proses',
                'title' => 'Berhasil'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
                // 'message' => 'Terjadi kesalahan',
                'title' => 'Gagal'
            ]);
        }
    }
}
