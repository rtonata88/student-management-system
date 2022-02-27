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
            <div class="card-footer">
                <p><strong>Aging Report</strong></p>
                <table class="table table-responsive-sm table-bordered table-sm" style="width:50%;">
                    <tr class="text-center">
                        <th>90+</th>
                        <th>60 Days</th>
                        <th>30 Days</th>
                    </tr>
                    <tr class="text-center" style="border:solid #000 !important; border-width:0 1px 1px 0 !important;">
                        <td style="border:solid #000 !important; border-width:0 1px 1px 0 !important;">{{number_format($aging_report["90"], 2, '.',',')}}</td>
                        <td style="border:solid #000 !important; border-width:0 1px 1px 0 !important;">{{number_format($aging_report["60"], 2, '.',',')}}</td>
                        <td style="border:solid #000 !important; border-width:0 1px 1px 0 !important;">{{number_format($aging_report["30"], 2, '.',',')}}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}
@endsection