@extends('layouts.student-portal')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Class Routine</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('student-portal.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('student-portal.academics') }}">Academics</a></li>
                        <li class="breadcrumb-item active">Class Routine</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="header-title mb-0">
                            <i class="fa fa-calendar"></i> My Weekly Class Schedule
                        </h4>
                        @if($routines->count() > 0)
                            <a href="{{ route('student-portal.class-routine.download') }}" 
                               class="btn" 
                               style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;"
                               target="_blank">
                                <i class="fa fa-download"></i> Download PDF
                            </a>
                        @endif
                    </div>
                    
                    @if($routines->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead style="background-color: #f8f9fa; color: #495057; font-weight: bold;">
                                    <tr>
                                        <th style="background-color: #e9ecef; color: #212529; font-weight: bold; padding: 12px;"><i class="fa fa-calendar-day"></i> Day</th>
                                        <th style="background-color: #e9ecef; color: #212529; font-weight: bold; padding: 12px;"><i class="fa fa-clock"></i> Time</th>
                                        <th style="background-color: #e9ecef; color: #212529; font-weight: bold; padding: 12px;"><i class="fa fa-book"></i> Subject</th>
                                        <th style="background-color: #e9ecef; color: #212529; font-weight: bold; padding: 12px;"><i class="fa fa-user"></i> Teacher</th>
                                        <th style="background-color: #e9ecef; color: #212529; font-weight: bold; padding: 12px;"><i class="fa fa-map-marker"></i> Venue</th>
                                        <th style="background-color: #e9ecef; color: #212529; font-weight: bold; padding: 12px;"><i class="fa fa-info-circle"></i> Duration</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $daysOrder = ['monday' => 1, 'tuesday' => 2, 'wednesday' => 3, 'thursday' => 4, 'friday' => 5, 'saturday' => 6, 'sunday' => 7];
                                        $groupedRoutines = $routines->groupBy('day_of_week')->sortBy(function($group, $day) use ($daysOrder) {
                                            return $daysOrder[strtolower($day)] ?? 8;
                                        });
                                    @endphp
                                    
                                    @foreach($groupedRoutines as $day => $dayRoutines)
                                        @foreach($dayRoutines->sortBy('start_time') as $index => $routine)
                                            <tr>
                                                @if($index === 0)
                                                    <td rowspan="{{ $dayRoutines->count() }}" class="align-middle">
                                                        <strong class="text-primary">{{ ucfirst($routine->day_of_week) }}</strong>
                                                    </td>
                                                @endif
                                                <td>
                                                    <strong class="text-success">{{ $routine->formatted_start_time }}</strong>
                                                    <span class="text-muted"> - </span>
                                                    <strong class="text-danger">{{ $routine->formatted_end_time }}</strong>
                                                </td>
                                                <td>
                                                    <strong>{{ $routine->subject_name }}</strong><br>
                                                    <small class="text-muted">{{ $routine->subject_code }}</small>
                                                </td>
                                                <td>
                                                    <i class="fa fa-user-circle text-primary"></i>
                                                    {{ $routine->teacher_name }}
                                                </td>
                                                <td>
                                                    <i class="fa fa-building text-info"></i>
                                                    {{ $routine->venue->venue_name ?? 'TBA' }}
                                                    @if($routine->venue && $routine->venue->capacity)
                                                        <br><small class="text-muted">
                                                            <i class="fa fa-users"></i> Capacity: {{ $routine->venue->capacity }}
                                                        </small>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($routine->classDuration)
                                                        <span class="badge badge-info">
                                                            {{ $routine->classDuration->duration_minutes ?? '60' }} mins
                                                        </span>
                                                    @else
                                                        <span class="badge badge-secondary">Standard</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="mt-3">
                            <div class="alert alert-info">
                                <i class="fa fa-info-circle"></i>
                                <strong>Note:</strong> This schedule shows classes for your registered subjects in the current academic year at your center.
                                If you notice any discrepancies, please contact your academic advisor.
                            </div>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-calendar-alt fa-4x text-muted mb-4"></i>
                            <h5 class="text-muted">No Subject Registrations</h5>
                            <p class="text-muted mb-4">You are not currently registered for any subjects. Class schedules will be available once you have been admitted and registered for subjects.</p>
                            <div class="alert alert-info" role="alert">
                                <i class="fas fa-info-circle"></i>
                                <strong>Note:</strong> If you have submitted an application, please wait for admission approval and subject registration to view your class routine.
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
