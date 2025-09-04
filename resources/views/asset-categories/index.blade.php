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
                                <i class="fas fa-tags"></i> Asset Categories Management
                            </h3>
                        </div>
                        <div class="col-auto">
                            @permission('create-asset-categories')
                            <a href="{{ route('asset-categories.create') }}" 
                               class="btn btn-sm"
                               style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                                <i class="fas fa-plus"></i> Add Asset Category
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
                    <form method="GET" action="{{ route('asset-categories.index') }}" class="mb-4">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="search">Search Asset Categories</label>
                                    <input type="text" class="form-control" id="search" name="search" 
                                           value="{{ request('search') }}" 
                                           placeholder="Search by name, code, or description...">
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
                                        <a href="{{ route('asset-categories.index') }}" class="btn" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                                            <i class="fas fa-times"></i> Clear
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- Asset Categories Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="thead-light">
                                <tr>
                                    <th>Code</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($assetCategories as $assetCategory)
                                <tr>
                                    <td><strong>{{ $assetCategory->code }}</strong></td>
                                    <td>{{ $assetCategory->name }}</td>
                                    <td>{{ $assetCategory->description ? \Illuminate\Support\Str::limit($assetCategory->description, 50) : '-' }}</td>
                                    <td>
                                        @if($assetCategory->is_active)
                                            <span class="badge badge-success">Active</span>
                                        @else
                                            <span class="badge badge-secondary">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div>
                                            @permission('edit-asset-categories')
                                            <a href="{{ route('asset-categories.edit', $assetCategory) }}" 
                                               class="btn btn-sm me-2" 
                                               style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            @endpermission

                                            @permission('toggle-asset-category-status')
                                            <form method="POST" action="{{ route('asset-categories.toggle-status', $assetCategory) }}" 
                                                  style="display: inline-block; margin-right: 8px;" 
                                                  onsubmit="return confirm('Are you sure you want to {{ $assetCategory->is_active ? 'deactivate' : 'activate' }} this asset category?')">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" 
                                                        class="btn btn-sm" style="background: linear-gradient(135deg, {{ $assetCategory->is_active ? '#ffc107, #fd7e14' : '#28a745, #20c997' }} ); color: white; border: none; border-radius: 6px; padding: 0.25rem 0.5rem;">
                                                    <i class="fas fa-{{ $assetCategory->is_active ? 'pause' : 'play' }}"></i> 
                                                    {{ $assetCategory->is_active ? 'Deactivate' : 'Activate' }}
                                                </button>
                                            </form>
                                            @endpermission

                                            @permission('delete-asset-categories')
                                            <form method="POST" action="{{ route('asset-categories.destroy', $assetCategory) }}" 
                                                  style="display: inline-block;" 
                                                  onsubmit="return confirm('Are you sure you want to delete this asset category? This action cannot be undone.')">
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
                                    <td colspan="5" class="text-center">
                                        <div class="py-4">
                                            <i class="fas fa-tags fa-3x text-muted mb-3"></i>
                                            <h5 class="text-muted">No Asset Categories Found</h5>
                                            <p class="text-muted">
                                                @if(request()->hasAny(['search', 'status']))
                                                    No asset categories match your search criteria.
                                                @else
                                                    Start by creating your first asset category.
                                                @endif
                                            </p>
                                            @permission('create-asset-categories')
                                            @if(!request()->hasAny(['search', 'status']))
                                            <a href="{{ route('asset-categories.create') }}" 
                                               class="btn btn-sm"
                                               style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                                                <i class="fas fa-plus"></i> Add First Asset Category
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
                    @if($assetCategories->hasPages())
                        <div class="d-flex justify-content-center">
                            {{ $assetCategories->appends(request()->query())->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
