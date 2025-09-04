@extends('layouts.app')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Access Management</li>
        <li class="breadcrumb-item">Users</li>
        <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-users"></i> Staff Users Management</h5>
                <div>
                    <a href="{{route('users.create')}}" class="btn me-2" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem; margin-right: 8px;">
                        <i class="fas fa-plus"></i> Add User
                    </a>
                    @permission('view-student-passwords')
                    <a href="{{route('users.reset-students')}}" class="btn" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                        <i class="fas fa-key"></i> Reset Students
                    </a>
                    @endpermission
                </div>
            </div>
            <div class="card-body">
                @if(Session::has('message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle"></i> {{ Session::get('message') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif

                <!-- Search Form -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <form method="GET" action="{{ route('users.index') }}" class="d-flex">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                                </div>
                                <input type="text" name="search" class="form-control" placeholder="Search by name, username, or email..." value="{{ request('search') }}">
                                <div class="input-group-append">
                                    <button class="btn" type="submit" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 0 6px 6px 0;">
                                        <i class="fas fa-search"></i> Search
                                    </button>
                                    @if(request('search'))
                                    <a href="{{ route('users.index') }}" class="btn" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: white; border: none; border-radius: 0;">
                                        <i class="fas fa-times"></i> Clear
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-6 text-right">
                        <small class="text-muted">
                            Showing {{ $users->firstItem() ?? 0 }} to {{ $users->lastItem() ?? 0 }} of {{ $users->total() }} results
                        </small>
                    </div>
                </div>

                <!-- Users Table -->
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th>Profile</th>
                                <th>Full Name</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                            <tr>
                                <td>
                                    @if($user->employeeProfile && $user->employeeProfile->profile_photo)
                                        <img src="{{ asset('storage/' . $user->employeeProfile->profile_photo) }}" 
                                             alt="{{ $user->name }}" 
                                             class="rounded-circle" 
                                             style="width: 40px; height: 40px; object-fit: cover;">
                                    @else
                                        <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                             style="width: 40px; height: 40px; background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; font-weight: bold;">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <strong>{{ $user->name }}</strong>
                                </td>
                                <td>
                                    <span class="badge badge-light">{{ $user->username }}</span>
                                </td>
                                <td>
                                    <a href="mailto:{{ $user->email }}" class="text-decoration-none">
                                        <i class="fas fa-envelope text-muted"></i> {{ $user->email }}
                                    </a>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="{{route('users.show', $user->username)}}" 
                                           class="btn btn-sm me-2" 
                                           style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.25rem 0.5rem; margin-right: 8px;"
                                           title="View User">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                        <a href="{{route('users.edit', $user->username)}}" 
                                           class="btn btn-sm me-2" 
                                           style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.25rem 0.5rem; margin-right: 8px;"
                                           title="Edit User">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <a href="{{route('users.change-password', $user->username)}}" 
                                           class="btn btn-sm" 
                                           style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.25rem 0.5rem;"
                                           title="Change Password">
                                            <i class="fas fa-key"></i> Change Password
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fas fa-users fa-3x mb-3"></i>
                                        <h5>No staff users found</h5>
                                        @if(request('search'))
                                            <p>No users match your search criteria: "<strong>{{ request('search') }}</strong>"</p>
                                            <a href="{{ route('users.index') }}" class="btn" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                                                <i class="fas fa-times"></i> Clear Search
                                            </a>
                                        @else
                                            <p>Start by adding your first staff user.</p>
                                            <a href="{{route('users.create')}}" class="btn" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                                                <i class="fas fa-plus"></i> Add First User
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($users->hasPages())
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div>
                        <small class="text-muted">
                            Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} results
                        </small>
                    </div>
                    <div>
                        {{ $users->appends(request()->query())->links() }}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
/* Custom pagination styling */
.pagination .page-link {
    background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%);
    color: white;
    border: none;
    margin: 0 2px;
    border-radius: 6px;
}

.pagination .page-link:hover {
    background: linear-gradient(135deg, #5a32a3 0%, #0056b3 100%);
    color: white;
}

.pagination .page-item.active .page-link {
    background: linear-gradient(135deg, #5a32a3 0%, #0056b3 100%);
    border-color: transparent;
}

.pagination .page-item.disabled .page-link {
    background: #e9ecef;
    color: #6c757d;
}

/* Table hover effects */
.table-hover tbody tr:hover {
    background-color: rgba(111, 66, 193, 0.05);
}

/* Profile image hover effect */
.table tbody tr:hover img,
.table tbody tr:hover .rounded-circle {
    transform: scale(1.1);
    transition: transform 0.2s ease;
}
</style>
@endsection