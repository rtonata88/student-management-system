@extends('layouts.app')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{route('employees.index')}}">Human Resources</a></li>
        <li class="breadcrumb-item"><a href="{{route('employees.index')}}">Employee Bio</a></li>
        <li class="breadcrumb-item">{{ $user->name }}</li>
        <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        @if(Session::has('message'))
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            {{ Session::get('message') }}
        </div>
        @endif
        
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Employee Profile: {{ $user->name }}</h5>
                <div>
                    <a href="{{route('employees.edit', $user->id)}}" class="btn btn-primary btn-sm">
                        <svg class="c-icon mr-1">
                            <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-pencil')}}"></use>
                        </svg>
                        Update Profile
                    </a>
                    <a href="{{route('employees.index')}}" class="btn btn-secondary btn-sm">Back to List</a>
                </div>
            </div>
            <div class="card-body">
                @if(!$user->employeeProfile)
                <div class="alert alert-warning">
                    <strong>No Employee Profile Found!</strong> 
                    <a href="{{route('employees.edit', $user->id)}}">Click here to create one.</a>
                </div>
                @else
                <div class="row">
                    <!-- Profile Photo -->
                    <div class="col-md-3 text-center mb-4">
                        @if($user->employeeProfile->profile_photo)
                            <img src="{{ asset('storage/' . $user->employeeProfile->profile_photo) }}" 
                                 alt="Profile Photo" 
                                 class="img-fluid rounded-circle mb-3" 
                                 style="width: 150px; height: 150px; object-fit: cover;">
                        @else
                            <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center mx-auto mb-3" 
                                 style="width: 150px; height: 150px; color: white; font-size: 48px; font-weight: bold;">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                        @endif
                        <h5>{{ $user->name }}</h5>
                        <p class="text-muted">{{ $user->employeeProfile->position ?? 'No Position' }}</p>
                        @if($user->employeeProfile->is_active)
                            <span class="badge badge-success">Active Employee</span>
                        @else
                            <span class="badge badge-danger">Inactive Employee</span>
                        @endif
                    </div>
                    
                    <!-- Profile Details -->
                    <div class="col-md-9">
                        <!-- Basic Information -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <h6 class="border-bottom pb-2 mb-3">Basic Information</h6>
                            </div>
                            <div class="col-md-6">
                                <strong>Employee Number:</strong> {{ $user->employeeProfile->employee_number ?? 'N/A' }}<br>
                                <strong>Department:</strong> {{ $user->employeeProfile->department ?? 'N/A' }}<br>
                                <strong>Employment Type:</strong> {{ $user->employeeProfile->employment_type ?? 'N/A' }}<br>
                                <strong>Hire Date:</strong> {{ $user->employeeProfile->hire_date ? $user->employeeProfile->hire_date->format('d M Y') : 'N/A' }}<br>
                            </div>
                            <div class="col-md-6">
                                <strong>Work Email:</strong> {{ $user->email }}<br>
                                <strong>Personal Email:</strong> {{ $user->employeeProfile->personal_email ?? 'N/A' }}<br>
                                <strong>Work Phone:</strong> {{ $user->employeeProfile->work_phone ?? 'N/A' }}<br>
                                <strong>Personal Phone:</strong> {{ $user->employeeProfile->personal_phone ?? 'N/A' }}<br>
                            </div>
                        </div>

                        <!-- Personal Information -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <h6 class="border-bottom pb-2 mb-3">Personal Information</h6>
                            </div>
                            <div class="col-md-6">
                                <strong>ID Number:</strong> {{ $user->employeeProfile->id_number ?? 'N/A' }}<br>
                                <strong>Date of Birth:</strong> {{ $user->employeeProfile->date_of_birth ? $user->employeeProfile->date_of_birth->format('d M Y') : 'N/A' }}<br>
                                <strong>Gender:</strong> {{ $user->employeeProfile->gender ?? 'N/A' }}<br>
                                <strong>Marital Status:</strong> {{ $user->employeeProfile->marital_status ?? 'N/A' }}<br>
                            </div>
                            <div class="col-md-6">
                                <strong>Nationality:</strong> {{ $user->employeeProfile->nationality ?? 'N/A' }}<br>
                                <strong>Home Language:</strong> {{ $user->employeeProfile->home_language ?? 'N/A' }}<br>
                                @if($user->employeeProfile->date_of_birth)
                                <strong>Age:</strong> {{ $user->employeeProfile->age }} years<br>
                                @endif
                                @if($user->employeeProfile->hire_date)
                                <strong>Years of Service:</strong> {{ $user->employeeProfile->years_of_service }} years<br>
                                @endif
                            </div>
                        </div>

                        <!-- Address Information -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <h6 class="border-bottom pb-2 mb-3">Address Information</h6>
                            </div>
                            <div class="col-md-6">
                                <strong>Residential Address:</strong><br>
                                {{ $user->employeeProfile->residential_address ?? 'N/A' }}<br>
                                @if($user->employeeProfile->residential_city)
                                {{ $user->employeeProfile->residential_city }}, {{ $user->employeeProfile->residential_province }}<br>
                                {{ $user->employeeProfile->residential_postal_code }}
                                @endif
                            </div>
                            <div class="col-md-6">
                                <strong>Postal Address:</strong><br>
                                {{ $user->employeeProfile->postal_address ?? 'N/A' }}<br>
                                @if($user->employeeProfile->postal_city)
                                {{ $user->employeeProfile->postal_city }}, {{ $user->employeeProfile->postal_province }}<br>
                                {{ $user->employeeProfile->postal_code }}
                                @endif
                            </div>
                        </div>

                        <!-- Emergency Contact -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <h6 class="border-bottom pb-2 mb-3">Emergency Contact</h6>
                            </div>
                            <div class="col-md-12">
                                <strong>Name:</strong> {{ $user->employeeProfile->emergency_contact_name ?? 'N/A' }}<br>
                                <strong>Phone:</strong> {{ $user->employeeProfile->emergency_contact_phone ?? 'N/A' }}<br>
                                <strong>Relationship:</strong> {{ $user->employeeProfile->emergency_contact_relationship ?? 'N/A' }}<br>
                            </div>
                        </div>

                        <!-- Banking Information -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <h6 class="border-bottom pb-2 mb-3">Banking Information</h6>
                            </div>
                            <div class="col-md-6">
                                <strong>Bank Name:</strong> {{ $user->employeeProfile->bank_name ?? 'N/A' }}<br>
                                <strong>Branch:</strong> {{ $user->employeeProfile->bank_branch ?? 'N/A' }}<br>
                            </div>
                            <div class="col-md-6">
                                <strong>Account Number:</strong> {{ $user->employeeProfile->account_number ?? 'N/A' }}<br>
                                <strong>Account Type:</strong> {{ $user->employeeProfile->account_type ?? 'N/A' }}<br>
                            </div>
                        </div>

                        <!-- Qualifications -->
                        @if($user->employeeProfile->qualifications)
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <h6 class="border-bottom pb-2 mb-3">Qualifications</h6>
                                @foreach($user->employeeProfile->qualifications as $qualification)
                                <div class="mb-2">
                                    <strong>{{ $qualification['qualification'] ?? 'N/A' }}</strong><br>
                                    <small class="text-muted">
                                        {{ $qualification['institution'] ?? '' }} 
                                        @if(isset($qualification['year']))
                                        ({{ $qualification['year'] }})
                                        @endif
                                    </small>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <!-- Notes -->
                        @if($user->employeeProfile->notes)
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <h6 class="border-bottom pb-2 mb-3">Additional Notes</h6>
                                <p>{{ $user->employeeProfile->notes }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
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
    --success-gradient: linear-gradient(135deg, #56ab2f 0%, #a8e6cf 100%);
    --danger-gradient: linear-gradient(135deg, #ff416c 0%, #ff4b2b 100%);
    --warning-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
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

/* Badge styling */
.badge-success {
    background: var(--success-gradient) !important;
    color: white !important;
}

.badge-danger {
    background: var(--danger-gradient) !important;
    color: white !important;
}

.badge-warning {
    background: var(--warning-gradient) !important;
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

/* Profile photo styling */
.img-fluid {
    border: 3px solid transparent;
    background: var(--primary-gradient);
    padding: 3px;
}
</style>
