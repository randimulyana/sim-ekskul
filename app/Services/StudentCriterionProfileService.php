<?php

namespace App\Services;

use App\Models\Criterion;
use App\Models\Period;
use App\Models\QuestionnaireAnswer;
use App\Models\Student;
use App\Models\User;

class StudentCriterionProfileService
{
    /**
     * Compute criterion profile scores (C1-C5) for a student in a given period.
     *
     * Rule:
     * - Only answers from mapped radio/likert questions with valid criterion values (1-5) are aggregated.
     * - Textarea and checkbox answers are excluded (no arbitrary scoring).
     * - Score per criterion = average(mapped answer scores), rounded to 4 decimals.
     * - If no mapped answers exist for a criterion, its score is NULL (never 0).
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

        // Fetch all student answers for this period with relationships
        $answers = QuestionnaireAnswer::where('student_id', $student->id)
            ->where('period_id', $period->id)
            ->with([
                'question.criterion',
                'questionOption.criterionValue',
            ])
            ->get();

        // Group valid numeric scores by criterion code
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

            // Strictly exclude textarea and checkbox questions from quantitative scoring
            if (in_array($question->type, ['textarea', 'checkbox'], true)) {
                continue;
            }

            // Extract numeric score from mapped Option / CriterionValue / AnswerValue
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

        // Build criteria scores array
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
                    'score' => null, // Explicitly NULL, never zero
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
     * Check if a user is authorized to view a student's profile.
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
