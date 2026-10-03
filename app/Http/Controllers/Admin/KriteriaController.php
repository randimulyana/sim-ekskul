<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCriterionRequest;
use App\Http\Requests\Admin\UpdateCriterionRequest;
use App\Models\Criterion;
use App\Models\CriterionValue;
use App\Models\Extracurricular;
use App\Models\ExtracurricularCriterionMapping;
use App\Services\KonfigurasiKriteriaService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class KriteriaController extends Controller
{
    public function __construct(
        protected KonfigurasiKriteriaService $configService
    ) {}

    /**
     * Tampilkan daftar kriteria dan kelengkapan konfigurasi.
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
     * Tampilkan formulir untuk membuat kriteria baru.
     */
    public function create(): View
    {
        return view('admin.kriteria.create');
    }

    /**
     * Simpan kriteria yang baru dibuat ke database.
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

            // Otomatis menyediakan nilai skala standar 1-5
            foreach (KonfigurasiKriteriaService::STANDARD_SCALE as $scale) {
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
     * Tampilkan detail dan nilai skala kriteria yang ditentukan.
     */
    public function show(int|string $id): View
    {
        $criterion = Criterion::with(['values', 'questions.options'])->findOrFail($id);

        return view('admin.kriteria.show', compact('criterion'));
    }

    /**
     * Tampilkan formulir untuk mengedit kriteria yang ditentukan.
     */
    public function edit(int|string $id): View
    {
        $criterion = Criterion::findOrFail($id);

        return view('admin.kriteria.edit', compact('criterion'));
    }

    /**
     * Perbarui kriteria yang ditentukan di database.
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
     * Hapus kriteria yang ditentukan dari penyimpanan.
     */
    public function destroy(int|string $id): RedirectResponse
    {
        $criterion = Criterion::findOrFail($id);
        $code = strtoupper(trim($criterion->code));

        if (in_array($code, ['C1', 'C2', 'C3', 'C4', 'C5'], true)) {
            return redirect()->route('admin.kriteria.index')
                ->with('error', "Kriteria inti penelitian ({$code}) tidak dapat dihapus.");
        }

        $criterion->delete();

        return redirect()->route('admin.kriteria.index')
            ->with('success', "Kriteria {$code} berhasil dihapus.");
    }

    /**
     * Tampilkan status matriks pemetaan kriteria ekstrakurikuler.
     * Menandai NEEDS_VALIDATION secara tegas tanpa mengarang nilai ideal.
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
