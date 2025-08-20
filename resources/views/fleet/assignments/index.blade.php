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
                        <a href="{{ route('fleet.assignments.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> New Assignment
                        </a>
                    </div>
                    @endpermission
                </div>
                <div class="card-body">
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
                                        <strong>{{ $assignment->driver->name }}</strong><br>
                                        <small class="text-muted">{{ $assignment->driver->employee_id }}</small>
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $assignment->assignment_type === 'primary' ? 'primary' : 'secondary' }}">
                                            {{ ucfirst($assignment->assignment_type) }}
                                        </span>
                                    </td>
                                    <td>{{ $assignment->start_date->format('M d, Y') }}</td>
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
                                    <td>{{ Str::limit($assignment->notes, 30) ?? 'N/A' }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            @permission('fleet-assignments-view')
                                            <a href="{{ route('fleet.assignments.show', $assignment->id) }}" class="btn btn-info btn-sm" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @endpermission
                                            @permission('fleet-assignments-edit')
                                            <a href="{{ route('fleet.assignments.edit', $assignment->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            @endpermission
                                            @permission('fleet-assignments-delete')
                                            <form action="{{ route('fleet.assignments.destroy', $assignment->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure?')">
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
                                            <i class="fas fa-user-cog fa-3x text-muted mb-3"></i>
                                            <h5 class="text-muted">No vehicle assignments found</h5>
                                            @permission('fleet-assignments-create')
                                            <a href="{{ route('fleet.assignments.create') }}" class="btn btn-primary">
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
                    <div class="d-flex justify-content-center">
                        {{ $assignments->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
