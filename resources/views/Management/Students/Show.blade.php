@extends('layouts.app')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Management</li>
        @if(isset($returnUrl) && $returnUrl === 'manual-admissions')
        <li class="breadcrumb-item"><a href="/manual-admissions">Manual Admissions</a></li>
        @else
        <li class="breadcrumb-item"><a href="/students">Student Info </a></li>
        @endif
        <li class="breadcrumb-item active">{{$student->student_names}} {{$student->surname}}</li>
        <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-2 col-xs-12"></div>
    <div class="col-md-8 col-xs-12">
        <div class="card">
            <div class="card-header">
                <strong>Student information</strong> | <a href="{{route('students.edit', $student->id)}}{{ isset($returnUrl) ? '?return=' . $returnUrl : '' }}">Edit</a>
            </div>
            <div class="card-body">
                @if($student->photo)
                    <div class="student-photo mb-4 text-center">
                        <img src="{{ asset('storage/' . $student->photo) }}" alt="{{$student->student_names}} {{$student->surname}}" 
                             style="max-width: 200px; max-height: 200px; border: 2px solid #ddd; border-radius: 8px; padding: 10px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                        <p class="small text-muted mt-2 mb-0">Student Photo</p>
                    </div>
                @endif
                <table class="table table-responsive-sm table-bordered table-sm" style="width:100%">
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5);width:250px;">Student Number </th>
                        <td>{{$student->student_number}}</td>
                    </tr>
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5);width:250px;">Allocated Number </th>
                        <td>{{$student->student_number2}}</td>
                    </tr>
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">Student names </th>
                        <td>{{$student->student_names}}</td>
                    </tr>
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">Surname </th>
                        <td>{{$student->surname}}</td>
                    </tr>
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">Initials </th>
                        <td>{{$student->initials}}</td>
                    </tr>
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">Center </th>
                        <td>
                            @if($student->center)
                                {{$student->center->center_name}}
                            @else
                                <span class="text-muted">Not assigned</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">Email </th>
                        <td>{{$student->contact_email}}</td>
                    </tr>
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">Contact number </th>
                        <td>{{$student->contact_number}}</td>
                    </tr>
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">Gender </th>
                        <td>{{$student->gender}}</td>
                    </tr>
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">Date of Birth</th>
                        <td>{{$student->date_of_birth}}</td>
                    </tr>
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">Birth Certificate</th>
                        <td>{{$student->birth_certificate}}</td>
                    </tr>
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">ID Number </th>
                        <td>{{$student->id_number}}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <strong>Guardian information</strong>
            </div>
            <div class="card-body qualifications-table">
                @foreach($student->guardian as $guardian)
                <table class="table table-responsive-sm table-bordered table-sm" style="width:100%">
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5); width:250px;">Name </th>
                        <td>{{$guardian->guardian_names}}</td>
                    </tr>
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">Surname </th>
                        <td>{{$guardian->surname}}</td>
                    </tr>
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">Relationship </th>
                        <td>{{$guardian->relationship}}</td>
                    </tr>
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">Contact number </th>
                        <td>{{$guardian->contact_number}}</td>
                    </tr>
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">Contact email </th>
                        <td>{{$guardian->contact_email}}</td>
                    </tr>
                </table>
                @endforeach
            </div>
            <!--
                UNCOMMENT this line if you wish to add more than one guardian 
                <div class="card-body" id="guardian-section">
            </div> 
            <div class="card-footer">
                <button typ="button" class="btn btn-sm btn-primary" id="add-qualification-btn">Add qualification</button>
            </div>-->
            <div class="card-footer">
                <a href="/students">Back</a>
            </div>
        </div>

        <!-- Selected Subjects Section -->
        <div class="card">
            <div class="card-header">
                <strong><i class="fas fa-book"></i> Selected Subjects</strong>
                <small class="text-muted ml-2">Student's enrolled subjects</small>
            </div>
            <div class="card-body">
                @if(isset($studentSubjects) && $studentSubjects->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                                <tr>
                                    <th>Subject</th>
                                    <th>Code</th>
                                    <th class="text-right">Monthly Fee</th>
                                    <th class="text-center">Credits</th>
                                    <th class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $totalFee = 0; $totalCredits = 0; @endphp
                                @foreach($studentSubjects as $studentSubject)
                                    @php 
                                        $subject = $studentSubject->subject ?? $studentSubject->module;
                                        $totalFee += $subject->subject_fees ?? 0;
                                        $totalCredits += $subject->credits ?? 3;
                                    @endphp
                                    <tr style="transition: all 0.3s ease;">
                                        <td class="align-middle">
                                            <div class="d-flex align-items-center">
                                                <div class="subject-icon me-3" style="width: 35px; height: 35px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 6px; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; margin-right: 12px; font-size: 0.8rem;">
                                                    {{ substr($subject->subject_name, 0, 1) }}
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">{{ $subject->subject_name }}</h6>
                                                    <small class="text-muted">{{ $subject->description ?? 'No description available' }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-middle">
                                            <span class="badge badge-light" style="background: #f8f9fa; color: #495057; padding: 4px 8px; border-radius: 4px;">
                                                {{ $subject->subject_code }}
                                            </span>
                                        </td>
                                        <td class="align-middle text-right">
                                            <span style="font-weight: 600; color: #28a745;">
                                                N${{ number_format($subject->subject_fees ?? 0, 2) }}
                                            </span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="badge badge-info" style="background: #17a2b8; padding: 4px 8px; border-radius: 4px;">
                                                {{ $subject->credits ?? 3 }}
                                            </span>
                                        </td>
                                        <td class="text-center align-middle">
                                            @php
                                                $status = $studentSubject->status ?? 'applied';
                                                $statusConfig = [
                                                    'applied' => ['class' => 'badge-warning', 'icon' => 'fas fa-clock', 'text' => 'Applied'],
                                                    'admitted' => ['class' => 'badge-info', 'icon' => 'fas fa-check', 'text' => 'Admitted'],
                                                    'registered' => ['class' => 'badge-success', 'icon' => 'fas fa-check-circle', 'text' => 'Registered']
                                                ];
                                                $config = $statusConfig[$status] ?? $statusConfig['applied'];
                                            @endphp
                                            <span class="badge {{ $config['class'] }}">
                                                <i class="{{ $config['icon'] }}"></i> {{ $config['text'] }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-3 p-3" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 8px; border-left: 4px solid #667eea;">
                        <h6><i class="fas fa-calculator"></i> Subject Summary</h6>
                        <div class="row">
                            <div class="col-md-4">
                                <p class="mb-1"><strong>Total Subjects:</strong> {{ $studentSubjects->count() }}</p>
                            </div>
                            <div class="col-md-4">
                                <p class="mb-1"><strong>Total Credits:</strong> {{ $totalCredits }}</p>
                            </div>
                            <div class="col-md-4">
                                <p class="mb-1"><strong>Total Monthly Fee:</strong> N${{ number_format($totalFee, 2) }}</p>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-book-open fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No Subjects Selected</h5>
                        <p class="text-muted">This student has not been enrolled in any subjects yet.</p>
                        @permission('edit-student')
                            <a href="{{ route('students.edit', $student->id) }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Add Subjects
                            </a>
                        @endpermission
                    </div>
                @endif
            </div>
        </div>

        <!-- Student Documents Section -->
        <div class="card">
            <div class="card-header">
                <strong><i class="fas fa-file-alt"></i> Student Documents</strong>
                <small class="text-muted ml-2">Uploaded documents and certificates</small>
            </div>
            <div class="card-body">
                @if(isset($studentDocuments) && $studentDocuments->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead style="background-color: #f8f9fa;">
                                <tr>
                                    <th>Document Type</th>
                                    <th>Document Name</th>
                                    <th>File Info</th>
                                    <th>Upload Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($studentDocuments as $document)
                                    <tr>
                                        <td>
                                            <span class="badge badge-primary" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none;">
                                                {{ ucwords(str_replace('_', ' ', $document->document_type)) }}
                                            </span>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-outline-secondary view-document-name" 
                                                    data-document-name="{{ $document->document_name }}"
                                                    data-document-description="{{ $document->document_description ?? '' }}">
                                                <i class="fas fa-eye"></i> View Details
                                            </button>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-file mr-2 text-primary"></i>
                                                <div>
                                                    <div class="font-weight-bold">{{ $document->file_name }}</div>
                                                    <small class="text-muted">
                                                        {{ strtoupper($document->file_type) }} • 
                                                        {{ $document->file_size ? number_format($document->file_size / 1024, 1) . ' KB' : 'Unknown size' }}
                                                    </small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div>{{ \Carbon\Carbon::parse($document->created_at)->format('d M Y') }}</div>
                                            <small class="text-muted">{{ \Carbon\Carbon::parse($document->created_at)->format('H:i') }}</small>
                                        </td>
                                        <td>
                                            @if($document->is_verified)
                                                <span class="badge badge-success">
                                                    <i class="fas fa-check-circle"></i> Verified
                                                </span>
                                            @else
                                                <span class="badge badge-warning">
                                                    <i class="fas fa-clock"></i> Pending
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ asset('storage/' . $document->file_path) }}" target="_blank" 
                                                   class="btn btn-sm btn-outline-primary" title="View Document">
                                                    <i class="fas fa-eye"></i> View
                                                </a>
                                                <a href="{{ asset('storage/' . $document->file_path) }}" download 
                                                   class="btn btn-sm btn-outline-success" title="Download Document">
                                                    <i class="fas fa-download"></i> Download
                                                </a>
                                                @permission('edit-student')
                                                    <button type="button" class="btn btn-sm {{ $document->is_verified ? 'btn-success disabled' : 'btn-outline-info verify-document' }}" 
                                                            data-document-id="{{ $document->id }}" 
                                                            title="{{ $document->is_verified ? 'Document Verified' : 'Mark as Verified' }}"
                                                            {{ $document->is_verified ? 'disabled' : '' }}>
                                                        <i class="fas fa-check"></i> {{ $document->is_verified ? 'Verified' : 'Verify' }}
                                                    </button>
                                                @endpermission
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-3 p-3" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 8px; border-left: 4px solid #28a745;">
                        <h6><i class="fas fa-info-circle"></i> Document Summary</h6>
                        <div class="row">
                            <div class="col-md-4">
                                <p class="mb-1"><strong>Total Documents:</strong> {{ $studentDocuments->count() }}</p>
                            </div>
                            <div class="col-md-4">
                                <p class="mb-1"><strong>Verified:</strong> {{ $studentDocuments->where('is_verified', true)->count() }}</p>
                            </div>
                            <div class="col-md-4">
                                <p class="mb-1"><strong>Pending:</strong> {{ $studentDocuments->where('is_verified', false)->count() }}</p>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-file-upload fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No Documents Uploaded</h5>
                        <p class="text-muted">This student has not uploaded any documents yet.</p>
                        @permission('edit-student')
                            <a href="{{ route('students.edit', $student->id) }}" class="btn btn-primary">
                                <i class="fas fa-upload"></i> Upload Documents
                            </a>
                        @endpermission
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
// Document verification functionality
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('verify-document') || e.target.closest('.verify-document')) {
        const button = e.target.classList.contains('verify-document') ? e.target : e.target.closest('.verify-document');
        const documentId = button.getAttribute('data-document-id');
        
        if (confirm('Mark this document as verified?')) {
            // AJAX call to verify the document
            fetch('/students/verify-document/' + documentId, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    document_id: documentId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update button appearance - make it disabled and green
                    button.className = 'btn btn-sm btn-success disabled';
                    button.disabled = true;
                    button.innerHTML = '<i class="fas fa-check"></i> Verified';
                    button.title = 'Document Verified';
                    
                    // Update status column
                    const statusCell = button.closest('tr').querySelector('td:nth-child(5)');
                    statusCell.innerHTML = '<span class="badge badge-success"><i class="fas fa-check-circle"></i> Verified</span>';
                    
                    // Update document summary counts
                    const verifiedCount = document.querySelector('.document-summary .row .col-md-4:nth-child(2) p strong:last-child');
                    const pendingCount = document.querySelector('.document-summary .row .col-md-4:nth-child(3) p strong:last-child');
                    if (verifiedCount && pendingCount) {
                        verifiedCount.textContent = parseInt(verifiedCount.textContent) + 1;
                        pendingCount.textContent = parseInt(pendingCount.textContent) - 1;
                    }
                } else {
                    alert('Failed to verify document: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while verifying the document.');
            });
        }
    }
});

// Document name view functionality
$(document).on('click', '.view-document-name', function(e) {
    e.preventDefault();
    e.stopPropagation();
    
    const button = $(this);
    const documentName = button.data('document-name');
    const documentDescription = button.data('document-description');
    
    console.log('Button clicked:', documentName); // Debug log
    
    // Create modal content
    const modalContent = `
        <div class="modal fade" id="documentNameModal" tabindex="-1" role="dialog" aria-labelledby="documentNameModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                        <h5 class="modal-title" id="documentNameModalLabel">
                            <i class="fas fa-file-alt"></i> Document Details
                        </h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="font-weight-bold text-primary">Document Name:</label>
                            <p class="mt-1 p-2 bg-light border rounded">${documentName}</p>
                        </div>
                        ${documentDescription ? `
                            <div class="mb-3">
                                <label class="font-weight-bold text-primary">Description:</label>
                                <p class="mt-1 p-2 bg-light border rounded">${documentDescription}</p>
                            </div>
                        ` : ''}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="fas fa-times"></i> Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    // Remove existing modal if any
    $('#documentNameModal').remove();
    
    // Add modal to body
    $('body').append(modalContent);
    
    // Show modal
    $('#documentNameModal').modal('show');
    
    // Remove modal from DOM when hidden
    $('#documentNameModal').on('hidden.bs.modal', function () {
        $(this).remove();
    });
});
</script>

<style>
.subject-row:hover {
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.btn-group .btn {
    border-radius: 0;
}

.btn-group .btn:first-child {
    border-top-left-radius: 0.25rem;
    border-bottom-left-radius: 0.25rem;
}

.btn-group .btn:last-child {
    border-top-right-radius: 0.25rem;
    border-bottom-right-radius: 0.25rem;
}
</style>
@endsection