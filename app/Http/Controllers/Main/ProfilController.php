<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfilRequest;
use App\Models\Distributor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProfilController extends Controller
{
    public function index()
    {
        $user = User::with('distributor')->where('id', auth()->user()->id)->first();
        return view('main.profil.index', compact('user'));
    }

    public function update(ProfilRequest $request)
    {
        DB::transaction(function () use ($request) {
            $user = User::find(auth()->user()->id);
            $data = [
                'nama' => $request->nama,
                'jenis_kelamin' => $request->jenis_kelamin,
                'telp' => $request->telp,
                'username' => $request->username,
                'email' => $request->email,
            ];

            if ($request->password != '') {
                $data['password'] = Hash::make($request->password);
            }

            if ($request->hasFile('foto')) {
                unlink($user->foto);
                $extension = $request->file('foto')->getClientOriginalExtension();
                $filenamestore = str_replace(' ', '', $request->nama) . '.' . $extension;
                $save_path = 'assets/uploads/users/distributor';

                if (!file_exists($save_path)) {
                    mkdir($save_path, 666, true);
                }

                $request->file('foto')->move($save_path, $filenamestore);

                $data['foto'] = $save_path . '/' . $filenamestore;
            }

            // User
            if ($data != null) {
                $user->update($data);
            }

            Distributor::updateOrCreate(
                ['user_id' => auth()->user()->id],
                [
                    'user_id' => auth()->user()->id,
                    'nama_pt' => $request->nama_pt,
                    'alamat_pt' => $request->alamat,
                ]
            );
        });
        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil disimpan',
            'title' => 'Berhasil'
        ]);
    }
}
