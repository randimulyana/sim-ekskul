<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCriterionRequest extends FormRequest
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
        // Normalize weight: if entered as percentage > 1 (e.g. 30), convert to decimal 0.30
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
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $id = $this->route('id') ?? $this->route('kriterium') ?? $this->route('criterion');

        return [
            'code' => ['required', 'string', 'max:10', Rule::unique('criteria', 'code')->ignore($id)],
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', 'in:benefit,cost'],
            'weight' => ['required', 'numeric', 'min:0', 'max:1'],
            'description' => ['nullable', 'string'],
            'status' => ['nullable', 'string', 'in:proposed,needs_validation,validated'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }

    /**
     * Custom attribute names for validation.
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
