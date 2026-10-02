<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Period;
use App\Models\QuestionnaireAnswer;
use App\Models\Recommendation;
use App\Models\Student;
use App\Services\DecisionMatrixService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RecommendationController extends Controller
{
    public function __construct(
        protected DecisionMatrixService $matrixService
    ) {}

    /**
     * Display a listing of recommendation results.
     */
    public function index(): View
    {
        $recommendations = Recommendation::with([
            'student.user',
            'items.extracurricular',
        ])->latest()->paginate(10);

        return view('admin.rekomendasi.index', compact('recommendations'));
    }

    /**
     * Preview Decision Matrix X for a student (Phase 5A Debug & Validation).
     */
    public function matrixPreview(Request $request): View
    {
        $activePeriod = Period::where('is_active', true)->first();
        $students = Student::with('user')->get()->sortBy(fn ($s) => $s->user?->name ?? '')->values();

        // Select student: either from query param or the first student with answers, or first student in DB
        $selectedStudent = null;
        if ($request->filled('student_id')) {
            $selectedStudent = Student::find($request->input('student_id'));
        }

        if (! $selectedStudent && $activePeriod) {
            $firstAnswerStudentId = QuestionnaireAnswer::where('period_id', $activePeriod->id)
                ->value('student_id');

            if ($firstAnswerStudentId) {
                $selectedStudent = Student::find($firstAnswerStudentId);
            }
        }

        if (! $selectedStudent) {
            $selectedStudent = $students->first();
        }

        $matrixData = $selectedStudent
            ? $this->matrixService->build($selectedStudent, $activePeriod)
            : null;

        return view('admin.rekomendasi.matrix', compact(
            'students',
            'selectedStudent',
            'matrixData',
            'activePeriod'
        ));
    }

    /**
     * Display the specified recommendation result.
     */
    public function show(int|string $id): View
    {
        $recommendation = Recommendation::with([
            'student.user',
            'items.extracurricular',
        ])->findOrFail($id);

        return view('admin.rekomendasi.show', compact('recommendation'));
    }
}
