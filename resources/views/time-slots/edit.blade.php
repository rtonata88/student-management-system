@extends('layouts.app')

@section('breadcrumb')
<div class="c-subheader px-3">
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Assessments</li>
        <li class="breadcrumb-item">Examination Schedule</li>
        <li class="breadcrumb-item"><a href="{{ route('time-slots.index') }}">Manage Time Slots</a></li>
        <li class="breadcrumb-item active">Edit Time Slot</li>
    </ol>
</div>
@endsection

@section('content')
<div class="container-fluid">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">
                            <i class="fas fa-edit"></i> Edit Time Slot: {{ $timeSlot->period_name }}
                        </h4>
                    </div>

                    <form action="{{ route('time-slots.update', $timeSlot) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="period_name">Period Name <span class="text-danger">*</span></label>
                                        <input type="text" name="period_name" id="period_name" class="form-control" 
                                               value="{{ old('period_name', $timeSlot->period_name) }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="sort_order">Sort Order <span class="text-danger">*</span></label>
                                        <input type="number" name="sort_order" id="sort_order" class="form-control" 
                                               value="{{ old('sort_order', $timeSlot->sort_order) }}" min="1" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="start_time">Start Time <span class="text-danger">*</span></label>
                                        <input type="time" name="start_time" id="start_time" class="form-control" 
                                               value="{{ old('start_time', $timeSlot->start_time->format('H:i')) }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="end_time">End Time <span class="text-danger">*</span></label>
                                        <input type="time" name="end_time" id="end_time" class="form-control" 
                                               value="{{ old('end_time', $timeSlot->end_time->format('H:i')) }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="day_type">Day Type <span class="text-danger">*</span></label>
                                        <select name="day_type" id="day_type" class="form-control" required>
                                            <option value="">Select Day Type</option>
                                            <option value="Weekday" {{ old('day_type', $timeSlot->day_type) == 'Weekday' ? 'selected' : '' }}>Weekday</option>
                                            <option value="Weekend" {{ old('day_type', $timeSlot->day_type) == 'Weekend' ? 'selected' : '' }}>Weekend</option>
                                            <option value="All Days" {{ old('day_type', $timeSlot->day_type) == 'All Days' ? 'selected' : '' }}>All Days</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>&nbsp;</label>
                                        <div class="form-check">
                                            <input type="checkbox" name="is_break" id="is_break" class="form-check-input" 
                                                   value="1" {{ old('is_break', $timeSlot->is_break) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_break">
                                                This is a break period
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-6">
                                    <a href="{{ route('time-slots.index') }}" class="btn btn-secondary">
                                        <i class="fa fa-times"></i> Cancel
                                    </a>
                                </div>
                                <div class="col-md-6 text-right">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-save"></i> Update Time Slot
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
