<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Extracurricular;
use App\Models\Period;
use App\Services\SawRecommendationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class RecommendationController extends Controller
{
    public function __construct(
        protected SawRecommendationService $sawService
    ) {}

    /**
     * Display student recommendation results.
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
     * Display details for a specific recommended extracurricular.
     */
    public function show(int|string $id): View
    {
        $user = Auth::user();
        $student = $user->getOrCreateStudent();
        $activePeriod = Period::where('is_active', true)->first();
        $progress = $student->getQuestionnaireProgress($activePeriod);

        $extracurricular = Extracurricular::findOrFail($id);

        $recommendationResult = $this->sawService->recommend($student, $activePeriod, persist: false);

        // Find ranking item for this extracurricular if available
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
