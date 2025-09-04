@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-edit"></i>
                        <strong>Edit Leave Request</strong>
                        <small>Modify leave request details</small>
                    </div>
                    
                    <div class="card-body">
                        <form method="POST" action="{{ route('leave-management.update', $leaveRequest) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
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
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="user_id">Employee <span class="text-danger">*</span></label>
                                        <select name="user_id" id="user_id" class="form-control @error('user_id') is-invalid @enderror" required>
                                            <option value="">Select Employee</option>
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}" {{ (old('user_id', $leaveRequest->user_id) == $user->id) ? 'selected' : '' }}>
                                                    {{ $user->name }} ({{ $user->email }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('user_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="leave_type_id">Leave Type <span class="text-danger">*</span></label>
                                        <select name="leave_type_id" id="leave_type_id" class="form-control @error('leave_type_id') is-invalid @enderror" required>
                                            <option value="">Select Leave Type</option>
                                            @foreach($leaveTypes as $type)
                                                <option value="{{ $type->id }}" {{ (old('leave_type_id', $leaveRequest->leave_type_id) == $type->id) ? 'selected' : '' }}>
                                                    {{ $type->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('leave_type_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>
                                            <input type="checkbox" name="is_half_day" id="is_half_day" value="1" {{ old('is_half_day', $leaveRequest->is_half_day) ? 'checked' : '' }}>
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
                                               value="{{ old('start_date', $leaveRequest->start_date->format('Y-m-d')) }}" required>
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
                                               value="{{ old('end_date', $leaveRequest->end_date->format('Y-m-d')) }}" required>
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
                                            <option value="morning" {{ old('half_day_period', $leaveRequest->half_day_period) == 'morning' ? 'selected' : '' }}>Morning</option>
                                            <option value="afternoon" {{ old('half_day_period', $leaveRequest->half_day_period) == 'afternoon' ? 'selected' : '' }}>Afternoon</option>
                                        </select>
                                        @error('half_day_period')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="status">Status <span class="text-danger">*</span></label>
                                        <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                                            <option value="pending" {{ old('status', $leaveRequest->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="approved" {{ old('status', $leaveRequest->status) == 'approved' ? 'selected' : '' }}>Approved</option>
                                            <option value="rejected" {{ old('status', $leaveRequest->status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                            <option value="cancelled" {{ old('status', $leaveRequest->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="reason">Reason for Leave <span class="text-danger">*</span></label>
                                <textarea name="reason" id="reason" rows="4" 
                                          class="form-control @error('reason') is-invalid @enderror" 
                                          placeholder="Please provide the reason for this leave..." required>{{ old('reason', $leaveRequest->reason) }}</textarea>
                                @error('reason')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label for="admin_comments">Admin Comments</label>
                                <textarea name="admin_comments" id="admin_comments" rows="3" 
                                          class="form-control @error('admin_comments') is-invalid @enderror" 
                                          placeholder="Optional admin comments...">{{ old('admin_comments', $leaveRequest->admin_comments) }}</textarea>
                                @error('admin_comments')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label for="attachment">Supporting Document (Optional)</label>
                                @if($leaveRequest->attachment)
                                    <div class="mb-2">
                                        <small class="text-muted">Current file: </small>
                                        <a href="{{ asset('storage/' . $leaveRequest->attachment) }}" target="_blank">
                                            {{ basename($leaveRequest->attachment) }}
                                        </a>
                                    </div>
                                @endif
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
                                <button type="submit" class="btn btn-primary gradient-btn">
                                    <i class="cil-check"></i> Update Leave Request
                                </button>
                                <a href="{{ route('leave-management.index') }}" class="btn btn-secondary">
                                    <i class="cil-arrow-left"></i> Back to Leave Management
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
    const endDateInput = document.getElementById('end_date');
    const startDateInput = document.getElementById('start_date');
    
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
            // Clear half day period when not half day
            document.getElementById('half_day_period').value = '';
        }
    }
    
    halfDayCheckbox.addEventListener('change', toggleHalfDay);
    startDateInput.addEventListener('change', function() {
        if (halfDayCheckbox.checked) {
            endDateInput.value = startDateInput.value;
        }
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
