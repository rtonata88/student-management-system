@extends('layouts.student-portal')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Quick Support</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('student-portal.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Quick Support</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mb-3">Get Quick Support</h4>
                    
                    <div class="text-center py-4">
                        <i class="fas fa-headset fa-3x text-muted mb-3"></i>
                        <h5>Quick Support</h5>
                        <p class="text-muted">Get immediate assistance with your questions and technical issues.</p>
                        <div class="mt-4">
                            <p><strong>Contact Information:</strong></p>
                            <p>Phone: +264 81 37 0 37 26</p>
                            <p>Email: info@educims.com</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
