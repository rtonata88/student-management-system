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
            <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
                <div class="stats-card stats-card-purple">
                    <div class="stats-card-body">
                        <div class="stats-number">{{ $stats['total_assets'] }}</div>
                        <div class="stats-label">Total Assets</div>
                        <div class="stats-icon">
                            <i class="fas fa-briefcase"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
                <div class="stats-card stats-card-green">
                    <div class="stats-card-body">
                        <div class="stats-number">{{ $stats['active_assets'] }}</div>
                        <div class="stats-label">Active Assets</div>
                        <div class="stats-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
                <div class="stats-card stats-card-orange">
                    <div class="stats-card-body">
                        <div class="stats-number">{{ $stats['maintenance_due'] }}</div>
                        <div class="stats-label">Maintenance Due</div>
                        <div class="stats-icon">
                            <i class="fas fa-cog"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
                <div class="stats-card stats-card-red">
                    <div class="stats-card-body">
                        <div class="stats-number">{{ $stats['warranty_expired'] }}</div>
                        <div class="stats-label">Warranty Expired</div>
                        <div class="stats-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-8 col-sm-12 mb-3">
                <div class="stats-card stats-card-blue">
                    <div class="stats-card-body">
                        <div class="stats-number">${{ number_format($stats['total_value'], 0) }}</div>
                        <div class="stats-label">Total Asset Value</div>
                        <div class="stats-icon">
                            <i class="fas fa-dollar-sign"></i>
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
                        <a href="{{ route('fixed-asset-categories.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-folder-open mr-2"></i>
                            Categories
                        </a>
                        <a href="{{ route('fixed-assets.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus mr-2"></i>
                            Add Asset
                        </a>
                    </div>
                    <div class="btn-group" role="group">
                        <a href="{{ route('fixed-assets.maintenance-due') }}" class="btn btn-outline-primary">
                            <i class="fas fa-cog mr-2"></i>
                            Maintenance Due
                        </a>
                        <a href="{{ route('fixed-assets.warranty-expired') }}" class="btn btn-outline-primary">
                            <i class="fas fa-clock mr-2"></i>
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
                                        <i class="fas fa-search"></i>
                                        <span class="ml-1">Search</span>
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
                                <a href="{{ route('fixed-assets.index') }}" class="btn btn-outline-primary">Clear</a>
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
                                        <strong>{{ preg_replace('/\s+\d+$/', '', $asset->location) }}</strong>
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
                                        <a href="{{ route('fixed-assets.show', $asset) }}" class="btn btn-sm btn-outline-primary" title="View">
                                            <i class="fas fa-eye"></i>
                                            <span class="d-none d-md-inline ml-1">View</span>
                                        </a>
                                        <a href="{{ route('fixed-assets.edit', $asset) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                            <i class="fas fa-edit"></i>
                                            <span class="d-none d-md-inline ml-1">Edit</span>
                                        </a>
                                        <a href="{{ route('fixed-assets.schedule-maintenance', $asset) }}" class="btn btn-sm btn-outline-primary" title="Schedule Maintenance">
                                            <i class="fas fa-cog"></i>
                                            <span class="d-none d-md-inline ml-1">Maintenance</span>
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

<style>
/* Modern Stats Cards */
.stats-card {
    border-radius: 16px;
    border: none;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    overflow: hidden;
    transition: all 0.3s ease;
    position: relative;
    height: 120px;
}

.stats-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
}

.stats-card-body {
    padding: 24px;
    position: relative;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.stats-number {
    font-size: 2.5rem;
    font-weight: 700;
    color: white;
    margin-bottom: 4px;
    line-height: 1;
}

.stats-label {
    font-size: 0.875rem;
    color: rgba(255, 255, 255, 0.9);
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.stats-icon {
    position: absolute;
    top: 20px;
    right: 20px;
    font-size: 1.5rem;
    color: rgba(255, 255, 255, 0.3);
}

/* Card Color Variants */
.stats-card-purple {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.stats-card-green {
    background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
}

.stats-card-orange {
    background: linear-gradient(135deg, #ff9800 0%, #f57c00 100%);
}

.stats-card-red {
    background: linear-gradient(135deg, #ff5722 0%, #e64a19 100%);
}

.stats-card-blue {
    background: linear-gradient(135deg, #2196F3 0%, #1976D2 100%);
}

/* Standard gradient button styling */
:root {
    --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --primary-color: #667eea;
}

.btn-primary {
    background: var(--primary-gradient) !important;
    border: none !important;
    color: white !important;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
    color: white !important;
}

.btn-outline-primary {
    border: 2px solid var(--primary-color) !important;
    color: var(--primary-color) !important;
    background: transparent !important;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-outline-primary:hover {
    background: var(--primary-gradient) !important;
    border-color: transparent !important;
    color: white !important;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
}

/* Small button variants */
.btn-sm.btn-outline-primary {
    border-width: 1px !important;
}

.btn-sm.btn-outline-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);
}

/* Input group button styling */
.input-group-append .btn-outline-primary {
    border-left: none !important;
    border-top-left-radius: 0 !important;
    border-bottom-left-radius: 0 !important;
}

/* Button group spacing */
.d-flex.gap-2 > * {
    margin-right: 0.5rem;
}

.d-flex.gap-2 > *:last-child {
    margin-right: 0;
}
</style>
