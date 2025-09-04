@extends('layouts.student-portal')

@section('content')
<div class="container-fluid px-4">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box mb-4">
                <h4 class="page-title">My Documents</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('student-portal.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('student-portal.profile') }}">Profile</a></li>
                        <li class="breadcrumb-item active">My Documents</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Student Documents Section -->
    <div class="row">
        <div class="col-12">
            <div class="card" style="background: white; border-radius: 15px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08); border: none;">
                <div class="card-header" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border-radius: 15px 15px 0 0; border: none;">
                    <strong><i class="fas fa-file-alt"></i> Student Documents</strong>
                    <small class="ml-2">Uploaded documents and certificates</small>
                </div>
                <div class="card-body p-4">
                    @if($documents && $documents->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead style="background-color: #f8f9fa;">
                                    <tr>
                                        <th>Document Type</th>
                                        <th>Document Name</th>
                                        <th>File Info</th>
                                        <th>Upload Date</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($documents as $document)
                                        <tr>
                                            <td>
                                                <span class="badge badge-primary" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none;">
                                                    {{ ucwords(str_replace('_', ' ', $document->document_type)) }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-file-text mr-2 text-primary"></i>
                                                    <div>
                                                        <div class="font-weight-bold">{{ $document->document_name ?? 'Document' }}</div>
                                                        @if($document->document_description)
                                                            <small class="text-muted">{{ $document->document_description }}</small>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-file mr-2 text-primary"></i>
                                                    <div>
                                                        <div class="font-weight-bold">{{ $document->file_name }}</div>
                                                        <small class="text-muted">
                                                            {{ strtoupper($document->file_type) }} • 
                                                            {{ $document->file_size ? number_format($document->file_size / 1024, 1) . ' KB' : 'Unknown size' }}
                                                        </small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div>{{ \Carbon\Carbon::parse($document->created_at)->format('d M Y') }}</div>
                                                <small class="text-muted">{{ \Carbon\Carbon::parse($document->created_at)->format('H:i') }}</small>
                                            </td>
                                            <td>
                                                @if($document->is_verified)
                                                    <span class="badge badge-success">
                                                        <i class="fas fa-check-circle"></i> Verified
                                                    </span>
                                                @else
                                                    <span class="badge badge-warning">
                                                        <i class="fas fa-clock"></i> Pending
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ asset('storage/' . $document->file_path) }}" target="_blank" 
                                                   class="btn btn-sm me-2" 
                                                   style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem; margin-right: 8px;"
                                                   title="View Document">
                                                    <i class="fas fa-eye"></i> View
                                                </a>
                                                <a href="{{ asset('storage/' . $document->file_path) }}" download 
                                                   class="btn btn-sm" 
                                                   style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;"
                                                   title="Download Document">
                                                    <i class="fas fa-download"></i> Download
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="mt-4 p-3" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 8px; border-left: 4px solid #28a745;">
                            <h6><i class="fas fa-info-circle"></i> Document Summary</h6>
                            <div class="row">
                                <div class="col-md-4">
                                    <p class="mb-1"><strong>Total Documents:</strong> {{ $documents->count() }}</p>
                                </div>
                                <div class="col-md-4">
                                    <p class="mb-1"><strong>Verified:</strong> {{ $documents->where('is_verified', true)->count() }}</p>
                                </div>
                                <div class="col-md-4">
                                    <p class="mb-1"><strong>Pending:</strong> {{ $documents->where('is_verified', false)->count() }}</p>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-file-upload fa-4x text-muted mb-4"></i>
                            <h5 class="text-muted mb-3">No Documents Available</h5>
                            <p class="text-muted mb-4">You don't have any documents uploaded to your profile yet.</p>
                            <div class="alert alert-info" role="alert">
                                <i class="fas fa-info-circle"></i>
                                <strong>Note:</strong> Documents are uploaded by administrators through the student management system. 
                                If you need to submit documents, please contact the administration office.
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
