<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Extracurricular;
use App\Models\Period;
use App\Models\Registration;
use App\Services\SawRecommendationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class RegistrationController extends Controller
{
    public function __construct(
        protected SawRecommendationService $sawService
    ) {}

    /**
     * Display registration form with selected extracurricular.
     */
    public function index(Request $request): View|RedirectResponse
    {
        $user = Auth::user();
        $student = $user->getOrCreateStudent();
        $activePeriod = Period::where('is_active', true)->first();

        // Check if student already registered in the active period
        $existingRegistration = null;
        if ($activePeriod) {
            $existingRegistration = Registration::where('student_id', $student->id)
                ->where('period_id', $activePeriod->id)
                ->with(['extracurricular', 'period'])
                ->first();
        }

        $extracurriculars = Extracurricular::where('is_active', true)
            ->orderBy('name')
            ->get();

        // Check if student has recommendation result
        $topRecommendation = null;
        $recommendationResult = null;
        if ($activePeriod) {
            $recommendationResult = $this->sawService->recommend($student, $activePeriod, persist: false);
            if (! empty($recommendationResult['ranking'])) {
                $topRecommendation = $recommendationResult['ranking'][0];
            }
        }

        // Determine preselected extracurricular
        $selectedEkskulId = $request->query('ekskul_id') ?? $request->query('ekskul');
        if (! $selectedEkskulId && $topRecommendation) {
            $selectedEkskulId = $topRecommendation['extracurricular_id'];
        }

        $selectedExtracurricular = $extracurriculars->firstWhere('id', (int) $selectedEkskulId)
            ?? $extracurriculars->first();

        return view('siswa.pendaftaran.index', compact(
            'student',
            'activePeriod',
            'existingRegistration',
            'extracurriculars',
            'selectedExtracurricular',
            'topRecommendation',
            'recommendationResult'
        ));
    }

    /**
     * Store student's extracurricular registration.
     */
    public function store(Request $request): RedirectResponse
    {
        $user = Auth::user();
        $student = $user->getOrCreateStudent();
        $activePeriod = Period::where('is_active', true)->first();

        if (! $activePeriod) {
            return redirect()->route('siswa.pendaftaran.index')
                ->with('error', 'Tidak ada periode pendaftaran yang aktif saat ini.');
        }

        // Check for duplicate registration in this period
        $alreadyRegistered = Registration::where('student_id', $student->id)
            ->where('period_id', $activePeriod->id)
            ->exists();

        if ($alreadyRegistered) {
            return redirect()->route('siswa.pendaftaran.sukses')
                ->with('info', 'Anda telah terdaftar pada periode pendaftaran ini.');
        }

        $validated = $request->validate([
            'extracurricular_id' => ['required', 'integer', 'exists:extracurriculars,id'],
            'motivation' => ['nullable', 'string', 'max:1000'],
            'agreement' => ['required'],
        ], [
            'extracurricular_id.required' => 'Pilihan ekstrakurikuler wajib ditentukan.',
            'extracurricular_id.exists' => 'Ekstrakurikuler yang dipilih tidak valid.',
            'agreement.required' => 'Anda wajib menyetujui pernyataan pendaftaran.',
        ]);

        $extracurricular = Extracurricular::where('id', $validated['extracurricular_id'])
            ->where('is_active', true)
            ->firstOrFail();

        // Generate unique registration number
        $randomSuffix = strtoupper(Str::random(4));
        $registrationNumber = sprintf(
            'REG-%s-%03d-%s',
            date('Y'),
            $student->id,
            $randomSuffix
        );

        $registration = Registration::create([
            'student_id' => $student->id,
            'period_id' => $activePeriod->id,
            'extracurricular_id' => $extracurricular->id,
            'registration_number' => $registrationNumber,
            'status' => 'submitted',
            'motivation' => $validated['motivation'] ?? null,
            'registered_at' => now(),
        ]);

        session(['latest_registration_id' => $registration->id]);

        return redirect()->route('siswa.pendaftaran.sukses')
            ->with('success', 'Pendaftaran ekstrakurikuler berhasil dikirim!');
    }

    /**
     * Display registration success page.
     */
    public function sukses(): View|RedirectResponse
    {
        $user = Auth::user();
        $student = $user->getOrCreateStudent();

        $registration = null;
        if (session('latest_registration_id')) {
            $registration = Registration::where('id', session('latest_registration_id'))
                ->where('student_id', $student->id)
                ->with(['extracurricular', 'period', 'student'])
                ->first();
        }

        if (! $registration) {
            $registration = $student->registrations()
                ->with(['extracurricular', 'period', 'student'])
                ->latest('id')
                ->first();
        }

        if (! $registration) {
            return redirect()->route('siswa.pendaftaran.index')
                ->with('info', 'Silakan pilih dan daftarkan ekstrakurikuler terlebih dahulu.');
        }

        return view('siswa.pendaftaran.sukses', compact('student', 'registration'));
    }

    /**
     * Display student's registration history.
     */
    public function riwayat(): View
    {
        $user = Auth::user();
        $student = $user->getOrCreateStudent();

        $registrations = $student->registrations()
            ->with(['extracurricular', 'period'])
            ->latest('registered_at')
            ->latest('id')
            ->get();

        return view('siswa.riwayat', compact('student', 'registrations'));
    }
}
