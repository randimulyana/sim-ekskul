<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\Student\UpdateStudentProfileRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the student profile.
     */
    public function show(): View
    {
        $user = Auth::user();
        $student = $user->getOrCreateStudent();
        $questionnaireProgress = $student->getQuestionnaireProgress();

        return view('siswa.profil', compact('user', 'student', 'questionnaireProgress'));
    }

    /**
     * Update the student profile and account settings.
     */
    public function update(UpdateStudentProfileRequest $request): RedirectResponse
    {
        $user = Auth::user();
        $student = $user->getOrCreateStudent();

        DB::transaction(function () use ($request, $user, $student) {
            $user->update([
                'name' => $request->input('name'),
            ]);

            if ($request->filled('password')) {
                $user->update([
                    'password' => Hash::make($request->input('password')),
                ]);
            }

            $student->update([
                'whatsapp' => $request->input('whatsapp'),
            ]);
        });

        return redirect()->route('siswa.profil')
            ->with('success', 'Profil berhasil diperbarui.');
    }
}
