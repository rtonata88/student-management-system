@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-route"></i> Trip Details
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('fleet.trips') }}" class="btn btn-sm" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                            <i class="fas fa-arrow-left"></i> Back to Trips
                        </a>
                        @permission('fleet-trips-edit')
                        <a href="{{ route('fleet.trips.edit', $trip) }}" class="btn btn-sm" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem; margin-left: 8px;">
                            <i class="fas fa-edit"></i> Edit Trip
                        </a>
                        @endpermission
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Trip Information -->
                        <div class="col-md-6">
                            <h5 class="mb-3"><i class="fas fa-info-circle"></i> Trip Information</h5>
                            
                            <div class="form-group">
                                <label><strong>Trip Purpose:</strong></label>
                                <p>{{ ucfirst(str_replace('_', ' ', $trip->trip_purpose)) }}</p>
                            </div>

                            <div class="form-group">
                                <label><strong>Destination:</strong></label>
                                <p>{{ $trip->destination }}</p>
                            </div>

                            @if($trip->origin)
                            <div class="form-group">
                                <label><strong>Origin:</strong></label>
                                <p>{{ $trip->origin }}</p>
                            </div>
                            @endif

                            @if($trip->route_taken)
                            <div class="form-group">
                                <label><strong>Route Taken:</strong></label>
                                <p>{{ $trip->route_taken }}</p>
                            </div>
                            @endif

                            <div class="form-group">
                                <label><strong>Status:</strong></label>
                                <p>
                                    @if($trip->arrival_time)
                                        <span class="badge badge-success">Completed</span>
                                    @else
                                        <span class="badge badge-warning">In Progress</span>
                                    @endif
                                </p>
                            </div>

                            @if($trip->passenger_count)
                            <div class="form-group">
                                <label><strong>Passenger Count:</strong></label>
                                <p>{{ $trip->passenger_count }} passengers</p>
                            </div>
                            @endif
                        </div>

                        <!-- Vehicle & Driver Information -->
                        <div class="col-md-6">
                            <h5 class="mb-3"><i class="fas fa-car"></i> Vehicle & Driver</h5>

                            <div class="form-group">
                                <label><strong>Vehicle:</strong></label>
                                <p>
                                    {{ $trip->vehicle->make }} {{ $trip->vehicle->model }}<br>
                                    <small class="text-muted">{{ $trip->vehicle->registration_number }}</small>
                                </p>
                            </div>

                            <div class="form-group">
                                <label><strong>Driver:</strong></label>
                                <p>
                                    {{ $trip->driver->full_name }}<br>
                                    <small class="text-muted">{{ $trip->driver->employee_number }}</small>
                                </p>
                            </div>

                            @if($trip->odometer_start)
                            <div class="form-group">
                                <label><strong>Starting Odometer:</strong></label>
                                <p>{{ number_format($trip->odometer_start) }} km</p>
                            </div>
                            @endif

                            @if($trip->odometer_end)
                            <div class="form-group">
                                <label><strong>Ending Odometer:</strong></label>
                                <p>{{ number_format($trip->odometer_end) }} km</p>
                            </div>
                            @endif

                            @if($trip->distance_km)
                            <div class="form-group">
                                <label><strong>Distance Traveled:</strong></label>
                                <p>{{ number_format($trip->distance_km, 1) }} km</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Time Information -->
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <h5 class="mb-3"><i class="fas fa-clock"></i> Time Information</h5>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label><strong>Departure Time:</strong></label>
                                <p>
                                    @if($trip->departure_time)
                                        {{ \Carbon\Carbon::parse($trip->departure_time)->format('M d, Y') }}<br>
                                        <small class="text-muted">{{ \Carbon\Carbon::parse($trip->departure_time)->format('H:i') }}</small>
                                    @else
                                        <span class="text-muted">Not set</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label><strong>Expected Return:</strong></label>
                                <p>
                                    @if($trip->expected_return_time)
                                        {{ \Carbon\Carbon::parse($trip->expected_return_time)->format('M d, Y') }}<br>
                                        <small class="text-muted">{{ \Carbon\Carbon::parse($trip->expected_return_time)->format('H:i') }}</small>
                                    @else
                                        <span class="text-muted">Not set</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label><strong>Actual Arrival:</strong></label>
                                <p>
                                    @if($trip->arrival_time)
                                        {{ \Carbon\Carbon::parse($trip->arrival_time)->format('M d, Y') }}<br>
                                        <small class="text-muted">{{ \Carbon\Carbon::parse($trip->arrival_time)->format('H:i') }}</small>
                                    @else
                                        <span class="text-muted">Not completed</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label><strong>Duration:</strong></label>
                                <p>
                                    @if($trip->arrival_time && $trip->departure_time)
                                        @php
                                            $departure = \Carbon\Carbon::parse($trip->departure_time);
                                            $arrival = \Carbon\Carbon::parse($trip->arrival_time);
                                            $duration = $departure->diffInMinutes($arrival);
                                        @endphp
                                        {{ floor($duration / 60) }}h {{ $duration % 60 }}m
                                    @else
                                        <span class="text-muted">In progress</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Fuel Information -->
                    @if($trip->fuel_filled_up == 'yes')
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <h5 class="mb-3"><i class="fas fa-gas-pump"></i> Fuel Information</h5>
                        </div>
                        @if($trip->fuel_type)
                        <div class="col-md-3">
                            <div class="form-group">
                                <label><strong>Fuel Type:</strong></label>
                                <p>{{ ucfirst($trip->fuel_type) }}</p>
                            </div>
                        </div>
                        @endif
                        @if($trip->fuel_liters)
                        <div class="col-md-3">
                            <div class="form-group">
                                <label><strong>Fuel Liters:</strong></label>
                                <p>{{ number_format($trip->fuel_liters, 1) }} L</p>
                            </div>
                        </div>
                        @endif
                        @if($trip->price_per_liter)
                        <div class="col-md-3">
                            <div class="form-group">
                                <label><strong>Price per Liter:</strong></label>
                                <p>${{ number_format($trip->price_per_liter, 3) }}</p>
                            </div>
                        </div>
                        @endif
                        @if($trip->total_fuel_cost)
                        <div class="col-md-3">
                            <div class="form-group">
                                <label><strong>Total Fuel Cost:</strong></label>
                                <p>${{ number_format($trip->total_fuel_cost, 2) }}</p>
                            </div>
                        </div>
                        @endif
                        @if($trip->fuel_station)
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><strong>Fuel Station:</strong></label>
                                <p>{{ $trip->fuel_station }}</p>
                            </div>
                        </div>
                        @endif
                        @if($trip->fuel_town_city)
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><strong>Town/City:</strong></label>
                                <p>{{ $trip->fuel_town_city }}</p>
                            </div>
                        </div>
                        @endif
                        @if($trip->receipt_number)
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><strong>Receipt Number:</strong></label>
                                <p>{{ $trip->receipt_number }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                    @endif

                    <!-- Notes -->
                    @if($trip->notes)
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <h5 class="mb-3"><i class="fas fa-sticky-note"></i> Trip Notes</h5>
                            <div class="alert alert-light">
                                {{ $trip->notes }}
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Trip Statistics -->
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <h5 class="mb-3"><i class="fas fa-chart-bar"></i> Trip Statistics</h5>
                        </div>
                        <div class="col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-info"><i class="fas fa-road"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Distance</span>
                                    <span class="info-box-number">{{ $trip->distance_km ? number_format($trip->distance_km, 1) . ' km' : 'N/A' }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-success"><i class="fas fa-gas-pump"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Fuel Used</span>
                                    <span class="info-box-number">{{ $trip->fuel_liters ? number_format($trip->fuel_liters, 1) . 'L' : 'N/A' }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-warning"><i class="fas fa-users"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Passengers</span>
                                    <span class="info-box-number">{{ $trip->passenger_count ?? 'N/A' }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-danger"><i class="fas fa-clock"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Status</span>
                                    <span class="info-box-number">{{ $trip->arrival_time ? 'Complete' : 'Active' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
