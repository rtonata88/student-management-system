@extends('layouts.app')
@section('breadcrumb')
<div class="c-subheader px-3">
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Human Resources</li>
        <li class="breadcrumb-item"><a href="{{route('payroll.index')}}">Payroll</a></li>
        <li class="breadcrumb-item active">Pay Slips</li>
    </ol>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Pay Slips</h5>
                <small class="text-muted">View and manage employee pay slips</small>
            </div>
            <div class="card-body">
                <!-- Filters -->
                <form method="GET" class="mb-4">
                    <div class="row">
                        <div class="col-md-4">
                            <select name="period_id" class="form-control">
                                <option value="">All Periods</option>
                                @foreach($periods as $period)
                                    <option value="{{$period->id}}" {{request('period_id') == $period->id ? 'selected' : ''}}>
                                        {{$period->period_name}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <select name="status" class="form-control">
                                <option value="">All Status</option>
                                <option value="draft" {{request('status') == 'draft' ? 'selected' : ''}}>Draft</option>
                                <option value="approved" {{request('status') == 'approved' ? 'selected' : ''}}>Approved</option>
                                <option value="paid" {{request('status') == 'paid' ? 'selected' : ''}}>Paid</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                                <i class="fas fa-filter"></i> Filter
                            </button>
                        </div>
                    </div>
                </form>

                @if(session('success'))
                    <div class="alert alert-success">{{session('success')}}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">{{session('error')}}</div>
                @endif

                @if($paySlips->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Slip Number</th>
                                <th>Employee</th>
                                <th>Period</th>
                                <th>Gross Pay</th>
                                <th>Net Pay</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($paySlips as $paySlip)
                            <tr>
                                <td>
                                    <strong>{{$paySlip->slip_number}}</strong>
                                </td>
                                <td>
                                    {{$paySlip->employee_name}}<br>
                                    <small class="text-muted">{{$paySlip->employee_number}}</small>
                                </td>
                                <td>{{$paySlip->payrollPeriod->period_name}}</td>
                                <td>{{$paySlip->formatted_gross_pay}}</td>
                                <td><strong>{{$paySlip->formatted_net_pay}}</strong></td>
                                <td>
                                    <span class="badge badge-{{$paySlip->status_badge}}">{{ucfirst($paySlip->status)}}</span>
                                </td>
                                <td>
                                    @permission('view-pay-slips')
                                    <a href="{{route('payroll.pay-slips.show', $paySlip)}}" class="btn btn-sm" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem; margin-right: 8px;">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                    @endpermission
                                    
                                    @permission('print-pay-slips')
                                    <a href="{{route('payroll.pay-slips.print', $paySlip)}}" class="btn btn-sm btn-secondary" target="_blank" style="margin-right: 8px;">
                                        <i class="fas fa-print"></i> Print
                                    </a>
                                    @endpermission
                                    
                                    @permission('download-pay-slips')
                                    <a href="{{route('payroll.pay-slips.download', $paySlip)}}" class="btn btn-sm btn-info" style="margin-right: 8px;">
                                        <i class="fas fa-download"></i> PDF
                                    </a>
                                    @endpermission
                                    
                                    @permission('approve-pay-slips')
                                    @if($paySlip->canBeApproved())
                                        <form method="POST" action="{{route('payroll.pay-slips.approve', $paySlip)}}" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Approve this pay slip?')">
                                                <i class="fas fa-check"></i> Approve
                                            </button>
                                        </form>
                                    @endif
                                    @endpermission
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="d-flex justify-content-center">
                    {{$paySlips->links()}}
                </div>
                @else
                <div class="text-center py-5">
                    <i class="fas fa-file-invoice-dollar fa-3x text-muted mb-3"></i>
                    <h5>No Pay Slips Found</h5>
                    <p class="text-muted">Pay slips will appear here after processing payroll periods.</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
