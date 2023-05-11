<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class AuthRequest extends FormRequest
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
            'email' => 'required|email',
            'password' => 'required',
        ];

        if (strpos($this->url(), '/signup') == false) {
            $rules += [
                'nama' => 'required',
                'jenis_kelamin' => 'required',
                'telp' => 'required|numeric',
                'username' => 'required',
                'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
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
            'email' => ':attribute salah format'
        ];
    }

    public function attributes()
    {
        return [
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
