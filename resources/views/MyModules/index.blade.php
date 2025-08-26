@extends('layouts.app')

@section('breadcrumb')
<div class="c-subheader px-3">
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Assessments</li>
        <li class="breadcrumb-item active">My Modules</li>
    </ol>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-book-open"></i> My Modules</h5>
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
                                <th>Academic Year</th>
                                <th>Subject Name</th>
                                <th>Centre Name</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($myModules as $allocation)
                            <tr>
                                <td>
                                    <i class="fas fa-calendar-alt text-success"></i>
                                    {{ $allocation->academicYear->academic_year }}
                                </td>
                                <td>
                                    <span class="badge badge-info">{{ $allocation->module->subject_code }}</span>
                                    {{ $allocation->module->subject_name }}
                                </td>
                                <td>
                                    <i class="fas fa-map-marker-alt text-warning"></i>
                                    {{ $allocation->center->center_name }}
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" 
                                                id="actionsDropdown{{ $allocation->id }}" data-toggle="dropdown" 
                                                aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-cog"></i> Actions
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="actionsDropdown{{ $allocation->id }}">
                                            @permission('view-class-list')
                                            <a class="dropdown-item" href="{{ route('my-modules.class-list', $allocation->id) }}">
                                                <i class="fas fa-users"></i> Class List
                                            </a>
                                            @endpermission
                                            
                                            @permission('view-attendance')
                                            <a class="dropdown-item" href="{{ route('my-modules.attendance', $allocation->id) }}">
                                                <i class="fas fa-check-circle"></i> Attendance
                                            </a>
                                            @endpermission
                                            
                                            @permission('view-subject-materials')
                            <a class="dropdown-item" href="{{ route('my-modules.subject-materials', $allocation->id) }}">
                                <i class="fas fa-folder-open"></i> Subject Materials
                            </a>
                            @endpermission
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">
                                    <i class="fas fa-inbox fa-2x mb-2"></i><br>
                                    No modules allocated to you.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.dropdown-menu {
    z-index: 1050 !important;
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    border: 1px solid rgba(0,0,0,0.1);
}

.dropdown {
    position: relative;
}

.table-responsive {
    overflow: visible !important;
}

.table td {
    position: relative;
}

.btn-secondary {
    background: linear-gradient(45deg, #6c757d 0%, #5a6268 100%);
    border: none;
    color: white;
}

.btn-secondary:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    transition: all 0.3s ease;
}
</style>
@endsection
