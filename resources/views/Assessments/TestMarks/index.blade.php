@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="card-title">Test Marks - Module List</h4>
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
                            <form method="GET" action="{{ route('test-marks.index') }}">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control" placeholder="Search by module name or code..." value="{{ $search }}">
                                    <div class="input-group-append">
                                        <button class="btn btn-gradient-info" type="submit">
                                            <i class="fa fa-search"></i> Search
                                        </button>
                                        <a href="{{ route('test-marks.index') }}" class="btn btn-secondary">
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
                                            <td>{{ $moduleData['module']->subject_code }}</td>
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
                                                @if(Auth::user()->hasPermission('capture-test-marks'))
                                                    @php
                                                        $hasAssessmentWeights = $moduleData['module']->assessmentWeights->isNotEmpty();
                                                    @endphp
                                                    
                                                    @if($hasAssessmentWeights)
                                                        <div class="dropdown">
                                                            <button class="btn btn-sm btn-gradient-primary dropdown-toggle" type="button" 
                                                                    id="dropdownMenuButton{{ $moduleData['module']->id }}_{{ $moduleData['centre_id'] }}" 
                                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <i class="fa fa-edit"></i> Capture Marks
                                                            </button>
                                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $moduleData['module']->id }}_{{ $moduleData['centre_id'] }}">
                                                                @foreach($moduleData['module']->assessmentWeights as $weight)
                                                                    <a class="dropdown-item" href="{{ route('test-marks.capture', [$moduleData['module']->id, $moduleData['centre_id'], $weight->assessment_type_id]) }}">
                                                                        <i class="fa fa-pencil-alt"></i> {{ $weight->assessmentType->name }}
                                                                    </a>
                                                                @endforeach
                                                                @if(Auth::user()->hasPermission('view-all-test-marks'))
                                                                    <div class="dropdown-divider"></div>
                                                                    <a class="dropdown-item" href="{{ route('test-marks.view-all', [$moduleData['module']->id, $moduleData['centre_id']]) }}">
                                                                        <i class="fa fa-eye"></i> View All
                                                                    </a>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @else
                                                        <button class="btn btn-sm btn-warning" type="button" 
                                                                onclick="alert('No assessment weights have been defined for {{ $moduleData['module']->subject_name }} ({{ $moduleData['module']->subject_code }}). Please set up assessment weights first before capturing marks.')">
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

                        <!-- Pagination -->
                        @if(isset($modules))
                        <div class="d-flex justify-content-center">
                            {{ $modules->appends(['search' => $search])->links() }}
                        </div>
                        @endif
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
