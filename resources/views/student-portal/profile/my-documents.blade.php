@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white;">
                    <h4 class="mb-0"><i class="fas fa-file-alt"></i> My Documents</h4>
                    <small>View and manage your uploaded documents</small>
                </div>
                <div class="card-body">
                    @if($documents->isEmpty())
                        <div class="alert alert-info text-center">
                            <i class="fas fa-info-circle fa-3x mb-3"></i>
                            <h5>No Documents Found</h5>
                            <p>You haven't uploaded any documents yet. Documents uploaded during your application process will appear here.</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead style="background-color: #f8f9fa;">
                                    <tr>
                                        <th>Document Type</th>
                                        <th>Document Name</th>
                                        <th>File Size</th>
                                        <th>Upload Date</th>
                                        <th>Verification Status</th>
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
                                            <td>{{ $document->getFileSizeFormatted() }}</td>
                                            <td>{{ $document->created_at->format('d M Y H:i') }}</td>
                                            <td>
                                                @if($document->verified)
                                                    <span class="badge badge-success">
                                                        <i class="fas fa-check"></i> Verified
                                                    </span>
                                                    @if($document->verified_at)
                                                        <br><small class="text-muted">{{ $document->verified_at->format('d M Y') }}</small>
                                                    @endif
                                                @else
                                                    <span class="badge badge-warning">
                                                        <i class="fas fa-clock"></i> Pending Verification
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ $document->getFileUrl() }}" target="_blank" 
                                                   class="btn btn-sm btn-outline-primary" title="View Document">
                                                    <i class="fas fa-eye"></i> View
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Document Summary -->
                        <div class="card mt-4">
                            <div class="card-header">
                                <h6><i class="fas fa-chart-pie"></i> Document Summary</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="text-center">
                                            <h4 class="text-primary">{{ $documents->count() }}</h4>
                                            <p class="text-muted mb-0">Total Documents</p>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="text-center">
                                            <h4 class="text-success">{{ $documents->where('verified', true)->count() }}</h4>
                                            <p class="text-muted mb-0">Verified</p>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="text-center">
                                            <h4 class="text-warning">{{ $documents->where('verified', false)->count() }}</h4>
                                            <p class="text-muted mb-0">Pending</p>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="text-center">
                                            <h4 class="text-info">{{ $documents->sum(function($doc) { return $doc->file_size; }) > 0 ? number_format($documents->sum(function($doc) { return $doc->file_size; }) / 1024 / 1024, 2) . ' MB' : '0 MB' }}</h4>
                                            <p class="text-muted mb-0">Total Size</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Navigation -->
                    <div class="text-center mt-4">
                        <a href="{{ route('student-portal.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
