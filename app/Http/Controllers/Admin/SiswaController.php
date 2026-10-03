<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreSiswaRequest;
use App\Http\Requests\Admin\UpdateSiswaRequest;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class SiswaController extends Controller
{
    /**
     * Tampilkan daftar siswa dengan filter dan paginasi.
     */
    public function index(Request $request): View
    {
        $query = Student::with('user');

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('nis', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($uq) use ($search) {
                        $uq->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        if ($class = $request->input('class')) {
            $query->where('class_name', $class);
        }

        if ($status = $request->input('status')) {
            $normalizedStatus = match (strtolower($status)) {
                'aktif', 'active' => 'active',
                'nonaktif', 'inactive' => 'inactive',
                default => $status,
            };
            $query->where('status', $normalizedStatus);
        }

        $students = $query->latest()->paginate(10)->withQueryString();

        $classes = Student::query()
            ->select('class_name')
            ->distinct()
            ->orderBy('class_name')
            ->pluck('class_name');

        return view('admin.siswa.index', compact('students', 'classes'));
    }

    /**
     * Tampilkan formulir untuk membuat siswa baru.
     */
    public function create(): View
    {
        return view('admin.siswa.create');
    }

    /**
     * Simpan siswa yang baru dibuat beserta akun pengguna terkait.
     */
    public function store(StoreSiswaRequest $request): RedirectResponse
    {
        DB::transaction(function () use ($request) {
            $cleanNis = preg_replace('/[^a-zA-Z0-9]/', '', $request->input('nis'));
            $email = $request->input('email') ?: (strtolower($cleanNis) . '@smkn3payakumbuh.sch.id');

            // Pastikan email unik
            $baseEmail = $email;
            $counter = 1;
            while (User::where('email', $email)->exists()) {
                $email = str_replace('@', "_{$counter}@", $baseEmail);
                $counter++;
            }

            $user = User::create([
                'name' => $request->input('name'),
                'email' => $email,
                'password' => Hash::make('password'),
                'role' => 'student',
            ]);

            $status = in_array(strtolower($request->input('status')), ['aktif', 'active'], true) ? 'active' : 'inactive';

            Student::create([
                'user_id' => $user->id,
                'nis' => $request->input('nis'),
                'class_name' => $request->input('class_name'),
                'whatsapp' => $request->input('whatsapp'),
                'status' => $status,
            ]);
        });

        return redirect()->route('admin.siswa.index')->with('success', 'Data siswa berhasil ditambahkan.');
    }

    /**
     * Tampilkan detail siswa yang ditentukan.
     */
    public function show(int|string $id): View
    {
        $student = Student::with([
            'user',
            'registrations.extracurricular',
            'registrations.period',
            'recommendations.items.extracurricular',
        ])->findOrFail($id);

        return view('admin.siswa.show', compact('student'));
    }

    /**
     * Tampilkan formulir untuk mengedit siswa yang ditentukan.
     */
    public function edit(int|string $id): View
    {
        $student = Student::with('user')->findOrFail($id);

        return view('admin.siswa.edit', compact('student'));
    }

    /**
     * Perbarui data siswa dan pengguna terkait.
     */
    public function update(UpdateSiswaRequest $request, int|string $id): RedirectResponse
    {
        $student = Student::with('user')->findOrFail($id);

        DB::transaction(function () use ($request, $student) {
            $student->user->update([
                'name' => $request->input('name'),
                'email' => $request->input('email') ?: $student->user->email,
            ]);

            $status = in_array(strtolower($request->input('status')), ['aktif', 'active'], true) ? 'active' : 'inactive';

            $student->update([
                'nis' => $request->input('nis'),
                'class_name' => $request->input('class_name'),
                'whatsapp' => $request->input('whatsapp'),
                'status' => $status,
            ]);
        });

        return redirect()->route('admin.siswa.index')->with('success', 'Data siswa berhasil diperbarui.');
    }

    /**
     * Hapus siswa yang ditentukan dari penyimpanan.
     */
    public function destroy(int|string $id): RedirectResponse
    {
        $student = Student::with('user')->findOrFail($id);

        DB::transaction(function () use ($student) {
            $user = $student->user;
            $student->delete();
            $user?->delete();
        });

        return redirect()->route('admin.siswa.index')->with('success', 'Data siswa berhasil dihapus.');
    }
}
