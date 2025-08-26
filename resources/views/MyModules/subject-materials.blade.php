@extends('layouts.app')

@section('breadcrumb')
<div class="c-subheader px-3">
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Assessments</li>
        <li class="breadcrumb-item"><a href="{{ route('my-modules.index') }}">My Modules</a></li>
        <li class="breadcrumb-item active">Subject Materials</li>
    </ol>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h5 class="mb-0">
                            <i class="fas fa-folder-open"></i> Subject Materials
                        </h5>
                        <small class="text-muted">
                            {{ $allocation->module->subject_code }} - {{ $allocation->module->subject_name }}
                            <span class="badge badge-info ml-2">{{ $allocation->academicYear->academic_year }}</span>
                        </small>
                    </div>
                    <div class="col-auto">
                        @permission('upload-subject-materials')
                        <a href="{{ route('my-modules.upload-material', $allocation->id) }}" 
                           class="btn btn-sm" 
                           style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                            <i class="fas fa-plus"></i> Upload New
                        </a>
                        @endpermission
                        <a href="{{ route('my-modules.index') }}" 
                           class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Back to My Modules
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if(Session::has('success'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    {{ Session::get('success') }}
                </div>
                @endif

                @if(Session::has('error'))
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    {{ Session::get('error') }}
                </div>
                @endif

                <!-- Search and Filter Section -->
                <div class="card mb-4">
                    <div class="card-body">
                        <form method="GET" action="{{ route('my-modules.subject-materials', $allocation->id) }}" class="row g-3">
                            <div class="col-md-6">
                                <label for="search" class="form-label">Search Materials</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                                    <input type="text" 
                                           class="form-control" 
                                           id="search" 
                                           name="search" 
                                           value="{{ request('search') }}" 
                                           placeholder="Search by name, description, or category...">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="category" class="form-label">Filter by Category</label>
                                <select class="form-control" id="category" name="category">
                                    <option value="all" {{ request('category') == 'all' ? 'selected' : '' }}>All Categories</option>
                                    @if(isset($categories))
                                        @foreach($categories as $cat)
                                            <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>
                                                {{ $cat }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <button type="submit" class="btn btn-outline-primary me-2">
                                    <i class="fas fa-filter"></i> Filter
                                </button>
                                <a href="{{ route('my-modules.subject-materials', $allocation->id) }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-times"></i> Clear
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                @if($materials->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>Document Name</th>
                                <th>Description</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Expiry</th>
                                <th>Uploader</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($materials as $material)
                            <tr>
                                <td>
                                    <i class="fas fa-file-alt text-primary"></i>
                                    <strong>{{ $material->document_name }}</strong>
                                    <br>
                                    <small class="text-muted">{{ $material->file_size_human }}</small>
                                </td>
                                <td>
                                    <div class="description-cell text-center">
                                        <button type="button" class="btn btn-sm btn-outline-info" 
                                                data-toggle="modal" data-target="#descriptionModal{{ $material->id }}">
                                            <i class="fas fa-eye"></i> View Description
                                        </button>
                                    </div>
                                </td>
                                <td>
                                    @php
                                        $categoryColors = [
                                            'Syllabus' => 'primary',
                                            'Class Notes' => 'success', 
                                            'General Info' => 'info',
                                            'Exam Papers' => 'warning',
                                            'Others' => 'secondary'
                                        ];
                                        $color = $categoryColors[$material->category] ?? 'secondary';
                                    @endphp
                                    <span class="badge badge-{{ $color }}">{{ $material->category }}</span>
                                </td>
                                <td>
                                    @if($material->published)
                                        <span class="badge badge-success">
                                            <i class="fas fa-check-circle"></i> Published
                                        </span>
                                    @else
                                        <span class="badge badge-secondary">
                                            <i class="fas fa-clock"></i> Draft
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if($material->end_date && $material->end_date->isPast())
                                        <span class="text-danger">
                                            <i class="fas fa-exclamation-triangle"></i>
                                            Expired
                                        </span>
                                        <br>
                                        <small class="text-muted">{{ $material->end_date->format('d M Y') }}</small>
                                    @elseif($material->end_date)
                                        <span class="text-warning">
                                            <i class="fas fa-calendar-alt"></i>
                                            {{ $material->end_date->format('d M Y') }}
                                        </span>
                                    @else
                                        <span class="text-muted">
                                            <i class="fas fa-infinity"></i>
                                            No expiry
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <i class="fas fa-user text-info"></i>
                                    {{ $material->uploader->name }}
                                    <br>
                                    <small class="text-muted">{{ $material->created_at->format('d M Y H:i') }}</small>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        @permission('download-subject-materials')
                                        <a href="{{ route('my-modules.download-material', $material->id) }}" 
                                           class="btn btn-sm" 
                                           style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;"
                                           title="Download {{ $material->file_name }}">
                                            <i class="fas fa-download"></i> Download
                                        </a>
                                        @endpermission
                                        
                                        @permission('view-subject-materials')
                                        <button type="button" class="btn btn-sm btn-outline-info" 
                                                data-toggle="modal" data-target="#descriptionModal{{ $material->id }}"
                                                title="View Material Details">
                                            <i class="fas fa-eye"></i> View
                                        </button>
                                        @endpermission
                                        
                                        @permission('edit-subject-materials')
                                        <a href="{{ route('my-modules.edit-material', $material->id) }}" 
                                           class="btn btn-sm btn-outline-primary" 
                                           title="Edit Material">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        @endpermission
                                        
                                        @permission('delete-subject-materials')
                                        <form method="POST" action="{{ route('my-modules.delete-material', $material->id) }}" 
                                              style="display: inline-block;" 
                                              onsubmit="return confirm('Are you sure you want to delete this material?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete Material">
                                                <i class="fas fa-trash-alt"></i> Delete
                                            </button>
                                        </form>
                                        @endpermission
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Description Modals -->
                @foreach($materials as $material)
                <div class="modal fade" id="descriptionModal{{ $material->id }}" tabindex="-1" role="dialog" aria-labelledby="descriptionModalLabel{{ $material->id }}" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="descriptionModalLabel{{ $material->id }}">
                                    <i class="fas fa-file-alt text-primary"></i> {{ $material->document_name }}
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <h6 class="text-muted mb-2">Description:</h6>
                                <p>{{ $material->document_description }}</p>
                                
                                <hr>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <small class="text-muted">
                                            <strong>Category:</strong> 
                                            <span class="badge badge-{{ $categoryColors[$material->category] ?? 'secondary' }}">
                                                {{ $material->category }}
                                            </span>
                                        </small>
                                    </div>
                                    <div class="col-md-6">
                                        <small class="text-muted">
                                            <strong>File Size:</strong> {{ $material->file_size_human }}
                                        </small>
                                    </div>
                                </div>
                                
                                <div class="row mt-2">
                                    <div class="col-md-6">
                                        <small class="text-muted">
                                            <strong>Uploaded by:</strong> {{ $material->uploader->name }}
                                        </small>
                                    </div>
                                    <div class="col-md-6">
                                        <small class="text-muted">
                                            <strong>Upload Date:</strong> {{ $material->created_at->format('d M Y H:i') }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                @permission('download-subject-materials')
                                <a href="{{ route('my-modules.download-material', $material->id) }}" 
                                   class="btn btn-sm" 
                                   style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                                    <i class="fas fa-download"></i> Download
                                </a>
                                @endpermission
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div>
                        <small class="text-muted">
                            Showing {{ $materials->firstItem() ?? 0 }} to {{ $materials->lastItem() ?? 0 }} 
                            of {{ $materials->total() }} results
                        </small>
                    </div>
                    <div>
                        {{ $materials->links() }}
                    </div>
                </div>
                @else
                <div class="text-center py-5">
                    <div class="mb-3">
                        <i class="fas fa-folder-open fa-3x text-muted"></i>
                    </div>
                    @if(request('search') || request('category'))
                        <h5 class="text-muted">No materials found</h5>
                        <p class="text-muted">Try adjusting your search criteria or filters.</p>
                        <a href="{{ route('my-modules.subject-materials', $allocation->id) }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times"></i> Clear Filters
                        </a>
                    @else
                        <h5 class="text-muted">No materials have been uploaded</h5>
                        <p class="text-muted">Upload your first material to get started.</p>
                        @permission('upload-subject-materials')
                        <a href="{{ route('my-modules.upload-material', $allocation->id) }}" 
                           class="btn" 
                           style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                            <i class="fas fa-plus"></i> Upload New Material
                        </a>
                        @endpermission
                    @endif
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
.table td {
    vertical-align: middle;
}

.badge {
    font-size: 0.75em;
}

.btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    transition: all 0.3s ease;
}

.alert {
    border-radius: 8px;
}

.card {
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.card-header {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-bottom: 1px solid #dee2e6;
}

.description-cell {
    max-width: 200px;
}

.description-preview {
    margin-bottom: 5px;
    line-height: 1.4;
}

.action-buttons .btn {
    margin-right: 8px;
}

.action-buttons .btn:last-child {
    margin-right: 0;
}

.btn-outline-primary:hover {
    background-color: #007bff;
    border-color: #007bff;
    color: white;
}

.btn-outline-danger:hover {
    background-color: #dc3545;
    border-color: #dc3545;
    color: white;
}

.btn-outline-info:hover {
    background-color: #17a2b8;
    border-color: #17a2b8;
    color: white;
}

.modal-header {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-bottom: 1px solid #dee2e6;
}

.modal-content {
    border-radius: 10px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.2);
}
</style>
@endsection
