@extends('layouts.app')
@section('breadcrumb')
<div class="c-subheader px-3">
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Asset Management</li>
        <li class="breadcrumb-item"><a href="{{route('maintenance.index')}}">Maintenance</a></li>
        <li class="breadcrumb-item active">{{$request->request_number}}</li>
    </ol>
</div>
@endsection
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">{{$request->title}}</h4>
                    <div class="d-flex gap-2">
                        @permission('maintenance-edit-request')
                        @if($request->status == 'pending' || $request->requested_by == auth()->id())
                        <a href="{{route('maintenance.edit', $request)}}" class="btn btn-sm btn-primary">
                            <i class="fa fa-edit"></i> Edit
                        </a>
                        @endif
                        @endpermission
                        @permission('maintenance-approve-request')
                        @if($request->status == 'pending')
                        <button class="btn btn-sm btn-success" onclick="approveRequest({{$request->id}})">
                            <i class="fa fa-check"></i> Approve
                        </button>
                        <button class="btn btn-sm btn-danger" onclick="rejectRequest({{$request->id}})">
                            <i class="fa fa-times"></i> Reject
                        </button>
                        @endif
                        @endpermission
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Request Number:</strong><br>
                            <span class="text-primary">{{$request->request_number}}</span>
                        </div>
                        <div class="col-md-6">
                            <strong>Status:</strong><br>
                            <span class="badge badge-{{$request->status_badge_color}}">
                                {{ucfirst(str_replace('_', ' ', $request->status))}}
                            </span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Category:</strong><br>
                            @if($request->category)
                            <span class="badge" style="background-color: {{$request->category->color}}; color: white;">
                                {{$request->category->name}}
                            </span>
                            @else
                            <span class="text-muted">N/A</span>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <strong>Priority:</strong><br>
                            <span class="badge badge-{{$request->priority_badge_color}}">
                                {{ucfirst($request->priority)}}
                            </span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Location:</strong><br>
                            {{$request->location}}
                        </div>
                        <div class="col-md-6">
                            <strong>Requested By:</strong><br>
                            {{$request->requestedBy->name ?? 'N/A'}}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Requested Date:</strong><br>
                            {{$request->requested_date ? $request->requested_date->format('M d, Y') : 'N/A'}}
                        </div>
                        <div class="col-md-6">
                            <strong>Required Completion:</strong><br>
                            @if($request->required_completion_date)
                                <span class="{{$request->is_overdue ? 'text-danger' : ''}}">
                                    {{$request->required_completion_date->format('M d, Y')}}
                                </span>
                                @if($request->is_overdue)
                                    <i class="fa fa-exclamation-triangle text-danger" title="Overdue"></i>
                                @endif
                            @else
                                <span class="text-muted">Not specified</span>
                            @endif
                        </div>
                    </div>

                    @if($request->estimated_cost)
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Estimated Cost:</strong><br>
                            ${{number_format($request->estimated_cost, 2)}}
                        </div>
                    </div>
                    @endif

                    <div class="mb-3">
                        <strong>Description:</strong><br>
                        <div class="bg-light p-3 rounded">
                            {{$request->description}}
                        </div>
                    </div>

                    @if($request->notes)
                    <div class="mb-3">
                        <strong>Notes:</strong><br>
                        <div class="bg-light p-3 rounded">
                            {{$request->notes}}
                        </div>
                    </div>
                    @endif

                    @if($request->approved_by && $request->approved_at)
                    <div class="mb-3">
                        <strong>Approval Information:</strong><br>
                        <div class="bg-success bg-opacity-10 p-3 rounded border border-success">
                            <i class="fa fa-check-circle text-success"></i>
                            Approved by {{$request->approvedBy->name ?? 'N/A'}} on {{$request->approved_at->format('M d, Y \a\t g:i A')}}
                        </div>
                    </div>
                    @endif

                    @if($request->rejected_by && $request->rejected_at)
                    <div class="mb-3">
                        <strong>Rejection Information:</strong><br>
                        <div class="bg-danger bg-opacity-10 p-3 rounded border border-danger">
                            <i class="fa fa-times-circle text-danger"></i>
                            Rejected by {{$request->rejectedBy->name ?? 'N/A'}} on {{$request->rejected_at->format('M d, Y \a\t g:i A')}}
                            @if($request->rejection_reason)
                            <br><strong>Reason:</strong> {{$request->rejection_reason}}
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Work Orders Section -->
            @if($request->workOrders->count() > 0)
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0">Work Orders</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Work Order #</th>
                                    <th>Title</th>
                                    <th>Assigned To</th>
                                    <th>Status</th>
                                    <th>Priority</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($request->workOrders as $workOrder)
                                <tr>
                                    <td><strong class="text-primary">{{$workOrder->work_order_number}}</strong></td>
                                    <td>{{$workOrder->title}}</td>
                                    <td>{{$workOrder->assignedTechnician->name ?? 'Unassigned'}}</td>
                                    <td>
                                        <span class="badge badge-{{$workOrder->status_badge_color}}">
                                            {{ucfirst(str_replace('_', ' ', $workOrder->status))}}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-{{$workOrder->priority_badge_color}}">
                                            {{ucfirst($workOrder->priority)}}
                                        </span>
                                    </td>
                                    <td>{{$workOrder->created_at->format('M d, Y')}}</td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-outline-primary">View</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Quick Actions</h5>
                </div>
                <div class="card-body">
                    @permission('maintenance-create-work-order')
                    @if($request->status == 'approved')
                    <a href="#" class="btn btn-primary btn-block mb-2">
                        <i class="fa fa-plus"></i> Create Work Order
                    </a>
                    @endif
                    @endpermission
                    
                    <a href="{{route('maintenance.index')}}" class="btn btn-secondary btn-block mb-2">
                        <i class="fa fa-list"></i> Back to List
                    </a>
                    
                    @permission('maintenance-view-reports')
                    <a href="{{route('maintenance.reports')}}" class="btn btn-info btn-block">
                        <i class="fa fa-chart-bar"></i> View Reports
                    </a>
                    @endpermission
                </div>
            </div>

            <!-- Request Timeline -->
            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="mb-0">Timeline</h5>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-marker bg-primary"></div>
                            <div class="timeline-content">
                                <h6 class="mb-1">Request Created</h6>
                                <small class="text-muted">{{$request->created_at->format('M d, Y \a\t g:i A')}}</small>
                                <p class="mb-0">by {{$request->requestedBy->name ?? 'N/A'}}</p>
                            </div>
                        </div>

                        @if($request->approved_at)
                        <div class="timeline-item">
                            <div class="timeline-marker bg-success"></div>
                            <div class="timeline-content">
                                <h6 class="mb-1">Request Approved</h6>
                                <small class="text-muted">{{$request->approved_at->format('M d, Y \a\t g:i A')}}</small>
                                <p class="mb-0">by {{$request->approvedBy->name ?? 'N/A'}}</p>
                            </div>
                        </div>
                        @endif

                        @if($request->rejected_at)
                        <div class="timeline-item">
                            <div class="timeline-marker bg-danger"></div>
                            <div class="timeline-content">
                                <h6 class="mb-1">Request Rejected</h6>
                                <small class="text-muted">{{$request->rejected_at->format('M d, Y \a\t g:i A')}}</small>
                                <p class="mb-0">by {{$request->rejectedBy->name ?? 'N/A'}}</p>
                                @if($request->rejection_reason)
                                <p class="mb-0"><strong>Reason:</strong> {{$request->rejection_reason}}</p>
                                @endif
                            </div>
                        </div>
                        @endif

                        @foreach($request->workOrders as $workOrder)
                        <div class="timeline-item">
                            <div class="timeline-marker bg-info"></div>
                            <div class="timeline-content">
                                <h6 class="mb-1">Work Order Created</h6>
                                <small class="text-muted">{{$workOrder->created_at->format('M d, Y \a\t g:i A')}}</small>
                                <p class="mb-0">{{$workOrder->work_order_number}}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 15px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #dee2e6;
}

.timeline-item {
    position: relative;
    margin-bottom: 20px;
}

.timeline-marker {
    position: absolute;
    left: -22px;
    top: 0;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: 2px solid #fff;
}

.timeline-content {
    background: #f8f9fa;
    padding: 10px;
    border-radius: 4px;
    border-left: 3px solid #007bff;
}
</style>

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
