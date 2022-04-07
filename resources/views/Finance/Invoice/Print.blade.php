@extends('layouts.print')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Finance</li>
        <li class="breadcrumb-item"><a href="/invoices">Invoices</a></li>
        <li class="breadcrumb-item active">{{$student->student_names}} {{$student->surname}}</li>
        <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 col-xs-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <table style="width: 100%;">
                        <tr>
                            <td>
                                <h3>{{$company->company_name}}</h3><br>
                                {{$company->address1}} <br>
                                {{$company->address2}} <br>
                                {{$company->address3}} <br>
                                {{$company->address4}} <br>
                                <strong>C: </strong> {{$company->contact_number}} <br>
                                <strong>F: </strong>{{$company->fax}} <br>
                                <strong>E: </strong>{{$company->email}} <br>
                            </td>
                            <td width="200px; margin-right:20px;">
                                <img src="{{asset('assets/Logo.png')}}" class="img-fluid" />
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
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
                            <tr>
                                <th style="width: 100px">Center</th>
                                <td>{{$student_center->center_name}}</td>
                            </tr>

                        </table>
                    </div>

                    <div class="col-md-6">
                        <strong>Account Summary: </strong>
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
                                    <td>N${{number_format($course_balance,2, '.',',')}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <hr>
                <table class="table table-responsive-sm table-bordered table-sm" style="width:100%">
                    <tr>
                        <th>Date</th>
                        <th>Description</th>
                        <th>Debit</th>
                        <th>Credit</th>
                        <th>Balance</th>
                    </tr>
                    @foreach($invoices as $invoice)
                    <?php
                    $balance = ($invoice->debit_amount > 0) ? $balance += $invoice->debit_amount : $balance -= $invoice->credit_amount
                    ?>
                    <tr>
                        <td>{{$invoice->transaction_date}}</td>
                        <td>{{$invoice->line_description}}</td>
                        <td>{{number_format($invoice->debit_amount, 2, '.',',')}}</td>
                        <td>{{number_format($invoice->credit_amount, 2, '.',',')}}</td>
                        <td>{{number_format($balance, 2, '.',',')}}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <th colspan="4" class="text-right">
                            @if($balance >= 0)
                            You are owing
                            @else
                            We owe you
                            @endif
                        </th>
                        <th>
                            {{number_format($balance, 2, '.',',')}}
                        </th>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}
@endsection