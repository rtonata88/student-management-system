@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-user-cog"></i> Vehicle Assignment Details
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('fleet.assignments') }}" class="btn btn-sm" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                            <i class="fas fa-arrow-left"></i> Back to Assignments
                        </a>
                        @permission('fleet-assignments-edit')
                        <a href="{{ route('fleet.assignments.edit', $assignment->id) }}" class="btn btn-sm ml-1" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                            <i class="fas fa-edit"></i> Edit Assignment
                        </a>
                        @endpermission
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title"><i class="fas fa-car"></i> Vehicle Information</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td><strong>Registration Number:</strong></td>
                                            <td>{{ $assignment->vehicle->registration_number }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Make & Model:</strong></td>
                                            <td>{{ $assignment->vehicle->make }} {{ $assignment->vehicle->model }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Year:</strong></td>
                                            <td>{{ $assignment->vehicle->year }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Fuel Type:</strong></td>
                                            <td>{{ ucfirst($assignment->vehicle->fuel_type) }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Status:</strong></td>
                                            <td>
                                                <span class="badge badge-{{ $assignment->vehicle->status === 'active' ? 'success' : 'secondary' }}">
                                                    {{ ucfirst($assignment->vehicle->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title"><i class="fas fa-user"></i> Driver Information</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td><strong>Name:</strong></td>
                                            <td>{{ $assignment->driver->first_name }} {{ $assignment->driver->last_name }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Employee Number:</strong></td>
                                            <td>{{ $assignment->driver->employee_number }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>License Number:</strong></td>
                                            <td>{{ $assignment->driver->license_number }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>License Class:</strong></td>
                                            <td>{{ $assignment->driver->license_class }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Phone:</strong></td>
                                            <td>{{ $assignment->driver->phone }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Status:</strong></td>
                                            <td>
                                                <span class="badge badge-{{ $assignment->driver->status === 'active' ? 'success' : 'secondary' }}">
                                                    {{ ucfirst($assignment->driver->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title"><i class="fas fa-clipboard-list"></i> Assignment Details</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <table class="table table-borderless">
                                                <tr>
                                                    <td><strong>Assignment Type:</strong></td>
                                                    <td>
                                                        <span class="badge badge-{{ $assignment->assignment_type === 'primary' ? 'primary' : 'secondary' }}">
                                                            {{ ucfirst($assignment->assignment_type) }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Start Date:</strong></td>
                                                    <td>
                                                        @if($assignment->start_date)
                                                            {{ $assignment->start_date->format('M d, Y') }}
                                                        @else
                                                            <span class="text-muted">Not set</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>End Date:</strong></td>
                                                    <td>
                                                        @if($assignment->end_date)
                                                            {{ $assignment->end_date->format('M d, Y') }}
                                                        @else
                                                            <span class="badge badge-success">Ongoing</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Status:</strong></td>
                                                    <td>
                                                        <span class="badge badge-{{ $assignment->isActive() ? 'success' : 'secondary' }}">
                                                            {{ $assignment->isActive() ? 'Active' : 'Inactive' }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-md-6">
                                            <table class="table table-borderless">
                                                <tr>
                                                    <td><strong>Created:</strong></td>
                                                    <td>{{ $assignment->created_at->format('M d, Y H:i') }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Last Updated:</strong></td>
                                                    <td>{{ $assignment->updated_at->format('M d, Y H:i') }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Notes:</strong></td>
                                                    <td>
                                                        @if($assignment->notes)
                                                            {{ $assignment->notes }}
                                                        @else
                                                            <span class="text-muted">No notes</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
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
