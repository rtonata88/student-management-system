@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-route"></i> Trip Logs
                    </h3>
                    @permission('fleet-trips-create')
                    <div class="card-tools">
                        <a href="{{ route('fleet.trips.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Log New Trip
                        </a>
                    </div>
                    @endpermission
                </div>
                <div class="card-body">
                    <!-- Filters -->
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <select class="form-control" id="vehicle-filter">
                                <option value="">All Vehicles</option>
                                @foreach($vehicles as $vehicle)
                                    <option value="{{ $vehicle->id }}">{{ $vehicle->registration_number }} - {{ $vehicle->make }} {{ $vehicle->model }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-control" id="driver-filter">
                                <option value="">All Drivers</option>
                                @foreach($drivers as $driver)
                                    <option value="{{ $driver->id }}">{{ $driver->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <input type="date" class="form-control" id="date-from" placeholder="From Date">
                        </div>
                        <div class="col-md-2">
                            <input type="date" class="form-control" id="date-to" placeholder="To Date">
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-secondary btn-block" id="filter-btn">
                                <i class="fas fa-filter"></i> Filter
                            </button>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Vehicle</th>
                                    <th>Driver</th>
                                    <th>Route</th>
                                    <th>Distance</th>
                                    <th>Duration</th>
                                    <th>Fuel Used</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($trips as $trip)
                                <tr>
                                    <td>
                                        <strong>{{ $trip->departure_date->format('M d, Y') }}</strong><br>
                                        <small class="text-muted">{{ $trip->departure_time->format('H:i') }}</small>
                                    </td>
                                    <td>
                                        <strong>{{ $trip->vehicle->registration_number }}</strong><br>
                                        <small class="text-muted">{{ $trip->vehicle->make }} {{ $trip->vehicle->model }}</small>
                                    </td>
                                    <td>
                                        <strong>{{ $trip->driver->name }}</strong><br>
                                        <small class="text-muted">{{ $trip->driver->employee_id }}</small>
                                    </td>
                                    <td>
                                        <strong>{{ $trip->origin }}</strong><br>
                                        <i class="fas fa-arrow-down text-muted"></i><br>
                                        <strong>{{ $trip->destination }}</strong>
                                    </td>
                                    <td>
                                        @if($trip->distance_km)
                                            <span class="badge badge-info">{{ number_format($trip->distance_km, 1) }} km</span>
                                        @else
                                            <span class="badge badge-secondary">Not Set</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($trip->arrival_date && $trip->arrival_time)
                                            @php
                                                $departure = \Carbon\Carbon::parse($trip->departure_date->format('Y-m-d') . ' ' . $trip->departure_time->format('H:i:s'));
                                                $arrival = \Carbon\Carbon::parse($trip->arrival_date->format('Y-m-d') . ' ' . $trip->arrival_time->format('H:i:s'));
                                                $duration = $departure->diffInMinutes($arrival);
                                            @endphp
                                            <span class="badge badge-success">
                                                {{ floor($duration / 60) }}h {{ $duration % 60 }}m
                                            </span>
                                        @else
                                            <span class="badge badge-warning">In Progress</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($trip->fuel_consumed)
                                            <span class="badge badge-primary">{{ number_format($trip->fuel_consumed, 1) }}L</span>
                                        @else
                                            <span class="badge badge-secondary">Not Set</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($trip->arrival_date && $trip->arrival_time)
                                            <span class="badge badge-success">Completed</span>
                                        @else
                                            <span class="badge badge-warning">In Progress</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            @permission('fleet-trips-view')
                                            <a href="{{ route('fleet.trips.show', $trip->id) }}" class="btn btn-info btn-sm" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @endpermission
                                            @permission('fleet-trips-edit')
                                            <a href="{{ route('fleet.trips.edit', $trip->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            @endpermission
                                            @permission('fleet-trips-delete')
                                            <form action="{{ route('fleet.trips.destroy', $trip->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this trip log?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                            @endpermission
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center">
                                        <div class="py-4">
                                            <i class="fas fa-route fa-3x text-muted mb-3"></i>
                                            <h5 class="text-muted">No trip logs found</h5>
                                            @permission('fleet-trips-create')
                                            <a href="{{ route('fleet.trips.create') }}" class="btn btn-primary">
                                                <i class="fas fa-plus"></i> Log First Trip
                                            </a>
                                            @endpermission
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($trips->hasPages())
                    <div class="d-flex justify-content-center">
                        {{ $trips->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Summary Cards -->
<div class="row mt-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>{{ $totalTrips }}</h4>
                        <p class="mb-0">Total Trips</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-route fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>{{ number_format($totalDistance, 1) }} km</h4>
                        <p class="mb-0">Total Distance</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-road fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>{{ number_format($totalFuelConsumed, 1) }}L</h4>
                        <p class="mb-0">Fuel Consumed</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-gas-pump fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>{{ $activeTrips }}</h4>
                        <p class="mb-0">Active Trips</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-clock fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    $('#filter-btn').click(function() {
        var vehicle = $('#vehicle-filter').val();
        var driver = $('#driver-filter').val();
        var dateFrom = $('#date-from').val();
        var dateTo = $('#date-to').val();
        
        var url = new URL(window.location.href);
        
        if (vehicle) url.searchParams.set('vehicle', vehicle);
        else url.searchParams.delete('vehicle');
        
        if (driver) url.searchParams.set('driver', driver);
        else url.searchParams.delete('driver');
        
        if (dateFrom) url.searchParams.set('date_from', dateFrom);
        else url.searchParams.delete('date_from');
        
        if (dateTo) url.searchParams.set('date_to', dateTo);
        else url.searchParams.delete('date_to');
        
        window.location.href = url.toString();
    });
    
    // Set current filter values from URL
    var urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('vehicle')) $('#vehicle-filter').val(urlParams.get('vehicle'));
    if (urlParams.get('driver')) $('#driver-filter').val(urlParams.get('driver'));
    if (urlParams.get('date_from')) $('#date-from').val(urlParams.get('date_from'));
    if (urlParams.get('date_to')) $('#date-to').val(urlParams.get('date_to'));
});
</script>
@endsection
