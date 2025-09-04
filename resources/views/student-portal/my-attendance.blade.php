@extends('layouts.student-portal')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">My Attendance</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('student-portal.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('student-portal.my-subjects') }}">My Subjects</a></li>
                        <li class="breadcrumb-item active">My Attendance</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="mb-0">
                                <i class="fas fa-calendar-check"></i> My Attendance
                            </h5>
                            <small class="text-muted">
                                {{ $allocation->module->subject_code }} - {{ $allocation->module->subject_name }}
                                <span class="badge bg-info ms-2">{{ $allocation->academicYear->academic_year }}</span>
                            </small>
                        </div>
                        <div class="col-auto">
                            <a href="{{ route('student-portal.my-subjects') }}" 
                               class="btn btn-sm" 
                               style="background: linear-gradient(135deg, #6c757d 0%, #495057 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                                <i class="fas fa-arrow-left"></i> Back to My Subjects
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if(Session::has('success'))
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        {{ Session::get('success') }}
                    </div>
                    @endif

                    @if(Session::has('error'))
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        {{ Session::get('error') }}
                    </div>
                    @endif

                    <!-- Subject Information -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6 class="mb-2"><i class="fas fa-book"></i> Subject Information</h6>
                                            <p class="mb-1"><strong>Subject:</strong> {{ $allocation->module->subject_name }}</p>
                                            <p class="mb-1"><strong>Code:</strong> {{ $allocation->module->subject_code }}</p>
                                            <p class="mb-0"><strong>Academic Year:</strong> {{ $allocation->academicYear->academic_year }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="mb-1"><strong>Campus:</strong> {{ $allocation->center->center_name }}</p>
                                            <p class="mb-1"><strong>Lecturer:</strong> 
                                                @if($allocation->user)
                                                    {{ $allocation->user->first_name }} {{ $allocation->user->surname }}
                                                @else
                                                    <span class="text-muted">Not Assigned</span>
                                                @endif
                                            </p>
                                            <p class="mb-0"><strong>Student:</strong> {{ $student->student_names }} {{ $student->surname }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Attendance Statistics -->
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h3 class="text-primary">{{ $totalClasses }}</h3>
                                    <p class="mb-0">Total Classes</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h3 class="text-success">{{ $attendedClasses }}</h3>
                                    <p class="mb-0">Classes Attended</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h3 class="text-{{ $attendancePercentage >= 75 ? 'success' : ($attendancePercentage >= 50 ? 'warning' : 'danger') }}">
                                        {{ $attendancePercentage }}%
                                    </h3>
                                    <p class="mb-0">Attendance Rate</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Attendance Records -->
                    @if($attendanceRecords->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Date</th>
                                        <th>Class Time</th>
                                        <th>Status</th>
                                        <th>Remarks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($attendanceRecords as $record)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($record->attendance_date)->format('d M Y') }}</td>
                                        <td>{{ $record->class_time ?? 'N/A' }}</td>
                                        <td>
                                            @if($record->status == 'present')
                                                <span class="badge bg-success">Present</span>
                                            @elseif($record->status == 'absent')
                                                <span class="badge bg-danger">Absent</span>
                                            @elseif($record->status == 'late')
                                                <span class="badge bg-warning">Late</span>
                                            @elseif($record->status == 'excused')
                                                <span class="badge bg-info">Excused</span>
                                            @else
                                                <span class="badge bg-secondary">{{ ucfirst($record->status) }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $record->remarks ?? '-' }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center">
                            {{ $attendanceRecords->links() }}
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                            <h5>No Attendance Records</h5>
                            <p class="text-muted">Your attendance records will appear here once classes begin.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
