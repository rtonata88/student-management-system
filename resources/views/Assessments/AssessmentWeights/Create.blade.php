@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Create CA Weight</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('assessment-weights.store') }}" id="assessmentWeightForm">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="module_id">Module <span class="text-danger">*</span></label>
                                    <select name="module_id" id="module_id" class="form-control @error('module_id') is-invalid @enderror" required>
                                        <option value="">Select module</option>
                                        @foreach($modules as $module)
                                            <option value="{{ $module->id }}" {{ old('module_id') == $module->id ? 'selected' : '' }}>
                                                {{ $module->subject_name }} ({{ $module->subject_code }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('module_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="academic_year_id">Academic Year <span class="text-danger">*</span></label>
                                    <select name="academic_year_id" id="academic_year_id" class="form-control @error('academic_year_id') is-invalid @enderror" required>
                                        <option value="">Select Academic Year</option>
                                        @foreach($academicYears as $year)
                                            <option value="{{ $year->id }}" {{ old('academic_year_id') == $year->id ? 'selected' : '' }}>
                                                {{ $year->academic_year }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('academic_year_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-warning">
                            <i class="fa fa-info-circle"></i> The weights should add up 100%.
                        </div>

                        @error('assessment_weights')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror

                        <div class="table-responsive">
                            <table class="table table-bordered" id="assessmentWeightsTable">
                                <thead>
                                    <tr>
                                        <th>MARK TYPE</th>
                                        <th>DESCRIPTION</th>
                                        <th>WEIGHT (%)</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="assessmentWeightsBody">
                                    <!-- Dynamic rows will be added here -->
                                </tbody>
                            </table>
                        </div>

                        <div class="mb-3">
                            <button type="button" class="btn btn-gradient-info" id="addAssessmentType">
                                <i class="fa fa-plus"></i> Add Assessment Type
                            </button>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-gradient-success">
                                <i class="fa fa-save"></i> Save
                            </button>
                            <a href="{{ route('assessment-weights.index') }}" class="btn btn-secondary">
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
    let rowIndex = 0;
    const assessmentTypes = @json($assessmentTypes);
    
    function addAssessmentRow() {
        const tbody = document.getElementById('assessmentWeightsBody');
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>
                <select name="assessment_weights[${rowIndex}][assessment_type_id]" class="form-control" required>
                    <option value="">Select Assessment Type</option>
                    ${assessmentTypes.map(type => `<option value="${type.id}">${type.name}</option>`).join('')}
                </select>
            </td>
            <td>
                <input type="text" name="assessment_weights[${rowIndex}][description]" class="form-control" placeholder="Enter description">
            </td>
            <td>
                <input type="number" name="assessment_weights[${rowIndex}][weight]" class="form-control weight-input" 
                       min="0" max="100" step="0.01" placeholder="0.00" required>
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
    
    // Add first row by default
    addAssessmentRow();
    
    // Add event listener to "Add Assessment Type" button
    document.getElementById('addAssessmentType').addEventListener('click', addAssessmentRow);
    
    // Form validation
    document.getElementById('assessmentWeightForm').addEventListener('submit', function(e) {
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
