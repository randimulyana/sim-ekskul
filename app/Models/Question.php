<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'criterion_id',
        'question',
        'question_text',
        'category',
        'type',
        'is_required',
        'sort_order',
        'order',
        'is_active',
    ];

    public function getQuestionTextAttribute(): ?string
    {
        return $this->question;
    }

    public function setQuestionTextAttribute(?string $value): void
    {
        $this->attributes['question'] = $value;
    }

    public function getOrderAttribute(): ?int
    {
        return $this->sort_order;
    }

    public function setOrderAttribute(?int $value): void
    {
        $this->attributes['sort_order'] = $value;
    }

    protected function casts(): array
    {
        return [
            'is_required' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    /**
     * Scope query hanya untuk pertanyaan yang aktif.
     */
    public function scopeActive(Builder $query): void
    {
        $query->where('is_active', true);
    }

    /**
     * Kriteria opsional yang dipetakan ke pertanyaan ini.
     */
    public function criterion(): BelongsTo
    {
        return $this->belongsTo(Criterion::class);
    }

    /**
     * Opsi yang tersedia untuk pertanyaan ini.
     */
    public function options(): HasMany
    {
        return $this->hasMany(QuestionOption::class)->orderBy('sort_order');
    }

    /**
     * Jawaban siswa yang dicatat untuk pertanyaan ini.
     */
    public function answers(): HasMany
    {
        return $this->hasMany(QuestionnaireAnswer::class);
    }
}
