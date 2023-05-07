<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SignupController extends Controller
{
    public function index()
    {
        return view('auth.signup');
    }

    public function signup(AuthRequest $request)
    {
        try {
            $data = [
                'nama' => $request->nama,
                'jenis_kelamin' => $request->jenis_kelamin,
                'telp' => $request->telp,
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'email' => $request->email,
                'role' => 'Distributor',
            ];

            if ($request->hasFile('foto')) {
                $extension = $request->file('foto')->getClientOriginalExtension();
                $filenamestore = str_replace(' ', '', $request->nama) . '.' . $extension;
                $save_path = 'assets/uploads/users/distributor';

                if (!file_exists($save_path)) {
                    mkdir($save_path, 666, true);
                }

                $request->file('foto')->move($save_path, $filenamestore);

                $data['foto'] = $save_path . '/' . $filenamestore;
            }

            User::create($data);

            return redirect()->route('login')->with([
                'status' => 'success',
                'title' => 'Success',
                'message' => 'Berhasil daftar, silahkan login untuk melanjutkan'
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with([
                'status' => 'error',
                'title' => 'Gagal',
                'message' => $e->getMessage()
                // 'message' => 'Terjadi kesalahan mohon coba lagi'
            ]);
        }
    }
}
