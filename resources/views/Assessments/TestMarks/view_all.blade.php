@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h4 class="mb-0">Assessment Marks Overview</h4>
                        </div>
                        <div class="col-md-4 text-right">
                            <a href="{{ route('test-marks.index') }}" class="btn btn-outline-light btn-sm">
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
                            </table>
                        </div>
                    </div>

                    @if($studentsWithCA->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead class="table-dark">
                                    <tr>
                                        <th rowspan="2">Student Number</th>
                                        <th rowspan="2">Student Name</th>
                                        @foreach($assessmentWeights as $weight)
                                            <th colspan="3" class="text-center">
                                                {{ $weight->assessmentType->name }}
                                                <small class="d-block">(Weight: {{ $weight->weight }}%)</small>
                                            </th>
                                        @endforeach
                                        <th rowspan="2" class="bg-success text-white">CA Total</th>
                                    </tr>
                                    <tr>
                                        @foreach($assessmentWeights as $weight)
                                            <th class="text-center small">Marks</th>
                                            <th class="text-center small">%</th>
                                            <th class="text-center small">Weighted</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($studentsWithCA as $student)
                                        <tr>
                                            <td><strong>{{ $student->student_number }}</strong></td>
                                            <td>{{ $student->surname }}, {{ $student->student_names }}</td>
                                            
                                            @foreach($student->assessment_data as $assessment)
                                                <td class="text-center">
                                                    @if($assessment['marks_obtained'] !== null)
                                                        {{ $assessment['marks_obtained'] }}/{{ $assessment['total_marks'] }}
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @if($assessment['percentage'] > 0)
                                                        {{ $assessment['percentage'] }}%
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @if($assessment['weighted_mark'] > 0)
                                                        {{ $assessment['weighted_mark'] }}
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                            @endforeach
                                            
                                            <td class="text-center bg-success text-white">
                                                <strong>{{ $student->ca_total }}%</strong>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Summary Statistics -->
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6 class="card-title">Assessment Summary</h6>
                                        <div class="row">
                                            @foreach($assessmentWeights as $weight)
                                                <div class="col-md-3">
                                                    <div class="text-center">
                                                        <h5 class="text-primary">{{ $weight->assessmentType->name }}</h5>
                                                        <p class="mb-0">Weight: <strong>{{ $weight->weight }}%</strong></p>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <p class="text-muted">No students registered for this module.</p>
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

.table-dark {
    background: linear-gradient(135deg, #343a40 0%, #495057 100%);
}

.table th {
    border-top: 1px solid #dee2e6;
    font-size: 0.875rem;
}

.table td {
    font-size: 0.875rem;
}

.bg-success {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%) !important;
}

.text-primary {
    color: #667eea !important;
}

.card.bg-light {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%) !important;
}

@media (max-width: 768px) {
    .table-responsive {
        font-size: 0.75rem;
    }
    
    .table th,
    .table td {
        padding: 0.5rem 0.25rem;
    }
}
</style>
@endsection
