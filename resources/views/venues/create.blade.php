@extends('layouts.app')

@section('breadcrumb')
<div class="c-subheader px-3">
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Assessments</li>
        <li class="breadcrumb-item">Examination Schedule</li>
        <li class="breadcrumb-item"><a href="{{ route('venues.index') }}">Manage Venues</a></li>
        <li class="breadcrumb-item active">Add Venue</li>
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
                            <i class="fas fa-plus"></i> Add New Venue
                        </h4>
                    </div>

                    <form action="{{ route('venues.store') }}" method="POST">
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
                                        <label for="venue_name">Venue Name <span class="text-danger">*</span></label>
                                        <input type="text" name="venue_name" id="venue_name" class="form-control" 
                                               value="{{ old('venue_name') }}" required>
                                        <small class="form-text text-muted">e.g., Main Hall, Computer Lab A</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="venue_code">Venue Code <span class="text-danger">*</span></label>
                                        <input type="text" name="venue_code" id="venue_code" class="form-control" 
                                               value="{{ old('venue_code') }}" required>
                                        <small class="form-text text-muted">e.g., MH01, CLA</small>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="center_id">Centre <span class="text-danger">*</span></label>
                                        <select name="center_id" id="center_id" class="form-control" required>
                                            <option value="">Select Centre</option>
                                            @foreach($centers as $center)
                                                <option value="{{ $center->id }}" {{ old('center_id') == $center->id ? 'selected' : '' }}>
                                                    {{ $center->center_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="venue_type">Venue Type <span class="text-danger">*</span></label>
                                        <select name="venue_type" id="venue_type" class="form-control" required>
                                            <option value="">Select Type</option>
                                            <option value="Hall" {{ old('venue_type') == 'Hall' ? 'selected' : '' }}>Hall</option>
                                            <option value="Classroom" {{ old('venue_type') == 'Classroom' ? 'selected' : '' }}>Classroom</option>
                                            <option value="Laboratory" {{ old('venue_type') == 'Laboratory' ? 'selected' : '' }}>Laboratory</option>
                                            <option value="Auditorium" {{ old('venue_type') == 'Auditorium' ? 'selected' : '' }}>Auditorium</option>
                                            <option value="Library" {{ old('venue_type') == 'Library' ? 'selected' : '' }}>Library</option>
                                            <option value="Other" {{ old('venue_type') == 'Other' ? 'selected' : '' }}>Other</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="capacity">Capacity <span class="text-danger">*</span></label>
                                        <input type="number" name="capacity" id="capacity" class="form-control" 
                                               value="{{ old('capacity') }}" min="1" required>
                                        <small class="form-text text-muted">Maximum number of students</small>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea name="description" id="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                                <small class="form-text text-muted">Optional additional details about the venue</small>
                            </div>
                        </div>

                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-6">
                                    <a href="{{ route('venues.index') }}" class="btn" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                                        <i class="fa fa-times"></i> Cancel
                                    </a>
                                </div>
                                <div class="col-md-6 text-right">
                                    <button type="submit" class="btn" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                                        <i class="fa fa-save"></i> Create Venue
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
