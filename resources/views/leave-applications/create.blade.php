@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-plus"></i>
                        <strong>Apply for Leave</strong>
                        <small>Submit a new leave application</small>
                    </div>
                    
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        <form method="POST" action="{{ route('leave-applications.store') }}" enctype="multipart/form-data">
                            @csrf
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="leave_type_id">Leave Type <span class="text-danger">*</span></label>
                                        <select name="leave_type_id" id="leave_type_id" class="form-control @error('leave_type_id') is-invalid @enderror" required>
                                            <option value="">Select Leave Type</option>
                                            @foreach($leaveTypes as $type)
                                                <option value="{{ $type->id }}" {{ old('leave_type_id') == $type->id ? 'selected' : '' }}>
                                                    {{ $type->name }}
                                                    @if($type->max_days_per_year)
                                                        (Max: {{ $type->max_days_per_year }} days/year)
                                                    @endif
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('leave_type_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>
                                            <input type="checkbox" name="is_half_day" id="is_half_day" value="1" {{ old('is_half_day') ? 'checked' : '' }}>
                                            Half Day Leave
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="start_date">Start Date <span class="text-danger">*</span></label>
                                        <input type="date" name="start_date" id="start_date" 
                                               class="form-control @error('start_date') is-invalid @enderror" 
                                               value="{{ old('start_date') }}" required>
                                        @error('start_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-6" id="end_date_container">
                                    <div class="form-group">
                                        <label for="end_date">End Date <span class="text-danger">*</span></label>
                                        <input type="date" name="end_date" id="end_date" 
                                               class="form-control @error('end_date') is-invalid @enderror" 
                                               value="{{ old('end_date') }}" required>
                                        @error('end_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row" id="half_day_period_container" style="display: none;">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="half_day_period">Half Day Period</label>
                                        <select name="half_day_period" id="half_day_period" class="form-control @error('half_day_period') is-invalid @enderror">
                                            <option value="">Select Period</option>
                                            <option value="morning" {{ old('half_day_period') == 'morning' ? 'selected' : '' }}>Morning</option>
                                            <option value="afternoon" {{ old('half_day_period') == 'afternoon' ? 'selected' : '' }}>Afternoon</option>
                                        </select>
                                        @error('half_day_period')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="reason">Reason for Leave <span class="text-danger">*</span></label>
                                <textarea name="reason" id="reason" rows="4" 
                                          class="form-control @error('reason') is-invalid @enderror" 
                                          placeholder="Please provide the reason for your leave request..." required>{{ old('reason') }}</textarea>
                                @error('reason')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label for="attachment">Supporting Document (Optional)</label>
                                <input type="file" name="attachment" id="attachment" 
                                       class="form-control-file @error('attachment') is-invalid @enderror"
                                       accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                                <small class="form-text text-muted">
                                    Accepted formats: PDF, DOC, DOCX, JPG, JPEG, PNG (Max: 2MB)
                                </small>
                                @error('attachment')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary gradient-btn" id="submitBtn">
                                    <i class="cil-check"></i> Submit Application
                                </button>
                                <a href="{{ route('leave-applications.index') }}" class="btn btn-secondary">
                                    <i class="cil-arrow-left"></i> Back to Applications
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const halfDayCheckbox = document.getElementById('is_half_day');
    const endDateContainer = document.getElementById('end_date_container');
    const halfDayPeriodContainer = document.getElementById('half_day_period_container');
    const halfDayPeriodSelect = document.getElementById('half_day_period');
    const endDateInput = document.getElementById('end_date');
    const startDateInput = document.getElementById('start_date');
    const submitBtn = document.getElementById('submitBtn');
    const form = document.querySelector('form');
    
    function toggleHalfDay() {
        if (halfDayCheckbox.checked) {
            endDateContainer.style.display = 'none';
            halfDayPeriodContainer.style.display = 'block';
            endDateInput.value = startDateInput.value;
            endDateInput.required = false;
        } else {
            endDateContainer.style.display = 'block';
            halfDayPeriodContainer.style.display = 'none';
            endDateInput.required = true;
            // Clear half day period when unchecked
            halfDayPeriodSelect.value = '';
        }
    }
    
    halfDayCheckbox.addEventListener('change', toggleHalfDay);
    startDateInput.addEventListener('change', function() {
        if (halfDayCheckbox.checked) {
            endDateInput.value = startDateInput.value;
        }
    });
    
    // Debug form submission
    form.addEventListener('submit', function(e) {
        console.log('Form submitting...');
        console.log('Form data:', new FormData(form));
        
        // Log all form values for debugging
        const formData = new FormData(form);
        for (let [key, value] of formData.entries()) {
            console.log(key + ': ' + value);
        }
    });
    
    submitBtn.addEventListener('click', function(e) {
        console.log('Submit button clicked');
        console.log('Half day checked:', halfDayCheckbox.checked);
        console.log('Half day period:', halfDayPeriodSelect.value);
    });
    
    // Initialize on page load
    toggleHalfDay();
});
</script>
@endsection

<style>
:root {
    --primary-color: #667eea;
    --secondary-color: #764ba2;
    --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --hover-gradient: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
    --success-gradient: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
    --danger-gradient: linear-gradient(135deg, #fc466b 0%, #3f5efb 100%);
    --warning-gradient: linear-gradient(135deg, #fdbb2d 0%, #22c1c3 100%);
}

/* Primary button with gradient */
.btn-primary, .gradient-btn {
    background: var(--primary-gradient) !important;
    border: none !important;
    color: white !important;
    transition: all 0.3s ease;
}

.btn-primary:hover, .gradient-btn:hover {
    background: var(--hover-gradient) !important;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
    color: white !important;
}

/* Secondary button styling */
.btn-secondary {
    background: linear-gradient(135deg, #6c757d 0%, #495057 100%) !important;
    border: none !important;
    color: white !important;
    transition: all 0.3s ease;
}

.btn-secondary:hover {
    background: linear-gradient(135deg, #5a6268 0%, #3d424a 100%) !important;
    transform: translateY(-1px);
    color: white !important;
}
</style>
