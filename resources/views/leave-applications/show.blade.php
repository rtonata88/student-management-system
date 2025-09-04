@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-eye"></i>
                        <strong>Leave Application Details</strong>
                        <small>View leave request information</small>
                        
                        <div class="card-header-actions">
                            <a href="{{ route('leave-applications.index') }}" class="btn btn-sm btn-secondary">
                                <i class="cil-arrow-left"></i> Back to Applications
                            </a>
                        </div>
                    </div>
                    
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><strong>Employee:</strong></label>
                                    <p>{{ $leaveApplication->user->name }}</p>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><strong>Leave Type:</strong></label>
                                    <p>
                                        <span class="badge" style="background-color: {{ $leaveApplication->leaveType->color }}; color: white;">
                                            {{ $leaveApplication->leaveType->name }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><strong>Start Date:</strong></label>
                                    <p>{{ $leaveApplication->start_date->format('M d, Y') }}</p>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><strong>End Date:</strong></label>
                                    <p>{{ $leaveApplication->end_date->format('M d, Y') }}</p>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label><strong>Duration:</strong></label>
                                    <p>{{ $leaveApplication->duration }}</p>
                                </div>
                            </div>
                        </div>
                        
                        @if($leaveApplication->is_half_day)
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><strong>Half Day Period:</strong></label>
                                        <p>{{ ucfirst($leaveApplication->half_day_period) }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><strong>Status:</strong></label>
                                    <p>
                                        <span class="badge {{ $leaveApplication->status_badge_class }}">
                                            {{ $leaveApplication->formatted_status }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><strong>Applied On:</strong></label>
                                    <p>{{ $leaveApplication->created_at->format('M d, Y \a\t g:i A') }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label><strong>Reason:</strong></label>
                            <p>{{ $leaveApplication->reason }}</p>
                        </div>
                        
                        @if($leaveApplication->admin_comments)
                            <div class="form-group">
                                <label><strong>Admin Comments:</strong></label>
                                <p>{{ $leaveApplication->admin_comments }}</p>
                            </div>
                        @endif
                        
                        @if($leaveApplication->approver)
                            <div class="form-group">
                                <label><strong>{{ $leaveApplication->status === 'approved' ? 'Approved' : 'Processed' }} By:</strong></label>
                                <p>{{ $leaveApplication->approver->name }}</p>
                            </div>
                        @endif
                        
                        @if($leaveApplication->attachment)
                            <div class="form-group">
                                <label><strong>Attachment:</strong></label>
                                <p>
                                    <a href="{{ Storage::url($leaveApplication->attachment) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class="cil-cloud-download"></i> Download Attachment
                                    </a>
                                </p>
                            </div>
                        @endif
                        
                        <div class="form-group mt-4">
                            @if($leaveApplication->status === 'pending')
                                <a href="{{ route('leave-applications.edit', $leaveApplication) }}" class="btn btn-warning gradient-btn me-1">
                                    <i class="cil-pencil"></i> Edit Application
                                </a>
                                
                                <form method="POST" action="{{ route('leave-applications.cancel', $leaveApplication) }}" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-secondary me-1" 
                                            onclick="return confirm('Are you sure you want to cancel this application?')">
                                        <i class="cil-ban"></i> Cancel Application
                                    </button>
                                </form>
                            @endif
                            
                            <a href="{{ route('leave-applications.index') }}" class="btn btn-secondary">
                                <i class="cil-arrow-left"></i> Back to Applications
                            </a>
                        </div>
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

/* Outline button styling */
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
</style>
