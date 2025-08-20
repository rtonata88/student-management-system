@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-gas-pump"></i> Fuel Records
                    </h3>
                    @permission('fleet-fuel-create')
                    <div class="card-tools">
                        <a href="{{ route('fleet.fuel.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Add Fuel Record
                        </a>
                    </div>
                    @endpermission
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Vehicle</th>
                                    <th>Driver</th>
                                    <th>Fuel Type</th>
                                    <th>Quantity</th>
                                    <th>Cost</th>
                                    <th>Odometer</th>
                                    <th>Station</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($fuelRecords as $record)
                                <tr>
                                    <td>{{ $record->date->format('M d, Y') }}</td>
                                    <td>
                                        <strong>{{ $record->vehicle->registration_number }}</strong><br>
                                        <small class="text-muted">{{ $record->vehicle->make }} {{ $record->vehicle->model }}</small>
                                    </td>
                                    <td>{{ $record->driver->name ?? 'N/A' }}</td>
                                    <td>
                                        <span class="badge badge-info">{{ ucfirst($record->fuel_type) }}</span>
                                    </td>
                                    <td>{{ number_format($record->quantity, 2) }}L</td>
                                    <td>${{ number_format($record->total_cost, 2) }}</td>
                                    <td>{{ number_format($record->odometer_reading) }} km</td>
                                    <td>{{ $record->fuel_station ?? 'N/A' }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            @permission('fleet-fuel-view')
                                            <a href="{{ route('fleet.fuel.show', $record->id) }}" class="btn btn-info btn-sm" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @endpermission
                                            @permission('fleet-fuel-edit')
                                            <a href="{{ route('fleet.fuel.edit', $record->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            @endpermission
                                            @permission('fleet-fuel-delete')
                                            <form action="{{ route('fleet.fuel.destroy', $record->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure?')">
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
                                            <i class="fas fa-gas-pump fa-3x text-muted mb-3"></i>
                                            <h5 class="text-muted">No fuel records found</h5>
                                            @permission('fleet-fuel-create')
                                            <a href="{{ route('fleet.fuel.create') }}" class="btn btn-primary">
                                                <i class="fas fa-plus"></i> Add First Fuel Record
                                            </a>
                                            @endpermission
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($fuelRecords->hasPages())
                    <div class="d-flex justify-content-center">
                        {{ $fuelRecords->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
