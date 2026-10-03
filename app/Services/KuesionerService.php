<?php

namespace App\Services;

use App\Models\Period;
use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\QuestionnaireAnswer;
use App\Models\Student;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class KuesionerService
{
    /**
     * Ambil periode aktif saat ini.
     */
    public function getActivePeriod(): ?Period
    {
        return Period::where('is_active', true)->first();
    }

    /**
     * Get all active questions ordered by sort order with options.
     */
    public function getActiveQuestions(): Collection
    {
        return Question::where('is_active', true)
            ->with(['options' => function ($query) {
                $query->orderBy('sort_order');
            }])
            ->orderBy('sort_order')
            ->get();
    }

    /**
     * Get answers submitted by a student for a specific period.
     * Returns an array keyed by question_id.
     *
     * @return array<int, array{option_id: ?int, option_ids: array<int>, text: ?string, value: ?float}>
     */
    public function getStudentAnswers(Student $student, Period $period): array
    {
        $rawAnswers = QuestionnaireAnswer::where('student_id', $student->id)
            ->where('period_id', $period->id)
            ->get();

        $answers = [];

        foreach ($rawAnswers as $ans) {
            $qId = $ans->question_id;

            if (! isset($answers[$qId])) {
                $answers[$qId] = [
                    'option_id' => $ans->question_option_id,
                    'option_ids' => $ans->question_option_id ? [$ans->question_option_id] : [],
                    'text' => $ans->answer_text,
                    'value' => $ans->answer_value,
                ];
            } else {
                if ($ans->question_option_id) {
                    $answers[$qId]['option_ids'][] = $ans->question_option_id;
                }
                if ($ans->answer_text) {
                    $answers[$qId]['text'] = $ans->answer_text;
                }
            }
        }

        return $answers;
    }

    /**
     * Save answers for a student in the active period.
     *
     * @param  array<int|string, mixed>  $answersInput  e.g. [question_id => value | [option_id, ...]]
     * @throws InvalidArgumentException
     */
    public function saveAnswers(Student $student, Period $period, array $answersInput): void
    {
        if (! $period->is_active) {
            throw new InvalidArgumentException('Tidak dapat menyimpan jawaban pada periode yang tidak aktif.');
        }

        $activeQuestions = Question::where('is_active', true)
            ->with('options')
            ->get()
            ->keyBy('id');

        DB::transaction(function () use ($student, $period, $answersInput, $activeQuestions) {
            foreach ($answersInput as $questionId => $answerPayload) {
                // Ensure question is active
                if (! $activeQuestions->has($questionId)) {
                    continue; // Skip inactive or non-existent questions
                }

                $question = $activeQuestions->get($questionId);
                $validOptionIds = $question->options->pluck('id')->all();

                if (in_array($question->type, ['radio', 'likert'], true)) {
                    // Single choice option
                    $optionId = is_numeric($answerPayload) ? (int) $answerPayload : null;

                    if ($optionId !== null && in_array($optionId, $validOptionIds, true)) {
                        $selectedOption = $question->options->firstWhere('id', $optionId);

                        // Delete existing answers for this question and insert single answer
                        QuestionnaireAnswer::where('student_id', $student->id)
                            ->where('period_id', $period->id)
                            ->where('question_id', $question->id)
                            ->delete();

                        QuestionnaireAnswer::create([
                            'student_id' => $student->id,
                            'period_id' => $period->id,
                            'question_id' => $question->id,
                            'question_option_id' => $optionId,
                            'answer_value' => $selectedOption?->value,
                            'answer_text' => null,
                        ]);
                    }
                } elseif ($question->type === 'checkbox') {
                    // Multiple choice options
                    $selectedOptionIds = is_array($answerPayload) ? $answerPayload : [$answerPayload];
                    $selectedOptionIds = array_map('intval', array_filter($selectedOptionIds, 'is_numeric'));

                    // Filter only valid option IDs belonging to this question
                    $cleanOptionIds = array_intersect($selectedOptionIds, $validOptionIds);

                    // Delete existing answers for this question
                    QuestionnaireAnswer::where('student_id', $student->id)
                        ->where('period_id', $period->id)
                        ->where('question_id', $question->id)
                        ->delete();

                    // Insert rows for each selected option
                    foreach ($cleanOptionIds as $optId) {
                        $opt = $question->options->firstWhere('id', $optId);
                        QuestionnaireAnswer::create([
                            'student_id' => $student->id,
                            'period_id' => $period->id,
                            'question_id' => $question->id,
                            'question_option_id' => $optId,
                            'answer_value' => $opt?->value,
                            'answer_text' => null,
                        ]);
                    }
                } elseif ($question->type === 'textarea') {
                    // Text response
                    $text = is_string($answerPayload) ? trim($answerPayload) : null;

                    if (! empty($text)) {
                        QuestionnaireAnswer::where('student_id', $student->id)
                            ->where('period_id', $period->id)
                            ->where('question_id', $question->id)
                            ->delete();

                        QuestionnaireAnswer::create([
                            'student_id' => $student->id,
                            'period_id' => $period->id,
                            'question_id' => $question->id,
                            'question_option_id' => null,
                            'answer_value' => null,
                            'answer_text' => $text,
                        ]);
                    }
                }
            }
        });
    }

    /**
     * Validasi bahwa semua pertanyaan wajib aktif sudah dijawab.
     *
     * @return array<int, string> Daftar pesan error untuk pertanyaan wajib yang belum dijawab
     */
    public function validateRequiredQuestions(Student $student, Period $period): array
    {
        $requiredQuestions = Question::where('is_active', true)
            ->where('is_required', true)
            ->get();

        $answeredQuestionIds = QuestionnaireAnswer::where('student_id', $student->id)
            ->where('period_id', $period->id)
            ->distinct('question_id')
            ->pluck('question_id')
            ->all();

        $errors = [];
        foreach ($requiredQuestions as $q) {
            if (! in_array($q->id, $answeredQuestionIds, true)) {
                $errors[$q->id] = "Pertanyaan '{$q->question}' wajib dijawab.";
            }
        }

        return $errors;
    }
}
