@extends('layouts.app')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{route('employees.index')}}">Human Resources</a></li>
        <li class="breadcrumb-item"><a href="{{route('employees.index')}}">Employee Bio</a></li>
        <li class="breadcrumb-item">{{ $user->employeeProfile ? 'Edit' : 'Create' }} Profile</li>
        <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">{{ $user->employeeProfile ? 'Update' : 'Create' }} Employee Profile: {{ $user->name }}</h5>
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

                <form method="POST" action="{{route('employees.update', $user->id)}}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <!-- Basic Employment Information -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h6 class="border-bottom pb-2 mb-3">Employment Information</h6>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="employee_number">Employee Number</label>
                                <input type="text" class="form-control" id="employee_number" name="employee_number" 
                                       value="{{ old('employee_number', $user->employeeProfile->employee_number ?? '') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="department">Department</label>
                                <input type="text" class="form-control" id="department" name="department" 
                                       value="{{ old('department', $user->employeeProfile->department ?? '') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="position">Position</label>
                                <input type="text" class="form-control" id="position" name="position" 
                                       value="{{ old('position', $user->employeeProfile->position ?? '') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="employment_type">Employment Type</label>
                                <select class="form-control" id="employment_type" name="employment_type">
                                    <option value="">Select Employment Type</option>
                                    <option value="Full-time" {{ old('employment_type', $user->employeeProfile->employment_type ?? '') == 'Full-time' ? 'selected' : '' }}>Full-time</option>
                                    <option value="Part-time" {{ old('employment_type', $user->employeeProfile->employment_type ?? '') == 'Part-time' ? 'selected' : '' }}>Part-time</option>
                                    <option value="Contract" {{ old('employment_type', $user->employeeProfile->employment_type ?? '') == 'Contract' ? 'selected' : '' }}>Contract</option>
                                    <option value="Temporary" {{ old('employment_type', $user->employeeProfile->employment_type ?? '') == 'Temporary' ? 'selected' : '' }}>Temporary</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="hire_date">Hire Date</label>
                                <input type="date" class="form-control" id="hire_date" name="hire_date" 
                                       value="{{ old('hire_date', $user->employeeProfile && $user->employeeProfile->hire_date ? $user->employeeProfile->hire_date->format('Y-m-d') : '') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="salary">Salary</label>
                                <input type="number" step="0.01" class="form-control" id="salary" name="salary" 
                                       value="{{ old('salary', $user->employeeProfile->salary ?? '') }}">
                            </div>
                        </div>
                    </div>

                    <!-- Personal Information -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h6 class="border-bottom pb-2 mb-3">Personal Information</h6>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="id_number">ID Number</label>
                                <input type="text" class="form-control" id="id_number" name="id_number" 
                                       value="{{ old('id_number', $user->employeeProfile->id_number ?? '') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="passport_number">Passport Number</label>
                                <input type="text" class="form-control" id="passport_number" name="passport_number" 
                                       value="{{ old('passport_number', $user->employeeProfile->passport_number ?? '') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="date_of_birth">Date of Birth</label>
                                <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" 
                                       value="{{ old('date_of_birth', $user->employeeProfile && $user->employeeProfile->date_of_birth ? $user->employeeProfile->date_of_birth->format('Y-m-d') : '') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="gender">Gender</label>
                                <select class="form-control" id="gender" name="gender">
                                    <option value="">Select Gender</option>
                                    <option value="Male" {{ old('gender', $user->employeeProfile->gender ?? '') == 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ old('gender', $user->employeeProfile->gender ?? '') == 'Female' ? 'selected' : '' }}>Female</option>
                                    <option value="Other" {{ old('gender', $user->employeeProfile->gender ?? '') == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="marital_status">Marital Status</label>
                                <select class="form-control" id="marital_status" name="marital_status">
                                    <option value="">Select Marital Status</option>
                                    <option value="Single" {{ old('marital_status', $user->employeeProfile->marital_status ?? '') == 'Single' ? 'selected' : '' }}>Single</option>
                                    <option value="Married" {{ old('marital_status', $user->employeeProfile->marital_status ?? '') == 'Married' ? 'selected' : '' }}>Married</option>
                                    <option value="Divorced" {{ old('marital_status', $user->employeeProfile->marital_status ?? '') == 'Divorced' ? 'selected' : '' }}>Divorced</option>
                                    <option value="Widowed" {{ old('marital_status', $user->employeeProfile->marital_status ?? '') == 'Widowed' ? 'selected' : '' }}>Widowed</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nationality">Nationality</label>
                                <input type="text" class="form-control" id="nationality" name="nationality" 
                                       value="{{ old('nationality', $user->employeeProfile->nationality ?? '') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="home_language">Home Language</label>
                                <input type="text" class="form-control" id="home_language" name="home_language" 
                                       value="{{ old('home_language', $user->employeeProfile->home_language ?? '') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="profile_photo">Profile Photo</label>
                                <input type="file" class="form-control-file" id="profile_photo" name="profile_photo" accept="image/*">
                                @if($user->employeeProfile && $user->employeeProfile->profile_photo)
                                <small class="form-text text-muted">Current photo will be replaced if you upload a new one.</small>
                                @endif
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
                                       value="{{ old('personal_email', $user->employeeProfile->personal_email ?? '') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="work_phone">Work Phone</label>
                                <input type="text" class="form-control" id="work_phone" name="work_phone" 
                                       value="{{ old('work_phone', $user->employeeProfile->work_phone ?? '') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="personal_phone">Personal Phone</label>
                                <input type="text" class="form-control" id="personal_phone" name="personal_phone" 
                                       value="{{ old('personal_phone', $user->employeeProfile->personal_phone ?? '') }}">
                            </div>
                        </div>
                    </div>

                    <!-- Emergency Contact -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h6 class="border-bottom pb-2 mb-3">Emergency Contact</h6>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="emergency_contact_name">Emergency Contact Name</label>
                                <input type="text" class="form-control" id="emergency_contact_name" name="emergency_contact_name" 
                                       value="{{ old('emergency_contact_name', $user->employeeProfile->emergency_contact_name ?? '') }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="emergency_contact_phone">Emergency Contact Phone</label>
                                <input type="text" class="form-control" id="emergency_contact_phone" name="emergency_contact_phone" 
                                       value="{{ old('emergency_contact_phone', $user->employeeProfile->emergency_contact_phone ?? '') }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="emergency_contact_relationship">Relationship</label>
                                <input type="text" class="form-control" id="emergency_contact_relationship" name="emergency_contact_relationship" 
                                       value="{{ old('emergency_contact_relationship', $user->employeeProfile->emergency_contact_relationship ?? '') }}">
                            </div>
                        </div>
                    </div>

                    <!-- Address Information -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h6 class="border-bottom pb-2 mb-3">Address Information</h6>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="residential_address">Residential Address</label>
                                <textarea class="form-control" id="residential_address" name="residential_address" rows="3">{{ old('residential_address', $user->employeeProfile->residential_address ?? '') }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="postal_address">Postal Address</label>
                                <textarea class="form-control" id="postal_address" name="postal_address" rows="3">{{ old('postal_address', $user->employeeProfile->postal_address ?? '') }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="residential_city">Residential City</label>
                                <input type="text" class="form-control" id="residential_city" name="residential_city" 
                                       value="{{ old('residential_city', $user->employeeProfile->residential_city ?? '') }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="residential_province">Residential Province</label>
                                <input type="text" class="form-control" id="residential_province" name="residential_province" 
                                       value="{{ old('residential_province', $user->employeeProfile->residential_province ?? '') }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="postal_city">Postal City</label>
                                <input type="text" class="form-control" id="postal_city" name="postal_city" 
                                       value="{{ old('postal_city', $user->employeeProfile->postal_city ?? '') }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="postal_province">Postal Province</label>
                                <input type="text" class="form-control" id="postal_province" name="postal_province" 
                                       value="{{ old('postal_province', $user->employeeProfile->postal_province ?? '') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="residential_postal_code">Residential Postal Code</label>
                                <input type="text" class="form-control" id="residential_postal_code" name="residential_postal_code" 
                                       value="{{ old('residential_postal_code', $user->employeeProfile->residential_postal_code ?? '') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="postal_code">Postal Code</label>
                                <input type="text" class="form-control" id="postal_code" name="postal_code" 
                                       value="{{ old('postal_code', $user->employeeProfile->postal_code ?? '') }}">
                            </div>
                        </div>
                    </div>

                    <!-- Banking Information -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h6 class="border-bottom pb-2 mb-3">Banking Information</h6>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="bank_name">Bank Name</label>
                                <input type="text" class="form-control" id="bank_name" name="bank_name" 
                                       value="{{ old('bank_name', $user->employeeProfile->bank_name ?? '') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="bank_branch">Bank Branch</label>
                                <input type="text" class="form-control" id="bank_branch" name="bank_branch" 
                                       value="{{ old('bank_branch', $user->employeeProfile->bank_branch ?? '') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="account_number">Account Number</label>
                                <input type="text" class="form-control" id="account_number" name="account_number" 
                                       value="{{ old('account_number', $user->employeeProfile->account_number ?? '') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="account_type">Account Type</label>
                                <select class="form-control" id="account_type" name="account_type">
                                    <option value="">Select Account Type</option>
                                    <option value="Savings" {{ old('account_type', $user->employeeProfile->account_type ?? '') == 'Savings' ? 'selected' : '' }}>Savings</option>
                                    <option value="Cheque" {{ old('account_type', $user->employeeProfile->account_type ?? '') == 'Cheque' ? 'selected' : '' }}>Cheque</option>
                                    <option value="Current" {{ old('account_type', $user->employeeProfile->account_type ?? '') == 'Current' ? 'selected' : '' }}>Current</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Tax Information -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h6 class="border-bottom pb-2 mb-3">Tax Information</h6>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tax_number">Tax Number</label>
                                <input type="text" class="form-control" id="tax_number" name="tax_number" 
                                       value="{{ old('tax_number', $user->employeeProfile->tax_number ?? '') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="uif_number">UIF Number</label>
                                <input type="text" class="form-control" id="uif_number" name="uif_number" 
                                       value="{{ old('uif_number', $user->employeeProfile->uif_number ?? '') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="medical_aid_name">Medical Aid Name</label>
                                <input type="text" class="form-control" id="medical_aid_name" name="medical_aid_name" 
                                       value="{{ old('medical_aid_name', $user->employeeProfile->medical_aid_name ?? '') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="medical_aid_number">Medical Aid Number</label>
                                <input type="text" class="form-control" id="medical_aid_number" name="medical_aid_number" 
                                       value="{{ old('medical_aid_number', $user->employeeProfile->medical_aid_number ?? '') }}">
                            </div>
                        </div>
                    </div>

                    <!-- Additional Information -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h6 class="border-bottom pb-2 mb-3">Additional Information</h6>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="notes">Notes</label>
                                <textarea class="form-control" id="notes" name="notes" rows="4">{{ old('notes', $user->employeeProfile->notes ?? '') }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" 
                                           {{ old('is_active', $user->employeeProfile->is_active ?? true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">
                                        Active Employee
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            {{ $user->employeeProfile ? 'Update' : 'Create' }} Profile
                        </button>
                        <a href="{{route('employees.index')}}" class="btn btn-secondary">Cancel</a>
                        @if($user->employeeProfile)
                        <a href="{{route('employees.show', $user->id)}}" class="btn btn-info">View Profile</a>
                        @endif
                    </div>
                </form>
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
    --info-gradient: linear-gradient(135deg, #36d1dc 0%, #5b86e5 100%);
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

/* Info button styling */
.btn-info {
    background: var(--info-gradient) !important;
    border: none !important;
    color: white !important;
    transition: all 0.3s ease;
}

.btn-info:hover {
    background: linear-gradient(135deg, #2bc0cc 0%, #4a7bd1 100%) !important;
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
