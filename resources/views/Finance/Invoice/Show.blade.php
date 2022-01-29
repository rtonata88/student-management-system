@extends('layouts.app')
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
    <div class="col-md-9 col-xs-12">
        <div class="card">
            <div class="card-header">
                <strong>Invoice</strong> | <a href="{{route('invoice.index')}}">Back</a> | <a href="/">Print</a>
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
                    $balance = ($invoice->debit > 0) ? $balance += $invoice->debit : $balance -= $invoice->credit
                    ?>
                    <tr>
                        <td>{{$invoice->transaction_date}}</td>
                        <td>{{$invoice->line_description}}</td>
                        <td>{{$invoice->debit}}</td>
                        <td>{{$invoice->credit}}</td>
                        <td>{{$balance}}</td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}
@endsection