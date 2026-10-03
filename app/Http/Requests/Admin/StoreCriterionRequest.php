<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreCriterionRequest extends FormRequest
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
        // Normalisasi bobot: jika diinput sebagai persentase > 1 (mis. 30), ubah ke desimal 0.30
        if ($this->has('weight') && is_numeric($this->input('weight'))) {
            $val = (float) $this->input('weight');
            if ($val > 1.0) {
                $this->merge(['weight' => round($val / 100, 4)]);
            }
        }

        if ($this->has('kode') && ! $this->has('code')) {
            $this->merge(['code' => strtoupper(trim($this->input('kode')))]);
        } elseif ($this->has('code')) {
            $this->merge(['code' => strtoupper(trim($this->input('code')))]);
        }

        if ($this->has('nama') && ! $this->has('name')) {
            $this->merge(['name' => trim($this->input('nama'))]);
        }

        if ($this->has('tipe') && ! $this->has('type')) {
            $this->merge(['type' => strtolower($this->input('tipe'))]);
        }

        if ($this->has('bobot') && ! $this->has('weight')) {
            $w = (float) $this->input('bobot');
            $this->merge(['weight' => $w > 1.0 ? round($w / 100, 4) : $w]);
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
            'code' => ['required', 'string', 'max:10', 'unique:criteria,code'],
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', 'in:benefit,cost'],
            'weight' => ['required', 'numeric', 'min:0', 'max:1'],
            'description' => ['nullable', 'string'],
            'status' => ['nullable', 'string', 'in:proposed,needs_validation,validated'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }

    /**
     * Nama atribut kustom untuk pesan validasi.
     */
    public function attributes(): array
    {
        return [
            'code' => 'Kode Kriteria',
            'name' => 'Nama Kriteria',
            'type' => 'Tipe Atribut',
            'weight' => 'Bobot Kriteria',
            'status' => 'Status Validasi',
        ];
    }
}
