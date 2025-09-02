@extends('layouts.app')

@section('breadcrumb')
<div class="c-subheader px-3">
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Application</li>
        <li class="breadcrumb-item"><a href="{{ route('online-submissions.index') }}">Online Submissions</a></li>
        <li class="breadcrumb-item active">{{ $application->application_number }}</li>
    </ol>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4><i class="fas fa-file-alt"></i> Application Details - {{ $application->application_number }}</h4>
                <div class="float-right">
                    <span class="badge badge-lg {{ $application->getStatusBadgeClass() }}">
                        {{ $application->getStatusLabel() }}
                    </span>
                </div>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Application Overview -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6><i class="fas fa-info-circle"></i> Application Information</h6>
                            </div>
                            <div class="card-body">
                                <table class="table table-sm">
                                    <tr>
                                        <th width="40%">Application Number:</th>
                                        <td>{{ $application->application_number }}</td>
                                    </tr>
                                    <tr>
                                        <th>Status:</th>
                                        <td>
                                            <span class="badge {{ $application->getStatusBadgeClass() }}">
                                                {{ $application->getStatusLabel() }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Created:</th>
                                        <td>{{ $application->created_at->format('d M Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Submitted:</th>
                                        <td>
                                            @if($application->submitted_at)
                                                {{ $application->submitted_at->format('d M Y H:i') }}
                                            @else
                                                <span class="text-muted">Not submitted</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @if($application->reviewed_at)
                                        <tr>
                                            <th>Reviewed:</th>
                                            <td>{{ $application->reviewed_at->format('d M Y H:i') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Reviewed By:</th>
                                            <td>{{ $application->reviewer->name ?? 'Unknown' }}</td>
                                        </tr>
                                    @endif
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6><i class="fas fa-user"></i> Student Information</h6>
                            </div>
                            <div class="card-body">
                                <table class="table table-sm">
                                    <tr>
                                        <th width="40%">Name:</th>
                                        <td>{{ $application->user->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Email:</th>
                                        <td>{{ $application->user->email }}</td>
                                    </tr>
                                    @if($application->student)
                                        <tr>
                                            <th>Full Name:</th>
                                            <td>{{ $application->student->student_names }} {{ $application->student->surname }}</td>
                                        </tr>
                                        <tr>
                                            <th>Contact:</th>
                                            <td>{{ $application->student->contact_number }}</td>
                                        </tr>
                                        <tr>
                                            <th>Gender:</th>
                                            <td>{{ $application->student->gender }}</td>
                                        </tr>
                                    @endif
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Selected Subjects -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h6><i class="fas fa-book"></i> Selected Subjects ({{ $application->subjects->count() }})</h6>
                    </div>
                    <div class="card-body">
                        @if($application->subjects->isNotEmpty())
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm">
                                    <thead style="background-color: #f8f9fa;">
                                        <tr>
                                            <th>Subject Name</th>
                                            <th>Subject Code</th>
                                            <th>Subject Fee</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $totalFee = 0; @endphp
                                        @foreach($application->subjects as $subject)
                                            <tr>
                                                <td>{{ $subject->subject_name }}</td>
                                                <td>{{ $subject->subject_code }}</td>
                                                <td>R{{ number_format($subject->subject_fees, 2) }}</td>
                                            </tr>
                                            @php $totalFee += $subject->subject_fees; @endphp
                                        @endforeach
                                    </tbody>
                                    <tfoot style="background-color: #f8f9fa;">
                                        <tr>
                                            <th colspan="2">Total Fee</th>
                                            <th>R{{ number_format($totalFee, 2) }}</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        @else
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle"></i> No subjects selected
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Uploaded Documents -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h6><i class="fas fa-file-alt"></i> Uploaded Documents ({{ $application->documents->count() }})</h6>
                    </div>
                    <div class="card-body">
                        @if($application->documents->isNotEmpty())
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm">
                                    <thead style="background-color: #f8f9fa;">
                                        <tr>
                                            <th>Document Type</th>
                                            <th>Document Name</th>
                                            <th>File Size</th>
                                            <th>Upload Date</th>
                                            <th>Verified</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($application->documents as $document)
                                            <tr>
                                                <td>
                                                    <span class="badge badge-primary">{{ $document->getDocumentTypeLabel() }}</span>
                                                </td>
                                                <td>{{ $document->document_name }}</td>
                                                <td>{{ $document->getFileSizeFormatted() }}</td>
                                                <td>{{ $document->created_at->format('d M Y H:i') }}</td>
                                                <td>
                                                    @if($document->verified)
                                                        <span class="badge badge-success">
                                                            <i class="fas fa-check"></i> Verified
                                                        </span>
                                                        @if($document->verified_at)
                                                            <br><small class="text-muted">{{ $document->verified_at->format('d M Y') }}</small>
                                                        @endif
                                                    @else
                                                        <span class="badge badge-warning">Pending</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        @permission('download-application-documents')
                                                            <a href="{{ route('online-submissions.download-document', $document->id) }}" 
                                                               class="btn btn-sm btn-outline-primary" title="Download">
                                                                <i class="fas fa-download"></i>
                                                            </a>
                                                        @endpermission
                                                        @permission('verify-application-documents')
                                                            <button type="button" class="btn btn-sm btn-outline-{{ $document->verified ? 'warning' : 'success' }}" 
                                                                    onclick="verifyDocument({{ $document->id }}, {{ $document->verified ? 'false' : 'true' }})" 
                                                                    title="{{ $document->verified ? 'Unverify' : 'Verify' }}">
                                                                <i class="fas fa-{{ $document->verified ? 'times' : 'check' }}"></i>
                                                            </button>
                                                        @endpermission
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle"></i> No documents uploaded
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Admin Notes -->
                @if($application->admin_notes)
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6><i class="fas fa-sticky-note"></i> Admin Notes</h6>
                        </div>
                        <div class="card-body">
                            <p>{{ $application->admin_notes }}</p>
                        </div>
                    </div>
                @endif

                <!-- Actions -->
                <div class="card">
                    <div class="card-footer text-center">
                        @permission('review-online-applications')
                            <button type="button" class="btn btn-success mr-2" onclick="updateStatus({{ $application->id }}, 'approved')">
                                <i class="fas fa-check"></i> Approve Application
                            </button>
                            <button type="button" class="btn btn-danger mr-2" onclick="updateStatus({{ $application->id }}, 'rejected')">
                                <i class="fas fa-times"></i> Reject Application
                            </button>
                            <button type="button" class="btn" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;" onclick="updateStatus({{ $application->id }}, 'under_review')">
                                <i class="fas fa-eye"></i> Mark Under Review
                            </button>
                        @endpermission
                        <a href="{{ route('online-submissions.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>
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
                                  placeholder="Enter any notes or comments...">{{ $application->admin_notes }}</textarea>
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

<!-- Document Verification Modal -->
<div class="modal fade" id="verifyModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Document Verification</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id="verifyForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Verification Status</label>
                        <select name="verified" id="verifiedSelect" class="form-control" required>
                            <option value="1">Verified</option>
                            <option value="0">Not Verified</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Verification Notes</label>
                        <textarea name="verification_notes" class="form-control" rows="3" 
                                  placeholder="Enter verification notes..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                        Update Verification
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

function verifyDocument(documentId, verified) {
    const modal = $('#verifyModal');
    const form = $('#verifyForm');
    
    form.attr('action', `/online-submissions/documents/${documentId}/verify`);
    $('#verifiedSelect').val(verified ? '1' : '0');
    
    modal.modal('show');
}
</script>
@endsection
