@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="fade-in">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg border-0" style="border-radius: 15px;">
                    <div class="card-header text-center" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border-radius: 15px 15px 0 0;">
                        <h4 class="mb-0">
                            <i class="fas fa-calculator mr-2"></i>
                            Process Final Marks
                        </h4>
                    </div>
                    <div class="card-body text-center py-5">
                        <div class="coming-soon-icon mb-4">
                            <i class="fas fa-tools" style="font-size: 4rem; color: #6f42c1; opacity: 0.7;"></i>
                        </div>
                        
                        <h2 class="text-muted mb-4">Coming Soon</h2>
                        
                        <div class="feature-description mb-4">
                            <p class="lead text-muted mb-3">
                                This powerful feature will allow you to process test and exam marks to create final marks for students using various calculation rules and weights.
                            </p>
                            
                            <div class="row mt-4">
                                <div class="col-md-6 mb-3">
                                    <div class="feature-item p-3" style="background: #f8f9fa; border-radius: 10px;">
                                        <i class="fas fa-percentage text-primary mb-2" style="font-size: 1.5rem;"></i>
                                        <h6 class="font-weight-bold">Weighted Calculations</h6>
                                        <small class="text-muted">Configure custom weights for tests and exams</small>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="feature-item p-3" style="background: #f8f9fa; border-radius: 10px;">
                                        <i class="fas fa-chart-line text-success mb-2" style="font-size: 1.5rem;"></i>
                                        <h6 class="font-weight-bold">Grade Processing</h6>
                                        <small class="text-muted">Automatic grade assignment based on marks</small>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="feature-item p-3" style="background: #f8f9fa; border-radius: 10px;">
                                        <i class="fas fa-users text-info mb-2" style="font-size: 1.5rem;"></i>
                                        <h6 class="font-weight-bold">Batch Processing</h6>
                                        <small class="text-muted">Process multiple students simultaneously</small>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="feature-item p-3" style="background: #f8f9fa; border-radius: 10px;">
                                        <i class="fas fa-file-export text-warning mb-2" style="font-size: 1.5rem;"></i>
                                        <h6 class="font-weight-bold">Report Generation</h6>
                                        <small class="text-muted">Generate comprehensive mark sheets</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="alert alert-info" role="alert">
                            <i class="fas fa-info-circle mr-2"></i>
                            This feature is currently under development and will be available in a future update.
                        </div>
                        
                        <div class="mt-4">
                            <a href="{{ url()->previous() }}" class="btn btn-lg" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.75rem 2rem;">
                                <i class="fas fa-arrow-left mr-2"></i>
                                Go Back
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.feature-item {
    transition: transform 0.2s ease-in-out;
}

.feature-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.coming-soon-icon {
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
</style>
@endsection
