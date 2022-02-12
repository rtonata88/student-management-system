@extends('layouts.app')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Management</li>
        <li class="breadcrumb-item"><a href="/students">Enrolment Confirmation</a></li>
        <li class="breadcrumb-item active">{{$student->student_names}} {{$student->surname}}</li>
        <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-9 col-xs-12">
        <div class="card">
            <div class="card-header">
                <strong>Enrolment confirmation</strong> | <a href="{{route('enrolment.index', $student->id)}}">Back</a> | <a href="{{route('enrolment.index', $student->id)}}">Print</a>
            </div>
            <div class="card-body">
                <table class="table-sm" style="width:100%">
                    <tr>
                        <th style="width: 150px">Student number </th>
                        <td>{{$student->student_number2}}</td>
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

                <table class="table table-responsive-sm table-bordered table-sm" style="width:100%">
                    <tr>
                        <th>Date</th>
                        <th>Description</th>
                        <th>Amount</th>
                        <th>Total</th>
                    </tr>
                    @foreach($enrolment as $enrolment)
                    <tr>
                        <td>{{$enrolment->registration_date}}</td>
                        <td>{{$enrolment->subject->subject_name}}</td>
                        <td>9</td>
                        <td>{{$enrolment->subject->subject_fees}}</td>
                        <td>{{$enrolment->subject->subject_fees * 9}}</td>
                    </tr>
                    @endforeach
                    @foreach($extra_fees as $extra_fee)
                    <tr>
                        <td>{{$extra_fee->transaction_date}}</td>
                        <td>{{$extra_fee->fee_description}}</td>
                        <td>9</td>
                        <td>{{$extra_fee->amount}}</td>
                        <td>{{$extra_fee->amount * 9}}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <th colspan="3">TOTAL</th>
                        <th>
                            {{$total }}
                        </th>
                        <th>
                            {{$total * 9}}
                        </th>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}
@endsection