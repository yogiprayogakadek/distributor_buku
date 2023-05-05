<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class BukuRequest extends FormRequest
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
            'kategori' => 'required',
            'kode_buku' => 'required',
            'judul' => 'required',
            'tahun_terbit' => 'required|numeric',
            'penerbit' => 'required',
            'penulis' => 'required',
            'harga' => 'required|required',
            'deskripsi' => 'required',
            'stok_buku' => 'required|numeric',
        ];

        if (!Request::instance()->has('id')) {
            $rules += [
                'status' => 'nullable',
                'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ];
        } else {
            $rules += [
                'status' => 'required',
                'foto' => 'image|mimes:jpeg,png,jpg|max:2048',
            ];
        }

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
            'kategori' => 'Kategori',
            'kode_buku' => 'Kode buku',
            'judul' => 'Judul',
            'tahun_terbit' => 'Tahun terbit',
            'penerbit' => 'Penerbit',
            'penulis' => 'Penulis',
            'harga' => 'Harga',
            'deskripsi' => 'Deskripsi',
            'stok_buku' => 'Stok buku'
        ];
    }
}
