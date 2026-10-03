<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Extracurricular;
use App\Models\Period;
use App\Models\Registration;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReportController extends Controller
{
    /**
     * Tampilkan laporan dan rekap data.
     */
    public function index(Request $request): View
    {
        $periods = Period::orderByDesc('start_date')->get();
        $selectedPeriodId = $request->input('period_id', Period::where('is_active', true)->value('id'));

        $query = Registration::query();
        if ($selectedPeriodId) {
            $query->where('period_id', $selectedPeriodId);
        }

        $totalRegistrations = (clone $query)->count();
        $totalAccepted = (clone $query)->where('status', 'accepted')->count();
        $totalReviewed = (clone $query)->whereIn('status', ['submitted', 'reviewed'])->count();
        $totalRejected = (clone $query)->where('status', 'rejected')->count();

        $ekskuls = Extracurricular::withCount([
            'registrations as total_pendaftar' => function ($q) use ($selectedPeriodId) {
                if ($selectedPeriodId) {
                    $q->where('period_id', $selectedPeriodId);
                }
            },
            'registrations as diterima_count' => function ($q) use ($selectedPeriodId) {
                $q->where('status', 'accepted');
                if ($selectedPeriodId) {
                    $q->where('period_id', $selectedPeriodId);
                }
            },
            'registrations as menunggu_count' => function ($q) use ($selectedPeriodId) {
                $q->whereIn('status', ['submitted', 'reviewed']);
                if ($selectedPeriodId) {
                    $q->where('period_id', $selectedPeriodId);
                }
            },
            'registrations as ditolak_count' => function ($q) use ($selectedPeriodId) {
                $q->where('status', 'rejected');
                if ($selectedPeriodId) {
                    $q->where('period_id', $selectedPeriodId);
                }
            },
        ])->orderBy('name')->get();

        return view('admin.laporan', compact(
            'periods',
            'selectedPeriodId',
            'totalRegistrations',
            'totalAccepted',
            'totalReviewed',
            'totalRejected',
            'ekskuls'
        ));
    }
}
