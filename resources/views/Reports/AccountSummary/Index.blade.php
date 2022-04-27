@extends('layouts.app')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Reports</li>
        <li class="breadcrumb-item active">Account Summary </li>
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
                {!! Form::open(array('route' => array('reports.account-summary.search'), 'method' => 'post', 'class'=> 'form-vertical form-material')) !!}
                <div class="form-group">
                    <label class="text-right control-label col-form-label">Financial year</label>
                    {{Form::select('financial_year', $financial_years, date('Y'), ['class' => 'form-control form-control-sm select', 'placeholder'=>"All years"])}}
                </div>

                <div class="form-group">
                    <label class="text-right control-label col-form-label">Registration status</label>
                    {{Form::select('registration_status', ['Registered' => 'Registered', 'Canceled' => 'Cancelled'], null, ['class' => 'form-control form-control-sm select','placeholder'=>"Show all"])}}
                </div>

                <div class="form-group">
                    <label class="text-right control-label col-form-label">Center</label>
                    {{Form::select('center_id', $centers, null, ['class' => 'form-control form-control-sm select','placeholder'=>"Show all"])}}
                </div>

                <hr>
                <div class="form-actions">
                    <button type="submit" class="btn btn-success btn-sm">Search</button>
                    <a href="{{route('reports.account-summary.index')}}" class="btn btn-sm">Clear</a>
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

                @if($account_summary)
                <strong>{{$account_summary->count()}} Results Found</strong>, <a href="{{route('reports.account-summary.export')}}">Export to excel</a>
                <table class="table table-responsive-sm table-bordered table-striped table-sm" style="width:100%; font-size:12px">
                    <thead>
                        <tr>
                            <th>Student number</th>
                            <th>Names</th>
                            <th>Center</th>
                            <th>Tuition Fees (N$)</th>
                            <th>Other fees (N$)</th>
                            <th>Total Payable (N$)</th>
                            <th>Course Balance (N$)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th colspan="3">TOTAL</th>
                            <th>{{number_format($totals['tuition_fees'], 2, '.',',')}}</th>
                            <th>{{number_format($totals['other_fees'], 2, '.',',')}}</th>
                            <th>{{number_format($totals['payable_amount'], 2, '.',',')}}</th>
                            <th>{{number_format($totals['course_balance'], 2, '.',',')}}</th>
                        </tr>

                        @foreach($account_summary->take(10) as $summary)
                        <?php
                        $payment = $payments->where('student_id', $summary->student_id)->first()->payments ?? 0;
                        $other_fees = $extra_charges->where('student_id', $summary->student_id)->first()->outstanding ?? 0;
                        $payable_amount = ($other_fees + $summary->tuition_fees_payable) - $payment;
                        $debit = $invoices->where('student_id', $summary->student_id)->first()->debit ?? 0;
                        $credit = $invoices->where('student_id', $summary->student_id)->first()->credit ?? 0;
                        $course_balance = $debit - $credit;
                        ?>
                        <tr>
                            <td>{{$summary->student_number2}}</td>
                            <td>{{$summary->student_names}} {{$summary->surname}}</td>
                            <td>{{$centers[$summary->center_id]}}</td>
                            <td>{{number_format($summary->tuition_fees_payable - $payment, 2, '.',',')}}</td>
                            <td>{{number_format($other_fees, 2, '.',',')}}</td>
                            <td>{{number_format($payable_amount, 2, '.',',')}}</td>
                            <td>{{number_format($course_balance, 2, '.',',')}}</td>
                        </tr>
                        @endforeach
                        <tr>
                            <th colspan="3">TOTAL</th>
                            <th>{{number_format($totals['tuition_fees'], 2, '.',',')}}</th>
                            <th>{{number_format($totals['other_fees'], 2, '.',',')}}</th>
                            <th>{{number_format($totals['payable_amount'], 2, '.',',')}}</th>
                            <th>{{number_format($totals['course_balance'], 2, '.',',')}}</th>
                        </tr>
                    </tbody>
                </table>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection