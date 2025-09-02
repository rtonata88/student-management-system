@extends('layouts.student-portal')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Library Fines</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('student-portal.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Library Fines</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mb-3">Outstanding Fines</h4>
                    
                    <div class="text-center py-4">
                        <i class="fas fa-exclamation-triangle fa-3x text-muted mb-3"></i>
                        <h5>No Outstanding Fines</h5>
                        <p class="text-muted">Your library fine details will appear here if any.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
