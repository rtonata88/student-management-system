@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">{{ $reportTitle }} Report</h4>
                </div>
                <div class="card-body text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-chart-line fa-5x text-muted"></i>
                    </div>
                    <h2 class="text-muted mb-3">Coming Soon</h2>
                    <p class="lead text-muted mb-4">
                        The {{ $reportTitle }} report is currently under development and will be available soon.
                    </p>
                    <p class="text-muted">
                        Please check back later or contact your system administrator for more information.
                    </p>
                    <div class="mt-4">
                        <a href="javascript:history.back()" class="btn" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                            <i class="fas fa-arrow-left"></i> Go Back
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
