<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Extracurricular;
use App\Models\Period;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the student dashboard.
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
            'popularEkskuls'
        ));
    }
}
