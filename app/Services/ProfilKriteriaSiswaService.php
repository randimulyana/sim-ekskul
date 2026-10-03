<?php

namespace App\Services;

use App\Models\Criterion;
use App\Models\Period;
use App\Models\QuestionnaireAnswer;
use App\Models\Student;
use App\Models\User;

class ProfilKriteriaSiswaService
{
    /**
     * Hitung skor profil kriteria (C1-C5) untuk seorang siswa pada periode tertentu.
     *
     * Aturan:
     * - Hanya jawaban dari pertanyaan radio/likert yang terpetakan dengan nilai kriteria valid (1-5) yang diagregasi.
     * - Jawaban textarea dan checkbox dikecualikan (tidak ada penilaian sembarangan).
     * - Skor per kriteria = rata-rata(skor jawaban terpetakan), dibulatkan ke 4 desimal.
     * - Jika tidak ada jawaban terpetakan untuk suatu kriteria, skornya adalah NULL (tidak pernah 0).
     *
     * @return array{
     *     student_id: int,
     *     student_name: string,
     *     period_id: ?int,
     *     period_name: ?string,
     *     criteria: array<string, array{
     *         criterion_id: int,
     *         code: string,
     *         name: string,
     *         type: string,
     *         weight: float,
     *         score: ?float,
     *         formatted_score: ?string,
     *         answers_count: int,
     *         status: string
     *     }>,
     *     is_complete: bool,
     *     missing_criteria: array<string>,
     *     total_answers_evaluated: int
     * }
     */
    public function getProfile(Student $student, ?Period $period = null): array
    {
        $period = $period ?? Period::where('is_active', true)->first();

        $activeCriteria = Criterion::where('is_active', true)
            ->orderBy('code')
            ->get();

        if (! $period) {
            $criteriaList = [];
            $missing = [];
            foreach ($activeCriteria as $c) {
                $criteriaList[$c->code] = [
                    'criterion_id' => $c->id,
                    'code' => $c->code,
                    'name' => $c->name,
                    'type' => $c->type,
                    'weight' => (float) $c->weight,
                    'score' => null,
                    'formatted_score' => null,
                    'answers_count' => 0,
                    'status' => 'no_period',
                ];
                $missing[] = $c->code;
            }

            return [
                'student_id' => $student->id,
                'student_name' => $student->name,
                'period_id' => null,
                'period_name' => null,
                'criteria' => $criteriaList,
                'is_complete' => false,
                'missing_criteria' => $missing,
                'total_answers_evaluated' => 0,
            ];
        }

        // Ambil semua jawaban siswa untuk periode ini beserta relasi-relasinya
        $answers = QuestionnaireAnswer::where('student_id', $student->id)
            ->where('period_id', $period->id)
            ->with([
                'question.criterion',
                'questionOption.criterionValue',
            ])
            ->get();

        // Kelompokkan skor numerik valid berdasarkan kode kriteria
        $scoresByCriterion = [];
        $evaluatedCount = 0;

        foreach ($answers as $ans) {
            $question = $ans->question;
            if (! $question || ! $question->is_active || ! $question->criterion_id) {
                continue;
            }

            $criterion = $question->criterion;
            if (! $criterion || ! $criterion->is_active) {
                continue;
            }

            // Kecualikan secara ketat pertanyaan textarea dan checkbox dari penilaian kuantitatif
            if (in_array($question->type, ['textarea', 'checkbox'], true)) {
                continue;
            }

            // Ekstrak skor numerik dari Opsi / CriterionValue / AnswerValue yang terpetakan
            $score = null;

            if ($ans->questionOption && $ans->questionOption->criterionValue) {
                $val = (float) $ans->questionOption->criterionValue->value;
                if ($val >= 1.0 && $val <= 5.0) {
                    $score = $val;
                }
            } elseif ($ans->questionOption && $ans->questionOption->value !== null) {
                $val = (float) $ans->questionOption->value;
                if ($val >= 1.0 && $val <= 5.0) {
                    $score = $val;
                }
            } elseif ($ans->answer_value !== null) {
                $val = (float) $ans->answer_value;
                if ($val >= 1.0 && $val <= 5.0) {
                    $score = $val;
                }
            }

            if ($score !== null) {
                $scoresByCriterion[$criterion->code][] = $score;
                $evaluatedCount++;
            }
        }

        // Bangun array skor kriteria
        $criteriaList = [];
        $missing = [];

        foreach ($activeCriteria as $criterion) {
            $code = $criterion->code;
            $hasScores = isset($scoresByCriterion[$code]) && count($scoresByCriterion[$code]) > 0;

            if ($hasScores) {
                $count = count($scoresByCriterion[$code]);
                $sum = array_sum($scoresByCriterion[$code]);
                $avg = round($sum / $count, 4);

                $criteriaList[$code] = [
                    'criterion_id' => $criterion->id,
                    'code' => $code,
                    'name' => $criterion->name,
                    'type' => $criterion->type,
                    'weight' => (float) $criterion->weight,
                    'score' => $avg,
                    'formatted_score' => number_format($avg, 2),
                    'answers_count' => $count,
                    'status' => 'calculated',
                ];
            } else {
                $criteriaList[$code] = [
                    'criterion_id' => $criterion->id,
                    'code' => $code,
                    'name' => $criterion->name,
                    'type' => $criterion->type,
                    'weight' => (float) $criterion->weight,
                    'score' => null, // Eksplisit NULL, tidak pernah nol
                    'formatted_score' => null,
                    'answers_count' => 0,
                    'status' => 'missing',
                ];
                $missing[] = $code;
            }
        }

        return [
            'student_id' => $student->id,
            'student_name' => $student->name,
            'period_id' => $period->id,
            'period_name' => $period->name,
            'criteria' => $criteriaList,
            'is_complete' => empty($missing),
            'missing_criteria' => $missing,
            'total_answers_evaluated' => $evaluatedCount,
        ];
    }

    /**
     * Periksa apakah pengguna berwenang untuk melihat profil seorang siswa.
     */
    public function canAccess(User $user, Student $student): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isStudent()) {
            return $user->student && $user->student->id === $student->id;
        }

        return false;
    }
}
