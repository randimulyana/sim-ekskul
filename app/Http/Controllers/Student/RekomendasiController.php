<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Extracurricular;
use App\Models\Period;
use App\Services\RekomendasiSawService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class RekomendasiController extends Controller
{
    public function __construct(
        protected RekomendasiSawService $sawService
    ) {}

    /**
     * Tampilkan hasil rekomendasi siswa.
     */
    public function index(): View
    {
        $user = Auth::user();
        $student = $user->getOrCreateStudent();
        $activePeriod = Period::where('is_active', true)->first();
        $progress = $student->getQuestionnaireProgress($activePeriod);

        $recommendationResult = $this->sawService->recommend($student, $activePeriod, persist: true);

        return view('siswa.rekomendasi.index', compact(
            'student',
            'activePeriod',
            'progress',
            'recommendationResult'
        ));
    }

    /**
     * Tampilkan detail ekstrakurikuler yang direkomendasikan.
     */
    public function show(int|string $id): View
    {
        $user = Auth::user();
        $student = $user->getOrCreateStudent();
        $activePeriod = Period::where('is_active', true)->first();
        $progress = $student->getQuestionnaireProgress($activePeriod);

        $extracurricular = Extracurricular::findOrFail($id);

        $recommendationResult = $this->sawService->recommend($student, $activePeriod, persist: false);

        // Temukan item peringkat untuk ekstrakurikuler ini jika tersedia
        $rankItem = null;
        if (! empty($recommendationResult['ranking'])) {
            $rankItem = collect($recommendationResult['ranking'])
                ->firstWhere('extracurricular_id', $extracurricular->id);
        }

        return view('siswa.rekomendasi.show', compact(
            'student',
            'activePeriod',
            'progress',
            'extracurricular',
            'rankItem',
            'recommendationResult'
        ));
    }
}
