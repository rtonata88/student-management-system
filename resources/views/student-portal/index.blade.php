@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white;">
                    <h4 class="mb-0"><i class="fas fa-tachometer-alt"></i> Student Portal Dashboard</h4>
                    <small>Welcome back, {{ Auth::user()->name }}!</small>
                </div>
                <div class="card-body">
                    @if($student)
                        <div class="alert alert-success">
                            <i class="fas fa-user-check"></i> <strong>Student ID:</strong> {{ $student->student_number }}
                        </div>
                    @endif

                    <!-- Quick Stats -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card text-center" style="border-left: 4px solid #6f42c1;">
                                <div class="card-body">
                                    <i class="fas fa-book fa-2x text-primary mb-2"></i>
                                    <h4>{{ $stats['total_subjects'] }}</h4>
                                    <p class="text-muted mb-0">My Subjects</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-center" style="border-left: 4px solid #28a745;">
                                <div class="card-body">
                                    <i class="fas fa-money-bill-wave fa-2x text-success mb-2"></i>
                                    <h4>R{{ number_format($stats['total_payments'], 2) }}</h4>
                                    <p class="text-muted mb-0">Total Payments</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-center" style="border-left: 4px solid #ffc107;">
                                <div class="card-body">
                                    <i class="fas fa-file-alt fa-2x text-warning mb-2"></i>
                                    <h4>{{ $stats['pending_applications'] }}</h4>
                                    <p class="text-muted mb-0">Pending Applications</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-center" style="border-left: 4px solid #dc3545;">
                                <div class="card-body">
                                    <i class="fas fa-calendar-check fa-2x text-danger mb-2"></i>
                                    <h4>{{ $stats['exam_schedules'] }}</h4>
                                    <p class="text-muted mb-0">Exam Schedules</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Portal Sections -->
                    <div class="row">
                        <!-- Profile Section -->
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card h-100">
                                <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                                    <h6 class="mb-0"><i class="fas fa-user"></i> Profile</h6>
                                </div>
                                <div class="card-body">
                                    <div class="list-group list-group-flush">
                                        <a href="{{ route('student-portal.my-info') }}" class="list-group-item list-group-item-action">
                                            <i class="fas fa-info-circle text-primary"></i> My Info
                                        </a>
                                        <a href="{{ route('student-portal.my-documents') }}" class="list-group-item list-group-item-action">
                                            <i class="fas fa-file-alt text-success"></i> My Documents
                                        </a>
                                        <a href="{{ route('student-portal.my-applications') }}" class="list-group-item list-group-item-action">
                                            <i class="fas fa-clipboard-list text-warning"></i> My Applications
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Academics Section -->
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card h-100">
                                <div class="card-header" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white;">
                                    <h6 class="mb-0"><i class="fas fa-graduation-cap"></i> Academics</h6>
                                </div>
                                <div class="card-body">
                                    <div class="list-group list-group-flush">
                                        <a href="{{ route('student-portal.ca-marks') }}" class="list-group-item list-group-item-action">
                                            <i class="fas fa-chart-line text-info"></i> CA Marks
                                        </a>
                                        <a href="{{ route('student-portal.exam-marks') }}" class="list-group-item list-group-item-action">
                                            <i class="fas fa-trophy text-warning"></i> Exam Marks
                                        </a>
                                        <a href="{{ route('student-portal.class-routine') }}" class="list-group-item list-group-item-action">
                                            <i class="fas fa-calendar text-primary"></i> Class Routine
                                        </a>
                                        <a href="{{ route('student-portal.exam-timetable') }}" class="list-group-item list-group-item-action">
                                            <i class="fas fa-clock text-danger"></i> Exam Time Table
                                        </a>
                                        <a href="{{ route('student-portal.academic-script') }}" class="list-group-item list-group-item-action">
                                            <i class="fas fa-file-pdf text-secondary"></i> Academic Script
                                        </a>
                                        <a href="{{ route('student-portal.proof-of-registration') }}" class="list-group-item list-group-item-action">
                                            <i class="fas fa-certificate text-success"></i> Proof of Registration
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Finance Section -->
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card h-100">
                                <div class="card-header" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white;">
                                    <h6 class="mb-0"><i class="fas fa-coins"></i> Finance</h6>
                                </div>
                                <div class="card-body">
                                    <div class="list-group list-group-flush">
                                        <a href="{{ route('student-portal.my-payments') }}" class="list-group-item list-group-item-action">
                                            <i class="fas fa-credit-card text-success"></i> My Payments
                                        </a>
                                        <a href="{{ route('student-portal.financial-statement') }}" class="list-group-item list-group-item-action">
                                            <i class="fas fa-file-invoice text-primary"></i> Financial Statement
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- My Subjects Section -->
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card h-100">
                                <div class="card-header" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); color: white;">
                                    <h6 class="mb-0"><i class="fas fa-book-open"></i> My Subjects</h6>
                                </div>
                                <div class="card-body">
                                    <a href="{{ route('student-portal.my-subjects') }}" class="btn btn-block" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.75rem;">
                                        <i class="fas fa-eye"></i> View My Subjects
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Online Learning Section -->
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card h-100">
                                <div class="card-header" style="background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%); color: #333;">
                                    <h6 class="mb-0"><i class="fas fa-laptop"></i> Online Learning</h6>
                                </div>
                                <div class="card-body">
                                    <a href="{{ route('student-portal.online-learning') }}" class="btn btn-block" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.75rem;">
                                        <i class="fas fa-play-circle"></i> Access Learning Portal
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Library Management Section -->
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card h-100">
                                <div class="card-header" style="background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%); color: #333;">
                                    <h6 class="mb-0"><i class="fas fa-book-reader"></i> Library Management</h6>
                                </div>
                                <div class="card-body">
                                    <div class="list-group list-group-flush">
                                        <a href="{{ route('student-portal.library-books') }}" class="list-group-item list-group-item-action">
                                            <i class="fas fa-books text-primary"></i> Library Books
                                        </a>
                                        <a href="{{ route('student-portal.library-fines') }}" class="list-group-item list-group-item-action">
                                            <i class="fas fa-exclamation-triangle text-warning"></i> Library Fines
                                        </a>
                                        <a href="{{ route('student-portal.borrow-history') }}" class="list-group-item list-group-item-action">
                                            <i class="fas fa-history text-info"></i> My Borrow History
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Hostel Management Section -->
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card h-100">
                                <div class="card-header" style="background: linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%); color: #333;">
                                    <h6 class="mb-0"><i class="fas fa-bed"></i> Hostel Management</h6>
                                </div>
                                <div class="card-body">
                                    <div class="list-group list-group-flush">
                                        <a href="{{ route('student-portal.hostel-applications') }}" class="list-group-item list-group-item-action">
                                            <i class="fas fa-file-alt text-primary"></i> Applications
                                        </a>
                                        <a href="{{ route('student-portal.my-hostel-data') }}" class="list-group-item list-group-item-action">
                                            <i class="fas fa-home text-success"></i> My Hostel Data
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Market Place Section -->
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card h-100">
                                <div class="card-header" style="background: linear-gradient(135deg, #a1c4fd 0%, #c2e9fb 100%); color: #333;">
                                    <h6 class="mb-0"><i class="fas fa-shopping-cart"></i> The Market Place</h6>
                                </div>
                                <div class="card-body">
                                    <a href="{{ route('student-portal.marketplace') }}" class="btn btn-block" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.75rem;">
                                        <i class="fas fa-store"></i> Browse Marketplace
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    transition: transform 0.2s, box-shadow 0.2s;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.list-group-item-action:hover {
    background-color: #f8f9fa;
    transform: translateX(5px);
    transition: all 0.2s;
}

.list-group-item i {
    width: 20px;
    margin-right: 10px;
}
</style>
@endsection
