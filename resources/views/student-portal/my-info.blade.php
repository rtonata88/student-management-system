@extends('layouts.student-portal')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">My Information</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('student-portal.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('student-portal.profile') }}">Profile</a></li>
                        <li class="breadcrumb-item active">My Information</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    @if($student)
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mb-3">Student Information</h4>
                    <div class="table-responsive">
                        <table class="table table-borderless mb-0">
                            <tbody>
                                <tr>
                                    <th scope="row" style="width: 200px;">Full Name</th>
                                    <td>{{ $student->student_names }} {{ $student->surname }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Student Number</th>
                                    <td>{{ $student->student_number }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Initials</th>
                                    <td>{{ $student->initials }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Gender</th>
                                    <td>{{ $student->gender }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Date of Birth</th>
                                    <td>{{ $student->date_of_birth ? \Carbon\Carbon::parse($student->date_of_birth)->format('M d, Y') : 'Not provided' }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">ID Number</th>
                                    <td>{{ $student->id_number ?? 'Not provided' }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Birth Certificate</th>
                                    <td>{{ $student->birth_certificate ?? 'Not provided' }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Center</th>
                                    <td>{{ $student->center->center_name ?? 'Not assigned' }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Contact Email</th>
                                    <td>{{ $student->contact_email }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Contact Number</th>
                                    <td>{{ $student->contact_number }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center">
                    <h4>No Student Record Found</h4>
                    <p class="text-muted">Your student profile is not yet set up. Please contact the administration.</p>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
