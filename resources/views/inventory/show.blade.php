@extends('layouts.app')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Asset Management</li>
        <li class="breadcrumb-item"><a href="{{ route('inventories.index') }}">Inventories</a></li>
        <li class="breadcrumb-item">{{ $inventory->name }}</li>
        <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection
@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0">{{ $inventory->name }}</h5>
                    <small class="text-muted">Item Code: {{ $inventory->item_code }}</small>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('inventories.edit', $inventory) }}" class="btn btn-primary btn-sm">
                        <svg class="c-icon c-icon-sm mr-1">
                            <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-pencil')}}"></use>
                        </svg>
                        Edit
                    </a>
                    <a href="{{ route('inventories.adjust-stock', $inventory) }}" class="btn btn-warning btn-sm">
                        <svg class="c-icon c-icon-sm mr-1">
                            <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-settings')}}"></use>
                        </svg>
                        Adjust Stock
                    </a>
                    <a href="{{ route('inventories.stock-movement', $inventory) }}" class="btn btn-info btn-sm">
                        <svg class="c-icon c-icon-sm mr-1">
                            <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-transfer')}}"></use>
                        </svg>
                        Stock Movement
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

                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-primary mb-3">Item Details</h6>
                        <table class="table table-sm">
                            <tr>
                                <td><strong>Name:</strong></td>
                                <td>{{ $inventory->name }}</td>
                            </tr>
                            <tr>
                                <td><strong>Item Code:</strong></td>
                                <td>{{ $inventory->item_code }}</td>
                            </tr>
                            <tr>
                                <td><strong>Category:</strong></td>
                                <td>
                                    <span class="badge" style="background-color: {{ $inventory->category->color }}; color: white;">
                                        {{ $inventory->category->name }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Description:</strong></td>
                                <td>{{ $inventory->description ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Unit of Measure:</strong></td>
                                <td>{{ $inventory->unit_of_measure }}</td>
                            </tr>
                            <tr>
                                <td><strong>Barcode:</strong></td>
                                <td>{{ $inventory->barcode ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Status:</strong></td>
                                <td>
                                    <span class="badge badge-{{ $inventory->status === 'active' ? 'success' : ($inventory->status === 'inactive' ? 'warning' : 'danger') }}">
                                        {{ ucfirst($inventory->status) }}
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-primary mb-3">Stock Information</h6>
                        <table class="table table-sm">
                            <tr>
                                <td><strong>Current Stock:</strong></td>
                                <td>
                                    <span class="text-{{ $inventory->stock_status_color }}">
                                        <strong>{{ $inventory->quantity_in_stock }} {{ $inventory->unit_of_measure }}</strong>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Stock Status:</strong></td>
                                <td>
                                    <span class="badge badge-{{ $inventory->stock_status_color }}">
                                        {{ $inventory->stock_status_text }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Minimum Level:</strong></td>
                                <td>{{ $inventory->minimum_stock_level }} {{ $inventory->unit_of_measure }}</td>
                            </tr>
                            <tr>
                                <td><strong>Maximum Level:</strong></td>
                                <td>{{ $inventory->maximum_stock_level ?? 'N/A' }} {{ $inventory->maximum_stock_level ? $inventory->unit_of_measure : '' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Unit Cost:</strong></td>
                                <td>${{ number_format($inventory->unit_cost, 2) }}</td>
                            </tr>
                            <tr>
                                <td><strong>Total Value:</strong></td>
                                <td><strong>${{ number_format($inventory->total_value, 2) }}</strong></td>
                            </tr>
                            <tr>
                                <td><strong>Expiry Date:</strong></td>
                                <td>
                                    @if($inventory->expiry_date)
                                        {{ $inventory->expiry_date->format('M d, Y') }}
                                        @if($inventory->is_expired)
                                            <span class="badge badge-danger ml-1">Expired</span>
                                        @elseif($inventory->is_expiring_soon)
                                            <span class="badge badge-warning ml-1">Expiring Soon</span>
                                        @endif
                                    @else
                                        N/A
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-6">
                        <h6 class="text-primary mb-3">Location & Supplier</h6>
                        <table class="table table-sm">
                            <tr>
                                <td><strong>Storage Location:</strong></td>
                                <td>{{ $inventory->location ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Supplier:</strong></td>
                                <td>{{ $inventory->supplier ?? 'N/A' }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        @if($inventory->specifications)
                        <h6 class="text-primary mb-3">Specifications</h6>
                        <div class="specifications-container">
                            @foreach($inventory->specifications as $key => $value)
                            <div class="specification-item">
                                <strong>{{ ucfirst(str_replace('_', ' ', $key)) }}:</strong> {{ $value }}
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Recent Transactions</h6>
            </div>
            <div class="card-body">
                @forelse($inventory->transactions->take(10) as $transaction)
                <div class="transaction-item mb-3 p-2 border rounded">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <span class="badge badge-{{ $transaction->transaction_type_badge }}">
                                {{ $transaction->formatted_transaction_type }}
                            </span>
                            <div class="mt-1">
                                <strong>{{ $transaction->quantity > 0 ? '+' : '' }}{{ $transaction->quantity }} {{ $inventory->unit_of_measure }}</strong>
                            </div>
                            @if($transaction->notes)
                            <small class="text-muted">{{ \Illuminate\Support\Str::limit($transaction->notes, 50) }}</small>
                            @endif
                        </div>
                        <div class="text-right">
                            <small class="text-muted">{{ $transaction->transaction_date->format('M d, Y') }}</small>
                            @if($transaction->performed_by)
                            <br><small class="text-muted">{{ $transaction->performed_by }}</small>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-3">
                    <svg class="c-icon c-icon-2xl text-muted mb-2">
                        <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-history')}}"></use>
                    </svg>
                    <p class="text-muted mb-0">No transactions yet</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="mb-0">Quick Actions</h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('inventories.adjust-stock', $inventory) }}" class="btn btn-outline-warning btn-sm">
                        <svg class="c-icon c-icon-sm mr-1">
                            <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-settings')}}"></use>
                        </svg>
                        Adjust Stock
                    </a>
                    <a href="{{ route('inventories.stock-movement', $inventory) }}" class="btn btn-outline-info btn-sm">
                        <svg class="c-icon c-icon-sm mr-1">
                            <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-transfer')}}"></use>
                        </svg>
                        Stock In/Out
                    </a>
                    <a href="{{ route('inventories.edit', $inventory) }}" class="btn btn-outline-primary btn-sm">
                        <svg class="c-icon c-icon-sm mr-1">
                            <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-pencil')}}"></use>
                        </svg>
                        Edit Item
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-12">
        <div class="d-flex justify-content-start">
            <a href="{{ route('inventories.index') }}" class="btn btn-outline-secondary">
                <svg class="c-icon c-icon-sm mr-1">
                    <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-arrow-left')}}"></use>
                </svg>
                Back to Inventory List
            </a>
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

.text-primary {
    color: var(--primary-color) !important;
}

.gap-2 {
    gap: 0.5rem;
}

.transaction-item {
    background: rgba(248, 249, 250, 0.5);
    transition: all 0.3s ease;
}

.transaction-item:hover {
    background: rgba(102, 126, 234, 0.05);
}

.specifications-container {
    background: #f8f9fa;
    padding: 1rem;
    border-radius: 8px;
}

.specification-item {
    margin-bottom: 0.5rem;
    padding: 0.25rem 0;
    border-bottom: 1px solid #e9ecef;
}

.specification-item:last-child {
    border-bottom: none;
    margin-bottom: 0;
}

h6 {
    font-weight: 600;
    border-bottom: 2px solid #e9ecef;
    padding-bottom: 0.5rem;
}

.d-grid {
    display: grid;
}

.gap-2 {
    gap: 0.5rem;
}
</style>
