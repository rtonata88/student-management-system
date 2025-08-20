@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-wrench"></i> Add Service Record
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('fleet.services') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to Services
                        </a>
                    </div>
                </div>
                <form action="{{ route('fleet.services.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="mb-3"><i class="fas fa-info-circle"></i> Service Information</h5>
                                
                                <div class="form-group">
                                    <label for="vehicle_id">Vehicle <span class="text-danger">*</span></label>
                                    <select class="form-control @error('vehicle_id') is-invalid @enderror" 
                                            id="vehicle_id" name="vehicle_id" required>
                                        <option value="">Select Vehicle</option>
                                        @foreach($vehicles as $vehicle)
                                            <option value="{{ $vehicle->id }}" {{ old('vehicle_id') == $vehicle->id ? 'selected' : '' }}>
                                                {{ $vehicle->registration_number }} - {{ $vehicle->make }} {{ $vehicle->model }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('vehicle_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="service_date">Service Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('service_date') is-invalid @enderror" 
                                           id="service_date" name="service_date" value="{{ old('service_date', date('Y-m-d')) }}" required>
                                    @error('service_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="service_type">Service Type <span class="text-danger">*</span></label>
                                    <select class="form-control @error('service_type') is-invalid @enderror" 
                                            id="service_type" name="service_type" required>
                                        <option value="">Select Service Type</option>
                                        <option value="routine" {{ old('service_type') == 'routine' ? 'selected' : '' }}>Routine Maintenance</option>
                                        <option value="repair" {{ old('service_type') == 'repair' ? 'selected' : '' }}>Repair</option>
                                        <option value="inspection" {{ old('service_type') == 'inspection' ? 'selected' : '' }}>Inspection</option>
                                        <option value="oil_change" {{ old('service_type') == 'oil_change' ? 'selected' : '' }}>Oil Change</option>
                                        <option value="tire_service" {{ old('service_type') == 'tire_service' ? 'selected' : '' }}>Tire Service</option>
                                        <option value="brake_service" {{ old('service_type') == 'brake_service' ? 'selected' : '' }}>Brake Service</option>
                                        <option value="other" {{ old('service_type') == 'other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    @error('service_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="description">Description <span class="text-danger">*</span></label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              id="description" name="description" rows="4" required 
                                              placeholder="Describe the service performed...">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="odometer_reading">Odometer Reading (km) <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('odometer_reading') is-invalid @enderror" 
                                           id="odometer_reading" name="odometer_reading" 
                                           value="{{ old('odometer_reading') }}" min="0" step="0.1" required>
                                    @error('odometer_reading')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <h5 class="mb-3"><i class="fas fa-dollar-sign"></i> Cost & Status</h5>

                                <div class="form-group">
                                    <label for="cost">Service Cost <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">$</span>
                                        </div>
                                        <input type="number" class="form-control @error('cost') is-invalid @enderror" 
                                               id="cost" name="cost" value="{{ old('cost') }}" 
                                               min="0" step="0.01" required>
                                        @error('cost')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="service_provider">Service Provider</label>
                                    <input type="text" class="form-control @error('service_provider') is-invalid @enderror" 
                                           id="service_provider" name="service_provider" value="{{ old('service_provider') }}">
                                    @error('service_provider')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="status">Status <span class="text-danger">*</span></label>
                                    <select class="form-control @error('status') is-invalid @enderror" 
                                            id="status" name="status" required>
                                        <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="next_service_date">Next Service Date</label>
                                    <input type="date" class="form-control @error('next_service_date') is-invalid @enderror" 
                                           id="next_service_date" name="next_service_date" value="{{ old('next_service_date') }}">
                                    @error('next_service_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="next_service_mileage">Next Service Mileage (km)</label>
                                    <input type="number" class="form-control @error('next_service_mileage') is-invalid @enderror" 
                                           id="next_service_mileage" name="next_service_mileage" 
                                           value="{{ old('next_service_mileage') }}" min="0" step="0.1">
                                    @error('next_service_mileage')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="notes">Notes</label>
                                    <textarea class="form-control @error('notes') is-invalid @enderror" 
                                              id="notes" name="notes" rows="3" 
                                              placeholder="Any additional notes...">{{ old('notes') }}</textarea>
                                    @error('notes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Save Service Record
                        </button>
                        <a href="{{ route('fleet.services') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
