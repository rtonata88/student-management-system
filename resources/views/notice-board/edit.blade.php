@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><i class="fas fa-edit"></i> Edit Notice</h4>
                    <a href="{{ route('notice-board.index') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Notices
                    </a>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('notice-board.update', $notice->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="category">Category <span class="text-danger">*</span></label>
                                    <select name="category" id="category" class="form-control @error('category') is-invalid @enderror" required>
                                        <option value="">Select category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category }}" {{ (old('category') ?? $notice->category) == $category ? 'selected' : '' }}>{{ $category }}</option>
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
                                        <option value="All Centres" {{ (old('target_center') ?? $notice->target_campus) == 'All Centres' ? 'selected' : '' }}>All Centres</option>
                                        @foreach($centers as $center)
                                            <option value="{{ $center->center_name }}" {{ (old('target_center') ?? $notice->target_campus) == $center->center_name ? 'selected' : '' }}>{{ $center->center_name }}</option>
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
                            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') ?? $notice->title }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="short_description">Short Description <span class="text-danger">*</span></label>
                            <textarea name="short_description" id="short_description" rows="3" class="form-control @error('short_description') is-invalid @enderror" placeholder="Brief summary of the notice..." required>{{ old('short_description') ?? $notice->short_description }}</textarea>
                            @error('short_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="body">Body <span class="text-danger">*</span></label>
                            <textarea name="body" id="body" rows="8" class="form-control @error('body') is-invalid @enderror" placeholder="Full notice content..." required>{{ old('body') ?? $notice->body }}</textarea>
                            @error('body')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Existing Attachments -->
                        @if($notice->attachments && count($notice->attachments) > 0)
                            <div class="form-group">
                                <label>Current Attachments</label>
                                <div class="row">
                                    @foreach($notice->attachments as $index => $attachment)
                                        <div class="col-md-4 mb-2">
                                            <div class="card">
                                                <div class="card-body p-2">
                                                    <small class="d-block">{{ $attachment['name'] }}</small>
                                                    <small class="text-muted">{{ number_format($attachment['size'] / 1024, 2) }} KB</small>
                                                    <button type="button" class="btn btn-sm btn-outline-danger float-right" onclick="removeAttachment({{ $notice->id }}, {{ $index }})">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div class="form-group">
                            <label for="attachments">Add New Attachments</label>
                            <input type="file" name="attachments[]" id="attachments" class="form-control-file @error('attachments.*') is-invalid @enderror" multiple accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.gif">
                            <small class="form-text text-muted">You can select multiple files. Supported formats: PDF, DOC, DOCX, JPG, JPEG, PNG, GIF (Max: 10MB each)</small>
                            @error('attachments.*')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="publish" id="publish" class="custom-control-input" {{ (old('publish') ?? $notice->publish) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="publish">Publish (Yes/No) <span class="text-danger">*</span></label>
                            </div>
                            <small class="form-text text-muted">Check this box to make the notice visible to students</small>
                        </div>

                        <div class="form-group text-right">
                            <a href="{{ route('notice-board.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                                <i class="fas fa-save"></i> Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function removeAttachment(noticeId, index) {
    if (confirm('Are you sure you want to remove this attachment?')) {
        fetch(`/notice-board/${noticeId}/remove-attachment`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ index: index })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        });
    }
}
</script>
@endsection
