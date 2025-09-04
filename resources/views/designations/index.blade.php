@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="fas fa-user-tag"></i> Designation Management
                    </h4>
                    @permission('create-designations')
                    <a href="{{ route('designations.create') }}" class="btn btn-sm" 
                       style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                        <i class="fas fa-plus"></i> Add Designation
                    </a>
                    @endpermission
                </div>

                <div class="card-body">
                    <!-- Search and Filter Form -->
                    <form method="GET" action="{{ route('designations.index') }}" class="mb-4">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="text" name="search" class="form-control" 
                                           placeholder="Search designations..." 
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
                                <button type="submit" class="btn me-2" 
                                        style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                                    <i class="fas fa-search"></i> Search
                                </button>
                                <a href="{{ route('designations.index') }}" class="btn btn-secondary">
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

                    <!-- Designations Table -->
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="thead-dark">
                            <tr>
                                <th>Code</th>
                                <th>Name</th>
                                <th>Level</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                            <tbody>
                                @forelse($designations as $designation)
                                <tr>
                                    <td><strong>{{ $designation->code }}</strong></td>
                                    <td>{{ $designation->name }}</td>
                                    <td>{{ $designation->level ?? '-' }}</td>
                                    <td>{{ $designation->description ? \Illuminate\Support\Str::limit($designation->description, 50) : '-' }}</td>
                                    <td>
                                        @if($designation->is_active)
                                            <span class="badge badge-success">Active</span>
                                        @else
                                            <span class="badge badge-secondary">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div>
                                            @permission('edit-designations')
                                            <a href="{{ route('designations.edit', $designation) }}" 
                                               class="btn btn-sm me-2" 
                                               style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            @endpermission

                                            @permission('toggle-designation-status')
                                            <form method="POST" action="{{ route('designations.toggle-status', $designation) }}" 
                                                  style="display: inline-block; margin-right: 8px;" 
                                                  onsubmit="return confirm('Are you sure you want to {{ $designation->is_active ? 'deactivate' : 'activate' }} this designation?')">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" 
                                                        class="btn btn-sm {{ $designation->is_active ? 'btn-warning' : 'btn-success' }}">
                                                    <i class="fas fa-{{ $designation->is_active ? 'pause' : 'play' }}"></i> 
                                                    {{ $designation->is_active ? 'Deactivate' : 'Activate' }}
                                                </button>
                                            </form>
                                            @endpermission

                                            @permission('delete-designations')
                                            <form method="POST" action="{{ route('designations.destroy', $designation) }}" 
                                                  style="display: inline-block;" 
                                                  onsubmit="return confirm('Are you sure you want to delete this designation? This action cannot be undone.')">
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
                                        <i class="fas fa-user-tag fa-3x text-muted mb-3"></i>
                                        <h5 class="text-muted">No designations found</h5>
                                        @permission('create-designations')
                                        <p class="text-muted">
                                            <a href="{{ route('designations.create') }}" 
                                               style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;"
                                               class="btn">
                                                <i class="fas fa-plus"></i> Create your first designation
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
                    @if($designations->hasPages())
                    <div class="d-flex justify-content-center">
                        {{ $designations->appends(request()->query())->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
