@extends('layouts.app')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Finance</li>
        <li class="breadcrumb-item active"><a href="/payments">Payments</a></li>
        <li class="breadcrumb-item">Capture new</li>
        <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection
@section('content')
<div class="row">

    <div class="offset-2 col-md-9 col-sm-12">
        @if(Session::has('message'))
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            {{ Session::get('message') }}
        </div>
        @endif

        @if($student)
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
                            <th>Balance</th>
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
                            <td>{{number_format($balance, 2, '.',',')}}</td>
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

        <div class="card">
            <div class="card-header">
                <strong>Payment information form</strong>
            </div>
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            {!! Form::open(array('route' => array('payments.store'), 'method' => 'post')) !!}
            <div class="card-body">
                @if(Session::has('error_message'))
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    {{ Session::get('error_message') }}
                </div>
                @endif
                <div class="form-group">
                    {{Form::label('payment_amount', 'Amount')}}
                    {{Form::text('payment_amount',null, ['class' => 'form-control', 'required'])}}
                    {{Form::hidden('academic_year',$academic_year, ['class' => 'form-control'])}}
                    {{Form::hidden('student_id',$student->id, ['class' => 'form-control'])}}
                </div>

                <div class="form-group">
                    {{Form::label('payment_method', 'Payment method')}}
                    {{Form::select('payment_method', ['Cash' => 'Cash', 'Bank Deposit' => 'Bank Deposit', 'EFT' => 'EFT'], null, ['class' => 'form-control', 'required'])}}
                </div>

                <div class="form-group">
                    {{Form::label('document_type', 'Document Type')}}
                    {{Form::select('document_type', ['Payment' => 'Payment', 'Credit Memo' => 'Credit Memo'], null, ['class' => 'form-control', 'required'])}}
                    <span class="help text-info">
                        Please select Credit Memo if you are recording an amount that must be credited onto the student's account which is not a payment.
                    </span>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-sm btn-success">Submit</button>
                <a href="/payments">Cancel</a>
            </div>
            {!! Form::close() !!}
        </div>
        @endif
    </div>
</div>
@endsection