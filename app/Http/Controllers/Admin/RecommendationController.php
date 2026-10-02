<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Recommendation;
use Illuminate\View\View;

class RecommendationController extends Controller
{
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
