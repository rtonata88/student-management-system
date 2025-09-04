@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-eye"></i>
                        <strong>Leave Request Details</strong>
                        <small>View leave request information</small>
                        
                        <div class="card-header-actions">
                            <a href="{{ route('leave-management.index') }}" class="btn btn-sm btn-secondary">
                                <i class="cil-arrow-left"></i> Back to Leave Management
                            </a>
                        </div>
                    </div>
                    
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Employee Information</h5>
                                <table class="table table-borderless">
                                    <tr>
                                        <td><strong>Name:</strong></td>
                                        <td>{{ $leaveRequest->user->name }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Email:</strong></td>
                                        <td>{{ $leaveRequest->user->email }}</td>
                                    </tr>
                                </table>
                            </div>
                            
                            <div class="col-md-6">
                                <h5>Leave Details</h5>
                                <table class="table table-borderless">
                                    <tr>
                                        <td><strong>Leave Type:</strong></td>
                                        <td>
                                            <span class="badge" style="background-color: {{ $leaveRequest->leaveType->color }}; color: white;">
                                                {{ $leaveRequest->leaveType->name }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Duration:</strong></td>
                                        <td>{{ $leaveRequest->duration }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Status:</strong></td>
                                        <td>
                                            <span class="badge {{ $leaveRequest->status_badge_class }}">
                                                {{ $leaveRequest->formatted_status }}
                                            </span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <h5>Dates</h5>
                                <table class="table table-borderless">
                                    <tr>
                                        <td><strong>Start Date:</strong></td>
                                        <td>{{ $leaveRequest->start_date->format('M d, Y') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>End Date:</strong></td>
                                        <td>{{ $leaveRequest->end_date->format('M d, Y') }}</td>
                                    </tr>
                                    @if($leaveRequest->is_half_day)
                                    <tr>
                                        <td><strong>Half Day Period:</strong></td>
                                        <td>{{ ucfirst($leaveRequest->half_day_period) }}</td>
                                    </tr>
                                    @endif
                                </table>
                            </div>
                            
                            <div class="col-md-6">
                                <h5>Application Details</h5>
                                <table class="table table-borderless">
                                    <tr>
                                        <td><strong>Applied On:</strong></td>
                                        <td>{{ $leaveRequest->created_at->format('M d, Y') }}</td>
                                    </tr>
                                    @if($leaveRequest->approved_by)
                                    <tr>
                                        <td><strong>{{ $leaveRequest->status === 'approved' ? 'Approved' : 'Processed' }} By:</strong></td>
                                        <td>{{ $leaveRequest->approver->name }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>{{ $leaveRequest->status === 'approved' ? 'Approved' : 'Processed' }} On:</strong></td>
                                        <td>{{ $leaveRequest->approved_at->format('M d, Y') }}</td>
                                    </tr>
                                    @endif
                                </table>
                            </div>
                        </div>
                        
                        <div class="row mt-4">
                            <div class="col-12">
                                <h5>Reason for Leave</h5>
                                <div class="card">
                                    <div class="card-body">
                                        {{ $leaveRequest->reason }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        @if($leaveRequest->admin_comments)
                        <div class="row mt-4">
                            <div class="col-12">
                                <h5>Admin Comments</h5>
                                <div class="card">
                                    <div class="card-body">
                                        {{ $leaveRequest->admin_comments }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        
                        @if($leaveRequest->attachment)
                        <div class="row mt-4">
                            <div class="col-12">
                                <h5>Supporting Document</h5>
                                <div class="card">
                                    <div class="card-body">
                                        <a href="{{ asset('storage/' . $leaveRequest->attachment) }}" target="_blank" class="btn btn-outline-primary">
                                            <i class="cil-cloud-download"></i> Download Attachment
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="d-flex gap-2">
                                    @if($leaveRequest->status === 'pending')
                                        <form method="POST" action="{{ route('leave-management.approve', $leaveRequest) }}" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-success" title="Approve">
                                                <i class="cil-check"></i> Approve
                                            </button>
                                        </form>
                                        
                                        <form method="POST" action="{{ route('leave-management.reject', $leaveRequest) }}" style="display: inline;">
                                            @csrf
                                            <input type="hidden" name="admin_comments" value="Rejected by admin">
                                            <button type="submit" class="btn btn-danger" title="Reject">
                                                <i class="cil-x"></i> Reject
                                            </button>
                                        </form>
                                    @endif
                                    
                                    <a href="{{ route('leave-management.edit', $leaveRequest) }}" class="btn btn-warning">
                                        <i class="cil-pencil"></i> Edit
                                    </a>
                                    
                                    <a href="{{ route('leave-management.index') }}" class="btn btn-secondary">
                                        <i class="cil-arrow-left"></i> Back
                                    </a>
                                </div>
                            </div>
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
    --success-gradient: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
    --danger-gradient: linear-gradient(135deg, #fc466b 0%, #3f5efb 100%);
    --warning-gradient: linear-gradient(135deg, #fdbb2d 0%, #22c1c3 100%);
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
