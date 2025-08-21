@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h4 class="mb-0">Exam Marks Overview</h4>
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
                                    <td>{{ $examType->exam_type }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    @if($studentsWithExamTotals->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead class="table-dark">
                                    <tr>
                                        <th rowspan="2">Student Number</th>
                                        <th rowspan="2">Student Name</th>
                                        @foreach($examPaperWeights as $weight)
                                            <th colspan="3" class="text-center">{{ $weight->examPaper->paper_name }} ({{ $weight->weight }}%)</th>
                                        @endforeach
                                        <th rowspan="2" class="text-center bg-success text-white">Exam Total</th>
                                    </tr>
                                    <tr>
                                        @foreach($examPaperWeights as $weight)
                                            <th class="text-center small">Marks</th>
                                            <th class="text-center small">%</th>
                                            <th class="text-center small">Weighted</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($studentsWithExamTotals as $student)
                                        <tr>
                                            <td><strong>{{ $student->student_number }}</strong></td>
                                            <td>{{ $student->surname }}, {{ $student->student_names }}</td>
                                            
                                            @foreach($student->exam_data as $examData)
                                                <td class="text-center">
                                                    @if($examData['marks_obtained'] !== null)
                                                        {{ $examData['marks_obtained'] }}/{{ $examData['total_marks'] }}
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @if($examData['percentage'] > 0)
                                                        {{ $examData['percentage'] }}%
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @if($examData['weighted_mark'] > 0)
                                                        {{ $examData['weighted_mark'] }}
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                            @endforeach
                                            
                                            <td class="text-center bg-light">
                                                <strong>{{ $student->exam_total }}%</strong>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            <div class="alert alert-info">
                                <h6><i class="fa fa-info-circle"></i> Calculation Information:</h6>
                                <ul class="mb-0">
                                    <li><strong>Marks:</strong> Shows marks obtained out of total marks for each exam paper</li>
                                    <li><strong>%:</strong> Percentage score for each exam paper</li>
                                    <li><strong>Weighted:</strong> Percentage multiplied by paper weight</li>
                                    <li><strong>Exam Total:</strong> Sum of all weighted marks for the exam type</li>
                                </ul>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-info text-center">
                            <i class="fa fa-info-circle"></i>
                            <strong>No Students Found</strong>
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

.table-dark th {
    background-color: #343a40;
    border-color: #454d55;
}

.table-bordered {
    border: 1px solid #dee2e6;
}

.table-bordered th,
.table-bordered td {
    border: 1px solid #dee2e6;
}

.small {
    font-size: 0.875rem;
}

.bg-success {
    background-color: #28a745 !important;
}

.bg-light {
    background-color: #f8f9fa !important;
}

.alert-info {
    background-color: #d1ecf1;
    border-color: #bee5eb;
    color: #0c5460;
}
</style>
@endsection
