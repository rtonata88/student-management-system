@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="animated fadeIn">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Fixed Assets</li>
            </ol>
        </nav>

        <!-- Dashboard Statistics -->
        <div class="row mb-4">
            <div class="col-md-2 col-sm-6 mb-3">
                <div class="card text-white bg-primary">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <div class="h4 mb-0">{{ $stats['total_assets'] }}</div>
                                <div class="small">Total Assets</div>
                            </div>
                            <svg class="c-icon c-icon-xl">
                                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-briefcase')}}"></use>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-sm-6 mb-3">
                <div class="card text-white bg-success">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <div class="h4 mb-0">{{ $stats['active_assets'] }}</div>
                                <div class="small">Active Assets</div>
                            </div>
                            <svg class="c-icon c-icon-xl">
                                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-check')}}"></use>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-sm-6 mb-3">
                <div class="card text-white bg-warning">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <div class="h4 mb-0">{{ $stats['maintenance_due'] }}</div>
                                <div class="small">Maintenance Due</div>
                            </div>
                            <svg class="c-icon c-icon-xl">
                                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-settings')}}"></use>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-sm-6 mb-3">
                <div class="card text-white bg-danger">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <div class="h4 mb-0">{{ $stats['warranty_expired'] }}</div>
                                <div class="small">Warranty Expired</div>
                            </div>
                            <svg class="c-icon c-icon-xl">
                                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-clock')}}"></use>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-6 mb-3">
                <div class="card text-white bg-info">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <div class="h4 mb-0">${{ number_format($stats['total_value'], 2) }}</div>
                                <div class="small">Total Asset Value</div>
                            </div>
                            <svg class="c-icon c-icon-xl">
                                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-dollar')}}"></use>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0">Fixed Assets Management</h5>
                    <small class="text-muted">Manage school fixed assets, maintenance, and tracking</small>
                </div>
                <div class="btn-toolbar" role="toolbar">
                    <div class="btn-group mr-2" role="group">
                        <a href="{{ route('fixed-asset-categories.index') }}" class="btn btn-outline-secondary">
                            <svg class="c-icon mr-2">
                                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-folder-open')}}"></use>
                            </svg>
                            Categories
                        </a>
                        <a href="{{ route('fixed-assets.create') }}" class="btn btn-primary">
                            <svg class="c-icon mr-2">
                                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-plus')}}"></use>
                            </svg>
                            Add Asset
                        </a>
                    </div>
                    <div class="btn-group" role="group">
                        <a href="{{ route('fixed-assets.maintenance-due') }}" class="btn btn-outline-secondary">
                            <svg class="c-icon mr-2">
                                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-settings')}}"></use>
                            </svg>
                            Maintenance Due
                        </a>
                        <a href="{{ route('fixed-assets.warranty-expired') }}" class="btn btn-outline-secondary">
                            <svg class="c-icon mr-2">
                                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-clock')}}"></use>
                            </svg>
                            Warranty Expired
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if(Session::has('message'))
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    {{ Session::get('message') }}
                </div>
                @endif

                <!-- Search and Filter Form -->
                <form method="GET" action="{{ route('fixed-assets.index') }}" class="mb-4">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <div class="input-group">
                                <input type="text" class="form-control" name="search" 
                                       placeholder="Search assets..." 
                                       value="{{ request('search') }}">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-primary" type="submit">
                                        <svg class="c-icon">
                                            <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-search')}}"></use>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 mb-3">
                            <select name="category" class="form-control">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2 mb-3">
                            <select name="status" class="form-control">
                                <option value="">All Status</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                <option value="maintenance" {{ request('status') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                                <option value="disposed" {{ request('status') == 'disposed' ? 'selected' : '' }}>Disposed</option>
                            </select>
                        </div>
                        <div class="col-md-2 mb-3">
                            <select name="condition" class="form-control">
                                <option value="">All Conditions</option>
                                <option value="excellent" {{ request('condition') == 'excellent' ? 'selected' : '' }}>Excellent</option>
                                <option value="good" {{ request('condition') == 'good' ? 'selected' : '' }}>Good</option>
                                <option value="fair" {{ request('condition') == 'fair' ? 'selected' : '' }}>Fair</option>
                                <option value="poor" {{ request('condition') == 'poor' ? 'selected' : '' }}>Poor</option>
                                <option value="damaged" {{ request('condition') == 'damaged' ? 'selected' : '' }}>Damaged</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">Filter</button>
                                <a href="{{ route('fixed-assets.index') }}" class="btn btn-outline-secondary">Clear</a>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Results Summary -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <small class="text-muted">
                            Showing {{ $assets->firstItem() ?? 0 }} to {{ $assets->lastItem() ?? 0 }} 
                            of {{ $assets->total() }} assets
                        </small>
                    </div>
                </div>

                <!-- Assets Table -->
                @if($assets->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Asset Tag</th>
                                <th>Asset Name</th>
                                <th>Category</th>
                                <th>Location</th>
                                <th>Purchase Cost</th>
                                <th>Current Value</th>
                                <th>Status</th>
                                <th>Condition</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($assets as $asset)
                            <tr>
                                <td>
                                    <strong>{{ $asset->asset_tag }}</strong>
                                </td>
                                <td>
                                    <div>
                                        <strong>{{ $asset->name }}</strong>
                                        @if($asset->brand || $asset->model)
                                        <br><small class="text-muted">{{ $asset->brand }} {{ $asset->model }}</small>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <span class="badge badge-light">
                                        {{ $asset->category->name }}
                                    </span>
                                </td>
                                <td>
                                    <div>
                                        <strong>{{ $asset->location }}</strong>
                                        @if($asset->department)
                                        <br><small class="text-muted">{{ $asset->department }}</small>
                                        @endif
                                    </div>
                                </td>
                                <td>${{ number_format($asset->purchase_cost, 2) }}</td>
                                <td>
                                    @if($asset->current_value)
                                    <strong>${{ number_format($asset->current_value, 2) }}</strong>
                                    @else
                                    <span class="text-muted">Not set</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge badge-{{ $asset->status_badge_color }}">
                                        {{ ucfirst($asset->status) }}
                                    </span>
                                    @if($asset->is_maintenance_due)
                                    <br><span class="badge badge-warning">Maintenance Due</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge badge-{{ $asset->condition_badge_color }}">
                                        {{ ucfirst($asset->condition) }}
                                    </span>
                                    @if($asset->is_warranty_expired)
                                    <br><span class="badge badge-danger">Warranty Expired</span>
                                    @elseif($asset->is_warranty_expiring_soon)
                                    <br><span class="badge badge-warning">Warranty Expiring</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('fixed-assets.show', $asset) }}" class="btn btn-sm btn-outline-secondary" title="View">
                                            <svg class="c-icon">
                                                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-magnifying-glass')}}"></use>
                                            </svg>
                                        </a>
                                        <a href="{{ route('fixed-assets.edit', $asset) }}" class="btn btn-sm btn-outline-secondary" title="Edit">
                                            <svg class="c-icon">
                                                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-pencil')}}"></use>
                                            </svg>
                                        </a>
                                        <a href="{{ route('fixed-assets.schedule-maintenance', $asset) }}" class="btn btn-sm btn-outline-secondary" title="Schedule Maintenance">
                                            <svg class="c-icon">
                                                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-settings')}}"></use>
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center">
                    {{ $assets->appends(request()->query())->links() }}
                </div>
                @else
                <div class="text-center py-5">
                    <svg class="c-icon c-icon-4xl text-muted mb-3">
                        <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-briefcase')}}"></use>
                    </svg>
                    <h5 class="text-muted">No Fixed Assets Found</h5>
                    <p class="text-muted">
                        @if(request()->hasAny(['search', 'category', 'status', 'condition']))
                            No assets match your search criteria. Try adjusting your filters.
                        @else
                            Start by adding your first fixed asset to the system.
                        @endif
                    </p>
                    @if(request()->hasAny(['search', 'category', 'status', 'condition']))
                    <a href="{{ route('fixed-assets.index') }}" class="btn btn-outline-primary">
                        Clear Filters
                    </a>
                    @else
                    <a href="{{ route('fixed-assets.create') }}" class="btn btn-primary">
                        Add First Asset
                    </a>
                    @endif
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
