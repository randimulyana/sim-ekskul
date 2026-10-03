<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Extracurricular;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ExtracurricularController extends Controller
{
    /**
     * Tampilkan daftar ekstrakurikuler aktif untuk siswa.
     */
    public function index(Request $request): View
    {
        $query = Extracurricular::where('is_active', true)
            ->withCount('registrations');

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('coach_name', 'like', "%{$search}%");
            });
        }

        if ($category = $request->input('category')) {
            if ($category !== 'all') {
                $query->where('category', $category);
            }
        }

        $extracurriculars = $query->orderBy('name')->get();

        $categories = Extracurricular::where('is_active', true)
            ->whereNotNull('category')
            ->select('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        return view('siswa.ekstrakurikuler.index', compact('extracurriculars', 'categories'));
    }

    /**
     * Tampilkan detail ekstrakurikuler aktif yang ditentukan.
     */
    public function show(int|string $id): View
    {
        $extracurricular = Extracurricular::where('is_active', true)
            ->withCount('registrations')
            ->findOrFail($id);

        return view('siswa.ekstrakurikuler.show', compact('extracurricular'));
    }
}
