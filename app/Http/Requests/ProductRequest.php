<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Form Request untuk validasi produk.
 */
class ProductRequest extends FormRequest
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
        $rules = [
            'name' => 'required|string|max:200',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0|max:999999999999.99',
            'description' => 'nullable|string|max:5000',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120', // Maks 5MB
            'stock' => 'nullable|integer|min:0|max:999999',
        ];

        // Untuk update, slug opsional
        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $rules['slug'] = 'nullable|string|unique:products,slug,' . $this->route('product')?->id;
            $rules['category_id'] = 'sometimes|exists:categories,id';
        }

        return $rules;
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Nama produk wajib diisi.',
            'name.max' => 'Nama produk maksimal 200 karakter.',
            'category_id.required' => 'Gagal! Silakan pilih kategori produk terlebih dahulu.',
            'category_id.exists' => 'Gagal! Silakan buat kategori produk terlebih dahulu sebelum menambah produk.',
            'price.required' => 'Harga produk wajib diisi.',
            'price.numeric' => 'Harga harus berupa angka.',
            'price.min' => 'Harga tidak boleh negatif.',
            'description.max' => 'Deskripsi maksimal 5000 karakter.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Format gambar harus JPG, PNG, atau WEBP.',
            'image.max' => 'Ukuran file terlalu besar. Maksimal 5MB.',
            'stock.integer' => 'Stok harus berupa angka bulat.',
            'stock.min' => 'Stok tidak boleh negatif.',
            'slug.unique' => 'Slug sudah digunakan. Silakan gunakan slug lain.',
        ];
    }
}
