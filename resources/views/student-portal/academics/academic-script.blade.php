@extends('layouts.student-portal')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Academic Script</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('student-portal.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('student-portal.academics') }}">Academics</a></li>
                        <li class="breadcrumb-item active">Academic Script</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mb-3">Academic Transcripts</h4>
                    
                    <div class="text-center py-4">
                        <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                        <h5>Academic Transcripts</h5>
                        <p class="text-muted">Download your official academic transcripts and certificates.</p>
                        <button class="btn btn-primary mt-3" disabled>
                            <i class="fas fa-download"></i> Download Transcript
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
