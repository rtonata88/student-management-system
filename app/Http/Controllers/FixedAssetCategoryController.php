<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FixedAssetCategory;

class FixedAssetCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:fixed-assets-categories-manage');
    }

    /**
     * Display a listing of fixed asset categories.
     */
    public function index()
    {
        $categories = FixedAssetCategory::withCount('assets')
                                     ->orderBy('name')
                                     ->paginate(15);

        return view('fixed-assets.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new category.
     */
    public function create()
    {
        return view('fixed-assets.categories.create');
    }

    /**
     * Store a newly created category.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:fixed_asset_categories,name',
            'description' => 'nullable|string',
            'color' => 'required|string|size:7',
            'depreciation_rate' => 'nullable|numeric|min:0|max:100',
            'useful_life_years' => 'nullable|integer|min:1|max:50',
            'active' => 'boolean'
        ]);

        FixedAssetCategory::create($request->all());

        return redirect()->route('fixed-asset-categories.index')
                        ->with('success', 'Fixed asset category created successfully.');
    }

    /**
     * Display the specified category.
     */
    public function show(FixedAssetCategory $fixedAssetCategory)
    {
        $fixedAssetCategory->load(['assets' => function($query) {
            $query->orderBy('created_at', 'desc');
        }]);

        return view('fixed-assets.categories.show', compact('fixedAssetCategory'));
    }

    /**
     * Show the form for editing the specified category.
     */
    public function edit(FixedAssetCategory $fixedAssetCategory)
    {
        return view('fixed-assets.categories.edit', compact('fixedAssetCategory'));
    }

    /**
     * Update the specified category.
     */
    public function update(Request $request, FixedAssetCategory $fixedAssetCategory)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:fixed_asset_categories,name,' . $fixedAssetCategory->id,
            'description' => 'nullable|string',
            'color' => 'required|string|size:7',
            'depreciation_rate' => 'nullable|numeric|min:0|max:100',
            'useful_life_years' => 'nullable|integer|min:1|max:50',
            'active' => 'boolean'
        ]);

        $fixedAssetCategory->update($request->all());

        return redirect()->route('fixed-asset-categories.index')
                        ->with('success', 'Fixed asset category updated successfully.');
    }

    /**
     * Remove the specified category.
     */
    public function destroy(FixedAssetCategory $fixedAssetCategory)
    {
        if ($fixedAssetCategory->assets()->count() > 0) {
            return redirect()->route('fixed-asset-categories.index')
                            ->with('error', 'Cannot delete category that has assets assigned to it.');
        }

        $fixedAssetCategory->delete();

        return redirect()->route('fixed-asset-categories.index')
                        ->with('success', 'Fixed asset category deleted successfully.');
    }
}
