<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreSiswaRequest extends FormRequest
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
        if ($this->has('nama') && ! $this->has('name')) {
            $this->merge(['name' => $this->input('nama')]);
        }

        if ($this->has('kelas') && ! $this->has('class_name')) {
            $this->merge(['class_name' => $this->input('kelas')]);
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
            'name' => ['required', 'string', 'max:255'],
            'nis' => ['required', 'string', 'max:20', 'unique:students,nis'],
            'class_name' => ['required', 'string', 'max:50'],
            'whatsapp' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'string', 'in:active,inactive,aktif,nonaktif'],
            'email' => ['nullable', 'email', 'max:255', 'unique:users,email'],
        ];
    }

    /**
     * Nama atribut kustom untuk pesan validasi.
     */
    public function attributes(): array
    {
        return [
            'name' => 'Nama Siswa',
            'nama' => 'Nama Siswa',
            'nis' => 'NIS',
            'class_name' => 'Kelas',
            'kelas' => 'Kelas',
            'whatsapp' => 'Nomor WhatsApp',
            'status' => 'Status',
        ];
    }
}
