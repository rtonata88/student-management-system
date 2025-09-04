@extends('layouts.student-portal')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">FAQ & Help</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('student-portal.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">FAQ & Help</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mb-3">Frequently Asked Questions</h4>
                    
                    <div class="text-center py-4">
                        <i class="fas fa-question-circle fa-3x text-muted mb-3"></i>
                        <h5>FAQ & Help</h5>
                        <p class="text-muted">Find answers to common questions and get help with using the student portal.</p>
                        
                        <div class="mt-3">
                            <a href="https://educims.com/contact.html" target="_blank" class="btn" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                                <i class="fas fa-envelope"></i> Contact Support
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
