@extends('layouts.app')

@section('breadcrumb')
<div class="c-subheader px-3">
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Assessments</li>
        <li class="breadcrumb-item active">Module Allocations</li>
    </ol>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-chalkboard-teacher"></i> Module Allocations</h5>
                @permission('create-module-allocations')
                <a href="{{ route('module-allocations.create') }}" class="btn btn-system-gradient">
                    <i class="fas fa-plus"></i> Add New
                </a>
                @endpermission
            </div>
            <div class="card-body">
                @if(Session::has('success'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    {{ Session::get('success') }}
                </div>
                @endif

                @if(Session::has('error'))
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    {{ Session::get('error') }}
                </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>Teacher</th>
                                <th>Module</th>
                                <th>Academic Year</th>
                                <th>Center</th>
                                <th>Allocated Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($allocations as $allocation)
                            <tr>
                                <td>
                                    <i class="fas fa-user-tie text-primary"></i>
                                    {{ $allocation->teacher_name }}
                                </td>
                                <td>
                                    <span class="badge badge-info">{{ $allocation->module->subject_code }}</span>
                                    {{ $allocation->module->subject_name }}
                                </td>
                                <td>
                                    <i class="fas fa-calendar-alt text-success"></i>
                                    {{ $allocation->academicYear->academic_year }}
                                </td>
                                <td>
                                    <i class="fas fa-map-marker-alt text-warning"></i>
                                    {{ $allocation->center->center_name }}
                                </td>
                                <td>{{ $allocation->created_at->format('M d, Y') }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        @permission('edit-module-allocations')
                                        <a href="{{ route('module-allocations.edit', $allocation->id) }}" 
                                           class="btn btn-sm btn-primary" title="Edit">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        @endpermission
                                        
                                        @permission('delete-module-allocations')
                                        <form action="{{ route('module-allocations.destroy', $allocation->id) }}" 
                                              method="POST" class="d-inline"
                                              onsubmit="return confirm('Are you sure you want to delete this allocation?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>
                                        @endpermission
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    <i class="fas fa-inbox fa-2x mb-2"></i><br>
                                    No module allocations found.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($allocations->hasPages())
                <div class="d-flex justify-content-center mt-3">
                    {{ $allocations->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
.btn-system-gradient {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    color: white;
    padding: 8px 16px;
    border-radius: 8px;
    font-weight: 500;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.3s ease;
    box-shadow: 0 2px 4px rgba(102, 126, 234, 0.2);
}

.btn-system-gradient:hover {
    background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(102, 126, 234, 0.3);
    color: white;
    text-decoration: none;
}

.btn-system-gradient:focus,
.btn-system-gradient:active {
    color: white;
    text-decoration: none;
    outline: none;
}
</style>
@endsection
