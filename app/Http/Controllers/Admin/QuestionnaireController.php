<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreQuestionRequest;
use App\Http\Requests\Admin\UpdateQuestionRequest;
use App\Models\Question;
use App\Models\QuestionOption;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class QuestionnaireController extends Controller
{
    /**
     * Display a listing of questionnaire questions.
     */
    public function index(): View
    {
        $questions = Question::with('options')
            ->orderBy('order')
            ->paginate(15);

        return view('admin.kuesioner.index', compact('questions'));
    }

    /**
     * Show the form for creating a new question.
     */
    public function create(): View
    {
        return view('admin.kuesioner.create');
    }

    /**
     * Store a newly created question with optional options.
     */
    public function store(StoreQuestionRequest $request): RedirectResponse
    {
        DB::transaction(function () use ($request) {
            $maxOrder = Question::max('sort_order') ?: 0;
            $order = $request->input('sort_order') ?: $request->input('order') ?: ($maxOrder + 1);
            $qText = $request->input('question') ?? $request->input('question_text') ?? $request->input('teks_pertanyaan');

            $question = Question::create([
                'question' => $qText,
                'category' => $request->input('category'),
                'type' => $request->input('type'),
                'sort_order' => $order,
                'is_active' => $request->has('is_active') ? $request->boolean('is_active') : true,
            ]);

            // Save options if provided
            $options = $request->input('options', []);
            if (is_array($options) && in_array($request->input('type'), ['radio', 'checkbox'], true)) {
                $optOrder = 1;
                foreach ($options as $opt) {
                    $text = is_array($opt) ? ($opt['option_text'] ?? $opt['text'] ?? $opt['label'] ?? '') : (string) $opt;
                    $score = is_array($opt) ? ($opt['score_value'] ?? $opt['score'] ?? $opt['value'] ?? null) : null;
                    if (trim($text) !== '') {
                        QuestionOption::create([
                            'question_id' => $question->id,
                            'label' => trim($text),
                            'value' => $score,
                            'sort_order' => $optOrder++,
                        ]);
                    }
                }
            }
        });

        return redirect()->route('admin.kuesioner.index')
            ->with('success', 'Pertanyaan kuesioner berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified question.
     */
    public function edit(int|string $id): View
    {
        $question = Question::with('options')->findOrFail($id);

        return view('admin.kuesioner.edit', compact('question'));
    }

    /**
     * Update the specified question and its options.
     */
    public function update(UpdateQuestionRequest $request, int|string $id): RedirectResponse
    {
        $question = Question::with('options')->findOrFail($id);

        DB::transaction(function () use ($request, $question) {
            $qText = $request->input('question') ?? $request->input('question_text') ?? $request->input('teks_pertanyaan') ?? $question->question;
            $order = $request->input('sort_order') ?: $request->input('order') ?: $question->sort_order;

            $question->update([
                'question' => $qText,
                'category' => $request->input('category'),
                'type' => $request->input('type'),
                'sort_order' => $order,
                'is_active' => $request->has('is_active') ? $request->boolean('is_active') : $question->is_active,
            ]);

            $options = $request->input('options');
            if (is_array($options) && in_array($request->input('type'), ['radio', 'checkbox'], true)) {
                // Delete existing and re-create options cleanly
                $question->options()->delete();
                $optOrder = 1;
                foreach ($options as $opt) {
                    $text = is_array($opt) ? ($opt['option_text'] ?? $opt['text'] ?? $opt['label'] ?? '') : (string) $opt;
                    $score = is_array($opt) ? ($opt['score_value'] ?? $opt['score'] ?? $opt['value'] ?? null) : null;
                    if (trim($text) !== '') {
                        QuestionOption::create([
                            'question_id' => $question->id,
                            'label' => trim($text),
                            'value' => $score,
                            'sort_order' => $optOrder++,
                        ]);
                    }
                }
            }
        });

        return redirect()->route('admin.kuesioner.index')
            ->with('success', 'Pertanyaan kuesioner berhasil diperbarui.');
    }

    /**
     * Toggle active status of the question.
     */
    public function toggleStatus(int|string $id): RedirectResponse
    {
        $question = Question::findOrFail($id);
        $question->update(['is_active' => ! $question->is_active]);

        $statusStr = $question->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()->route('admin.kuesioner.index')
            ->with('success', "Pertanyaan berhasil {$statusStr}.");
    }

    /**
     * Remove the specified question.
     */
    public function destroy(int|string $id): RedirectResponse
    {
        $question = Question::findOrFail($id);
        $question->delete();

        return redirect()->route('admin.kuesioner.index')
            ->with('success', 'Pertanyaan kuesioner berhasil dihapus.');
    }
}
