@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white;">
                    <h4 class="mb-0"><i class="fas fa-clipboard-list"></i> My Applications</h4>
                    <small>Track the status of your applications</small>
                </div>
                <div class="card-body">
                    @if($applications->isEmpty())
                        <div class="alert alert-info text-center">
                            <i class="fas fa-info-circle fa-3x mb-3"></i>
                            <h5>No Applications Found</h5>
                            <p>You haven't submitted any applications yet.</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead style="background-color: #f8f9fa;">
                                    <tr>
                                        <th>Application Number</th>
                                        <th>Status</th>
                                        <th>Subjects</th>
                                        <th>Documents</th>
                                        <th>Created Date</th>
                                        <th>Submitted Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($applications as $application)
                                        <tr>
                                            <td>
                                                <strong>{{ $application->application_number }}</strong>
                                            </td>
                                            <td>
                                                <span class="badge {{ $application->getStatusBadgeClass() }}">
                                                    {{ $application->getStatusLabel() }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge badge-info">{{ $application->subjects->count() }} subjects</span>
                                                @if($application->subjects->count() > 0)
                                                    <br><small class="text-muted">
                                                        {{ $application->subjects->pluck('subject_name')->take(2)->implode(', ') }}
                                                        @if($application->subjects->count() > 2)
                                                            ...
                                                        @endif
                                                    </small>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge badge-secondary">{{ $application->documents->count() }} files</span>
                                                @if($application->documents->where('verified', true)->count() > 0)
                                                    <br><small class="text-success">
                                                        <i class="fas fa-check"></i> {{ $application->documents->where('verified', true)->count() }} verified
                                                    </small>
                                                @endif
                                            </td>
                                            <td>{{ $application->created_at->format('d M Y H:i') }}</td>
                                            <td>
                                                @if($application->submitted_at)
                                                    {{ $application->submitted_at->format('d M Y H:i') }}
                                                @else
                                                    <span class="text-muted">Not submitted</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($application->isSubmitted())
                                                    <a href="{{ route('online-application.download-acknowledgement') }}" 
                                                       class="btn btn-sm btn-outline-primary" title="Download Acknowledgement">
                                                        <i class="fas fa-download"></i>
                                                    </a>
                                                @else
                                                    <a href="{{ route('online-application.review') }}" 
                                                       class="btn btn-sm btn-outline-warning" title="Complete Application">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Application Status Guide -->
                        <div class="card mt-4">
                            <div class="card-header">
                                <h6><i class="fas fa-info-circle"></i> Application Status Guide</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <ul class="list-unstyled">
                                            <li><span class="badge badge-warning">Pending</span> - Application created but not submitted</li>
                                            <li><span class="badge badge-info">Under Review</span> - Application submitted and being reviewed</li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <ul class="list-unstyled">
                                            <li><span class="badge badge-success">Approved</span> - Application approved, enrollment instructions sent</li>
                                            <li><span class="badge badge-danger">Rejected</span> - Application rejected, contact administration for details</li>
                                        </ul>
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
