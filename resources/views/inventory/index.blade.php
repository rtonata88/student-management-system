@extends('layouts.app')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Asset Management</li>
        <li class="breadcrumb-item">Inventories</li>
        <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection
@section('content')
<div class="row">
    <div class="col-md-12 col-xs-12">
        <!-- Dashboard Statistics -->
        <div class="row mb-4">
            <div class="col-md-2 col-sm-6 mb-3">
                <div class="card text-white bg-primary">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <div class="h4 mb-0">{{ $stats['total_items'] }}</div>
                                <div class="small">Total Items</div>
                            </div>
                            <svg class="c-icon c-icon-xl">
                                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-layers')}}"></use>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-sm-6 mb-3">
                <div class="card text-white bg-success">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <div class="h4 mb-0">${{ number_format($stats['total_value'], 2) }}</div>
                                <div class="small">Total Value</div>
                            </div>
                            <svg class="c-icon c-icon-xl">
                                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-dollar')}}"></use>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-sm-6 mb-3">
                <div class="card text-white bg-warning">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <div class="h4 mb-0">{{ $stats['low_stock_items'] }}</div>
                                <div class="small">Low Stock</div>
                            </div>
                            <svg class="c-icon c-icon-xl">
                                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-warning')}}"></use>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-sm-6 mb-3">
                <div class="card text-white bg-danger">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <div class="h4 mb-0">{{ $stats['expired_items'] }}</div>
                                <div class="small">Expired</div>
                            </div>
                            <svg class="c-icon c-icon-xl">
                                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-clock')}}"></use>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-sm-6 mb-3">
                <div class="card text-white bg-info">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <div class="h4 mb-0">{{ $stats['categories'] }}</div>
                                <div class="small">Categories</div>
                            </div>
                            <svg class="c-icon c-icon-xl">
                                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-folder')}}"></use>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0">Inventory Management</h5>
                    <small class="text-muted">Manage school inventory items, stock levels, and transactions</small>
                </div>
                <div class="btn-toolbar" role="toolbar">
                    <div class="btn-group mr-2" role="group">
                        <a href="{{ route('inventory-categories.index') }}" class="btn btn-outline-secondary">
                            <svg class="c-icon mr-2">
                                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-folder-open')}}"></use>
                            </svg>
                            Categories
                        </a>
                        <a href="{{ route('inventories.create') }}" class="btn btn-primary">
                            <svg class="c-icon mr-2">
                                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-plus')}}"></use>
                            </svg>
                            Add Item
                        </a>
                    </div>
                    <div class="btn-group" role="group">
                        <a href="{{ route('inventories.low-stock') }}" class="btn btn-outline-secondary">
                            <svg class="c-icon mr-2">
                                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-warning')}}"></use>
                            </svg>
                            Low Stock
                        </a>
                        <a href="{{ route('inventories.expired') }}" class="btn btn-outline-secondary">
                            <svg class="c-icon mr-2">
                                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-clock')}}"></use>
                            </svg>
                            Expired
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if(Session::has('message'))
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    {{ Session::get('message') }}
                </div>
                @endif

                <!-- Search and Filter Form -->
                <form method="GET" action="{{ route('inventories.index') }}" class="mb-4">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <div class="input-group">
                                <input type="text" class="form-control" name="search" 
                                       placeholder="Search items..." 
                                       value="{{ request('search') }}">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-primary" type="submit">
                                        <svg class="c-icon">
                                            <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-search')}}"></use>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 mb-3">
                            <select name="category" class="form-control">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2 mb-3">
                            <select name="status" class="form-control">
                                <option value="">All Status</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                <option value="discontinued" {{ request('status') == 'discontinued' ? 'selected' : '' }}>Discontinued</option>
                            </select>
                        </div>
                        <div class="col-md-2 mb-3">
                            <select name="stock_level" class="form-control">
                                <option value="">All Stock Levels</option>
                                <option value="low" {{ request('stock_level') == 'low' ? 'selected' : '' }}>Low Stock</option>
                                <option value="out" {{ request('stock_level') == 'out' ? 'selected' : '' }}>Out of Stock</option>
                                <option value="normal" {{ request('stock_level') == 'normal' ? 'selected' : '' }}>Normal Stock</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">Filter</button>
                                <a href="{{ route('inventories.index') }}" class="btn btn-outline-secondary">Clear</a>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Results Summary -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <small class="text-muted">
                            Showing {{ $items->firstItem() ?? 0 }} to {{ $items->lastItem() ?? 0 }} 
                            of {{ $items->total() }} items
                        </small>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover table-sm">
                        <thead>
                            <tr>
                                <th>Item Code</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Stock</th>
                                <th>Unit Cost</th>
                                <th>Total Value</th>
                                <th>Status</th>
                                <th>Location</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($items as $item)
                            <tr>
                                <td>
                                    <strong>{{ $item->item_code }}</strong>
                                </td>
                                <td>
                                    <div>
                                        <strong>{{ $item->name }}</strong>
                                        @if($item->description)
                                        <br><small class="text-muted">{{ \Illuminate\Support\Str::limit($item->description, 50) }}</small>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <span class="badge badge-light">
                                        {{ $item->category->name }}
                                    </span>
                                </td>
                                <td>
                                    <div>
                                        <strong>
                                            {{ $item->quantity_in_stock }} {{ $item->unit_of_measure }}
                                        </strong>
                                        <br><small class="text-muted">Min: {{ $item->minimum_stock_level }}</small>
                                        @if($item->is_low_stock)
                                        <br><span class="badge badge-warning">Low Stock</span>
                                        @endif
                                    </div>
                                </td>
                                <td>${{ number_format($item->unit_cost, 2) }}</td>
                                <td><strong>${{ number_format($item->total_value, 2) }}</strong></td>
                                <td>
                                    @if($item->is_expired)
                                    <span class="badge badge-danger">Expired</span>
                                    @elseif($item->current_stock <= $item->minimum_stock)
                                    <span class="badge badge-warning">Low Stock</span>
                                    @elseif($item->is_expiring_soon)
                                    <span class="badge badge-warning">Expiring Soon</span>
                                    @else
                                    <span class="badge badge-light">{{ $item->stock_status }}</span>
                                    @endif
                                </td>
                                <td>{{ $item->location ?? 'N/A' }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('inventories.show', $item) }}" class="btn btn-sm btn-outline-secondary" title="View">
                                            <svg class="c-icon">
                                                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-magnifying-glass')}}"></use>
                                            </svg>
                                        </a>
                                        <a href="{{ route('inventories.edit', $item) }}" class="btn btn-sm btn-outline-secondary" title="Edit">
                                            <svg class="c-icon">
                                                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-pencil')}}"></use>
                                            </svg>
                                        </a>
                                        <a href="{{ route('inventories.adjust-stock', $item) }}" class="btn btn-sm btn-outline-secondary" title="Adjust Stock">
                                            <svg class="c-icon">
                                                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-settings')}}"></use>
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center py-4">
                                    <div class="empty-state">
                                        <svg class="c-icon c-icon-4xl text-muted mb-3">
                                            <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-layers')}}"></use>
                                        </svg>
                                        <h5 class="text-muted">No Inventory Items Found</h5>
                                        <p class="text-muted">
                                            @if(request()->hasAny(['search', 'category', 'status', 'stock_level']))
                                                No items match your search criteria. Try adjusting your filters.
                                            @else
                                                <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="btn-group" role="group">
                                <a href="{{ route('inventory-categories.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-folder-open mr-1"></i> Categories
                                </a>
                                <a href="{{ route('inventories.create') }}" class="btn btn-success">
                                    <i class="fas fa-plus-circle mr-1"></i> Add Item
                                </a>
                            </div>
                            <div class="btn-group" role="group">
                                <a href="{{ route('inventories.low-stock') }}" class="btn btn-warning text-white">
                                    <i class="fas fa-exclamation-triangle mr-1"></i> Low Stock
                                </a>
                                <a href="{{ route('inventories.expired') }}" class="btn btn-danger">
                                    <i class="fas fa-times-circle mr-1"></i> Expired
                                </a>
                            </div>
                        </div>
                                            @endif
                                        </p>
                                        @if(request()->hasAny(['search', 'category', 'status', 'stock_level']))
                                        <a href="{{ route('inventories.index') }}" class="btn btn-outline-primary">
                                            Clear Filters
                                        </a>
                                        @else
                                        <a href="{{ route('inventories.create') }}" class="btn btn-primary">
                                            Add First Item
                                        </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($items->hasPages())
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div>
                        <small class="text-muted">
                            Page {{ $items->currentPage() }} of {{ $items->lastPage() }}
                        </small>
                    </div>
                    <div>
                        {{ $items->links() }}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

<style>
:root {
    --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --primary-color: #667eea;
    --success-gradient: linear-gradient(135deg, #56ab2f 0%, #a8e6cf 100%);
    --warning-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    --danger-gradient: linear-gradient(135deg, #ff416c 0%, #ff4b2b 100%);
    --info-gradient: linear-gradient(135deg, #36d1dc 0%, #5b86e5 100%);
}

/* Card styling */
.card {
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    border: none;
    border-radius: 10px;
}

.card-header {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-bottom: 1px solid #dee2e6;
    border-radius: 10px 10px 0 0 !important;
}

/* Button styling */
.btn-primary {
    background: var(--primary-gradient) !important;
    border: none !important;
    color: white !important;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
}

.btn-outline-primary {
    border: 2px solid var(--primary-color) !important;
    color: var(--primary-color) !important;
    background: transparent !important;
}

.btn-outline-primary:hover {
    background: var(--primary-gradient) !important;
    border-color: transparent !important;
    color: white !important;
}

/* Dashboard cards */
.bg-primary {
    background: var(--primary-gradient) !important;
}

.bg-success {
    background: var(--success-gradient) !important;
}

.bg-warning {
    background: var(--warning-gradient) !important;
}

.bg-danger {
    background: var(--danger-gradient) !important;
}

.bg-info {
    background: var(--info-gradient) !important;
}

/* Table styling */
.table-hover tbody tr:hover {
    background-color: rgba(102, 126, 234, 0.05);
}

/* Badge styling */
.badge-success {
    background: var(--success-gradient) !important;
}

.badge-warning {
    background: var(--warning-gradient) !important;
}

.badge-danger {
    background: var(--danger-gradient) !important;
}

/* Gap utility */
.gap-2 {
    gap: 0.5rem;
}

/* Empty state */
.empty-state {
    padding: 2rem;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .btn-group {
        flex-direction: column;
    }
    
    .btn-group .btn {
        margin-bottom: 0.25rem;
    }
}
</style>
