@extends('layouts.app')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Asset Management</li>
        <li class="breadcrumb-item"><a href="{{ route('inventories.index') }}">Inventories</a></li>
        <li class="breadcrumb-item">Add Item</li>
        <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection
@section('content')
<div class="row">
    <div class="col-md-12 col-xs-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Add New Inventory Item</h5>
                <small class="text-muted">Create a new inventory item for the school system</small>
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

                <form method="POST" action="{{ route('inventories.store') }}">
                    @csrf
                    
                    <div class="row">
                        <!-- Basic Information -->
                        <div class="col-md-6">
                            <h6 class="text-primary mb-3">Basic Information</h6>
                            
                            <div class="form-group">
                                <label for="item_code">Item Code <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="item_code" name="item_code" 
                                       value="{{ old('item_code') }}" required>
                                <small class="form-text text-muted">Unique identifier for the item</small>
                            </div>

                            <div class="form-group">
                                <label for="name">Item Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" 
                                       value="{{ old('name') }}" required>
                            </div>

                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="category_id">Category <span class="text-danger">*</span></label>
                                <select class="form-control" id="category_id" name="category_id" required>
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="barcode">Barcode</label>
                                <input type="text" class="form-control" id="barcode" name="barcode" 
                                       value="{{ old('barcode') }}">
                            </div>
                        </div>

                        <!-- Stock & Pricing -->
                        <div class="col-md-6">
                            <h6 class="text-primary mb-3">Stock & Pricing</h6>
                            
                            <div class="form-group">
                                <label for="unit_of_measure">Unit of Measure <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="unit_of_measure" name="unit_of_measure" 
                                       value="{{ old('unit_of_measure') }}" placeholder="e.g., pieces, boxes, liters" required>
                            </div>

                            <div class="form-group">
                                <label for="unit_cost">Unit Cost <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">$</span>
                                    </div>
                                    <input type="number" class="form-control" id="unit_cost" name="unit_cost" 
                                           value="{{ old('unit_cost') }}" step="0.01" min="0" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="quantity_in_stock">Initial Stock Quantity <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="quantity_in_stock" name="quantity_in_stock" 
                                       value="{{ old('quantity_in_stock', 0) }}" min="0" required>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="minimum_stock_level">Minimum Stock Level <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="minimum_stock_level" name="minimum_stock_level" 
                                               value="{{ old('minimum_stock_level', 0) }}" min="0" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="maximum_stock_level">Maximum Stock Level</label>
                                        <input type="number" class="form-control" id="maximum_stock_level" name="maximum_stock_level" 
                                               value="{{ old('maximum_stock_level') }}" min="0">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="expiry_date">Expiry Date</label>
                                <input type="date" class="form-control" id="expiry_date" name="expiry_date" 
                                       value="{{ old('expiry_date') }}" min="{{ date('Y-m-d') }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Additional Information -->
                        <div class="col-md-6">
                            <h6 class="text-primary mb-3">Additional Information</h6>
                            
                            <div class="form-group">
                                <label for="supplier">Supplier</label>
                                <input type="text" class="form-control" id="supplier" name="supplier" 
                                       value="{{ old('supplier') }}">
                            </div>

                            <div class="form-group">
                                <label for="location">Storage Location</label>
                                <input type="text" class="form-control" id="location" name="location" 
                                       value="{{ old('location') }}" placeholder="e.g., Warehouse A, Room 101">
                            </div>
                        </div>

                        <!-- Specifications -->
                        <div class="col-md-6">
                            <h6 class="text-primary mb-3">Specifications (Optional)</h6>
                            
                            <div class="form-group">
                                <label for="specifications">Technical Specifications</label>
                                <textarea class="form-control" id="specifications" name="specifications" rows="4" 
                                          placeholder='{"color": "blue", "size": "large", "material": "plastic"}'>{{ old('specifications') }}</textarea>
                                <small class="form-text text-muted">Enter as JSON format for structured data</small>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mt-4">
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('inventories.index') }}" class="btn btn-outline-secondary">
                                <svg class="c-icon c-icon-sm mr-1">
                                    <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-arrow-left')}}"></use>
                                </svg>
                                Back to List
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <svg class="c-icon c-icon-sm mr-1">
                                    <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-save')}}"></use>
                                </svg>
                                Create Item
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

<style>
:root {
    --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --primary-color: #667eea;
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
    transition: all 0.3s ease;
}

.btn-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
}

.btn-outline-secondary {
    border: 2px solid #6c757d !important;
    color: #6c757d !important;
    background: transparent !important;
    transition: all 0.3s ease;
}

.btn-outline-secondary:hover {
    background: #6c757d !important;
    color: white !important;
    transform: translateY(-1px);
}

.text-primary {
    color: var(--primary-color) !important;
}

.form-control:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

h6 {
    font-weight: 600;
    border-bottom: 2px solid #e9ecef;
    padding-bottom: 0.5rem;
}
</style>
