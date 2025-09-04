@extends('layouts.app')
@section('breadcrumb')
<div class="c-subheader px-3">
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Human Resources</li>
        <li class="breadcrumb-item"><a href="{{route('payroll.index')}}">Payroll</a></li>
        <li class="breadcrumb-item"><a href="{{route('payroll.pay-slips')}}">Pay Slips</a></li>
        <li class="breadcrumb-item active">{{$paySlip->employee_name}}</li>
    </ol>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <a href="{{route('payroll.pay-slips')}}" class="btn btn-outline-secondary btn-sm me-3" style="margin-right: 12px;">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                        <div>
                            <h5 class="mb-0">Pay Slip - {{$paySlip->slip_number}}</h5>
                            <small class="text-muted">{{$paySlip->employee_name}} - {{$paySlip->payrollPeriod->period_name}}</small>
                        </div>
                    </div>
                    <div>
                        @permission('print-pay-slips')
                        <a href="{{route('payroll.pay-slips.print', $paySlip)}}" class="btn btn-outline-primary btn-sm" target="_blank" style="margin-right: 8px;">
                            <i class="fas fa-print"></i> Print
                        </a>
                        @endpermission
                        @permission('download-pay-slips')
                        <a href="{{route('payroll.pay-slips.download', $paySlip)}}" class="btn btn-outline-success btn-sm">
                            <i class="fas fa-download"></i> Download PDF
                        </a>
                        @endpermission
                    </div>
                </div>
            </div>
            <div class="card-body">
                <!-- Company Header -->
                <div class="row mb-4">
                    <div class="col-md-12 text-center">
                        <h3>{{$company->company_name}}</h3>
                        <p class="mb-1">{{$company->address1}}</p>
                        @if($company->address2)<p class="mb-1">{{$company->address2}}</p>@endif
                        @if($company->address3)<p class="mb-1">{{$company->address3}}</p>@endif
                        @if($company->address4)<p class="mb-1">{{$company->address4}}</p>@endif
                        <p class="mb-0">
                            <strong>Contact:</strong> {{$company->contact_number}} 
                            @if($company->fax) | <strong>Fax:</strong> {{$company->fax}}@endif
                        </p>
                        <hr class="my-3">
                        <h4 class="text-primary">PAY SLIP</h4>
                    </div>
                </div>

                <!-- Employee & Period Info -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>Employee Name:</strong></td>
                                <td>{{$paySlip->employee_name}}</td>
                            </tr>
                            <tr>
                                <td><strong>Employee Number:</strong></td>
                                <td>{{$paySlip->employee_number}}</td>
                            </tr>
                            <tr>
                                <td><strong>Pay Period:</strong></td>
                                <td>{{$paySlip->payrollPeriod->period_name}}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>Slip Number:</strong></td>
                                <td>{{$paySlip->slip_number}}</td>
                            </tr>
                            <tr>
                                <td><strong>Pay Date:</strong></td>
                                <td>{{$paySlip->payrollPeriod->pay_date->format('M d, Y')}}</td>
                            </tr>
                            <tr>
                                <td><strong>Status:</strong></td>
                                <td><span class="badge badge-{{$paySlip->status_badge}}">{{ucfirst($paySlip->status)}}</span></td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- Earnings & Deductions -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-success text-white">
                                <h6 class="mb-0"><i class="fas fa-plus-circle"></i> Earnings</h6>
                            </div>
                            <div class="card-body">
                                <table class="table table-sm">
                                    <tr>
                                        <td><strong>Basic Salary</strong></td>
                                        <td class="text-right">{{$paySlip->formatted_basic_salary ?? 'N$ ' . number_format($paySlip->basic_salary, 2)}}</td>
                                    </tr>
                                    @if($paySlip->earnings_breakdown)
                                        @foreach($paySlip->earnings_breakdown as $earning)
                                        <tr>
                                            <td>{{$earning['name'] ?? 'Allowance'}}</td>
                                            <td class="text-right">N$ {{number_format($earning['amount'] ?? 0, 2)}}</td>
                                        </tr>
                                        @endforeach
                                    @endif
                                    <tr class="table-success">
                                        <td><strong>Total Earnings</strong></td>
                                        <td class="text-right"><strong>{{$paySlip->formatted_total_earnings ?? 'N$ ' . number_format($paySlip->total_earnings, 2)}}</strong></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-warning text-dark">
                                <h6 class="mb-0"><i class="fas fa-minus-circle"></i> Deductions</h6>
                            </div>
                            <div class="card-body">
                                <table class="table table-sm">
                                    @if($paySlip->deductions_breakdown)
                                        @foreach($paySlip->deductions_breakdown as $deduction)
                                        <tr>
                                            <td>{{$deduction['name'] ?? 'Deduction'}}</td>
                                            <td class="text-right">N$ {{number_format($deduction['amount'] ?? 0, 2)}}</td>
                                        </tr>
                                        @endforeach
                                    @endif
                                    @if($paySlip->tax_amount > 0)
                                    <tr>
                                        <td>Income Tax</td>
                                        <td class="text-right">N$ {{number_format($paySlip->tax_amount, 2)}}</td>
                                    </tr>
                                    @endif
                                    <tr class="table-warning">
                                        <td><strong>Total Deductions</strong></td>
                                        <td class="text-right"><strong>{{$paySlip->formatted_total_deductions ?? 'N$ ' . number_format($paySlip->total_deductions + $paySlip->tax_amount, 2)}}</strong></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Net Pay Summary -->
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card bg-primary text-white">
                            <div class="card-body text-center">
                                <h4 class="mb-0">
                                    <i class="fas fa-money-bill-wave"></i> 
                                    Net Pay: {{$paySlip->formatted_net_pay ?? 'N$ ' . number_format($paySlip->net_pay, 2)}}
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>

                @if($paySlip->notes)
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0"><i class="fas fa-sticky-note"></i> Notes</h6>
                            </div>
                            <div class="card-body">
                                <p class="mb-0">{{$paySlip->notes}}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Approval Info -->
                @if($paySlip->status !== 'draft')
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card border-success">
                            <div class="card-body">
                                <div class="row">
                                    @if($paySlip->approved_by && $paySlip->approved_at)
                                    <div class="col-md-6">
                                        <p class="mb-1"><strong>Approved By:</strong> {{$paySlip->approvedBy->name ?? 'N/A'}}</p>
                                        <p class="mb-0"><strong>Approved On:</strong> {{$paySlip->approved_at->format('M d, Y H:i')}}</p>
                                    </div>
                                    @endif
                                    @if($paySlip->paid_at)
                                    <div class="col-md-6">
                                        <p class="mb-0"><strong>Paid On:</strong> {{$paySlip->paid_at->format('M d, Y H:i')}}</p>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
