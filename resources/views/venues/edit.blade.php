@extends('layouts.app')

@section('breadcrumb')
<div class="c-subheader px-3">
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Assessments</li>
        <li class="breadcrumb-item">Examination Schedule</li>
        <li class="breadcrumb-item"><a href="{{ route('venues.index') }}">Manage Venues</a></li>
        <li class="breadcrumb-item active">Edit Venue</li>
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
                            <i class="fas fa-edit"></i> Edit Venue: {{ $venue->venue_name }}
                        </h4>
                    </div>

                    <form action="{{ route('venues.update', $venue) }}" method="POST">
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
                                        <label for="venue_name">Venue Name <span class="text-danger">*</span></label>
                                        <input type="text" name="venue_name" id="venue_name" class="form-control" 
                                               value="{{ old('venue_name', $venue->venue_name) }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="venue_code">Venue Code <span class="text-danger">*</span></label>
                                        <input type="text" name="venue_code" id="venue_code" class="form-control" 
                                               value="{{ old('venue_code', $venue->venue_code) }}" required>
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
                                                <option value="{{ $center->id }}" {{ old('center_id', $venue->center_id) == $center->id ? 'selected' : '' }}>
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
                                            <option value="Hall" {{ old('venue_type', $venue->venue_type) == 'Hall' ? 'selected' : '' }}>Hall</option>
                                            <option value="Classroom" {{ old('venue_type', $venue->venue_type) == 'Classroom' ? 'selected' : '' }}>Classroom</option>
                                            <option value="Laboratory" {{ old('venue_type', $venue->venue_type) == 'Laboratory' ? 'selected' : '' }}>Laboratory</option>
                                            <option value="Auditorium" {{ old('venue_type', $venue->venue_type) == 'Auditorium' ? 'selected' : '' }}>Auditorium</option>
                                            <option value="Library" {{ old('venue_type', $venue->venue_type) == 'Library' ? 'selected' : '' }}>Library</option>
                                            <option value="Other" {{ old('venue_type', $venue->venue_type) == 'Other' ? 'selected' : '' }}>Other</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="capacity">Capacity <span class="text-danger">*</span></label>
                                        <input type="number" name="capacity" id="capacity" class="form-control" 
                                               value="{{ old('capacity', $venue->capacity) }}" min="1" required>
                                        <small class="form-text text-muted">Maximum number of students</small>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea name="description" id="description" class="form-control" rows="3">{{ old('description', $venue->description) }}</textarea>
                            </div>
                        </div>

                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-6">
                                    <a href="{{ route('venues.index') }}" class="btn btn-secondary">
                                        <i class="fa fa-times"></i> Cancel
                                    </a>
                                </div>
                                <div class="col-md-6 text-right">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-save"></i> Update Venue
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
