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
{!! Form::open(array('route' => array('enrolment.store'), 'method' => 'post')) !!}
<input type="hidden" name="student_id" value="{{$student->id}}">
<div class="row">
    <div class="offset-2 col-md-9">
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
                                <th>Symbol</th>
                                <th>System</th>
                                <th class="text-center">Tick to Enrol</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($subjects as $subject)
                            <tr>
                                <td>{{$subject->subject_name}}</td>
                                <td>{{$subject->subject_code}}</td>
                                <td>{{$subject->subject_fees}}</td>
                                <td><input type="text" name="subject_symbol[{{$subject->id}}]" class="form-control form-control-sm input-no-border" value="{{$symbols->where('module_id', $subject->id)->first()->subject_symbol ?? ''}}" placeholder="Subject symbol" /></td>
                                <td>
                                    <select class="form-control select form-control-sm input-no-border" name="system[{{$subject->id}}]">
                                        <option>Select</option>
                                        @foreach($education_system as $system)
                                        <option value="{{$system->value}}" @if($symbols->where('module_id', $subject->id)->first()->system ?? '' == $system->value) {{'selected'}} @endif>{{$system->label}} {{$symbols->where('module_id', $subject->id)->first()->system ?? ''}}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class=" text-center">

                                    @if(in_array($subject->id, $registered_modules))
                                    <input type="checkbox" value="{{$subject->id}}" name="subject[]" checked="checked" disabled>
                                    @else
                                    <input type="checkbox" value="{{$subject->id}}" name="subject[]">
                                    @endif
                                    <input type="hidden" value="{{$subject->subject_fees}}" name="subject_fee[]">
                                    <input type="hidden" value="{{$subject->subject_name}}" name="subject_name[]">
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="offset-2 col-md-9">
        <div class="card">
            <div class="card-header">
                <strong>Other charges</strong>
            </div>
            <div class="card-body">
                <table class="table table-responsive-sm table-bordered table-striped table-sm" style="width:100%">
                    <thead>
                        <tr>
                            <th>Fee desscription</th>
                            <th>Mandatory fee</th>
                            <th>Charge type</th>
                            <th>Amount</th>
                            <th class="text-center">Tick to Charge</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($fees as $fee)
                        <tr>
                            <td>{{$fee->fee_description}}</td>
                            <td>{{$fee->automatic_charge}}</td>
                            <td>{{$fee->charge_type}}</td>
                            <td>{{$fee->amount}}</td>
                            <td class="text-center">
                                @if(($fee->automatic_charge == 'Yes') || (in_array($fee->id, $charged_fees)))
                                <input type="checkbox" value="{{$fee->id}}" checked="checked" name="other_fees[]" disabled>
                                @else

                                <input type="checkbox" value="{{$fee->id}}" name="other_fees[]">
                                @endif
                                <input type="hidden" name="fee_description[]" value="{{$fee->fee_description}}">
                                <input type="hidden" name="charge_type[]" value="{{$fee->charge_type}}">
                                <input type="hidden" name="fee_amount[]" value="{{$fee->amount}}">
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