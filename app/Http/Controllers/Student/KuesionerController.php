<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\Student\SaveQuestionnaireRequest;
use App\Services\KuesionerService;
use App\Services\RekomendasiSawService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class KuesionerController extends Controller
{
    public function __construct(
        protected KuesionerService $questionnaireService,
        protected RekomendasiSawService $sawService
    ) {}

    /**
     * Tampilkan formulir kuesioner.
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

        // Kelompokkan pertanyaan berdasarkan kategori untuk presentasi multi-langkah
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
     * Simpan jawaban siswa pada kuesioner yang aktif.
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

        // Periksa apakah ini adalah pengiriman final
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
     * Tampilkan halaman animasi pengolahan kuesioner.
     */
    public function analisis(): View
    {
        return view('siswa.kuesioner.analisis');
    }

    /**
     * Tampilkan halaman hasil penyelesaian kuesioner / hasil rekomendasi.
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
