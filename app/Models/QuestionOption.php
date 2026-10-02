<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QuestionOption extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_id',
        'label',
        'option_text',
        'text',
        'value',
        'score_value',
        'sort_order',
        'order',
    ];

    public function getOptionTextAttribute(): ?string
    {
        return $this->label;
    }

    public function setOptionTextAttribute(?string $value): void
    {
        $this->attributes['label'] = $value;
    }

    public function getTextAttribute(): ?string
    {
        return $this->label;
    }

    public function setTextAttribute(?string $value): void
    {
        $this->attributes['label'] = $value;
    }

    public function getScoreValueAttribute(): mixed
    {
        return $this->value;
    }

    public function setScoreValueAttribute(mixed $value): void
    {
        $this->attributes['value'] = $value;
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
            'value' => 'float',
            'sort_order' => 'integer',
        ];
    }

    /**
     * The question this option belongs to.
     */
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    /**
     * Student answers that selected this option.
     */
    public function answers(): HasMany
    {
        return $this->hasMany(QuestionnaireAnswer::class);
    }
}
