@extends('layouts.app')

@section('breadcrumb')
<div class="c-subheader px-3">
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Assessments</li>
        <li class="breadcrumb-item"><a href="{{ route('examination-schedule.index') }}">Examination Schedule</a></li>
        <li class="breadcrumb-item active">Timetable View</li>
    </ol>
</div>
@endsection

@section('content')
<div class="container-fluid">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="card-title mb-0">
                                    <i class="fas fa-table"></i> Examination Timetable
                                    <small class="text-muted">{{ $currentAcademicYear->academic_year }}</small>
                                </h4>
                            </div>
                            <div class="col-md-6 text-right">
                                <a href="{{ route('examination-schedule.index') }}" class="btn btn-secondary">
                                    <i class="fa fa-list"></i> List View
                                </a>
                                @if(Auth::user()->hasPermission('print-examination-schedule'))
                                    <a href="{{ route('examination-schedule.print', request()->query()) }}" target="_blank" class="btn btn-gradient-primary">
                                        <i class="fa fa-print"></i> Print Timetable
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <!-- Filters -->
                        <form method="GET" action="{{ route('examination-schedule.timetable') }}" class="mb-4">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="center_id">Centre</label>
                                        <select name="center_id" id="center_id" class="form-control">
                                            <option value="">All Centres</option>
                                            @foreach($centers as $center)
                                                <option value="{{ $center->id }}" {{ $centerId == $center->id ? 'selected' : '' }}>
                                                    {{ $center->center_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="examination_id">Exam Type</label>
                                        <select name="examination_id" id="examination_id" class="form-control">
                                            <option value="">All Types</option>
                                            @foreach($examinations as $examination)
                                                <option value="{{ $examination->id }}" {{ $examinationId == $examination->id ? 'selected' : '' }}>
                                                    {{ $examination->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="date_from">From Date</label>
                                        <input type="date" name="date_from" id="date_from" class="form-control" value="{{ $dateFrom }}">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="date_to">To Date</label>
                                        <input type="date" name="date_to" id="date_to" class="form-control" value="{{ $dateTo }}">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>&nbsp;</label>
                                        <button type="submit" class="btn btn-primary btn-block">
                                            <i class="fa fa-search"></i> Filter
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        @if($groupedSchedules->count() > 0)
                            @foreach($groupedSchedules as $date => $schedules)
                                <div class="timetable-day mb-4">
                                    <div class="day-header">
                                        <h5 class="mb-0">
                                            <i class="fas fa-calendar-day text-primary"></i>
                                            {{ \Carbon\Carbon::parse($date)->format('l, F j, Y') }}
                                        </h5>
                                    </div>
                                    
                                    <div class="table-responsive mt-3">
                                        <table class="table table-bordered timetable-table">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th width="120">Time</th>
                                                    <th>Subject</th>
                                                    <th>Teacher</th>
                                                    <th>Venue</th>
                                                    <th>Centre</th>
                                                    <th>Exam Type</th>
                                                    <th>Capacity</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($schedules->sortBy('classDuration.sort_order') as $schedule)
                                                    <tr class="{{ $schedule->hasConflicts() ? 'table-warning' : '' }}">
                                                        <td class="time-slot">
                                                            <strong>{{ $schedule->time_range }}</strong>
                                                        </td>
                                                        <td>
                                                            <strong>{{ $schedule->subject_name }}</strong><br>
                                                            <small class="text-muted">{{ $schedule->subject_code }}</small>
                                                        </td>
                                                        <td>
                                                            <i class="fas fa-user-tie text-primary"></i>
                                                            {{ $schedule->teacher_name }}
                                                        </td>
                                                        <td>
                                                            <strong>{{ $schedule->venue->venue_name }}</strong><br>
                                                            <small class="text-muted">{{ $schedule->venue->venue_code }}</small>
                                                        </td>
                                                        <td>{{ $schedule->center->center_name }}</td>
                                                        <td>
                                                            <span class="badge badge-primary">{{ $schedule->examination->name }}</span>
                                                        </td>
                                                        <td>
                                                            <span class="badge badge-secondary">{{ $schedule->venue->capacity }}</span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-calendar-times fa-4x text-muted mb-3"></i>
                                <h5 class="text-muted">No examination schedules found</h5>
                                <p class="text-muted">Try adjusting your filters or create new schedules.</p>
                                @if(Auth::user()->hasPermission('create-examination-schedule'))
                                    <a href="{{ route('examination-schedule.create') }}" class="btn btn-primary">
                                        <i class="fa fa-plus"></i> Create Schedule
                                    </a>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
.btn-gradient-primary {
    background: linear-gradient(45deg, #007bff 0%, #0056b3 100%);
    border: none;
    color: white;
}

.timetable-day {
    border: 1px solid #e3e6f0;
    border-radius: 0.35rem;
    padding: 1rem;
    background: #fff;
}

.day-header {
    background: linear-gradient(45deg, #f8f9fa 0%, #e9ecef 100%);
    padding: 0.75rem 1rem;
    border-radius: 0.25rem;
    border-left: 4px solid #007bff;
}

.timetable-table {
    margin-bottom: 0;
}

.timetable-table th {
    background-color: #f8f9fa;
    border-top: none;
    font-weight: 600;
    color: #495057;
    font-size: 0.875rem;
    text-align: center;
}

.timetable-table td {
    vertical-align: middle;
    border-color: #e3e6f0;
}

.time-slot {
    background-color: #f8f9fa;
    font-weight: 600;
    text-align: center;
    color: #495057;
}

.table-warning {
    background-color: rgba(255, 193, 7, 0.1) !important;
}

.badge-primary {
    background: linear-gradient(45deg, #007bff 0%, #0056b3 100%);
}

.badge-secondary {
    background: linear-gradient(45deg, #6c757d 0%, #545b62 100%);
}
</style>
@endsection
