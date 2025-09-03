@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-route"></i> Create New Trip
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('fleet.trips') }}" class="btn btn-sm" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                            <i class="fas fa-arrow-left"></i> Back to Trips
                        </a>
                    </div>
                </div>

                <!-- Display validation errors -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('fleet.trips.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <!-- Vehicle Selection -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="vehicle_id">Vehicle <span class="text-danger">*</span></label>
                                    <select name="vehicle_id" id="vehicle_id" class="form-control" required>
                                        <option value="">Select Vehicle</option>
                                        @foreach($vehicles as $vehicle)
                                            <option value="{{ $vehicle->id }}" {{ old('vehicle_id') == $vehicle->id ? 'selected' : '' }}>
                                                {{ $vehicle->make }} {{ $vehicle->model }} ({{ $vehicle->registration_number }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Driver Selection -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="driver_id">Driver <span class="text-danger">*</span></label>
                                    <select name="driver_id" id="driver_id" class="form-control" required>
                                        <option value="">Select Driver</option>
                                        @foreach($drivers as $driver)
                                            <option value="{{ $driver->id }}" {{ old('driver_id') == $driver->id ? 'selected' : '' }}>
                                                {{ $driver->full_name }} ({{ $driver->employee_number }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Trip Purpose -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="trip_purpose">Trip Purpose <span class="text-danger">*</span></label>
                                    <select name="trip_purpose" id="trip_purpose" class="form-control" required>
                                        <option value="">Select Purpose</option>
                                        <option value="student_transport" {{ old('trip_purpose') == 'student_transport' ? 'selected' : '' }}>Student Transport</option>
                                        <option value="staff_transport" {{ old('trip_purpose') == 'staff_transport' ? 'selected' : '' }}>Staff Transport</option>
                                        <option value="field_trip" {{ old('trip_purpose') == 'field_trip' ? 'selected' : '' }}>Field Trip</option>
                                        <option value="maintenance" {{ old('trip_purpose') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                                        <option value="emergency" {{ old('trip_purpose') == 'emergency' ? 'selected' : '' }}>Emergency</option>
                                        <option value="other" {{ old('trip_purpose') == 'other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Destination -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="destination">Destination <span class="text-danger">*</span></label>
                                    <input type="text" name="destination" id="destination" class="form-control" 
                                           value="{{ old('destination') }}" placeholder="Enter destination address" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Departure Time -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="departure_time">Departure Time <span class="text-danger">*</span></label>
                                    <input type="datetime-local" name="departure_time" id="departure_time" class="form-control" 
                                           value="{{ old('departure_time') }}" required>
                                </div>
                            </div>

                            <!-- Expected Return Time -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="expected_return_time">Expected Return Time</label>
                                    <input type="datetime-local" name="expected_return_time" id="expected_return_time" class="form-control" 
                                           value="{{ old('expected_return_time') }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Starting Odometer -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="odometer_start">Starting Odometer Reading (km) <span class="text-danger">*</span></label>
                                    <input type="number" name="odometer_start" id="odometer_start" class="form-control" 
                                           value="{{ old('odometer_start') }}" placeholder="e.g., 15000" min="0" required>
                                </div>
                            </div>

                            <!-- Ending Odometer -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="odometer_end">Ending Odometer Reading (km) <span class="text-danger">*</span></label>
                                    <input type="number" name="odometer_end" id="odometer_end" class="form-control" 
                                           value="{{ old('odometer_end') }}" placeholder="e.g., 15250" min="0" required>
                                    <small class="text-muted">Must be greater than or equal to starting odometer</small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Total Distance -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="distance_km">Total Distance (km)</label>
                                    <input type="number" name="distance_km" id="distance_km" class="form-control" 
                                           value="{{ old('distance_km') }}" placeholder="Auto-calculated" min="0" step="0.1" readonly>
                                    <small class="text-muted">Automatically calculated from odometer readings</small>
                                </div>
                            </div>

                            <!-- Passenger Count -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="passenger_count">Number of Passengers</label>
                                    <input type="number" name="passenger_count" id="passenger_count" class="form-control" 
                                           value="{{ old('passenger_count') }}" placeholder="e.g., 25" min="0">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Did you fill up fuel? -->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="fuel_filled_up">Did you fill up (fuel)?</label>
                                    <div class="form-check-inline">
                                        <input type="radio" class="form-check-input" id="fuel_filled_yes" name="fuel_filled_up" value="yes" {{ old('fuel_filled_up') == 'yes' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="fuel_filled_yes">Yes</label>
                                    </div>
                                    <div class="form-check-inline ml-3">
                                        <input type="radio" class="form-check-input" id="fuel_filled_no" name="fuel_filled_up" value="no" {{ old('fuel_filled_up') == 'no' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="fuel_filled_no">No</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Fuel Details Section (Hidden by default) -->
                        <div id="fuel_details_section" style="display: none;">
                            <div class="row">
                                <!-- Fuel Type -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="fuel_type">Fuel Type</label>
                                        <select class="form-control" id="fuel_type" name="fuel_type">
                                            <option value="">Select Fuel Type</option>
                                            <option value="petrol" {{ old('fuel_type') == 'petrol' ? 'selected' : '' }}>Petrol</option>
                                            <option value="diesel" {{ old('fuel_type') == 'diesel' ? 'selected' : '' }}>Diesel</option>
                                            <option value="cng" {{ old('fuel_type') == 'cng' ? 'selected' : '' }}>CNG</option>
                                            <option value="electric" {{ old('fuel_type') == 'electric' ? 'selected' : '' }}>Electric</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Number of Liters -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="fuel_liters">Number of Liters</label>
                                        <input type="number" name="fuel_liters" id="fuel_liters" class="form-control" 
                                               value="{{ old('fuel_liters') }}" placeholder="e.g., 50" min="0" step="0.1">
                                    </div>
                                </div>

                                <!-- Price per Liter -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="price_per_liter">Price per Liter</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">$</span>
                                            </div>
                                            <input type="number" name="price_per_liter" id="price_per_liter" class="form-control" 
                                                   value="{{ old('price_per_liter') }}" placeholder="e.g., 1.50" min="0" step="0.001">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Total Fuel Cost -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="total_fuel_cost">Total Fuel Cost</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">$</span>
                                            </div>
                                            <input type="number" name="total_fuel_cost" id="total_fuel_cost" class="form-control" 
                                                   value="{{ old('total_fuel_cost') }}" placeholder="Auto-calculated" min="0" step="0.01" readonly>
                                        </div>
                                        <small class="text-muted">Auto-calculated</small>
                                    </div>
                                </div>

                                <!-- Fuel Station Name -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="fuel_station">Fuel Station Name</label>
                                        <input type="text" name="fuel_station" id="fuel_station" class="form-control" 
                                               value="{{ old('fuel_station') }}" placeholder="e.g., Shell, BP, Total">
                                    </div>
                                </div>

                                <!-- Town / City -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="fuel_town_city">Town / City</label>
                                        <input type="text" name="fuel_town_city" id="fuel_town_city" class="form-control" 
                                               value="{{ old('fuel_town_city') }}" placeholder="e.g., Windhoek, Swakopmund">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Receipt Number -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="receipt_number">Receipt Number</label>
                                        <input type="text" name="receipt_number" id="receipt_number" class="form-control" 
                                               value="{{ old('receipt_number') }}" placeholder="e.g., REC123456">
                                    </div>
                                </div>

                                <!-- Receipt/Invoice Upload -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="fuel_receipt">Upload Receipt/Invoice</label>
                                        <input type="file" name="fuel_receipt" id="fuel_receipt" class="form-control-file" 
                                               accept=".pdf,.jpg,.jpeg,.png,.gif">
                                        <small class="text-muted">Accepted formats: PDF, JPG, PNG, GIF (Max: 2MB)</small>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Notes -->
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="notes">Notes</label>
                                        <textarea name="notes" id="notes" class="form-control" rows="3" 
                                                  placeholder="Any additional notes...">{{ old('notes') }}</textarea>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                                    <i class="fas fa-save"></i> Create Trip
                                </button>
                                <a href="{{ route('fleet.trips') }}" class="btn btn-secondary" style="margin-left: 8px;">
                                    <i class="fas fa-times"></i> Cancel
                                </a>
                            </div>
                        </div>
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
    // Calculate total fuel cost when fuel consumed or price per liter changes
    function calculateFuelCost() {
        var fuelConsumed = parseFloat($('#fuel_consumed').val()) || 0;
        var pricePerLiter = parseFloat($('#price_per_liter').val()) || 0;
        
        if (fuelConsumed > 0 && pricePerLiter > 0) {
            var totalCost = (fuelConsumed * pricePerLiter).toFixed(2);
            $('#total_fuel_cost').val(totalCost);
        } else {
            $('#total_fuel_cost').val('');
        }
    }
    
    // Calculate distance when odometer values change
    function calculateDistance() {
        var startOdometer = parseFloat($('#odometer_start').val()) || 0;
        var endOdometer = parseFloat($('#odometer_end').val()) || 0;
        
        if (startOdometer > 0 && endOdometer > 0 && endOdometer >= startOdometer) {
            var distance = endOdometer - startOdometer;
            $('#distance_km').val(distance.toFixed(1));
        } else {
            $('#distance_km').val('');
        }
    }
    
    // Validate ending odometer
    function validateEndingOdometer() {
        var startOdometer = parseFloat($('#odometer_start').val()) || 0;
        var endOdometer = parseFloat($('#odometer_end').val()) || 0;
        
        if (endOdometer > 0 && endOdometer < startOdometer) {
            $('#odometer_end')[0].setCustomValidity('Ending odometer must be greater than or equal to starting odometer');
        } else {
            $('#odometer_end')[0].setCustomValidity('');
        }
    }
    
    // Show/hide fuel details based on fuel fill-up selection
    function toggleFuelDetails() {
        var fuelFilledUp = $('input[name="fuel_filled_up"]:checked').val();
        if (fuelFilledUp === 'yes') {
            $('#fuel_details_section').slideDown();
        } else {
            $('#fuel_details_section').slideUp();
            // Clear fuel fields when hiding
            $('#fuel_type').val('');
            $('#fuel_liters').val('');
            $('#price_per_liter').val('');
            $('#total_fuel_cost').val('');
            $('#fuel_station').val('');
            $('#fuel_town_city').val('');
            $('#receipt_number').val('');
            $('#fuel_receipt').val('');
        }
    }
    
    // Bind events for fuel fill-up toggle
    $('input[name="fuel_filled_up"]').on('change', toggleFuelDetails);
    
    // Calculate total fuel cost from liters and price per liter
    function calculateFuelCost() {
        var liters = parseFloat($('#fuel_liters').val()) || 0;
        var pricePerLiter = parseFloat($('#price_per_liter').val()) || 0;
        var totalCost = liters * pricePerLiter;
        
        if (liters > 0 && pricePerLiter > 0) {
            $('#total_fuel_cost').val(totalCost.toFixed(2));
        } else {
            $('#total_fuel_cost').val('');
        }
    }
    
    // Bind events for fuel cost calculation
    $('#fuel_liters, #price_per_liter').on('input change', calculateFuelCost);
    
    // Bind events for distance calculation and validation
    $('#odometer_start, #odometer_end').on('input change', function() {
        calculateDistance();
        validateEndingOdometer();
    });
    
    // Set minimum value for ending odometer when starting odometer changes
    $('#odometer_start').on('input change', function() {
        var startValue = $(this).val();
        if (startValue) {
            $('#odometer_end').attr('min', startValue);
        }
    });
    
    // Validate Expected Return Time is not less than Departure Time
    function validateReturnTime() {
        var departureTime = $('#departure_time').val();
        var expectedReturnTime = $('#expected_return_time').val();
        
        if (departureTime && expectedReturnTime) {
            var departure = new Date(departureTime);
            var expectedReturn = new Date(expectedReturnTime);
            
            if (expectedReturn < departure) {
                $('#expected_return_time')[0].setCustomValidity('Expected return time cannot be earlier than departure time');
                $('#expected_return_time').addClass('is-invalid');
                if (!$('#expected_return_time').next('.invalid-feedback').length) {
                    $('#expected_return_time').after('<div class="invalid-feedback">Expected return time cannot be earlier than departure time</div>');
                }
            } else {
                $('#expected_return_time')[0].setCustomValidity('');
                $('#expected_return_time').removeClass('is-invalid');
                $('#expected_return_time').next('.invalid-feedback').remove();
            }
        }
    }
    
    // Bind events for return time validation
    $('#departure_time, #expected_return_time').on('input change', validateReturnTime);
    
    // Initial setup on page load
    toggleFuelDetails(); // Show/hide fuel section based on current selection
    calculateFuelCost();
    calculateDistance();
    validateEndingOdometer();
});
</script>
@endsection
