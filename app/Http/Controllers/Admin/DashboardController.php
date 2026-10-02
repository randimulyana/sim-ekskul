<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Extracurricular;
use App\Models\Period;
use App\Models\Registration;
use App\Models\Student;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display admin dashboard with real statistics.
     */
    public function index(): View
    {
        $totalStudents = Student::count();
        $totalExtracurriculars = Extracurricular::where('is_active', true)->count();
        $totalRegistrations = Registration::count();
        $pendingRegistrations = Registration::whereIn('status', ['submitted', 'reviewed'])->count();

        $activePeriod = Period::where('is_active', true)->first();

        $recentRegistrations = Registration::with(['student.user', 'extracurricular'])
            ->latest()
            ->take(5)
            ->get();

        $ekskulStats = Extracurricular::withCount('registrations')
            ->orderByDesc('registrations_count')
            ->take(6)
            ->get();

        // Calculate percentage for progress bars in ekskul stats
        $maxRegistrations = $ekskulStats->max('registrations_count') ?: 1;
        $ekskulStats->each(function ($item) use ($maxRegistrations) {
            $item->percentage = $maxRegistrations > 0
                ? round(($item->registrations_count / $maxRegistrations) * 100)
                : 0;
        });

        return view('admin.dashboard', compact(
            'totalStudents',
            'totalExtracurriculars',
            'totalRegistrations',
            'pendingRegistrations',
            'activePeriod',
            'recentRegistrations',
            'ekskulStats'
        ));
    }
}
