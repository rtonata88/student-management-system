@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Edit Service</h4>
                    <a href="{{ route('fleet.services') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Services
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('fleet.services.update', $service->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="vehicle_id">Vehicle <span class="text-danger">*</span></label>
                                    <select name="vehicle_id" id="vehicle_id" class="form-control @error('vehicle_id') is-invalid @enderror" required>
                                        <option value="">Select Vehicle</option>
                                        @foreach($vehicles as $vehicle)
                                            <option value="{{ $vehicle->id }}" {{ old('vehicle_id', $service->vehicle_id) == $vehicle->id ? 'selected' : '' }}>
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
                                    <input type="date" name="service_date" id="service_date" 
                                           class="form-control @error('service_date') is-invalid @enderror" 
                                           value="{{ old('service_date', $service->service_date->format('Y-m-d')) }}" required>
                                    @error('service_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label for="service_type">Service Type <span class="text-danger">*</span></label>
                                    <select name="service_type" id="service_type" class="form-control @error('service_type') is-invalid @enderror" required>
                                        <option value="">Select Service Type</option>
                                        <option value="routine" {{ old('service_type', $service->service_type) == 'routine' ? 'selected' : '' }}>Routine</option>
                                        <option value="repair" {{ old('service_type', $service->service_type) == 'repair' ? 'selected' : '' }}>Repair</option>
                                        <option value="inspection" {{ old('service_type', $service->service_type) == 'inspection' ? 'selected' : '' }}>Inspection</option>
                                        <option value="oil_change" {{ old('service_type', $service->service_type) == 'oil_change' ? 'selected' : '' }}>Oil Change</option>
                                        <option value="tire_service" {{ old('service_type', $service->service_type) == 'tire_service' ? 'selected' : '' }}>Tire Service</option>
                                        <option value="brake_service" {{ old('service_type', $service->service_type) == 'brake_service' ? 'selected' : '' }}>Brake Service</option>
                                        <option value="other" {{ old('service_type', $service->service_type) == 'other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    @error('service_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label for="cost">Cost <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">$</span>
                                        </div>
                                        <input type="number" name="cost" id="cost" step="0.01" min="0"
                                               class="form-control @error('cost') is-invalid @enderror" 
                                               value="{{ old('cost', $service->cost) }}" required>
                                        @error('cost')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="odometer_reading">Odometer Reading (km) <span class="text-danger">*</span></label>
                                    <input type="number" name="odometer_reading" id="odometer_reading" min="0"
                                           class="form-control @error('odometer_reading') is-invalid @enderror" 
                                           value="{{ old('odometer_reading', $service->odometer_reading) }}" required>
                                    @error('odometer_reading')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label for="service_provider">Service Provider</label>
                                    <input type="text" name="service_provider" id="service_provider" 
                                           class="form-control @error('service_provider') is-invalid @enderror" 
                                           value="{{ old('service_provider', $service->service_provider) }}">
                                    @error('service_provider')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label for="next_service_date">Next Service Due Date</label>
                                    <input type="date" name="next_service_date" id="next_service_date" 
                                           class="form-control @error('next_service_date') is-invalid @enderror" 
                                           value="{{ old('next_service_date', $service->next_service_date ? $service->next_service_date->format('Y-m-d') : '') }}">
                                    @error('next_service_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label for="status">Status <span class="text-danger">*</span></label>
                                    <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                                        <option value="scheduled" {{ old('status', $service->status) == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                                        <option value="in_progress" {{ old('status', $service->status) == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                        <option value="completed" {{ old('status', $service->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="cancelled" {{ old('status', $service->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="description">Description <span class="text-danger">*</span></label>
                                    <textarea name="description" id="description" rows="4" 
                                              class="form-control @error('description') is-invalid @enderror" 
                                              required>{{ old('description', $service->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label for="notes">Notes</label>
                                    <textarea name="notes" id="notes" rows="3" 
                                              class="form-control @error('notes') is-invalid @enderror">{{ old('notes', $service->notes) }}</textarea>
                                    @error('notes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <button type="submit" class="btn" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                                <i class="fas fa-save"></i> Update Service
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
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Auto-calculate next service date based on service type
    $('#service_type').change(function() {
        var serviceType = $(this).val();
        var serviceDate = $('#service_date').val();
        
        if (serviceDate && serviceType) {
            var nextServiceDate = new Date(serviceDate);
            
            // Add months based on service type
            switch(serviceType) {
                case 'oil_change':
                    nextServiceDate.setMonth(nextServiceDate.getMonth() + 3);
                    break;
                case 'maintenance':
                    nextServiceDate.setMonth(nextServiceDate.getMonth() + 6);
                    break;
                case 'inspection':
                    nextServiceDate.setFullYear(nextServiceDate.getFullYear() + 1);
                    break;
                default:
                    nextServiceDate.setMonth(nextServiceDate.getMonth() + 6);
            }
            
            $('#next_service_date').val(nextServiceDate.toISOString().split('T')[0]);
        }
    });
});
</script>
@endsection
