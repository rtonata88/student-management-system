@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-car"></i> Vehicle Management
                    </h3>
                    <div class="card-tools">
                        @permission('fleet-vehicles-create')
                        <a href="{{ route('fleet.vehicles.create') }}" class="btn btn-sm" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                            <i class="fas fa-plus"></i> Add Vehicle
                        </a>
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

                    <!-- Search Form -->
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <form method="GET" action="{{ route('fleet.vehicles') }}" class="form-inline">
                                <div class="input-group" style="width: 100%; max-width: 400px;">
                                    <input type="text" name="search" class="form-control" placeholder="Search by registration, make, model..." value="{{ request('search') }}">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 0 6px 6px 0; padding: 0.375rem 0.75rem;">
                                            <i class="fas fa-search"></i> Search
                                        </button>
                                    </div>
                                </div>
                                @if(request('search'))
                                    <a href="{{ route('fleet.vehicles') }}" class="btn btn-outline-secondary ml-2" style="border-radius: 6px; padding: 0.375rem 0.75rem;">
                                        <i class="fas fa-times"></i> Clear
                                    </a>
                                @endif
                            </form>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Registration</th>
                                    <th>Make & Model</th>
                                    <th>Year</th>
                                    <th>Category</th>
                                    <th>Status</th>
                                    <th>Current Driver</th>
                                    <th>Fuel Type</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($vehicles as $vehicle)
                                <tr>
                                    <td><strong>{{ $vehicle->registration_number }}</strong></td>
                                    <td>{{ $vehicle->make }} {{ $vehicle->model }}</td>
                                    <td>{{ $vehicle->year }}</td>
                                    <td>{{ $vehicle->category->name ?? 'N/A' }}</td>
                                    <td>
                                        <span class="badge badge-{{ $vehicle->status == 'active' ? 'success' : ($vehicle->status == 'maintenance' ? 'warning' : 'danger') }}">
                                            {{ ucfirst($vehicle->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($vehicle->currentDriver && $vehicle->currentDriver->driver)
                                            {{ $vehicle->currentDriver->driver->full_name }}
                                        @else
                                            <span class="text-muted">Unassigned</span>
                                        @endif
                                    </td>
                                    <td>{{ ucfirst($vehicle->fuel_type) }}</td>
                                    <td>
                                        <div class="d-flex" style="gap: 0.5rem;">
                                            @permission('fleet-vehicles-edit')
                                            <a href="{{ route('fleet.vehicles.edit', $vehicle) }}" class="btn btn-sm" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;" title="Edit">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            @endpermission
                                            @permission('fleet-vehicles-delete')
                                            <form method="POST" action="{{ route('fleet.vehicles.destroy', $vehicle) }}" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;" title="Delete" onclick="return confirm('Are you sure you want to delete this vehicle?')">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            </form>
                                            @endpermission
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center">No vehicles found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($vehicles->hasPages())
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div>
                            <small class="text-muted">
                                Showing {{ $vehicles->firstItem() }} to {{ $vehicles->lastItem() }} of {{ $vehicles->total() }} vehicles
                            </small>
                        </div>
                        <div>
                            {{ $vehicles->appends(request()->query())->links() }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
