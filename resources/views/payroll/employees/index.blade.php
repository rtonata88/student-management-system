@extends('layouts.app')
@section('breadcrumb')
<div class="c-subheader px-3">
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Human Resources</li>
        <li class="breadcrumb-item"><a href="{{route('payroll.index')}}">Payroll</a></li>
        <li class="breadcrumb-item active">Employee Settings</li>
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
                        <a href="{{route('payroll.index')}}" class="btn btn-outline-secondary btn-sm me-3" style="margin-right: 12px;">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                        <div>
                            <h5 class="mb-0">Employee Payroll Settings</h5>
                            <small class="text-muted">Manage employee salary and payroll configurations</small>
                        </div>
                    </div>
                    @permission('edit-employee-payroll')
                    <a href="{{route('payroll.employees.create')}}" class="btn" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                        <i class="fas fa-plus"></i> Add Employee
                    </a>
                    @endpermission
                </div>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{session('success')}}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">{{session('error')}}</div>
                @endif

                <!-- Search Form -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <form method="GET" action="{{route('payroll.employees.index')}}">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" placeholder="Search by name, employee number, or email..." value="{{request('search')}}">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="submit">
                                        <i class="fas fa-search"></i> Search
                                    </button>
                                    @if(request('search'))
                                    <a href="{{route('payroll.employees.index')}}" class="btn btn-outline-danger">
                                        <i class="fas fa-times"></i>
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-6 text-right">
                        @if(request('search'))
                        <small class="text-muted">
                            Showing results for "<strong>{{request('search')}}</strong>" ({{$employees->total()}} found)
                        </small>
                        @else
                        <small class="text-muted">
                            Total: {{$employees->total()}} employees
                        </small>
                        @endif
                    </div>
                </div>

                @if($employees->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Employee</th>
                                <th>Employee Number</th>
                                <th>Basic Salary</th>
                                <th>Pay Frequency</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($employees as $employee)
                            <tr>
                                <td>
                                    <strong>{{$employee->full_name}}</strong><br>
                                    <small class="text-muted">{{$employee->user->email ?? 'N/A'}}</small>
                                </td>
                                <td>{{$employee->employee_number}}</td>
                                <td>{{$employee->formatted_salary}}</td>
                                <td>
                                    <span class="badge badge-info">{{ucfirst($employee->pay_frequency)}}</span>
                                </td>
                                <td>
                                    @if($employee->is_active)
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-secondary">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    @permission('edit-employee-payroll')
                                    <a href="{{route('payroll.employees.edit', $employee)}}" class="btn btn-sm" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem; margin-right: 8px;">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    @endpermission
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="d-flex justify-content-center">
                    {{$employees->appends(request()->query())->links()}}
                </div>
                @else
                <div class="text-center py-5">
                    <i class="fas fa-users fa-3x text-muted mb-3"></i>
                    <h5>No Employee Payroll Settings Found</h5>
                    <p class="text-muted">Start by adding employees to the payroll system.</p>
                    @permission('edit-employee-payroll')
                    <a href="{{route('payroll.employees.create')}}" class="btn" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                        <i class="fas fa-plus"></i> Add First Employee
                    </a>
                    @endpermission
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
