@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="card-title mb-0">
                                <i class="fa fa-calendar"></i> Class Routine Management
                            </h4>
                        </div>
                        <div class="col-md-6 text-right">
                            @if(Auth::user()->hasPermission('view-venue'))
                            <a href="{{ route('venues.index') }}" class="btn" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; margin-right: 5px; padding: 0.375rem 0.75rem;">
                                <i class="fa fa-building"></i> Manage Venues
                            </a>
                            @endif
                            @if(Auth::user()->hasPermission('view-class-duration'))
                            <a href="{{ route('class-durations.index') }}" class="btn" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; margin-right: 5px; padding: 0.375rem 0.75rem;">
                                <i class="fa fa-clock"></i> Class Duration
                            </a>
                            @endif
                            @if(Auth::user()->hasPermission('create-class-routine'))
                            <a href="{{ route('class-routine.create') }}" class="btn" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; margin-right: 5px; padding: 0.375rem 0.75rem;">
                                <i class="fa fa-plus"></i> Add New Schedule
                            </a>
                            @endif
                            @if(Auth::user()->hasPermission('print-class-routine'))
                            <a href="{{ route('class-routine.print', request()->all()) }}" target="_blank" class="btn" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                                <i class="fa fa-print"></i> Print Routine
                            </a>
                            @endif
                        </div>
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
                                    <button type="submit" class="btn" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                                        <i class="fa fa-filter"></i> Filter
                                    </button>
                                    <a href="{{ route('class-routine.index') }}" class="btn" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem; margin-left: 5px;">
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
                                        <th>Start Time</th>
                                        <th>End Time</th>
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
                                                <strong>{{ $schedule->formatted_start_time }}</strong>
                                            </td>
                                            <td>
                                                <strong>{{ $schedule->formatted_end_time }}</strong>
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
                                                <div class="d-flex gap-2">
                                                    @if(Auth::user()->hasPermission('view-class-routine'))
                                                    <a href="{{ route('class-routine.show', $schedule->id) }}" 
                                                       class="btn btn-sm btn-info" title="View">
                                                        <i class="fa fa-eye"></i> View
                                                    </a>
                                                    @endif
                                                    @if(Auth::user()->hasPermission('edit-class-routine'))
                                                    <a href="{{ route('class-routine.edit', $schedule->id) }}" 
                                                       class="btn btn-sm btn-warning" title="Edit">
                                                        <i class="fa fa-edit"></i> Edit
                                                    </a>
                                                    @endif
                                                    @if(Auth::user()->hasPermission('delete-class-routine'))
                                                    <form method="POST" action="{{ route('class-routine.destroy', $schedule->id) }}" 
                                                          style="display: inline;" 
                                                          onsubmit="return confirm('Are you sure you want to delete this class schedule?\n\nSubject: {{ $schedule->subject_name }}\nTeacher: {{ $schedule->teacher_name }}\nDay: {{ $schedule->formatted_day }}\nTime: {{ $schedule->formatted_start_time }} - {{ $schedule->formatted_end_time }}\n\nThis action cannot be undone.')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                                            <i class="fa fa-trash"></i> Delete
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
