@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="animated fadeIn">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('inventories.index') }}">Inventory</a></li>
                <li class="breadcrumb-item"><a href="{{ route('inventory-categories.index') }}">Categories</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $category->name }}</li>
            </ol>
        </nav>

        <!-- Category Details -->
        <div class="row">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Category Details</h5>
                        <div class="btn-group">
                            <a href="{{ route('inventory-categories.edit', $category) }}" class="btn btn-sm btn-primary">
                                <i class="fa fa-edit"></i> Edit
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <span class="badge mr-3" style="background-color: {{ $category->color }}; color: white; width: 30px; height: 30px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                <i class="fa fa-tag"></i>
                            </span>
                            <div>
                                <h5 class="mb-0">{{ $category->name }}</h5>
                                <span class="badge {{ $category->active ? 'badge-success' : 'badge-secondary' }}">
                                    {{ $category->active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                        </div>

                        @if($category->description)
                        <div class="mb-3">
                            <strong>Description:</strong>
                            <p class="text-muted mb-0">{{ $category->description }}</p>
                        </div>
                        @endif

                        <div class="row text-center">
                            <div class="col-6">
                                <div class="border-right">
                                    <h4 class="text-primary">{{ $category->items_count }}</h4>
                                    <small class="text-muted">Total Items</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <h4 class="text-success">${{ number_format($category->total_value, 2) }}</h4>
                                <small class="text-muted">Total Value</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Items in Category -->
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Items in {{ $category->name }}</h5>
                        <a href="{{ route('inventories.create', ['category' => $category->id]) }}" class="btn btn-sm btn-success">
                            <i class="fa fa-plus"></i> Add Item
                        </a>
                    </div>
                    <div class="card-body">
                        @if($category->items->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Item Code</th>
                                        <th>Name</th>
                                        <th>Stock</th>
                                        <th>Unit Cost</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($category->items as $item)
                                    <tr>
                                        <td><strong>{{ $item->item_code }}</strong></td>
                                        <td>
                                            <div>
                                                <strong>{{ $item->name }}</strong>
                                                @if($item->description)
                                                <br><small class="text-muted">{{ \Illuminate\Support\Str::limit($item->description, 40) }}</small>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <strong>{{ $item->current_stock }} {{ $item->unit_of_measure }}</strong>
                                                @if($item->current_stock <= $item->minimum_stock)
                                                <br><small class="text-danger">Low Stock</small>
                                                @endif
                                            </div>
                                        </td>
                                        <td>${{ number_format($item->unit_cost, 2) }}</td>
                                        <td>
                                            @if($item->status === 'active')
                                                <span class="badge badge-success">Active</span>
                                            @elseif($item->status === 'inactive')
                                                <span class="badge badge-secondary">Inactive</span>
                                            @else
                                                <span class="badge badge-warning">{{ ucfirst($item->status) }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('inventories.show', $item) }}" class="btn btn-sm btn-outline-info" title="View">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a href="{{ route('inventories.edit', $item) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="text-center py-4">
                            <i class="fa fa-box-open fa-3x text-muted mb-3"></i>
                            <h6 class="text-muted">No Items in This Category</h6>
                            <p class="text-muted">Add inventory items to this category to get started.</p>
                            <a href="{{ route('inventories.create', ['category' => $category->id]) }}" class="btn btn-primary">
                                <i class="fa fa-plus"></i> Add First Item
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
