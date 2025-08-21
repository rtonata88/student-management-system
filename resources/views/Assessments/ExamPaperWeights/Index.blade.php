@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="card-title">Exam Paper Weights</h4>
                        </div>
                        <div class="col-md-6 text-right">
                            @if(Auth::user()->hasPermission('add-exam-paper-weights'))
                                <a href="{{ route('exam-paper-weights.create') }}" class="btn btn-gradient-primary">
                                    <i class="fa fa-plus"></i> Add New
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Search Form -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <form method="GET" action="{{ route('exam-paper-weights.index') }}">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control" placeholder="Search by module, paper name or code..." value="{{ $search }}">
                                    <div class="input-group-append">
                                        <button class="btn btn-gradient-info" type="submit">
                                            <i class="fa fa-search"></i> Search
                                        </button>
                                        <a href="{{ route('exam-paper-weights.index') }}" class="btn btn-secondary">
                                            <i class="fa fa-times"></i> Clear
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-6 text-right">
                            <!-- Clear button moved to be next to search button -->
                        </div>
                    </div>

                    @if($examPaperWeights->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Module Name</th>
                                        <th>Module Code</th>
                                        <th>Academic Year</th>
                                        <th>Exam Type</th>
                                        <th>Exam Papers & Weights</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $groupedWeights = $examPaperWeights->groupBy(function($item) {
                                            return $item->module_id . '_' . $item->academic_year_id . '_' . $item->assessment_type_id;
                                        });
                                    @endphp
                                    
                                    @foreach($groupedWeights as $key => $weights)
                                        @php
                                            $firstWeight = $weights->first();
                                        @endphp
                                        <tr>
                                            <td>{{ $firstWeight->module->subject_name }}</td>
                                            <td>{{ $firstWeight->module->subject_code }}</td>
                                            <td>{{ $firstWeight->academicYear->academic_year }}</td>
                                            <td>{{ $firstWeight->examination->name }}</td>
                                            <td>
                                                @foreach($weights as $weight)
                                                    <span class="badge badge-success mr-1">
                                                        {{ $weight->paper_name }}
                                                        @if($weight->paper_code)
                                                            ({{ $weight->paper_code }})
                                                        @endif
                                                        <em>{{ $weight->weight }}%</em>
                                                    </span>
                                                    @if($weight->description)
                                                        <br><small class="text-muted">{{ $weight->description }}</small>
                                                    @endif
                                                    <br>
                                                @endforeach
                                            </td>
                                            <td>
                                                @if(Auth::user()->hasPermission('edit-exam-paper-weights'))
                                                    <a href="{{ route('exam-paper-weights.edit', [$firstWeight->module_id, $firstWeight->academic_year_id, $firstWeight->examination_id]) }}" 
                                                       class="btn btn-sm btn-gradient-warning">
                                                        <i class="fa fa-edit"></i> Edit
                                                    </a>
                                                @endif
                                                
                                                @if(Auth::user()->hasPermission('delete-exam-paper-weights'))
                                                    <form method="POST" action="{{ route('exam-paper-weights.destroy', [$firstWeight->module_id, $firstWeight->academic_year_id, $firstWeight->examination_id]) }}" 
                                                          style="display: inline-block;" 
                                                          onsubmit="return confirm('Are you sure you want to delete these exam paper weights?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-gradient-danger">
                                                            <i class="fa fa-trash"></i> Delete
                                                        </button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center">
                            {{ $examPaperWeights->appends(['search' => $search])->links() }}
                        </div>
                    @else
                        <div class="text-center py-4">
                            <p class="text-muted">No exam paper weights found.</p>
                            @if(Auth::user()->hasPermission('add-exam-paper-weights'))
                                <a href="{{ route('exam-paper-weights.create') }}" class="btn btn-gradient-primary">
                                    <i class="fa fa-plus"></i> Create First Exam Paper Weight
                                </a>
                            @endif
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

.btn-gradient-warning {
    background: linear-gradient(45deg, #ffc107 0%, #e0a800 100%);
    border: none;
    color: white;
}

.btn-gradient-danger {
    background: linear-gradient(45deg, #dc3545 0%, #c82333 100%);
    border: none;
    color: white;
}

.btn-gradient-primary:hover,
.btn-gradient-info:hover,
.btn-gradient-warning:hover,
.btn-gradient-danger:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    transition: all 0.3s ease;
}
</style>
@endsection
