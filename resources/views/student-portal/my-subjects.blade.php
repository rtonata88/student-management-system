@extends('layouts.student-portal')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">My Subjects</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('student-portal.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">My Subjects</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mb-3">Enrolled Subjects</h4>
                    
                    <div class="text-center py-4">
                        <i class="fas fa-book fa-3x text-muted mb-3"></i>
                        <h5>No Subjects Enrolled</h5>
                        <p class="text-muted">Your enrolled subjects and course details will appear here.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
