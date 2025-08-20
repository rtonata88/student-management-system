@extends('layouts.app')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Asset Management</li>
        <li class="breadcrumb-item"><a href="{{ route('inventories.index') }}">Inventories</a></li>
        <li class="breadcrumb-item">Expired Items</li>
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
                    <h5 class="mb-0">Expired Items</h5>
                    <small class="text-muted">Items that have passed their expiry date and need immediate attention</small>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('inventories.index') }}" class="btn btn-outline-primary btn-sm">
                        <svg class="c-icon c-icon-sm mr-1">
                            <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-layers')}}"></use>
                        </svg>
                        All Items
                    </a>
                    <a href="{{ route('inventories.low-stock') }}" class="btn btn-outline-warning btn-sm">
                        <svg class="c-icon c-icon-sm mr-1">
                            <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-warning')}}"></use>
                        </svg>
                        Low Stock
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
                <div class="alert alert-danger">
                    <svg class="c-icon c-icon-lg mr-2">
                        <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-warning')}}"></use>
                    </svg>
                    <strong>Urgent Action Required:</strong> {{ $items->count() }} item(s) have expired and should be removed from inventory.
                </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-hover table-sm">
                        <thead>
                            <tr>
                                <th>Item Code</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Expiry Date</th>
                                <th>Days Expired</th>
                                <th>Current Stock</th>
                                <th>Unit Cost</th>
                                <th>Loss Value</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($items as $item)
                            <tr class="table-danger">
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
                                        <strong class="text-danger">{{ $item->expiry_date->format('M d, Y') }}</strong>
                                        <br><span class="badge badge-danger">Expired</span>
                                    </div>
                                </td>
                                <td>
                                    <strong class="text-danger">
                                        {{ $item->expiry_date->diffInDays(now()) }} days
                                    </strong>
                                </td>
                                <td>
                                    <div>
                                        <strong>{{ $item->quantity_in_stock }} {{ $item->unit_of_measure }}</strong>
                                        @if($item->quantity_in_stock > 0)
                                        <br><small class="text-danger">Needs Disposal</small>
                                        @endif
                                    </div>
                                </td>
                                <td>${{ number_format($item->unit_cost, 2) }}</td>
                                <td>
                                    <strong class="text-danger">
                                        ${{ number_format($item->quantity_in_stock * $item->unit_cost, 2) }}
                                    </strong>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('inventories.show', $item) }}" class="btn btn-info btn-sm" title="View Details">
                                            <svg class="c-icon c-icon-sm">
                                                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-eye')}}"></use>
                                            </svg>
                                        </a>
                                        <a href="{{ route('inventories.adjust-stock', $item) }}" class="btn btn-danger btn-sm" title="Remove Stock">
                                            <svg class="c-icon c-icon-sm">
                                                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-trash')}}"></use>
                                            </svg>
                                        </a>
                                        <a href="{{ route('inventories.edit', $item) }}" class="btn btn-warning btn-sm" title="Update Expiry">
                                            <svg class="c-icon c-icon-sm">
                                                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-pencil')}}"></use>
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
                                        <h5 class="text-success">No Expired Items</h5>
                                        <p class="text-muted">
                                            All items are within their expiry dates. Keep monitoring for items expiring soon.
                                        </p>
                                        <a href="{{ route('inventories.index') }}" class="btn btn-outline-primary">
                                            View All Items
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Summary Cards -->
                @if($items->count() > 0)
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card bg-light">
                            <div class="card-body">
                                <div class="row text-center">
                                    <div class="col-md-3">
                                        <h4 class="text-danger">{{ $items->count() }}</h4>
                                        <small class="text-muted">Expired Items</small>
                                    </div>
                                    <div class="col-md-3">
                                        <h4 class="text-warning">{{ $items->sum('quantity_in_stock') }}</h4>
                                        <small class="text-muted">Total Units to Dispose</small>
                                    </div>
                                    <div class="col-md-3">
                                        <h4 class="text-danger">
                                            ${{ number_format($items->sum(function($item) { 
                                                return $item->quantity_in_stock * $item->unit_cost; 
                                            }), 2) }}
                                        </h4>
                                        <small class="text-muted">Total Loss Value</small>
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

                <!-- Action Recommendations -->
                <div class="row mt-3">
                    <div class="col-md-12">
                        <div class="card border-danger">
                            <div class="card-header bg-danger text-white">
                                <h6 class="mb-0">
                                    <svg class="c-icon c-icon-sm mr-1">
                                        <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-lightbulb')}}"></use>
                                    </svg>
                                    Recommended Actions
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6 class="text-danger">Immediate Actions:</h6>
                                        <ul class="list-unstyled">
                                            <li class="mb-2">
                                                <svg class="c-icon c-icon-sm text-danger mr-1">
                                                    <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-trash')}}"></use>
                                                </svg>
                                                Remove expired items from active inventory
                                            </li>
                                            <li class="mb-2">
                                                <svg class="c-icon c-icon-sm text-warning mr-1">
                                                    <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-description')}}"></use>
                                                </svg>
                                                Document disposal reasons and methods
                                            </li>
                                            <li class="mb-2">
                                                <svg class="c-icon c-icon-sm text-info mr-1">
                                                    <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-calculator')}}"></use>
                                                </svg>
                                                Calculate and record financial losses
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="text-primary">Prevention Measures:</h6>
                                        <ul class="list-unstyled">
                                            <li class="mb-2">
                                                <svg class="c-icon c-icon-sm text-success mr-1">
                                                    <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-clock')}}"></use>
                                                </svg>
                                                Implement FIFO (First In, First Out) system
                                            </li>
                                            <li class="mb-2">
                                                <svg class="c-icon c-icon-sm text-primary mr-1">
                                                    <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-bell')}}"></use>
                                                </svg>
                                                Set up expiry date alerts and notifications
                                            </li>
                                            <li class="mb-2">
                                                <svg class="c-icon c-icon-sm text-warning mr-1">
                                                    <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-chart-line')}}"></use>
                                                </svg>
                                                Review ordering patterns and quantities
                                            </li>
                                        </ul>
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

.bg-danger {
    background: var(--danger-gradient) !important;
}

.btn-primary {
    background: var(--primary-gradient) !important;
    border: none !important;
    color: white !important;
}

.btn-danger {
    background: var(--danger-gradient) !important;
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

.table-danger {
    background-color: rgba(220, 53, 69, 0.1) !important;
}

.border-danger {
    border-color: #dc3545 !important;
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
