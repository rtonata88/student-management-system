@extends('layouts.app')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Management</li>
        <li class="breadcrumb-item active"><a href="/enrolment">Cancel Enrolment </a></li>
        <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection
@section('content')
<div class="row">
    <div class="col-md-3 col-xs-12">
        <div class="card">
            <div class="card-header">
                <strong>Search</strong>
            </div>
            <div class="card-body">
                {!! Form::open(array('route' => array('cancel-registration.filter'), 'method' => 'post', 'class'=> 'form-vertical form-material')) !!}
                <div class="form-group">
                    {{Form::number('student_number', null, ['class' => 'form-control form-control-sm', 'placeholder' => 'Student number'])}}
                </div>
                <button type="submit" class="btn btn-sm btn-success">
                    Search
                </button>
                <a href="/students" class="btn btn-sm">
                    Clear
                </a>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    @if($student)
    <div class="col-md-9">
        <div class="card">
            <div class="card-header">
                <strong> Student information </strong>
            </div>
            <div class="card-body">
                <table class="table-sm" style="width:100%">
                    <tr>
                        <th style="width: 150px">Student number </th>
                        <td>{{$student->student_number}}</td>
                    </tr>
                    <tr>
                        <th style="width: 150px">Student names </th>
                        <td>{{$student->student_names}}</td>
                    </tr>
                    <tr>
                        <th style="width: 150px">Surname </th>
                        <td>{{$student->surname}}</td>
                    </tr>
                    <tr>
                        <th style="width: 100px">Date of Birth</th>
                        <td>{{$student->date_of_birth}}</td>
                    </tr>
                </table>
                <hr>
                <div class="form-group">
                    <strong><label>Select subjects below: </label></strong>
                    <table class="table table-responsive-sm table-bordered table-striped table-sm" style="width:100%">
                        <thead>
                            <tr>
                                <th>Subject</th>
                                <th>Subject code</th>
                                <th>Amount</th>
                                <th class="text-center">Tick to Cancel</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($student->registered_modules as $registered_module)
                            <tr>
                                <td>{{$registered_module->subject->subject_name}}</td>
                                <td>{{$registered_module->subject->subject_code}}</td>
                                <td>{{$registered_module->subject->subject_fees}}</td>
                                <td class="text-center">
                                    @if($registered_module->registration_status == 'Registered')
                                    <input type="checkbox" value="{{$registered_module->module_id}}" name="subject[]">
                                    @else
                                    <a href="#" class="btn btn-success btn-sm text-white">Remove Cancellation</a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="form-group">
                    {{Form::label('cancelation_reason', 'Cancellation reason')}}
                    {{Form::textarea('cancelation_reason', null, ['class' => 'form-control', 'required', 'placeholder' => 'Please type a cancelation reason here'])}}
                </div>
            </div>
        </div>
    </div>
</div>
{!! Form::open(array('route' => array('cancel-registration.store'), 'method' => 'post')) !!}
<input type="hidden" name="student_id" value="{{$student->id}}">
<div class="row">
    <div class="offset-3 col-md-9">

    </div>

    <div class="offset-3 col-md-9">
        <div class="card">
            <div class="card-header">
                <strong>Other charges</strong>
            </div>
            <div class="card-body">
                <table class="table table-responsive-sm table-bordered table-striped table-sm" style="width:100%">
                    <thead>
                        <tr>
                            <th>Fee desscription</th>
                            <th>Amount</th>
                            <th class="text-center">Tick to Cancel</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($charged_fees as $fee)
                        <tr>
                            <td>{{$fee->line_description}}</td>
                            <td>{{$fee->debit_amount}}</td>
                            <td class="text-center">
                                <input type="checkbox" value="{{$fee->model_id}}" name="other_fees[]">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-sm btn-success">Confirm cancellation</button>
                <a href="/cancel-registration">Cancel</a>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}
@endif
</div>
@endsection