@extends('layouts.app')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Reports</li>
        <li class="breadcrumb-item active">Accounting </li>
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
                {!! Form::open(array('route' => array('reports.finance.search'), 'method' => 'post', 'class'=> 'form-vertical form-material')) !!}
                <div class="form-group">
                    <label class="text-right control-label col-form-label">Financial year</label>
                    {{Form::select('financial_year', $academic_years, date('Y'), ['class' => 'form-control form-control-sm select', 'placeholder'=>"All years"])}}
                </div>

                <div class="form-group">
                    <label class="text-right control-label col-form-label">Fee type</label>
                    {{Form::select('fee_type', ['Subject' => 'Subject fees', 'Other' => 'Other fees'], null, ['class' => 'form-control form-control-sm select','placeholder'=>"All fees"])}}
                </div>

                <div class="form-group">
                    <label class="text-right control-label col-form-label">Registered Subjects</label>
                    {{Form::select('subject_id', $subjects, null, ['class' => 'form-control form-control-sm select','placeholder'=>"All subjects"])}}
                </div>

                <hr>
                <div class="form-actions">
                    <button type="submit" class="btn btn-success btn-sm">Search</button>
                    <a href="{{route('reports.students.index')}}" class="btn btn-sm">Clear</a>
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
                @if($invoices)
                <strong>{{$invoices->total()}} Results Found</strong>, <a href="{{route('reports.finance.export')}}">Export to excel</a>
                <table class="table table-responsive-sm table-bordered table-striped table-sm" style="width:100%">
                    <thead>
                        <tr>
                            <th>Student number</th>
                            <th>Names</th>
                            <th>Contact number</th>
                            <th>Total Debit(N$)</th>
                            <th>Total Credit(N$)</th>
                            <th>Balance (N$)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($invoices as $invoice)

                        <tr>
                            <td>{{$invoice->student_number2}}</td>
                            <td>{{$invoice->student_names}} {{$invoice->surname}}</td>
                            <td>{{$invoice->contact_number}}</td>
                            <td>{{number_format($invoice->debit_amount, 2, '.',',')}}</td>
                            <td>{{number_format($invoice->credit_amount, 2, '.',',')}}</td>
                            <td>{{number_format($invoice->balance, 2, '.',',')}}</td>
                        </tr>
                        @endforeach
                        <tr>
                            <th colspan="3" class="text-right">TOTAL</th>
                            <th>{{number_format($invoices->sum('debit_amount'),2, '.',',')}}</th>
                            <th>{{number_format($invoices->sum('credit_amount'),2, '.',',')}}</th>
                            <th>{{number_format($invoices->sum('balance'),2, '.',',')}}</th>
                        </tr>
                    </tbody>
                </table>

                @endif
            </div>
        </div>
    </div>
</div>
@endsection