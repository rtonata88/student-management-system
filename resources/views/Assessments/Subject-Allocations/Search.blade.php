@extends('layouts.app')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Assessment</li>
        <li class="breadcrumb-item active"><a href="/enrolment">Subject Allocations</a></li>
        <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection
@section('content')
<div class="container-fluid">
    <!-- Search Section -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
            {!! Form::open(array('route' => array('subject-allocations.filter'), 'method' => 'post', 'class'=> 'form-inline')) !!}
            
            <div class="row w-100 align-items-end">
                <div class="col-md-3 mb-3">
                    <label for="name" class="form-label text-muted small font-weight-bold mb-2 d-block">
                        NAME:
                    </label>
                    {{Form::text('name', null, [
                        'class' => 'form-control', 
                        'placeholder' => 'Enter name here...',
                        'id' => 'name'
                    ])}}
                </div>
                
                <div class="col-md-1 mb-3 d-flex align-items-end justify-content-center">
                    <div style="padding-bottom: 8px;">
                        <span class="badge badge-secondary px-2 py-1">OR</span>
                    </div>
                </div>
                
                <div class="col-md-3 mb-3">
                    <label for="username" class="form-label text-muted small font-weight-bold mb-2 d-block">
                        USERNAME:
                    </label>
                    {{Form::text('username', null, [
                        'class' => 'form-control', 
                        'placeholder' => 'Enter username here...',
                        'id' => 'username'
                    ])}}
                </div>
                
                <div class="col-md-1 mb-3 d-flex align-items-end justify-content-center">
                    <div style="padding-bottom: 8px;">
                        <span class="badge badge-secondary px-2 py-1">OR</span>
                    </div>
                </div>
                
                <div class="col-md-2 mb-3">
                    <label for="email" class="form-label text-muted small font-weight-bold mb-2 d-block">
                        EMAIL:
                    </label>
                    {{Form::email('email', null, [
                        'class' => 'form-control', 
                        'placeholder' => 'Enter email here...',
                        'id' => 'email'
                    ])}}
                </div>
                
                <div class="col-md-2 mb-3">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary px-3">
                            Search
                        </button>
                        <button type="button" class="btn btn-outline-secondary" onclick="clearForm()">
                            Clear
                        </button>
                    </div>
                </div>
            </div>
            
            {!! Form::close() !!}
        </div>
    </div>

    <!-- Results Section -->
    <div class="row">
        <div class="col-12">
        @if (Session::has('error'))
        <div class="alert alert-danger">
            {{Session::get('error')}}
        </div>
        @endif
        @if(isset($students))
        <div class="card">
            <div class="card-header">
                <strong>Select student</strong>
            </div>
            <div class="card-body">
                <table class="table table-responsive-sm table-bordered table-striped table-hover table-sm" style="width:100%">
                    <thead>
                        <tr>
                            <th>Student number</th>
                            <th>Student names</th>
                            <th>Surname</th>
                            <th>DOB</th>
                            <th>Registration status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $student)
                        <tr style="cursor: pointer" onclick="window.location='{{route('enrolment.showEnrollmentScreen', $student->id)}}'">
                            <td>{{$student->student_number2}}</td>
                            <td>{{$student->student_names}}</td>
                            <td>{{$student->surname}}</td>
                            <td>{{$student->date_of_birth}}</td>
                            <td>
                                @if($student->currentRegistration->registration_status == 'Registered')
                                <span class="badge badge-success">
                                    {{$student->currentRegistration->registration_status}}
                                </span>
                                @elseif($registration_status == 'Canceled')
                                <span class="badge badge-danger">
                                    {{$student->currentRegistration->registration_status}}
                                </span>
                                @else
                                <span class="badge badge-warning text-white">
                                    Not registered
                                </span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>
</div>
</div>
@endsection

<script>
function clearForm() {
    document.getElementById('name').value = '';
    document.getElementById('username').value = '';
    document.getElementById('email').value = '';
    
    // Also clear any search results if they exist
    const resultsSection = document.querySelector('.col-12 .card');
    if (resultsSection) {
        resultsSection.style.display = 'none';
    }
    
    // Remove any error messages
    const alertDanger = document.querySelector('.alert-danger');
    if (alertDanger) {
        alertDanger.style.display = 'none';
    }
}
</script>
@endsection