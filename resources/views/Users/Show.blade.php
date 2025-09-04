@extends('layouts.app')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Access Management</li>
        <li class="breadcrumb-item"><a href="{{route('users.index')}}">Users</a></li>
        <li class="breadcrumb-item active">Non-Staff Users</li>
        <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Header Section with Title, Filters and Back Button -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div class="mb-2 mb-md-0">
                    <h2 class="mb-1">Non-Staff Users Management</h2>
                    <p class="text-muted mb-0">Manage passwords for students and other non-staff users</p>
                </div>
                <div class="d-flex align-items-center flex-wrap gap-2">
                    <!-- Search Filters -->
                    <form method="GET" action="{{ route('users.show') }}" class="d-flex align-items-center flex-wrap gap-2 me-3">
                        <div class="input-group" style="width: 200px;">
                            <input type="text" name="search" class="form-control form-control-sm" placeholder="Search users..." value="{{ request('search') }}">
                        </div>
                        <button type="submit" class="btn btn-sm btn-outline-primary">
                            <i class="fa fa-search"></i> Search
                        </button>
                        @if(request('search'))
                        <a href="{{ route('users.show') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="fa fa-refresh"></i> Clear
                        </a>
                        @endif
                    </form>
                    
                    <!-- Back Button -->
                    <a href="{{ route('users.index') }}" class="btn btn-primary btn-sm">
                        <i class="fa fa-arrow-left"></i> Back to Staff Users
                    </a>
                </div>
            </div>
        </div>
    </div>

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

    <!-- Main Content Card -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" style="width:100%">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0 ps-3">USERNAME</th>
                                    <th class="border-0">FULL NAME</th>
                                    <th class="border-0">EMAIL ADDRESS</th>
                                    <th class="border-0">USER TYPE</th>
                                    <th class="border-0">CREATED</th>
                                    <th class="border-0 text-center">PASSWORD RESET</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $user)
                                <tr class="border-bottom">
                                    <td class="ps-3 py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle d-flex align-items-center justify-content-center me-3" 
                                                 style="width: 40px; height: 40px; background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; font-weight: bold;">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                            <strong class="text-primary">{{ $user->username }}</strong>
                                        </div>
                                    </td>
                                    <td class="py-3">{{ $user->name }}</td>
                                    <td class="py-3">
                                        @if($user->email)
                                            <a href="mailto:{{ $user->email }}" class="text-decoration-none">
                                                {{ $user->email }}
                                            </a>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="py-3">
                                        <span class="badge badge-info">{{ ucfirst($user->user_type ?? 'Unknown') }}</span>
                                    </td>
                                    <td class="py-3">
                                        @if($user->created_at)
                                            {{ $user->created_at->format('Y-m-d') }}
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="py-3 text-center">
                                        @permission('reset-student-passwords')
                                        <a href="{{route('users.reset-student-password', $user->username)}}" 
                                           class="btn btn-sm btn-primary"
                                           title="Reset Password">
                                            <i class="fas fa-key"></i> Password Reset
                                        </a>
                                        @endpermission
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="fa fa-users fa-3x mb-3"></i>
                                            <h5>No Non-Staff Users Found</h5>
                                            @if(request('search'))
                                                <p>No users match your search criteria: "<strong>{{ request('search') }}</strong>"</p>
                                                <a href="{{ route('users.show') }}" class="btn btn-primary">
                                                    <i class="fa fa-times"></i> Clear Search
                                                </a>
                                            @else
                                                <p>There are no non-staff users in the system yet.</p>
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
                    <div class="card-footer bg-light border-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-muted">
                                Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} results
                            </div>
                            <div>
                                {{$users->links()}}
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
:root {
    --primary-gradient: linear-gradient(135deg, #6f42c1 0%, #007bff 100%);
    --primary-color: #6f42c1;
    --secondary-color: #007bff;
    --hover-gradient: linear-gradient(135deg, #5a32a3 0%, #0056b3 100%);
}

.gap-2 {
    gap: 0.5rem;
}

.table-hover tbody tr:hover {
    background-color: rgba(0,0,0,.02);
}

/* Primary button with gradient */
.btn-primary {
    background: var(--primary-gradient) !important;
    border: none !important;
    color: white !important;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    background: var(--hover-gradient) !important;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(111, 66, 193, 0.4);
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
    box-shadow: 0 4px 12px rgba(111, 66, 193, 0.3);
}

/* Username styling */
.text-primary {
    background: var(--primary-gradient);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    font-weight: 600 !important;
}

/* Pagination styling */
.pagination .page-link {
    color: var(--primary-color) !important;
    border-color: #dee2e6;
    transition: all 0.3s ease;
}

.pagination .page-link:hover {
    background: var(--primary-gradient) !important;
    border-color: transparent !important;
    color: white !important;
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(111, 66, 193, 0.3);
}

.pagination .page-item.active .page-link {
    background: var(--primary-gradient) !important;
    border-color: transparent !important;
    color: white !important;
}

/* Clear button styling */
.btn-outline-secondary:hover {
    background: linear-gradient(135deg, #6c757d 0%, #495057 100%) !important;
    border-color: transparent !important;
    color: white !important;
    transform: translateY(-1px);
}

/* Profile circle hover effect */
.table tbody tr:hover .rounded-circle {
    transform: scale(1.1);
    transition: transform 0.2s ease;
}

@media (max-width: 768px) {
    .d-flex.flex-wrap .input-group {
        width: 100% !important;
        margin-bottom: 0.5rem;
    }
    .d-flex.flex-wrap .btn {
        margin-bottom: 0.5rem;
    }
}
</style>
@endsection