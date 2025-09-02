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
                <div class="card-body p-4 text-center">
                    <div class="mb-3">
                        <div style="font-size: 3rem; color: #667eea;">1</div>
                    </div>
                    <p class="stats-label">APPLICATION</p>
                    <button class="btn btn-gradient btn-sm mt-2">Submit Application</button>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card stats-card">
                <div class="card-body p-4 text-center">
                    <div class="mb-3">
                        <div style="font-size: 3rem; color: #28a745;">1</div>
                    </div>
                    <p class="stats-label">PROOF OF REGISTRATION</p>
                    <button class="btn btn-outline-success btn-sm mt-2">Download</button>
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
                    <div class="row">
                        <div class="col-md-2 text-center mb-3">
                            <div class="avatar-placeholder mx-auto mb-2">
                                {{ substr($student->student_names ?? Auth::user()->name, 0, 1) }}
                            </div>
                            <small class="text-muted">My Profile</small>
                        </div>
                        
                        <div class="col-md-10">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="text-muted small">Student Number</label>
                                        <p class="mb-0 font-weight-medium">{{ $student->student_number ?? 'Not assigned' }}</p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="text-muted small">Gender</label>
                                        <p class="mb-0">{{ $student->gender ?? 'Not specified' }}</p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="text-muted small">Campus</label>
                                        <p class="mb-0">{{ $student->center->center_name ?? 'Windhoek Campus' }}</p>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="text-muted small">Full Name</label>
                                        <p class="mb-0 font-weight-medium">{{ $student->student_names }} {{ $student->surname }}</p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="text-muted small">Birthdate</label>
                                        <p class="mb-0">{{ $student->date_of_birth ? date('M d, Y', strtotime($student->date_of_birth)) : 'Not provided' }}</p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="text-muted small">Qualification</label>
                                        <p class="mb-0">Certificate in Extended Nursing and Midwifery Sciences Level 6</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="text-muted small">Mobile Number</label>
                                        <p class="mb-0">{{ $student->contact_number ?? 'Not provided' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="text-muted small">Email Address</label>
                                        <p class="mb-0">{{ $student->contact_email ?? Auth::user()->email }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="text-muted small">Intake</label>
                                        <p class="mb-0">August Intake</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="text-muted small">Citizenship</label>
                                        <p class="mb-0">{{ $student->nationality ?? 'Namibian' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="text-center py-4">
                        <div class="avatar-placeholder mx-auto mb-3">
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
