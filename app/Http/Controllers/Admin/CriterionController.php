<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCriterionRequest;
use App\Http\Requests\Admin\UpdateCriterionRequest;
use App\Models\Criterion;
use App\Models\CriterionValue;
use App\Models\Extracurricular;
use App\Models\ExtracurricularCriterionMapping;
use App\Services\CriteriaConfigurationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CriterionController extends Controller
{
    public function __construct(
        protected CriteriaConfigurationService $configService
    ) {}

    /**
     * Display a listing of criteria and configuration completeness.
     */
    public function index(): View
    {
        $criteria = Criterion::with(['values', 'questions'])
            ->orderBy('code')
            ->get();

        $totalWeight = Criterion::getTotalWeight();
        $isWeightValid = Criterion::isTotalWeightValid();
        $completeness = $this->configService->checkCompleteness();

        return view('admin.kriteria.index', compact(
            'criteria',
            'totalWeight',
            'isWeightValid',
            'completeness'
        ));
    }

    /**
     * Show the form for creating a new criterion.
     */
    public function create(): View
    {
        return view('admin.kriteria.create');
    }

    /**
     * Store a newly created criterion in storage.
     */
    public function store(StoreCriterionRequest $request): RedirectResponse
    {
        DB::transaction(function () use ($request) {
            $criterion = Criterion::create([
                'code' => $request->input('code'),
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'type' => $request->input('type'),
                'weight' => $request->input('weight'),
                'status' => $request->input('status', 'proposed'),
                'is_active' => $request->boolean('is_active', true),
            ]);

            // Automatically provide standard 1-5 scale values
            foreach (CriteriaConfigurationService::STANDARD_SCALE as $scale) {
                CriterionValue::create([
                    'criterion_id' => $criterion->id,
                    'label' => $scale['label'],
                    'value' => $scale['value'],
                    'sort_order' => $scale['sort_order'],
                    'description' => "Skala {$scale['value']} ({$scale['label']}) [PROPOSED / NEEDS VALIDATION]",
                ]);
            }
        });

        return redirect()->route('admin.kriteria.index')
            ->with('success', 'Kriteria baru berhasil ditambahkan beserta skala indikator 1-5.');
    }

    /**
     * Display the specified criterion details and scale values.
     */
    public function show(int|string $id): View
    {
        $criterion = Criterion::with(['values', 'questions.options'])->findOrFail($id);

        return view('admin.kriteria.show', compact('criterion'));
    }

    /**
     * Show the form for editing the specified criterion.
     */
    public function edit(int|string $id): View
    {
        $criterion = Criterion::findOrFail($id);

        return view('admin.kriteria.edit', compact('criterion'));
    }

    /**
     * Update the specified criterion in storage.
     */
    public function update(UpdateCriterionRequest $request, int|string $id): RedirectResponse
    {
        $criterion = Criterion::findOrFail($id);

        $criterion->update([
            'code' => $request->input('code'),
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'type' => $request->input('type'),
            'weight' => $request->input('weight'),
            'status' => $request->input('status', $criterion->status),
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.kriteria.index')
            ->with('success', "Kriteria {$criterion->code} berhasil diperbarui.");
    }

    /**
     * Remove the specified criterion from storage.
     */
    public function destroy(int|string $id): RedirectResponse
    {
        $criterion = Criterion::findOrFail($id);
        $code = $criterion->code;
        $criterion->delete();

        return redirect()->route('admin.kriteria.index')
            ->with('success', "Kriteria {$code} berhasil dihapus.");
    }

    /**
     * Display extracurricular criterion mapping matrix status.
     * Strictly indicates NEEDS_VALIDATION without inventing ideal scores.
     */
    public function mapping(): View
    {
        $extracurriculars = Extracurricular::where('is_active', true)
            ->orderBy('name')
            ->get();

        $criteria = Criterion::where('is_active', true)
            ->orderBy('code')
            ->get();

        $mappings = ExtracurricularCriterionMapping::all()
            ->groupBy(fn ($item) => "{$item->extracurricular_id}_{$item->criterion_id}");

        $completeness = $this->configService->checkCompleteness();

        return view('admin.kriteria.mapping', compact(
            'extracurriculars',
            'criteria',
            'mappings',
            'completeness'
        ));
    }
}
