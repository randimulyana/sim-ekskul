<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Recommendation extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'period_id',
        'method_name',
        'method_version',
        'generated_at',
    ];

    protected function casts(): array
    {
        return [
            'generated_at' => 'datetime',
        ];
    }

    /**
     * Siswa yang menerima rekomendasi ini.
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Periode saat rekomendasi dibuat.
     */
    public function period(): BelongsTo
    {
        return $this->belongsTo(Period::class);
    }

    /**
     * Item rekomendasi yang telah diperingkatkan.
     */
    public function items(): HasMany
    {
        return $this->hasMany(RecommendationItem::class)->orderBy('rank');
    }
}
