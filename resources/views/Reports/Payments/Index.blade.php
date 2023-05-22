@extends('layouts.app')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Reports</li>
        <li class="breadcrumb-item active">Payments </li>
        <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection
@section('content')
<div class="row">
    <div class="col-md-3 col-xs-12">
        <div class="card">
            <div class="card-header">
                <strong>Report filter</strong>
            </div>
            <div class="card-body">
                {!! Form::open(array('route' => array('reports.payments.search'), 'method' => 'post', 'class'=> 'form-vertical form-material')) !!}
                <div class="form-group">
                    <label class="text-right control-label col-form-label">From date</label>
                    {{Form::date('date_from', date('Y-m-d'), ['class' => 'form-control form-control-sm', 'required'])}}
                </div>

                <div class="form-group">
                    <label class="text-right control-label col-form-label">To date</label>
                    {{Form::date('date_to', date('Y-m-d'), ['class' => 'form-control form-control-sm', 'required'])}}
                </div>

                <div class="form-group">
                    <label class="text-right control-label col-form-label">Receipt number</label>
                    {{Form::text('receipt_number', null, ['class' => 'form-control form-control-sm','placeholder'=>"Enter receipt number"])}}
                </div>

                <div class="form-group">
                    <label class="text-right control-label col-form-label">Student number</label>
                    {{Form::text('student_number', null, ['class' => 'form-control form-control-sm','placeholder'=>"Enter student number"])}}
                </div>
                <hr>
                <div class="form-actions">
                    <button type="submit" class="btn btn-success btn-sm">Search</button>
                    <a href="{{route('reports.payments.index')}}" class="btn btn-sm">Clear</a>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <div class="col-md-9 col-xs-12">
        <div class="card">
            <div class="card-header">
                <strong>Report results</strong>
            </div>
            <div class="card-body">
                
                @if($payments)
                <a href="{{route('reports.payments.export')}}">Export to excel</a>
                <table class="table table-responsive-sm table-bordered table-striped table-sm" style="width:100%; font-size: 12px">
                    <thead>
                        <tr>
                            <th>Receipt number</th>
                            <th>Student number</th>
                            <th>Student name</th>
                            <th>Transaction date</th>
                            <th>Description</th>
                            <th>Captured By</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th colspan="6">TOTAL</th>
                            <th>{{number_format($payments->sum('credit_amount'), 2, '.',',')}}</th>
                        </tr>
                        @foreach($payments->take(10) as $payment)
                        <tr>
                            <td>{{$payment->reference_number}}</td>
                            <td>{{$payment->student->student_number2}}</td>
                            <td>{{$payment->student->student_names}} {{$payment->student->surname}}</td>
                            <td>{{$payment->transaction_date}}</td>
                            <td>{{$payment->line_description}}</td>
                            <td>
                                @if($payment->capturedBy)
                                {{$users->where('id', $payment->capturedBy->received_by)->first()->name}}
                                @endif
                            </td>
                            <td>{{number_format($payment->credit_amount, 2, '.',',')}}</td>
                        </tr>
                        @endforeach
                        <tr>
                            <th colspan="6">TOTAL</th>
                            <th>{{number_format($payments->sum('credit_amount'), 2, '.',',')}}</th>
                        </tr>
                    </tbody>
                </table>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection