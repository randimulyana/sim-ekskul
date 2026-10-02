<?php

namespace App\Http\Requests\Admin;

use App\Models\Extracurricular;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateExtracurricularRequest extends FormRequest
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
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $id = $this->route('id') ?? $this->route('ekstrakurikuler');
        $ekskul = $id instanceof Extracurricular ? $id : Extracurricular::find($id);

        return [
            'name' => ['required', 'string', 'max:255', Rule::unique('extracurriculars', 'name')->ignore($ekskul?->id)],
            'category' => ['nullable', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'schedule' => ['nullable', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'coach_name' => ['nullable', 'string', 'max:255'],
            'quota' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }
}
