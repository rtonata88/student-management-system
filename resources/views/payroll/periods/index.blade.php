@extends('layouts.app')
@section('breadcrumb')
<div class="c-subheader px-3">
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Human Resources</li>
        <li class="breadcrumb-item"><a href="{{route('payroll.index')}}">Payroll</a></li>
        <li class="breadcrumb-item active">Payroll Periods</li>
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
                            <h5 class="mb-0">Payroll Periods</h5>
                            <small class="text-muted">Manage payroll processing periods</small>
                        </div>
                    </div>
                    @permission('create-payroll-periods')
                    <a href="{{route('payroll.periods.create')}}" class="btn" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                        <i class="fas fa-plus"></i> New Period
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
                        <form method="GET" action="{{route('payroll.periods')}}">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" placeholder="Search by period name, status, or description..." value="{{request('search')}}">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="submit">
                                        <i class="fas fa-search"></i> Search
                                    </button>
                                    @if(request('search'))
                                    <a href="{{route('payroll.periods')}}" class="btn btn-outline-danger">
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
                            Showing results for "<strong>{{request('search')}}</strong>" ({{$periods->total()}} found)
                        </small>
                        @else
                        <small class="text-muted">
                            Total: {{$periods->total()}} periods
                        </small>
                        @endif
                    </div>
                </div>

                @if($periods->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Period Name</th>
                                <th>Period Dates</th>
                                <th>Pay Date</th>
                                <th>Status</th>
                                <th>Employees</th>
                                <th>Total Net Pay</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($periods as $period)
                            <tr>
                                <td>
                                    <strong>{{$period->period_name}}</strong>
                                    @if($period->description)
                                        <br><small class="text-muted">{{$period->description}}</small>
                                    @endif
                                </td>
                                <td>
                                    {{$period->start_date->format('M d')}} - {{$period->end_date->format('M d, Y')}}<br>
                                    <small class="text-muted">{{$period->duration}} days</small>
                                </td>
                                <td>{{$period->pay_date->format('M d, Y')}}</td>
                                <td>
                                    <span class="badge badge-{{$period->status_badge}}">{{ucfirst($period->status)}}</span>
                                </td>
                                <td>{{$period->employee_count}}</td>
                                <td>N${{number_format($period->total_net_pay, 2)}}</td>
                                <td>
                                    @permission('edit-payroll-periods')
                                    @if($period->canBeProcessed())
                                        <a href="{{route('payroll.periods.edit', $period)}}" class="btn btn-sm" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem; margin-right: 8px;">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                    @endif
                                    @endpermission
                                    
                                    @permission('process-payroll')
                                    @if($period->canBeProcessed())
                                        <form method="POST" action="{{route('payroll.periods.process', $period)}}" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Process payroll for this period?')" style="margin-right: 8px;">
                                                <i class="fas fa-play"></i> Process
                                            </button>
                                        </form>
                                    @endif
                                    @endpermission
                                    
                                    @permission('delete-payroll-periods')
                                    @if($period->canBeDeleted())
                                        <form method="POST" action="{{route('payroll.periods.destroy', $period)}}" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this period?')">
                                                <i class="fas fa-trash"></i> Delete
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
                    {{$periods->appends(request()->query())->links()}}
                </div>
                @else
                <div class="text-center py-5">
                    <i class="fas fa-calendar-alt fa-3x text-muted mb-3"></i>
                    <h5>No Payroll Periods Found</h5>
                    <p class="text-muted">Create your first payroll period to start processing employee payments.</p>
                    @permission('create-payroll-periods')
                    <a href="{{route('payroll.periods.create')}}" class="btn" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                        <i class="fas fa-plus"></i> Create First Period
                    </a>
                    @endpermission
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
