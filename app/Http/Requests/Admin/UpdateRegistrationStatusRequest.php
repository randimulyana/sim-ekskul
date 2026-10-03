<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRegistrationStatusRequest extends FormRequest
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
        if ($this->has('admin_notes') && ! $this->has('notes')) {
            $this->merge(['notes' => $this->input('admin_notes')]);
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
            'status' => ['required', 'string', 'in:submitted,reviewed,accepted,rejected,cancelled'],
            'notes' => ['nullable', 'string', 'max:1000'],
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
            'status' => 'Status Pendaftaran',
            'notes' => 'Catatan Administrator',
            'admin_notes' => 'Catatan Administrator',
        ];
    }
}
