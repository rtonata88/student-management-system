@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                        <h4 class="card-title mb-0">
                            <i class="fa fa-plus"></i> Add New Grading Scale
                        </h4>
                        <div class="card-header-actions">
                            <a href="{{ route('grading-scales.index') }}" class="btn btn-sm btn-outline-light">
                                <i class="fa fa-arrow-left"></i> Back to List
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('grading-scales.store') }}" method="POST" onsubmit="return validateFormBeforeSubmit()">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="module_id" class="form-control-label">Module <span class="text-danger">*</span></label>
                                        <select name="module_id" id="module_id" class="form-control @error('module_id') is-invalid @enderror" required>
                                            <option value="">Select Module</option>
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
                                        <label for="academic_year_id" class="form-control-label">Academic Year <span class="text-danger">*</span></label>
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

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="examination_id" class="form-control-label">Examination Type <span class="text-danger">*</span></label>
                                        <select name="examination_id" id="examination_id" class="form-control @error('examination_id') is-invalid @enderror" required>
                                            <option value="">Select Examination Type</option>
                                            @foreach($examinations as $exam)
                                                <option value="{{ $exam->id }}" {{ old('examination_id') == $exam->id ? 'selected' : '' }}>
                                                    {{ $exam->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('examination_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="result_code_id" class="form-control-label">Result Code <span class="text-danger">*</span></label>
                                        <select name="result_code_id" id="result_code_id" class="form-control @error('result_code_id') is-invalid @enderror" required onchange="updateGradeFromResultCode()">
                                            <option value="">Select Result Code</option>
                                            @foreach($resultCodes as $resultCode)
                                                <option value="{{ $resultCode->id }}" 
                                                        data-name="{{ $resultCode->name }}" 
                                                        data-description="{{ $resultCode->description }}"
                                                        data-pass-fail="{{ $resultCode->pass_fail }}"
                                                        {{ old('result_code_id') == $resultCode->id ? 'selected' : '' }}>
                                                    {{ $resultCode->name }} ({{ $resultCode->code }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('result_code_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Grading Scales Table -->
                            <div class="row">
                                <div class="col-md-12">
                                    <h5 class="mb-3">Grading Scale Ranges</h5>
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="grading-scales-table">
                                            <thead style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                                                <tr>
                                                    <th>Min Mark</th>
                                                    <th>Max Mark</th>
                                                    <th>Result Code</th>
                                                    <th>Description</th>
                                                    <th>Pass/Fail</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody id="grading-scales-tbody">
                                                <tr class="grading-scale-row">
                                                    <td>
                                                        <input type="number" name="grading_scales[0][min_mark]" class="form-control min-mark" 
                                                               step="0.01" min="0" max="100" required onchange="validateRanges()" onblur="validateRanges()">
                                                    </td>
                                                    <td>
                                                        <input type="number" name="grading_scales[0][max_mark]" class="form-control max-mark" 
                                                               step="0.01" min="0" max="100" required onchange="validateRanges()" onblur="validateRanges()">
                                                    </td>
                                                    <td>
                                                        <select name="grading_scales[0][result_code_id]" class="form-control result-code-select" required onchange="updateRowFromResultCode(this)">
                                                            <option value="">Select Result Code</option>
                                                            @foreach($resultCodes as $resultCode)
                                                                <option value="{{ $resultCode->id }}" 
                                                                        data-name="{{ $resultCode->name }}" 
                                                                        data-description="{{ $resultCode->description }}"
                                                                        data-pass-fail="{{ $resultCode->pass_fail }}">
                                                                    {{ $resultCode->name }} ({{ $resultCode->code }})
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="grading_scales[0][grade]" class="form-control grade-input" 
                                                               maxlength="255" required placeholder="Auto-populated">
                                                    </td>
                                                    <td>
                                                        <select name="grading_scales[0][pass_fail]" class="form-control pass-fail-select" required>
                                                            <option value="">Auto-populated</option>
                                                            <option value="Pass">Pass</option>
                                                            <option value="Fail">Fail</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-sm btn-danger remove-row" onclick="removeGradingScaleRow(this)">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <button type="button" class="btn btn-sm" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none;" onclick="addGradingScaleRow()">
                                        <i class="fas fa-plus"></i> Add Another Range
                                    </button>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="active" class="form-control-label">Active</label>
                                        <div class="form-check">
                                            <input type="checkbox" name="active" id="active" class="form-check-input" value="1" {{ old('active', true) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="active">
                                                Active
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mt-4">
                                <button type="submit" class="btn" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none;">
                                    <i class="fa fa-save"></i> Save Grading Scale
                                </button>
                                <a href="{{ route('grading-scales.index') }}" class="btn btn-secondary ml-2">
                                    <i class="fa fa-times"></i> Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
let rowIndex = 1;

function updateRowFromResultCode(selectElement) {
    const row = selectElement.closest('tr');
    const gradeInput = row.querySelector('.grade-input');
    const passFailSelect = row.querySelector('.pass-fail-select');
    
    const selectedOption = selectElement.options[selectElement.selectedIndex];
    
    if (selectedOption && selectedOption.value && selectedOption.value !== '') {
        const name = selectedOption.getAttribute('data-name');
        const description = selectedOption.getAttribute('data-description');
        const passFailValue = selectedOption.getAttribute('data-pass-fail');
        
        // Use description if available and not empty, otherwise use name
        let gradeValue = '';
        if (description && description.trim() !== '' && description !== 'null') {
            gradeValue = description;
        } else if (name && name.trim() !== '' && name !== 'null') {
            gradeValue = name;
        }
        
        gradeInput.value = gradeValue;
        
        // Set pass/fail value
        if (passFailValue && passFailValue !== 'null') {
            passFailSelect.value = passFailValue;
        }
    } else {
        gradeInput.value = '';
        passFailSelect.value = '';
    }
}

function addGradingScaleRow() {
    const tbody = document.getElementById('grading-scales-tbody');
    const newRow = document.createElement('tr');
    newRow.className = 'grading-scale-row';
    
    newRow.innerHTML = `
        <td>
            <input type="number" name="grading_scales[${rowIndex}][min_mark]" class="form-control min-mark" 
                   step="0.01" min="0" max="100" required onchange="validateRanges()" onblur="validateRanges()">
        </td>
        <td>
            <input type="number" name="grading_scales[${rowIndex}][max_mark]" class="form-control max-mark" 
                   step="0.01" min="0" max="100" required onchange="validateRanges()" onblur="validateRanges()">
        </td>
        <td>
            <select name="grading_scales[${rowIndex}][result_code_id]" class="form-control result-code-select" required onchange="updateRowFromResultCode(this)">
                <option value="">Select Result Code</option>
                @foreach($resultCodes as $resultCode)
                    <option value="{{ $resultCode->id }}" 
                            data-name="{{ $resultCode->name }}" 
                            data-description="{{ $resultCode->description }}"
                            data-pass-fail="{{ $resultCode->pass_fail }}">
                        {{ $resultCode->name }} ({{ $resultCode->code }})
                    </option>
                @endforeach
            </select>
        </td>
        <td>
            <input type="text" name="grading_scales[${rowIndex}][grade]" class="form-control grade-input" 
                   maxlength="255" required placeholder="Auto-populated">
        </td>
        <td>
            <select name="grading_scales[${rowIndex}][pass_fail]" class="form-control pass-fail-select" required>
                <option value="">Auto-populated</option>
                <option value="Pass">Pass</option>
                <option value="Fail">Fail</option>
            </select>
        </td>
        <td>
            <button type="button" class="btn btn-sm btn-danger remove-row" onclick="removeGradingScaleRow(this)">
                <i class="fa fa-trash"></i>
            </button>
        </td>
    `;
    
    tbody.appendChild(newRow);
    rowIndex++;
}

function removeGradingScaleRow(button) {
    const row = button.closest('tr');
    const tbody = document.getElementById('grading-scales-tbody');
    
    // Don't allow removing the last row
    if (tbody.children.length > 1) {
        row.remove();
        validateRanges(); // Revalidate after removing a row
    } else {
        alert('At least one grading scale range is required.');
    }
}

function validateRanges() {
    const rows = document.querySelectorAll('.grading-scale-row');
    let ranges = [];
    let hasErrors = false;
    
    // Clear previous error styling
    document.querySelectorAll('.min-mark, .max-mark').forEach(input => {
        input.classList.remove('is-invalid');
        input.style.borderColor = '';
    });
    
    // Remove existing error messages
    document.querySelectorAll('.range-error').forEach(error => error.remove());
    
    // Collect all ranges
    rows.forEach((row, index) => {
        const minInput = row.querySelector('.min-mark');
        const maxInput = row.querySelector('.max-mark');
        
        if (minInput && maxInput && minInput.value && maxInput.value) {
            const minMark = parseFloat(minInput.value);
            const maxMark = parseFloat(maxInput.value);
            
            // Check if min > max within same row
            if (minMark > maxMark) {
                showRangeError(maxInput, 'Maximum mark must be greater than or equal to minimum mark');
                hasErrors = true;
            }
            
            ranges.push({
                min: minMark,
                max: maxMark,
                minInput: minInput,
                maxInput: maxInput,
                index: index
            });
        }
    });
    
    // Check for overlaps between different ranges
    for (let i = 0; i < ranges.length; i++) {
        for (let j = i + 1; j < ranges.length; j++) {
            const range1 = ranges[i];
            const range2 = ranges[j];
            
            // Check if ranges overlap
            if (!(range1.max < range2.min || range2.max < range1.min)) {
                showRangeError(range1.maxInput, `Range overlaps with row ${range2.index + 1}`);
                showRangeError(range2.maxInput, `Range overlaps with row ${range1.index + 1}`);
                hasErrors = true;
            }
        }
    }
    
    return !hasErrors;
}

function showRangeError(input, message) {
    input.classList.add('is-invalid');
    input.style.borderColor = '#dc3545';
    
    // Add error message if it doesn't exist
    if (!input.parentNode.querySelector('.range-error')) {
        const errorDiv = document.createElement('div');
        errorDiv.className = 'range-error text-danger small mt-1';
        errorDiv.textContent = message;
        input.parentNode.appendChild(errorDiv);
    }
}

function validateFormBeforeSubmit() {
    const isValid = validateRanges();
    if (!isValid) {
        alert('Please fix the overlapping or invalid mark ranges before submitting.');
        return false;
    }
    return true;
}

document.addEventListener('DOMContentLoaded', function() {
    // Initialize any existing rows
    const resultCodeSelects = document.querySelectorAll('.result-code-select');
    resultCodeSelects.forEach(function(select) {
        if (select.value) {
            updateRowFromResultCode(select);
        }
    });
});
</script>
@endsection
