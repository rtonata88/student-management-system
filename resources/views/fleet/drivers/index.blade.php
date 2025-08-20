@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-users"></i> Fleet Drivers
                    </h3>
                    @permission('fleet-drivers-create')
                    <div class="card-tools">
                        <a href="{{ route('fleet.drivers.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Add Driver
                        </a>
                    </div>
                    @endpermission
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Photo</th>
                                    <th>Name</th>
                                    <th>License Number</th>
                                    <th>Phone</th>
                                    <th>License Expiry</th>
                                    <th>Status</th>
                                    <th>Current Vehicle</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($drivers as $driver)
                                <tr>
                                    <td>
                                        @if($driver->photo)
                                            <img src="{{ asset('storage/' . $driver->photo) }}" alt="{{ $driver->name }}" class="img-circle" width="40" height="40">
                                        @else
                                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                {{ strtoupper(substr($driver->name, 0, 1)) }}
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <strong>{{ $driver->name }}</strong><br>
                                        <small class="text-muted">{{ $driver->employee_id }}</small>
                                    </td>
                                    <td>{{ $driver->license_number }}</td>
                                    <td>{{ $driver->phone }}</td>
                                    <td>
                                        @if($driver->license_expiry_date)
                                            @php
                                                $expiryDate = \Carbon\Carbon::parse($driver->license_expiry_date);
                                                $daysUntilExpiry = $expiryDate->diffInDays(now(), false);
                                            @endphp
                                            <span class="badge badge-{{ $daysUntilExpiry > 30 ? 'success' : ($daysUntilExpiry > 0 ? 'warning' : 'danger') }}">
                                                {{ $driver->license_expiry_date->format('M d, Y') }}
                                            </span>
                                        @else
                                            <span class="badge badge-secondary">Not Set</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $driver->status === 'active' ? 'success' : 'secondary' }}">
                                            {{ ucfirst($driver->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($driver->currentAssignment && $driver->currentAssignment->vehicle)
                                            <span class="badge badge-info">
                                                {{ $driver->currentAssignment->vehicle->registration_number }}
                                            </span>
                                        @else
                                            <span class="badge badge-secondary">Unassigned</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            @permission('fleet-drivers-view')
                                            <a href="{{ route('fleet.drivers.show', $driver->id) }}" class="btn btn-info btn-sm" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @endpermission
                                            @permission('fleet-drivers-edit')
                                            <a href="{{ route('fleet.drivers.edit', $driver->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            @endpermission
                                            @permission('fleet-drivers-delete')
                                            <form action="{{ route('fleet.drivers.destroy', $driver->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this driver?')">
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
                                    <td colspan="8" class="text-center">
                                        <div class="py-4">
                                            <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                            <h5 class="text-muted">No drivers found</h5>
                                            @permission('fleet-drivers-create')
                                            <a href="{{ route('fleet.drivers.create') }}" class="btn btn-primary">
                                                <i class="fas fa-plus"></i> Add First Driver
                                            </a>
                                            @endpermission
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($drivers->hasPages())
                    <div class="d-flex justify-content-center">
                        {{ $drivers->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
