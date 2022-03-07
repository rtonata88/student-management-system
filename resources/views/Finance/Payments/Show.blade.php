@extends('layouts.app')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Finance</li>
        <li class="breadcrumb-item"><a href="/payments">Payments</a></li>
        <li class="breadcrumb-item active">{{$student->student_names}} {{$student->surname}}</li>
        <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-3 col-xs-12">
        <div class="card">
            <div class="card-header">
                <strong>Quick actions</strong>
            </div>
            <div class="card-body">
                <ul>
                    <li><a href="{{route('invoices.print', $student->id)}}" target="_blank">Print Invoice</a></li>
                    <li><a href="{{route('payments.index')}}">Search another student</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="col-md-9 col-xs-12">
        <div class="row">
            <div class="col-md-6 col-xs-12">
                <div class="card">
                    <div class="card-header">
                        <strong>Student information</strong>
                    </div>
                    <div class="card-body">
                        <table class="table table-responsive-sm table-bordered table-striped table-sm" style="width:100%">
                            <tbody>
                                <tr>
                                    <th>Student number</th>
                                    <td>{{$student->student_number2}}</td>
                                </tr>
                                <tr>
                                    <th>Academic year</th>
                                    <td>{{$academic_year->academic_year}}</td>
                                </tr>
                                <tr>
                                    <th>Student names</th>
                                    <td>{{$student->student_names}} {{$student->surname}}</td>
                                </tr>
                                <tr>
                                    <th>Registration status</th>
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
            <div class="col-md-6 col-xs-12">
                <div class="card">
                    <div class="card-header">
                        <strong>Account summary information</strong>
                    </div>
                    <div class="card-body">
                        <table class="table table-responsive-sm table-bordered table-striped table-sm" style="width:100%">
                            <tbody>
                                <tr>
                                    <th>Total Payable</th>
                                    <td>N${{number_format($payable_amount,2, '.',',')}}</td>
                                </tr>
                                <tr>
                                    <th>Tuition Fees</th>
                                    <td>N${{number_format($tuition_fees,2, '.',',')}}</td>
                                </tr>
                                <tr>
                                    <th>Other Fees</th>
                                    <td>N${{number_format($other_fees,2, '.',',')}}</td>
                                </tr>
                                <tr>
                                    <th>Course Balance</th>
                                    <td>N${{number_format($balance,2, '.',',')}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                @permission('add-payment')
                <div class="float-left">
                    <a href="{{route('payments.edit', $student->id)}}" class="btn btn-primary pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light"><span class="fa fa-plus"></span> ADD PAYMENT</a>
                </div>
                @endpermission
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
                        <th>Receipt Number</th>
                        <th>Payment Date</th>
                        <th>Method</th>
                        <th>Received by</th>
                        <th>Amount</th>
                    </tr>
                    @forelse($payments as $payment)
                    <tr>
                        <td>{{$payment->receipt_number}}</td>
                        <td>{{$payment->payment_date}}</td>
                        <td>{{$payment->payment_method}}</td>
                        <td>{{$payment->user->name}}</td>
                        <td>{{$payment->payment_amount}}</td>
                    </tr>
                    @empty
                    <p class="text-info"><strong>No payment information found for this student.</strong></p>
                    @endforelse
                    @if(count($payments) > 0)
                    <tr>
                        <th colspan="4" class="text-right">Total</th>
                        <th>{{number_format($payments->sum('payment_amount'), 2, '.',',')}}</th>
                    </tr>
                    @endif
                </table>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}
@endsection