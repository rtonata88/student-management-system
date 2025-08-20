@extends('layouts.app')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Asset Management</li>
        <li class="breadcrumb-item active">Maintenance</li>
        <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection
@section('content')
<div class="container-fluid">
    <!-- Header Section with Stats -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div class="mb-2 mb-md-0">
                    <h2 class="mb-1">Maintenance Management</h2>
                    <p class="text-muted mb-0">Manage facility maintenance requests and work orders</p>
                </div>
                @permission('maintenance-create-request')
                <div class="d-flex align-items-center gap-2">
                    <a href="{{route('maintenance.create')}}" class="btn btn-primary">
                        <i class="fa fa-plus"></i> New Request
                    </a>
                </div>
                @endpermission
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-2">
            <div class="card bg-primary text-white">
                <div class="card-body text-center">
                    <h3 class="mb-1">{{$stats['total_requests']}}</h3>
                    <small>Total Requests</small>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card bg-warning text-white">
                <div class="card-body text-center">
                    <h3 class="mb-1">{{$stats['pending_requests']}}</h3>
                    <small>Pending</small>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card bg-info text-white">
                <div class="card-body text-center">
                    <h3 class="mb-1">{{$stats['in_progress_requests']}}</h3>
                    <small>In Progress</small>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card bg-success text-white">
                <div class="card-body text-center">
                    <h3 class="mb-1">{{$stats['completed_requests']}}</h3>
                    <small>Completed</small>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card bg-danger text-white">
                <div class="card-body text-center">
                    <h3 class="mb-1">{{$stats['overdue_requests']}}</h3>
                    <small>Overdue</small>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            @permission('maintenance-view-reports')
            <a href="{{route('maintenance.reports')}}" class="card bg-dark text-white text-decoration-none">
                <div class="card-body text-center">
                    <h3 class="mb-1"><i class="fa fa-chart-bar"></i></h3>
                    <small>View Reports</small>
                </div>
            </a>
            @endpermission
        </div>
    </div>

    <!-- Filters -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="GET" action="{{route('maintenance.index')}}" class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Search</label>
                            <input type="text" name="search" class="form-control" placeholder="Request number, title, location..." value="{{request('search')}}">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-control">
                                <option value="">All Statuses</option>
                                <option value="pending" {{request('status') == 'pending' ? 'selected' : ''}}>Pending</option>
                                <option value="approved" {{request('status') == 'approved' ? 'selected' : ''}}>Approved</option>
                                <option value="in_progress" {{request('status') == 'in_progress' ? 'selected' : ''}}>In Progress</option>
                                <option value="completed" {{request('status') == 'completed' ? 'selected' : ''}}>Completed</option>
                                <option value="cancelled" {{request('status') == 'cancelled' ? 'selected' : ''}}>Cancelled</option>
                                <option value="rejected" {{request('status') == 'rejected' ? 'selected' : ''}}>Rejected</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Priority</label>
                            <select name="priority" class="form-control">
                                <option value="">All Priorities</option>
                                <option value="low" {{request('priority') == 'low' ? 'selected' : ''}}>Low</option>
                                <option value="medium" {{request('priority') == 'medium' ? 'selected' : ''}}>Medium</option>
                                <option value="high" {{request('priority') == 'high' ? 'selected' : ''}}>High</option>
                                <option value="critical" {{request('priority') == 'critical' ? 'selected' : ''}}>Critical</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Category</label>
                            <select name="category_id" class="form-control">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                <option value="{{$category->id}}" {{request('category_id') == $category->id ? 'selected' : ''}}>{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">Filter</button>
                                <a href="{{route('maintenance.index')}}" class="btn btn-secondary">Clear</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Maintenance Requests Table -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Request #</th>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Location</th>
                                    <th>Priority</th>
                                    <th>Status</th>
                                    <th>Requested By</th>
                                    <th>Date</th>
                                    <th>Due Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($requests as $request)
                                <tr>
                                    <td>
                                        <strong class="text-primary">{{$request->request_number ?? 'N/A'}}</strong>
                                    </td>
                                    <td>
                                        <a href="{{route('maintenance.show', $request)}}" class="text-decoration-none">
                                            {{$request->title ?? 'N/A'}}
                                        </a>
                                    </td>
                                    <td>
                                        @if($request->category)
                                        <span class="badge" style="background-color: {{$request->category->color}}; color: white;">
                                            {{$request->category->name}}
                                        </span>
                                        @else
                                        <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                    <td>{{$request->location ?? 'N/A'}}</td>
                                    <td>
                                        <span class="badge badge-{{$request->priority_badge_color}}">
                                            {{ucfirst($request->priority ?? 'N/A')}}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-{{$request->status_badge_color}}">
                                            {{ucfirst(str_replace('_', ' ', $request->status ?? 'N/A'))}}
                                        </span>
                                    </td>
                                    <td>{{$request->requestedBy->name ?? 'N/A'}}</td>
                                    <td>{{$request->requested_date ? $request->requested_date->format('M d, Y') : 'N/A'}}</td>
                                    <td>
                                        @if($request->required_completion_date)
                                            <span class="{{$request->is_overdue ? 'text-danger' : ''}}">
                                                {{$request->required_completion_date->format('M d, Y')}}
                                            </span>
                                            @if($request->is_overdue)
                                                <i class="fa fa-exclamation-triangle text-danger" title="Overdue"></i>
                                            @endif
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-light" type="button" data-toggle="dropdown">
                                                <i class="fa fa-ellipsis-v"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="{{route('maintenance.show', $request)}}">
                                                    <i class="fa fa-eye"></i> View
                                                </a>
                                                @permission('maintenance-edit-request')
                                                @if($request->status == 'pending' || $request->requested_by == auth()->id())
                                                <a class="dropdown-item" href="{{route('maintenance.edit', $request)}}">
                                                    <i class="fa fa-edit"></i> Edit
                                                </a>
                                                @endif
                                                @endpermission
                                                @permission('maintenance-approve-request')
                                                @if($request->status == 'pending')
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item text-success" href="#" onclick="approveRequest({{$request->id}})">
                                                    <i class="fa fa-check"></i> Approve
                                                </a>
                                                <a class="dropdown-item text-danger" href="#" onclick="rejectRequest({{$request->id}})">
                                                    <i class="fa fa-times"></i> Reject
                                                </a>
                                                @endif
                                                @endpermission
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="10" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="fa fa-wrench fa-3x mb-3"></i>
                                            <h5>No Maintenance Requests Found</h5>
                                            <p>No maintenance requests match your current filters.</p>
                                            @permission('maintenance-create-request')
                                            <a href="{{route('maintenance.create')}}" class="btn btn-primary">Create First Request</a>
                                            @endpermission
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    @if($requests->hasPages())
                    <div class="card-footer">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-muted">
                                Showing {{ $requests->firstItem() }} to {{ $requests->lastItem() }} of {{ $requests->total() }} results
                            </div>
                            <div>
                                {{$requests->appends(request()->query())->links()}}
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function approveRequest(requestId) {
    if (confirm('Are you sure you want to approve this maintenance request?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/maintenance/${requestId}/approve`;
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        form.appendChild(csrfToken);
        document.body.appendChild(form);
        form.submit();
    }
}

function rejectRequest(requestId) {
    const reason = prompt('Please provide a reason for rejection:');
    if (reason) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/maintenance/${requestId}/reject`;
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        const reasonInput = document.createElement('input');
        reasonInput.type = 'hidden';
        reasonInput.name = 'rejection_reason';
        reasonInput.value = reason;
        
        form.appendChild(csrfToken);
        form.appendChild(reasonInput);
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endsection
