<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MaterialRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nama_bahan' => 'required|string|max:255',
            'satuan' => 'required|string|max:255',
            'harga' => 'required|integer',
            'gambar' => 'image|mimes:jpeg,png,jpg|max:2048',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */

    public function messages(): array
    {
        return [
            'nama_bahan.required' => 'Nama Bahan harus diisi',
            'harga.required' => 'Harga harus diisi',
            'deskripsi.required' => 'Deskripsi harus diisi',
            'gambar.image' => 'Gambar harus berupa file gambar',
            'gambar.mimes' => 'Gambar harus berupa jpeg, png, jpg',
        ];
    }
}
