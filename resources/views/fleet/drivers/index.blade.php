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
                        <a href="{{ route('fleet.drivers.create') }}" class="btn btn-sm" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                            <i class="fas fa-plus"></i> Add Driver
                        </a>
                    </div>
                    @endpermission
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Search Form -->
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <form method="GET" action="{{ route('fleet.drivers') }}" class="form-inline">
                                <div class="input-group" style="width: 100%; max-width: 400px;">
                                    <input type="text" name="search" class="form-control" placeholder="Search by name, license, phone..." value="{{ request('search') }}">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 0 6px 6px 0; padding: 0.375rem 0.75rem;">
                                            <i class="fas fa-search"></i> Search
                                        </button>
                                    </div>
                                </div>
                                @if(request('search'))
                                    <a href="{{ route('fleet.drivers') }}" class="btn btn-outline-secondary ml-2" style="border-radius: 6px; padding: 0.375rem 0.75rem;">
                                        <i class="fas fa-times"></i> Clear
                                    </a>
                                @endif
                            </form>
                        </div>
                    </div>

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
                                            <img src="{{ asset('storage/' . $driver->photo) }}" alt="{{ $driver->full_name }}" class="img-circle" width="40" height="40">
                                        @else
                                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                {{ strtoupper(substr($driver->first_name, 0, 1)) }}
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <strong>{{ $driver->full_name }}</strong><br>
                                        <small class="text-muted">{{ $driver->employee_number }}</small>
                                    </td>
                                    <td>{{ $driver->license_number }}</td>
                                    <td>{{ $driver->phone }}</td>
                                    <td>
                                        @if($driver->license_expiry)
                                            @php
                                                $expiryDate = \Carbon\Carbon::parse($driver->license_expiry);
                                                $daysUntilExpiry = $expiryDate->diffInDays(now(), false);
                                            @endphp
                                            <span class="badge badge-{{ $daysUntilExpiry > 30 ? 'success' : ($daysUntilExpiry > 0 ? 'warning' : 'danger') }}">
                                                {{ $driver->license_expiry->format('M d, Y') }}
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
                                        @if($driver->currentVehicle && $driver->currentVehicle->vehicle)
                                            <span class="badge badge-info">
                                                {{ $driver->currentVehicle->vehicle->registration_number }}
                                            </span>
                                        @else
                                            <span class="badge badge-secondary">Unassigned</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex" style="gap: 0.5rem;">
                                            @permission('fleet-drivers-view')
                                            <a href="{{ route('fleet.drivers.show', $driver->id) }}" class="btn btn-sm" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;" title="View">
                                                <i class="fas fa-eye"></i> View
                                            </a>
                                            @endpermission
                                            @permission('fleet-drivers-edit')
                                            <a href="{{ route('fleet.drivers.edit', $driver) }}" class="btn btn-sm" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;" title="Edit">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            @endpermission
                                            @permission('fleet-drivers-delete')
                                            <form action="{{ route('fleet.drivers.destroy', $driver->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;" title="Delete" onclick="return confirm('Are you sure you want to delete this driver?')">
                                                    <i class="fas fa-trash"></i> Delete
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
                                            <a href="{{ route('fleet.drivers.create') }}" class="btn" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
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
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div>
                            <small class="text-muted">
                                Showing {{ $drivers->firstItem() }} to {{ $drivers->lastItem() }} of {{ $drivers->total() }} drivers
                            </small>
                        </div>
                        <div>
                            {{ $drivers->appends(request()->query())->links() }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
