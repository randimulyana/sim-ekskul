<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuestionnaireAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'period_id',
        'question_id',
        'question_option_id',
        'answer_text',
        'answer_value',
    ];

    protected function casts(): array
    {
        return [
            'answer_value' => 'float',
        ];
    }

    /**
     * The student who gave this answer.
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * The period in which this answer was submitted.
     */
    public function period(): BelongsTo
    {
        return $this->belongsTo(Period::class);
    }

    /**
     * The question being answered.
     */
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    /**
     * The specific option chosen, if applicable.
     */
    public function questionOption(): BelongsTo
    {
        return $this->belongsTo(QuestionOption::class);
    }
}
