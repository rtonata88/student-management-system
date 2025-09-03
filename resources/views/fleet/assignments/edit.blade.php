@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-user-cog"></i> Edit Vehicle Assignment
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('fleet.assignments') }}" class="btn btn-sm" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                            <i class="fas fa-arrow-left"></i> Back to Assignments
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('fleet.assignments.update', $assignment->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="vehicle_id">Vehicle <span class="text-danger">*</span></label>
                                    <select name="vehicle_id" id="vehicle_id" class="form-control @error('vehicle_id') is-invalid @enderror" required>
                                        <option value="">Select Vehicle</option>
                                        @foreach($vehicles as $vehicle)
                                            <option value="{{ $vehicle->id }}" {{ (old('vehicle_id', $assignment->vehicle_id) == $vehicle->id) ? 'selected' : '' }}>
                                                {{ $vehicle->registration_number }} - {{ $vehicle->make }} {{ $vehicle->model }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('vehicle_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="driver_id">Driver <span class="text-danger">*</span></label>
                                    <select name="driver_id" id="driver_id" class="form-control @error('driver_id') is-invalid @enderror" required>
                                        <option value="">Select Driver</option>
                                        @foreach($drivers as $driver)
                                            <option value="{{ $driver->id }}" {{ (old('driver_id', $assignment->driver_id) == $driver->id) ? 'selected' : '' }}>
                                                {{ $driver->first_name }} {{ $driver->last_name }} ({{ $driver->employee_number }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('driver_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="assignment_type">Assignment Type <span class="text-danger">*</span></label>
                                    <select name="assignment_type" id="assignment_type" class="form-control @error('assignment_type') is-invalid @enderror" required>
                                        <option value="">Select Type</option>
                                        <option value="primary" {{ old('assignment_type', $assignment->assignment_type) == 'primary' ? 'selected' : '' }}>Primary Driver</option>
                                        <option value="secondary" {{ old('assignment_type', $assignment->assignment_type) == 'secondary' ? 'selected' : '' }}>Secondary Driver</option>
                                        <option value="temporary" {{ old('assignment_type', $assignment->assignment_type) == 'temporary' ? 'selected' : '' }}>Temporary Assignment</option>
                                    </select>
                                    @error('assignment_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="start_date">Start Date <span class="text-danger">*</span></label>
                                    <input type="date" name="start_date" id="start_date" class="form-control @error('start_date') is-invalid @enderror" value="{{ old('start_date', $assignment->start_date ? $assignment->start_date->format('Y-m-d') : '') }}" required>
                                    @error('start_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="end_date">End Date</label>
                                    <input type="date" name="end_date" id="end_date" class="form-control @error('end_date') is-invalid @enderror" value="{{ old('end_date', $assignment->end_date ? $assignment->end_date->format('Y-m-d') : '') }}">
                                    <small class="form-text text-muted">Leave empty for ongoing assignment</small>
                                    @error('end_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status">Status <span class="text-danger">*</span></label>
                                    <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                                        <option value="active" {{ old('status', $assignment->status) == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ old('status', $assignment->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="notes">Notes</label>
                            <textarea name="notes" id="notes" rows="3" class="form-control @error('notes') is-invalid @enderror" placeholder="Additional notes about this assignment">{{ old('notes', $assignment->notes) }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <button type="submit" class="btn" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                                <i class="fas fa-save"></i> Update Assignment
                            </button>
                            <a href="{{ route('fleet.assignments') }}" class="btn btn-secondary ml-2">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Set minimum date for end_date based on start_date
    $('#start_date').on('change', function() {
        var startDate = $(this).val();
        $('#end_date').attr('min', startDate);
    });
    
    // Initialize minimum date on page load
    var currentStartDate = $('#start_date').val();
    if (currentStartDate) {
        $('#end_date').attr('min', currentStartDate);
    }
});
</script>
@endpush
@endsection
