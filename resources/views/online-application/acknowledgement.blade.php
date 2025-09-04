@extends('layouts.student-portal')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white;">
                    <h4 class="mb-0"><i class="fas fa-check-circle"></i> Application Submitted Successfully</h4>
                    <small>Your application has been received and is under review</small>
                </div>
                
                <div class="card-body text-center">
                    <div class="mb-4">
                        <i class="fas fa-check-circle text-success" style="font-size: 4rem;"></i>
                    </div>
                    
                    <h5 class="text-success mb-3">Application Process Complete!</h5>
                    
                    <div class="alert alert-success">
                        <h6><i class="fas fa-info-circle"></i> Your application has been emailed to you!</h6>
                        <p class="mb-0">(PS: This letter has been emailed to you.)</p>
                    </div>

                    <div class="card mb-4">
                        <div class="card-body">
                            <h6>Application Details</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Application Number:</strong><br>{{ $application->application_number }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Submission Date:</strong><br>{{ $application->submitted_at->format('d M Y H:i') }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Status:</strong><br>
                                        <span class="badge {{ $application->getStatusBadgeClass() }}">
                                            {{ $application->getStatusLabel() }}
                                        </span>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Applicant:</strong><br>{{ $application->user->name }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <a href="{{ route('online-application.download-acknowledgement') }}" 
                           class="btn btn-lg mr-3" 
                           style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.75rem 2rem;">
                            <i class="fas fa-download"></i> DOWNLOAD YOUR ACKNOWLEDGEMENT LETTER HERE!
                        </a>
                    </div>

                    <div class="alert alert-info">
                        <h6><i class="fas fa-clock"></i> What happens next?</h6>
                        <ul class="text-left mb-0">
                            <li>Your application will be reviewed by our admissions team</li>
                            <li>You will receive an email notification once your application status changes</li>
                            <li>You can check your application status anytime by logging into your student portal</li>
                            <li>If approved, you will receive further instructions for enrollment</li>
                        </ul>
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('student-portal.index') }}" 
                           class="btn btn-outline-primary btn-lg">
                            <i class="fas fa-tachometer-alt"></i> Go to Student Portal
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}

.alert ul {
    padding-left: 1.2rem;
}

.btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}
</style>
@endsection
