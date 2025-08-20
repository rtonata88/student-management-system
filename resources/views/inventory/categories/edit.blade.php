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
                <li class="breadcrumb-item active" aria-current="page">Edit {{ $category->name }}</li>
            </ol>
        </nav>

        <!-- Form -->
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">
                            <i class="fa fa-edit"></i> Edit Category
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('inventory-categories.update', $category) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="form-group">
                                <label for="name">Category Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name', $category->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                          id="description" name="description" rows="3">{{ old('description', $category->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="color">Category Color <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="color" class="form-control @error('color') is-invalid @enderror" 
                                           id="color" name="color" value="{{ old('color', $category->color) }}" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="fa fa-palette"></i>
                                        </span>
                                    </div>
                                </div>
                                @error('color')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="active" name="active" value="1" 
                                           {{ old('active', $category->active) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="active">
                                        Active Category
                                    </label>
                                </div>
                                <small class="form-text text-muted">Only active categories can be assigned to inventory items</small>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save"></i> Update Category
                                </button>
                                <a href="{{ route('inventory-categories.index') }}" class="btn btn-secondary">
                                    <i class="fa fa-times"></i> Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Preview Card -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Preview</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <span id="color-preview" class="badge mr-2" style="background-color: {{ $category->color }}; color: white; width: 20px; height: 20px; border-radius: 50%;"></span>
                            <span id="name-preview" class="font-weight-bold">{{ $category->name }}</span>
                        </div>
                        <p id="description-preview" class="text-muted">{{ $category->description ?: 'No description provided' }}</p>
                        <span id="status-preview" class="badge {{ $category->active ? 'badge-success' : 'badge-secondary' }}">
                            {{ $category->active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const nameInput = document.getElementById('name');
    const descriptionInput = document.getElementById('description');
    const colorInput = document.getElementById('color');
    const activeInput = document.getElementById('active');
    
    const namePreview = document.getElementById('name-preview');
    const descriptionPreview = document.getElementById('description-preview');
    const colorPreview = document.getElementById('color-preview');
    const statusPreview = document.getElementById('status-preview');
    
    function updatePreview() {
        namePreview.textContent = nameInput.value || 'Category Name';
        descriptionPreview.textContent = descriptionInput.value || 'No description provided';
        colorPreview.style.backgroundColor = colorInput.value;
        
        if (activeInput.checked) {
            statusPreview.textContent = 'Active';
            statusPreview.className = 'badge badge-success';
        } else {
            statusPreview.textContent = 'Inactive';
            statusPreview.className = 'badge badge-secondary';
        }
    }
    
    nameInput.addEventListener('input', updatePreview);
    descriptionInput.addEventListener('input', updatePreview);
    colorInput.addEventListener('input', updatePreview);
    activeInput.addEventListener('change', updatePreview);
});
</script>
@endsection
