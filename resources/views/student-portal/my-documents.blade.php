@extends('layouts.student-portal')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
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

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mb-3">Uploaded Documents</h4>
                    
                    @if($documents && $documents->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Document Type</th>
                                        <th>File Name</th>
                                        <th>Upload Date</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($documents as $document)
                                    <tr>
                                        <td>{{ $document->document_type }}</td>
                                        <td>{{ $document->file_name }}</td>
                                        <td>{{ $document->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <span class="badge badge-{{ $document->status === 'verified' ? 'success' : ($document->status === 'pending' ? 'warning' : 'secondary') }}">
                                                {{ ucfirst($document->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="#" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-download"></i> Download
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                            <h5>No Documents Found</h5>
                            <p class="text-muted">You haven't uploaded any documents yet.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
