<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateRegistrationStatusRequest;
use App\Models\Extracurricular;
use App\Models\Registration;
use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RegistrationController extends Controller
{
    /**
     * Tampilkan daftar pendaftaran dengan filter.
     */
    public function index(Request $request): View
    {
        $query = Registration::with(['student.user', 'extracurricular', 'period']);

        if ($search = $request->input('search')) {
            $query->whereHas('student', function ($sq) use ($search) {
                $sq->where('nis', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($uq) use ($search) {
                        $uq->where('name', 'like', "%{$search}%");
                    });
            });
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        if ($ekskulId = $request->input('ekskul')) {
            $query->where('extracurricular_id', $ekskulId);
        }

        if ($class = $request->input('class')) {
            $query->whereHas('student', function ($sq) use ($class) {
                $sq->where('class_name', $class);
            });
        }

        $registrations = $query->latest()->paginate(10)->withQueryString();

        $extracurriculars = Extracurricular::orderBy('name')->get();
        $classes = Student::select('class_name')->distinct()->orderBy('class_name')->pluck('class_name');

        return view('admin.pendaftaran.index', compact('registrations', 'extracurriculars', 'classes'));
    }

    /**
     * Tampilkan detail pendaftaran yang ditentukan.
     */
    public function show(int|string $id): View
    {
        $registration = Registration::with([
            'student.user',
            'student.recommendations.items.extracurricular',
            'extracurricular',
            'period',
        ])->findOrFail($id);

        return view('admin.pendaftaran.show', compact('registration'));
    }

    /**
     * Perbarui status dan catatan pendaftaran.
     */
    public function updateStatus(UpdateRegistrationStatusRequest $request, int|string $id): RedirectResponse
    {
        $registration = Registration::findOrFail($id);

        $registration->update([
            'status' => $request->input('status'),
            'notes' => $request->input('notes', $registration->notes),
        ]);

        $statusLabels = [
            'submitted' => 'Terkirim',
            'reviewed' => 'Ditinjau',
            'accepted' => 'Diterima',
            'rejected' => 'Ditolak',
            'cancelled' => 'Dibatalkan',
        ];
        $label = $statusLabels[$request->input('status')] ?? $request->input('status');

        return redirect()->route('admin.pendaftaran.show', $registration->id)
            ->with('success', "Status pendaftaran berhasil diperbarui menjadi: {$label}.");
    }
}
