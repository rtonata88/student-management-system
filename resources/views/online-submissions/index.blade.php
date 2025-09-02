@extends('layouts.app')

@section('breadcrumb')
<div class="c-subheader px-3">
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Application</li>
        <li class="breadcrumb-item active">Online Submissions</li>
    </ol>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4><i class="fas fa-laptop"></i> Online Submissions</h4>
                <small class="text-muted">Manage student applications submitted through the online portal</small>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Filter Form -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h6><i class="fas fa-filter"></i> Filter Applications</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('online-submissions.filter') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select name="status" class="form-control">
                                            <option value="">All Statuses</option>
                                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="under_review" {{ request('status') == 'under_review' ? 'selected' : '' }}>Under Review</option>
                                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Application Number</label>
                                        <input type="text" name="application_number" class="form-control" 
                                               placeholder="Enter application number" value="{{ request('application_number') }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Student Name</label>
                                        <input type="text" name="student_name" class="form-control" 
                                               placeholder="Enter student name" value="{{ request('student_name') }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>&nbsp;</label>
                                        <div>
                                            <button type="submit" class="btn btn-sm" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                                                <i class="fas fa-search"></i> Filter
                                            </button>
                                            <a href="{{ route('online-submissions.index') }}" class="btn btn-sm btn-secondary">
                                                <i class="fas fa-times"></i> Clear
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Date From</label>
                                        <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Date To</label>
                                        <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Applications Table -->
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead style="background-color: #f8f9fa;">
                            <tr>
                                <th>Application #</th>
                                <th>Student Name</th>
                                <th>Email</th>
                                <th>Subjects</th>
                                <th>Documents</th>
                                <th>Status</th>
                                <th>Submitted</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($applications as $application)
                                <tr>
                                    <td>
                                        <strong>{{ $application->application_number }}</strong>
                                    </td>
                                    <td>
                                        {{ $application->user->name }}
                                        @if($application->student)
                                            <br><small class="text-muted">{{ $application->student->student_names }} {{ $application->student->surname }}</small>
                                        @endif
                                    </td>
                                    <td>{{ $application->user->email }}</td>
                                    <td>
                                        <span class="badge badge-info">{{ $application->subjects->count() }} subjects</span>
                                        @if($application->subjects->count() > 0)
                                            <br><small class="text-muted">
                                                {{ $application->subjects->pluck('subject_name')->take(2)->implode(', ') }}
                                                @if($application->subjects->count() > 2)
                                                    ...
                                                @endif
                                            </small>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge badge-secondary">{{ $application->documents->count() }} files</span>
                                        @if($application->documents->where('verified', true)->count() > 0)
                                            <br><small class="text-success">
                                                <i class="fas fa-check"></i> {{ $application->documents->where('verified', true)->count() }} verified
                                            </small>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge {{ $application->getStatusBadgeClass() }}">
                                            {{ $application->getStatusLabel() }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($application->submitted_at)
                                            {{ $application->submitted_at->format('d M Y') }}
                                            <br><small class="text-muted">{{ $application->submitted_at->format('H:i') }}</small>
                                        @else
                                            <span class="text-muted">Not submitted</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('online-submissions.show', $application->id) }}" 
                                               class="btn btn-sm btn-outline-primary" title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @permission('review-online-applications')
                                                @if($application->status !== 'approved')
                                                    <button type="button" class="btn btn-sm btn-outline-success" 
                                                            onclick="updateStatus({{ $application->id }}, 'approved')" title="Approve">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                @endif
                                                @if($application->status !== 'rejected')
                                                    <button type="button" class="btn btn-sm btn-outline-danger" 
                                                            onclick="updateStatus({{ $application->id }}, 'rejected')" title="Reject">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                @endif
                                            @endpermission
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">
                                        <div class="py-4">
                                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                            <h5 class="text-muted">No applications found</h5>
                                            <p class="text-muted">No online applications match your current filters.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($applications->hasPages())
                    <div class="d-flex justify-content-center">
                        {{ $applications->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Status Update Modal -->
<div class="modal fade" id="statusModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Application Status</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id="statusForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" id="statusSelect" class="form-control" required>
                            <option value="pending">Pending</option>
                            <option value="under_review">Under Review</option>
                            <option value="approved">Approved</option>
                            <option value="rejected">Rejected</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Admin Notes</label>
                        <textarea name="admin_notes" class="form-control" rows="3" 
                                  placeholder="Enter any notes or comments..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                        Update Status
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function updateStatus(applicationId, status) {
    const modal = $('#statusModal');
    const form = $('#statusForm');
    
    form.attr('action', `/online-submissions/${applicationId}/update-status`);
    $('#statusSelect').val(status);
    
    modal.modal('show');
}
</script>
@endsection
