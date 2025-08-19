@extends('layouts.app')

@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item active">Welcome</li>
        <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection

@section('content')
<div class="welcome-container">
    <!-- Hero Section -->
    <div class="hero-section text-center py-4 mb-4">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h1 class="hero-title mb-3">
                        <span class="text-gradient">Welcome to</span><br>
                        <span class="text-primary fw-bold">EDUCIMS TUTORIALS SYSTEM</span>
                    </h1>
                    <p class="hero-subtitle lead text-muted">
                        Hello, <span class="fw-bold text-primary">{{ $user->name }}</span>! 
                        <span class="wave">👋</span> We're excited to have you here today.
                    </p>
                    <div class="hero-stats mt-4">
                        <div class="row justify-content-center">
                            <div class="col-md-3 col-sm-6 mb-3">
                                <div class="stat-card">
                                    <div class="stat-number text-primary fw-bold">24/7</div>
                                    <div class="stat-label">System Access</div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 mb-3">
                                <div class="stat-card">
                                    <div class="stat-number text-success fw-bold">100%</div>
                                    <div class="stat-label">Secure</div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 mb-3">
                                <div class="stat-card">
                                    <div class="stat-number text-info fw-bold">Real-time</div>
                                    <div class="stat-label">Updates</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container-fluid">
        <!-- Quick Actions Section -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="section-header mb-4">
                    <h2 class="section-title">
                        <svg class="c-icon c-icon-lg me-2">
                            <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-bolt')}}"></use>
                        </svg>
                        Quick Actions
                    </h2>
                    <p class="section-subtitle text-muted">Get started with these common tasks</p>
                </div>
                <div class="quick-actions-grid">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 mb-4">
                            <a href="/enrolment" class="quick-action-card">
                                <div class="card-icon">
                                    <svg class="c-icon c-icon-2xl text-success">
                                        <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-plus')}}"></use>
                                    </svg>
                                </div>
                                <div class="card-content">
                                    <h5>New Enrolment</h5>
                                    <p>Register students for courses</p>
                                </div>
                                <div class="card-arrow">
                                    <svg class="c-icon">
                                        <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-arrow-right')}}"></use>
                                    </svg>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-4">
                            <a href="/students" class="quick-action-card">
                                <div class="card-icon">
                                    <svg class="c-icon c-icon-2xl text-primary">
                                        <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-user-plus')}}"></use>
                                    </svg>
                                </div>
                                <div class="card-content">
                                    <h5>Add Student</h5>
                                    <p>Create new student profiles</p>
                                </div>
                                <div class="card-arrow">
                                    <svg class="c-icon">
                                        <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-arrow-right')}}"></use>
                                    </svg>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-4">
                            <a href="/payments" class="quick-action-card">
                                <div class="card-icon">
                                    <svg class="c-icon c-icon-2xl text-warning">
                                        <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-credit-card')}}"></use>
                                    </svg>
                                </div>
                                <div class="card-content">
                                    <h5>Record Payment</h5>
                                    <p>Process student payments</p>
                                </div>
                                <div class="card-arrow">
                                    <svg class="c-icon">
                                        <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-arrow-right')}}"></use>
                                    </svg>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-4">
                            <a href="/student/reports" class="quick-action-card">
                                <div class="card-icon">
                                    <svg class="c-icon c-icon-2xl text-info">
                                        <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-chart')}}"></use>
                                    </svg>
                                </div>
                                <div class="card-content">
                                    <h5>View Reports</h5>
                                    <p>Generate system reports</p>
                                </div>
                                <div class="card-arrow">
                                    <svg class="c-icon">
                                        <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-arrow-right')}}"></use>
                                    </svg>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Features Section -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="section-header mb-4">
                    <h2 class="section-title">
                        <svg class="c-icon c-icon-lg me-2">
                            <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-star')}}"></use>
                        </svg>
                        System Features
                    </h2>
                    <p class="section-subtitle text-muted">Explore the main functionalities of our system</p>
                </div>
                <div class="features-grid">
                    <div class="row">
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="feature-card">
                                <div class="feature-icon">
                                    <svg class="c-icon c-icon-3xl text-primary">
                                        <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-education')}}"></use>
                                    </svg>
                                </div>
                                <div class="feature-content">
                                    <h4 class="feature-title">Student Management</h4>
                                    <p class="feature-description">Comprehensive student information management with biographical data, academic records, and enrollment tracking.</p>
                                    <a href="/students" class="btn btn-outline-primary btn-sm">Explore Students</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="feature-card">
                                <div class="feature-icon">
                                    <svg class="c-icon c-icon-3xl text-success">
                                        <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-check-circle')}}"></use>
                                    </svg>
                                </div>
                                <div class="feature-content">
                                    <h4 class="feature-title">Enrolment System</h4>
                                    <p class="feature-description">Streamlined course registration with automated fee calculations and enrollment status management.</p>
                                    <a href="/enrolment" class="btn btn-outline-success btn-sm">Manage Enrolments</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="feature-card">
                                <div class="feature-icon">
                                    <svg class="c-icon c-icon-3xl text-info">
                                        <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-wallet')}}"></use>
                                    </svg>
                                </div>
                                <div class="feature-content">
                                    <h4 class="feature-title">Financial Management</h4>
                                    <p class="feature-description">Complete financial tracking including invoices, payments, credit memos, and student account statements.</p>
                                    <a href="/invoices" class="btn btn-outline-info btn-sm">View Finance</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="feature-card">
                                <div class="feature-icon">
                                    <svg class="c-icon c-icon-3xl text-warning">
                                        <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-chart')}}"></use>
                                    </svg>
                                </div>
                                <div class="feature-content">
                                    <h4 class="feature-title">Advanced Reporting</h4>
                                    <p class="feature-description">Generate comprehensive reports on student registrations, financial data, and system analytics.</p>
                                    <a href="/student/reports" class="btn btn-outline-warning btn-sm">Access Reports</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="feature-card">
                                <div class="feature-icon">
                                    <svg class="c-icon c-icon-3xl text-secondary">
                                        <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-cog')}}"></use>
                                    </svg>
                                </div>
                                <div class="feature-content">
                                    <h4 class="feature-title">System Administration</h4>
                                    <p class="feature-description">Comprehensive system configuration with user management, roles, permissions, and system settings.</p>
                                    <a href="/users" class="btn btn-outline-secondary btn-sm">Admin Panel</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="feature-card">
                                <div class="feature-icon">
                                    <svg class="c-icon c-icon-3xl text-danger">
                                        <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-speedometer')}}"></use>
                                    </svg>
                                </div>
                                <div class="feature-content">
                                    <h4 class="feature-title">Dashboard Analytics</h4>
                                    <p class="feature-description">Real-time system overview with key performance indicators and operational metrics.</p>
                                    <a href="/home" class="btn btn-outline-danger btn-sm">View Dashboard</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- System Status Section -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="system-status-card">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h3 class="status-title mb-2">System Status</h3>
                            <p class="status-description mb-0">All systems are running smoothly. You have full access to all features.</p>
                        </div>
                        <div class="col-md-4 text-md-end">
                            <div class="status-indicator">
                                <span class="status-dot online"></span>
                                <span class="status-text">Online</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.welcome-container {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    min-height: 100vh;
}

.hero-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 0 0 30px 30px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.hero-title {
    font-size: 2.5rem;
    font-weight: 700;
    line-height: 1.2;
}

.text-gradient {
    background: linear-gradient(45deg, #ffd700, #ffed4e);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.hero-subtitle {
    font-size: 1.1rem;
    font-weight: 400;
}

.wave {
    animation: wave 2s infinite;
    display: inline-block;
}

@keyframes wave {
    0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
    40% { transform: translateY(-10px); }
    60% { transform: translateY(-5px); }
}

.stat-card {
    background: rgba(255,255,255,0.2);
    padding: 1rem;
    border-radius: 15px;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,0.3);
}

.stat-number {
    font-size: 1.8rem;
    font-weight: 700;
}

.stat-label {
    font-size: 0.9rem;
    opacity: 0.9;
}

.section-header {
    text-align: center;
}

.section-title {
    font-size: 2.2rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 0.5rem;
}

.section-subtitle {
    font-size: 1.1rem;
    color: #6c757d;
}

.quick-action-card {
    display: block;
    background: white;
    border-radius: 20px;
    padding: 1.5rem;
    text-decoration: none;
    color: inherit;
    transition: all 0.3s ease;
    border: 2px solid transparent;
    position: relative;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
}

.quick-action-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.15);
    border-color: #007bff;
    text-decoration: none;
    color: inherit;
}

.card-icon {
    text-align: center;
    margin-bottom: 1rem;
}

.card-content h5 {
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 0.5rem;
}

.card-content p {
    color: #6c757d;
    margin-bottom: 0;
    font-size: 0.9rem;
}

.card-arrow {
    position: absolute;
    top: 1rem;
    right: 1rem;
    opacity: 0;
    transition: all 0.3s ease;
}

.quick-action-card:hover .card-arrow {
    opacity: 1;
    transform: translateX(5px);
}

.feature-card {
    background: white;
    border-radius: 20px;
    padding: 2rem;
    height: 100%;
    transition: all 0.3s ease;
    border: 2px solid transparent;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
}

.feature-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.15);
    border-color: #007bff;
}

.feature-icon {
    text-align: center;
    margin-bottom: 1.5rem;
}

.feature-title {
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 1rem;
    font-size: 1.3rem;
}

.feature-description {
    color: #6c757d;
    margin-bottom: 1.5rem;
    line-height: 1.6;
}

.system-status-card {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    color: white;
    padding: 1rem 2rem;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(40, 167, 69, 0.2);
}

.status-title {
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.status-description {
    opacity: 0.9;
}

.status-indicator {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 0.5rem;
}

.status-dot {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background: #fff;
    animation: pulse 2s infinite;
}

.status-dot.online {
    background: #fff;
}

.status-text {
    font-weight: 600;
    font-size: 1.1rem;
}

@keyframes pulse {
    0% { opacity: 1; }
    50% { opacity: 0.5; }
    100% { opacity: 1; }
}

@media (max-width: 768px) {
    .hero-title {
        font-size: 2.5rem;
    }
    
    .hero-subtitle {
        font-size: 1.1rem;
    }
    
    .section-title {
        font-size: 1.8rem;
    }
    
    .quick-action-card,
    .feature-card {
        margin-bottom: 1rem;
    }
}
</style>
@endsection 