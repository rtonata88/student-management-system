@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-user"></i> Driver Details - {{ $driver->full_name }}
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('fleet.drivers') }}" class="btn btn-sm" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                            <i class="fas fa-arrow-left"></i> Back to Drivers
                        </a>
                        @permission('fleet-drivers-edit')
                        <a href="{{ route('fleet.drivers.edit', $driver) }}" class="btn btn-sm" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                            <i class="fas fa-edit"></i> Edit Driver
                        </a>
                        @endpermission
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Personal Information -->
                        <div class="col-md-6">
                            <h5 class="mb-3"><i class="fas fa-user"></i> Personal Information</h5>
                            
                            <div class="form-group">
                                <label><strong>Full Name:</strong></label>
                                <p>{{ $driver->full_name }}</p>
                            </div>

                            <div class="form-group">
                                <label><strong>Employee Number:</strong></label>
                                <p>{{ $driver->employee_number }}</p>
                            </div>

                            <div class="form-group">
                                <label><strong>Phone Number:</strong></label>
                                <p>{{ $driver->phone }}</p>
                            </div>

                            <div class="form-group">
                                <label><strong>Email Address:</strong></label>
                                <p>{{ $driver->email ?: 'Not provided' }}</p>
                            </div>

                            <div class="form-group">
                                <label><strong>Address:</strong></label>
                                <p>{{ $driver->address ?: 'Not provided' }}</p>
                            </div>

                            <div class="form-group">
                                <label><strong>Date of Birth:</strong></label>
                                <p>{{ $driver->date_of_birth ? $driver->date_of_birth->format('M d, Y') : 'Not provided' }}</p>
                            </div>

                            @if($driver->age)
                            <div class="form-group">
                                <label><strong>Age:</strong></label>
                                <p>{{ $driver->age }} years old</p>
                            </div>
                            @endif
                        </div>

                        <!-- License & Employment Information -->
                        <div class="col-md-6">
                            <h5 class="mb-3"><i class="fas fa-id-card"></i> License & Employment</h5>

                            <div class="form-group">
                                <label><strong>License Number:</strong></label>
                                <p>{{ $driver->license_number }}</p>
                            </div>

                            <div class="form-group">
                                <label><strong>License Class:</strong></label>
                                <p>Class {{ $driver->license_class }}</p>
                            </div>

                            <div class="form-group">
                                <label><strong>License Expiry Date:</strong></label>
                                <p>
                                    {{ $driver->license_expiry->format('M d, Y') }}
                                    @if($driver->license_expiring_soon)
                                        <span class="badge badge-warning ml-2">Expiring Soon</span>
                                    @endif
                                </p>
                            </div>

                            <div class="form-group">
                                <label><strong>Hire Date:</strong></label>
                                <p>{{ $driver->hire_date->format('M d, Y') }}</p>
                            </div>

                            <div class="form-group">
                                <label><strong>Years of Service:</strong></label>
                                <p>{{ $driver->years_of_service }} years</p>
                            </div>

                            <div class="form-group">
                                <label><strong>Status:</strong></label>
                                <p>
                                    @if($driver->status == 'active')
                                        <span class="badge badge-success">Active</span>
                                    @elseif($driver->status == 'inactive')
                                        <span class="badge badge-secondary">Inactive</span>
                                    @else
                                        <span class="badge badge-warning">Suspended</span>
                                    @endif
                                </p>
                            </div>

                            @if($driver->photo)
                            <div class="form-group">
                                <label><strong>Profile Photo:</strong></label>
                                <br>
                                <img src="{{ asset('storage/' . $driver->photo) }}" alt="Driver Photo" class="img-thumbnail" style="max-width: 150px;">
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Current Vehicle Assignment -->
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <h5 class="mb-3"><i class="fas fa-car"></i> Current Vehicle Assignment</h5>
                            @if($driver->currentVehicle && $driver->currentVehicle->vehicle)
                                <div class="alert alert-info">
                                    <strong>Assigned Vehicle:</strong> 
                                    {{ $driver->currentVehicle->vehicle->make }} {{ $driver->currentVehicle->vehicle->model }} 
                                    ({{ $driver->currentVehicle->vehicle->registration_number }})
                                    <br>
                                    <strong>Assigned Date:</strong> {{ $driver->currentVehicle->assigned_date->format('M d, Y') }}
                                </div>
                            @else
                                <div class="alert alert-warning">
                                    <i class="fas fa-exclamation-triangle"></i> No vehicle currently assigned to this driver.
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Emergency Contact -->
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <h5 class="mb-3"><i class="fas fa-phone"></i> Emergency Contact</h5>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><strong>Emergency Contact Name:</strong></label>
                                <p>{{ $driver->emergency_contact_name ?: 'Not provided' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><strong>Emergency Contact Phone:</strong></label>
                                <p>{{ $driver->emergency_contact_phone ?: 'Not provided' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Driver Statistics -->
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <h5 class="mb-3"><i class="fas fa-chart-bar"></i> Driver Statistics</h5>
                        </div>
                        <div class="col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-info"><i class="fas fa-route"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Total Trips</span>
                                    <span class="info-box-number">{{ $driver->total_trips }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-success"><i class="fas fa-road"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Total Distance</span>
                                    <span class="info-box-number">{{ number_format($driver->total_distance) }} km</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-warning"><i class="fas fa-calendar"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Years of Service</span>
                                    <span class="info-box-number">{{ $driver->years_of_service }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-danger"><i class="fas fa-car"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Vehicle Assignments</span>
                                    <span class="info-box-number">{{ $driver->assignments->count() }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Notes -->
                    @if($driver->notes)
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <h5 class="mb-3"><i class="fas fa-sticky-note"></i> Notes</h5>
                            <div class="alert alert-light">
                                {{ $driver->notes }}
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
