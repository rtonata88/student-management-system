@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fa fa-calendar"></i> Class Routine Management
                    </h3>
                    <div class="card-tools">
                        @can('create-class-routine')
                        <a href="{{ route('class-routine.create') }}" class="btn btn-primary btn-sm">
                            <i class="fa fa-plus"></i> Add New Schedule
                        </a>
                        @endcan
                        @can('print-class-routine')
                        <a href="{{ route('class-routine.print', request()->all()) }}" target="_blank" class="btn btn-info btn-sm">
                            <i class="fa fa-print"></i> Print Routine
                        </a>
                        @endcan
                    </div>
                </div>

                <div class="card-body">
                    <!-- Filters -->
                    <form method="GET" action="{{ route('class-routine.index') }}" class="mb-4">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="academic_year_id">Academic Year</label>
                                <select name="academic_year_id" id="academic_year_id" class="form-control">
                                    <option value="">All Academic Years</option>
                                    @foreach($academicYears as $year)
                                        <option value="{{ $year->id }}" {{ $selectedAcademicYear == $year->id ? 'selected' : '' }}>
                                            {{ $year->academic_year }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="center_id">Center</label>
                                <select name="center_id" id="center_id" class="form-control">
                                    <option value="">All Centers</option>
                                    @foreach($centers as $center)
                                        <option value="{{ $center->id }}" {{ $selectedCenter == $center->id ? 'selected' : '' }}>
                                            {{ $center->center_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="day_of_week">Day of Week</label>
                                <select name="day_of_week" id="day_of_week" class="form-control">
                                    <option value="">All Days</option>
                                    @foreach($daysOfWeek as $key => $day)
                                        <option value="{{ $key }}" {{ $selectedDay == $key ? 'selected' : '' }}>
                                            {{ $day }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>&nbsp;</label>
                                <div>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-filter"></i> Filter
                                    </button>
                                    <a href="{{ route('class-routine.index') }}" class="btn btn-secondary">
                                        <i class="fa fa-refresh"></i> Reset
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($schedules->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Day</th>
                                        <th>Time</th>
                                        <th>Subject</th>
                                        <th>Teacher</th>
                                        <th>Venue</th>
                                        <th>Center</th>
                                        <th>Effective Period</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($schedules as $schedule)
                                        <tr>
                                            <td>{{ $schedule->formatted_day }}</td>
                                            <td>
                                                <strong>{{ $schedule->classDuration->period_name }}</strong><br>
                                                <small class="text-muted">{{ $schedule->classDuration->time_range }}</small>
                                            </td>
                                            <td>
                                                <strong>{{ $schedule->subject_name }}</strong><br>
                                                <small class="text-muted">{{ $schedule->subject_code }}</small>
                                            </td>
                                            <td>
                                                <i class="fa fa-user text-primary"></i>
                                                {{ $schedule->teacher_name }}
                                            </td>
                                            <td>
                                                <i class="fa fa-map-marker text-info"></i>
                                                {{ $schedule->venue->venue_name }}
                                                @if($schedule->venue->capacity)
                                                    <br><small class="text-muted">Capacity: {{ $schedule->venue->capacity }}</small>
                                                @endif
                                            </td>
                                            <td>{{ $schedule->center->center_name }}</td>
                                            <td>
                                                <strong>From:</strong> {{ $schedule->effective_from->format('M d, Y') }}<br>
                                                @if($schedule->effective_to)
                                                    <strong>To:</strong> {{ $schedule->effective_to->format('M d, Y') }}
                                                @else
                                                    <span class="text-success">Ongoing</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    @can('edit-class-routine')
                                                    <a href="{{ route('class-routine.edit', $schedule->id) }}" 
                                                       class="btn btn-sm btn-warning" title="Edit">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    @endcan
                                                    @can('delete-class-routine')
                                                    <form method="POST" action="{{ route('class-routine.destroy', $schedule->id) }}" 
                                                          style="display: inline;" 
                                                          onsubmit="return confirm('Are you sure you want to delete this schedule?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </form>
                                                    @endcan
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info">
                            <i class="fa fa-info-circle"></i>
                            No class schedules found. 
                            @can('create-class-routine')
                                <a href="{{ route('class-routine.create') }}">Create the first schedule</a>.
                            @endcan
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
