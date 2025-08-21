@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h4 class="mb-0">{{ $examType->exam_type }} - Module List</h4>
                        </div>
                        <div class="col-md-4 text-right">
                            <a href="{{ route('exam-marks.index') }}" class="btn btn-outline-light btn-sm">
                                <i class="fa fa-arrow-left"></i> Back to Exam Types
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Search Form -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <form method="GET">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control" placeholder="Search by module name or code..." value="{{ $search }}">
                                    <div class="input-group-append">
                                        <button class="btn btn-gradient-info" type="submit">
                                            <i class="fa fa-search"></i> Search
                                        </button>
                                        <a href="{{ route('exam-marks.modules', $examType->id) }}" class="btn btn-secondary">
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
                                            <td><!-- Reference Teacher - to be populated later --></td>
                                            <td>
                                                @if(Auth::user()->hasPermission('capture-exam-marks'))
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-gradient-primary dropdown-toggle" type="button" 
                                                                id="dropdownMenuButton{{ $moduleData['module']->id }}_{{ $moduleData['centre_id'] }}" 
                                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="fa fa-edit"></i> Capture Marks
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $moduleData['module']->id }}_{{ $moduleData['centre_id'] }}">
                                                            @foreach($moduleData['module']->examPaperWeights as $weight)
                                                                <a class="dropdown-item" href="{{ route('exam-marks.capture', [$examType->id, $moduleData['module']->id, $moduleData['centre_id'], $weight->exam_paper_id]) }}">
                                                                    <i class="fa fa-pencil-alt"></i> {{ $weight->examPaper->paper_name }}
                                                                </a>
                                                            @endforeach
                                                            @if(Auth::user()->hasPermission('view-all-exam-marks'))
                                                                <div class="dropdown-divider"></div>
                                                                <a class="dropdown-item" href="{{ route('exam-marks.view-all', [$examType->id, $moduleData['module']->id, $moduleData['centre_id']]) }}">
                                                                    <i class="fa fa-eye"></i> View All
                                                                </a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <p class="text-muted">No modules with exam paper weights found for {{ $examType->exam_type }} in the current academic year.</p>
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

.btn-gradient-primary {
    background: linear-gradient(45deg, #007bff 0%, #0056b3 100%);
    border: none;
    color: white;
}

.btn-gradient-info:hover,
.btn-gradient-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}
</style>
@endsection
