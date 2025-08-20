@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="animated fadeIn">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('fixed-assets.index') }}">Fixed Assets</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add New Asset</li>
            </ol>
        </nav>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Add New Fixed Asset</h5>
                <small class="text-muted">Enter the details of the new fixed asset</small>
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

                <form method="POST" action="{{ route('fixed-assets.store') }}">
                    @csrf
                    
                    <!-- Basic Information -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="asset_tag">Asset Tag <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="asset_tag" name="asset_tag" 
                                       value="{{ old('asset_tag') }}" required>
                                <small class="form-text text-muted">Unique identifier for the asset</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Asset Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" 
                                       value="{{ old('name') }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Category and Details -->
                    <div class="row">
                        <div class="col-md-4">
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
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="brand">Brand</label>
                                <input type="text" class="form-control" id="brand" name="brand" 
                                       value="{{ old('brand') }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="model">Model</label>
                                <input type="text" class="form-control" id="model" name="model" 
                                       value="{{ old('model') }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="serial_number">Serial Number</label>
                                <input type="text" class="form-control" id="serial_number" name="serial_number" 
                                       value="{{ old('serial_number') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="supplier">Supplier</label>
                                <input type="text" class="form-control" id="supplier" name="supplier" 
                                       value="{{ old('supplier') }}">
                            </div>
                        </div>
                    </div>

                    <!-- Purchase Information -->
                    <h6 class="mt-4 mb-3">Purchase Information</h6>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="purchase_cost">Purchase Cost <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">$</span>
                                    </div>
                                    <input type="number" class="form-control" id="purchase_cost" name="purchase_cost" 
                                           step="0.01" min="0" value="{{ old('purchase_cost') }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="purchase_date">Purchase Date</label>
                                <input type="date" class="form-control" id="purchase_date" name="purchase_date" 
                                       value="{{ old('purchase_date') }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="current_value">Current Value</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">$</span>
                                    </div>
                                    <input type="number" class="form-control" id="current_value" name="current_value" 
                                           step="0.01" min="0" value="{{ old('current_value') }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Warranty Information -->
                    <h6 class="mt-4 mb-3">Warranty Information</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="warranty_start_date">Warranty Start Date</label>
                                <input type="date" class="form-control" id="warranty_start_date" name="warranty_start_date" 
                                       value="{{ old('warranty_start_date') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="warranty_end_date">Warranty End Date</label>
                                <input type="date" class="form-control" id="warranty_end_date" name="warranty_end_date" 
                                       value="{{ old('warranty_end_date') }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="warranty_details">Warranty Details</label>
                                <textarea class="form-control" id="warranty_details" name="warranty_details" rows="2">{{ old('warranty_details') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Location and Assignment -->
                    <h6 class="mt-4 mb-3">Location and Assignment</h6>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="location">Location <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="location" name="location" 
                                       value="{{ old('location') }}" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="department">Department</label>
                                <input type="text" class="form-control" id="department" name="department" 
                                       value="{{ old('department') }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="assigned_to">Assigned To</label>
                                <input type="text" class="form-control" id="assigned_to" name="assigned_to" 
                                       value="{{ old('assigned_to') }}">
                            </div>
                        </div>
                    </div>

                    <!-- Status and Condition -->
                    <h6 class="mt-4 mb-3">Status and Condition</h6>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="status">Status <span class="text-danger">*</span></label>
                                <select class="form-control" id="status" name="status" required>
                                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                                    <option value="disposed" {{ old('status') == 'disposed' ? 'selected' : '' }}>Disposed</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="condition">Condition <span class="text-danger">*</span></label>
                                <select class="form-control" id="condition" name="condition" required>
                                    <option value="excellent" {{ old('condition') == 'excellent' ? 'selected' : '' }}>Excellent</option>
                                    <option value="good" {{ old('condition') == 'good' ? 'selected' : '' }}>Good</option>
                                    <option value="fair" {{ old('condition') == 'fair' ? 'selected' : '' }}>Fair</option>
                                    <option value="poor" {{ old('condition') == 'poor' ? 'selected' : '' }}>Poor</option>
                                    <option value="damaged" {{ old('condition') == 'damaged' ? 'selected' : '' }}>Damaged</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="accumulated_depreciation">Accumulated Depreciation</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">$</span>
                                    </div>
                                    <input type="number" class="form-control" id="accumulated_depreciation" name="accumulated_depreciation" 
                                           step="0.01" min="0" value="{{ old('accumulated_depreciation', 0) }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Maintenance Dates -->
                    <h6 class="mt-4 mb-3">Maintenance Schedule</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="last_maintenance_date">Last Maintenance Date</label>
                                <input type="date" class="form-control" id="last_maintenance_date" name="last_maintenance_date" 
                                       value="{{ old('last_maintenance_date') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="next_maintenance_date">Next Maintenance Date</label>
                                <input type="date" class="form-control" id="next_maintenance_date" name="next_maintenance_date" 
                                       value="{{ old('next_maintenance_date') }}">
                            </div>
                        </div>
                    </div>

                    <!-- Additional Notes -->
                    <h6 class="mt-4 mb-3">Additional Information</h6>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="notes">Notes</label>
                                <textarea class="form-control" id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="form-group mt-4">
                        <button type="submit" class="btn btn-primary">
                            <svg class="c-icon mr-2">
                                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-save')}}"></use>
                            </svg>
                            Save Asset
                        </button>
                        <a href="{{ route('fixed-assets.index') }}" class="btn btn-secondary ml-2">
                            <svg class="c-icon mr-2">
                                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-x')}}"></use>
                            </svg>
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
