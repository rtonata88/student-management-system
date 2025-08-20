@extends('layouts.app')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Management</li>
        <li class="breadcrumb-item active"><a href="/payments">Payments </a></li>
        <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection
@section('content')
<div class="container-fluid">
    <!-- Search Section -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
            {!! Form::open(array('route' => array('payments.filter'), 'method' => 'post', 'class'=> 'form-inline')) !!}
            
            <div class="row w-100 align-items-end">
                <div class="col-md-4 mb-3">
                    <label for="student_number" class="form-label text-muted small font-weight-bold mb-2 d-block">
                        STUDENT NUMBER:
                    </label>
                    {{Form::text('student_number', null, [
                        'class' => 'form-control', 
                        'placeholder' => 'Enter student number here...',
                        'id' => 'student_number'
                    ])}}
                </div>
                
                <div class="col-md-1 mb-3 d-flex align-items-end justify-content-center">
                    <div style="padding-bottom: 8px;">
                        <span class="badge badge-secondary px-3 py-2">OR</span>
                    </div>
                </div>
                
                <div class="col-md-3 mb-3">
                    <label for="names" class="form-label text-muted small font-weight-bold mb-2 d-block">
                        STUDENT NAMES:
                    </label>
                    {{Form::text('names', null, [
                        'class' => 'form-control', 
                        'placeholder' => 'Enter student names here...',
                        'id' => 'names'
                    ])}}
                </div>
                
                <div class="col-md-4 mb-3">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary px-4">
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
        @if(Session::has('message'))
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            {{ Session::get('message') }}
        </div>
        @endif
        @if(isset($students))
        <div class="card">
            <div class="card-header">
                <strong> Select student </strong>
            </div>
            <div class="card-body">
                <table class="table table-responsive-sm table-bordered table-striped table-hover table-sm" style="width:100%">
                    <thead>
                        <tr>
                            <th>Student number</th>
                            <th>Student names</th>
                            <th>Surname</th>
                            <th>DOB</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $student)
                        <tr style="cursor: pointer" onclick="window.location='{{route('payments.edit', $student->id)}}'">
                            <td>{{$student->student_number2}}</td>
                            <td>{{$student->student_names}}</td>
                            <td>{{$student->surname}}</td>
                            <td>{{$student->date_of_birth}}</td>
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

<script>
function clearForm() {
    document.getElementById('student_number').value = '';
    document.getElementById('names').value = '';
    
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