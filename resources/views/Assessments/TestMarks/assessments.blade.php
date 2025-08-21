@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h4 class="mb-0">Assessment Marks</h4>
                        </div>
                        <div class="col-md-6 text-right">
                            <a href="{{ route('test-marks.index') }}" class="btn btn-outline-light btn-sm">
                                <i class="fa fa-arrow-left"></i> Modules
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
                                    <td>{{ $currentAcademicYear->center->center_name ?? 'N/A' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- Assessment List -->
                    <div class="assessment-container">
                        <div class="assessment-card">
                            <div class="assessment-header">
                                <h5 class="text-center mb-0">
                                    <i class="fa fa-clipboard-list"></i> Assessment Marks
                                </h5>
                            </div>
                            <div class="assessment-body">
                                @foreach($assessmentWeights as $weight)
                                    <div class="assessment-item">
                                        <a href="{{ route('test-marks.capture', [$module->id, $centre->id, $weight->assessment_type_id]) }}" 
                                           class="assessment-link">
                                            {{ $weight->assessmentType->name }}
                                        </a>
                                    </div>
                                @endforeach
                                
                                <div class="assessment-item view-all">
                                    <a href="{{ route('test-marks.view-all', [$module->id, $centre->id]) }}" 
                                       class="assessment-link view-all-link">
                                        View all
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.bg-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
}

.assessment-container {
    display: flex;
    justify-content: center;
    margin-top: 2rem;
}

.assessment-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    overflow: hidden;
    min-width: 300px;
    max-width: 400px;
}

.assessment-header {
    background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
    padding: 1.5rem;
    border-bottom: 1px solid #e0e0e0;
}

.assessment-body {
    padding: 1rem 0;
}

.assessment-item {
    padding: 0.75rem 1.5rem;
    border-bottom: 1px solid #f5f5f5;
    transition: all 0.3s ease;
}

.assessment-item:last-child {
    border-bottom: none;
}

.assessment-item:hover {
    background-color: #f8f9fa;
    transform: translateX(5px);
}

.assessment-link {
    display: block;
    color: #666;
    text-decoration: none;
    font-weight: 500;
    font-size: 1rem;
    transition: color 0.3s ease;
}

.assessment-link:hover {
    color: #667eea;
    text-decoration: none;
}

.view-all .assessment-link {
    color: #28a745;
    font-weight: 600;
}

.view-all .assessment-link:hover {
    color: #20c997;
}

.assessment-item.view-all {
    margin-top: 0.5rem;
    border-top: 2px solid #e0e0e0;
    background-color: #f8f9fa;
}
</style>
@endsection
