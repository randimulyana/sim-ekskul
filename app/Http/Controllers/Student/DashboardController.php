<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Extracurricular;
use App\Models\Period;
use App\Services\RekomendasiSawService;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(
        protected RekomendasiSawService $sawService
    ) {}

    /**
     * Tampilkan dashboard siswa.
     */
    public function index(): View
    {
        $user = Auth::user();
        $student = $user->getOrCreateStudent();
        $activePeriod = Period::where('is_active', true)->first();
        $totalActiveEkskuls = Extracurricular::where('is_active', true)->count();
        $questionnaireProgress = $student->getQuestionnaireProgress($activePeriod);
        $latestRegistration = $student->registrations()->with('extracurricular')->latest()->first();
        $profileCompletion = $student->getProfileCompletionPercentage();

        $topRecommendations = [];
        if ($activePeriod && $questionnaireProgress['is_complete']) {
            $rec = $this->sawService->recommend($student, $activePeriod, persist: false);
            if (($rec['status'] ?? '') === 'READY' && ! empty($rec['ranking'])) {
                $topRecommendations = array_slice($rec['ranking'], 0, 3);
            }
        }

        $popularEkskuls = Extracurricular::where('is_active', true)
            ->withCount('registrations')
            ->orderByDesc('registrations_count')
            ->orderBy('name')
            ->take(4)
            ->get();

        return view('siswa.dashboard', compact(
            'user',
            'student',
            'activePeriod',
            'totalActiveEkskuls',
            'questionnaireProgress',
            'latestRegistration',
            'profileCompletion',
            'topRecommendations',
            'popularEkskuls'
        ));
    }
}
