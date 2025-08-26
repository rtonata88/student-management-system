@extends('layouts.app')

@section('breadcrumb')
<div class="c-subheader px-3">
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Assessments</li>
        <li class="breadcrumb-item"><a href="{{ route('my-modules.index') }}">My Modules</a></li>
        <li class="breadcrumb-item"><a href="{{ route('my-modules.attendance', $allocation->id) }}">Attendance</a></li>
        <li class="breadcrumb-item active">Mark Attendance</li>
    </ol>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0">
                        <i class="fas fa-check-circle"></i> Mark Attendance - {{ $allocation->module->subject_name }}
                    </h5>
                    <small class="text-muted">
                        {{ $allocation->academicYear->academic_year }} | {{ $allocation->center->center_name }}
                    </small>
                </div>
                <div>
                    <a href="{{ route('my-modules.attendance', $allocation->id) }}" 
                       class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Attendance
                    </a>
                </div>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('my-modules.store-attendance', $allocation->id) }}">
                    @csrf
                    
                    <!-- Date and Time Selection -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="attendance_date" class="form-label">Date <span class="text-danger">*</span></label>
                            <input type="date" name="attendance_date" id="attendance_date" 
                                   class="form-control" value="{{ $selectedDate }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="class_time" class="form-label">Class Time <span class="text-danger">*</span></label>
                            <input type="time" name="class_time" id="class_time" 
                                   class="form-control" value="{{ $selectedTime }}" required>
                            <small class="form-text text-muted">
                                This allows for multiple classes per day for the same subject.
                            </small>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-outline-success btn-sm" onclick="markAll('present')">
                                    <i class="fas fa-check"></i> Mark All Present
                                </button>
                                <button type="button" class="btn btn-outline-danger btn-sm" onclick="markAll('absent')">
                                    <i class="fas fa-times"></i> Mark All Absent
                                </button>
                                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="clearAll()">
                                    <i class="fas fa-eraser"></i> Clear All
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Student Attendance List -->
                    @if($students->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Student Number</th>
                                        <th>Student Name</th>
                                        <th>Status</th>
                                        <th>Notes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($students as $index => $student)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td><strong>{{ $student->student_number2 }}</strong></td>
                                            <td>{{ $student->student_names }} {{ $student->surname }}</td>
                                            <td>
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <input type="radio" class="btn-check" name="attendance[{{ $student->id }}]" 
                                                           id="present_{{ $student->id }}" value="present" autocomplete="off">
                                                    <label class="btn btn-outline-success" for="present_{{ $student->id }}">
                                                        <i class="fas fa-check"></i> Present
                                                    </label>

                                                    <input type="radio" class="btn-check" name="attendance[{{ $student->id }}]" 
                                                           id="absent_{{ $student->id }}" value="absent" autocomplete="off">
                                                    <label class="btn btn-outline-danger" for="absent_{{ $student->id }}">
                                                        <i class="fas fa-times"></i> Absent
                                                    </label>

                                                    <input type="radio" class="btn-check" name="attendance[{{ $student->id }}]" 
                                                           id="late_{{ $student->id }}" value="late" autocomplete="off">
                                                    <label class="btn btn-outline-warning" for="late_{{ $student->id }}">
                                                        <i class="fas fa-clock"></i> Late
                                                    </label>

                                                    <input type="radio" class="btn-check" name="attendance[{{ $student->id }}]" 
                                                           id="excused_{{ $student->id }}" value="excused" autocomplete="off">
                                                    <label class="btn btn-outline-info" for="excused_{{ $student->id }}">
                                                        <i class="fas fa-info-circle"></i> Excused
                                                    </label>
                                                </div>
                                            </td>
                                            <td>
                                                <input type="text" name="notes[{{ $student->id }}]" 
                                                       class="form-control form-control-sm" 
                                                       placeholder="Optional notes..." maxlength="255">
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12 text-end">
                                <button type="submit" class="btn" 
                                        style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                                    <i class="fas fa-save"></i> Save Attendance
                                </button>
                                <a href="{{ route('my-modules.attendance', $allocation->id) }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-times"></i> Cancel
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i>
                            No students are enrolled in this module.
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function markAll(status) {
    const radios = document.querySelectorAll(`input[type="radio"][value="${status}"]`);
    radios.forEach(radio => {
        radio.checked = true;
    });
}

function clearAll() {
    const radios = document.querySelectorAll('input[type="radio"]');
    radios.forEach(radio => {
        radio.checked = false;
    });
}

// Auto-select present for all students by default
document.addEventListener('DOMContentLoaded', function() {
    markAll('present');
});
</script>
@endsection
