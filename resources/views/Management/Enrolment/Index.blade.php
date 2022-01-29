@extends('layouts.app')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Management</li>
        <li class="breadcrumb-item active"><a href="/enrolment">Enrolment </a></li>
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
                {!! Form::open(array('route' => array('enrolment.filter'), 'method' => 'post', 'class'=> 'form-vertical form-material')) !!}
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
                            <td>{{$student->student_number}}</td>
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
{!! Form::open(array('route' => array('enrolment.store'), 'method' => 'post')) !!}
<input type="hidden" name="student_id" value="{{$student->id}}">
<div class="row">
    <div class="offset-3 col-md-9">
        <div class="card">
            <div class="card-header">
                <strong> Academic and Module registrations </strong>
            </div>
            <div class="card-body">
                <div class="form-group">
                    {{Form::label('academic_year', 'Academic Year')}}
                    {{Form::text('academic_year', $academic_year, ['class' => 'form-control', 'readonly', 'required'])}}
                </div>
                <div class="form-group">
                    {{Form::label('center_id', 'Center')}}
                    {{Form::select('center_id', $centers,null, ['class' => 'form-control'])}}
                </div>
                <div class="form-group">
                    <strong><label>Select subjects below: </label></strong>
                    <table class="table table-responsive-sm table-bordered table-striped table-sm" style="width:100%">
                        <thead>
                            <tr>
                                <th>Subject</th>
                                <th>Subject code</th>
                                <th>Amount</th>
                                <th class="text-center">Tick to Enrol</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($subjects as $subject)
                            <tr>
                                <td>{{$subject->subject_name}}</td>
                                <td>{{$subject->subject_code}}</td>
                                <td>{{$subject->subject_fees}}</td>
                                <td class="text-center">
                                    <input type="checkbox" value="{{$subject->id}}" name="subject[]">
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
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
                            <th>Charge Automatically?</th>
                            <th>Amount</th>
                            <th class="text-center">Tick to Charge</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($fees as $fee)
                        <tr>
                            <td>{{$fee->fee_description}}</td>
                            <td>{{$fee->automatic_charge}}</td>
                            <td>{{$fee->amount}}</td>
                            <td class="text-center">
                                @if($fee->automatic_charge == 'Yes')
                                <input type="checkbox" value="{{$fee->id}}" checked="checked" name="other_fees[]" disabled>
                                @else
                                <input type="checkbox" value="{{$fee->id}}" name="other_fees[]">
                                @endif
                                <input type="hidden" name="fee_description[]" value="{{$fee->fee_description}}">

                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-sm btn-success">Confirm enrolment</button>
                <a href="/enrolment">Cancel</a>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}
@endif
</div>
@endsection