@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="animated fadeIn">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('fixed-assets.index') }}">Fixed Assets</a></li>
                <li class="breadcrumb-item active" aria-current="page">Categories</li>
            </ol>
        </nav>

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0">Fixed Asset Categories</h5>
                    <small class="text-muted">Manage categories for organizing fixed assets</small>
                </div>
                <a href="{{ route('fixed-asset-categories.create') }}" class="btn btn-primary">
                    <svg class="c-icon mr-2">
                        <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-plus')}}"></use>
                    </svg>
                    Add Category
                </a>
            </div>
            <div class="card-body">
                @if(Session::has('success'))
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    {{ Session::get('success') }}
                </div>
                @endif

                @if(Session::has('error'))
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    {{ Session::get('error') }}
                </div>
                @endif

                @if($categories->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Category</th>
                                <th>Description</th>
                                <th>Assets Count</th>
                                <th>Depreciation Rate</th>
                                <th>Useful Life</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $category)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="color-indicator mr-3" 
                                             style="width: 20px; height: 20px; background-color: {{ $category->color }}; border-radius: 3px;">
                                        </div>
                                        <div>
                                            <strong>{{ $category->name }}</strong>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="text-muted">{{ $category->description ?: 'No description' }}</span>
                                </td>
                                <td>
                                    <span class="badge badge-info">{{ $category->assets_count }} assets</span>
                                </td>
                                <td>
                                    @if($category->depreciation_rate)
                                        {{ $category->depreciation_rate }}% per year
                                    @else
                                        <span class="text-muted">Not set</span>
                                    @endif
                                </td>
                                <td>
                                    @if($category->useful_life_years)
                                        {{ $category->useful_life_years }} years
                                    @else
                                        <span class="text-muted">Not set</span>
                                    @endif
                                </td>
                                <td>
                                    @if($category->active)
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-secondary">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('fixed-asset-categories.show', $category) }}" 
                                           class="btn btn-sm btn-outline-secondary" title="View">
                                            <svg class="c-icon">
                                                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-magnifying-glass')}}"></use>
                                            </svg>
                                        </a>
                                        <a href="{{ route('fixed-asset-categories.edit', $category) }}" 
                                           class="btn btn-sm btn-outline-secondary" title="Edit">
                                            <svg class="c-icon">
                                                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-pencil')}}"></use>
                                            </svg>
                                        </a>
                                        @if($category->assets_count == 0)
                                        <form method="POST" action="{{ route('fixed-asset-categories.destroy', $category) }}" 
                                              class="d-inline" onsubmit="return confirm('Are you sure you want to delete this category?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                                <svg class="c-icon">
                                                    <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-trash')}}"></use>
                                                </svg>
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center">
                    {{ $categories->links() }}
                </div>
                @else
                <div class="text-center py-5">
                    <svg class="c-icon c-icon-4xl text-muted mb-3">
                        <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-folder-open')}}"></use>
                    </svg>
                    <h5 class="text-muted">No Categories Found</h5>
                    <p class="text-muted">Start by creating your first fixed asset category.</p>
                    <a href="{{ route('fixed-asset-categories.create') }}" class="btn btn-primary">
                        Create First Category
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
