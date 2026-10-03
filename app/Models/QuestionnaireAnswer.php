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
     * Siswa yang memberikan jawaban ini.
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Periode saat jawaban ini dikirimkan.
     */
    public function period(): BelongsTo
    {
        return $this->belongsTo(Period::class);
    }

    /**
     * Pertanyaan yang dijawab.
     */
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    /**
     * Opsi tertentu yang dipilih, jika ada.
     */
    public function questionOption(): BelongsTo
    {
        return $this->belongsTo(QuestionOption::class);
    }
}
