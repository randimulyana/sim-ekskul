<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nis',
        'class_name',
        'whatsapp',
        'status',
    ];

    /**
     * Get the student's name from the associated user account.
     */
    public function getNameAttribute(): string
    {
        return $this->user?->name ?? 'Siswa';
    }

    /**
     * The user account associated with the student profile.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Registrations submitted by this student.
     */
    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class);
    }

    /**
     * Questionnaire answers submitted by this student.
     */
    public function questionnaireAnswers(): HasMany
    {
        return $this->hasMany(QuestionnaireAnswer::class);
    }

    /**
     * Recommendations calculated for this student.
     */
    public function recommendations(): HasMany
    {
        return $this->hasMany(Recommendation::class);
    }

    /**
     * Calculate questionnaire completion progress for a given period.
     */
    public function getQuestionnaireProgress(?Period $period = null): array
    {
        $period = $period ?: Period::where('is_active', true)->first();

        if (! $period) {
            return [
                'total_questions' => 0,
                'answered_questions' => 0,
                'percentage' => 0,
                'is_complete' => false,
                'status' => 'belum_ada_periode',
                'status_label' => 'Belum Ada Periode Aktif',
            ];
        }

        $totalQuestions = Question::where('is_active', true)->count();
        $answeredQuestions = $this->questionnaireAnswers()
            ->where('period_id', $period->id)
            ->distinct('question_id')
            ->count('question_id');

        $percentage = $totalQuestions > 0 ? (int) round(($answeredQuestions / $totalQuestions) * 100) : 0;
        $isComplete = $totalQuestions > 0 && $answeredQuestions >= $totalQuestions;

        $status = 'belum_mulai';
        $statusLabel = 'Belum Diisi';
        if ($isComplete) {
            $status = 'selesai';
            $statusLabel = 'Selesai';
        } elseif ($answeredQuestions > 0) {
            $status = 'sedang_mengisi';
            $statusLabel = 'Sedang Mengisi';
        }

        return [
            'total_questions' => $totalQuestions,
            'answered_questions' => $answeredQuestions,
            'percentage' => $percentage,
            'is_complete' => $isComplete,
            'status' => $status,
            'status_label' => $statusLabel,
            'period' => $period,
        ];
    }

    /**
     * Calculate profile completion percentage based on stored student fields.
     */
    public function getProfileCompletionPercentage(): int
    {
        $score = 0;
        if (! empty($this->user?->name)) {
            $score += 25;
        }
        if (! empty($this->nis)) {
            $score += 25;
        }
        if (! empty($this->class_name)) {
            $score += 25;
        }
        if (! empty($this->whatsapp)) {
            $score += 25;
        }

        return $score;
    }
}
