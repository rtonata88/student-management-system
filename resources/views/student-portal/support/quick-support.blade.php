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
                        @if($company && $company->company_name)
                            <div class="mb-4">
                                <h3 style="color: black; font-weight: bold;">{{ $company->company_name }}</h3>
                            </div>
                        @endif
                        @if($company && $company->logo)
                            <div class="mb-3">
                                <img src="{{asset('storage/'.$company->logo)}}" alt="{{ $company->company_name ?? 'Institution' }} Logo" class="img-fluid" style="max-height: 80px;">
                            </div>
                        @else
                            <i class="fas fa-headset fa-3x text-muted mb-3"></i>
                        @endif
                        <h5>Quick Support</h5>
                        <p class="text-muted">Get immediate assistance with your questions and technical issues.</p>
                        <div class="mt-4">
                            <p><strong>Contact Information:</strong></p>
                            <p>Phone: {{ $company->contact_number ?? 'N/A' }}</p>
                            <p>Email: {{ $company->email ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
