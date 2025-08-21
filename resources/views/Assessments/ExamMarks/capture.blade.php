@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h4 class="mb-0">Capture {{ $examPaper->paper_name }} marks</h4>
                        </div>
                        <div class="col-md-4 text-right">
                            <a href="{{ route('exam-marks.index') }}" class="btn btn-outline-light btn-sm">
                                <i class="fa fa-arrow-left"></i> Back to Modules
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Module Information -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Module Name:</strong></td>
                                    <td>{{ $module->subject_name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Module Code:</strong></td>
                                    <td>{{ $module->subject_code }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Academic Year:</strong></td>
                                    <td>{{ $currentAcademicYear->academic_year }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Centre:</strong></td>
                                    <td>{{ $centre->center_name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Exam Type:</strong></td>
                                    <td>{{ $examType->name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Exam Paper:</strong></td>
                                    <td>{{ $examPaper->paper_name }} ({{ $examPaperWeight->weight }}%)</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- Search Form -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <form method="GET">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control" placeholder="Search by student number, surname, or first name" value="{{ $search }}">
                                    <div class="input-group-append">
                                        <button class="btn btn-gradient-info" type="submit">
                                            <i class="fa fa-search"></i> Search
                                        </button>
                                        <a href="{{ route('exam-marks.capture', [$examType->id, $module->id, $centre->id, $examPaper->id]) }}" class="btn btn-secondary">
                                            <i class="fa fa-times"></i> Clear
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    @if($students->count() > 0)
                        <form method="POST" action="{{ route('exam-marks.store', [$examType->id, $module->id, $centre->id, $examPaper->id]) }}">
                            @csrf
                            
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <label for="total_marks" class="form-label"><strong>Exam Total Marks:</strong></label>
                                    <input type="number" name="total_marks" id="total_marks" class="form-control" 
                                           value="{{ old('total_marks', request('total_marks', 100)) }}" min="1" max="1000" required>
                                </div>
                                <div class="col-md-9 d-flex align-items-end">
                                    <button type="submit" class="btn btn-gradient-success">
                                        <i class="fa fa-save"></i> Save Marks
                                    </button>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Student Number</th>
                                            <th>Surname</th>
                                            <th>Student Name</th>
                                            <th>{{ $examPaper->paper_name }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($students as $student)
                                            @php
                                                $existingMark = $student->examMarks->first();
                                            @endphp
                                            <tr>
                                                <td>{{ $student->student_number2 }}</td>
                                                <td>{{ $student->surname }}</td>
                                                <td>{{ $student->student_names }}</td>
                                                <td>
                                                    <input type="number" 
                                                           name="marks[{{ $student->id }}]" 
                                                           class="form-control marks-input" 
                                                           value="{{ old('marks.'.$student->id, $existingMark ? $existingMark->marks_obtained : '') }}"
                                                           min="0" 
                                                           step="0.01"
                                                           placeholder="Enter marks">
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </form>
                    @else
                        <div class="alert alert-info text-center">
                            <i class="fa fa-info-circle"></i>
                            <strong>No Students Registered</strong>
                            <p class="mb-0">There are no students registered for <strong>{{ $module->subject_name }} ({{ $module->subject_code }})</strong> at <strong>{{ $centre->center_name }}</strong> for the {{ $currentAcademicYear->academic_year }} academic year.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.bg-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
}

.btn-gradient-info {
    background: linear-gradient(45deg, #17a2b8 0%, #138496 100%);
    border: none;
    color: white;
}

.btn-gradient-success {
    background: linear-gradient(45deg, #28a745 0%, #20c997 100%);
    border: none;
    color: white;
}

.btn-gradient-info:hover,
.btn-gradient-success:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const totalMarksInput = document.getElementById('total_marks');
    const marksInputs = document.querySelectorAll('.marks-input');
    
    function updateMaxValues() {
        const totalMarks = parseFloat(totalMarksInput.value) || 100;
        marksInputs.forEach(input => {
            input.setAttribute('max', totalMarks);
        });
    }
    
    // Update max values when total marks changes
    totalMarksInput.addEventListener('input', updateMaxValues);
    
    // Set initial max values
    updateMaxValues();
});
</script>
@endsection
