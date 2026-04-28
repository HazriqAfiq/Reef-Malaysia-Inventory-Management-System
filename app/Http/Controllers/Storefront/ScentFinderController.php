<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class ScentFinderController extends Controller
{
    public function index()
    {
        return view('storefront.scent-finder.index');
    }

    public function results(Request $request)
    {
        if ($request->isMethod('get') && !$request->has('answers')) {
            return redirect()->route('storefront.scent-finder');
        }

        $validated = $request->validate([
            'answers.vibe' => 'nullable|in:fresh,woody,floral',
            'answers.time' => 'nullable|in:day,night',
            'answers.intensity' => 'nullable|in:subtle,bold',
        ]);

        $answers = Arr::get($validated, 'answers', []);
        $scoringClauses = [];

        if (($answers['vibe'] ?? null) === 'fresh') {
            $scoringClauses[] = "(CASE WHEN LOWER(COALESCE(top_note, '')) LIKE '%citrus%' THEN 3 ELSE 0 END)";
            $scoringClauses[] = "(CASE WHEN LOWER(COALESCE(top_note, '')) LIKE '%bergamot%' THEN 2 ELSE 0 END)";
            $scoringClauses[] = "(CASE WHEN LOWER(COALESCE(top_note, '')) LIKE '%ocean%' THEN 2 ELSE 0 END)";
        } elseif (($answers['vibe'] ?? null) === 'woody') {
            $scoringClauses[] = "(CASE WHEN LOWER(COALESCE(base_note, '')) LIKE '%sandalwood%' THEN 3 ELSE 0 END)";
            $scoringClauses[] = "(CASE WHEN LOWER(COALESCE(base_note, '')) LIKE '%cedar%' THEN 2 ELSE 0 END)";
            $scoringClauses[] = "(CASE WHEN LOWER(COALESCE(base_note, '')) LIKE '%oud%' THEN 2 ELSE 0 END)";
        } elseif (($answers['vibe'] ?? null) === 'floral') {
            $scoringClauses[] = "(CASE WHEN LOWER(COALESCE(heart_note, '')) LIKE '%rose%' THEN 3 ELSE 0 END)";
            $scoringClauses[] = "(CASE WHEN LOWER(COALESCE(heart_note, '')) LIKE '%jasmine%' THEN 2 ELSE 0 END)";
            $scoringClauses[] = "(CASE WHEN LOWER(COALESCE(heart_note, '')) LIKE '%lavender%' THEN 2 ELSE 0 END)";
        }

        if (($answers['time'] ?? null) === 'day') {
            $scoringClauses[] = "(CASE WHEN LOWER(COALESCE(top_note, '')) LIKE '%citrus%' THEN 2 ELSE 0 END)";
            $scoringClauses[] = "(CASE WHEN LOWER(COALESCE(top_note, '')) LIKE '%green%' THEN 2 ELSE 0 END)";
        } elseif (($answers['time'] ?? null) === 'night') {
            $scoringClauses[] = "(CASE WHEN LOWER(COALESCE(base_note, '')) LIKE '%oud%' THEN 2 ELSE 0 END)";
            $scoringClauses[] = "(CASE WHEN LOWER(COALESCE(base_note, '')) LIKE '%amber%' THEN 2 ELSE 0 END)";
            $scoringClauses[] = "(CASE WHEN LOWER(COALESCE(base_note, '')) LIKE '%musk%' THEN 2 ELSE 0 END)";
        }

        if (($answers['intensity'] ?? null) === 'subtle') {
            $scoringClauses[] = "(CASE WHEN LOWER(COALESCE(heart_note, '')) LIKE '%lavender%' THEN 1 ELSE 0 END)";
            $scoringClauses[] = "(CASE WHEN LOWER(COALESCE(top_note, '')) LIKE '%green%' THEN 1 ELSE 0 END)";
        } elseif (($answers['intensity'] ?? null) === 'bold') {
            $scoringClauses[] = "(CASE WHEN LOWER(COALESCE(base_note, '')) LIKE '%oud%' THEN 2 ELSE 0 END)";
            $scoringClauses[] = "(CASE WHEN LOWER(COALESCE(base_note, '')) LIKE '%patchouli%' THEN 2 ELSE 0 END)";
            $scoringClauses[] = "(CASE WHEN LOWER(COALESCE(base_note, '')) LIKE '%amber%' THEN 1 ELSE 0 END)";
        }

        $query = Product::active()->with(['variants', 'images'])->withSum('sales', 'quantity');

        if (count($scoringClauses) > 0) {
            $scoreExpression = implode(' + ', $scoringClauses);
            $query->selectRaw("products.*, ({$scoreExpression}) as scent_score")
                ->orderByDesc('scent_score')
                ->latest('id');
        } else {
            $query->latest();
        }

        $recommendations = $query->limit(4)->get();

        if ($recommendations->isEmpty() && count($answers) > 0) {
            $recommendations = Product::active()
                ->with(['variants', 'images'])
                ->withSum('sales', 'quantity')
                ->latest('id')
                ->limit(4)
                ->get();
        }

        return view('storefront.scent-finder.results', compact('recommendations', 'answers'));
    }
}
