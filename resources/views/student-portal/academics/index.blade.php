@extends('layouts.student-portal')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Academics</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('student-portal.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Academics</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="avatar-sm rounded-circle bg-primary">
                                <span class="avatar-title">
                                    <i class="fas fa-clipboard-list text-white font-size-16"></i>
                                </span>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0">Academic Records</h6>
                            <p class="text-muted mb-0">View your academic history</p>
                        </div>
                        <div class="flex-shrink-0">
                            <a href="{{ route('student-portal.academic-records') }}" class="btn btn-sm btn-outline-primary">View</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="avatar-sm rounded-circle bg-success">
                                <span class="avatar-title">
                                    <i class="fas fa-tasks text-white font-size-16"></i>
                                </span>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0">Assignments</h6>
                            <p class="text-muted mb-0">View and submit assignments</p>
                        </div>
                        <div class="flex-shrink-0">
                            <a href="{{ route('student-portal.assignments') }}" class="btn btn-sm btn-outline-success">View</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="avatar-sm rounded-circle bg-warning">
                                <span class="avatar-title">
                                    <i class="fas fa-star text-white font-size-16"></i>
                                </span>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0">Grades</h6>
                            <p class="text-muted mb-0">Check your grades</p>
                        </div>
                        <div class="flex-shrink-0">
                            <a href="{{ route('student-portal.grades') }}" class="btn btn-sm btn-outline-warning">View</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="avatar-sm rounded-circle bg-info">
                                <span class="avatar-title">
                                    <i class="fas fa-chart-line text-white font-size-16"></i>
                                </span>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0">CA Marks</h6>
                            <p class="text-muted mb-0">Continuous Assessment marks</p>
                        </div>
                        <div class="flex-shrink-0">
                            <a href="{{ route('student-portal.ca-marks') }}" class="btn btn-sm btn-outline-info">View</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="avatar-sm rounded-circle bg-danger">
                                <span class="avatar-title">
                                    <i class="fas fa-graduation-cap text-white font-size-16"></i>
                                </span>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0">Exam Marks</h6>
                            <p class="text-muted mb-0">View examination results</p>
                        </div>
                        <div class="flex-shrink-0">
                            <a href="{{ route('student-portal.exam-marks') }}" class="btn btn-sm btn-outline-danger">View</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="avatar-sm rounded-circle bg-secondary">
                                <span class="avatar-title">
                                    <i class="fas fa-calendar-alt text-white font-size-16"></i>
                                </span>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0">Class Routine</h6>
                            <p class="text-muted mb-0">View your class schedule</p>
                        </div>
                        <div class="flex-shrink-0">
                            <a href="{{ route('student-portal.class-routine') }}" class="btn btn-sm btn-outline-secondary">View</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="avatar-sm rounded-circle bg-dark">
                                <span class="avatar-title">
                                    <i class="fas fa-clock text-white font-size-16"></i>
                                </span>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0">Exam Timetable</h6>
                            <p class="text-muted mb-0">Check exam schedule</p>
                        </div>
                        <div class="flex-shrink-0">
                            <a href="{{ route('student-portal.exam-timetable') }}" class="btn btn-sm btn-outline-dark">View</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="avatar-sm rounded-circle bg-primary">
                                <span class="avatar-title">
                                    <i class="fas fa-file-alt text-white font-size-16"></i>
                                </span>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0">Academic Script</h6>
                            <p class="text-muted mb-0">Download academic transcripts</p>
                        </div>
                        <div class="flex-shrink-0">
                            <a href="{{ route('student-portal.academic-script') }}" class="btn btn-sm btn-outline-primary">View</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="avatar-sm rounded-circle bg-success">
                                <span class="avatar-title">
                                    <i class="fas fa-certificate text-white font-size-16"></i>
                                </span>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0">Proof of Registration</h6>
                            <p class="text-muted mb-0">Download registration certificate</p>
                        </div>
                        <div class="flex-shrink-0">
                            <a href="{{ route('student-portal.proof-of-registration') }}" class="btn btn-sm btn-outline-success">View</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
