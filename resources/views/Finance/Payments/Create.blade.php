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
                            <th>Registration status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{$academic_year->academic_year}}</td>
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
                    <strong>{{Form::label('receipt_number', 'Receipt number')}} <span class="text-danger">*</span></strong>
                    {{Form::text('receipt_number',null, ['class' => 'form-control', 'required'])}}
                </div>

                <div class="form-group">
                    <strong>{{Form::label('payment_date', 'Payment Date')}} <span class="text-danger">*</span></strong>
                    {{Form::date('payment_date',null, ['class' => 'form-control', 'required'])}}
                </div>

                <div class="form-group">
                    <strong>{{Form::label('receipt_amount', 'Receipt amount (N$)')}} <span class="text-danger">*</span></strong>
                    {{Form::number('receipt_amount',null, ['class' => 'form-control', 'required'])}}
                    {{Form::hidden('academic_year',$academic_year->academic_year, ['class' => 'form-control'])}}
                    {{Form::hidden('student_id',$student->id, ['class' => 'form-control'])}}
                    <div class="help-text text-danger d-none" id="error-message"><strong>The receipt amount does not add up to the individual item amounts below.</strong></div>
                </div>

                <div class="form-group">
                    <p><strong>Receipt Breakdown</strong></p>
                    <table class="table table-responsive-sm table-bordered table-striped table-sm" style="width:100%">
                        <thead>
                            <tr>
                                <th>Payment Description</th>
                                <th>Amount due (N$)</th>
                                <th>Status</th>
                                <th>Amount paid + Credits (N$)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Tuition fees</td>
                                <td>
                                    @if($tuition_fees > 0)
                                    {{number_format($tuition_fees, 2, '.',',')}}
                                    @else
                                    0.00
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($tuition_fees > 0)
                                    <span class="badge badge-warning">
                                        Outstanding
                                    </span>
                                    @else
                                    <span class="badge badge-success">
                                        Paid
                                    </span>
                                    @endif
                                </td>
                                <td>
                                    {{Form::number('tuition_fees', ($tuition_fees > 0) ? $tuition_fees : 0, ['class' => 'form-control fees', 'required'])}}
                                </td>
                            </tr>
                            @foreach($extra_fees as $fee)
                            @php
                            $amount_due = ($fee->outstanding - $fee->credit_memos) + $fee->debit_memos
                            @endphp
                            <tr>
                                <td>{{$fee->fee_description}}</td>
                                <td>
                                    @if($amount_due > 0)
                                    {{$amount_due}}
                                    @else
                                    0.00
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($amount_due >= $fee->amount)
                                    <span class="badge badge-danger">
                                        Not paid
                                    </span>
                                    @elseif($amount_due <= 0) <span class="badge badge-success">
                                        Paid
                                        </span>
                                        @else
                                        <span class="badge badge-warning">
                                            Partially paid
                                        </span>
                                        @endif

                                </td>
                                <td>
                                    @if($amount_due <= 0)
                                    {{$fee->credit_memos + $fee->amount_paid}}
                                    @elseif($amount_due <= $fee->amount)
                                        <input type="number" name="other_fee[{{$fee->fee_id}}]" class="form-control input-no-border fees" value="{{$amount_due}}">
                                    @elseif($amount_due <= 0) 
                                    {{$fee->credit_memos + $fee->amount_paid}} 
                                    @endif 
                                    <input type="hidden" name="fee_id[]" class="form-control" value="{{$fee->fee_id}}">
                                    <input type="hidden" name="fee_description[{{$fee->fee_id}}]" value="{{$fee->fee_description}}">
                                </td>
                            </tr>
                            @endforeach
                            <tr>
                                <th colspan="3" class="text-right">TOTAL RECEIPT AMOUNT (N$)</th>
                                <th>
                                    <input type="text" class="form-control input-no-border" id="displayTotalReceiptAmount" value="0" readonly="readonly">
                                </th>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="form-group">
                    {{Form::label('payment_method', 'Payment method')}}
                    {{Form::select('payment_method', ['Cash' => 'Cash', 'Bank Deposit' => 'Bank Deposit', 'EFT' => 'EFT'], null, ['class' => 'form-control', 'required'])}}
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-sm btn-success" id="submit-btn">Submit</button>
                <a href="/payments">Cancel</a>
            </div>
            {!! Form::close() !!}
        </div>
        @endif
    </div>
</div>
@push('payments')
<script src="{{asset('js/payments.js')}}"></script>
@endpush
@endsection