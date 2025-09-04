@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="fas fa-edit"></i> Edit Designation
                    </h4>
                    <a href="{{ route('designations.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Designations
                    </a>
                </div>

                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('designations.update', $designation) }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name" class="required">Designation Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name', $designation->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="code" class="required">Designation Code</label>
                                    <input type="text" class="form-control @error('code') is-invalid @enderror" 
                                           id="code" name="code" value="{{ old('code', $designation->code) }}" 
                                           placeholder="e.g., MGR, DEV, HR" maxlength="10" required>
                                    @error('code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Maximum 10 characters. Will be converted to uppercase.</small>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="level">Level</label>
                                    <select class="form-control @error('level') is-invalid @enderror" 
                                            id="level" name="level">
                                        <option value="">Select Level</option>
                                        <option value="Entry" {{ old('level', $designation->level) == 'Entry' ? 'selected' : '' }}>Entry</option>
                                        <option value="Junior" {{ old('level', $designation->level) == 'Junior' ? 'selected' : '' }}>Junior</option>
                                        <option value="Mid" {{ old('level', $designation->level) == 'Mid' ? 'selected' : '' }}>Mid</option>
                                        <option value="Senior" {{ old('level', $designation->level) == 'Senior' ? 'selected' : '' }}>Senior</option>
                                        <option value="Lead" {{ old('level', $designation->level) == 'Lead' ? 'selected' : '' }}>Lead</option>
                                        <option value="Manager" {{ old('level', $designation->level) == 'Manager' ? 'selected' : '' }}>Manager</option>
                                        <option value="Director" {{ old('level', $designation->level) == 'Director' ? 'selected' : '' }}>Director</option>
                                        <option value="Executive" {{ old('level', $designation->level) == 'Executive' ? 'selected' : '' }}>Executive</option>
                                    </select>
                                    @error('level')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="3">{{ old('description', $designation->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" 
                                       {{ old('is_active', $designation->is_active) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="is_active">Active</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn me-2" 
                                    style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                                <i class="fas fa-save"></i> Update Designation
                            </button>
                            <a href="{{ route('designations.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    </form>

                    @if($designation->creator || $designation->updater)
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            @if($designation->creator)
                            <small class="text-muted">
                                <strong>Created by:</strong> {{ $designation->creator->name ?? 'Unknown' }}<br>
                                <strong>Created at:</strong> {{ $designation->created_at->format('M d, Y H:i') }}
                            </small>
                            @endif
                        </div>
                        <div class="col-md-6">
                            @if($designation->updater)
                            <small class="text-muted">
                                <strong>Last updated by:</strong> {{ $designation->updater->name ?? 'Unknown' }}<br>
                                <strong>Updated at:</strong> {{ $designation->updated_at->format('M d, Y H:i') }}
                            </small>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.required:after {
    content: " *";
    color: red;
}
</style>
@endsection
