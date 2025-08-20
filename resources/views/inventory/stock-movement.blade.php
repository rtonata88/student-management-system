@extends('layouts.app')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Asset Management</li>
        <li class="breadcrumb-item"><a href="{{ route('inventories.index') }}">Inventories</a></li>
        <li class="breadcrumb-item"><a href="{{ route('inventories.show', $inventory) }}">{{ $inventory->name }}</a></li>
        <li class="breadcrumb-item">Stock Movement</li>
        <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection
@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Stock Movement - {{ $inventory->name }}</h5>
                <small class="text-muted">Record stock in/out transactions</small>
            </div>
            <div class="card-body">
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form method="POST" action="{{ route('inventories.process-stock-movement', $inventory) }}">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="movement_type">Movement Type <span class="text-danger">*</span></label>
                                <select class="form-control" id="movement_type" name="movement_type" required>
                                    <option value="">Select Movement Type</option>
                                    <option value="in" {{ old('movement_type') == 'in' ? 'selected' : '' }}>Stock In (Receive)</option>
                                    <option value="out" {{ old('movement_type') == 'out' ? 'selected' : '' }}>Stock Out (Issue)</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="quantity">Quantity <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="quantity" name="quantity" 
                                           value="{{ old('quantity') }}" min="1" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text">{{ $inventory->unit_of_measure }}</span>
                                    </div>
                                </div>
                                <small class="form-text text-muted" id="quantity-help">Available: {{ $inventory->quantity_in_stock }} {{ $inventory->unit_of_measure }}</small>
                            </div>

                            <div class="form-group">
                                <label for="reference_number">Reference Number</label>
                                <input type="text" class="form-control" id="reference_number" name="reference_number" 
                                       value="{{ old('reference_number') }}" placeholder="PO#, Invoice#, etc.">
                            </div>

                            <div class="form-group" id="supplier-group" style="display: none;">
                                <label for="supplier">Supplier</label>
                                <input type="text" class="form-control" id="supplier" name="supplier" 
                                       value="{{ old('supplier', $inventory->supplier) }}">
                            </div>

                            <div class="form-group" id="recipient-group" style="display: none;">
                                <label for="recipient">Recipient/Department</label>
                                <input type="text" class="form-control" id="recipient" name="recipient" 
                                       value="{{ old('recipient') }}" placeholder="Department, Person, etc.">
                            </div>

                            <div class="form-group">
                                <label for="notes">Notes</label>
                                <textarea class="form-control" id="notes" name="notes" rows="3" 
                                          placeholder="Additional details about this movement">{{ old('notes') }}</textarea>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="movement-preview card bg-light">
                                <div class="card-header">
                                    <h6 class="mb-0">Movement Preview</h6>
                                </div>
                                <div class="card-body">
                                    <table class="table table-sm mb-0">
                                        <tr>
                                            <td><strong>Current Stock:</strong></td>
                                            <td>{{ $inventory->quantity_in_stock }} {{ $inventory->unit_of_measure }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Movement:</strong></td>
                                            <td id="movement-amount">-</td>
                                        </tr>
                                        <tr class="table-primary">
                                            <td><strong>New Stock:</strong></td>
                                            <td id="new-stock"><strong>-</strong></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Unit Cost:</strong></td>
                                            <td>${{ number_format($inventory->unit_cost, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Total Value:</strong></td>
                                            <td id="total-value">-</td>
                                        </tr>
                                    </table>
                                    
                                    <div class="mt-3">
                                        <div id="stock-warning" class="alert alert-warning d-none">
                                            <small><strong>Warning:</strong> This will result in low stock levels.</small>
                                        </div>
                                        <div id="stock-error" class="alert alert-danger d-none">
                                            <small><strong>Error:</strong> Insufficient stock available.</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mt-4">
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('inventories.show', $inventory) }}" class="btn btn-outline-secondary">
                                <svg class="c-icon c-icon-sm mr-1">
                                    <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-arrow-left')}}"></use>
                                </svg>
                                Back to Item
                            </a>
                            <button type="submit" class="btn btn-info" id="submit-btn" disabled>
                                <svg class="c-icon c-icon-sm mr-1">
                                    <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-transfer')}}"></use>
                                </svg>
                                Process Movement
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Item Information</h6>
            </div>
            <div class="card-body">
                <table class="table table-sm">
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
                        <td><strong>Current Stock:</strong></td>
                        <td>
                            <strong class="text-{{ $inventory->stock_status_color }}">
                                {{ $inventory->quantity_in_stock }} {{ $inventory->unit_of_measure }}
                            </strong>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Min Level:</strong></td>
                        <td>{{ $inventory->minimum_stock_level }} {{ $inventory->unit_of_measure }}</td>
                    </tr>
                    <tr>
                        <td><strong>Unit Cost:</strong></td>
                        <td>${{ number_format($inventory->unit_cost, 2) }}</td>
                    </tr>
                    <tr>
                        <td><strong>Location:</strong></td>
                        <td>{{ $inventory->location ?? 'N/A' }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h6 class="mb-0">Movement Types</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <h6 class="text-success mb-2">
                        <svg class="c-icon c-icon-sm mr-1">
                            <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-arrow-bottom')}}"></use>
                        </svg>
                        Stock In
                    </h6>
                    <ul class="list-unstyled mb-0 ml-3">
                        <li><small>• Purchase receipts</small></li>
                        <li><small>• Returns from departments</small></li>
                        <li><small>• Transfers from other locations</small></li>
                    </ul>
                </div>
                <div>
                    <h6 class="text-danger mb-2">
                        <svg class="c-icon c-icon-sm mr-1">
                            <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-arrow-top')}}"></use>
                        </svg>
                        Stock Out
                    </h6>
                    <ul class="list-unstyled mb-0 ml-3">
                        <li><small>• Issues to departments</small></li>
                        <li><small>• Consumption/Usage</small></li>
                        <li><small>• Transfers to other locations</small></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const movementType = document.getElementById('movement_type');
    const quantity = document.getElementById('quantity');
    const supplierGroup = document.getElementById('supplier-group');
    const recipientGroup = document.getElementById('recipient-group');
    const currentStock = {{ $inventory->quantity_in_stock }};
    const minStock = {{ $inventory->minimum_stock_level }};
    const unitCost = {{ $inventory->unit_cost }};
    const unitOfMeasure = '{{ $inventory->unit_of_measure }}';
    
    function updatePreview() {
        const type = movementType.value;
        const qty = parseInt(quantity.value) || 0;
        
        // Show/hide relevant fields
        if (type === 'in') {
            supplierGroup.style.display = 'block';
            recipientGroup.style.display = 'none';
        } else if (type === 'out') {
            supplierGroup.style.display = 'none';
            recipientGroup.style.display = 'block';
        } else {
            supplierGroup.style.display = 'none';
            recipientGroup.style.display = 'none';
        }
        
        if (!type || !qty) {
            document.getElementById('movement-amount').textContent = '-';
            document.getElementById('new-stock').innerHTML = '<strong>-</strong>';
            document.getElementById('total-value').textContent = '-';
            document.getElementById('submit-btn').disabled = true;
            hideAlerts();
            return;
        }
        
        let newStock;
        let movementText;
        
        if (type === 'in') {
            newStock = currentStock + qty;
            movementText = `+${qty} ${unitOfMeasure}`;
        } else {
            newStock = currentStock - qty;
            movementText = `-${qty} ${unitOfMeasure}`;
        }
        
        const totalValue = qty * unitCost;
        
        document.getElementById('movement-amount').textContent = movementText;
        document.getElementById('new-stock').innerHTML = `<strong>${Math.max(0, newStock)} ${unitOfMeasure}</strong>`;
        document.getElementById('total-value').textContent = `$${totalValue.toFixed(2)}`;
        
        // Show warnings/errors
        hideAlerts();
        if (type === 'out' && qty > currentStock) {
            document.getElementById('stock-error').classList.remove('d-none');
            document.getElementById('submit-btn').disabled = true;
        } else if (type === 'out' && newStock <= minStock && newStock >= 0) {
            document.getElementById('stock-warning').classList.remove('d-none');
            document.getElementById('submit-btn').disabled = false;
        } else {
            document.getElementById('submit-btn').disabled = false;
        }
    }
    
    function hideAlerts() {
        document.getElementById('stock-warning').classList.add('d-none');
        document.getElementById('stock-error').classList.add('d-none');
    }
    
    movementType.addEventListener('change', updatePreview);
    quantity.addEventListener('input', updatePreview);
});
</script>

<style>
:root {
    --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --primary-color: #667eea;
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

.btn-info {
    background: var(--info-gradient) !important;
    border: none !important;
    color: white !important;
    transition: all 0.3s ease;
}

.btn-info:hover:not(:disabled) {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(54, 209, 220, 0.4);
}

.btn-info:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

.movement-preview {
    position: sticky;
    top: 20px;
}

.form-control:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}
</style>
@endsection
