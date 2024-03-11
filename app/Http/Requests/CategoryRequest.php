<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
        return [
            'name' => ['required', 'string', 'max:255'],
            'image' => ['image', 'mimes:png,jpg,jpeg', 'max:5120']
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nama kategori wajib diisi',
            'name.max' => 'Nama kategori maksimal 255 karakter',
            'image.image' => 'File yang diupload harus gambar',
            'image.mimes' => 'File yang diupload harus berformat jpeg, png, jpg',
            'image.max' => 'Ukuran gambar maksimal 5MB'
        ];
    }
}
