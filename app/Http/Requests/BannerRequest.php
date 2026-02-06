<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Form Request untuk validasi banner.
 */
class BannerRequest extends FormRequest
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
        $imageRule = 'image|mimes:jpg,jpeg,png,webp|max:5120';

        // Image wajib saat create, opsional saat update
        if ($this->isMethod('POST')) {
            $imageRule = 'required|' . $imageRule;
        } else {
            $imageRule = 'nullable|' . $imageRule;
        }

        return [
            'title' => 'required|string|max:200',
            'image' => $imageRule,
            'link' => 'nullable|url|max:500',
            'is_active' => 'nullable|boolean',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Judul banner wajib diisi.',
            'title.max' => 'Judul banner maksimal 200 karakter.',
            'image.required' => 'Gambar banner wajib diupload.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Format gambar harus JPG, PNG, atau WEBP.',
            'image.max' => 'Ukuran file terlalu besar. Maksimal 5MB.',
            'link.url' => 'Format URL tidak valid.',
            'link.max' => 'URL maksimal 500 karakter.',
            'is_active.boolean' => 'Status aktif harus berupa true atau false.',
        ];
    }
}
