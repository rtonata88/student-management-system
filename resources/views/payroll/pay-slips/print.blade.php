@extends('layouts.print')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Human Resources</li>
        <li class="breadcrumb-item"><a href="/payroll">Payroll</a></li>
        <li class="breadcrumb-item"><a href="/payroll/pay-slips">Pay Slips</a></li>
        <li class="breadcrumb-item active">{{$paySlip->employee_name}}</li>
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
                <div class="row mb-3">
                    <div class="col-md-12 text-center">
                        <h4><strong>PAY SLIP</strong></h4>
                        <p class="text-muted">Pay Period: {{$paySlip->payrollPeriod->start_date->format('M d, Y')}} - {{$paySlip->payrollPeriod->end_date->format('M d, Y')}}</p>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <table class="table-sm" style="width:100%">
                            <tr>
                                <th style="width: 150px">Employee Number</th>
                                <td>{{$paySlip->employee_number}}</td>
                            </tr>
                            <tr>
                                <th style="width: 150px">Employee Name</th>
                                <td>{{$paySlip->employee_name}}</td>
                            </tr>
                            <tr>
                                <th style="width: 150px">Pay Slip Number</th>
                                <td>{{$paySlip->slip_number}}</td>
                            </tr>
                            <tr>
                                <th style="width: 100px">Pay Date</th>
                                <td>{{$paySlip->payrollPeriod->pay_date->format('M d, Y')}}</td>
                            </tr>
                            <tr>
                                <th style="width: 100px">Status</th>
                                <td>{{ucfirst($paySlip->status)}}</td>
                            </tr>
                        </table>
                    </div>

                    <div class="col-md-6">
                        <strong>Pay Summary: </strong>
                        <table class="table table-responsive-sm table-bordered table-striped table-sm" style="width:100%">
                            <tbody>
                                <tr>
                                    <th>Basic Salary</th>
                                    <td>N${{number_format($paySlip->basic_salary,2, '.',',')}}</td>
                                </tr>
                                <tr>
                                    <th>Total Allowances</th>
                                    <td>N${{number_format($paySlip->total_allowances,2, '.',',')}}</td>
                                </tr>
                                <tr>
                                    <th>Gross Pay</th>
                                    <td><strong>N${{number_format($paySlip->gross_pay,2, '.',',')}}</strong></td>
                                </tr>
                                <tr>
                                    <th>Total Deductions</th>
                                    <td>N${{number_format($paySlip->total_deductions,2, '.',',')}}</td>
                                </tr>
                                <tr>
                                    <th>Tax Amount</th>
                                    <td>N${{number_format($paySlip->tax_amount,2, '.',',')}}</td>
                                </tr>
                                <tr class="table-success">
                                    <th><strong>Net Pay</strong></th>
                                    <td><strong>N${{number_format($paySlip->net_pay,2, '.',',')}}</strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <hr>
                
                <!-- Earnings Breakdown -->
                @if($paySlip->earnings_breakdown && count($paySlip->earnings_breakdown) > 0)
                <div class="row mb-3">
                    <div class="col-md-6">
                        <h6><strong>Earnings Breakdown</strong></h6>
                        <table class="table table-responsive-sm table-bordered table-sm" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Description</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Basic Salary</td>
                                    <td>N${{number_format($paySlip->basic_salary, 2, '.',',')}}</td>
                                </tr>
                                @foreach($paySlip->earnings_breakdown as $earning)
                                <tr>
                                    <td>{{$earning['name'] ?? 'Allowance'}}</td>
                                    <td>N${{number_format($earning['amount'], 2, '.',',')}}</td>
                                </tr>
                                @endforeach
                                <tr class="table-info">
                                    <th>Total Earnings</th>
                                    <th>N${{number_format($paySlip->gross_pay, 2, '.',',')}}</th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Deductions Breakdown -->
                    <div class="col-md-6">
                        <h6><strong>Deductions Breakdown</strong></h6>
                        <table class="table table-responsive-sm table-bordered table-sm" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Description</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($paySlip->deductions_breakdown && count($paySlip->deductions_breakdown) > 0)
                                    @foreach($paySlip->deductions_breakdown as $deduction)
                                    <tr>
                                        <td>{{$deduction['name'] ?? 'Deduction'}}</td>
                                        <td>N${{number_format($deduction['amount'], 2, '.',',')}}</td>
                                    </tr>
                                    @endforeach
                                @endif
                                @if($paySlip->tax_amount > 0)
                                <tr>
                                    <td>Income Tax</td>
                                    <td>N${{number_format($paySlip->tax_amount, 2, '.',',')}}</td>
                                </tr>
                                @endif
                                <tr class="table-warning">
                                    <th>Total Deductions</th>
                                    <th>N${{number_format($paySlip->total_deductions + $paySlip->tax_amount, 2, '.',',')}}</th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif
                
                <hr>
                
                <!-- Final Summary -->
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-responsive-sm table-bordered table-sm" style="width:100%">
                            <tr class="table-success">
                                <th style="text-align: right; font-size: 1.1em;">NET PAY AMOUNT:</th>
                                <th style="font-size: 1.2em;">N${{number_format($paySlip->net_pay, 2, '.',',')}}</th>
                            </tr>
                        </table>
                    </div>
                </div>
                
                @if($paySlip->notes)
                <div class="row mt-3">
                    <div class="col-md-12">
                        <h6><strong>Notes:</strong></h6>
                        <p>{{$paySlip->notes}}</p>
                    </div>
                </div>
                @endif
                
                <div class="row mt-4">
                    <div class="col-md-6">
                        <p><strong>Generated On:</strong> {{now()->format('M d, Y H:i')}}</p>
                        @if($paySlip->approved_at)
                        <p><strong>Approved On:</strong> {{$paySlip->approved_at->format('M d, Y H:i')}}</p>
                        <p><strong>Approved By:</strong> {{$paySlip->approvedBy->name ?? 'System'}}</p>
                        @endif
                    </div>
                    <div class="col-md-6 text-right">
                        <div style="border-top: 1px solid #000; width: 200px; margin-left: auto; margin-top: 50px;">
                            <p class="mt-2"><strong>Authorized Signature</strong></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    window.onload = function() {
        window.print();
    };
</script>
@endsection
