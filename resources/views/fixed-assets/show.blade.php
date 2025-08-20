@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="animated fadeIn">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('fixed-assets.index') }}">Fixed Assets</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $asset->asset_tag }}</li>
            </ol>
        </nav>

        <div class="row">
            <!-- Asset Details Card -->
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-0">{{ $asset->name }}</h5>
                            <small class="text-muted">Asset Tag: {{ $asset->asset_tag }}</small>
                        </div>
                        <div class="btn-group" role="group">
                            @permission('fixed-assets-edit')
                            <a href="{{ route('fixed-assets.edit', $asset) }}" class="btn btn-outline-primary">
                                <svg class="c-icon mr-2">
                                    <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-pencil')}}"></use>
                                </svg>
                                Edit Asset
                            </a>
                            @endpermission
                            @permission('fixed-assets-maintenance')
                            <a href="{{ route('fixed-assets.schedule-maintenance', $asset) }}" class="btn btn-outline-secondary">
                                <svg class="c-icon mr-2">
                                    <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-settings')}}"></use>
                                </svg>
                                Schedule Maintenance
                            </a>
                            @endpermission
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Basic Information -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h6 class="text-muted">Basic Information</h6>
                                <table class="table table-sm">
                                    <tr>
                                        <td><strong>Category:</strong></td>
                                        <td>
                                            <span class="badge badge-light" style="background-color: {{ $asset->category->color }}20; color: {{ $asset->category->color }};">
                                                {{ $asset->category->name }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Brand:</strong></td>
                                        <td>{{ $asset->brand ?: 'Not specified' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Model:</strong></td>
                                        <td>{{ $asset->model ?: 'Not specified' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Serial Number:</strong></td>
                                        <td>{{ $asset->serial_number ?: 'Not specified' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Supplier:</strong></td>
                                        <td>{{ $asset->supplier ?: 'Not specified' }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-muted">Status & Condition</h6>
                                <table class="table table-sm">
                                    <tr>
                                        <td><strong>Status:</strong></td>
                                        <td>
                                            <span class="badge badge-{{ $asset->status_badge_color }}">
                                                {{ ucfirst($asset->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Condition:</strong></td>
                                        <td>
                                            <span class="badge badge-{{ $asset->condition_badge_color }}">
                                                {{ ucfirst($asset->condition) }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Location:</strong></td>
                                        <td>{{ $asset->location }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Department:</strong></td>
                                        <td>{{ $asset->department ?: 'Not assigned' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Assigned To:</strong></td>
                                        <td>{{ $asset->assigned_to ?: 'Not assigned' }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        @if($asset->description)
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-muted">Description</h6>
                                <p>{{ $asset->description }}</p>
                            </div>
                        </div>
                        @endif

                        <!-- Financial Information -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h6 class="text-muted">Financial Information</h6>
                                <table class="table table-sm">
                                    <tr>
                                        <td><strong>Purchase Cost:</strong></td>
                                        <td>${{ number_format($asset->purchase_cost, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Purchase Date:</strong></td>
                                        <td>{{ $asset->purchase_date ? \Carbon\Carbon::parse($asset->purchase_date)->format('M d, Y') : 'Not specified' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Current Value:</strong></td>
                                        <td>{{ $asset->current_value ? '$' . number_format($asset->current_value, 2) : 'Not set' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Book Value:</strong></td>
                                        <td>${{ number_format($asset->book_value, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Depreciation:</strong></td>
                                        <td>
                                            <span class="badge badge-{{ $asset->depreciation_status_color }}">
                                                {{ $asset->depreciation_status }}
                                            </span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-muted">Warranty Information</h6>
                                <table class="table table-sm">
                                    <tr>
                                        <td><strong>Warranty Start:</strong></td>
                                        <td>{{ $asset->warranty_start_date ? \Carbon\Carbon::parse($asset->warranty_start_date)->format('M d, Y') : 'Not specified' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Warranty End:</strong></td>
                                        <td>{{ $asset->warranty_end_date ? \Carbon\Carbon::parse($asset->warranty_end_date)->format('M d, Y') : 'Not specified' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Warranty Status:</strong></td>
                                        <td>
                                            @if($asset->is_warranty_expired)
                                                <span class="badge badge-danger">Expired</span>
                                            @elseif($asset->is_warranty_expiring_soon)
                                                <span class="badge badge-warning">Expiring Soon</span>
                                            @elseif($asset->warranty_end_date)
                                                <span class="badge badge-success">Active</span>
                                            @else
                                                <span class="badge badge-secondary">Not Set</span>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                                @if($asset->warranty_details)
                                <div class="mt-2">
                                    <small class="text-muted">{{ $asset->warranty_details }}</small>
                                </div>
                                @endif
                            </div>
                        </div>

                        @if($asset->notes)
                        <div class="row">
                            <div class="col-12">
                                <h6 class="text-muted">Notes</h6>
                                <p>{{ $asset->notes }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Maintenance History -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Maintenance History</h6>
                        @permission('fixed-assets-maintenance')
                        <a href="{{ route('fixed-assets.schedule-maintenance', $asset) }}" class="btn btn-sm btn-primary">
                            <svg class="c-icon">
                                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-plus')}}"></use>
                            </svg>
                        </a>
                        @endpermission
                    </div>
                    <div class="card-body">
                        @if($asset->maintenanceRecords->count() > 0)
                        <div class="timeline">
                            @foreach($asset->maintenanceRecords->sortByDesc('date') as $maintenance)
                            <div class="timeline-item mb-3">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <span class="badge badge-{{ $maintenance->type_badge_color }} mb-1">
                                            {{ ucfirst($maintenance->type) }}
                                        </span>
                                        <h6 class="mb-1">{{ $maintenance->description }}</h6>
                                        <small class="text-muted">
                                            {{ \Carbon\Carbon::parse($maintenance->date)->format('M d, Y') }}
                                            @if($maintenance->performed_by)
                                                • {{ $maintenance->performed_by }}
                                            @endif
                                        </small>
                                        @if($maintenance->cost)
                                        <div class="mt-1">
                                            <small class="text-success">${{ number_format($maintenance->cost, 2) }}</small>
                                        </div>
                                        @endif
                                    </div>
                                    <span class="badge badge-{{ $maintenance->status_badge_color }}">
                                        {{ ucfirst($maintenance->status) }}
                                    </span>
                                </div>
                                @if($maintenance->notes)
                                <p class="small text-muted mt-2 mb-0">{{ $maintenance->notes }}</p>
                                @endif
                            </div>
                            @endforeach
                        </div>
                        @else
                        <div class="text-center py-3">
                            <svg class="c-icon c-icon-2xl text-muted mb-2">
                                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-settings')}}"></use>
                            </svg>
                            <p class="text-muted mb-0">No maintenance records</p>
                        </div>
                        @endif

                        <!-- Maintenance Schedule -->
                        @if($asset->last_maintenance_date || $asset->next_maintenance_date)
                        <hr>
                        <h6 class="text-muted mb-2">Maintenance Schedule</h6>
                        @if($asset->last_maintenance_date)
                        <div class="d-flex justify-content-between">
                            <small class="text-muted">Last Maintenance:</small>
                            <small>{{ \Carbon\Carbon::parse($asset->last_maintenance_date)->format('M d, Y') }}</small>
                        </div>
                        @endif
                        @if($asset->next_maintenance_date)
                        <div class="d-flex justify-content-between">
                            <small class="text-muted">Next Maintenance:</small>
                            <small class="{{ $asset->is_maintenance_due ? 'text-danger' : 'text-success' }}">
                                {{ \Carbon\Carbon::parse($asset->next_maintenance_date)->format('M d, Y') }}
                                @if($asset->is_maintenance_due)
                                    <span class="badge badge-warning ml-1">Due</span>
                                @endif
                            </small>
                        </div>
                        @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
