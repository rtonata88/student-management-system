@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="fas fa-building"></i> Department Management
                    </h4>
                    @permission('create-departments')
                    <a href="{{ route('departments.create') }}" class="btn btn-sm" 
                       style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                        <i class="fas fa-plus"></i> Add Department
                    </a>
                    @endpermission
                </div>

                <div class="card-body">
                    <!-- Search and Filter Form -->
                    <form method="GET" action="{{ route('departments.index') }}" class="mb-4">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="text" name="search" class="form-control" 
                                           placeholder="Search departments..." 
                                           value="{{ request('search') }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <select name="status" class="form-control">
                                        <option value="">All Status</option>
                                        <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn" 
                                        style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                                    <i class="fas fa-search"></i> Search
                                </button>
                                <a href="{{ route('departments.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Clear
                                </a>
                            </div>
                        </div>
                    </form>

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

                    <!-- Departments Table -->
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="thead-dark">
                            <tr>
                                <th>Code</th>
                                <th>Name</th>
                                <th>Head of Department</th>
                                <th>Location</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                            <tbody>
                                @forelse($departments as $department)
                                <tr>
                                    <td><strong>{{ $department->code }}</strong></td>
                                    <td>{{ $department->name }}</td>
                                    <td>{{ $department->head_of_department ?? 'Not Assigned' }}</td>
                                    <td>{{ $department->location ?? '-' }}</td>
                                    <td>
                                        @if($department->is_active)
                                            <span class="badge badge-success">Active</span>
                                        @else
                                            <span class="badge badge-secondary">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div>
                                            @permission('edit-departments')
                                            <a href="{{ route('departments.edit', $department) }}" 
                                               class="btn btn-sm me-2" 
                                               style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            @endpermission

                                            @permission('toggle-department-status')
                                            <form method="POST" action="{{ route('departments.toggle-status', $department) }}" 
                                                  style="display: inline-block; margin-right: 8px;" 
                                                  onsubmit="return confirm('Are you sure you want to {{ $department->is_active ? 'deactivate' : 'activate' }} this department?')">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" 
                                                        class="btn btn-sm {{ $department->is_active ? 'btn-warning' : 'btn-success' }}">
                                                    <i class="fas fa-{{ $department->is_active ? 'pause' : 'play' }}"></i> 
                                                    {{ $department->is_active ? 'Deactivate' : 'Activate' }}
                                                </button>
                                            </form>
                                            @endpermission

                                            @permission('delete-departments')
                                            <form method="POST" action="{{ route('departments.destroy', $department) }}" 
                                                  style="display: inline-block;" 
                                                  onsubmit="return confirm('Are you sure you want to delete this department? This action cannot be undone.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            </form>
                                            @endpermission
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <i class="fas fa-building fa-3x text-muted mb-3"></i>
                                        <h5 class="text-muted">No departments found</h5>
                                        @permission('create-departments')
                                        <p class="text-muted">
                                            <a href="{{ route('departments.create') }}" 
                                               style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;"
                                               class="btn">
                                                <i class="fas fa-plus"></i> Create your first department
                                            </a>
                                        </p>
                                        @endpermission
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($departments->hasPages())
                    <div class="d-flex justify-content-center">
                        {{ $departments->appends(request()->query())->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
