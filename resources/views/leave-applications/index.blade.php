@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i>
                        <strong>My Leave Applications</strong>
                        <small>Submit and manage your leave requests</small>
                        
                        <div class="card-header-actions">
                            <a href="{{ route('leave-applications.create') }}" class="btn btn-sm btn-primary gradient-btn">
                                <i class="cil-plus"></i> Apply for Leave
                            </a>
                        </div>
                    </div>
                    
                    <div class="card-body">
                        <!-- Search and Filter Form -->
                        <form method="GET" action="{{ route('leave-applications.index') }}" class="mb-4">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <input type="text" name="search" class="form-control" 
                                               placeholder="Search leave type, reason..." 
                                               value="{{ request('search') }}">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-primary" type="submit">
                                                <i class="cil-magnifying-glass"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <select name="status" class="form-control">
                                        <option value="">All Status</option>
                                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                </div>
                                
                                <div class="col-md-3">
                                    <select name="leave_type" class="form-control">
                                        <option value="">All Leave Types</option>
                                        @foreach($leaveTypes as $type)
                                            <option value="{{ $type->id }}" {{ request('leave_type') == $type->id ? 'selected' : '' }}>
                                                {{ $type->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="col-md-2">
                                    <a href="{{ route('leave-applications.index') }}" class="btn btn-outline-secondary">
                                        <i class="cil-x"></i> Clear
                                    </a>
                                </div>
                            </div>
                        </form>

                        <!-- Results Summary -->
                        @if($leaveApplications->total() > 0)
                            <div class="mb-3">
                                <small class="text-muted">
                                    Showing {{ $leaveApplications->firstItem() }} to {{ $leaveApplications->lastItem() }} 
                                    of {{ $leaveApplications->total() }} applications
                                </small>
                            </div>
                        @endif

                        <!-- Leave Applications Table -->
                        @if($leaveApplications->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Leave Type</th>
                                            <th>Duration</th>
                                            <th>Dates</th>
                                            <th>Status</th>
                                            <th>Applied On</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($leaveApplications as $application)
                                            <tr>
                                                <td>
                                                    <span class="badge" style="background-color: {{ $application->leaveType->color }}; color: white;">
                                                        {{ $application->leaveType->name }}
                                                    </span>
                                                </td>
                                                <td>{{ $application->duration }}</td>
                                                <td>
                                                    <div>
                                                        <strong>{{ $application->start_date->format('M d, Y') }}</strong>
                                                        @if($application->start_date->format('Y-m-d') !== $application->end_date->format('Y-m-d'))
                                                            <br><small class="text-muted">to {{ $application->end_date->format('M d, Y') }}</small>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="badge {{ $application->status_badge_class }}">
                                                        {{ $application->formatted_status }}
                                                    </span>
                                                </td>
                                                <td>{{ $application->created_at->format('M d, Y') }}</td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <a href="{{ route('leave-applications.show', $application) }}" 
                                                           class="btn btn-sm btn-info" title="View Details">
                                                            <i class="cil-eye"></i>
                                                        </a>
                                                        
                                                        @if($application->status === 'pending')
                                                            <a href="{{ route('leave-applications.edit', $application) }}" 
                                                               class="btn btn-sm btn-warning" title="Edit">
                                                                <i class="cil-pencil"></i>
                                                            </a>
                                                            
                                                            <form method="POST" action="{{ route('leave-applications.cancel', $application) }}" style="display: inline;">
                                                                @csrf
                                                                <button type="submit" class="btn btn-sm btn-secondary" title="Cancel" 
                                                                        onclick="return confirm('Are you sure you want to cancel this application?')">
                                                                    <i class="cil-ban"></i>
                                                                </button>
                                                            </form>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div class="d-flex justify-content-center">
                                {{ $leaveApplications->appends(request()->query())->links() }}
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="cil-calendar" style="font-size: 3rem; color: #ccc;"></i>
                                <h5 class="mt-3">No Leave Applications Found</h5>
                                <p class="text-muted">
                                    @if(request()->hasAny(['search', 'status', 'leave_type']))
                                        No applications match your current filters.
                                    @else
                                        You haven't submitted any leave applications yet.
                                    @endif
                                </p>
                                <a href="{{ route('leave-applications.create') }}" class="btn btn-primary gradient-btn">
                                    <i class="cil-plus"></i> Apply for Leave
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<style>
:root {
    --primary-color: #667eea;
    --secondary-color: #764ba2;
    --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --hover-gradient: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
    --success-gradient: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
    --danger-gradient: linear-gradient(135deg, #fc466b 0%, #3f5efb 100%);
    --warning-gradient: linear-gradient(135deg, #fdbb2d 0%, #22c1c3 100%);
}

/* Primary button with gradient */
.btn-primary, .gradient-btn {
    background: var(--primary-gradient) !important;
    border: none !important;
    color: white !important;
    transition: all 0.3s ease;
}

.btn-primary:hover, .gradient-btn:hover {
    background: var(--hover-gradient) !important;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
    color: white !important;
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

.badge-secondary {
    background: linear-gradient(135deg, #6c757d 0%, #495057 100%) !important;
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

/* Warning button styling */
.btn-warning {
    background: var(--warning-gradient) !important;
    border: none !important;
    color: white !important;
    transition: all 0.3s ease;
}

.btn-warning:hover {
    background: linear-gradient(135deg, #e6a82d 0%, #1fb3b6 100%) !important;
    transform: translateY(-1px);
    color: white !important;
}

/* Success button styling */
.btn-success {
    background: var(--success-gradient) !important;
    border: none !important;
    color: white !important;
    transition: all 0.3s ease;
}

.btn-success:hover {
    background: linear-gradient(135deg, #0e8a7f 0%, #32d470 100%) !important;
    transform: translateY(-1px);
    color: white !important;
}

/* Danger button styling */
.btn-danger {
    background: var(--danger-gradient) !important;
    border: none !important;
    color: white !important;
    transition: all 0.3s ease;
}

.btn-danger:hover {
    background: linear-gradient(135deg, #e63e5f 0%, #3651e8 100%) !important;
    transform: translateY(-1px);
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
    background: linear-gradient(135deg, #5a6268 0%, #3d424a 100%) !important;
    transform: translateY(-1px);
    color: white !important;
}
</style>
