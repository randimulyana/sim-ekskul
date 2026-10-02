<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuestionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    /**
     * Prepare data for validation.
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
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'question_text' => ['required', 'string'],
            'category' => ['required', 'string', 'max:100'],
            'type' => ['required', 'string', 'in:radio,checkbox,likert,textarea'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
            'options' => ['nullable', 'array'],
            'options.*' => ['nullable'],
        ];
    }
}
