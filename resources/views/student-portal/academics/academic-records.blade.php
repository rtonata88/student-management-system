@extends('layouts.student-portal')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Academic Records</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('student-portal.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('student-portal.academics') }}">Academics</a></li>
                        <li class="breadcrumb-item active">Academic Records</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mb-3">Academic History</h4>
                    
                    <div class="text-center py-4">
                        <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                        <h5>Academic Records</h5>
                        <p class="text-muted">Your complete academic history and transcripts will be available here.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
