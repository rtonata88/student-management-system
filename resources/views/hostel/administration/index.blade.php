@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Hostel Administration Dashboard</h4>
                </div>
                <div class="card-body">
                    <!-- Statistics Cards -->
                    <div class="row mb-4">
                        <div class="col-lg-3 col-md-6">
                            <div class="card bg-primary text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h3 class="mb-0">{{ $totalHostels }}</h3>
                                            <p class="mb-0">Total Hostels</p>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="fas fa-building fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-3 col-md-6">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h3 class="mb-0">{{ $totalRooms }}</h3>
                                            <p class="mb-0">Total Rooms</p>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="fas fa-door-open fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-3 col-md-6">
                            <div class="card bg-info text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h3 class="mb-0">{{ $totalBeds }}</h3>
                                            <p class="mb-0">Total Beds</p>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="fas fa-bed fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-3 col-md-6">
                            <div class="card bg-warning text-white">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h3 class="mb-0">{{ $occupancyRate }}%</h3>
                                            <p class="mb-0">Occupancy Rate</p>
                                        </div>
                                        <div class="align-self-center">
                                            <i class="fas fa-chart-pie fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h5>Quick Actions</h5>
                            <div class="btn-group-vertical btn-group-lg d-block d-md-none" role="group">
                                <a href="{{ route('hostel.administration.hostels') }}" class="btn btn-outline-primary mb-2">
                                    <i class="fas fa-building"></i> Manage Hostels
                                </a>
                                <a href="{{ route('hostel.administration.blocks') }}" class="btn btn-outline-success mb-2">
                                    <i class="fas fa-th-large"></i> Manage Blocks
                                </a>
                                <a href="{{ route('hostel.administration.rooms') }}" class="btn btn-outline-info mb-2">
                                    <i class="fas fa-door-open"></i> Manage Rooms
                                </a>
                                <a href="{{ route('hostel.administration.allocations') }}" class="btn btn-outline-warning mb-2">
                                    <i class="fas fa-users"></i> Student Allocations
                                </a>
                                <a href="{{ route('hostel.administration.payments') }}" class="btn btn-outline-secondary mb-2">
                                    <i class="fas fa-money-bill"></i> Payments
                                </a>
                                <a href="{{ route('hostel.administration.reports') }}" class="btn btn-outline-dark">
                                    <i class="fas fa-chart-bar"></i> Reports
                                </a>
                            </div>
                            
                            <div class="btn-group d-none d-md-flex" role="group">
                                <a href="{{ route('hostel.administration.hostels') }}" class="btn btn-outline-primary">
                                    <i class="fas fa-building"></i> Manage Hostels
                                </a>
                                <a href="{{ route('hostel.administration.blocks') }}" class="btn btn-outline-success">
                                    <i class="fas fa-th-large"></i> Manage Blocks
                                </a>
                                <a href="{{ route('hostel.administration.rooms') }}" class="btn btn-outline-info">
                                    <i class="fas fa-door-open"></i> Manage Rooms
                                </a>
                                <a href="{{ route('hostel.administration.allocations') }}" class="btn btn-outline-warning">
                                    <i class="fas fa-users"></i> Student Allocations
                                </a>
                                <a href="{{ route('hostel.administration.payments') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-money-bill"></i> Payments
                                </a>
                                <a href="{{ route('hostel.administration.reports') }}" class="btn btn-outline-dark">
                                    <i class="fas fa-chart-bar"></i> Reports
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Hostel Overview -->
                    <div class="row">
                        <div class="col-12">
                            <h5>Hostel Overview</h5>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Hostel Name</th>
                                            <th>Code</th>
                                            <th>Gender</th>
                                            <th>Total Capacity</th>
                                            <th>Occupied Beds</th>
                                            <th>Available Beds</th>
                                            <th>Occupancy Rate</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($hostels as $hostel)
                                        <tr>
                                            <td>{{ $hostel->name }}</td>
                                            <td>{{ $hostel->code }}</td>
                                            <td>
                                                <span class="badge badge-{{ $hostel->gender == 'male' ? 'primary' : ($hostel->gender == 'female' ? 'danger' : 'info') }}">
                                                    {{ ucfirst($hostel->gender) }}
                                                </span>
                                            </td>
                                            <td>{{ $hostel->beds->count() }}</td>
                                            <td>{{ $hostel->getOccupiedBedsCount() }}</td>
                                            <td>{{ $hostel->getAvailableBedsCount() }}</td>
                                            <td>
                                                <div class="progress" style="height: 20px;">
                                                    <div class="progress-bar" role="progressbar" style="width: {{ $hostel->getOccupancyRate() }}%">
                                                        {{ $hostel->getOccupancyRate() }}%
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge badge-{{ $hostel->is_active ? 'success' : 'secondary' }}">
                                                    {{ $hostel->is_active ? 'Active' : 'Inactive' }}
                                                </span>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="8" class="text-center">No hostels found. <a href="{{ route('hostel.administration.hostels.create') }}">Create your first hostel</a></td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
