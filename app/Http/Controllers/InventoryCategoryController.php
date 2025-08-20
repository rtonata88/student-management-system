<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InventoryCategory;

class InventoryCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:inventory-categories-manage');
    }
    /**
     * Display a listing of inventory categories.
     */
    public function index()
    {
        $categories = InventoryCategory::withCount('items')
                                     ->orderBy('name')
                                     ->paginate(15);

        return view('inventory.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new category.
     */
    public function create()
    {
        return view('inventory.categories.create');
    }

    /**
     * Store a newly created category.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:inventory_categories',
            'description' => 'nullable|string',
            'color' => 'required|string|size:7|regex:/^#[0-9A-Fa-f]{6}$/',
        ]);

        InventoryCategory::create($request->all());

        return redirect()->route('inventory-categories.index')
                        ->with('message', 'Category created successfully.');
    }

    /**
     * Display the specified category.
     */
    public function show(InventoryCategory $inventoryCategory)
    {
        $inventoryCategory->load(['items' => function($query) {
            $query->orderBy('name');
        }]);

        return view('inventory.categories.show', compact('inventoryCategory'));
    }

    /**
     * Show the form for editing the specified category.
     */
    public function edit(InventoryCategory $inventoryCategory)
    {
        return view('inventory.categories.edit', compact('inventoryCategory'));
    }

    /**
     * Update the specified category.
     */
    public function update(Request $request, InventoryCategory $inventoryCategory)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:inventory_categories,name,' . $inventoryCategory->id,
            'description' => 'nullable|string',
            'color' => 'required|string|size:7|regex:/^#[0-9A-Fa-f]{6}$/',
            'is_active' => 'boolean',
        ]);

        $inventoryCategory->update($request->all());

        return redirect()->route('inventory-categories.index')
                        ->with('message', 'Category updated successfully.');
    }

    /**
     * Remove the specified category.
     */
    public function destroy(InventoryCategory $inventoryCategory)
    {
        if ($inventoryCategory->items()->count() > 0) {
            return redirect()->route('inventory-categories.index')
                            ->withErrors(['error' => 'Cannot delete category with existing items.']);
        }

        $inventoryCategory->delete();

        return redirect()->route('inventory-categories.index')
                        ->with('message', 'Category deleted successfully.');
    }
}
