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
                        <a href="{{ route('fleet.services') }}" class="btn btn-sm" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                            <i class="fas fa-arrow-left"></i> Back to Services
                        </a>
                    </div>
                </div>
                <form action="{{ route('fleet.services.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <!-- Row 1: Vehicle, Service Type, Service Date -->
                        <div class="row">
                            <div class="col-md-4">
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
                            </div>
                            <div class="col-md-4">
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
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="service_date">Service Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('service_date') is-invalid @enderror" 
                                           id="service_date" name="service_date" value="{{ old('service_date', date('Y-m-d')) }}" required>
                                    @error('service_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Row 2: Service Provider, Service Cost, Status -->
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="service_provider">Service Provider <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('service_provider') is-invalid @enderror" 
                                           id="service_provider" name="service_provider" value="{{ old('service_provider') }}" 
                                           required placeholder="Name of service provider">
                                    @error('service_provider')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="cost">Service Cost <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('cost') is-invalid @enderror" 
                                           id="cost" name="cost" value="{{ old('cost') }}" 
                                           min="0" step="0.01" required placeholder="0.00">
                                    @error('cost')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="status">Status <span class="text-danger">*</span></label>
                                    <select class="form-control @error('status') is-invalid @enderror" 
                                            id="status" name="status" required>
                                        <option value="">Select Status</option>
                                        <option value="scheduled" {{ old('status') == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                                        <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                        <option value="completed" {{ old('status', 'completed') == 'completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Row 3: Odometer Reading, Next Service Date, Next Service Odometer -->
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="odometer_reading">Odometer Reading (km) <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('odometer_reading') is-invalid @enderror" 
                                           id="odometer_reading" name="odometer_reading" value="{{ old('odometer_reading') }}" 
                                           min="0" step="1" required>
                                    @error('odometer_reading')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="next_service_date">Next Service Date</label>
                                    <input type="date" class="form-control @error('next_service_date') is-invalid @enderror" 
                                           id="next_service_date" name="next_service_date" value="{{ old('next_service_date') }}">
                                    <small class="text-muted">Automatically calculated as Service Date + 1 year (editable)</small>
                                    @error('next_service_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="next_service_odometer">Next Service Odometer (km)</label>
                                    <input type="number" class="form-control @error('next_service_odometer') is-invalid @enderror" 
                                           id="next_service_odometer" name="next_service_odometer" 
                                           value="{{ old('next_service_odometer') }}" min="0" step="1">
                                    @error('next_service_odometer')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Row 4: Service Description and Notes (2x1 layout) -->
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="description">Service Description <span class="text-danger">*</span></label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              id="description" name="description" rows="4" required 
                                              placeholder="Describe the service performed...">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="notes">Notes</label>
                                    <textarea class="form-control @error('notes') is-invalid @enderror" 
                                              id="notes" name="notes" rows="4" 
                                              placeholder="Any additional notes...">{{ old('notes') }}</textarea>
                                    @error('notes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                            <i class="fas fa-save"></i> Save Service Record
                        </button>
                        <a href="{{ route('fleet.services') }}" class="btn" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem; margin-left: 8px;">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Auto-calculate Next Service Date when Service Date changes
    function calculateNextServiceDate() {
        var serviceDate = $('#service_date').val();
        
        if (serviceDate) {
            var date = new Date(serviceDate);
            // Add 365 days (1 year)
            date.setDate(date.getDate() + 365);
            
            // Format date as YYYY-MM-DD for input field
            var nextServiceDate = date.toISOString().split('T')[0];
            
            // Only update if the field is empty or was auto-calculated
            if (!$('#next_service_date').val() || $('#next_service_date').data('auto-calculated') !== false) {
                $('#next_service_date').val(nextServiceDate);
                $('#next_service_date').data('auto-calculated', true);
            }
        }
    }
    
    // Validate Next Service Odometer against Odometer Reading
    function validateOdometerReading() {
        var currentOdometer = parseInt($('#odometer_reading').val()) || 0;
        var nextOdometer = parseInt($('#next_service_odometer').val()) || 0;
        
        if (nextOdometer > 0 && nextOdometer < currentOdometer) {
            $('#next_service_odometer').addClass('is-invalid');
            if (!$('#next_service_odometer').next('.invalid-feedback').length) {
                $('#next_service_odometer').after('<div class="invalid-feedback">Next Service Odometer cannot be less than current Odometer Reading</div>');
            }
            return false;
        } else {
            $('#next_service_odometer').removeClass('is-invalid');
            $('#next_service_odometer').next('.invalid-feedback').remove();
            return true;
        }
    }
    
    // Track manual changes to next service date field
    $('#next_service_date').on('input change', function() {
        if ($(this).val()) {
            $(this).data('auto-calculated', false);
        }
    });
    
    // Bind events for service date changes
    $('#service_date').on('input change', calculateNextServiceDate);
    
    // Bind events for odometer validation
    $('#odometer_reading, #next_service_odometer').on('input change', validateOdometerReading);
    
    // Form submission validation
    $('form').on('submit', function(e) {
        if (!validateOdometerReading()) {
            e.preventDefault();
            return false;
        }
    });
    
    // Initial calculation on page load
    calculateNextServiceDate();
});
</script>
@endsection
