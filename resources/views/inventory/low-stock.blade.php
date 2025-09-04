@extends('layouts.app')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Asset Management</li>
        <li class="breadcrumb-item"><a href="{{ route('inventories.index') }}">Inventories</a></li>
        <li class="breadcrumb-item">Low Stock Items</li>
        <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection
@section('content')
<div class="row">
    <div class="col-md-12 col-xs-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0">Low Stock Items</h5>
                    <small class="text-muted">Items at or below minimum stock levels requiring attention</small>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('inventories.index') }}" class="btn btn-outline-secondary btn-sm">
                        <svg class="c-icon c-icon-sm mr-1">
                            <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-arrow-left')}}"></use>
                        </svg>
                        Back to Inventory
                    </a>
                    <a href="{{ route('inventories.index') }}" class="btn btn-sm" 
                       style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                        <svg class="c-icon c-icon-sm mr-1">
                            <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-layers')}}"></use>
                        </svg>
                        View All Items
                    </a>
                    <a href="{{ route('inventories.create') }}" class="btn btn-sm"
                       style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                        <svg class="c-icon c-icon-sm mr-1">
                            <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-plus')}}"></use>
                        </svg>
                        Add Item
                    </a>
                </div>
            </div>
            <div class="card-body">
                @if(Session::has('message'))
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    {{ Session::get('message') }}
                </div>
                @endif

                @if($items->count() > 0)
                <div class="alert alert-warning">
                    <svg class="c-icon c-icon-lg mr-2">
                        <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-warning')}}"></use>
                    </svg>
                    <strong>Attention Required:</strong> {{ $items->count() }} item(s) are at or below minimum stock levels.
                </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-hover table-sm">
                        <thead>
                            <tr>
                                <th>Item Code</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Current Stock</th>
                                <th>Minimum Level</th>
                                <th>Shortage</th>
                                <th>Unit Cost</th>
                                <th>Reorder Value</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($items as $item)
                            <tr class="table-warning">
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
                                    <span class="badge" style="background-color: {{ $item->category->color }}; color: white;">
                                        {{ $item->category->name }}
                                    </span>
                                </td>
                                <td>
                                    <div>
                                        <strong class="text-danger">
                                            {{ $item->quantity_in_stock }} {{ $item->unit_of_measure }}
                                        </strong>
                                        @if($item->quantity_in_stock == 0)
                                        <br><span class="badge badge-danger">Out of Stock</span>
                                        @else
                                        <br><span class="badge badge-warning">Low Stock</span>
                                        @endif
                                    </div>
                                </td>
                                <td>{{ $item->minimum_stock_level }} {{ $item->unit_of_measure }}</td>
                                <td>
                                    <strong class="text-danger">
                                        {{ max(0, $item->minimum_stock_level - $item->quantity_in_stock) }} {{ $item->unit_of_measure }}
                                    </strong>
                                </td>
                                <td>${{ number_format($item->unit_cost, 2) }}</td>
                                <td>
                                    <strong class="text-primary">
                                        ${{ number_format(max(0, $item->minimum_stock_level - $item->quantity_in_stock) * $item->unit_cost, 2) }}
                                    </strong>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('inventories.show', $item) }}" class="btn btn-info btn-sm" title="View Details">
                                            <svg class="c-icon c-icon-sm">
                                                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-eye')}}"></use>
                                            </svg>
                                        </a>
                                        <a href="{{ route('inventories.stock-movement', $item) }}" class="btn btn-success btn-sm" title="Stock In">
                                            <svg class="c-icon c-icon-sm">
                                                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-arrow-bottom')}}"></use>
                                            </svg>
                                        </a>
                                        <a href="{{ route('inventories.adjust-stock', $item) }}" class="btn btn-warning btn-sm" title="Adjust Stock">
                                            <svg class="c-icon c-icon-sm">
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
                                        <svg class="c-icon c-icon-4xl text-success mb-3">
                                            <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-check-circle')}}"></use>
                                        </svg>
                                        <h5 class="text-success">All Items Well Stocked</h5>
                                        <p class="text-muted">
                                            No items are currently below minimum stock levels. Great job maintaining inventory!
                                        </p>
                                        <a href="{{ route('inventories.index') }}" class="btn"
                                           style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                                            View All Items
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Summary Card -->
                @if($items->count() > 0)
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card bg-light">
                            <div class="card-body">
                                <div class="row text-center">
                                    <div class="col-md-3">
                                        <h4 class="text-danger">{{ $items->count() }}</h4>
                                        <small class="text-muted">Items Below Minimum</small>
                                    </div>
                                    <div class="col-md-3">
                                        <h4 class="text-warning">{{ $items->where('quantity_in_stock', 0)->count() }}</h4>
                                        <small class="text-muted">Out of Stock</small>
                                    </div>
                                    <div class="col-md-3">
                                        <h4 class="text-primary">
                                            ${{ number_format($items->sum(function($item) { 
                                                return max(0, $item->minimum_stock_level - $item->quantity_in_stock) * $item->unit_cost; 
                                            }), 2) }}
                                        </h4>
                                        <small class="text-muted">Total Reorder Value</small>
                                    </div>
                                    <div class="col-md-3">
                                        <h4 class="text-info">{{ $items->pluck('category')->unique()->count() }}</h4>
                                        <small class="text-muted">Categories Affected</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

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

.btn-primary {
    background: var(--primary-gradient) !important;
    border: none !important;
    color: white !important;
}

.btn-success {
    background: var(--success-gradient) !important;
    border: none !important;
    color: white !important;
}

.btn-warning {
    background: var(--warning-gradient) !important;
    border: none !important;
    color: white !important;
}

.btn-info {
    background: var(--info-gradient) !important;
    border: none !important;
    color: white !important;
}

.table-warning {
    background-color: rgba(255, 193, 7, 0.1) !important;
}

.empty-state {
    padding: 2rem;
}

.gap-2 {
    gap: 0.5rem;
}

.text-primary {
    color: var(--primary-color) !important;
}
</style>
