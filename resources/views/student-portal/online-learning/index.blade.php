@extends('layouts.student-portal')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">
                        <i class="fas fa-laptop"></i> Online Learning
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Learning Management System -->
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body text-center">
                                    <div class="mb-3">
                                        <i class="fas fa-graduation-cap fa-3x text-primary"></i>
                                    </div>
                                    <h5 class="card-title">Learning Management System</h5>
                                    <p class="card-text text-muted">Access course materials, assignments, and interactive content.</p>
                                    <button class="btn btn-primary" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                                        <i class="fas fa-external-link-alt"></i> Access LMS
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Virtual Classroom -->
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body text-center">
                                    <div class="mb-3">
                                        <i class="fas fa-video fa-3x text-success"></i>
                                    </div>
                                    <h5 class="card-title">Virtual Classroom</h5>
                                    <p class="card-text text-muted">Join live lectures and interactive sessions with instructors.</p>
                                    <button class="btn btn-success" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                                        <i class="fas fa-play"></i> Join Session
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Digital Library -->
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body text-center">
                                    <div class="mb-3">
                                        <i class="fas fa-book-open fa-3x text-info"></i>
                                    </div>
                                    <h5 class="card-title">Digital Library</h5>
                                    <p class="card-text text-muted">Browse e-books, research papers, and academic resources.</p>
                                    <button class="btn btn-info" style="background: linear-gradient(135deg, #17a2b8 0%, #138496 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                                        <i class="fas fa-search"></i> Browse Library
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Online Assessments -->
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body text-center">
                                    <div class="mb-3">
                                        <i class="fas fa-clipboard-check fa-3x text-warning"></i>
                                    </div>
                                    <h5 class="card-title">Online Assessments</h5>
                                    <p class="card-text text-muted">Take quizzes, tests, and submit assignments online.</p>
                                    <button class="btn btn-warning" style="background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                                        <i class="fas fa-pencil-alt"></i> View Assessments
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Discussion Forums -->
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body text-center">
                                    <div class="mb-3">
                                        <i class="fas fa-comments fa-3x text-secondary"></i>
                                    </div>
                                    <h5 class="card-title">Discussion Forums</h5>
                                    <p class="card-text text-muted">Participate in academic discussions and peer interactions.</p>
                                    <button class="btn btn-secondary" style="background: linear-gradient(135deg, #6c757d 0%, #495057 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                                        <i class="fas fa-comment-dots"></i> Join Discussion
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Study Groups -->
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body text-center">
                                    <div class="mb-3">
                                        <i class="fas fa-users fa-3x text-danger"></i>
                                    </div>
                                    <h5 class="card-title">Study Groups</h5>
                                    <p class="card-text text-muted">Collaborate with classmates in virtual study groups.</p>
                                    <button class="btn btn-danger" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                                        <i class="fas fa-user-friends"></i> Find Groups
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Links Section -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-link"></i> Quick Links
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3 mb-2">
                                            <a href="#" class="btn btn-outline-primary btn-block" style="border-radius: 6px;">
                                                <i class="fas fa-calendar-alt"></i> Course Calendar
                                            </a>
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <a href="#" class="btn btn-outline-success btn-block" style="border-radius: 6px;">
                                                <i class="fas fa-download"></i> Course Materials
                                            </a>
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <a href="#" class="btn btn-outline-info btn-block" style="border-radius: 6px;">
                                                <i class="fas fa-question-circle"></i> Help & Support
                                            </a>
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <a href="#" class="btn btn-outline-warning btn-block" style="border-radius: 6px;">
                                                <i class="fas fa-cog"></i> Settings
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Activity -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-clock"></i> Recent Activity
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle"></i>
                                        <strong>Welcome to Online Learning!</strong>
                                        <br>
                                        Your online learning platform is being set up. Check back soon for course materials, assignments, and virtual classroom sessions.
                                    </div>
                                    
                                    <!-- Placeholder for future activity feed -->
                                    <div class="text-center text-muted py-4">
                                        <i class="fas fa-laptop fa-3x mb-3"></i>
                                        <p>No recent activity to display.</p>
                                        <small>Your learning activities will appear here once you start engaging with course content.</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Placeholder for future JavaScript functionality
    $(document).ready(function() {
        // Add click handlers for buttons when functionality is implemented
        $('.btn').on('click', function(e) {
            if ($(this).attr('href') === '#') {
                e.preventDefault();
                toastr.info('This feature is coming soon!');
            }
        });
    });
</script>
@endsection
