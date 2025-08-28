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
                                <i class="fa fa-eye"></i> View Class Schedule
                            </h4>
                        </div>
                        <div class="col-md-6 text-right">
                            <a href="{{ route('class-routine.index') }}" class="btn" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                                <i class="fa fa-arrow-left"></i> Back to List
                            </a>
                            @if(Auth::user()->hasPermission('edit-class-routine'))
                            <a href="{{ route('class-routine.edit', $schedule->id) }}" class="btn" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem; margin-left: 5px;">
                                <i class="fa fa-edit"></i> Edit Schedule
                            </a>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0"><i class="fa fa-info-circle"></i> Schedule Information</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td><strong>Academic Year:</strong></td>
                                            <td>{{ $schedule->academicYear->academic_year }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Center:</strong></td>
                                            <td>{{ $schedule->center->center_name }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Day of Week:</strong></td>
                                            <td>{{ $schedule->formatted_day }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Start Time:</strong></td>
                                            <td><span class="badge badge-primary">{{ $schedule->formatted_start_time }}</span></td>
                                        </tr>
                                        <tr>
                                            <td><strong>End Time:</strong></td>
                                            <td><span class="badge badge-success">{{ $schedule->formatted_end_time }}</span></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Status:</strong></td>
                                            <td>
                                                @if($schedule->is_active)
                                                    <span class="badge badge-success">Active</span>
                                                @else
                                                    <span class="badge badge-secondary">Inactive</span>
                                                @endif
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0"><i class="fa fa-book"></i> Subject & Teacher</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td><strong>Subject:</strong></td>
                                            <td>{{ $schedule->subject_name }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Subject Code:</strong></td>
                                            <td><span class="badge badge-info">{{ $schedule->subject_code }}</span></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Teacher:</strong></td>
                                            <td>
                                                <i class="fa fa-user text-primary"></i>
                                                {{ $schedule->teacher_name }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Venue:</strong></td>
                                            <td>
                                                <i class="fa fa-map-marker text-info"></i>
                                                {{ $schedule->venue->venue_name }}
                                                @if($schedule->venue->capacity)
                                                    <br><small class="text-muted">Capacity: {{ $schedule->venue->capacity }}</small>
                                                @endif
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0"><i class="fa fa-calendar"></i> Effective Period</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p><strong>Effective From:</strong> {{ $schedule->effective_from->format('M d, Y') }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p><strong>Effective To:</strong> 
                                                @if($schedule->effective_to)
                                                    {{ $schedule->effective_to->format('M d, Y') }}
                                                @else
                                                    <span class="text-success">Ongoing</span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                    @if($schedule->notes)
                                    <div class="row">
                                        <div class="col-md-12">
                                            <p><strong>Notes:</strong></p>
                                            <div class="alert alert-light">
                                                {{ $schedule->notes }}
                                            </div>
                                        </div>
                                    </div>
                                    @endif
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
