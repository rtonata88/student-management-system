@extends('layouts.app')

@section('breadcrumb')
<div class="c-subheader px-3">
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Assessments</li>
        <li class="breadcrumb-item"><a href="{{ route('my-modules.index') }}">My Modules</a></li>
        <li class="breadcrumb-item active">Class List</li>
    </ol>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-users"></i> Class List - {{ $allocation->module->subject_name }}
                </h5>
                <small class="text-muted">
                    {{ $allocation->academicYear->academic_year }} | {{ $allocation->center->center_name }}
                </small>
            </div>
            <div class="card-body">
                <!-- Module Information -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6 class="mb-2"><i class="fas fa-book"></i> Module Information</h6>
                                        <p class="mb-1"><strong>Module:</strong> {{ $allocation->module->subject_name }}</p>
                                        <p class="mb-1"><strong>Code:</strong> {{ $allocation->module->subject_code }}</p>
                                        <p class="mb-0"><strong>Academic Year:</strong> {{ $allocation->academicYear->academic_year }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="mb-1"><strong>Campus:</strong> {{ $allocation->center->center_name }}</p>
                                        <p class="mb-1"><strong>Students Enrolled:</strong> {{ $students->count() }}</p>
                                        <p class="mb-0"><strong>Lecturer:</strong> {{ auth()->user()->name }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Students Table -->
                @if($students->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                            <tr>
                                <th>#</th>
                                <th>Student Number</th>
                                <th>Names</th>
                                <th>Surname</th>
                                <th>Email</th>
                                <th>Mobile</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($students as $index => $student)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td><strong>{{ $student->student_number }}</strong></td>
                                <td>{{ $student->student_names }}</td>
                                <td>{{ $student->surname }}</td>
                                <td>{{ $student->email_address }}</td>
                                <td>{{ $student->mobile_number }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="alert alert-warning text-center">
                    <i class="fas fa-exclamation-triangle"></i>
                    <h5>No Students Enrolled</h5>
                    <p class="mb-0">There are currently no students enrolled in this module for the {{ $allocation->academicYear->academic_year }} academic year.</p>
                </div>
                @endif

                <!-- Back Button -->
                <div class="mt-4">
                    <a href="{{ route('my-modules.index') }}" class="btn btn-lg" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none;">
                        <i class="fas fa-arrow-left"></i> Back to My Modules
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
