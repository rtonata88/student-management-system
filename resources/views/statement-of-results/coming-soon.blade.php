@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0" style="border-radius: 15px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <div class="card-header text-center" style="background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px); border-radius: 15px 15px 0 0; border: none;">
                    <h3 class="mb-0 text-white">
                        <i class="fas fa-file-alt mr-2"></i>
                        Statement of Results
                    </h3>
                </div>
                <div class="card-body text-center p-5">
                    <div class="mb-4">
                        <i class="fas fa-tools" style="font-size: 4rem; color: rgba(255, 255, 255, 0.8);"></i>
                    </div>
                    <h2 class="text-white mb-3">Under Development</h2>
                    <h4 class="text-white mb-4" style="opacity: 0.9;">Coming Soon</h4>
                    <p class="text-white mb-4" style="font-size: 1.1rem; opacity: 0.8;">
                        We're working hard to bring you the Statement of Results feature. 
                        This powerful tool will allow you to generate comprehensive academic result statements for students.
                    </p>
                    <div class="row mt-4">
                        <div class="col-md-4 mb-3">
                            <div class="p-3" style="background: rgba(255, 255, 255, 0.1); border-radius: 10px;">
                                <i class="fas fa-chart-line mb-2 text-white" style="font-size: 2rem;"></i>
                                <h6 class="text-white">Academic Performance</h6>
                                <small class="text-white" style="opacity: 0.7;">Comprehensive grade analysis</small>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="p-3" style="background: rgba(255, 255, 255, 0.1); border-radius: 10px;">
                                <i class="fas fa-certificate mb-2 text-white" style="font-size: 2rem;"></i>
                                <h6 class="text-white">Official Documents</h6>
                                <small class="text-white" style="opacity: 0.7;">Professional result statements</small>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="p-3" style="background: rgba(255, 255, 255, 0.1); border-radius: 10px;">
                                <i class="fas fa-download mb-2 text-white" style="font-size: 2rem;"></i>
                                <h6 class="text-white">Export Options</h6>
                                <small class="text-white" style="opacity: 0.7;">PDF and print formats</small>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('welcome') }}" class="btn btn-lg" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.75rem 2rem;">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Back to Welcome Page
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    transition: transform 0.3s ease;
}

.card:hover {
    transform: translateY(-5px);
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}
</style>
@endsection
