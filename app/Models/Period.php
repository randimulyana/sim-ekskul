<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Period extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'school_year',
        'start_date',
        'end_date',
        'is_active',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Scope query hanya untuk periode yang aktif.
     */
    public function scopeActive(Builder $query): void
    {
        $query->where('is_active', true);
    }

    /**
     * Pendaftaran dalam periode ini.
     */
    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class);
    }

    /**
     * Jawaban kuesioner dalam periode ini.
     */
    public function questionnaireAnswers(): HasMany
    {
        return $this->hasMany(QuestionnaireAnswer::class);
    }

    /**
     * Rekomendasi yang dibuat dalam periode ini.
     */
    public function recommendations(): HasMany
    {
        return $this->hasMany(Recommendation::class);
    }
}
