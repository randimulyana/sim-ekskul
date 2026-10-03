<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreEkstrakurikulerRequest extends FormRequest
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
        if ($this->has('kategori') && ! $this->has('category')) {
            $this->merge(['category' => $this->input('kategori')]);
        }
        if ($this->has('deskripsi') && ! $this->has('description')) {
            $this->merge(['description' => $this->input('deskripsi')]);
        }
        if ($this->has('jadwal') && ! $this->has('schedule')) {
            $this->merge(['schedule' => $this->input('jadwal')]);
        }
        if ($this->has('lokasi') && ! $this->has('location')) {
            $this->merge(['location' => $this->input('lokasi')]);
        }
        if ($this->has('pembina') && ! $this->has('coach_name')) {
            $this->merge(['coach_name' => $this->input('pembina')]);
        }
        if ($this->has('status')) {
            $this->merge([
                'is_active' => in_array($this->input('status'), ['aktif', 'active', '1', 1, true], true),
            ]);
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
            'name' => ['required', 'string', 'max:255', 'unique:extracurriculars,name'],
            'category' => ['nullable', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'schedule' => ['nullable', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'coach_name' => ['nullable', 'string', 'max:255'],
            'quota' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
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
            'name' => 'Nama Ekstrakurikuler',
            'nama' => 'Nama Ekstrakurikuler',
            'category' => 'Kategori',
            'kategori' => 'Kategori',
            'description' => 'Deskripsi',
            'deskripsi' => 'Deskripsi',
            'schedule' => 'Jadwal Kegiatan',
            'jadwal' => 'Jadwal Kegiatan',
            'location' => 'Lokasi Kegiatan',
            'lokasi' => 'Lokasi Kegiatan',
            'coach_name' => 'Nama Pembina/Pelatih',
            'pembina' => 'Nama Pembina/Pelatih',
            'quota' => 'Kuota Anggota',
            'is_active' => 'Status Aktif',
        ];
    }
}
