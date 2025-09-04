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
                            <h6 class="text-primary mb-3" style="color: #000000 !important; font-weight: bold !important;">Basic Information</h6>
                            
                            <div class="form-group">
                                <label for="item_code">Item Code <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="item_code" name="item_code" 
                                           value="{{ old('item_code') }}" required>
                                    <div class="input-group-append">
                                        <button type="button" class="btn" id="generateCodeBtn" 
                                                title="Generate Random Code" onclick="generateRandomCode()"
                                                style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                                            <i class="fas fa-dice me-1"></i> Generate
                                        </button>
                                    </div>
                                </div>
                                <small class="form-text text-muted">Unique identifier for the item. Click the dice icon to generate a random code.</small>
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
                                <div class="input-group">
                                    <input type="text" class="form-control" id="barcode" name="barcode" 
                                           value="{{ old('barcode') }}">
                                    <div class="input-group-append">
                                        <button type="button" class="btn" id="generateBarcodeBtn" 
                                                title="Generate Random Barcode" onclick="generateRandomBarcode()"
                                                style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                                            <i class="fas fa-barcode me-1"></i> Generate
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Stock & Pricing -->
                        <div class="col-md-6">
                            <h6 class="text-primary mb-3" style="color: #000000 !important; font-weight: bold !important;">Stock & Pricing</h6>
                            
                            <div class="form-group">
                                <label for="unit_of_measure">Unit of Measure <span class="text-danger">*</span></label>
                                <select class="form-control" id="unit_of_measure" name="unit_of_measure" required>
                                    <option value="">Select Unit of Measure</option>
                                    <option value="Bags" {{ old('unit_of_measure') == 'Bags' ? 'selected' : '' }}>Bags</option>
                                    <option value="Liters" {{ old('unit_of_measure') == 'Liters' ? 'selected' : '' }}>Liters</option>
                                    <option value="Boxes" {{ old('unit_of_measure') == 'Boxes' ? 'selected' : '' }}>Boxes</option>
                                    <option value="Pieces" {{ old('unit_of_measure') == 'Pieces' ? 'selected' : '' }}>Pieces</option>
                                    <option value="Kilograms" {{ old('unit_of_measure') == 'Kilograms' ? 'selected' : '' }}>Kilograms</option>
                                </select>
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
                            <h6 class="text-primary mb-3" style="color: #000000 !important; font-weight: bold !important;">Additional Information</h6>
                            
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
                            <h6 class="text-primary mb-3" style="color: #000000 !important; font-weight: bold !important;">Specifications (Optional)</h6>
                            
                            <div class="form-group">
                                <label for="specifications">Technical Specifications</label>
                                <textarea class="form-control" id="specifications" name="specifications" rows="4" 
                                          placeholder='Color: Blue, Size: Large, Material: Plastic, Weight: 2kg'>{{ old('specifications') }}</textarea>
                                <small class="form-text text-muted">Enter any technical details or specifications (optional)</small>
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
                            <button type="submit" class="btn" 
                                    style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
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
    color: #000000 !important;
    font-weight: bold !important;
}

.form-control:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

h6, h6.text-primary, .text-primary h6 {
    font-weight: bold !important;
    color: #000000 !important;
    border-bottom: 2px solid #e9ecef;
    padding-bottom: 0.5rem;
}

#generateCodeBtn {
    border-color: var(--primary-color) !important;
    color: var(--primary-color) !important;
    transition: all 0.3s ease;
}

#generateCodeBtn:hover {
    background: var(--primary-color) !important;
    color: white !important;
    transform: scale(1.05);
}
</style>

<script>
function generateRandomCode() {
    // Generate a random code with format: INV-YYYYMMDD-XXXX
    const now = new Date();
    const year = now.getFullYear();
    const month = String(now.getMonth() + 1).padStart(2, '0');
    const day = String(now.getDate()).padStart(2, '0');
    const randomNum = Math.floor(Math.random() * 9999) + 1;
    const randomStr = String(randomNum).padStart(4, '0');
    
    const generatedCode = `INV-${year}${month}${day}-${randomStr}`;
    
    // Set the generated code in the input field
    document.getElementById('item_code').value = generatedCode;
    
    // Add a subtle animation to show the code was generated
    const input = document.getElementById('item_code');
    input.style.background = '#e8f5e8';
    setTimeout(() => {
        input.style.background = '';
    }, 1000);
    
    // Focus on the input so user can edit if needed
    input.focus();
    input.select();
}

function generateRandomBarcode() {
    // Generate a random 13-digit barcode (EAN-13 format)
    let barcode = '';
    for (let i = 0; i < 13; i++) {
        barcode += Math.floor(Math.random() * 10);
    }
    
    // Set the generated barcode in the input field
    document.getElementById('barcode').value = barcode;
    
    // Add a subtle animation to show the barcode was generated
    const input = document.getElementById('barcode');
    input.style.background = '#e8f5e8';
    setTimeout(() => {
        input.style.background = '';
    }, 1000);
    
    // Focus on the input so user can edit if needed
    input.focus();
    input.select();
}
</script>
