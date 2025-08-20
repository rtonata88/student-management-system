@extends('layouts.app')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Human Resources</li>
        <li class="breadcrumb-item">Payroll Management</li>
        <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection
@section('content')
<div class="row">
    <div class="col-md-12 col-xs-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Payroll Management</h5>
                <small class="text-muted">Employee payroll processing and management system</small>
            </div>
            <div class="card-body">
                <div class="text-center py-5">
                    <div class="coming-soon-container">
                        <svg class="c-icon c-icon-6xl text-primary mb-4">
                            <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-dollar')}}"></use>
                        </svg>
                        <h2 class="text-primary mb-3">Coming Soon</h2>
                        <p class="text-muted mb-4 lead">
                            The Payroll Management system is currently under development. This feature will include:
                        </p>
                        <div class="row justify-content-center">
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="feature-item">
                                            <svg class="c-icon c-icon-lg text-success mb-2">
                                                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-check')}}"></use>
                                            </svg>
                                            <h6>Salary Processing</h6>
                                            <small class="text-muted">Automated salary calculations and processing</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="feature-item">
                                            <svg class="c-icon c-icon-lg text-success mb-2">
                                                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-check')}}"></use>
                                            </svg>
                                            <h6>Tax Calculations</h6>
                                            <small class="text-muted">Automatic tax deductions and compliance</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="feature-item">
                                            <svg class="c-icon c-icon-lg text-success mb-2">
                                                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-check')}}"></use>
                                            </svg>
                                            <h6>Payslip Generation</h6>
                                            <small class="text-muted">Digital payslips and payment records</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="feature-item">
                                            <svg class="c-icon c-icon-lg text-success mb-2">
                                                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-check')}}"></use>
                                            </svg>
                                            <h6>Benefits Management</h6>
                                            <small class="text-muted">Employee benefits and allowances tracking</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">
                            <p class="text-muted">
                                <strong>Expected Release:</strong> Q3 2026
                            </p>
                            <p class="text-muted small">
                                For any questions or feature requests, please contact the system administrator.
                            </p>
                        </div>
                    </div>
                </div>
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
    --success-gradient: linear-gradient(135deg, #56ab2f 0%, #a8e6cf 100%);
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

/* Coming soon container */
.coming-soon-container {
    padding: 2rem;
    max-width: 800px;
    margin: 0 auto;
}

/* Feature items */
.feature-item {
    text-align: center;
    padding: 1rem;
    border-radius: 8px;
    background: rgba(102, 126, 234, 0.05);
    margin-bottom: 1rem;
    transition: all 0.3s ease;
}

.feature-item:hover {
    background: rgba(102, 126, 234, 0.1);
    transform: translateY(-2px);
}

.feature-item h6 {
    color: var(--primary-color);
    font-weight: 600;
    margin-bottom: 0.5rem;
}

/* Icon styling */
.c-icon {
    transition: all 0.3s ease;
}

.text-primary {
    color: var(--primary-color) !important;
}

.text-success {
    color: #56ab2f !important;
}

/* Animation for the main icon */
.c-icon-6xl {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.05);
    }
    100% {
        transform: scale(1);
    }
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .coming-soon-container {
        padding: 1rem;
    }
    
    .feature-item {
        margin-bottom: 0.5rem;
    }
}
</style>
