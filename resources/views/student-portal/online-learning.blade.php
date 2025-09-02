@extends('layouts.student-portal')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Online Learning</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('student-portal.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Online Learning</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mb-3">Learning Management System</h4>
                    
                    <div class="text-center py-4">
                        <i class="fas fa-laptop fa-3x text-muted mb-3"></i>
                        <h5>Online Learning Platform</h5>
                        <p class="text-muted">Access your online courses, lectures, and learning materials.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
