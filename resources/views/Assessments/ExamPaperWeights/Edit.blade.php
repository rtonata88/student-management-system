@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ $module->subject_name }} - {{ $examination->name }} Paper Weights</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('exam-paper-weights.update', [$module->id, $academicYear->id, $examination->id]) }}" id="examPaperWeightForm">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Module <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" value="{{ $module->subject_name }} ({{ $module->subject_code }})" readonly>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Academic Year <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" value="{{ $academicYear->academic_year }}" readonly>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Exam Type <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" value="{{ $examination->name }}" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-warning">
                            <i class="fa fa-info-circle"></i> The weights should add up 100%.
                        </div>

                        @error('exam_papers')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror

                        <div class="table-responsive">
                            <table class="table table-bordered" id="examPapersTable">
                                <thead>
                                    <tr>
                                        <th>PAPER NAME</th>
                                        <th>PAPER CODE</th>
                                        <th>WEIGHT (%)</th>
                                        <th>DESCRIPTION</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="examPapersBody">
                                    @foreach($examPaperWeights as $index => $paper)
                                        <tr>
                                            <td>
                                                <input type="text" name="exam_papers[{{ $index }}][paper_name]" 
                                                       class="form-control" placeholder="Enter paper name" 
                                                       value="{{ $paper->paper_name }}" required>
                                            </td>
                                            <td>
                                                <input type="text" name="exam_papers[{{ $index }}][paper_code]" 
                                                       class="form-control" placeholder="Enter paper code" 
                                                       value="{{ $paper->paper_code }}">
                                            </td>
                                            <td>
                                                <input type="number" name="exam_papers[{{ $index }}][weight]" 
                                                       class="form-control weight-input" min="0" max="100" step="0.01" 
                                                       placeholder="0.00" value="{{ $paper->weight }}" required>
                                            </td>
                                            <td>
                                                <input type="text" name="exam_papers[{{ $index }}][description]" 
                                                       class="form-control" placeholder="Enter description" 
                                                       value="{{ $paper->description }}">
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-gradient-danger btn-sm remove-row">
                                                    <i class="fa fa-trash"></i> Remove
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mb-3">
                            <button type="button" class="btn btn-gradient-info" id="addExamPaper">
                                <i class="fa fa-plus"></i> Add Exam Paper
                            </button>
                        </div>


                        <div class="form-group">
                            <button type="submit" class="btn btn-gradient-success">
                                <i class="fa fa-save"></i> Save
                            </button>
                            <a href="{{ route('exam-paper-weights.index') }}" class="btn btn-secondary">
                                <i class="fa fa-times"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.btn-gradient-success {
    background: linear-gradient(45deg, #28a745 0%, #20c997 100%);
    border: none;
    color: white;
}

.btn-gradient-info {
    background: linear-gradient(45deg, #17a2b8 0%, #138496 100%);
    border: none;
    color: white;
}

.btn-gradient-danger {
    background: linear-gradient(45deg, #dc3545 0%, #c82333 100%);
    border: none;
    color: white;
}

.btn-gradient-success:hover,
.btn-gradient-info:hover,
.btn-gradient-danger:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    transition: all 0.3s ease;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let rowIndex = {{ $examPaperWeights->count() }};
    
    function addExamPaperRow() {
        const tbody = document.getElementById('examPapersBody');
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>
                <input type="text" name="exam_papers[${rowIndex}][paper_name]" class="form-control" placeholder="Enter paper name" required>
            </td>
            <td>
                <input type="text" name="exam_papers[${rowIndex}][paper_code]" class="form-control" placeholder="Enter paper code">
            </td>
            <td>
                <input type="number" name="exam_papers[${rowIndex}][weight]" class="form-control weight-input" 
                       min="0" max="100" step="0.01" placeholder="0.00" required>
            </td>
            <td>
                <input type="text" name="exam_papers[${rowIndex}][description]" class="form-control" placeholder="Enter description">
            </td>
            <td>
                <button type="button" class="btn btn-gradient-danger btn-sm remove-row">
                    <i class="fa fa-trash"></i> Remove
                </button>
            </td>
        `;
        tbody.appendChild(row);
        rowIndex++;
        
        // Add event listener to remove button
        row.querySelector('.remove-row').addEventListener('click', function() {
            row.remove();
            updateTotalWeight();
        });
        
        // Add event listener to weight input
        row.querySelector('.weight-input').addEventListener('input', updateTotalWeight);
    }
    
    function updateTotalWeight() {
        const weightInputs = document.querySelectorAll('.weight-input');
        let total = 0;
        weightInputs.forEach(input => {
            const value = parseFloat(input.value) || 0;
            total += value;
        });
        
        // Update alert message
        const alert = document.querySelector('.alert-warning');
        if (total === 100) {
            alert.className = 'alert alert-success';
            alert.innerHTML = '<i class="fa fa-check-circle"></i> The weights add up to 100%. Perfect!';
        } else {
            alert.className = 'alert alert-warning';
            alert.innerHTML = `<i class="fa fa-info-circle"></i> The weights should add up 100%. Current total: ${total.toFixed(2)}%`;
        }
    }
    
    // Add event listeners to existing remove buttons
    document.querySelectorAll('.remove-row').forEach(button => {
        button.addEventListener('click', function() {
            button.closest('tr').remove();
            updateTotalWeight();
        });
    });
    
    // Add event listeners to existing weight inputs
    document.querySelectorAll('.weight-input').forEach(input => {
        input.addEventListener('input', updateTotalWeight);
    });
    
    // Initial weight calculation
    updateTotalWeight();
    
    // Add event listener to "Add Exam Paper" button
    document.getElementById('addExamPaper').addEventListener('click', addExamPaperRow);
    
    // Form validation
    document.getElementById('examPaperWeightForm').addEventListener('submit', function(e) {
        const weightInputs = document.querySelectorAll('.weight-input');
        let total = 0;
        weightInputs.forEach(input => {
            const value = parseFloat(input.value) || 0;
            total += value;
        });
        
        if (Math.abs(total - 100) > 0.01) {
            e.preventDefault();
            alert('The total weight must equal 100%. Current total: ' + total.toFixed(2) + '%');
            return false;
        }
    });
});
</script>
@endsection
