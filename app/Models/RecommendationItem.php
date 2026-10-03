<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RecommendationItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'recommendation_id',
        'extracurricular_id',
        'score',
        'rank',
        'explanation',
    ];

    protected function casts(): array
    {
        return [
            'score' => 'float',
            'rank' => 'integer',
        ];
    }

    /**
     * Data rekomendasi induk dari item ini.
     */
    public function recommendation(): BelongsTo
    {
        return $this->belongsTo(Recommendation::class);
    }

    /**
     * Ekstrakurikuler yang direkomendasikan.
     */
    public function extracurricular(): BelongsTo
    {
        return $this->belongsTo(Extracurricular::class);
    }
}
