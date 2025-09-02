@extends('layouts.student-portal')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Class Routine</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('student-portal.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('student-portal.academics') }}">Academics</a></li>
                        <li class="breadcrumb-item active">Class Routine</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mb-3">Weekly Class Schedule</h4>
                    
                    <div class="text-center py-4">
                        <i class="fas fa-calendar-alt fa-3x text-muted mb-3"></i>
                        <h5>No Class Routine Available</h5>
                        <p class="text-muted">Your weekly class schedule will be displayed here.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
