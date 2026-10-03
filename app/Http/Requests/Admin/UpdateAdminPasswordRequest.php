<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UpdateAdminPasswordRequest extends FormRequest
{
    /**
     * Tentukan apakah user berwenang untuk membuat request ini.
     */
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    /**
     * Siapkan data sebelum validasi.
     */
    protected function prepareForValidation(): void
    {
        if ($this->has('new_password') && ! $this->has('password')) {
            $this->merge(['password' => $this->input('new_password')]);
        }
        if ($this->has('new_password_confirmation') && ! $this->has('password_confirmation')) {
            $this->merge(['password_confirmation' => $this->input('new_password_confirmation')]);
        }
    }

    /**
     * Ambil aturan validasi yang berlaku untuk request ini.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', Password::defaults(), 'confirmed'],
        ];
    }

    /**
     * Nama atribut kustom untuk pesan validasi.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'current_password' => 'Kata Sandi Saat Ini',
            'password' => 'Kata Sandi Baru',
            'new_password' => 'Kata Sandi Baru',
            'new_password_confirmation' => 'Konfirmasi Kata Sandi Baru',
        ];
    }
}
