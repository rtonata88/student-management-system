@extends('layouts.app')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Access Management</li>
        <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Users</a></li>
        <li class="breadcrumb-item">Reset Students</li>
        <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-key"></i> Reset Student & Parent Passwords</h5>
                <a href="{{ route('users.index') }}" class="btn" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                    <i class="fas fa-arrow-left"></i> Back to Users
                </a>
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

                @if(Session::has('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle"></i> {{ Session::get('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif

                <!-- Search Form -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <form method="GET" action="{{ route('users.reset-students') }}" class="d-flex">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                                </div>
                                <input type="text" name="search" class="form-control" placeholder="Search by name, username, email, or student number..." value="{{ request('search') }}">
                                <div class="input-group-append">
                                    <button class="btn" type="submit" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 0 6px 6px 0;">
                                        <i class="fas fa-search"></i> Search
                                    </button>
                                    @if(request('search'))
                                    <a href="{{ route('users.reset-students') }}" class="btn" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: white; border: none; border-radius: 0; margin-left: 2px;">
                                        <i class="fas fa-times"></i> Clear
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-6 text-right">
                        <small class="text-muted">
                            Showing {{ $students->firstItem() ?? 0 }} to {{ $students->lastItem() ?? 0 }} of {{ $students->total() }} results
                        </small>
                    </div>
                </div>

                <!-- Students Table -->
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th>Profile</th>
                                <th>Full Name</th>
                                <th>Student Number</th>
                                <th>Centre</th>
                                <th>User Type</th>
                                <th>Registration Status</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($students as $student)
                            <tr>
                                <td>
                                    @if($student->photo)
                                        <img src="{{ asset('storage/' . $student->photo) }}" 
                                             alt="{{ $student->name }}" 
                                             class="rounded-circle"
                                             style="width: 40px; height: 40px; object-fit: cover; border: 2px solid #ddd;">
                                    @else
                                        <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                             style="width: 40px; height: 40px; background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; font-weight: bold;">
                                            {{ strtoupper(substr($student->name, 0, 1)) }}
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <strong>{{ $student->name }}</strong>
                                </td>
                                <td>
                                    @if($student->student_number)
                                        <div>
                                            <span class="badge badge-light" style="background-color: #f8f9fa; color: #495057; border: 1px solid #dee2e6;">{{ $student->student_number }}</span>
                                            @if($student->allocated_number)
                                                <br><small class="text-muted">Allocated: {{ $student->allocated_number }}</small>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($student->center_name)
                                        <span class="badge badge-info">{{ $student->center_name }}</span>
                                    @else
                                        <span class="text-muted">Not assigned</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge {{ $student->user_type == 'student' ? 'badge-success' : 'badge-warning' }}">
                                        {{ ucfirst($student->user_type) }}
                                    </span>
                                </td>
                                <td>
                                    @if($student->current_registration_id)
                                        <span class="badge badge-success">
                                            <i class="fas fa-check-circle"></i> Registered {{ date('Y') }}
                                        </span>
                                    @else
                                        <span class="badge badge-secondary">
                                            <i class="fas fa-times-circle"></i> Not Registered
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge badge-light">{{ $student->username }}</span>
                                </td>
                                <td>
                                    @if($student->email)
                                        <a href="mailto:{{ $student->email }}" class="text-decoration-none">
                                            <i class="fas fa-envelope text-muted"></i> {{ $student->email }}
                                        </a>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @permission('reset-student-passwords')
                                    <a href="{{route('users.reset-student-password', $student->username)}}" 
                                       class="btn btn-sm" 
                                       style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.25rem 0.5rem;"
                                       title="Reset Password">
                                        <i class="fas fa-key"></i> Reset Password
                                    </a>
                                    @endpermission
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fas fa-users fa-3x mb-3"></i>
                                        <h5>No students or parents found</h5>
                                        @if(request('search'))
                                            <p>No users match your search criteria: "<strong>{{ request('search') }}</strong>"</p>
                                            <a href="{{ route('users.reset-students') }}" class="btn" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                                                <i class="fas fa-times"></i> Clear Search
                                            </a>
                                        @else
                                            <p>No students or parents are registered in the system yet.</p>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($students->hasPages())
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div>
                        <small class="text-muted">
                            Showing {{ $students->firstItem() }} to {{ $students->lastItem() }} of {{ $students->total() }} results
                        </small>
                    </div>
                    <div>
                        {{ $students->appends(request()->query())->links() }}
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
.table tbody tr:hover .rounded-circle {
    transform: scale(1.1);
    transition: transform 0.2s ease;
}
</style>
@endsection
