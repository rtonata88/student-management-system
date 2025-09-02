@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white;">
                    <h4 class="mb-0"><i class="fas fa-clock"></i> Exam Timetable</h4>
                    <small>View your scheduled examinations</small>
                </div>
                <div class="card-body">
                    @if($examSchedules->isEmpty())
                        <div class="alert alert-info text-center">
                            <i class="fas fa-calendar-times fa-3x mb-3"></i>
                            <h5>No Exam Schedules Found</h5>
                            <p>You don't have any scheduled examinations at the moment.</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead style="background-color: #f8f9fa;">
                                    <tr>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Subject</th>
                                        <th>Subject Code</th>
                                        <th>Venue</th>
                                        <th>Duration</th>
                                        <th>Head Invigilator</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($examSchedules->sortBy('exam_date') as $schedule)
                                        <tr>
                                            <td>
                                                <strong>{{ \Carbon\Carbon::parse($schedule->exam_date)->format('d M Y') }}</strong>
                                                <br><small class="text-muted">{{ \Carbon\Carbon::parse($schedule->exam_date)->format('l') }}</small>
                                            </td>
                                            <td>
                                                @if($schedule->timeSlot)
                                                    {{ $schedule->timeSlot->start_time }} - {{ $schedule->timeSlot->end_time }}
                                                @else
                                                    <span class="text-muted">Time not set</span>
                                                @endif
                                            </td>
                                            <td>{{ $schedule->subjectAllocation->subject->subject_name ?? 'N/A' }}</td>
                                            <td>{{ $schedule->subjectAllocation->subject->subject_code ?? 'N/A' }}</td>
                                            <td>
                                                @if($schedule->venue)
                                                    <strong>{{ $schedule->venue->name }}</strong>
                                                    @if($schedule->venue->code)
                                                        <br><small class="text-muted">{{ $schedule->venue->code }}</small>
                                                    @endif
                                                @else
                                                    <span class="text-muted">Venue TBA</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($schedule->timeSlot)
                                                    {{ $schedule->timeSlot->duration ?? 'N/A' }} mins
                                                @else
                                                    <span class="text-muted">N/A</span>
                                                @endif
                                            </td>
                                            <td>{{ $schedule->subjectAllocation->teacher->name ?? 'TBA' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Exam Statistics -->
                        <div class="card mt-4">
                            <div class="card-header">
                                <h6><i class="fas fa-chart-bar"></i> Exam Statistics</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="text-center">
                                            <h4 class="text-primary">{{ $examSchedules->count() }}</h4>
                                            <p class="text-muted mb-0">Total Exams</p>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="text-center">
                                            <h4 class="text-success">{{ $examSchedules->where('exam_date', '>', now())->count() }}</h4>
                                            <p class="text-muted mb-0">Upcoming</p>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="text-center">
                                            <h4 class="text-warning">{{ $examSchedules->where('exam_date', '<=', now())->count() }}</h4>
                                            <p class="text-muted mb-0">Completed</p>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="text-center">
                                            <h4 class="text-info">{{ $examSchedules->unique('subjectAllocation.subject.id')->count() }}</h4>
                                            <p class="text-muted mb-0">Subjects</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Navigation -->
                    <div class="text-center mt-4">
                        <a href="{{ route('student-portal.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
