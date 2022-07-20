@extends('layouts.app')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Management</li>
        <li class="breadcrumb-item active"><a href="/enrolment-adjustment">Enrolment Adjustment</a></li>
        <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection
@section('content')
<div class="row">
    @if($student)
    <div class="offset-2 col-md-9">
        <div class="card">
            <div class="card-header">
                <strong>Student information</strong>
            </div>
            <div class="card-body">
                <table class="table table-responsive-sm table-bordered table-striped table-sm" style="width:100%">
                    <thead>
                        <tr>
                            <th>Academic year</th>
                            <th>Student number</th>
                            <th>Student names</th>
                            <th>Surname</th>
                            <th>DOB</th>
                            <th>Registration status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{$academic_year}}</td>
                            <td>{{$student->student_number2}}</td>
                            <td>{{$student->student_names}}</td>
                            <td>{{$student->surname}}</td>
                            <td>{{$student->date_of_birth}}</td>
                            <td>
                                @if($registration_status == 'Registered')
                                <span class="badge badge-success">
                                    {{$registration_status}}
                                </span>
                                @elseif($registration_status == 'Canceled')
                                <span class="badge badge-danger">
                                    {{$registration_status}}
                                </span>
                                @else
                                <span class="badge badge-warning text-white">
                                    Not registered
                                </span>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="offset-2 col-md-9">
        <div class="card">
            <div class="card-header">
                <strong> Academic and Module registrations </strong>
            </div>
            <div class="card-body">
                @if(Session::has('message'))
                <div class="alert alert-warning">
                    {{Session::get('message')}}
                </div>
                @endif
                <div class="form-group">
                    {{Form::label('academic_year', 'Academic Year')}}
                    {{Form::text('academic_year', $academic_year, ['class' => 'form-control', 'readonly', 'required'])}}
                </div>
                <div class="form-group">
                    {{Form::label('center_id', 'Center')}}
                    {{Form::select('center_id', $centers,null, ['class' => 'form-control', 'readonly'])}}
                </div>
                <div class="form-group">
                    <strong><label>Select subjects below: </label></strong>
                    <table class="table table-responsive-sm table-bordered table-striped table-sm" style="width:100%">
                        <thead>
                            <tr>
                                <th>Subject</th>
                                <th>Subject code</th>
                                <th>Registration Date</th>
                                <th>Registration Status</th>
                                <th>Cancellation Date</th>
                                <th>Amount Charged (N$)</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($subjects as $subject)
                            <tr>
                                <td>{{$subject->subject->subject_name}}</td>
                                <td>{{$subject->subject->subject_code}}</td>
                                <td>{{$subject->registration_date}}</td>
                                <td>{{$subject->registration_status}}</td>
                                <td>{{$subject->cancellation_date}}</td>
                                <td>{{$invoice->where('model_id', $subject->module_id)->first()->debit_amount}}</td>
                                <td class=" text-center">
                                    <a href="{{route('enrolment-adjustment.edit', $subject->id)}}">
                                        <svg class="c-icon mr-2">
                                            <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-pencil')}}"></use>
                                        </svg>Edit
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                <a href="/enrolment-adjustment">Cancel</a>
            </div>
        </div>
    </div>
</div>
@endif
</div>
@endsection