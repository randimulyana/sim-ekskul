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
