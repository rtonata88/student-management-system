@extends('layouts.app')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{route('employees.index')}}">Human Resources</a></li>
        <li class="breadcrumb-item"><a href="{{route('employees.index')}}">Employee Bio</a></li>
        <li class="breadcrumb-item">Create Profile</li>
        <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Create New Employee Profile</h5>
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

                @if($users->isEmpty())
                <div class="alert alert-info">
                    <strong>No users available!</strong> All users already have employee profiles or no users exist in the system.
                    <a href="{{route('employees.index')}}" class="btn btn-secondary btn-sm ml-2">Back to List</a>
                </div>
                @else
                <form method="POST" action="{{route('employees.store')}}" enctype="multipart/form-data">
                    @csrf
                    
                    <!-- User Selection -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h6 class="border-bottom pb-2 mb-3">Select User</h6>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="user_id">Select User <span class="text-danger">*</span></label>
                                <select class="form-control" id="user_id" name="user_id" required>
                                    <option value="">Select a user to create employee profile for</option>
                                    @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->username }}) - {{ $user->email }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Basic Employment Information -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h6 class="border-bottom pb-2 mb-3">Employment Information</h6>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="employee_number">Employee Number</label>
                                <input type="text" class="form-control" id="employee_number" name="employee_number" 
                                       value="{{ old('employee_number') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="department">Department</label>
                                <input type="text" class="form-control" id="department" name="department" 
                                       value="{{ old('department') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="position">Position</label>
                                <input type="text" class="form-control" id="position" name="position" 
                                       value="{{ old('position') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="employment_type">Employment Type</label>
                                <select class="form-control" id="employment_type" name="employment_type">
                                    <option value="">Select Employment Type</option>
                                    <option value="Full-time" {{ old('employment_type') == 'Full-time' ? 'selected' : '' }}>Full-time</option>
                                    <option value="Part-time" {{ old('employment_type') == 'Part-time' ? 'selected' : '' }}>Part-time</option>
                                    <option value="Contract" {{ old('employment_type') == 'Contract' ? 'selected' : '' }}>Contract</option>
                                    <option value="Temporary" {{ old('employment_type') == 'Temporary' ? 'selected' : '' }}>Temporary</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="hire_date">Hire Date</label>
                                <input type="date" class="form-control" id="hire_date" name="hire_date" 
                                       value="{{ old('hire_date') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="salary">Salary</label>
                                <input type="number" step="0.01" class="form-control" id="salary" name="salary" 
                                       value="{{ old('salary') }}">
                            </div>
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h6 class="border-bottom pb-2 mb-3">Contact Information</h6>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="personal_email">Personal Email</label>
                                <input type="email" class="form-control" id="personal_email" name="personal_email" 
                                       value="{{ old('personal_email') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="work_phone">Work Phone</label>
                                <input type="text" class="form-control" id="work_phone" name="work_phone" 
                                       value="{{ old('work_phone') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="personal_phone">Personal Phone</label>
                                <input type="text" class="form-control" id="personal_phone" name="personal_phone" 
                                       value="{{ old('personal_phone') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="profile_photo">Profile Photo</label>
                                <input type="file" class="form-control-file" id="profile_photo" name="profile_photo" accept="image/*">
                            </div>
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h6 class="border-bottom pb-2 mb-3">Status</h6>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" 
                                           {{ old('is_active', true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">
                                        Active Employee
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Create Employee Profile</button>
                        <a href="{{route('employees.index')}}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

<style>
:root {
    --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --primary-color: #667eea;
    --secondary-color: #764ba2;
    --hover-gradient: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
}

/* Primary button with gradient */
.btn-primary {
    background: var(--primary-gradient) !important;
    border: none !important;
    color: white !important;
    transition: all 0.3s ease;
    font-weight: 500;
}

.btn-primary:hover {
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
    background: linear-gradient(135deg, #5a6268 0%, #343a40 100%) !important;
    transform: translateY(-1px);
    color: white !important;
}

/* Card styling */
.card {
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    border: none;
    border-radius: 10px;
}

.card-header {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-bottom: 1px solid #dee2e6;
    border-radius: 10px 10px 0 0 !important;
}

/* Form styling */
.form-control:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

.form-group label {
    font-weight: 500;
    color: #495057;
}
</style>
