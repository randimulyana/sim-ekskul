<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Criterion extends Model
{
    use HasFactory;

    protected $table = 'criteria';

    protected $fillable = [
        'code',
        'name',
        'description',
        'type',
        'weight',
        'status',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'weight' => 'float',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Ambil bobot dalam representasi persentase (mis. 0.30 -> 30).
     */
    public function getWeightPercentageAttribute(): float
    {
        return round(($this->weight ?? 0) * 100, 2);
    }

    /**
     * Label yang mudah dibaca untuk status.
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'validated' => 'Validated (Resmi)',
            'proposed' => 'Proposed / Needs Validation',
            default => 'Needs Validation',
        };
    }

    /**
     * Periksa apakah kriteria bertipe benefit.
     */
    public function isBenefit(): bool
    {
        return strtolower($this->type) === 'benefit';
    }

    /**
     * Periksa apakah kriteria bertipe cost.
     */
    public function isCost(): bool
    {
        return strtolower($this->type) === 'cost';
    }

    /**
     * Hitung total bobot kriteria yang aktif.
     */
    public static function getTotalWeight(): float
    {
        return (float) static::where('is_active', true)->sum('weight');
    }

    /**
     * Validasi apakah total bobot kriteria yang aktif sama dengan 1.00 (100%).
     */
    public static function isTotalWeightValid(): bool
    {
        return abs(static::getTotalWeight() - 1.00) < 0.001;
    }

    /**
     * Scope query hanya untuk kriteria yang aktif.
     */
    public function scopeActive(Builder $query): void
    {
        $query->where('is_active', true);
    }

    /**
     * Nilai indikator/skala yang terkait dengan kriteria ini.
     */
    public function values(): HasMany
    {
        return $this->hasMany(CriterionValue::class)->orderBy('sort_order');
    }

    /**
     * Pertanyaan yang dipetakan ke kriteria ini.
     */
    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    /**
     * Relasi langsung ke pemetaan ekstrakurikuler.
     */
    public function extracurricularMappings(): HasMany
    {
        return $this->hasMany(ExtracurricularCriterionMapping::class);
    }

    /**
     * Ekstrakurikuler yang terkait dengan kriteria ini melalui pemetaan.
     */
    public function extracurriculars(): BelongsToMany
    {
        return $this->belongsToMany(Extracurricular::class, 'extracurricular_criterion_mappings')
            ->withPivot(['value', 'notes'])
            ->withTimestamps();
    }
}
