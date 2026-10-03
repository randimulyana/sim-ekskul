<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateAdminPasswordRequest;
use App\Http\Requests\Admin\UpdateAdminProfileRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AdminProfileController extends Controller
{
    /**
     * Tampilkan halaman profil admin.
     */
    public function edit(): View
    {
        return view('admin.profil', [
            'user' => Auth::user(),
        ]);
    }

    /**
     * Perbarui informasi profil admin.
     */
    public function update(UpdateAdminProfileRequest $request): RedirectResponse
    {
        $user = Auth::user();

        $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
        ]);

        return redirect()->route('admin.profil')
            ->with('success', 'Profil administrator berhasil diperbarui.');
    }

    /**
     * Perbarui kata sandi admin.
     */
    public function updatePassword(UpdateAdminPasswordRequest $request): RedirectResponse
    {
        $user = Auth::user();

        $user->update([
            'password' => Hash::make($request->input('password')),
        ]);

        return redirect()->route('admin.profil')
            ->with('success', 'Kata sandi berhasil diperbarui.');
    }
}
