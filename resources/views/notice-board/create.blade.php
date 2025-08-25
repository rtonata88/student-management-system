@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><i class="fas fa-plus"></i> Create Staff Notice</h4>
                    <a href="{{ route('notice-board.index') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Notices
                    </a>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('notice-board.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="category">Category <span class="text-danger">*</span></label>
                                    <select name="category" id="category" class="form-control @error('category') is-invalid @enderror" required>
                                        <option value="">Select category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category }}" {{ old('category') == $category ? 'selected' : '' }}>{{ $category }}</option>
                                        @endforeach
                                    </select>
                                    @error('category')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="target_center">Target Centre <span class="text-danger">*</span></label>
                                    <select name="target_center" id="target_center" class="form-control @error('target_center') is-invalid @enderror" required>
                                        <option value="All Centres" {{ old('target_center', 'All Centres') == 'All Centres' ? 'selected' : '' }}>All Centres</option>
                                        @foreach($centers as $center)
                                            <option value="{{ $center->center_name }}" {{ old('target_center') == $center->center_name ? 'selected' : '' }}>{{ $center->center_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('target_center')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="title">Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="short_description">Short Description <span class="text-danger">*</span></label>
                            <textarea name="short_description" id="short_description" rows="3" class="form-control @error('short_description') is-invalid @enderror" placeholder="Brief summary of the notice..." required>{{ old('short_description') }}</textarea>
                            @error('short_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="body">Body <span class="text-danger">*</span></label>
                            <textarea name="body" id="body" rows="8" class="form-control @error('body') is-invalid @enderror" placeholder="Full notice content..." required>{{ old('body') }}</textarea>
                            @error('body')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="attachments">Attachments</label>
                            <input type="file" name="attachments[]" id="attachments" class="form-control-file @error('attachments.*') is-invalid @enderror" multiple accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.gif">
                            <small class="form-text text-muted">You can select multiple files. Supported formats: PDF, DOC, DOCX, JPG, JPEG, PNG, GIF (Max: 10MB each)</small>
                            @error('attachments.*')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="publish" id="publish" class="custom-control-input" {{ old('publish') ? 'checked' : '' }}>
                                <label class="custom-control-label" for="publish">Publish (Yes/No) <span class="text-danger">*</span></label>
                            </div>
                            <small class="form-text text-muted">Check this box to make the notice visible to students immediately</small>
                        </div>

                        <div class="form-group text-right">
                            <a href="{{ route('notice-board.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                                <i class="fas fa-save"></i> Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
