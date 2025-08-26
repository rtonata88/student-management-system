@extends('layouts.app')

@section('breadcrumb')
<div class="c-subheader px-3">
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Assessments</li>
        <li class="breadcrumb-item"><a href="{{ route('my-modules.index') }}">My Modules</a></li>
        <li class="breadcrumb-item"><a href="{{ route('my-modules.subject-materials', $material->module_allocation_id) }}">Subject Materials</a></li>
        <li class="breadcrumb-item active">Edit Material</li>
    </ol>
</div>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-edit"></i> Edit Subject Material
                </h5>
                <small class="text-muted">
                    {{ $material->moduleAllocation->module->subject_code }} - {{ $material->moduleAllocation->module->subject_name }}
                    <span class="badge badge-info ml-2">{{ $material->moduleAllocation->academicYear->academic_year }}</span>
                </small>
            </div>
            <div class="card-body">
                @if(Session::has('error'))
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    {{ Session::get('error') }}
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

                <form method="POST" action="{{ route('my-modules.update-material', $material->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-group">
                        <label for="document_name">Document Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="document_name" name="document_name" 
                               value="{{ old('document_name', $material->document_name) }}" required>
                        <small class="form-text text-muted">Enter a descriptive name for this material</small>
                    </div>

                    <div class="form-group">
                        <label for="document_description">Document Description</label>
                        <textarea class="form-control" id="document_description" name="document_description" 
                                  rows="3" placeholder="Optional description of the material content">{{ old('document_description', $material->document_description) }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="category">Category <span class="text-danger">*</span></label>
                        <select class="form-control" id="category" name="category" required>
                            <option value="">Select Category...</option>
                            @foreach($categories as $key => $value)
                                <option value="{{ $key }}" {{ old('category', $material->category) == $key ? 'selected' : '' }}>
                                    {{ $value }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="published">Published <span class="text-danger">*</span></label>
                        <select class="form-control" id="published" name="published" required>
                            <option value="1" {{ old('published', $material->published) == '1' ? 'selected' : '' }}>Yes - Make available to students</option>
                            <option value="0" {{ old('published', $material->published) == '0' ? 'selected' : '' }}>No - Keep as draft</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="end_date">End Date (Optional)</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" 
                               value="{{ old('end_date', $material->end_date ? $material->end_date->format('Y-m-d') : '') }}" 
                               min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                        <small class="form-text text-muted">Leave blank for permanent availability</small>
                    </div>

                    <div class="form-group">
                        <label>Current File</label>
                        <div class="alert alert-info">
                            <i class="fas fa-file-alt"></i> 
                            <strong>{{ $material->file_name }}</strong>
                            <span class="badge badge-secondary ml-2">{{ $material->file_size_human }}</span>
                            <br>
                            <small class="text-muted">Uploaded: {{ $material->created_at->format('d M Y H:i') }}</small>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="file">Replace File (Optional)</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="file" name="file"
                                   accept=".pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.txt,.jpg,.jpeg,.png">
                            <label class="custom-file-label" for="file">Choose new file...</label>
                        </div>
                        <small class="form-text text-muted">
                            Leave blank to keep current file. Supported formats: PDF, DOC, DOCX, PPT, PPTX, XLS, XLSX, TXT, JPG, JPEG, PNG (Max: 10MB)
                        </small>
                    </div>

                    <div class="form-group text-right">
                        <a href="{{ route('my-modules.subject-materials', $material->module_allocation_id) }}" 
                           class="btn btn-secondary mr-2">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                        <button type="submit" 
                                class="btn" 
                                style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                            <i class="fas fa-save"></i> Update Material
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.card-header {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-bottom: 1px solid #dee2e6;
}

.form-group label {
    font-weight: 600;
    color: #495057;
}

.form-control:focus {
    border-color: #6f42c1;
    box-shadow: 0 0 0 0.2rem rgba(111, 66, 193, 0.25);
}

.custom-file-input:focus ~ .custom-file-label {
    border-color: #6f42c1;
    box-shadow: 0 0 0 0.2rem rgba(111, 66, 193, 0.25);
}

.btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    transition: all 0.3s ease;
}

.alert {
    border-radius: 8px;
}

.text-danger {
    color: #dc3545 !important;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Update file input label when file is selected
    document.getElementById('file').addEventListener('change', function(e) {
        var fileName = e.target.files[0] ? e.target.files[0].name : 'Choose new file...';
        var label = document.querySelector('.custom-file-label');
        label.textContent = fileName;
    });
});
</script>
@endsection
