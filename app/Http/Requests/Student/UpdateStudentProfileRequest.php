<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStudentProfileRequest extends FormRequest
{
    /**
     * Tentukan apakah user berwenang untuk membuat request ini.
     */
    public function authorize(): bool
    {
        return $this->user()?->isStudent() ?? false;
    }

    /**
     * Ambil aturan validasi yang berlaku untuk request ini.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'whatsapp' => ['nullable', 'string', 'max:50'],
            'current_password' => ['nullable', 'required_with:password', 'current_password'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ];
    }

    /**
     * Nama atribut kustom untuk pesan validasi.
     */
    public function attributes(): array
    {
        return [
            'name' => 'Nama Lengkap',
            'whatsapp' => 'Nomor WhatsApp',
            'current_password' => 'Password Saat Ini',
            'password' => 'Password Baru',
        ];
    }
}
