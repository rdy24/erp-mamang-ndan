<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BomRequest extends FormRequest
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
            'id_produk' => 'required',
            'id_bahan' => 'required',
            'jumlah' => 'required',
            'satuan' => 'required',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'id_produk.required' => 'Produk harus diisi',
            'id_bahan.required' => 'Bahan harus diisi',
            'jumlah.required' => 'Jumlah harus diisi',
            'satuan.required' => 'Satuan harus diisi',
        ];
    }
}
