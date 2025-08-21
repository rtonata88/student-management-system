@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">
                            <i class="fas fa-edit"></i> Edit Promotional Status
                        </h4>
                        <div class="card-header-actions">
                            <a href="{{ route('promotional-statuses.index') }}" class="btn btn-sm btn-outline-light">
                                <i class="fas fa-arrow-left"></i> Back to List
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('promotional-statuses.update', $promotionalStatus->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="promoted" class="form-control-label">Promoted (Yes/No) <span class="text-danger">*</span></label>
                                    <select name="promoted" id="promoted" class="form-control @error('promoted') is-invalid @enderror" required>
                                        <option value="">Select Promotion Status</option>
                                        <option value="Yes" {{ old('promoted', $promotionalStatus->promoted) == 'Yes' ? 'selected' : '' }}>Yes</option>
                                        <option value="No" {{ old('promoted', $promotionalStatus->promoted) == 'No' ? 'selected' : '' }}>No</option>
                                    </select>
                                    @error('promoted')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="description" class="form-control-label">Description <span class="text-danger">*</span></label>
                                    <input type="text" name="description" id="description" class="form-control @error('description') is-invalid @enderror" 
                                           value="{{ old('description', $promotionalStatus->description) }}" maxlength="255" required placeholder="e.g., Pass First Year, Graduated - Course completion">
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="active" class="form-control-label">Active</label>
                                    <div class="form-check">
                                        <input type="checkbox" name="active" id="active" class="form-check-input" value="1" {{ old('active', $promotionalStatus->active) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="active">
                                            Active
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none;">
                                <i class="fas fa-save"></i> Update Promotional Status
                            </button>
                            <a href="{{ route('promotional-statuses.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
