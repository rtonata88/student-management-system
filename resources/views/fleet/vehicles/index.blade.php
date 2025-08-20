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
                        <a href="{{ route('fleet.vehicles.create') }}" class="btn btn-primary btn-sm">
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
                                        @permission('fleet-vehicles-edit')
                                        <a href="{{ route('fleet.vehicles.edit', $vehicle) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @endpermission
                                        @permission('fleet-vehicles-delete')
                                        <form method="POST" action="{{ route('fleet.vehicles.destroy', $vehicle) }}" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                        @endpermission
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

                    {{ $vehicles->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
