<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfilRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = [
            'nama_pt' => 'required',
            'alamat' => 'required',
            'nama' => 'required',
            'jenis_kelamin' => 'required',
            'telp' => 'required|numeric',
            'username' => 'required',
            'email' => 'required',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'required' => ':attribute tidak boleh kosong',
            'mimes' => ':attribute harus berupa file :values',
            'image' => ':attribute harus berupa file gambar',
            'date' => ':attribute harus berupa tanggal',
            'numeric' => ':attribute harus berupa angka',
        ];
    }

    public function attributes()
    {
        return [
            'nama_pt' => 'Nama PT.',
            'alamat' => 'Alamat PT.',
            'nama' => 'Nama',
            'jenis_kelamin' => 'Jenis kelamin',
            'telp' => 'No. telp',
            'username' => 'Username',
            'password' => 'Password',
            'email' => 'Email',
            'foto' => 'Foto',
        ];
    }
}
