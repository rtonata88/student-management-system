@extends('layouts.student-portal')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; position: relative;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0"><i class="fas fa-clipboard-check"></i> Review Your Application</h4>
                            <small>Step 5 of 5 - Review all information before submitting</small>
                        </div>
                        <div class="text-right">
                            <div class="progress-indicator">
                                <span class="badge badge-light">Application Progress: 100%</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- Application Summary -->
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-bottom: 2px solid #dee2e6;">
                            <h5 class="mb-0"><i class="fas fa-info-circle text-primary"></i> Application Summary</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="info-box text-center p-3 border rounded" style="background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);">
                                        <i class="fas fa-hashtag fa-2x text-primary mb-2"></i>
                                        <h6 class="font-weight-bold">Application Number</h6>
                                        <p class="mb-0 h5 text-primary">{{ $application->application_number }}</p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="info-box text-center p-3 border rounded" style="background: linear-gradient(135deg, #f3e5f5 0%, #e1bee7 100%);">
                                        <i class="fas fa-flag fa-2x text-purple mb-2"></i>
                                        <h6 class="font-weight-bold">Status</h6>
                                        <span class="badge badge-lg {{ $application->getStatusBadgeClass() }}" style="font-size: 0.9rem; padding: 0.5rem 1rem;">
                                            {{ $application->getStatusLabel() }}
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="info-box text-center p-3 border rounded" style="background: linear-gradient(135deg, #e8f5e8 0%, #c8e6c9 100%);">
                                        <i class="fas fa-calendar-plus fa-2x text-success mb-2"></i>
                                        <h6 class="font-weight-bold">Created</h6>
                                        <p class="mb-0 text-success">{{ $application->created_at->format('d M Y') }}</p>
                                        <small class="text-muted">{{ $application->created_at->format('H:i') }}</small>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="info-box text-center p-3 border rounded" style="background: linear-gradient(135deg, #fff3e0 0%, #ffcc02 100%);">
                                        <i class="fas fa-paper-plane fa-2x text-warning mb-2"></i>
                                        <h6 class="font-weight-bold">Submitted</h6>
                                        @if($application->submitted_at)
                                            <p class="mb-0 text-warning">{{ $application->submitted_at->format('d M Y') }}</p>
                                            <small class="text-muted">{{ $application->submitted_at->format('H:i') }}</small>
                                        @else
                                            <p class="mb-0 text-muted">Not yet submitted</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Student Information Review -->
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header d-flex justify-content-between align-items-center" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-bottom: 2px solid #dee2e6;">
                            <h5 class="mb-0"><i class="fas fa-user text-info"></i> Student Information</h5>
                            @if($application->canBeEdited())
                                <a href="{{ route('online-application.student-info') }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                            @endif
                        </div>
                        <div class="card-body">
                            @if($student)
                                <!-- Personal Information -->
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <h6 class="text-primary border-bottom pb-2 mb-3"><i class="fas fa-user-circle"></i> Personal Details</h6>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="info-item mb-3">
                                            <label class="text-muted small">FULL NAME</label>
                                            <p class="mb-0 font-weight-bold">{{ $student->student_names }} {{ $student->surname }}</p>
                                        </div>
                                        <div class="info-item mb-3">
                                            <label class="text-muted small">INITIALS</label>
                                            <p class="mb-0">{{ $student->initials ?: 'Not provided' }}</p>
                                        </div>
                                        <div class="info-item mb-3">
                                            <label class="text-muted small">GENDER</label>
                                            <p class="mb-0">{{ $student->gender ?: 'Not provided' }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="info-item mb-3">
                                            <label class="text-muted small">DATE OF BIRTH</label>
                                            <p class="mb-0">{{ $student->date_of_birth ? \Carbon\Carbon::parse($student->date_of_birth)->format('d M Y') : 'Not provided' }}</p>
                                        </div>
                                        <div class="info-item mb-3">
                                            <label class="text-muted small">ID NUMBER</label>
                                            <p class="mb-0">{{ $student->id_number ?: 'Not provided' }}</p>
                                        </div>
                                        <div class="info-item mb-3">
                                            <label class="text-muted small">BIRTH CERTIFICATE</label>
                                            <p class="mb-0">{{ $student->birth_certificate ?: 'Not provided' }}</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Contact Information -->
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <h6 class="text-primary border-bottom pb-2 mb-3"><i class="fas fa-phone"></i> Contact Information</h6>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="info-item mb-3">
                                            <label class="text-muted small">EMAIL ADDRESS</label>
                                            <p class="mb-0">{{ $student->contact_email ?: 'Not provided' }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="info-item mb-3">
                                            <label class="text-muted small">CONTACT NUMBER</label>
                                            <p class="mb-0">{{ $student->contact_number ?: 'Not provided' }}</p>
                                        </div>
                                    </div>
                                </div>

                                @if($student->guardian_names)
                                    <!-- Guardian Information -->
                                    <div class="row">
                                        <div class="col-12">
                                            <h6 class="text-primary border-bottom pb-2 mb-3"><i class="fas fa-users"></i> Guardian Information</h6>
                                        </div>
                                        @php
                                            $guardianNames = json_decode($student->guardian_names, true) ?: [];
                                            $guardianSurnames = json_decode($student->guardian_surname, true) ?: [];
                                            $relationships = json_decode($student->relationship, true) ?: [];
                                            $guardianContacts = json_decode($student->guardian_contact_number, true) ?: [];
                                            $guardianEmails = json_decode($student->guardian_contact_email, true) ?: [];
                                        @endphp
                                        
                                        @for($i = 0; $i < count($guardianNames); $i++)
                                            @if(!empty($guardianNames[$i]))
                                                <div class="col-md-6 mb-3">
                                                    <div class="guardian-card p-3 border rounded" style="background-color: #f8f9fa;">
                                                        <h6 class="text-info mb-2">
                                                            <i class="fas fa-user-friends"></i> {{ $i == 0 ? 'Primary' : 'Secondary' }} Guardian
                                                        </h6>
                                                        <div class="info-item mb-2">
                                                            <label class="text-muted small">NAME</label>
                                                            <p class="mb-0 font-weight-bold">{{ $guardianNames[$i] }} {{ $guardianSurnames[$i] ?? '' }}</p>
                                                        </div>
                                                        <div class="info-item mb-2">
                                                            <label class="text-muted small">RELATIONSHIP</label>
                                                            <p class="mb-0">{{ $relationships[$i] ?? 'Not specified' }}</p>
                                                        </div>
                                                        <div class="info-item mb-2">
                                                            <label class="text-muted small">CONTACT</label>
                                                            <p class="mb-0">{{ $guardianContacts[$i] ?? 'Not provided' }}</p>
                                                        </div>
                                                        <div class="info-item mb-0">
                                                            <label class="text-muted small">EMAIL</label>
                                                            <p class="mb-0">{{ $guardianEmails[$i] ?: 'Not provided' }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endfor
                                    </div>
                                @endif
                            @else
                                <div class="alert alert-warning">
                                    <i class="fas fa-exclamation-triangle"></i> Student information not completed. 
                                    <a href="{{ route('online-application.student-info') }}">Complete now</a>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Selected Subjects Review -->
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header d-flex justify-content-between align-items-center" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-bottom: 2px solid #dee2e6;">
                            <h5 class="mb-0"><i class="fas fa-book text-success"></i> Selected Subjects</h5>
                            @if($application->canBeEdited())
                                <a href="{{ route('online-application.subject-selection') }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                            @endif
                        </div>
                        <div class="card-body">
                            @if($subjects->isNotEmpty())
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <div class="alert alert-info">
                                            <i class="fas fa-graduation-cap"></i> 
                                            <strong>{{ $subjects->count() }}</strong> subject{{ $subjects->count() > 1 ? 's' : '' }} selected for your academic program
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white;">
                                            <tr>
                                                <th><i class="fas fa-book-open"></i> Subject Name</th>
                                                <th><i class="fas fa-code"></i> Code</th>
                                                <th><i class="fas fa-credit-card"></i> Credits</th>
                                                <th><i class="fas fa-dollar-sign"></i> Monthly Fee</th>
                                                <th><i class="fas fa-calculator"></i> Total Fee</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php 
                                                $totalFee = 0;
                                                $courseDurationMonths = $courseDurationMonths ?? 12;
                                            @endphp
                                            @foreach($subjects as $subject)
                                                @php $subjectTotalFee = $subject->subject_fees * $courseDurationMonths; @endphp
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="subject-icon mr-2">
                                                                <i class="fas fa-book text-primary"></i>
                                                            </div>
                                                            <div>
                                                                <strong>{{ $subject->subject_name }}</strong>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td><span class="badge badge-secondary">{{ $subject->subject_code }}</span></td>
                                                    <td><span class="badge badge-info">{{ $subject->credits ?? 'N/A' }}</span></td>
                                                    <td class="text-success font-weight-bold">N${{ number_format($subject->subject_fees, 2) }}</td>
                                                    <td class="text-primary font-weight-bold">N${{ number_format($subjectTotalFee, 2) }}</td>
                                                </tr>
                                                @php $totalFee += $subjectTotalFee; @endphp
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white;">
                                                <th colspan="4" class="text-right"><i class="fas fa-calculator"></i> TOTAL PROGRAM FEE</th>
                                                <th class="h5 mb-0">N${{ number_format($totalFee, 2) }}</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <div class="info-box p-3 border rounded" style="background: linear-gradient(135deg, #e8f5e8 0%, #c8e6c9 100%);">
                                            <h6 class="text-success"><i class="fas fa-calendar-alt"></i> Course Duration</h6>
                                            <p class="mb-0 h5">{{ $courseDurationMonths }} months</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="info-box p-3 border rounded" style="background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);">
                                            <h6 class="text-primary"><i class="fas fa-money-bill-wave"></i> Monthly Payment</h6>
                                            <p class="mb-0 h5">N${{ number_format($totalFee / $courseDurationMonths, 2) }}</p>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="alert alert-warning">
                                    <i class="fas fa-exclamation-triangle"></i> No subjects selected. 
                                    <a href="{{ route('online-application.subject-selection') }}">Select subjects now</a>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Uploaded Documents Review -->
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header d-flex justify-content-between align-items-center" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-bottom: 2px solid #dee2e6;">
                            <h5 class="mb-0"><i class="fas fa-file-alt text-warning"></i> Uploaded Documents</h5>
                            @if($application->canBeEdited())
                                <a href="{{ route('online-application.document-upload') }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                            @endif
                        </div>
                        <div class="card-body">
                            @if($documents->isNotEmpty())
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <div class="alert alert-success">
                                            <i class="fas fa-check-circle"></i> 
                                            <strong>{{ $documents->count() }}</strong> document{{ $documents->count() > 1 ? 's' : '' }} uploaded successfully
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    @foreach($documents as $document)
                                        <div class="col-md-6 mb-3">
                                            <div class="document-card p-3 border rounded" style="background: linear-gradient(135deg, #fff3e0 0%, #ffe0b2 100%);">
                                                <div class="d-flex justify-content-between align-items-start mb-2">
                                                    <div class="document-icon">
                                                        <i class="fas fa-file-pdf fa-2x text-danger"></i>
                                                    </div>
                                                    <span class="badge badge-primary">{{ $document->getDocumentTypeLabel() }}</span>
                                                </div>
                                                <h6 class="font-weight-bold text-truncate" title="{{ $document->document_name }}">{{ $document->document_name }}</h6>
                                                <div class="document-details">
                                                    <small class="text-muted d-block">
                                                        <i class="fas fa-weight"></i> {{ $document->getFileSizeFormatted() }}
                                                    </small>
                                                    <small class="text-muted d-block">
                                                        <i class="fas fa-calendar"></i> {{ $document->created_at->format('d M Y H:i') }}
                                                    </small>
                                                </div>
                                                <div class="mt-2">
                                                    <a href="{{ $document->getFileUrl() }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-eye"></i> View
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="alert alert-warning">
                                    <i class="fas fa-exclamation-triangle"></i> No documents uploaded. 
                                    <a href="{{ route('online-application.document-upload') }}">Upload documents now</a>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Declaration and Submit -->
                    @if($application->canBeEdited())
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5><i class="fas fa-file-signature"></i> Declaration</h5>
                            </div>
                            <div class="card-body">
                                <div class="alert alert-info">
                                    <h6><strong>Declaration:</strong></h6>
                                    <ol>
                                        <li>I certify that all the information provided in this application is complete and accurate to the best of my knowledge and belief.</li>
                                        <li>I understand that the institution retains the right to reject any application or rescind any admission offer if any part of the information provided is found to be false or incorrect, or if an offer was made in error.</li>
                                        <li>I acknowledge that, if accepted at the institution, I will be subject to the disciplinary authority of the institution's authorities. I commit to familiarize myself with and abide by the rules and regulations of the institution.</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Navigation Buttons -->
                    <div class="card">
                        <div class="card-footer text-center">
                            @if($application->canBeEdited())
                                <form action="{{ route('online-application.submit') }}" method="POST" class="d-inline" 
                                      onsubmit="return confirm('Are you sure you want to submit your application? You will not be able to edit it after submission.')">
                                    @csrf
                                    <button type="submit" class="btn btn-lg mr-3" 
                                            style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white; border: none; border-radius: 6px; padding: 0.75rem 2rem;">
                                        <i class="fas fa-paper-plane"></i> Submit Application
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('online-application.acknowledgement') }}" 
                                   class="btn btn-lg mr-3" 
                                   style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.75rem 2rem;">
                                    <i class="fas fa-download"></i> Download Acknowledgement
                                </a>
                            @endif
                            
                            <a href="{{ route('online-application.document-upload') }}" class="btn btn-secondary btn-lg" style="padding: 0.75rem 2rem;">
                                <i class="fas fa-arrow-left"></i> Back
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
.info-box {
    transition: transform 0.2s ease-in-out;
}

.info-box:hover {
    transform: translateY(-2px);
}

.document-card {
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
}

.document-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.guardian-card {
    transition: transform 0.2s ease-in-out;
}

.guardian-card:hover {
    transform: translateY(-1px);
}

.info-item label {
    font-weight: 600;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.text-purple {
    color: #6f42c1 !important;
}

.badge-lg {
    font-size: 0.9rem;
    padding: 0.5rem 1rem;
}

.progress-indicator .badge {
    font-size: 0.8rem;
    padding: 0.4rem 0.8rem;
}

.table th {
    font-weight: 600;
    font-size: 0.85rem;
    border: none;
}

.table td {
    vertical-align: middle;
    border-color: #e9ecef;
}

.subject-icon {
    width: 30px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(0,123,255,0.1);
    border-radius: 50%;
}

.document-icon {
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(220,53,69,0.1);
    border-radius: 8px;
}

.card {
    border: none;
    border-radius: 10px;
}

.card-header {
    border-radius: 10px 10px 0 0 !important;
}

.shadow-sm {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
}
</style>
