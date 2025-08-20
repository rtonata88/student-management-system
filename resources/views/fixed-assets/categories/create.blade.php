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
                <li class="breadcrumb-item active" aria-current="page">Add Category</li>
            </ol>
        </nav>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Add New Category</h5>
                <small class="text-muted">Create a new fixed asset category</small>
            </div>
            <div class="card-body">
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form method="POST" action="{{ route('fixed-asset-categories.store') }}">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Category Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" 
                                       value="{{ old('name') }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="color">Category Color <span class="text-danger">*</span></label>
                                <input type="color" class="form-control" id="color" name="color" 
                                       value="{{ old('color', '#007bff') }}" required>
                                <small class="form-text text-muted">Choose a color to identify this category</small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="depreciation_rate">Depreciation Rate (%)</label>
                                <input type="number" class="form-control" id="depreciation_rate" name="depreciation_rate" 
                                       step="0.01" min="0" max="100" value="{{ old('depreciation_rate') }}">
                                <small class="form-text text-muted">Annual depreciation rate percentage</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="useful_life_years">Useful Life (Years)</label>
                                <input type="number" class="form-control" id="useful_life_years" name="useful_life_years" 
                                       min="1" max="50" value="{{ old('useful_life_years') }}">
                                <small class="form-text text-muted">Expected useful life in years</small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="active" name="active" value="1" 
                                           {{ old('active', true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="active">
                                        Active Category
                                    </label>
                                    <small class="form-text text-muted">Only active categories can be assigned to new assets</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="form-group mt-4">
                        <button type="submit" class="btn btn-primary">
                            <svg class="c-icon mr-2">
                                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-save')}}"></use>
                            </svg>
                            Save Category
                        </button>
                        <a href="{{ route('fixed-asset-categories.index') }}" class="btn btn-secondary ml-2">
                            <svg class="c-icon mr-2">
                                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-x')}}"></use>
                            </svg>
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
