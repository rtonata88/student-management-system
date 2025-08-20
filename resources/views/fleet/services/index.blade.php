@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-wrench"></i> Vehicle Services
                    </h3>
                    @permission('fleet-services-create')
                    <div class="card-tools">
                        <a href="{{ route('fleet.services.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Add Service Record
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
                                    <th>Service Type</th>
                                    <th>Description</th>
                                    <th>Cost</th>
                                    <th>Odometer</th>
                                    <th>Status</th>
                                    <th>Next Service</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($services as $service)
                                <tr>
                                    <td>{{ $service->service_date->format('M d, Y') }}</td>
                                    <td>
                                        <strong>{{ $service->vehicle->registration_number }}</strong><br>
                                        <small class="text-muted">{{ $service->vehicle->make }} {{ $service->vehicle->model }}</small>
                                    </td>
                                    <td>
                                        <span class="badge badge-primary">{{ ucfirst($service->service_type) }}</span>
                                    </td>
                                    <td>{{ Str::limit($service->description, 50) }}</td>
                                    <td>${{ number_format($service->cost, 2) }}</td>
                                    <td>{{ number_format($service->odometer_reading) }} km</td>
                                    <td>
                                        <span class="badge badge-{{ $service->status === 'completed' ? 'success' : ($service->status === 'pending' ? 'warning' : 'info') }}">
                                            {{ ucfirst($service->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($service->next_service_date)
                                            {{ $service->next_service_date->format('M d, Y') }}
                                        @else
                                            <span class="text-muted">Not Set</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            @permission('fleet-services-view')
                                            <a href="{{ route('fleet.services.show', $service->id) }}" class="btn btn-info btn-sm" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @endpermission
                                            @permission('fleet-services-edit')
                                            <a href="{{ route('fleet.services.edit', $service->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            @endpermission
                                            @permission('fleet-services-delete')
                                            <form action="{{ route('fleet.services.destroy', $service->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure?')">
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
                                            <i class="fas fa-wrench fa-3x text-muted mb-3"></i>
                                            <h5 class="text-muted">No service records found</h5>
                                            @permission('fleet-services-create')
                                            <a href="{{ route('fleet.services.create') }}" class="btn btn-primary">
                                                <i class="fas fa-plus"></i> Add First Service Record
                                            </a>
                                            @endpermission
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($services->hasPages())
                    <div class="d-flex justify-content-center">
                        {{ $services->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
