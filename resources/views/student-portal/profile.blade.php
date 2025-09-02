@extends('layouts.student-portal')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">My Profile</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('student-portal.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Profile</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    @if($student)
    <div class="row">
        <div class="col-xl-4 col-lg-5">
            <div class="card text-center">
                <div class="card-body">
                    <img src="{{ asset('assets/default-avatar.png') }}" class="rounded-circle avatar-lg img-thumbnail" alt="profile-image">
                    
                    <h4 class="mb-0 mt-2">{{ $student->student_names }} {{ $student->surname }}</h4>
                    <p class="text-muted font-14">Student</p>

                    <button type="button" class="btn btn-success btn-sm mb-2">Follow</button>
                    <button type="button" class="btn btn-danger btn-sm mb-2">Message</button>

                    <div class="text-left mt-3">
                        <h4 class="font-13 text-uppercase">About Me :</h4>
                        <p class="text-muted font-13 mb-3">
                            Student at {{ $student->center->center_name ?? 'Educational Institution' }}
                        </p>
                        <p class="text-muted mb-2 font-13"><strong>Student Number :</strong> <span class="ml-2">{{ $student->student_number }}</span></p>
                        <p class="text-muted mb-2 font-13"><strong>Email :</strong> <span class="ml-2">{{ $student->contact_email }}</span></p>
                        <p class="text-muted mb-1 font-13"><strong>Phone :</strong> <span class="ml-2">{{ $student->contact_number }}</span></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-8 col-lg-7">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-pills bg-nav-pills nav-justified mb-3">
                        <li class="nav-item">
                            <a href="#aboutme" data-toggle="tab" aria-expanded="false" class="nav-link rounded-0 active">
                                About
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#timeline" data-toggle="tab" aria-expanded="true" class="nav-link rounded-0">
                                Timeline
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#settings" data-toggle="tab" aria-expanded="false" class="nav-link rounded-0">
                                Settings
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane show active" id="aboutme">
                            <h5 class="mb-4 text-uppercase"><i class="mdi mdi-briefcase mr-1"></i> Student Information</h5>
                            <div class="table-responsive">
                                <table class="table table-borderless mb-0 text-muted">
                                    <tbody>
                                        <tr>
                                            <th scope="row">Full Name</th>
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

                            @if($student->guardian_names)
                            <h5 class="mb-3 mt-4 text-uppercase"><i class="mdi mdi-account-multiple mr-1"></i> Guardian Information</h5>
                            @php
                                $guardianNames = json_decode($student->guardian_names, true) ?: [];
                                $guardianSurnames = json_decode($student->guardian_surname, true) ?: [];
                                $relationships = json_decode($student->relationship, true) ?: [];
                                $guardianContacts = json_decode($student->guardian_contact_number, true) ?: [];
                                $guardianEmails = json_decode($student->guardian_contact_email, true) ?: [];
                            @endphp
                            
                            @foreach($guardianNames as $index => $guardianName)
                            <div class="card border mb-2">
                                <div class="card-body">
                                    <h6 class="card-title">Guardian {{ $index + 1 }}</h6>
                                    <div class="table-responsive">
                                        <table class="table table-borderless mb-0 text-muted">
                                            <tbody>
                                                <tr>
                                                    <th scope="row">Name</th>
                                                    <td>{{ $guardianName }} {{ $guardianSurnames[$index] ?? '' }}</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Relationship</th>
                                                    <td>{{ $relationships[$index] ?? 'Not specified' }}</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Contact Number</th>
                                                    <td>{{ $guardianContacts[$index] ?? 'Not provided' }}</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Email</th>
                                                    <td>{{ $guardianEmails[$index] ?? 'Not provided' }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @endif
                        </div>

                        <div class="tab-pane" id="timeline">
                            <div class="timeline-alt pb-0">
                                <div class="timeline-item">
                                    <i class="mdi mdi-account-plus bg-info-lighten text-info timeline-icon"></i>
                                    <div class="timeline-item-info">
                                        <h5 class="mt-0 mb-1">Student Registration</h5>
                                        <p class="font-14">Registered as a student in the system <small class="text-muted">{{ $student->created_at->format('M d, Y') }}</small></p>
                                    </div>
                                </div>

                                <div class="timeline-item">
                                    <i class="mdi mdi-book bg-primary-lighten text-primary timeline-icon"></i>
                                    <div class="timeline-item-info">
                                        <h5 class="mt-0 mb-1">Academic Journey</h5>
                                        <p class="font-14">Started academic journey at {{ $student->center->center_name ?? 'the institution' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane" id="settings">
                            <form>
                                <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle mr-1"></i> Personal Info</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="firstname">First Name</label>
                                            <input type="text" class="form-control" id="firstname" value="{{ $student->student_names }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="lastname">Last Name</label>
                                            <input type="text" class="form-control" id="lastname" value="{{ $student->surname }}" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="useremail">Email Address</label>
                                            <input type="email" class="form-control" id="useremail" value="{{ $student->contact_email }}" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="userphone">Phone</label>
                                            <input type="text" class="form-control" id="userphone" value="{{ $student->contact_number }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="studentnumber">Student Number</label>
                                            <input type="text" class="form-control" id="studentnumber" value="{{ $student->student_number }}" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-right">
                                    <button type="button" class="btn btn-success waves-effect waves-light mt-2" disabled>
                                        <i class="mdi mdi-content-save"></i> Contact Admin to Update
                                    </button>
                                </div>
                            </form>
                        </div>
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
