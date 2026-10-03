<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExtracurricularCriterionMapping extends Model
{
    use HasFactory;

    protected $fillable = [
        'extracurricular_id',
        'criterion_id',
        'value',
        'status',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'value' => 'float',
        ];
    }

    /**
     * Ekstrakurikuler dalam pemetaan ini.
     */
    public function extracurricular(): BelongsTo
    {
        return $this->belongsTo(Extracurricular::class);
    }

    /**
     * Kriteria dalam pemetaan ini.
     */
    public function criterion(): BelongsTo
    {
        return $this->belongsTo(Criterion::class);
    }
}
