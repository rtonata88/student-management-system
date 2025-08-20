@extends('layouts.app')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Asset Management</li>
        <li class="breadcrumb-item"><a href="{{ route('inventories.index') }}">Inventories</a></li>
        <li class="breadcrumb-item"><a href="{{ route('inventories.show', $inventory) }}">{{ $inventory->name }}</a></li>
        <li class="breadcrumb-item">Adjust Stock</li>
        <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection
@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Adjust Stock - {{ $inventory->name }}</h5>
                <small class="text-muted">Make inventory adjustments for stock corrections</small>
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

                <form method="POST" action="{{ route('inventories.process-stock-adjustment', $inventory) }}">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="adjustment_type">Adjustment Type <span class="text-danger">*</span></label>
                                <select class="form-control" id="adjustment_type" name="adjustment_type" required>
                                    <option value="">Select Adjustment Type</option>
                                    <option value="increase" {{ old('adjustment_type') == 'increase' ? 'selected' : '' }}>Increase Stock</option>
                                    <option value="decrease" {{ old('adjustment_type') == 'decrease' ? 'selected' : '' }}>Decrease Stock</option>
                                    <option value="set" {{ old('adjustment_type') == 'set' ? 'selected' : '' }}>Set Exact Quantity</option>
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
                                <small class="form-text text-muted" id="adjustment-help"></small>
                            </div>

                            <div class="form-group">
                                <label for="reason">Reason <span class="text-danger">*</span></label>
                                <select class="form-control" id="reason" name="reason" required>
                                    <option value="">Select Reason</option>
                                    <option value="Physical count correction" {{ old('reason') == 'Physical count correction' ? 'selected' : '' }}>Physical count correction</option>
                                    <option value="Damaged goods" {{ old('reason') == 'Damaged goods' ? 'selected' : '' }}>Damaged goods</option>
                                    <option value="Expired items" {{ old('reason') == 'Expired items' ? 'selected' : '' }}>Expired items</option>
                                    <option value="Lost items" {{ old('reason') == 'Lost items' ? 'selected' : '' }}>Lost items</option>
                                    <option value="Found items" {{ old('reason') == 'Found items' ? 'selected' : '' }}>Found items</option>
                                    <option value="System error correction" {{ old('reason') == 'System error correction' ? 'selected' : '' }}>System error correction</option>
                                    <option value="Other" {{ old('reason') == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="notes">Additional Notes</label>
                                <textarea class="form-control" id="notes" name="notes" rows="3" 
                                          placeholder="Provide additional details about this adjustment">{{ old('notes') }}</textarea>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="adjustment-preview card bg-light">
                                <div class="card-header">
                                    <h6 class="mb-0">Adjustment Preview</h6>
                                </div>
                                <div class="card-body">
                                    <table class="table table-sm mb-0">
                                        <tr>
                                            <td><strong>Current Stock:</strong></td>
                                            <td id="current-stock">{{ $inventory->quantity_in_stock }} {{ $inventory->unit_of_measure }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Adjustment:</strong></td>
                                            <td id="adjustment-amount">-</td>
                                        </tr>
                                        <tr class="table-primary">
                                            <td><strong>New Stock:</strong></td>
                                            <td id="new-stock"><strong>-</strong></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Minimum Level:</strong></td>
                                            <td>{{ $inventory->minimum_stock_level }} {{ $inventory->unit_of_measure }}</td>
                                        </tr>
                                    </table>
                                    
                                    <div class="mt-3">
                                        <div id="stock-warning" class="alert alert-warning d-none">
                                            <small><strong>Warning:</strong> This adjustment will result in low stock levels.</small>
                                        </div>
                                        <div id="stock-error" class="alert alert-danger d-none">
                                            <small><strong>Error:</strong> Cannot reduce stock below zero.</small>
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
                            <button type="submit" class="btn btn-warning" id="submit-btn" disabled>
                                <svg class="c-icon c-icon-sm mr-1">
                                    <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-settings')}}"></use>
                                </svg>
                                Process Adjustment
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
                <h6 class="mb-0">Adjustment Guidelines</h6>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0">
                    <li class="mb-2">
                        <svg class="c-icon c-icon-sm text-info mr-1">
                            <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-info')}}"></use>
                        </svg>
                        <small>Use "Increase" for found or corrected items</small>
                    </li>
                    <li class="mb-2">
                        <svg class="c-icon c-icon-sm text-warning mr-1">
                            <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-warning')}}"></use>
                        </svg>
                        <small>Use "Decrease" for damaged or lost items</small>
                    </li>
                    <li class="mb-2">
                        <svg class="c-icon c-icon-sm text-primary mr-1">
                            <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-settings')}}"></use>
                        </svg>
                        <small>Use "Set" to correct to exact count</small>
                    </li>
                    <li>
                        <svg class="c-icon c-icon-sm text-success mr-1">
                            <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-check')}}"></use>
                        </svg>
                        <small>All adjustments are tracked for audit</small>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const adjustmentType = document.getElementById('adjustment_type');
    const quantity = document.getElementById('quantity');
    const currentStock = {{ $inventory->quantity_in_stock }};
    const minStock = {{ $inventory->minimum_stock_level }};
    const unitOfMeasure = '{{ $inventory->unit_of_measure }}';
    
    function updatePreview() {
        const type = adjustmentType.value;
        const qty = parseInt(quantity.value) || 0;
        
        if (!type || !qty) {
            document.getElementById('adjustment-amount').textContent = '-';
            document.getElementById('new-stock').innerHTML = '<strong>-</strong>';
            document.getElementById('submit-btn').disabled = true;
            hideAlerts();
            return;
        }
        
        let newStock;
        let adjustmentText;
        
        switch(type) {
            case 'increase':
                newStock = currentStock + qty;
                adjustmentText = `+${qty} ${unitOfMeasure}`;
                break;
            case 'decrease':
                newStock = Math.max(0, currentStock - qty);
                adjustmentText = `-${Math.min(qty, currentStock)} ${unitOfMeasure}`;
                break;
            case 'set':
                newStock = qty;
                adjustmentText = qty > currentStock ? 
                    `+${qty - currentStock} ${unitOfMeasure}` : 
                    `-${currentStock - qty} ${unitOfMeasure}`;
                break;
        }
        
        document.getElementById('adjustment-amount').textContent = adjustmentText;
        document.getElementById('new-stock').innerHTML = `<strong>${newStock} ${unitOfMeasure}</strong>`;
        
        // Show warnings
        hideAlerts();
        if (type === 'decrease' && qty > currentStock) {
            document.getElementById('stock-error').classList.remove('d-none');
            document.getElementById('submit-btn').disabled = true;
        } else if (newStock <= minStock && newStock > 0) {
            document.getElementById('stock-warning').classList.remove('d-none');
            document.getElementById('submit-btn').disabled = false;
        } else {
            document.getElementById('submit-btn').disabled = false;
        }
        
        // Update help text
        updateHelpText(type);
    }
    
    function updateHelpText(type) {
        const helpElement = document.getElementById('adjustment-help');
        switch(type) {
            case 'increase':
                helpElement.textContent = 'Enter the quantity to add to current stock';
                break;
            case 'decrease':
                helpElement.textContent = 'Enter the quantity to remove from current stock';
                break;
            case 'set':
                helpElement.textContent = 'Enter the exact quantity that should be in stock';
                break;
            default:
                helpElement.textContent = '';
        }
    }
    
    function hideAlerts() {
        document.getElementById('stock-warning').classList.add('d-none');
        document.getElementById('stock-error').classList.add('d-none');
    }
    
    adjustmentType.addEventListener('change', updatePreview);
    quantity.addEventListener('input', updatePreview);
});
</script>

<style>
:root {
    --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --primary-color: #667eea;
    --warning-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
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

.btn-warning {
    background: var(--warning-gradient) !important;
    border: none !important;
    color: white !important;
    transition: all 0.3s ease;
}

.btn-warning:hover:not(:disabled) {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(240, 147, 251, 0.4);
}

.btn-warning:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

.adjustment-preview {
    position: sticky;
    top: 20px;
}

.form-control:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}
</style>
@endsection
