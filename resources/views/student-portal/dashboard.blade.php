@extends('layouts.student-portal')

@section('content')
<style>
    .welcome-banner {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 15px;
        color: white;
        position: relative;
        overflow: hidden;
        margin-bottom: 30px;
    }
    
    .welcome-banner::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }
    
    .stats-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border: none;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        margin-bottom: 20px;
    }
    
    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
    }
    
    .stats-number {
        font-size: 2rem;
        font-weight: 700;
        margin: 0;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    .stats-label {
        color: #6c757d;
        font-size: 0.9rem;
        margin-bottom: 0;
    }
    
    .quick-action-card {
        background: white;
        border-radius: 12px;
        border: 1px solid #e9ecef;
        transition: all 0.3s ease;
        height: 100%;
    }
    
    .quick-action-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 25px rgba(0, 0, 0, 0.1);
        border-color: #667eea;
    }
    
    .info-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border: none;
    }
    
    .avatar-placeholder {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 24px;
        font-weight: bold;
    }
    
    .btn-gradient {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 8px;
        color: white;
        padding: 8px 20px;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .btn-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        color: white;
    }
    
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
</style>

<div class="container-fluid px-4">
    <!-- Welcome Banner -->
    <div class="welcome-banner p-4 mb-4">
        <div class="row align-items-center">
            <div class="col-md-8">
                <p class="mb-1 opacity-75">{{ date('M d, Y') }}</p>
                <h2 class="mb-2 font-weight-bold">Welcome back, {{ explode(' ', Auth::user()->name)[0] }}!</h2>
                <p class="mb-0 opacity-90">
                    @if($student)
                        My Campus | My Profile | My Portal
                    @else
                        Complete your profile to get started
                    @endif
                </p>
            </div>
            <div class="col-md-4 text-right d-none d-md-block">
                <div class="avatar-placeholder mx-auto" style="width: 80px; height: 80px; font-size: 32px;">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card stats-card">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="stats-number" style="white-space: nowrap;">N$ 25,150.00</p>
                            <p class="stats-label">Outstanding Balance</p>
                            <div class="mt-3">
                                <small class="text-primary">📊 Statement</small><br>
                                <small class="text-muted">💳 Payments</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card stats-card">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="stats-number">1</p>
                            <p class="stats-label">APPLICATION</p>
                        </div>
                        <div class="text-primary" style="font-size: 2rem;">📝</div>
                    </div>
                    <div class="mt-3">
                        <button class="btn btn-gradient btn-sm">Submit Application</button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card stats-card">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="stats-number">1</p>
                            <p class="stats-label">PROOF OF REGISTRATION</p>
                        </div>
                        <div class="text-success" style="font-size: 2rem;">📄</div>
                    </div>
                    <div class="mt-3">
                        <button class="btn btn-outline-success btn-sm">Download</button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card stats-card">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="stats-number">{{ $stats['total_subjects'] ?? 0 }}</p>
                            <p class="stats-label">Total Subjects</p>
                        </div>
                        <div class="text-primary" style="font-size: 2rem;">📚</div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('student-portal.my-subjects') }}" class="btn btn-gradient btn-sm">My Subjects</a>
                    </div>
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
                                        <p class="info-value">{{ $student->student_number ?? '202599444' }}</p>
                                    </div>
                                    <div class="info-item mb-4">
                                        <label class="info-label">Gender</label>
                                        <p class="info-value text-muted">{{ $student->gender ?? 'Male' }}</p>
                                    </div>
                                    <div class="info-item mb-4">
                                        <label class="info-label">Mobile Number</label>
                                        <div class="d-flex align-items-center">
                                            <div class="online-indicator me-2"></div>
                                            <p class="info-value mb-0">{{ $student->contact_number ?? '0817456880' }}</p>
                                        </div>
                                    </div>
                                    <div class="info-item mb-4">
                                        <label class="info-label">Campus</label>
                                        <p class="info-value text-muted">{{ $student->center->center_name ?? 'Windhoek Campus' }}</p>
                                    </div>
                                </div>
                                
                                <!-- Column 2 -->
                                <div class="col-md-4">
                                    <div class="info-item mb-4">
                                        <label class="info-label">Full Name</label>
                                        <p class="info-value">{{ $student->student_names ?? 'Mr. Sharadon Allistor' }} {{ $student->surname ?? 'Jacobs' }}</p>
                                    </div>
                                    <div class="info-item mb-4">
                                        <label class="info-label">Birthdate</label>
                                        <p class="info-value text-muted">{{ $student->date_of_birth ? date('d M, Y', strtotime($student->date_of_birth)) : '31 Jul, 1988' }}</p>
                                    </div>
                                    <div class="info-item mb-4">
                                        <label class="info-label">Email Address</label>
                                        <p class="info-value text-muted">{{ $student->contact_email ?? Auth::user()->email ?? 'allistorjacobs@gmail.com' }}</p>
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
                                        <p class="info-value text-muted">8807310029</p>
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
