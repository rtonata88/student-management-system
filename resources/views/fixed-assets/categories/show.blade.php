@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="animated fadeIn">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('fixed-assets.index') }}">Fixed Assets</a></li>
                <li class="breadcrumb-item"><a href="{{ route('fixed-asset-categories.index') }}">Categories</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $fixedAssetCategory->name }}</li>
            </ol>
        </nav>

        <div class="row">
            <!-- Category Details -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Category Details</h5>
                        <a href="{{ route('fixed-asset-categories.edit', $fixedAssetCategory) }}" class="btn btn-outline-primary btn-sm">
                            <svg class="c-icon">
                                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-pencil')}}"></use>
                            </svg>
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="color-indicator mr-3" 
                                 style="width: 30px; height: 30px; background-color: {{ $fixedAssetCategory->color }}; border-radius: 5px;">
                            </div>
                            <div>
                                <h6 class="mb-0">{{ $fixedAssetCategory->name }}</h6>
                                <small class="text-muted">
                                    @if($fixedAssetCategory->active)
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-secondary">Inactive</span>
                                    @endif
                                </small>
                            </div>
                        </div>

                        @if($fixedAssetCategory->description)
                        <div class="mb-3">
                            <h6 class="text-muted">Description</h6>
                            <p>{{ $fixedAssetCategory->description }}</p>
                        </div>
                        @endif

                        <div class="row">
                            <div class="col-6">
                                <h6 class="text-muted">Depreciation Rate</h6>
                                <p class="mb-0">
                                    @if($fixedAssetCategory->depreciation_rate)
                                        {{ $fixedAssetCategory->depreciation_rate }}% per year
                                    @else
                                        <span class="text-muted">Not set</span>
                                    @endif
                                </p>
                            </div>
                            <div class="col-6">
                                <h6 class="text-muted">Useful Life</h6>
                                <p class="mb-0">
                                    @if($fixedAssetCategory->useful_life_years)
                                        {{ $fixedAssetCategory->useful_life_years }} years
                                    @else
                                        <span class="text-muted">Not set</span>
                                    @endif
                                </p>
                            </div>
                        </div>

                        <hr>

                        <div class="row text-center">
                            <div class="col-4">
                                <div class="h4 mb-0 text-primary">{{ $fixedAssetCategory->total_assets }}</div>
                                <small class="text-muted">Total Assets</small>
                            </div>
                            <div class="col-4">
                                <div class="h4 mb-0 text-success">{{ $fixedAssetCategory->active_assets_count }}</div>
                                <small class="text-muted">Active Assets</small>
                            </div>
                            <div class="col-4">
                                <div class="h4 mb-0 text-info">${{ number_format($fixedAssetCategory->total_value, 0) }}</div>
                                <small class="text-muted">Total Value</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Assets in Category -->
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-0">Assets in Category</h5>
                            <small class="text-muted">{{ $fixedAssetCategory->assets->count() }} assets found</small>
                        </div>
                        <a href="{{ route('fixed-assets.create') }}?category={{ $fixedAssetCategory->id }}" class="btn btn-primary btn-sm">
                            <svg class="c-icon mr-2">
                                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-plus')}}"></use>
                            </svg>
                            Add Asset
                        </a>
                    </div>
                    <div class="card-body">
                        @if($fixedAssetCategory->assets->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Asset Tag</th>
                                        <th>Name</th>
                                        <th>Location</th>
                                        <th>Purchase Cost</th>
                                        <th>Status</th>
                                        <th>Condition</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($fixedAssetCategory->assets->sortBy('asset_tag') as $asset)
                                    <tr>
                                        <td><strong>{{ $asset->asset_tag }}</strong></td>
                                        <td>
                                            <div>
                                                <strong>{{ $asset->name }}</strong>
                                                @if($asset->brand || $asset->model)
                                                <br><small class="text-muted">{{ $asset->brand }} {{ $asset->model }}</small>
                                                @endif
                                            </div>
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
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="text-center py-5">
                            <svg class="c-icon c-icon-4xl text-muted mb-3">
                                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-briefcase')}}"></use>
                            </svg>
                            <h5 class="text-muted">No Assets in Category</h5>
                            <p class="text-muted">Start by adding your first asset to this category.</p>
                            <a href="{{ route('fixed-assets.create') }}?category={{ $fixedAssetCategory->id }}" class="btn btn-primary">
                                Add First Asset
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
