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
                <form action="{{ route('reports.account-summary.search') }}" method="POST" class="form-vertical form-material">
                    @csrf
                <div class="form-group">
                    <label class="text-right control-label col-form-label">Financial year</label>
                    <select name="financial_year" class="form-control form-control-sm select">
                        <option value="">All years</option>
                        @foreach($financial_years as $key => $year)
                            <option value="{{ $key }}" {{ $key == date('Y') ? 'selected' : '' }}>{{ $year }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="text-right control-label col-form-label">Registration status</label>
                    <select name="registration_status" class="form-control form-control-sm select">
                        <option value="">Show all</option>
                        <option value="Registered">Registered</option>
                        <option value="Canceled">Cancelled</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="text-right control-label col-form-label">Center</label>
                    <select name="center_id" class="form-control form-control-sm select">
                        <option value="">Show all</option>
                        @foreach($centers as $key => $center)
                            <option value="{{ $key }}">{{ $center }}</option>
                        @endforeach
                    </select>
                </div>

                <hr>
                <div class="form-actions">
                    <button type="submit" class="btn btn-success btn-sm">Search</button>
                    <a href="{{route('reports.account-summary.index')}}" class="btn btn-sm">Clear</a>
                </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-9 col-xs-12">
        <div class="card">
            <div class="card-header">
                <strong>Report results</strong>
            </div>
            <div class="card-body">
                @if(Session::has('success'))
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    {{ Session::get('success') }}
                </div>
                @endif
                @if(isset($account_summary) && $account_summary)
                <strong>{{$account_summary->count()}} Results Found</strong>, <a href="{{route('reports.account-summary.export')}}">Export to excel</a>
                <div class="alert alert-info">
                    <strong>Please note: </strong> The report will be automatically generated on the 1st of every month by the system. Nevertheless, you can also generate it at any other time by clicking the "Export to Excel" link above on an ad-hoc basis.
                </div>

                <div class="alert alert-warning">
                    Exporting of this report may take up to 10 minutes due to the amount of calculations involved. As soon as its done doing the calculations, the downloaded file will be available in the table below.
                </div>
                @if(isset($report_request) && $report_request)
                <div class="alert alert-warning">
                    <table class="table table-bordered">
                        <tr>
                            <th>File</th>
                            <th>Date Requested</th>
                            <th>Requested by</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        <tr>
                            <td>{{ $report_request->document_path }}</td>
                            <td>{{ $report_request->request_datetime }}</td>
                            <td>{{ $report_request->requested_by }}</td>
                            <td class="text-center">
                                @if($report_request->status === 'Busy')
                                <div class="spinner-border spinner-border-sm text-warning" role="status">
                                    <span class="visually-hidden"></span>
                                </div>
                                @else
                                {{ $report_request->status }}
                                @endif
                            </td>
                            <td class="text-center">
                                @if($report_request->status === 'Complete')
                                <a href="{{ route('download.account-summary-report') }}">
                                    <svg class="c-icon mr-2">
                                        <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-cloud-download')}}"></use>
                                    </svg>
                                </a>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
                @endif
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

                        @if(isset($account_summary) && $account_summary->count() > 0)
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
                        @endif
                        <tr>
                            <th colspan="3">TOTAL</th>
                            <th>{{isset($totals) ? number_format($totals['tuition_fees'], 2, '.',',') : '0.00'}}</th>
                            <th>{{isset($totals) ? number_format($totals['other_fees'], 2, '.',',') : '0.00'}}</th>
                            <th>{{isset($totals) ? number_format($totals['payable_amount'], 2, '.',',') : '0.00'}}</th>
                            <th>{{isset($totals) ? number_format($totals['course_balance'], 2, '.',',') : '0.00'}}</th>
                        </tr>
                    </tbody>
                </table>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection