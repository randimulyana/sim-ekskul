<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Extracurricular extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'category',
        'description',
        'schedule_info',
        'location_info',
        'schedule',
        'location',
        'coach_name',
        'quota',
        'is_active',
    ];

    public function getScheduleAttribute(): ?string
    {
        return $this->schedule_info;
    }

    public function setScheduleAttribute(?string $value): void
    {
        $this->attributes['schedule_info'] = $value;
    }

    public function getLocationAttribute(): ?string
    {
        return $this->location_info;
    }

    public function setLocationAttribute(?string $value): void
    {
        $this->attributes['location_info'] = $value;
    }

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'quota' => 'integer',
        ];
    }

    /**
     * Scope query to only active extracurriculars.
     */
    public function scopeActive(Builder $query): void
    {
        $query->where('is_active', true);
    }

    /**
     * Registrations for this extracurricular.
     */
    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class);
    }

    /**
     * Recommendation items referencing this extracurricular.
     */
    public function recommendationItems(): HasMany
    {
        return $this->hasMany(RecommendationItem::class);
    }

    /**
     * Direct relationship to criterion mappings.
     */
    public function criterionMappings(): HasMany
    {
        return $this->hasMany(ExtracurricularCriterionMapping::class);
    }

    /**
     * Criteria associated with this extracurricular through mappings.
     */
    public function criteria(): BelongsToMany
    {
        return $this->belongsToMany(Criterion::class, 'extracurricular_criterion_mappings')
            ->withPivot(['value', 'notes'])
            ->withTimestamps();
    }
}
