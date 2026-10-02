<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\Student\SaveQuestionnaireRequest;
use App\Services\QuestionnaireService;
use App\Services\SawRecommendationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class QuestionnaireController extends Controller
{
    public function __construct(
        protected QuestionnaireService $questionnaireService,
        protected SawRecommendationService $sawService
    ) {}

    /**
     * Display the questionnaire form.
     */
    public function index(): View
    {
        $user = Auth::user();
        $student = $user->getOrCreateStudent();
        $activePeriod = $this->questionnaireService->getActivePeriod();

        if (! $activePeriod) {
            return view('siswa.kuesioner.index', [
                'student' => $student,
                'activePeriod' => null,
                'questions' => collect(),
                'categories' => collect(),
                'existingAnswers' => [],
                'progress' => [
                    'total_questions' => 0,
                    'answered_questions' => 0,
                    'percentage' => 0,
                    'is_complete' => false,
                    'status' => 'belum_ada_periode',
                    'status_label' => 'Belum Ada Periode Aktif',
                ],
            ]);
        }

        $questions = $this->questionnaireService->getActiveQuestions();
        $existingAnswers = $this->questionnaireService->getStudentAnswers($student, $activePeriod);
        $progress = $student->getQuestionnaireProgress($activePeriod);

        // Group questions by category for multi-step presentation
        $categories = $questions->pluck('category')->unique()->values();

        return view('siswa.kuesioner.index', compact(
            'student',
            'activePeriod',
            'questions',
            'categories',
            'existingAnswers',
            'progress'
        ));
    }

    /**
     * Save student's answers to the active questionnaire.
     */
    public function store(SaveQuestionnaireRequest $request): RedirectResponse
    {
        $user = Auth::user();
        $student = $user->getOrCreateStudent();
        $activePeriod = $this->questionnaireService->getActivePeriod();

        if (! $activePeriod) {
            return redirect()->route('siswa.kuesioner.index')
                ->with('error', 'Tidak ada periode pendaftaran/kuesioner yang aktif saat ini.');
        }

        $answers = $request->input('answers', []);
        $this->questionnaireService->saveAnswers($student, $activePeriod, $answers);

        // Check if this is final submission
        $isFinal = $request->boolean('is_final', true);

        if ($isFinal) {
            $missing = $this->questionnaireService->validateRequiredQuestions($student, $activePeriod);
            if (! empty($missing)) {
                return redirect()->route('siswa.kuesioner.index')
                    ->withErrors($missing)
                    ->with('error', 'Mohon lengkapi seluruh pertanyaan wajib yang belum dijawab.');
            }

            return redirect()->route('siswa.kuesioner.analisis')
                ->with('success', 'Seluruh jawaban kuesioner berhasil disimpan.');
        }

        return redirect()->route('siswa.kuesioner.index')
            ->with('success', 'Progress jawaban kuesioner berhasil disimpan.');
    }

    /**
     * Display the questionnaire analyzing animation page.
     */
    public function analisis(): View
    {
        return view('siswa.kuesioner.analisis');
    }

    /**
     * Display questionnaire completion / recommendation results page.
     */
    public function hasil(): View
    {
        $user = Auth::user();
        $student = $user->getOrCreateStudent();
        $activePeriod = $this->questionnaireService->getActivePeriod();
        $progress = $student->getQuestionnaireProgress($activePeriod);

        $recommendationResult = null;
        if ($activePeriod) {
            $recommendationResult = $this->sawService->recommend($student, $activePeriod, persist: true);
        }

        return view('siswa.kuesioner.hasil', compact('student', 'activePeriod', 'progress', 'recommendationResult'));
    }
}
