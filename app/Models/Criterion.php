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
     * Get weight in percentage representation (e.g. 0.30 -> 30).
     */
    public function getWeightPercentageAttribute(): float
    {
        return round(($this->weight ?? 0) * 100, 2);
    }

    /**
     * Human readable label for status.
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
     * Check if criterion is benefit type.
     */
    public function isBenefit(): bool
    {
        return strtolower($this->type) === 'benefit';
    }

    /**
     * Check if criterion is cost type.
     */
    public function isCost(): bool
    {
        return strtolower($this->type) === 'cost';
    }

    /**
     * Calculate total active criteria weight.
     */
    public static function getTotalWeight(): float
    {
        return (float) static::where('is_active', true)->sum('weight');
    }

    /**
     * Validate whether total active criteria weight equals 1.00 (100%).
     */
    public static function isTotalWeightValid(): bool
    {
        return abs(static::getTotalWeight() - 1.00) < 0.001;
    }

    /**
     * Scope query to only active criteria.
     */
    public function scopeActive(Builder $query): void
    {
        $query->where('is_active', true);
    }

    /**
     * Indicator/scale values associated with this criterion.
     */
    public function values(): HasMany
    {
        return $this->hasMany(CriterionValue::class)->orderBy('sort_order');
    }

    /**
     * Questions mapped to this criterion.
     */
    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    /**
     * Direct relationship to extracurricular mappings.
     */
    public function extracurricularMappings(): HasMany
    {
        return $this->hasMany(ExtracurricularCriterionMapping::class);
    }

    /**
     * Extracurriculars associated with this criterion through mappings.
     */
    public function extracurriculars(): BelongsToMany
    {
        return $this->belongsToMany(Extracurricular::class, 'extracurricular_criterion_mappings')
            ->withPivot(['value', 'notes'])
            ->withTimestamps();
    }
}
