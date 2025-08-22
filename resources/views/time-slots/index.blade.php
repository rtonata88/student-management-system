@extends('layouts.app')

@section('breadcrumb')
<div class="c-subheader px-3">
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Assessments</li>
        <li class="breadcrumb-item">Examination Schedule</li>
        <li class="breadcrumb-item active">Manage Time Slots</li>
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
                                    <i class="fas fa-clock"></i> Manage Time Slots
                                </h4>
                            </div>
                            <div class="col-md-6 text-right">
                                <a href="{{ route('examination-schedule.index') }}" class="btn" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem; margin-right: 5px;">
                                    <i class="fa fa-arrow-left"></i> Back to Schedule
                                </a>
                                @if(Auth::user()->hasPermission('create-time-slot'))
                                    <a href="{{ route('time-slots.create') }}" class="btn" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                                        <i class="fa fa-plus"></i> Add Time Slot
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="close" data-dismiss="alert">
                                    <span>&times;</span>
                                </button>
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Period Name</th>
                                        <th>Time Range</th>
                                        <th>Duration</th>
                                        <th>Day Type</th>
                                        <th>Type</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($timeSlots as $timeSlot)
                                        <tr>
                                            <td>
                                                <strong>{{ $timeSlot->period_name }}</strong>
                                                <br><small class="text-muted">Order: {{ $timeSlot->sort_order }}</small>
                                            </td>
                                            <td>
                                                <span class="badge badge-info">
                                                    {{ $timeSlot->time_range }}
                                                </span>
                                            </td>
                                            <td>{{ $timeSlot->formatted_duration }}</td>
                                            <td>{{ $timeSlot->day_type }}</td>
                                            <td>
                                                @if($timeSlot->is_break)
                                                    <span class="badge badge-warning">Break</span>
                                                @else
                                                    <span class="badge badge-primary">Class/Exam</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($timeSlot->is_active)
                                                    <span class="badge badge-success">Active</span>
                                                @else
                                                    <span class="badge badge-danger">Inactive</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    @if(Auth::user()->hasPermission('edit-time-slot'))
                                                        <a href="{{ route('time-slots.edit', $timeSlot) }}" class="btn btn-sm" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.25rem 0.5rem; margin-right: 2px;">
                                                            <i class="fa fa-edit"></i> Edit
                                                        </a>
                                                        <form action="{{ route('time-slots.toggle-status', $timeSlot) }}" method="POST" style="display: inline;">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.25rem 0.5rem; margin-right: 2px;" 
                                                                    onclick="return confirm('Are you sure you want to {{ $timeSlot->is_active ? 'deactivate' : 'activate' }} this time slot?')">
                                                                <i class="fa fa-{{ $timeSlot->is_active ? 'pause' : 'play' }}"></i> {{ $timeSlot->is_active ? 'Disable' : 'Enable' }}
                                                            </button>
                                                        </form>
                                                    @endif
                                                    @if(Auth::user()->hasPermission('delete-time-slot'))
                                                        <form action="{{ route('time-slots.destroy', $timeSlot) }}" method="POST" style="display: inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.25rem 0.5rem;" 
                                                                    onclick="return confirm('Are you sure you want to delete this time slot?')">
                                                                <i class="fa fa-trash"></i> Delete
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">
                                                <div class="py-4">
                                                    <i class="fas fa-clock fa-3x text-muted mb-3"></i>
                                                    <h5 class="text-muted">No time slots found</h5>
                                                    <p class="text-muted">Create your first time slot to get started.</p>
                                                    @if(Auth::user()->hasPermission('create-time-slot'))
                                                        <a href="{{ route('time-slots.create') }}" class="btn" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                                                            <i class="fa fa-plus"></i> Add Time Slot
                                                        </a>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
