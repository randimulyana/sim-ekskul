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
     * Ambil nama siswa dari akun user yang terkait.
     */
    public function getNameAttribute(): string
    {
        return $this->user?->name ?? 'Siswa';
    }

    /**
     * Akun user yang berasosiasi dengan profil siswa ini.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Pendaftaran yang diajukan oleh siswa ini.
     */
    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class);
    }

    /**
     * Jawaban kuesioner yang dikirimkan oleh siswa ini.
     */
    public function questionnaireAnswers(): HasMany
    {
        return $this->hasMany(QuestionnaireAnswer::class);
    }

    /**
     * Rekomendasi yang telah dihitung untuk siswa ini.
     */
    public function recommendations(): HasMany
    {
        return $this->hasMany(Recommendation::class);
    }

    /**
     * Hitung progres pengisian kuesioner untuk periode tertentu.
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
     * Hitung persentase kelengkapan profil berdasarkan field siswa yang tersimpan.
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
