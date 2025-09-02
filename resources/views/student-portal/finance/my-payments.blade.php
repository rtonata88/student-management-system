@extends('layouts.student-portal')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">My Payments</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('student-portal.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">My Payments</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mb-3">Payment History</h4>
                    
                    <div class="text-center py-4">
                        <i class="fas fa-credit-card fa-3x text-muted mb-3"></i>
                        <h5>No Payment Records</h5>
                        <p class="text-muted">Your payment history will appear here once payments are made.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
