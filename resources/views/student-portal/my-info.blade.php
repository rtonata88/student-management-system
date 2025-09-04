@extends('layouts.student-portal')

@section('content')
<style>
    .profile-photo-placeholder {
        width: 120px;
        height: 120px;
        background: #e9ecef;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #6c757d;
        font-size: 48px;
        font-weight: bold;
        position: relative;
        margin: 0 auto;
    }
    
    .profile-photo-container {
        width: 120px;
        height: 120px;
        position: relative;
        margin: 0 auto;
    }
    
    .profile-photo-image {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #fff;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
    
    .online-status {
        position: absolute;
        bottom: 8px;
        right: 8px;
        width: 20px;
        height: 20px;
        background: #28a745;
        border: 3px solid white;
        border-radius: 50%;
    }
    
    .online-indicator {
        width: 12px;
        height: 12px;
        background: #28a745;
        border-radius: 50%;
        flex-shrink: 0;
    }
    
    .info-item {
        margin-bottom: 1.5rem;
    }
    
    .info-label {
        font-size: 14px;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 4px;
        display: block;
    }
    
    .info-value {
        font-size: 14px;
        color: #2c3e50;
        margin-bottom: 0;
        font-weight: 500;
    }
    
    .info-value.text-muted {
        color: #6c757d !important;
        font-weight: 400;
    }
    
    .info-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border: none;
    }
</style>

<div class="container-fluid px-4">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box mb-4">
                <h4 class="page-title">My Information</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('student-portal.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('student-portal.profile') }}">Profile</a></li>
                        <li class="breadcrumb-item active">My Information</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Student Information Section -->
    <div class="row">
        <div class="col-12">
            <div class="card info-card">
                <div class="card-body p-4">
                    <h5 class="card-title mb-4 font-weight-bold">Student Information</h5>
                    
                    @if($student)
                    <div class="row align-items-start">
                        <!-- Profile Photo Section -->
                        <div class="col-md-2 text-center mb-4">
                            <div class="position-relative d-inline-block">
                                @if($student->photo)
                                    <div class="profile-photo-container">
                                        <img src="{{ asset('storage/' . $student->photo) }}" 
                                             alt="{{ $student->student_names }} {{ $student->surname }}" 
                                             class="profile-photo-image">
                                        <div class="online-status"></div>
                                    </div>
                                @else
                                    <div class="profile-photo-placeholder">
                                        {{ substr($student->student_names ?? Auth::user()->name, 0, 1) }}
                                    </div>
                                    <div class="online-status"></div>
                                @endif
                            </div>
                            <p class="text-muted small mt-2 mb-0">{{ $student->photo ? 'Student Photo' : 'No Photo' }}</p>
                        </div>
                        
                        <!-- Student Information Grid -->
                        <div class="col-md-10">
                            <div class="row">
                                <!-- Column 1 -->
                                <div class="col-md-4">
                                    <div class="info-item mb-4">
                                        <label class="info-label">Student Number</label>
                                        <p class="info-value">{{ $student->student_number ?? 'Not assigned' }}</p>
                                    </div>
                                    <div class="info-item mb-4">
                                        <label class="info-label">Gender</label>
                                        <p class="info-value text-muted">{{ $student->gender ?? 'Not specified' }}</p>
                                    </div>
                                    <div class="info-item mb-4">
                                        <label class="info-label">Mobile Number</label>
                                        <div class="d-flex align-items-center">
                                            <div class="online-indicator me-2"></div>
                                            <p class="info-value mb-0">{{ $student->contact_number ?? 'Not provided' }}</p>
                                        </div>
                                    </div>
                                    <div class="info-item mb-4">
                                        <label class="info-label">Campus</label>
                                        <p class="info-value text-muted">{{ $student->center->center_name ?? 'Not assigned' }}</p>
                                    </div>
                                </div>
                                
                                <!-- Column 2 -->
                                <div class="col-md-4">
                                    <div class="info-item mb-4">
                                        <label class="info-label">Full Name</label>
                                        <p class="info-value">{{ $student->student_names ?? 'Not provided' }} {{ $student->surname ?? '' }}</p>
                                    </div>
                                    <div class="info-item mb-4">
                                        <label class="info-label">Birthdate</label>
                                        <p class="info-value text-muted">{{ $student->date_of_birth ? date('d M, Y', strtotime($student->date_of_birth)) : 'Not provided' }}</p>
                                    </div>
                                    <div class="info-item mb-4">
                                        <label class="info-label">Email Address</label>
                                        <p class="info-value text-muted">{{ $student->contact_email ?? Auth::user()->email ?? 'Not provided' }}</p>
                                    </div>
                                    <div class="info-item mb-4">
                                        <label class="info-label">Qualification</label>
                                        <p class="info-value text-muted">Academic Advancement Programme</p>
                                    </div>
                                </div>
                                
                                <!-- Column 3 -->
                                <div class="col-md-4">
                                    <div class="info-item mb-4">
                                        <label class="info-label">Bursary Information</label>
                                        <p class="info-value text-muted">Not linked to any bursary</p>
                                    </div>
                                    <div class="info-item mb-4">
                                        <label class="info-label">ID Number</label>
                                        <p class="info-value text-muted">{{ $student->id_number ?? 'Not provided' }}</p>
                                    </div>
                                    <div class="info-item mb-4">
                                        <label class="info-label">Citizenship</label>
                                        <p class="info-value text-muted">{{ $student->nationality ?? 'Namibian' }}</p>
                                    </div>
                                    <div class="info-item mb-4">
                                        <label class="info-label">Intake</label>
                                        <p class="info-value text-muted">
                                            @if($student->currentRegistration)
                                                {{ $student->currentRegistration->academic_year }} - Current Intake
                                            @elseif($student->registration->first())
                                                {{ $student->registration->first()->academic_year }} - Intake
                                            @else
                                                {{ date('Y') }} - Current Intake
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="text-center py-4">
                        <div class="profile-photo-placeholder mx-auto mb-3">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <h6>Complete Your Profile</h6>
                        <p class="text-muted">Please complete your student information to access all features.</p>
                        <a href="{{ route('online-application.student-info') }}" class="btn btn-gradient">Complete Profile</a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
