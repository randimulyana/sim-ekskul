<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StorePeriodRequest extends FormRequest
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
        if ($this->has('nama_periode') && ! $this->has('name')) {
            $this->merge(['name' => $this->input('nama_periode')]);
        }
        if ($this->has('tahun_pelajaran') && ! $this->has('school_year')) {
            $this->merge(['school_year' => $this->input('tahun_pelajaran')]);
        }
        if ($this->has('tanggal_mulai') && ! $this->has('start_date')) {
            $this->merge(['start_date' => $this->input('tanggal_mulai')]);
        }
        if ($this->has('tanggal_selesai') && ! $this->has('end_date')) {
            $this->merge(['end_date' => $this->input('tanggal_selesai')]);
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
            'school_year' => ['required', 'string', 'max:50'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'is_active' => ['nullable', 'boolean'],
            'description' => ['nullable', 'string'],
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
            'name' => 'Nama Periode',
            'nama_periode' => 'Nama Periode',
            'school_year' => 'Tahun Pelajaran',
            'tahun_pelajaran' => 'Tahun Pelajaran',
            'start_date' => 'Tanggal Mulai',
            'tanggal_mulai' => 'Tanggal Mulai',
            'end_date' => 'Tanggal Selesai',
            'tanggal_selesai' => 'Tanggal Selesai',
            'is_active' => 'Status Aktif',
            'description' => 'Keterangan/Deskripsi',
        ];
    }
}
