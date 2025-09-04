@extends('layouts.app')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Access Management</li>
        <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Users</a></li>
        <li class="breadcrumb-item"><a href="{{ route('users.reset-students') }}">Reset Students</a></li>
        <li class="breadcrumb-item">Reset Password</li>
        <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-key"></i> Reset Password for {{ $user->name }}</h5>
                <a href="{{ route('users.reset-students') }}" class="btn" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                    <i class="fas fa-arrow-left"></i> Back to Students
                </a>
            </div>
            <div class="card-body">
                @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle"></i> <strong>Please fix the following errors:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif

                <!-- Student Info Card -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card bg-light">
                            <div class="card-body py-3">
                                <div class="row align-items-center">
                                    <div class="col-md-2 text-center">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto" 
                                             style="width: 60px; height: 60px; background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; font-weight: bold; font-size: 24px;">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                    </div>
                                    <div class="col-md-10">
                                        <h6 class="mb-1"><strong>{{ $user->name }}</strong></h6>
                                        <p class="mb-1"><i class="fas fa-user text-muted"></i> Username: <span class="badge badge-light">{{ $user->username }}</span></p>
                                        <p class="mb-1"><i class="fas fa-envelope text-muted"></i> Email: {{ $user->email }}</p>
                                        <p class="mb-0"><i class="fas fa-graduation-cap text-muted"></i> User Type: <span class="badge badge-info">Student</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Password Reset Form -->
                <form method="POST" action="{{ route('users.update-student-password', $user->username) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password"><i class="fas fa-lock"></i> New Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                       id="password" name="password" required>
                                <small class="form-text text-muted">
                                    Password must contain at least 6 characters with uppercase, lowercase, number and special character.
                                </small>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password_confirmation"><i class="fas fa-lock"></i> Confirm New Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" 
                                       id="password_confirmation" name="password_confirmation" required>
                                <small class="form-text text-muted">
                                    Re-enter the new password to confirm.
                                </small>
                                @error('password_confirmation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Password Requirements Info -->
                    <div class="alert alert-info" role="alert">
                        <i class="fas fa-info-circle"></i> <strong>Password Requirements:</strong>
                        <ul class="mb-0 mt-2">
                            <li>Minimum 6 characters long</li>
                            <li>At least one uppercase letter (A-Z)</li>
                            <li>At least one lowercase letter (a-z)</li>
                            <li>At least one number (0-9)</li>
                            <li>At least one special character (#?!@$%^&*-)</li>
                        </ul>
                    </div>

                    <div class="form-group text-center mt-4">
                        <button type="submit" class="btn me-3" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 1.5rem; margin-right: 8px;">
                            <i class="fas fa-save"></i> Reset Password
                        </button>
                        <a href="{{ route('users.reset-students') }}" class="btn btn-outline-secondary" style="border-radius: 6px; padding: 0.375rem 1.5rem;">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Password strength indicator
document.addEventListener('DOMContentLoaded', function() {
    const passwordInput = document.getElementById('password');
    const confirmInput = document.getElementById('password_confirmation');
    
    // Real-time password confirmation check
    confirmInput.addEventListener('input', function() {
        if (passwordInput.value !== confirmInput.value) {
            confirmInput.setCustomValidity('Passwords do not match');
        } else {
            confirmInput.setCustomValidity('');
        }
    });
    
    passwordInput.addEventListener('input', function() {
        if (passwordInput.value !== confirmInput.value) {
            confirmInput.setCustomValidity('Passwords do not match');
        } else {
            confirmInput.setCustomValidity('');
        }
    });
});
</script>
@endsection
