<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePeriodRequest;
use App\Http\Requests\Admin\UpdatePeriodRequest;
use App\Models\Period;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PeriodController extends Controller
{
    /**
     * Display period management page.
     */
    public function index(): View
    {
        $activePeriod = Period::where('is_active', true)->first();
        $periods = Period::orderByDesc('start_date')->get();

        return view('admin.pengaturan', compact('activePeriod', 'periods'));
    }

    /**
     * Store a newly created period.
     */
    public function store(StorePeriodRequest $request): RedirectResponse
    {
        DB::transaction(function () use ($request) {
            $isActive = $request->boolean('is_active', false);

            if ($isActive) {
                Period::query()->update(['is_active' => false]);
            }

            Period::create([
                'name' => $request->input('name'),
                'school_year' => $request->input('school_year'),
                'start_date' => $request->input('start_date'),
                'end_date' => $request->input('end_date'),
                'is_active' => $isActive,
                'description' => $request->input('description'),
            ]);
        });

        return redirect()->route('admin.pengaturan')
            ->with('success', 'Periode pendaftaran berhasil ditambahkan.');
    }

    /**
     * Update the specified period.
     */
    public function update(UpdatePeriodRequest $request, int|string $id): RedirectResponse
    {
        $period = Period::findOrFail($id);

        DB::transaction(function () use ($request, $period) {
            $isActive = $request->has('is_active') ? $request->boolean('is_active') : $period->is_active;

            if ($isActive && ! $period->is_active) {
                Period::where('id', '!=', $period->id)->update(['is_active' => false]);
            }

            $period->update([
                'name' => $request->input('name'),
                'school_year' => $request->input('school_year'),
                'start_date' => $request->input('start_date'),
                'end_date' => $request->input('end_date'),
                'is_active' => $isActive,
                'description' => $request->input('description'),
            ]);
        });

        return redirect()->route('admin.pengaturan')
            ->with('success', 'Periode pendaftaran berhasil diperbarui.');
    }

    /**
     * Toggle the active status of the period.
     */
    public function toggleStatus(int|string $id): RedirectResponse
    {
        $period = Period::findOrFail($id);

        DB::transaction(function () use ($period) {
            if ($period->is_active) {
                $period->update(['is_active' => false]);
            } else {
                Period::where('id', '!=', $period->id)->update(['is_active' => false]);
                $period->update(['is_active' => true]);
            }
        });

        $statusStr = $period->fresh()->is_active ? 'dibuka' : 'ditutup';

        return redirect()->route('admin.pengaturan')
            ->with('success', "Periode pendaftaran berhasil {$statusStr}.");
    }
}
