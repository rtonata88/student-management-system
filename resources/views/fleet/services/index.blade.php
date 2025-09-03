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
                        <a href="{{ route('fleet.services.create') }}" class="btn btn-sm" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                            <i class="fas fa-plus"></i> Add Service Record
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
                            <form method="GET" action="{{ route('fleet.services') }}" class="form-inline">
                                <div class="input-group" style="width: 100%; max-width: 400px;">
                                    <input type="text" name="search" class="form-control" placeholder="Search by vehicle, service type, provider..." value="{{ request('search') }}">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 0 6px 6px 0; padding: 0.375rem 0.75rem;">
                                            <i class="fas fa-search"></i> Search
                                        </button>
                                    </div>
                                </div>
                                @if(request('search'))
                                    <a href="{{ route('fleet.services') }}" class="btn btn-outline-secondary ml-2" style="border-radius: 6px; padding: 0.375rem 0.75rem;">
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
                                    <td>
                                        <button type="button" class="btn btn-sm view-description-btn" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;" data-description="{{ $service->description }}" data-service-type="{{ $service->service_type }}"
                                            <i class="fas fa-eye"></i> View
                                        </button>
                                    </td>
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
                                        <div class="d-flex gap-2">
                                            @permission('fleet-services-edit')
                                            <a href="{{ route('fleet.services.edit', $service) }}" class="btn btn-sm" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;" title="Edit">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            @endpermission
                                            @permission('fleet-services-delete')
                                            <form method="POST" action="{{ route('fleet.services.destroy', $service) }}" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;" title="Delete" onclick="return confirm('Are you sure you want to delete this service record?')">
                                                    <i class="fas fa-trash"></i> Delete
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
                                            <a href="{{ route('fleet.services.create') }}" class="btn" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
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
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div>
                            <small class="text-muted">
                                Showing {{ $services->firstItem() }} to {{ $services->lastItem() }} of {{ $services->total() }} services
                            </small>
                        </div>
                        <div>
                            {{ $services->appends(request()->query())->links() }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Description Modal -->
<div class="modal fade" id="descriptionModal" tabindex="-1" role="dialog" aria-labelledby="descriptionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="descriptionModalLabel">Service Description</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <strong>Service Type:</strong> <span id="modalServiceType"></span>
                </div>
                <div>
                    <strong>Description:</strong>
                    <div id="modalDescription" class="mt-2 p-3" style="background-color: #f8f9fa; border-radius: 6px; border-left: 4px solid #6f42c1;"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    console.log('Document ready');
    
    // Clear any existing modal backdrop on page load
    $('.modal-backdrop').remove();
    $('body').removeClass('modal-open');
    
    // Handle view description button clicks
    $(document).on('click', '.view-description-btn', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        var description = $(this).data('description');
        var serviceType = $(this).data('service-type');
        
        console.log('Button clicked with:', description, serviceType);
        
        // Set modal content
        $('#modalDescription').html(description);
        $('#modalServiceType').html(serviceType.charAt(0).toUpperCase() + serviceType.slice(1).replace('_', ' '));
        
        // Show modal
        $('#descriptionModal').modal('show');
    });
    
    // Ensure modal can be closed
    $(document).on('click', '[data-dismiss="modal"]', function() {
        $('#descriptionModal').modal('hide');
    });
});
</script>
@endsection
