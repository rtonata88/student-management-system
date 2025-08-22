@extends('layouts.app')

@section('breadcrumb')
<div class="c-subheader px-3">
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Assessments</li>
        <li class="breadcrumb-item">Examination Schedule</li>
        <li class="breadcrumb-item"><a href="{{ route('time-slots.index') }}">Manage Time Slots</a></li>
        <li class="breadcrumb-item active">Add Time Slot</li>
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
                            <i class="fas fa-plus"></i> Add New Time Slot
                        </h4>
                    </div>

                    <form action="{{ route('time-slots.store') }}" method="POST">
                        @csrf
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
                                               value="{{ old('period_name') }}" required>
                                        <small class="form-text text-muted">e.g., Period 1, Morning Session</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="sort_order">Sort Order <span class="text-danger">*</span></label>
                                        <input type="number" name="sort_order" id="sort_order" class="form-control" 
                                               value="{{ old('sort_order', 1) }}" min="1" required>
                                        <small class="form-text text-muted">Display order (1, 2, 3...)</small>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="start_time">Start Time <span class="text-danger">*</span></label>
                                        <input type="time" name="start_time" id="start_time" class="form-control" 
                                               value="{{ old('start_time') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="end_time">End Time <span class="text-danger">*</span></label>
                                        <input type="time" name="end_time" id="end_time" class="form-control" 
                                               value="{{ old('end_time') }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="day_type">Day Type <span class="text-danger">*</span></label>
                                        <select name="day_type" id="day_type" class="form-control" required>
                                            <option value="">Select Day Type</option>
                                            <option value="Weekday" {{ old('day_type') == 'Weekday' ? 'selected' : '' }}>Weekday</option>
                                            <option value="Weekend" {{ old('day_type') == 'Weekend' ? 'selected' : '' }}>Weekend</option>
                                            <option value="All Days" {{ old('day_type') == 'All Days' ? 'selected' : '' }}>All Days</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>&nbsp;</label>
                                        <div class="form-check">
                                            <input type="checkbox" name="is_break" id="is_break" class="form-check-input" 
                                                   value="1" {{ old('is_break') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_break">
                                                This is a break period
                                            </label>
                                        </div>
                                        <small class="form-text text-muted">Check if this is a break/recess time</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-6">
                                    <a href="{{ route('time-slots.index') }}" class="btn" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                                        <i class="fa fa-times"></i> Cancel
                                    </a>
                                </div>
                                <div class="col-md-6 text-right">
                                    <button type="submit" class="btn" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                                        <i class="fa fa-save"></i> Create Time Slot
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
