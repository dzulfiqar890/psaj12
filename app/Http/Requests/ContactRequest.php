<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Form Request untuk validasi kontak/pesan.
 */
class ContactRequest extends FormRequest
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
            'subject' => 'required|string|max:200',
            'message' => 'required|string|max:5000',
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
            'subject.required' => 'Subjek pesan wajib diisi.',
            'subject.max' => 'Subjek maksimal 200 karakter.',
            'message.required' => 'Isi pesan wajib diisi.',
            'message.max' => 'Isi pesan maksimal 5000 karakter.',
        ];
    }
}
