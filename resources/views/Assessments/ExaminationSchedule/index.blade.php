@extends('layouts.app')

@section('breadcrumb')
<div class="c-subheader px-3">
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Assessments</li>
        <li class="breadcrumb-item active">Examination Schedule</li>
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
                                    <i class="fas fa-calendar-alt"></i> Examination Schedule
                                    <small class="text-muted">{{ $currentAcademicYear->academic_year }}</small>
                                </h4>
                            </div>
                            <div class="col-md-6 text-right">
                                @if(Auth::user()->hasPermission('view-venue'))
                                    <a href="{{ route('venues.index') }}" class="btn" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; margin-right: 5px; padding: 0.375rem 0.75rem;">
                                        <i class="fa fa-building"></i> Manage Venues
                                    </a>
                                @endif
                                @if(Auth::user()->hasPermission('view-time-slot'))
                                    <a href="{{ route('time-slots.index') }}" class="btn" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; margin-right: 5px; padding: 0.375rem 0.75rem;">
                                        <i class="fa fa-clock"></i> Manage Time Slots
                                    </a>
                                @endif
                                @if(Auth::user()->hasPermission('create-examination-schedule'))
                                    <a href="{{ route('examination-schedule.create') }}" class="btn" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; margin-right: 5px; padding: 0.375rem 0.75rem;">
                                        <i class="fa fa-plus"></i> Add Schedule
                                    </a>
                                @endif
                                @if(Auth::user()->hasPermission('view-examination-schedule'))
                                    <a href="{{ route('examination-schedule.timetable', request()->query()) }}" class="btn" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; margin-right: 5px; padding: 0.375rem 0.75rem;">
                                        <i class="fa fa-table"></i> View Timetable
                                    </a>
                                @endif
                                @if(Auth::user()->hasPermission('print-examination-schedule'))
                                    <a href="{{ route('examination-schedule.print', request()->query()) }}" target="_blank" class="btn" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                                        <i class="fa fa-print"></i> Print
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <!-- Filters -->
                        <form method="GET" action="{{ route('examination-schedule.index') }}" class="mb-4">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="search">Search Subject</label>
                                        <input type="text" name="search" id="search" class="form-control" 
                                               value="{{ $search }}" placeholder="Subject name or code">
                                    </div>
                                </div>
                                <div class="col-md-2">
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
                                <div class="col-md-2">
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
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label>&nbsp;</label>
                                        <button type="submit" class="btn btn-block" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                                            <i class="fa fa-search"></i> Filter
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        @if($schedules->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Date</th>
                                            <th>Time</th>
                                            <th>Exam Type</th>
                                            <th>Subject</th>
                                            <th>Teacher</th>
                                            <th>Centre</th>
                                            <th>Venue</th>
                                            <th>Capacity</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($schedules as $schedule)
                                            <tr>
                                                <td>
                                                    <strong>{{ $schedule->exam_date->format('M j, Y') }}</strong><br>
                                                    <small class="text-muted">{{ $schedule->exam_date->format('l') }}</small>
                                                </td>
                                                <td>
                                                    <span class="badge badge-info">{{ $schedule->time_range }}</span>
                                                </td>
                                                <td>
                                                    <span class="badge badge-primary">{{ $schedule->examination->name }}</span>
                                                </td>
                                                <td>
                                                    <strong>{{ $schedule->subject_name }}</strong><br>
                                                    <small class="text-muted">{{ $schedule->subject_code }}</small>
                                                </td>
                                                <td>
                                                    <i class="fas fa-user-tie text-primary"></i>
                                                    {{ $schedule->teacher_name }}
                                                </td>
                                                <td>{{ $schedule->center->center_name }}</td>
                                                <td>
                                                    <strong>{{ $schedule->venue->venue_name }}</strong><br>
                                                    <small class="text-muted">{{ $schedule->venue->venue_code }}</small>
                                                </td>
                                                <td>
                                                    <span class="badge badge-secondary">{{ $schedule->venue->capacity }} students</span>
                                                </td>
                                                <td>
                                                    @if($schedule->hasConflicts())
                                                        <span class="badge badge-warning" title="{{ implode(', ', $schedule->getConflicts()) }}">
                                                            <i class="fas fa-exclamation-triangle"></i> Conflict
                                                        </span>
                                                    @else
                                                        <span class="badge badge-success">
                                                            <i class="fas fa-check"></i> OK
                                                        </span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        @if(Auth::user()->hasPermission('edit-examination-schedule'))
                                                            <a href="{{ route('examination-schedule.edit', $schedule->id) }}" 
                                                               class="btn btn-sm btn-outline-primary" title="Edit">
                                                                <i class="fa fa-edit"></i>
                                                            </a>
                                                        @endif
                                                        @if(Auth::user()->hasPermission('delete-examination-schedule'))
                                                            <form action="{{ route('examination-schedule.destroy', $schedule->id) }}" 
                                                                  method="POST" class="d-inline"
                                                                  onsubmit="return confirm('Are you sure you want to delete this schedule?')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                                                    <i class="fa fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="d-flex justify-content-center">
                                {{ $schedules->appends(request()->query())->links() }}
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                                <p class="text-muted">No examination schedules found for the current academic year.</p>
                                @if(Auth::user()->hasPermission('create-examination-schedule'))
                                    <a href="{{ route('examination-schedule.create') }}" class="btn" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 12px 24px;">
                                        <i class="fa fa-plus"></i> Create First Schedule
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

.btn-gradient-info {
    background: linear-gradient(45deg, #17a2b8 0%, #138496 100%);
    border: none;
    color: white;
}

.btn-gradient-secondary {
    background: linear-gradient(45deg, #6c757d 0%, #545b62 100%);
    border: none;
    color: white;
}

.badge-info {
    background: linear-gradient(45deg, #17a2b8 0%, #138496 100%);
}

.badge-primary {
    background: linear-gradient(45deg, #007bff 0%, #0056b3 100%);
}

.table th {
    background-color: #f8f9fa;
    border-top: none;
    font-weight: 600;
    color: #495057;
    font-size: 0.875rem;
}
</style>
@endsection
