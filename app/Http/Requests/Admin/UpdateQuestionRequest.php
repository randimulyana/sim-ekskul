<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateQuestionRequest extends FormRequest
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
        if ($this->has('teks_pertanyaan') && ! $this->has('question_text')) {
            $this->merge(['question_text' => $this->input('teks_pertanyaan')]);
        }
        if ($this->has('question') && ! $this->has('question_text')) {
            $this->merge(['question_text' => $this->input('question')]);
        }
        if ($this->has('kategori') && ! $this->has('category')) {
            $this->merge(['category' => $this->input('kategori')]);
        }
        if ($this->has('tipe') && ! $this->has('type')) {
            $this->merge(['type' => $this->input('tipe')]);
        }
        if ($this->has('urutan') && ! $this->has('order')) {
            $this->merge(['order' => $this->input('urutan')]);
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
            'criterion_id' => ['nullable', 'exists:criteria,id'],
            'question_text' => ['required', 'string'],
            'category' => ['required', 'string', 'max:100'],
            'type' => ['required', 'string', 'in:radio,checkbox,likert,textarea'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
            'options' => ['nullable', 'array'],
            'options.*' => ['nullable'],
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
            'criterion_id' => 'Kriteria',
            'question_text' => 'Teks Pertanyaan',
            'teks_pertanyaan' => 'Teks Pertanyaan',
            'question' => 'Teks Pertanyaan',
            'category' => 'Kategori Pertanyaan',
            'kategori' => 'Kategori Pertanyaan',
            'type' => 'Tipe Pertanyaan',
            'tipe' => 'Tipe Pertanyaan',
            'order' => 'Nomor Urut',
            'urutan' => 'Nomor Urut',
            'is_active' => 'Status Aktif',
            'options' => 'Pilihan Opsi',
        ];
    }
}
