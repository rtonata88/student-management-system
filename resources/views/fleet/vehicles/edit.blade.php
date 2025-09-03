@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-edit"></i> Edit Vehicle
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('fleet.vehicles') }}" class="btn btn-sm" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                            <i class="fas fa-arrow-left"></i> Back to Vehicles
                        </a>
                    </div>
                </div>
                <form action="{{ route('fleet.vehicles.update', $vehicle) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <div class="card-body">
                        <div class="row">
                            <!-- Basic Information -->
                            <div class="col-md-6">
                                <h5 class="mb-3"><i class="fas fa-info-circle"></i> Basic Information</h5>
                                
                                <div class="form-group">
                                    <label for="registration_number">Registration Number <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('registration_number') is-invalid @enderror" 
                                           id="registration_number" name="registration_number" 
                                           value="{{ old('registration_number', $vehicle->registration_number) }}" required>
                                    @error('registration_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="make">Make <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('make') is-invalid @enderror" 
                                           id="make" name="make" value="{{ old('make', $vehicle->make) }}" 
                                           placeholder="e.g. Mercedes-Benz, Toyota, Ford, BMW, Nissan" required>
                                    @error('make')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="model">Model <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('model') is-invalid @enderror" 
                                           id="model" name="model" value="{{ old('model', $vehicle->model) }}" 
                                           placeholder="e.g. Sprinter, Hiace, Transit, X5, Patrol" required>
                                    @error('model')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="year">Year <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('year') is-invalid @enderror" 
                                           id="year" name="year" value="{{ old('year', $vehicle->year) }}" 
                                           min="1990" max="{{ date('Y') + 1 }}" required>
                                    @error('year')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="category_id">Category <span class="text-danger">*</span></label>
                                    <select class="form-control @error('category_id') is-invalid @enderror" 
                                            id="category_id" name="category_id" required>
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id', $vehicle->category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="fuel_type">Fuel Type <span class="text-danger">*</span></label>
                                    <select class="form-control @error('fuel_type') is-invalid @enderror" 
                                            id="fuel_type" name="fuel_type" required>
                                        <option value="">Select Fuel Type</option>
                                        <option value="petrol" {{ old('fuel_type', $vehicle->fuel_type) == 'petrol' ? 'selected' : '' }}>Petrol</option>
                                        <option value="diesel" {{ old('fuel_type', $vehicle->fuel_type) == 'diesel' ? 'selected' : '' }}>Diesel</option>
                                        <option value="electric" {{ old('fuel_type', $vehicle->fuel_type) == 'electric' ? 'selected' : '' }}>Electric</option>
                                        <option value="hybrid" {{ old('fuel_type', $vehicle->fuel_type) == 'hybrid' ? 'selected' : '' }}>Hybrid</option>
                                    </select>
                                    @error('fuel_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Technical Details -->
                            <div class="col-md-6">
                                <h5 class="mb-3"><i class="fas fa-cogs"></i> Technical Details</h5>

                                <div class="form-group">
                                    <label for="engine_number">Engine Number</label>
                                    <input type="text" class="form-control @error('engine_number') is-invalid @enderror" 
                                           id="engine_number" name="engine_number" value="{{ old('engine_number', $vehicle->engine_number) }}">
                                    @error('engine_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="chassis_number">Chassis Number</label>
                                    <input type="text" class="form-control @error('chassis_number') is-invalid @enderror" 
                                           id="chassis_number" name="chassis_number" value="{{ old('chassis_number', $vehicle->chassis_number) }}">
                                    @error('chassis_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="color">Color</label>
                                    <input type="text" class="form-control @error('color') is-invalid @enderror" 
                                           id="color" name="color" value="{{ old('color', $vehicle->color) }}">
                                    @error('color')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="seating_capacity">Seating Capacity <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('seating_capacity') is-invalid @enderror" 
                                           id="seating_capacity" name="seating_capacity" 
                                           value="{{ old('seating_capacity', $vehicle->seating_capacity) }}" min="1" max="100" required>
                                    @error('seating_capacity')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="fuel_capacity">Fuel Capacity (Liters) <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('fuel_capacity') is-invalid @enderror" 
                                           id="fuel_capacity" name="fuel_capacity" 
                                           value="{{ old('fuel_capacity', $vehicle->fuel_capacity) }}" min="0" step="0.1" required>
                                    @error('fuel_capacity')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="current_odometer">Current Mileage (km)</label>
                                    <input type="number" class="form-control @error('current_odometer') is-invalid @enderror" 
                                           id="current_odometer" name="current_odometer" 
                                           value="{{ old('current_odometer', $vehicle->current_odometer ?? 0) }}" min="0" step="1">
                                    @error('current_odometer')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="status">Status <span class="text-danger">*</span></label>
                                    <select class="form-control @error('status') is-invalid @enderror" 
                                            id="status" name="status" required>
                                        <option value="">Select Status</option>
                                        <option value="active" {{ old('status', $vehicle->status) == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="maintenance" {{ old('status', $vehicle->status) == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                                        <option value="retired" {{ old('status', $vehicle->status) == 'retired' ? 'selected' : '' }}>Retired</option>
                                        <option value="accident" {{ old('status', $vehicle->status) == 'accident' ? 'selected' : '' }}>Accident</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Insurance & License Information -->
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <h5 class="mb-3"><i class="fas fa-shield-alt"></i> Insurance & License Information</h5>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="purchase_date">Purchase Date</label>
                                    <input type="date" class="form-control @error('purchase_date') is-invalid @enderror" 
                                           id="purchase_date" name="purchase_date" 
                                           value="{{ old('purchase_date', $vehicle->purchase_date ? $vehicle->purchase_date->format('Y-m-d') : '') }}">
                                    @error('purchase_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="purchase_price">Purchase Price</label>
                                    <input type="number" class="form-control @error('purchase_price') is-invalid @enderror" 
                                           id="purchase_price" name="purchase_price" 
                                           value="{{ old('purchase_price', $vehicle->purchase_price) }}" min="0" step="0.01">
                                    @error('purchase_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="insurance_expiry">Insurance Expiry Date</label>
                                    <input type="date" class="form-control @error('insurance_expiry') is-invalid @enderror" 
                                           id="insurance_expiry" name="insurance_expiry" 
                                           value="{{ old('insurance_expiry', $vehicle->insurance_expiry ? $vehicle->insurance_expiry->format('Y-m-d') : '') }}">
                                    @error('insurance_expiry')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="license_expiry">License Expiry Date</label>
                                    <input type="date" class="form-control @error('license_expiry') is-invalid @enderror" 
                                           id="license_expiry" name="license_expiry" 
                                           value="{{ old('license_expiry', $vehicle->license_expiry ? $vehicle->license_expiry->format('Y-m-d') : '') }}">
                                    @error('license_expiry')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Notes -->
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="notes">Notes</label>
                                    <textarea class="form-control @error('notes') is-invalid @enderror" 
                                              id="notes" name="notes" rows="3" 
                                              placeholder="Any additional notes about this vehicle...">{{ old('notes', $vehicle->notes) }}</textarea>
                                    @error('notes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                            <i class="fas fa-save"></i> Update Vehicle
                        </button>
                        <a href="{{ route('fleet.vehicles') }}" class="btn" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
