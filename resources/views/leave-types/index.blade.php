@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="card-title mb-0">
                                <i class="fas fa-calendar-alt"></i> Leave Types Management
                            </h3>
                        </div>
                        <div class="col-auto">
                            @permission('create-leave-types')
                            <a href="{{ route('leave-types.create') }}" 
                               class="btn btn-sm"
                               style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                                <i class="fas fa-plus"></i> Add Leave Type
                            </a>
                            @endpermission
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <!-- Search and Filter Form -->
                    <form method="GET" action="{{ route('leave-types.index') }}" class="mb-4">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="search">Search Leave Types</label>
                                    <input type="text" class="form-control" id="search" name="search" 
                                           value="{{ request('search') }}" 
                                           placeholder="Search by name or description...">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select class="form-control" id="status" name="status">
                                        <option value="">All Status</option>
                                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <div class="d-flex">
                                        <button type="submit" class="btn me-2" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                                            <i class="fas fa-search"></i> Search
                                        </button>
                                        <a href="{{ route('leave-types.index') }}" class="btn" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                                            <i class="fas fa-times"></i> Clear
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- Leave Types Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="thead-light">
                                <tr>
                                    <th>Leave Type</th>
                                    <th>Description</th>
                                    <th>Max Days/Year</th>
                                    <th>Approval Required</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($leaveTypes as $leaveType)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="badge me-2" style="background-color: {{ $leaveType->color }}; color: white; width: 20px; height: 20px; border-radius: 50%;"></span>
                                            <strong>{{ $leaveType->name }}</strong>
                                        </div>
                                    </td>
                                    <td>{{ $leaveType->description ? \Illuminate\Support\Str::limit($leaveType->description, 50) : '-' }}</td>
                                    <td>
                                        <span class="badge badge-info">{{ $leaveType->max_days_display }}</span>
                                    </td>
                                    <td>
                                        @if($leaveType->requires_approval)
                                            <span class="badge badge-warning">Required</span>
                                        @else
                                            <span class="badge badge-success">Not Required</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($leaveType->is_active)
                                            <span class="badge badge-success">Active</span>
                                        @else
                                            <span class="badge badge-secondary">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div>
                                            @permission('edit-leave-types')
                                            <a href="{{ route('leave-types.edit', $leaveType) }}" 
                                               class="btn btn-sm me-2" 
                                               style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            @endpermission

                                            @permission('toggle-leave-type-status')
                                            <form method="POST" action="{{ route('leave-types.toggle-status', $leaveType) }}" 
                                                  style="display: inline-block; margin-right: 8px;" 
                                                  onsubmit="return confirm('Are you sure you want to {{ $leaveType->is_active ? 'deactivate' : 'activate' }} this leave type?')">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" 
                                                        class="btn btn-sm" style="background: linear-gradient(135deg, {{ $leaveType->is_active ? '#ffc107, #fd7e14' : '#28a745, #20c997' }} ); color: white; border: none; border-radius: 6px; padding: 0.25rem 0.5rem;">
                                                    <i class="fas fa-{{ $leaveType->is_active ? 'pause' : 'play' }}"></i> 
                                                    {{ $leaveType->is_active ? 'Deactivate' : 'Activate' }}
                                                </button>
                                            </form>
                                            @endpermission

                                            @permission('delete-leave-types')
                                            <form method="POST" action="{{ route('leave-types.destroy', $leaveType) }}" 
                                                  style="display: inline-block;" 
                                                  onsubmit="return confirm('Are you sure you want to delete this leave type? This action cannot be undone.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: white; border: none; border-radius: 6px; padding: 0.25rem 0.5rem;">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            </form>
                                            @endpermission
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">
                                        <div class="py-4">
                                            <i class="fas fa-calendar-alt fa-3x text-muted mb-3"></i>
                                            <h5 class="text-muted">No Leave Types Found</h5>
                                            <p class="text-muted">
                                                @if(request()->hasAny(['search', 'status']))
                                                    No leave types match your search criteria.
                                                @else
                                                    Start by creating your first leave type.
                                                @endif
                                            </p>
                                            @permission('create-leave-types')
                                            @if(!request()->hasAny(['search', 'status']))
                                            <a href="{{ route('leave-types.create') }}" 
                                               class="btn btn-sm"
                                               style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                                                <i class="fas fa-plus"></i> Add First Leave Type
                                            </a>
                                            @endif
                                            @endpermission
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($leaveTypes->hasPages())
                        <div class="d-flex justify-content-center">
                            {{ $leaveTypes->appends(request()->query())->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
