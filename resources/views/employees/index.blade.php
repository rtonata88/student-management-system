@extends('layouts.app')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Human Resources</li>
        <li class="breadcrumb-item">Employee Bio</li>
        <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection
@section('content')
<div class="row">
    <div class="col-md-12 col-xs-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Employee Profiles</h5>
                <small class="text-muted">Manage HR information for existing users. Users are created in Access Control >> Users.</small>
            </div>
            <div class="card-body">
                @if(Session::has('message'))
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    {{ Session::get('message') }}
                </div>
                @endif
                
                <!-- Search and Filter Form -->
                <form method="GET" action="{{ route('employees.index') }}" class="mb-4">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="input-group">
                                <input type="text" class="form-control" name="search" 
                                       placeholder="Search by name, username, email, employee #, department, position..." 
                                       value="{{ request('search') }}">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-primary" type="submit">
                                        <svg class="c-icon">
                                            <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-search')}}"></use>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <select name="department" class="form-control">
                                <option value="">All Departments</option>
                                @foreach($departments as $department)
                                <option value="{{ $department }}" {{ request('department') == $department ? 'selected' : '' }}>
                                    {{ $department }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <select name="status" class="form-control">
                                <option value="">All Status</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                <option value="no_profile" {{ request('status') == 'no_profile' ? 'selected' : '' }}>No Profile</option>
                            </select>
                        </div>
                        <div class="col-md-2 mb-3">
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary px-4">
                                    Filter
                                </button>
                                <a href="{{ route('employees.index') }}" class="btn btn-outline-secondary">
                                    Clear
                                </a>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Results Summary -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <small class="text-muted">
                            Showing {{ $users->firstItem() ?? 0 }} to {{ $users->lastItem() ?? 0 }} 
                            of {{ $users->total() }} employees
                            @if(request('search'))
                                (filtered by "{{ request('search') }}")
                            @endif
                        </small>
                    </div>
                </div>

                <table class="table table-responsive-sm table-bordered table-striped table-sm table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>Photo</th>
                            <th>Full Names</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Employee #</th>
                            <th>Department</th>
                            <th>Position</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td class="text-center">
                                @if($user->employeeProfile && $user->employeeProfile->profile_photo)
                                    <img src="{{ asset('storage/' . $user->employeeProfile->profile_photo) }}" 
                                         alt="Profile Photo" 
                                         class="rounded-circle" 
                                         style="width: 40px; height: 40px; object-fit: cover;">
                                @else
                                    <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center" 
                                         style="width: 40px; height: 40px; color: white; font-weight: bold;">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                @endif
                            </td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->username}}</td>
                            <td>{{$user->email}}</td>
                            <td>
                                @if($user->employeeProfile)
                                    {{ $user->employeeProfile->employee_number ?? 'N/A' }}
                                @else
                                    <span class="text-muted">No Profile</span>
                                @endif
                            </td>
                            <td>
                                @if($user->employeeProfile)
                                    {{ $user->employeeProfile->department ?? 'N/A' }}
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($user->employeeProfile)
                                    {{ $user->employeeProfile->position ?? 'N/A' }}
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($user->employeeProfile)
                                    @if($user->employeeProfile->is_active)
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-danger">Inactive</span>
                                    @endif
                                @else
                                    <span class="badge badge-warning">No Profile</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($user->employeeProfile)
                                <a href="{{route('employees.show', $user->id)}}" title="View Profile" class="btn btn-info btn-sm mr-1">
                                    View
                                </a>
                                @endif
                                <a href="{{route('employees.edit', $user->id)}}" title="Update Profile" class="btn btn-primary btn-sm">
                                    {{ $user->employeeProfile ? 'Update' : 'Create' }} Profile
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div>
                        <small class="text-muted">
                            Page {{ $users->currentPage() }} of {{ $users->lastPage() }}
                        </small>
                    </div>
                    <div>
                        {{ $users->links() }}
                    </div>
                </div>

                <!-- No Results Message -->
                @if($users->count() == 0)
                <div class="text-center py-4">
                    <div class="empty-state">
                        <svg class="c-icon c-icon-4xl text-muted mb-3">
                            <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-people')}}"></use>
                        </svg>
                        <h5 class="text-muted">No Employees Found</h5>
                        <p class="text-muted">
                            @if(request()->hasAny(['search', 'department', 'status']))
                                No employees match your search criteria. Try adjusting your filters.
                            @else
                                No employees are available in the system.
                            @endif
                        </p>
                        @if(request()->hasAny(['search', 'department', 'status']))
                        <a href="{{ route('employees.index') }}" class="btn btn-outline-primary">
                            Clear Filters
                        </a>
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

<style>
:root {
    --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --primary-color: #667eea;
    --secondary-color: #764ba2;
    --hover-gradient: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
    --success-gradient: linear-gradient(135deg, #56ab2f 0%, #a8e6cf 100%);
    --danger-gradient: linear-gradient(135deg, #ff416c 0%, #ff4b2b 100%);
    --warning-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
}

/* Primary button with gradient */
.btn-primary {
    background: var(--primary-gradient) !important;
    border: none !important;
    color: white !important;
    transition: all 0.3s ease;
    font-weight: 500;
}

.btn-primary:hover {
    background: var(--hover-gradient) !important;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
    color: white !important;
}

/* Secondary button styling */
.btn-secondary {
    background: linear-gradient(135deg, #6c757d 0%, #495057 100%) !important;
    border: none !important;
    color: white !important;
    transition: all 0.3s ease;
}

.btn-secondary:hover {
    background: linear-gradient(135deg, #5a6268 0%, #343a40 100%) !important;
    transform: translateY(-1px);
    color: white !important;
}

/* Info button styling */
.btn-info {
    background: linear-gradient(135deg, #36d1dc 0%, #5b86e5 100%) !important;
    border: none !important;
    color: white !important;
    transition: all 0.3s ease;
}

.btn-info:hover {
    background: linear-gradient(135deg, #2bc0cc 0%, #4a7bd1 100%) !important;
    transform: translateY(-1px);
    color: white !important;
}

/* Badge styling */
.badge-success {
    background: var(--success-gradient) !important;
    color: white !important;
}

.badge-danger {
    background: var(--danger-gradient) !important;
    color: white !important;
}

.badge-warning {
    background: var(--warning-gradient) !important;
    color: white !important;
}

/* Icon hover effects */
.c-icon {
    transition: all 0.3s ease;
}

a:hover .c-icon {
    transform: scale(1.1);
}

/* Card styling */
.card {
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    border: none;
    border-radius: 10px;
}

.card-header {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-bottom: 1px solid #dee2e6;
    border-radius: 10px 10px 0 0 !important;
}

/* Table styling */
.table-hover tbody tr:hover {
    background-color: rgba(102, 126, 234, 0.05);
}

/* Search button styling */
.btn-outline-primary {
    border: 2px solid var(--primary-color) !important;
    color: var(--primary-color) !important;
    background: transparent !important;
    transition: all 0.3s ease;
}

.btn-outline-primary:hover {
    background: var(--primary-gradient) !important;
    border-color: transparent !important;
    color: white !important;
    transform: translateY(-1px);
}

.btn-outline-secondary {
    border: 2px solid #6c757d !important;
    color: #6c757d !important;
    background: transparent !important;
    transition: all 0.3s ease;
}

.btn-outline-secondary:hover {
    background: linear-gradient(135deg, #6c757d 0%, #495057 100%) !important;
    border-color: transparent !important;
    color: white !important;
    transform: translateY(-1px);
}

/* Gap utility */
.gap-2 {
    gap: 0.5rem;
}

/* Search form styling */
.input-group .form-control:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

/* Empty state styling */
.empty-state {
    padding: 2rem;
}

/* Pagination styling */
.pagination .page-link {
    color: var(--primary-color);
    border-color: #dee2e6;
}

.pagination .page-item.active .page-link {
    background: var(--primary-gradient);
    border-color: var(--primary-color);
    color: white;
}

.pagination .page-link:hover {
    color: white;
    background: var(--hover-gradient);
    border-color: var(--primary-color);
}
</style>
