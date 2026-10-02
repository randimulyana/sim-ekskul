<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    /**
     * Prepare the data for validation.
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
     * Get the validation rules that apply to the request.
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
     * Custom attribute names.
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
