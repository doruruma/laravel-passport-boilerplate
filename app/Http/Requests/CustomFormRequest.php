<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomFormRequest extends FormRequest
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
            'max' => ':attribute tidak boleh melebihi 255 karakter',
            'required' => ':attribute tidak boleh kosong',
            'present' => 'Form harus mengandung :attribute',
            'confirmed' => 'Konfirmasi :attribute tidak sesuai',
            'integer' => ':attribute harus berupa bilangan bulat',
            'numeric' => ':attribute harus berupa angka',
            'date' => ':attribute harus berupa tanggal',
            'email' => 'Format email tidak valid',
            'array' => ':attribute harus berupa array'
        ];
    }
}
