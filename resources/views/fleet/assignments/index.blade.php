@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-user-cog"></i> Vehicle Assignments
                    </h3>
                    @permission('fleet-assignments-create')
                    <div class="card-tools">
                        <a href="{{ route('fleet.assignments.create') }}" class="btn btn-sm" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                            <i class="fas fa-plus"></i> New Assignment
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
                            <form method="GET" action="{{ route('fleet.assignments') }}" class="form-inline">
                                <div class="input-group" style="width: 100%; max-width: 400px;">
                                    <input type="text" name="search" class="form-control" placeholder="Search by vehicle, driver, assignment type..." value="{{ request('search') }}">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 0 6px 6px 0; padding: 0.375rem 0.75rem;">
                                            <i class="fas fa-search"></i> Search
                                        </button>
                                    </div>
                                </div>
                                @if(request('search'))
                                    <a href="{{ route('fleet.assignments') }}" class="btn btn-outline-secondary ml-2" style="border-radius: 6px; padding: 0.375rem 0.75rem;">
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
                                    <th>Vehicle</th>
                                    <th>Driver</th>
                                    <th>Assignment Type</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Status</th>
                                    <th>Notes</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($assignments as $assignment)
                                <tr>
                                    <td>
                                        <strong>{{ $assignment->vehicle->registration_number }}</strong><br>
                                        <small class="text-muted">{{ $assignment->vehicle->make }} {{ $assignment->vehicle->model }}</small>
                                    </td>
                                    <td>
                                        <strong>{{ $assignment->driver->first_name }} {{ $assignment->driver->last_name }}</strong><br>
                                        <small class="text-muted">{{ $assignment->driver->employee_number }}</small>
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $assignment->assignment_type === 'primary' ? 'primary' : 'secondary' }}">
                                            {{ ucfirst($assignment->assignment_type) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($assignment->start_date)
                                            {{ $assignment->start_date->format('M d, Y') }}
                                        @else
                                            <span class="text-muted">Not set</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($assignment->end_date)
                                            {{ $assignment->end_date->format('M d, Y') }}
                                        @else
                                            <span class="badge badge-success">Ongoing</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $assignment->isActive() ? 'success' : 'secondary' }}">
                                            {{ $assignment->isActive() ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($assignment->notes)
                                            <button type="button" class="btn btn-sm" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.25rem 0.5rem;" data-toggle="modal" data-target="#notesModal{{ $assignment->id }}">
                                                <i class="fas fa-eye"></i> View
                                            </button>
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            @permission('fleet-assignments-view')
                                            <a href="{{ route('fleet.assignments.show', $assignment->id) }}" class="btn btn-sm" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;" title="View">
                                                <i class="fas fa-eye"></i> View
                                            </a>
                                            @endpermission
                                            @permission('fleet-assignments-edit')
                                            <a href="{{ route('fleet.assignments.edit', $assignment->id) }}" class="btn btn-sm" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;" title="Edit">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            @endpermission
                                            @permission('fleet-assignments-delete')
                                            <form action="{{ route('fleet.assignments.destroy', $assignment->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this assignment?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;" title="Delete">
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
                                            <i class="fas fa-user-cog fa-3x text-muted mb-3"></i>
                                            <h5 class="text-muted">No vehicle assignments found</h5>
                                            @permission('fleet-assignments-create')
                                            <a href="{{ route('fleet.assignments.create') }}" class="btn" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                                                <i class="fas fa-plus"></i> Create First Assignment
                                            </a>
                                            @endpermission
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($assignments->hasPages())
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div>
                            <small class="text-muted">
                                Showing {{ $assignments->firstItem() }} to {{ $assignments->lastItem() }} of {{ $assignments->total() }} assignments
                            </small>
                        </div>
                        <div>
                            {{ $assignments->appends(request()->query())->links() }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Notes Modals -->
@foreach($assignments as $assignment)
    @if($assignment->notes)
    <div class="modal fade" id="notesModal{{ $assignment->id }}" tabindex="-1" role="dialog" aria-labelledby="notesModalLabel{{ $assignment->id }}" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="notesModalLabel{{ $assignment->id }}">
                        <i class="fas fa-sticky-note"></i> Assignment Notes
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Vehicle:</strong> {{ $assignment->vehicle->registration_number }} ({{ $assignment->vehicle->make }} {{ $assignment->vehicle->model }})
                        </div>
                        <div class="col-md-6">
                            <strong>Driver:</strong> {{ $assignment->driver->first_name }} {{ $assignment->driver->last_name }}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <strong>Assignment Type:</strong> 
                            <span class="badge badge-{{ $assignment->assignment_type === 'primary' ? 'primary' : 'secondary' }}">
                                {{ ucfirst($assignment->assignment_type) }}
                            </span>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <strong>Notes:</strong>
                            <div class="mt-2 p-3" style="background-color: #f8f9fa; border-radius: 6px; border-left: 4px solid #6f42c1;">
                                {{ $assignment->notes }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times"></i> Close
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
@endforeach

@endsection
