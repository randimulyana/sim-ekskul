<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;

class SaveQuestionnaireRequest extends FormRequest
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
            'answers' => ['required', 'array'],
            'answers.*' => ['nullable'],
        ];
    }

    /**
     * Nama atribut kustom untuk pesan validasi.
     */
    public function attributes(): array
    {
        return [
            'answers' => 'Jawaban Kuesioner',
        ];
    }
}
