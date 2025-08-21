@extends('layouts.app')

@section('breadcrumb')
<div class="c-subheader px-3">
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Assessments</li>
        <li class="breadcrumb-item"><a href="{{ route('examination-schedule.index') }}">Examination Schedule</a></li>
        <li class="breadcrumb-item active">Create Schedule</li>
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
                        <h4 class="card-title mb-0">
                            <i class="fas fa-plus"></i> Create Examination Schedule
                            <small class="text-muted">{{ $currentAcademicYear->academic_year }}</small>
                        </h4>
                    </div>

                    <form action="{{ route('examination-schedule.store') }}" method="POST" id="scheduleForm">
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

                            <div id="conflictAlert" class="alert alert-warning" style="display: none;">
                                <strong>Conflicts Detected:</strong>
                                <ul id="conflictList"></ul>
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
                                        <label for="examination_id">Examination Type <span class="text-danger">*</span></label>
                                        <select name="examination_id" id="examination_id" class="form-control" required>
                                            <option value="">Select Examination Type</option>
                                            @foreach($examinations as $examination)
                                                <option value="{{ $examination->id }}" {{ old('examination_id') == $examination->id ? 'selected' : '' }}>
                                                    {{ $examination->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="subject_allocation_id">Subject & Teacher <span class="text-danger">*</span></label>
                                        <select name="subject_allocation_id" id="subject_allocation_id" class="form-control" required>
                                            <option value="">Select Centre First</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="venue_id">Venue <span class="text-danger">*</span></label>
                                        <select name="venue_id" id="venue_id" class="form-control" required>
                                            <option value="">Select Centre First</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exam_date">Examination Date <span class="text-danger">*</span></label>
                                        <input type="date" name="exam_date" id="exam_date" class="form-control" 
                                               value="{{ old('exam_date') }}" min="{{ date('Y-m-d') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="class_duration_id">Time Slot <span class="text-danger">*</span></label>
                                        <select name="class_duration_id" id="class_duration_id" class="form-control" required>
                                            <option value="">Select Time Slot</option>
                                            @foreach($classDurations as $duration)
                                                <option value="{{ $duration->id }}" {{ old('class_duration_id') == $duration->id ? 'selected' : '' }}>
                                                    {{ $duration->period_name }} ({{ $duration->time_range }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="notes">Notes</label>
                                        <textarea name="notes" id="notes" class="form-control" rows="3" 
                                                  placeholder="Additional notes or instructions...">{{ old('notes') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-6">
                                    <a href="{{ route('examination-schedule.index') }}" class="btn btn-secondary">
                                        <i class="fa fa-arrow-left"></i> Back to List
                                    </a>
                                </div>
                                <div class="col-md-6 text-right">
                                    <button type="submit" class="btn btn-gradient-primary">
                                        <i class="fa fa-save"></i> Create Schedule
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

@section('styles')
<style>
.btn-gradient-primary {
    background: linear-gradient(45deg, #007bff 0%, #0056b3 100%);
    border: none;
    color: white;
}

.form-group label {
    font-weight: 600;
    color: #495057;
}

.text-danger {
    color: #dc3545 !important;
}
</style>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Load subject allocations when centre changes
    $('#center_id').change(function() {
        var centerId = $(this).val();
        var subjectSelect = $('#subject_allocation_id');
        var venueSelect = $('#venue_id');
        
        // Reset selects
        subjectSelect.html('<option value="">Loading...</option>');
        venueSelect.html('<option value="">Loading...</option>');
        
        if (centerId) {
            // Load subject allocations
            $.get('{{ route("examination-schedule.get-subject-allocations") }}', {center_id: centerId})
                .done(function(data) {
                    subjectSelect.html('<option value="">Select Subject & Teacher</option>');
                    $.each(data, function(index, allocation) {
                        var teacherName = 'Not Assigned';
                        if (allocation.user) {
                            var fullName = (allocation.user.surname + ' ' + allocation.user.other_names).trim();
                            teacherName = fullName || allocation.user.name;
                        }
                        
                        subjectSelect.append(
                            '<option value="' + allocation.id + '">' + 
                            allocation.module.subject_name + ' (' + allocation.module.subject_code + ') - ' + teacherName +
                            '</option>'
                        );
                    });
                })
                .fail(function() {
                    subjectSelect.html('<option value="">Error loading subjects</option>');
                });
            
            // Load venues
            $.get('{{ route("examination-schedule.get-venues") }}', {center_id: centerId})
                .done(function(data) {
                    venueSelect.html('<option value="">Select Venue</option>');
                    $.each(data, function(index, venue) {
                        venueSelect.append(
                            '<option value="' + venue.id + '" data-capacity="' + venue.capacity + '">' + 
                            venue.venue_name + ' (' + venue.venue_code + ') - ' + venue.capacity + ' students' +
                            '</option>'
                        );
                    });
                })
                .fail(function() {
                    venueSelect.html('<option value="">Error loading venues</option>');
                });
        } else {
            subjectSelect.html('<option value="">Select Centre First</option>');
            venueSelect.html('<option value="">Select Centre First</option>');
        }
    });
    
    // Check for conflicts when key fields change
    function checkConflicts() {
        var subjectAllocationId = $('#subject_allocation_id').val();
        var classDurationId = $('#class_duration_id').val();
        var examDate = $('#exam_date').val();
        var venueId = $('#venue_id').val();
        
        if (subjectAllocationId && classDurationId && examDate && venueId) {
            $.get('{{ route("examination-schedule.check-conflicts") }}', {
                subject_allocation_id: subjectAllocationId,
                class_duration_id: classDurationId,
                exam_date: examDate,
                venue_id: venueId
            })
            .done(function(data) {
                var conflictAlert = $('#conflictAlert');
                var conflictList = $('#conflictList');
                
                if (data.conflicts && data.conflicts.length > 0) {
                    conflictList.empty();
                    $.each(data.conflicts, function(index, conflict) {
                        conflictList.append('<li>' + conflict + '</li>');
                    });
                    conflictAlert.show();
                } else {
                    conflictAlert.hide();
                }
            });
        } else {
            $('#conflictAlert').hide();
        }
    }
    
    $('#subject_allocation_id, #class_duration_id, #exam_date, #venue_id').change(checkConflicts);
    
    // Form validation
    $('#scheduleForm').submit(function(e) {
        var conflicts = $('#conflictAlert').is(':visible');
        if (conflicts) {
            if (!confirm('There are conflicts with this schedule. Do you want to proceed anyway?')) {
                e.preventDefault();
                return false;
            }
        }
    });
});
</script>
@endsection
