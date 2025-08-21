@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="card-title">Exam Marks - Module List</h4>
                        </div>
                        <div class="col-md-6 text-right">
                            <span class="badge badge-info">Academic Year: {{ $currentAcademicYear->academic_year }}</span>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Search Form -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <form method="GET" action="{{ route('exam-marks.index') }}">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control" placeholder="Search by module name or code..." value="{{ $search }}">
                                    <div class="input-group-append">
                                        <button class="btn btn-gradient-info" type="submit">
                                            <i class="fa fa-search"></i> Search
                                        </button>
                                        <a href="{{ route('exam-marks.index') }}" class="btn btn-secondary">
                                            <i class="fa fa-times"></i> Clear
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    @if($modulesWithCentres && count($modulesWithCentres) > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Academic Year</th>
                                        <th>Centre</th>
                                        <th>Module Name</th>
                                        <th>Module Code</th>
                                        <th>Reference Teacher</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($modulesWithCentres as $moduleData)
                                        <tr>
                                            <td>{{ $currentAcademicYear->academic_year }}</td>
                                            <td>{{ $moduleData['centre_name'] }}</td>
                                            <td>{{ $moduleData['module']->subject_name }}</td>
                                            <td><strong>{{ $moduleData['module']->subject_code }}</strong></td>
                                            <td>
                                                @if($moduleData['teacher_name'] !== 'Not Assigned')
                                                    <i class="fas fa-user-tie text-primary"></i>
                                                    {{ $moduleData['teacher_name'] }}
                                                @else
                                                    <span class="text-muted">
                                                        <i class="fas fa-user-slash"></i>
                                                        Not Assigned
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                @if(Auth::user()->hasPermission('capture-exam-marks'))
                                                    @php
                                                        $examTypeGroups = $moduleData['module']->examPaperWeights->groupBy('examination_id');
                                                        $hasExamPaperWeights = $examTypeGroups->isNotEmpty();
                                                    @endphp
                                                    
                                                    @if($hasExamPaperWeights)
                                                        <div class="dropdown">
                                                            <button class="btn btn-sm btn-gradient-primary dropdown-toggle" type="button" 
                                                                    id="dropdownMenuButton{{ $moduleData['module']->id }}_{{ $moduleData['centre_id'] }}" 
                                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <i class="fa fa-edit"></i> Capture Marks
                                                            </button>
                                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $moduleData['module']->id }}_{{ $moduleData['centre_id'] }}">
                                                                @foreach($examTypeGroups as $examTypeId => $examPapers)
                                                                    @php
                                                                        $examType = $examPapers->first()->examination ?? \App\AssessmentType::find($examTypeId);
                                                                    @endphp
                                                                    @if($examType)
                                                                        <h6 class="dropdown-header">{{ $examType->name ?? 'Exam Type ' . $examTypeId }}</h6>
                                                                        @foreach($examPapers as $paperWeight)
                                                                            @if($paperWeight->examPaper)
                                                                                <a class="dropdown-item" href="{{ route('exam-marks.capture', [$examTypeId, $moduleData['module']->id, $moduleData['centre_id'], $paperWeight->examPaper->id]) }}">
                                                                                    <i class="fa fa-pencil-alt"></i> 
                                                                                    {{ $paperWeight->examPaper->paper_name ?? $paperWeight->paper_name ?? 'Paper ' . $paperWeight->examPaper->id }} 
                                                                                    ({{ $paperWeight->weight }}%)
                                                                                </a>
                                                                            @endif
                                                                        @endforeach
                                                                        @if(Auth::user()->hasPermission('view-all-exam-marks'))
                                                                            <div class="dropdown-divider"></div>
                                                                            <a class="dropdown-item" href="{{ route('exam-marks.view-all', [$examTypeId, $moduleData['module']->id, $moduleData['centre_id']]) }}">
                                                                                <i class="fa fa-eye"></i> View All - {{ $examType->name ?? 'Exam Type ' . $examTypeId }}
                                                                            </a>
                                                                        @endif
                                                                        @if(!$loop->last)
                                                                            <div class="dropdown-divider"></div>
                                                                        @endif
                                                                    @endif
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    @else
                                                        <button class="btn btn-sm btn-warning" type="button" 
                                                                onclick="alert('No exam paper weights have been defined for {{ $moduleData['module']->subject_name }} ({{ $moduleData['module']->subject_code }}). Please set up exam paper weights first before capturing marks.')">
                                                            <i class="fa fa-exclamation-triangle"></i> No Weights Defined
                                                        </button>
                                                    @endif
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <p class="text-muted">No modules allocated to you for the current academic year.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.btn-gradient-primary {
    background: linear-gradient(45deg, #667eea 0%, #764ba2 100%);
    border: none;
    color: white;
}

.btn-gradient-info {
    background: linear-gradient(45deg, #17a2b8 0%, #138496 100%);
    border: none;
    color: white;
}

.btn-gradient-primary:hover,
.btn-gradient-info:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    transition: all 0.3s ease;
}

.badge-info {
    background: linear-gradient(45deg, #17a2b8 0%, #138496 100%);
}

.dropdown-header {
    font-weight: bold;
    color: #495057;
    font-size: 0.875rem;
}

.dropdown-menu {
    z-index: 1050 !important;
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    border: 1px solid rgba(0,0,0,0.1);
}

.dropdown {
    position: relative;
}

.table-responsive {
    overflow: visible !important;
}

.table td {
    position: relative;
}
</style>
@endsection
