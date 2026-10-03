<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreEkstrakurikulerRequest;
use App\Http\Requests\Admin\UpdateEkstrakurikulerRequest;
use App\Models\Extracurricular;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class EkstrakurikulerController extends Controller
{
    /**
     * Tampilkan daftar ekstrakurikuler.
     */
    public function index(Request $request): View
    {
        $query = Extracurricular::withCount('registrations');

        if ($search = $request->input('search')) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%")
                ->orWhere('coach_name', 'like', "%{$search}%");
        }

        if ($category = $request->input('category')) {
            $query->where('category', $category);
        }

        if ($status = $request->input('status')) {
            $isActive = in_array(strtolower($status), ['aktif', 'active', '1', 1], true);
            $query->where('is_active', $isActive);
        }

        $extracurriculars = $query->orderBy('name')->paginate(15)->withQueryString();

        $categories = Extracurricular::query()
            ->select('category')
            ->whereNotNull('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        return view('admin.ekstrakurikuler.index', compact('extracurriculars', 'categories'));
    }

    /**
     * Tampilkan formulir untuk membuat ekstrakurikuler baru.
     */
    public function create(): View
    {
        return view('admin.ekstrakurikuler.create');
    }

    /**
     * Simpan ekstrakurikuler yang baru dibuat.
     */
    public function store(StoreEkstrakurikulerRequest $request): RedirectResponse
    {
        $baseSlug = Str::slug($request->input('name'));
        $slug = $baseSlug;
        $counter = 1;
        while (Extracurricular::where('slug', $slug)->exists()) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        Extracurricular::create([
            'name' => $request->input('name'),
            'slug' => $slug,
            'category' => $request->input('category'),
            'description' => $request->input('description'),
            'schedule_info' => $request->input('schedule') ?? $request->input('schedule_info'),
            'location_info' => $request->input('location') ?? $request->input('location_info'),
            'coach_name' => $request->input('coach_name'),
            'quota' => $request->input('quota'),
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.ekstrakurikuler.index')
            ->with('success', 'Ekstrakurikuler berhasil ditambahkan.');
    }

    /**
     * Tampilkan detail ekstrakurikuler yang ditentukan.
     */
    public function show(int|string $id): View
    {
        $extracurricular = Extracurricular::with([
            'registrations.student.user',
            'registrations.period',
        ])->withCount('registrations')->findOrFail($id);

        return view('admin.ekstrakurikuler.show', compact('extracurricular'));
    }

    /**
     * Tampilkan formulir untuk mengedit ekstrakurikuler yang ditentukan.
     */
    public function edit(int|string $id): View
    {
        $extracurricular = Extracurricular::findOrFail($id);

        return view('admin.ekstrakurikuler.edit', compact('extracurricular'));
    }

    /**
     * Perbarui ekstrakurikuler yang ditentukan.
     */
    public function update(UpdateEkstrakurikulerRequest $request, int|string $id): RedirectResponse
    {
        $extracurricular = Extracurricular::findOrFail($id);

        $data = [
            'name' => $request->input('name'),
            'category' => $request->input('category'),
            'description' => $request->input('description'),
            'schedule_info' => $request->input('schedule') ?? $request->input('schedule_info') ?? $extracurricular->schedule_info,
            'location_info' => $request->input('location') ?? $request->input('location_info') ?? $extracurricular->location_info,
            'coach_name' => $request->input('coach_name'),
            'quota' => $request->input('quota'),
            'is_active' => $request->has('is_active') ? $request->boolean('is_active') : $extracurricular->is_active,
        ];

        if ($request->input('name') !== $extracurricular->name) {
            $baseSlug = Str::slug($request->input('name'));
            $slug = $baseSlug;
            $counter = 1;
            while (Extracurricular::where('slug', $slug)->where('id', '!=', $extracurricular->id)->exists()) {
                $slug = "{$baseSlug}-{$counter}";
                $counter++;
            }
            $data['slug'] = $slug;
        }

        $extracurricular->update($data);

        return redirect()->route('admin.ekstrakurikuler.index')
            ->with('success', 'Ekstrakurikuler berhasil diperbarui.');
    }

    /**
     * Hapus ekstrakurikuler yang ditentukan.
     */
    public function destroy(int|string $id): RedirectResponse
    {
        $extracurricular = Extracurricular::findOrFail($id);

        if ($extracurricular->registrations()->exists()) {
            return redirect()->route('admin.ekstrakurikuler.index')
                ->with('error', 'Ekstrakurikuler tidak dapat dihapus karena sudah memiliki data pendaftaran siswa. Silakan nonaktifkan status ekstrakurikuler jika kegiatan sudah tidak aktif.');
        }

        $extracurricular->delete();

        return redirect()->route('admin.ekstrakurikuler.index')
            ->with('success', 'Ekstrakurikuler berhasil dihapus.');
    }
}
