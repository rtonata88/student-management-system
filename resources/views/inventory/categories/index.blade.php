@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="animated fadeIn">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('inventories.index') }}">Inventory</a></li>
                <li class="breadcrumb-item active" aria-current="page">Categories</li>
            </ol>
        </nav>

        <!-- Header -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">
                            <svg class="c-icon c-icon-lg mr-2">
                                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-tags')}}"></use>
                            </svg>
                            Inventory Categories
                        </h4>
                        <a href="{{ route('inventory-categories.create') }}" 
                           class="btn btn-sm"
                           style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                            <svg class="c-icon mr-2">
                                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-plus')}}"></use>
                            </svg>
                            Add Category
                        </a>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        @if($categories->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Category</th>
                                        <th>Description</th>
                                        <th>Items Count</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($categories as $category)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <span class="badge mr-2" style="background-color: {{ $category->color }}; color: white; width: 20px; height: 20px; border-radius: 50%;"></span>
                                                <strong>{{ $category->name }}</strong>
                                            </div>
                                        </td>
                                        <td>
                                            @if($category->description)
                                                {{ \Illuminate\Support\Str::limit($category->description, 60) }}
                                            @else
                                                <span class="text-muted">No description</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge badge-info">{{ $category->items_count }} items</span>
                                        </td>
                                        <td>
                                            @if($category->active)
                                                <span class="badge badge-success">Active</span>
                                            @else
                                                <span class="badge badge-secondary">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div>
                                                <a href="{{ route('inventory-categories.show', $category) }}" 
                                                   class="btn btn-sm me-2" 
                                                   style="background: linear-gradient(135deg, #17a2b8 0%, #138496 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;" 
                                                   title="View">
                                                    <svg class="c-icon">
                                                        <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-magnifying-glass')}}"></use>
                                                    </svg>
                                                </a>
                                                <a href="{{ route('inventory-categories.edit', $category) }}" 
                                                   class="btn btn-sm me-2" 
                                                   style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;" 
                                                   title="Edit">
                                                    <svg class="c-icon">
                                                        <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-pencil')}}"></use>
                                                    </svg>
                                                </a>
                                                @if($category->items_count == 0)
                                                <form action="{{ route('inventory-categories.destroy', $category) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Are you sure you want to delete this category?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                                        <svg class="c-icon">
                                                            <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-trash')}}"></use>
                                                        </svg>
                                                    </button>
                                                </form>
                                                @else
                                                <button class="btn btn-sm btn-secondary" disabled title="Cannot delete category with items">
                                                    <svg class="c-icon">
                                                        <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-trash')}}"></use>
                                                    </svg>
                                                </button>
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
                            <i class="fa fa-tags fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No Categories Found</h5>
                            <p class="text-muted">Start by creating your first inventory category.</p>
                            <a href="{{ route('inventory-categories.create') }}" 
                               class="btn btn-sm"
                               style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                                <i class="fa fa-plus"></i> Create Category
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
