<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InventoryItem;
use App\Models\InventoryCategory;
use App\Models\InventoryTransaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class InventoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:inventory-view')->only(['index', 'show', 'lowStock', 'expired']);
        $this->middleware('permission:inventory-create')->only(['create', 'store']);
        $this->middleware('permission:inventory-edit')->only(['edit', 'update']);
        $this->middleware('permission:inventory-delete')->only(['destroy']);
        $this->middleware('permission:inventory-adjust-stock')->only(['adjustStock', 'processStockAdjustment']);
        $this->middleware('permission:inventory-stock-movement')->only(['stockMovement', 'processStockMovement']);
        $this->middleware('permission:inventory-reports')->only(['lowStock', 'expired']);
    }
    /**
     * Display a listing of inventory items.
     */
    public function index(Request $request)
    {
        $query = InventoryItem::with(['category', 'transactions']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('item_code', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('supplier', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Stock level filter
        if ($request->filled('stock_level')) {
            switch ($request->stock_level) {
                case 'low':
                    $query->whereRaw('quantity_in_stock <= minimum_stock_level');
                    break;
                case 'out':
                    $query->where('quantity_in_stock', 0);
                    break;
                case 'normal':
                    $query->whereRaw('quantity_in_stock > minimum_stock_level');
                    break;
            }
        }

        $items = $query->orderBy('name')->paginate(15);
        $categories = InventoryCategory::active()->orderBy('name')->get();

        // Dashboard statistics
        $stats = [
            'total_items' => InventoryItem::active()->count(),
            'total_value' => InventoryItem::active()->sum(DB::raw('quantity_in_stock * unit_cost')),
            'low_stock_items' => InventoryItem::active()->lowStock()->count(),
            'expired_items' => InventoryItem::active()->expired()->count(),
            'categories' => InventoryCategory::active()->count(),
        ];

        return view('inventory.index', compact('items', 'categories', 'stats'));
    }

    /**
     * Show the form for creating a new inventory item.
     */
    public function create()
    {
        $categories = InventoryCategory::active()->orderBy('name')->get();
        return view('inventory.create', compact('categories'));
    }

    /**
     * Store a newly created inventory item.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'item_code' => 'required|string|max:255|unique:inventory_items',
            'category_id' => 'required|exists:inventory_categories,id',
            'unit_of_measure' => 'required|string|max:255',
            'unit_cost' => 'required|numeric|min:0',
            'quantity_in_stock' => 'required|integer|min:0',
            'minimum_stock_level' => 'required|integer|min:0',
            'maximum_stock_level' => 'nullable|integer|min:0',
            'supplier' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'expiry_date' => 'nullable|date|after:today',
            'barcode' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'specifications' => 'nullable|string',
        ]);

        $item = InventoryItem::create($request->all());

        // Create initial stock transaction if quantity > 0
        if ($request->quantity_in_stock > 0) {
            InventoryTransaction::create([
                'item_id' => $item->id,
                'transaction_type' => 'in',
                'quantity' => $request->quantity_in_stock,
                'unit_cost' => $request->unit_cost,
                'total_cost' => $request->quantity_in_stock * $request->unit_cost,
                'reference_number' => 'INITIAL-' . $item->item_code,
                'notes' => 'Initial stock entry',
                'performed_by' => Auth::user()->name,
                'transaction_date' => now(),
                'supplier' => $request->supplier,
            ]);
        }

        return redirect()->route('inventories.index')
                        ->with('message', 'Inventory item created successfully.');
    }

    /**
     * Display the specified inventory item.
     */
    public function show(InventoryItem $inventory)
    {
        $inventory->load(['category', 'transactions' => function($query) {
            $query->orderBy('transaction_date', 'desc');
        }]);

        return view('inventory.show', compact('inventory'));
    }

    /**
     * Show the form for editing the specified inventory item.
     */
    public function edit(InventoryItem $inventory)
    {
        $categories = InventoryCategory::active()->orderBy('name')->get();
        return view('inventory.edit', compact('inventory', 'categories'));
    }

    /**
     * Update the specified inventory item.
     */
    public function update(Request $request, InventoryItem $inventory)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'item_code' => 'required|string|max:255|unique:inventory_items,item_code,' . $inventory->id,
            'category_id' => 'required|exists:inventory_categories,id',
            'unit_of_measure' => 'required|string|max:255',
            'unit_cost' => 'required|numeric|min:0',
            'minimum_stock_level' => 'required|integer|min:0',
            'maximum_stock_level' => 'nullable|integer|min:0',
            'supplier' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'expiry_date' => 'nullable|date',
            'barcode' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'specifications' => 'nullable|string',
            'status' => 'required|in:active,inactive,discontinued',
        ]);

        $inventory->update($request->all());

        return redirect()->route('inventories.index')
                        ->with('message', 'Inventory item updated successfully.');
    }

    /**
     * Remove the specified inventory item.
     */
    public function destroy(InventoryItem $inventory)
    {
        $inventory->delete();

        return redirect()->route('inventories.index')
                        ->with('message', 'Inventory item deleted successfully.');
    }

    /**
     * Show stock adjustment form.
     */
    public function adjustStock(InventoryItem $inventory)
    {
        return view('inventory.adjust-stock', compact('inventory'));
    }

    /**
     * Process stock adjustment.
     */
    public function processStockAdjustment(Request $request, InventoryItem $inventory)
    {
        $request->validate([
            'adjustment_type' => 'required|in:increase,decrease,set',
            'quantity' => 'required|integer|min:1',
            'reason' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $oldQuantity = $inventory->quantity_in_stock;
        $adjustmentQuantity = $request->quantity;

        switch ($request->adjustment_type) {
            case 'increase':
                $newQuantity = $oldQuantity + $adjustmentQuantity;
                $transactionQuantity = $adjustmentQuantity;
                break;
            case 'decrease':
                $newQuantity = max(0, $oldQuantity - $adjustmentQuantity);
                $transactionQuantity = -min($adjustmentQuantity, $oldQuantity);
                break;
            case 'set':
                $newQuantity = $adjustmentQuantity;
                $transactionQuantity = $adjustmentQuantity - $oldQuantity;
                break;
        }

        // Update inventory quantity
        $inventory->update(['quantity_in_stock' => $newQuantity]);

        // Create transaction record
        InventoryTransaction::create([
            'item_id' => $inventory->id,
            'transaction_type' => 'adjustment',
            'quantity' => $transactionQuantity,
            'unit_cost' => $inventory->unit_cost,
            'total_cost' => $transactionQuantity * $inventory->unit_cost,
            'reference_number' => 'ADJ-' . now()->format('YmdHis'),
            'notes' => $request->reason . ($request->notes ? ': ' . $request->notes : ''),
            'performed_by' => Auth::user()->name,
            'transaction_date' => now(),
        ]);

        return redirect()->route('inventories.show', $inventory)
                        ->with('message', 'Stock adjustment processed successfully.');
    }

    /**
     * Show stock movement form.
     */
    public function stockMovement(InventoryItem $inventory)
    {
        return view('inventory.stock-movement', compact('inventory'));
    }

    /**
     * Process stock movement (in/out).
     */
    public function processStockMovement(Request $request, InventoryItem $inventory)
    {
        $request->validate([
            'movement_type' => 'required|in:in,out',
            'quantity' => 'required|integer|min:1',
            'reference_number' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'supplier' => 'nullable|string|max:255',
            'recipient' => 'nullable|string|max:255',
        ]);

        $quantity = $request->quantity;
        
        if ($request->movement_type === 'out' && $inventory->quantity_in_stock < $quantity) {
            return back()->withErrors(['quantity' => 'Insufficient stock available.']);
        }

        // Update inventory quantity
        if ($request->movement_type === 'in') {
            $inventory->increment('quantity_in_stock', $quantity);
        } else {
            $inventory->decrement('quantity_in_stock', $quantity);
        }

        // Create transaction record
        InventoryTransaction::create([
            'item_id' => $inventory->id,
            'transaction_type' => $request->movement_type,
            'quantity' => $request->movement_type === 'out' ? -$quantity : $quantity,
            'unit_cost' => $inventory->unit_cost,
            'total_cost' => $quantity * $inventory->unit_cost,
            'reference_number' => $request->reference_number ?: strtoupper($request->movement_type) . '-' . now()->format('YmdHis'),
            'notes' => $request->notes,
            'performed_by' => Auth::user()->name,
            'transaction_date' => now(),
            'supplier' => $request->supplier,
            'recipient' => $request->recipient,
        ]);

        return redirect()->route('inventories.show', $inventory)
                        ->with('message', 'Stock movement processed successfully.');
    }

    /**
     * Display low stock items.
     */
    public function lowStock()
    {
        $items = InventoryItem::with('category')
                            ->active()
                            ->lowStock()
                            ->orderBy('name')
                            ->paginate(15);

        return view('inventory.low-stock', compact('items'));
    }

    /**
     * Display expired items.
     */
    public function expired()
    {
        $items = InventoryItem::with('category')
                            ->active()
                            ->expired()
                            ->orderBy('expiry_date')
                            ->paginate(15);

        return view('inventory.expired', compact('items'));
    }
}
