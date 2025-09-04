<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AssetCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class AssetCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view-asset-categories')->only(['index', 'show']);
        $this->middleware('permission:create-asset-categories')->only(['create', 'store']);
        $this->middleware('permission:edit-asset-categories')->only(['edit', 'update']);
        $this->middleware('permission:delete-asset-categories')->only(['destroy']);
        $this->middleware('permission:toggle-asset-category-status')->only(['toggleStatus']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = AssetCategory::with(['creator', 'updater']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('code', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }

        // Status filter
        if ($request->filled('status')) {
            if ($request->get('status') === 'active') {
                $query->where('is_active', true);
            } elseif ($request->get('status') === 'inactive') {
                $query->where('is_active', false);
            }
        }

        $assetCategories = $query->orderBy('name')->paginate(15);

        return view('asset-categories.index', compact('assetCategories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('asset-categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:asset_categories,name',
            'code' => 'required|string|max:10|unique:asset_categories,code',
            'description' => 'nullable|string',
            'is_active' => 'nullable'
        ]);

        try {
            DB::beginTransaction();

            $assetCategory = AssetCategory::create([
                'name' => $request->name,
                'code' => strtoupper($request->code),
                'description' => $request->description,
                'is_active' => $request->has('is_active') ? true : false,
            ]);

            DB::commit();

            return redirect()->route('asset-categories.index')
                           ->with('success', 'Asset category created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Failed to create asset category. Please try again.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  AssetCategory  $assetCategory
     * @return \Illuminate\Http\Response
     */
    public function show(AssetCategory $assetCategory)
    {
        return view('asset-categories.show', compact('assetCategory'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  AssetCategory  $assetCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(AssetCategory $assetCategory)
    {
        return view('asset-categories.edit', compact('assetCategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  AssetCategory  $assetCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AssetCategory $assetCategory)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('asset_categories')->ignore($assetCategory->id)],
            'code' => ['required', 'string', 'max:10', Rule::unique('asset_categories')->ignore($assetCategory->id)],
            'description' => 'nullable|string',
            'is_active' => 'nullable'
        ]);

        try {
            DB::beginTransaction();

            $assetCategory->update([
                'name' => $request->name,
                'code' => strtoupper($request->code),
                'description' => $request->description,
                'is_active' => $request->has('is_active') ? true : false,
            ]);

            DB::commit();

            return redirect()->route('asset-categories.index')
                           ->with('success', 'Asset category updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Failed to update asset category. Please try again.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  AssetCategory  $assetCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(AssetCategory $assetCategory)
    {
        try {
            DB::beginTransaction();

            $assetCategory->delete();

            DB::commit();

            return redirect()->route('asset-categories.index')
                           ->with('success', 'Asset category deleted successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                           ->with('error', 'Failed to delete asset category. Please try again.');
        }
    }

    /**
     * Toggle the status of the specified asset category.
     *
     * @param  AssetCategory  $assetCategory
     * @return \Illuminate\Http\Response
     */
    public function toggleStatus(AssetCategory $assetCategory)
    {
        try {
            DB::beginTransaction();

            $assetCategory->update([
                'is_active' => !$assetCategory->is_active
            ]);

            DB::commit();

            $status = $assetCategory->is_active ? 'activated' : 'deactivated';
            return redirect()->route('asset-categories.index')
                           ->with('success', "Asset category {$status} successfully.");

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                           ->with('error', 'Failed to update asset category status. Please try again.');
        }
    }
}
