@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white;">
                    <h4 class="mb-0"><i class="fas fa-upload"></i> Upload Required Documents</h4>
                    <small>Step 4 of 5 - Upload all required documents for your application</small>
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

                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Upload Form -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5><i class="fas fa-plus-circle"></i> Upload New Document</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('online-application.upload-document') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="document_type">Document Type <span class="text-danger">*</span></label>
                                            <select name="document_type" id="document_type" class="form-control" required>
                                                <option value="">Select Document Type</option>
                                                @foreach($documentTypes as $key => $label)
                                                    <option value="{{ $key }}" {{ old('document_type') == $key ? 'selected' : '' }}>{{ $label }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="document_name">Document Name <span class="text-danger">*</span></label>
                                            <input type="text" name="document_name" id="document_name" class="form-control" 
                                                   placeholder="Enter document name" value="{{ old('document_name') }}" required>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="document_file">Choose File <span class="text-danger">*</span></label>
                                    <input type="file" name="document_file" id="document_file" class="form-control-file" 
                                           accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" required>
                                    <small class="form-text text-muted">
                                        Allowed file types: PDF, DOC, DOCX, JPG, JPEG, PNG. Maximum file size: 10MB
                                    </small>
                                </div>
                                
                                <button type="submit" class="btn" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                                    <i class="fas fa-upload"></i> Upload Document
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Uploaded Documents -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5><i class="fas fa-file-alt"></i> Uploaded Documents</h5>
                        </div>
                        <div class="card-body">
                            @if($documents->isEmpty())
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle"></i> No documents uploaded yet. Please upload at least one document to continue.
                                </div>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead style="background-color: #f8f9fa;">
                                            <tr>
                                                <th>Document Type</th>
                                                <th>Document Name</th>
                                                <th>File Name</th>
                                                <th>File Size</th>
                                                <th>Upload Date</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($documents as $document)
                                                <tr>
                                                    <td>
                                                        <span class="badge badge-primary">{{ $document->getDocumentTypeLabel() }}</span>
                                                    </td>
                                                    <td>{{ $document->document_name }}</td>
                                                    <td>
                                                        <i class="fas fa-file"></i> {{ $document->file_name }}
                                                    </td>
                                                    <td>{{ $document->getFileSizeFormatted() }}</td>
                                                    <td>{{ $document->created_at->format('d M Y H:i') }}</td>
                                                    <td>
                                                        <a href="{{ $document->getFileUrl() }}" target="_blank" 
                                                           class="btn btn-sm btn-outline-primary" title="View Document">
                                                            <i class="fas fa-eye"></i> View
                                                        </a>
                                                        <form action="{{ route('online-application.delete-document', $document->id) }}" 
                                                              method="POST" class="d-inline" 
                                                              onsubmit="return confirm('Are you sure you want to delete this document?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete Document">
                                                                <i class="fas fa-trash"></i> Delete
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Document Requirements Info -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5><i class="fas fa-info-circle"></i> Document Requirements</h5>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-warning">
                                <h6><i class="fas fa-exclamation-triangle"></i> Please upload all required documents:</h6>
                                <ul class="mb-0">
                                    <li><strong>ID or Birth Certificate:</strong> Valid identification document</li>
                                    <li><strong>School Certificate:</strong> Latest academic qualification certificate</li>
                                    <li><strong>Proof of Payment:</strong> Payment receipt or proof of payment</li>
                                    <li><strong>Other Documents:</strong> Any additional supporting documents</li>
                                </ul>
                            </div>
                            <div class="alert alert-info">
                                <h6><i class="fas fa-file-upload"></i> File Upload Guidelines:</h6>
                                <ul class="mb-0">
                                    <li>Maximum file size is 4MB per file</li>
                                    <li>We only allow PDF documents</li>
                                    <li>Documents marked with <span class="text-success">✓</span> have already been uploaded. Please do not re-upload again unless you wish to update the uploaded document</li>
                                    <li>Documents marked with <span class="text-danger">●</span> have not yet been uploaded.</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="card">
                        <div class="card-footer text-center">
                            <a href="{{ route('online-application.review') }}" 
                               class="btn btn-lg mr-3" 
                               style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.75rem 2rem;"
                               {{ $documents->isEmpty() ? 'onclick="return confirm(\'You have not uploaded any documents. Are you sure you want to continue?\')"' : '' }}>
                                <i class="fas fa-arrow-right"></i> Continue to Review
                            </a>
                            <a href="{{ route('online-application.subject-selection') }}" class="btn btn-secondary btn-lg" style="padding: 0.75rem 2rem;">
                                <i class="fas fa-arrow-left"></i> Back
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card-header h5 {
    margin-bottom: 0;
}

.table th {
    border-top: none;
}

.badge {
    font-size: 0.75em;
}

.btn-outline-primary:hover,
.btn-outline-danger:hover {
    transform: translateY(-1px);
}
</style>

<script>
document.getElementById('document_file').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        // Check file size (10MB = 10 * 1024 * 1024 bytes)
        if (file.size > 10 * 1024 * 1024) {
            alert('File size must be less than 10MB');
            e.target.value = '';
            return;
        }
        
        // Auto-fill document name if empty
        const documentNameField = document.getElementById('document_name');
        if (!documentNameField.value) {
            documentNameField.value = file.name.replace(/\.[^/.]+$/, "");
        }
    }
});
</script>
@endsection
