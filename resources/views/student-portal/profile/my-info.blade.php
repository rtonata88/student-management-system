@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white;">
                    <h4 class="mb-0"><i class="fas fa-user"></i> My Information</h4>
                    <small>View your personal and academic information</small>
                </div>
                <div class="card-body">
                    @if(!$student)
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i> Your student profile is not complete. Please contact the administration.
                        </div>
                    @else
                        <!-- Personal Information -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6><i class="fas fa-user-circle"></i> Personal Information</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <table class="table table-borderless">
                                            <tr>
                                                <th width="40%">Student Number:</th>
                                                <td>{{ $student->student_number }}</td>
                                            </tr>
                                            <tr>
                                                <th>Full Name:</th>
                                                <td>{{ $student->student_names }} {{ $student->surname }}</td>
                                            </tr>
                                            <tr>
                                                <th>Initials:</th>
                                                <td>{{ $student->initials }}</td>
                                            </tr>
                                            <tr>
                                                <th>Gender:</th>
                                                <td>{{ $student->gender }}</td>
                                            </tr>
                                            <tr>
                                                <th>Date of Birth:</th>
                                                <td>{{ $student->date_of_birth ? \Carbon\Carbon::parse($student->date_of_birth)->format('d M Y') : 'Not provided' }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <table class="table table-borderless">
                                            <tr>
                                                <th width="40%">Email:</th>
                                                <td>{{ $student->contact_email ?: 'Not provided' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Contact Number:</th>
                                                <td>{{ $student->contact_number }}</td>
                                            </tr>
                                            <tr>
                                                <th>ID Number:</th>
                                                <td>{{ $student->id_number ?: 'Not provided' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Birth Certificate:</th>
                                                <td>{{ $student->birth_certificate ?: 'Not provided' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Center:</th>
                                                <td>{{ $student->center->center_name ?? 'Not assigned' }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Guardian Information -->
                        @if($student->guardian_names)
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h6><i class="fas fa-users"></i> Guardian Information</h6>
                                </div>
                                <div class="card-body">
                                    @php
                                        $guardianNames = json_decode($student->guardian_names, true) ?: [];
                                        $guardianSurnames = json_decode($student->guardian_surname, true) ?: [];
                                        $relationships = json_decode($student->relationship, true) ?: [];
                                        $guardianContacts = json_decode($student->guardian_contact_number, true) ?: [];
                                        $guardianEmails = json_decode($student->guardian_contact_email, true) ?: [];
                                    @endphp
                                    
                                    @for($i = 0; $i < count($guardianNames); $i++)
                                        @if(!empty($guardianNames[$i]))
                                            <div class="card mb-3">
                                                <div class="card-header">
                                                    <h6 class="mb-0">{{ $i == 0 ? 'Primary' : 'Secondary' }} Guardian</h6>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <table class="table table-borderless table-sm">
                                                                <tr>
                                                                    <th width="40%">Name:</th>
                                                                    <td>{{ $guardianNames[$i] }} {{ $guardianSurnames[$i] ?? '' }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Relationship:</th>
                                                                    <td>{{ $relationships[$i] ?? 'Not specified' }}</td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <table class="table table-borderless table-sm">
                                                                <tr>
                                                                    <th width="40%">Contact:</th>
                                                                    <td>{{ $guardianContacts[$i] ?? 'Not provided' }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Email:</th>
                                                                    <td>{{ $guardianEmails[$i] ?: 'Not provided' }}</td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endfor
                                </div>
                            </div>
                        @endif

                        <!-- Account Information -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6><i class="fas fa-key"></i> Account Information</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <table class="table table-borderless">
                                            <tr>
                                                <th width="40%">Login Email:</th>
                                                <td>{{ Auth::user()->email }}</td>
                                            </tr>
                                            <tr>
                                                <th>Account Created:</th>
                                                <td>{{ Auth::user()->created_at->format('d M Y H:i') }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <table class="table table-borderless">
                                            <tr>
                                                <th width="40%">User Type:</th>
                                                <td><span class="badge badge-primary">{{ ucfirst(Auth::user()->user_type) }}</span></td>
                                            </tr>
                                            <tr>
                                                <th>Last Updated:</th>
                                                <td>{{ $student->updated_at->format('d M Y H:i') }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Navigation -->
                    <div class="text-center">
                        <a href="{{ route('student-portal.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
