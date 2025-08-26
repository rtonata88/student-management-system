@extends('layouts.app')

@section('breadcrumb')
<div class="c-subheader px-3">
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Assessments</li>
        <li class="breadcrumb-item"><a href="{{ route('my-modules.index') }}">My Modules</a></li>
        <li class="breadcrumb-item active">Attendance</li>
    </ol>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0">
                        <i class="fas fa-check-circle"></i> Attendance - {{ $allocation->module->subject_name }}
                    </h5>
                    <small class="text-muted">
                        {{ $allocation->academicYear->academic_year }} | {{ $allocation->center->center_name }}
                    </small>
                </div>
                <div>
                    @permission('mark-attendance')
                    <a href="{{ route('my-modules.mark-attendance', $allocation->id) }}" 
                       class="btn btn-sm" 
                       style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                        <i class="fas fa-plus"></i> Mark Attendance
                    </a>
                    @endpermission
                    <a href="{{ route('my-modules.index') }}" 
                       class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>
                </div>
            </div>
            <div class="card-body">
                @if(Session::has('success'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    {{ Session::get('success') }}
                </div>
                @endif

                <!-- Filter Form -->
                <form method="GET" class="mb-4">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="date" class="form-label">Date</label>
                            <input type="date" name="date" id="date" class="form-control" 
                                   value="{{ $selectedDate }}" onchange="this.form.submit()">
                        </div>
                        <div class="col-md-4">
                            <label for="time" class="form-label">Class Time (Optional)</label>
                            <input type="time" name="time" id="time" class="form-control" 
                                   value="{{ $selectedTime }}" onchange="this.form.submit()">
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button type="submit" class="btn btn-outline-primary me-2">
                                <i class="fas fa-filter"></i> Filter
                            </button>
                            <a href="{{ route('my-modules.attendance', $allocation->id) }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times"></i> Clear
                            </a>
                        </div>
                    </div>
                </form>

                <!-- Attendance Records -->
                @if($students->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Student Number</th>
                                    <th>Student Name</th>
                                    <th>Status</th>
                                    <th>Time</th>
                                    <th>Notes</th>
                                    <th>Recorded By</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($students as $index => $student)
                                    @php
                                        $attendance = $attendanceRecords->get($student->id);
                                    @endphp
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td><strong>{{ $student->student_number2 }}</strong></td>
                                        <td>{{ $student->student_names }} {{ $student->surname }}</td>
                                        <td>
                                            @if($attendance)
                                                <span class="badge bg-{{ $attendance->status_color }}">
                                                    <i class="fas {{ $attendance->status_icon }}"></i>
                                                    {{ ucfirst($attendance->status) }}
                                                </span>
                                            @else
                                                <span class="badge bg-secondary">
                                                    <i class="fas fa-question"></i>
                                                    Not Marked
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $attendance ? $attendance->formatted_time : '-' }}
                                        </td>
                                        <td>
                                            {{ $attendance->notes ?? '-' }}
                                        </td>
                                        <td>
                                            {{ $attendance ? $attendance->recordedBy->name : '-' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Summary Statistics -->
                    @if($attendanceRecords->count() > 0)
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <h6>Attendance Summary for {{ \Carbon\Carbon::parse($selectedDate)->format('d F Y') }}</h6>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="card bg-success text-white">
                                            <div class="card-body text-center">
                                                <h4>{{ $attendanceRecords->where('status', 'present')->count() }}</h4>
                                                <small>Present</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card bg-danger text-white">
                                            <div class="card-body text-center">
                                                <h4>{{ $attendanceRecords->where('status', 'absent')->count() }}</h4>
                                                <small>Absent</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card bg-warning text-white">
                                            <div class="card-body text-center">
                                                <h4>{{ $attendanceRecords->where('status', 'late')->count() }}</h4>
                                                <small>Late</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card bg-info text-white">
                                            <div class="card-body text-center">
                                                <h4>{{ $attendanceRecords->where('status', 'excused')->count() }}</h4>
                                                <small>Excused</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @else
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i>
                        No students are enrolled in this module.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
