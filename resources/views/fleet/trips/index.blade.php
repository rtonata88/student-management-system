@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12 col-xs-12">
        <!-- Dashboard Statistics -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 col-sm-6 mb-3">
                <div class="stats-card stats-card-purple">
                    <div class="stats-card-body">
                        <div class="stats-number">{{ $stats['total_trips'] ?? 0 }}</div>
                        <div class="stats-label">Total Trips</div>
                        <div class="stats-icon">
                            <i class="fas fa-route"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 col-sm-6 mb-3">
                <div class="stats-card stats-card-green">
                    <div class="stats-card-body">
                        <div class="stats-number">{{ number_format($stats['total_distance'] ?? 0, 1) }}km</div>
                        <div class="stats-label">Total Distance</div>
                        <div class="stats-icon">
                            <i class="fas fa-road"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 col-sm-6 mb-3">
                <div class="stats-card stats-card-blue">
                    <div class="stats-card-body">
                        <div class="stats-number">{{ number_format($stats['fuel_consumed'] ?? 0, 1) }}L</div>
                        <div class="stats-label">Fuel Consumed</div>
                        <div class="stats-icon">
                            <i class="fas fa-gas-pump"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 col-sm-6 mb-3">
                <div class="stats-card stats-card-orange">
                    <div class="stats-card-body">
                        <div class="stats-number">{{ $stats['active_trips'] ?? 0 }}</div>
                        <div class="stats-label">Active Trips</div>
                        <div class="stats-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0">Fleet Trip Management</h5>
                    <small class="text-muted">Monitor and manage vehicle trips, routes, and driver activities</small>
                </div>
                <div class="btn-toolbar" role="toolbar">
                    @permission('fleet-trips-create')
                    <div class="btn-group mr-2" role="group">
                        <a href="{{ route('fleet.trips.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus mr-2"></i>
                            Log New Trip
                        </a>
                    </div>
                    @endpermission
                </div>
            </div>
            <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            {{ session('success') }}
                        </div>
                    @endif

                <!-- Search and Filter Form -->
                <form method="GET" action="{{ route('fleet.trips') }}" class="mb-4">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <div class="input-group">
                                <input type="text" class="form-control" name="search" 
                                       placeholder="Search trips..." 
                                       value="{{ request('search') }}">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-primary" type="submit">
                                        <i class="fas fa-search"></i>
                                        <small class="d-block">Search</small>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 mb-3">
                            <select name="status" class="form-control">
                                <option value="">All Status</option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                            </select>
                        </div>
                        <div class="col-md-2 mb-3">
                            <select name="vehicle" class="form-control">
                                <option value="">All Vehicles</option>
                                @if(isset($vehicles))
                                    @foreach($vehicles as $vehicle)
                                    <option value="{{ $vehicle->id }}" {{ request('vehicle') == $vehicle->id ? 'selected' : '' }}>
                                        {{ $vehicle->registration_number }}
                                    </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-md-2 mb-3">
                            <select name="driver" class="form-control">
                                <option value="">All Drivers</option>
                                @if(isset($drivers))
                                    @foreach($drivers as $driver)
                                    <option value="{{ $driver->id }}" {{ request('driver') == $driver->id ? 'selected' : '' }}>
                                        {{ $driver->name }}
                                    </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">Filter</button>
                                <a href="{{ route('fleet.trips') }}" class="btn btn-outline-secondary">Clear</a>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Results Summary -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <small class="text-muted">
                            Showing {{ $trips->firstItem() ?? 0 }} to {{ $trips->lastItem() ?? 0 }} 
                            of {{ $trips->total() }} trips
                        </small>
                    </div>
                </div>

                    <div class="table-responsive">
                        <table class="table table-hover table-sm">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Vehicle</th>
                                    <th>Driver</th>
                                    <th>Route</th>
                                    <th>Distance</th>
                                    <th>Fuel Used</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($trips as $trip)
                                <tr>
                                    <td>
                                        @if($trip->trip_date)
                                            <strong>{{ $trip->trip_date->format('M d, Y') }}</strong>
                                            <br><small class="text-muted">{{ $trip->trip_date->format('H:i') }}</small>
                                        @else
                                            <span class="text-muted">No date set</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div>
                                            <strong>{{ $trip->vehicle->registration_number }}</strong>
                                            <br><small class="text-muted">{{ $trip->vehicle->make }} {{ $trip->vehicle->model }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <strong>{{ $trip->driver->name }}</strong>
                                            <br><small class="text-muted">{{ $trip->driver->license_number }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <strong>{{ $trip->origin }}</strong> → <strong>{{ $trip->destination }}</strong>
                                            @if($trip->purpose)
                                            <br><small class="text-muted">{{ \Illuminate\Support\Str::limit($trip->purpose, 30) }}</small>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            @if($trip->distance_km)
                                                <strong>{{ number_format($trip->distance_km, 1) }} km</strong>
                                            @else
                                                <span class="text-muted">Not recorded</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            @if($trip->fuel_consumed)
                                                <strong>{{ number_format($trip->fuel_consumed, 2) }} L</strong>
                                            @else
                                                <span class="text-muted">Not recorded</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        @if($trip->arrival_time)
                                            <span class="badge badge-success">Completed</span>
                                        @else
                                            <span class="badge badge-warning">In Progress</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex" style="gap: 0.5rem;">
                                            @permission('fleet-trips-view')
                                            <a href="{{ route('fleet.trips.show', $trip) }}" class="btn btn-sm" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;" title="View">
                                                <i class="fas fa-eye"></i> View
                                            </a>
                                            @endpermission
                                            @permission('fleet-trips-edit')
                                            <a href="{{ route('fleet.trips.edit', $trip) }}" class="btn btn-sm" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;" title="Edit">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            @endpermission
                                            @permission('fleet-trips-delete')
                                            <form action="{{ route('fleet.trips.destroy', $trip->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;" title="Delete" onclick="return confirm('Are you sure you want to delete this trip log?')">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            </form>
                                            @endpermission
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4">
                                        <div class="empty-state">
                                            <i class="fas fa-route fa-4x text-muted mb-3"></i>
                                            <h5 class="text-muted">No Trip Logs Found</h5>
                                            <p class="text-muted">
                                                @if(request()->hasAny(['search', 'status', 'vehicle', 'driver']))
                                                    No trips match your search criteria. Try adjusting your filters.
                                                @else
                                                    Start tracking your fleet trips by logging your first trip.
                                                @endif
                                            </p>
                                            @if(request()->hasAny(['search', 'status', 'vehicle', 'driver']))
                                            <a href="{{ route('fleet.trips') }}" class="btn btn-outline-primary">
                                                Clear Filters
                                            </a>
                                            @else
                                            @permission('fleet-trips-create')
                                            <a href="{{ route('fleet.trips.create') }}" class="btn btn-primary">
                                                Log First Trip
                                            </a>
                                            @endpermission
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                <!-- Pagination -->
                @if($trips->hasPages())
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div>
                        <small class="text-muted">
                            Page {{ $trips->currentPage() }} of {{ $trips->lastPage() }}
                        </small>
                    </div>
                    <div>
                        {{ $trips->appends(request()->query())->links() }}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection

<style>
:root {
    --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --primary-color: #667eea;
    --success-gradient: linear-gradient(135deg, #56ab2f 0%, #a8e6cf 100%);
    --warning-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    --danger-gradient: linear-gradient(135deg, #ff416c 0%, #ff4b2b 100%);
    --info-gradient: linear-gradient(135deg, #36d1dc 0%, #5b86e5 100%);
}

/* Card styling */
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

/* Button styling */
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

.btn-outline-primary {
    border: 2px solid var(--primary-color) !important;
    color: var(--primary-color) !important;
    background: transparent !important;
}

.btn-outline-primary:hover {
    background: var(--primary-gradient) !important;
    border-color: transparent !important;
    color: white !important;
}

/* Modern Stats Cards */
.stats-card {
    border-radius: 16px;
    border: none;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    overflow: hidden;
    transition: all 0.3s ease;
    position: relative;
    height: 120px;
}

.stats-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
}

.stats-card-body {
    padding: 24px;
    position: relative;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.stats-number {
    font-size: 2.5rem;
    font-weight: 700;
    color: white;
    margin-bottom: 4px;
    line-height: 1;
}

.stats-label {
    font-size: 0.875rem;
    color: rgba(255, 255, 255, 0.9);
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.stats-icon {
    position: absolute;
    top: 20px;
    right: 20px;
    font-size: 1.5rem;
    color: rgba(255, 255, 255, 0.3);
}

/* Card Color Variants */
.stats-card-purple {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.stats-card-green {
    background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
}

.stats-card-blue {
    background: linear-gradient(135deg, #2196F3 0%, #1976D2 100%);
}

.stats-card-orange {
    background: linear-gradient(135deg, #ff9800 0%, #f57c00 100%);
}

/* Table styling */
.table-hover tbody tr:hover {
    background-color: rgba(102, 126, 234, 0.05);
}

/* Badge styling */
.badge-success {
    background: var(--success-gradient) !important;
}

.badge-warning {
    background: var(--warning-gradient) !important;
}

.badge-danger {
    background: var(--danger-gradient) !important;
}

/* Gap utility */
.gap-2 {
    gap: 0.5rem;
}

/* Empty state */
.empty-state {
    padding: 2rem;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .btn-group {
        flex-direction: column;
    }
    
    .btn-group .btn {
        margin-bottom: 0.25rem;
    }
}
</style>

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
