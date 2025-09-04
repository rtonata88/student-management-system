@extends('layouts.app')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Human Resources</li>
        <li class="breadcrumb-item">Payroll Management</li>
        <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection
@section('content')
<div class="row">
    <div class="col-md-12 col-xs-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Payroll Management Dashboard</h5>
                <small class="text-muted">Employee payroll processing and management system</small>
            </div>
            <div class="card-body">
                <!-- Statistics Cards -->
                <div class="row mb-4">
                    <div class="col-md-3 mb-3">
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="stat-content">
                                <h3>{{$stats['total_employees']}}</h3>
                                <p>Total Employees</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="stat-card">
                            <div class="stat-icon processing">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="stat-content">
                                <h3>{{$stats['active_periods']}}</h3>
                                <p>Active Periods</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="stat-card">
                            <div class="stat-icon warning">
                                <i class="fas fa-exclamation-triangle"></i>
                            </div>
                            <div class="stat-content">
                                <h3>{{$stats['pending_approvals']}}</h3>
                                <p>Pending Approvals</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="stat-card">
                            <div class="stat-icon success">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="stat-content">
                                <h3>{{$stats['completed_periods']}}</h3>
                                <p>Completed Periods</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <h6 class="mb-3">Quick Actions</h6>
                        <div class="row">
                            @permission('create-payroll-periods')
                            <div class="col-md-3 mb-3">
                                <a href="{{route('payroll.periods.create')}}" class="action-card">
                                    <div class="action-icon">
                                        <i class="fas fa-plus"></i>
                                    </div>
                                    <h6>New Period</h6>
                                    <small>Create new payroll period</small>
                                </a>
                            </div>
                            @endpermission
                            
                            @permission('view-employee-payroll')
                            <div class="col-md-3 mb-3">
                                <a href="{{route('payroll.employees.index')}}" class="action-card">
                                    <div class="action-icon">
                                        <i class="fas fa-user-cog"></i>
                                    </div>
                                    <h6>Manage Employees</h6>
                                    <small>Employee payroll settings</small>
                                </a>
                            </div>
                            @endpermission
                            
                            @permission('view-pay-slips')
                            <div class="col-md-3 mb-3">
                                <a href="{{route('payroll.pay-slips')}}" class="action-card">
                                    <div class="action-icon">
                                        <i class="fas fa-file-invoice-dollar"></i>
                                    </div>
                                    <h6>Pay Slips</h6>
                                    <small>View and manage pay slips</small>
                                </a>
                            </div>
                            @endpermission
                            
                            @permission('view-payroll-reports')
                            <div class="col-md-3 mb-3">
                                <a href="{{route('payroll.reports')}}" class="action-card">
                                    <div class="action-icon">
                                        <i class="fas fa-chart-bar"></i>
                                    </div>
                                    <h6>Reports</h6>
                                    <small>Payroll reports and analytics</small>
                                </a>
                            </div>
                            @endpermission
                        </div>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="activity-card">
                            <h6 class="mb-3">Recent Payroll Periods</h6>
                            @if($recentPeriods->count() > 0)
                                @foreach($recentPeriods as $period)
                                <div class="activity-item">
                                    <div class="activity-content">
                                        <h6>{{$period->period_name}}</h6>
                                        <small class="text-muted">{{$period->start_date->format('M d')}} - {{$period->end_date->format('M d, Y')}}</small>
                                        <span class="badge badge-{{$period->status_badge}} ml-2">{{ucfirst($period->status)}}</span>
                                    </div>
                                    <div class="activity-actions">
                                        @permission('view-payroll-periods')
                                        <a href="{{route('payroll.periods')}}" class="btn btn-sm" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                        @endpermission
                                    </div>
                                </div>
                                @endforeach
                            @else
                                <p class="text-muted">No payroll periods found.</p>
                            @endif
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="activity-card">
                            <h6 class="mb-3">Pending Pay Slip Approvals</h6>
                            @if($pendingPaySlips->count() > 0)
                                @foreach($pendingPaySlips as $paySlip)
                                <div class="activity-item">
                                    <div class="activity-content">
                                        <h6>{{$paySlip->employee_name}}</h6>
                                        <small class="text-muted">{{$paySlip->payrollPeriod->period_name}} - {{$paySlip->formatted_net_pay}}</small>
                                    </div>
                                    <div class="activity-actions">
                                        @permission('approve-pay-slips')
                                        <a href="{{route('payroll.pay-slips.show', $paySlip)}}" class="btn btn-sm" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                                            <i class="fas fa-check"></i> Approve
                                        </a>
                                        @endpermission
                                    </div>
                                </div>
                                @endforeach
                            @else
                                <p class="text-muted">No pending approvals.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<style>
/* Statistics Cards */
.stat-card {
    background: white;
    border-radius: 10px;
    padding: 1.5rem;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    display: flex;
    align-items: center;
    transition: transform 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-2px);
}

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1rem;
    background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%);
    color: white;
    font-size: 1.5rem;
}

.stat-icon.processing {
    background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);
}

.stat-icon.warning {
    background: linear-gradient(135deg, #dc3545 0%, #fd7e14 100%);
}

.stat-icon.success {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
}

.stat-content h3 {
    margin: 0;
    font-size: 2rem;
    font-weight: bold;
    color: #333;
}

.stat-content p {
    margin: 0;
    color: #666;
    font-size: 0.9rem;
}

/* Action Cards */
.action-card {
    display: block;
    background: white;
    border-radius: 10px;
    padding: 1.5rem;
    text-align: center;
    text-decoration: none;
    color: inherit;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
}

.action-card:hover {
    text-decoration: none;
    color: inherit;
    transform: translateY(-2px);
    box-shadow: 0 4px 20px rgba(0,0,0,0.15);
}

.action-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    font-size: 1.2rem;
}

.action-card h6 {
    margin-bottom: 0.5rem;
    color: #333;
    font-weight: 600;
}

.action-card small {
    color: #666;
}

/* Activity Cards */
.activity-card {
    background: white;
    border-radius: 10px;
    padding: 1.5rem;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    height: 100%;
}

.activity-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 0;
    border-bottom: 1px solid #eee;
}

.activity-item:last-child {
    border-bottom: none;
}

.activity-content h6 {
    margin: 0 0 0.25rem 0;
    color: #333;
}

.activity-content small {
    color: #666;
}

.activity-actions {
    flex-shrink: 0;
}

/* Card styling */
.card {
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    border: none;
    border-radius: 10px;
}

.card-header {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-bottom: 1px solid #dee2e6;
    border-radius: 10px 10px 0 0 !important;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .stat-card, .action-card {
        margin-bottom: 1rem;
    }
    
    .activity-item {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .activity-actions {
        margin-top: 0.5rem;
    }
}
</style>
