@extends('layouts.student-portal')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">My Applications</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('student-portal.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('student-portal.profile') }}">Profile</a></li>
                        <li class="breadcrumb-item active">My Applications</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mb-3">Application History</h4>
                    
                    @if($applications && $applications->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Application Number</th>
                                        <th>Submission Date</th>
                                        <th>Status</th>
                                        <th>Last Updated</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($applications as $application)
                                    <tr>
                                        <td>{{ $application->application_number }}</td>
                                        <td>{{ $application->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <span class="badge badge-{{ $application->status === 'approved' ? 'success' : ($application->status === 'pending' ? 'warning' : 'info') }}">
                                                {{ ucfirst($application->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $application->updated_at->format('M d, Y') }}</td>
                                        <td>
                                            <a href="#" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i> View
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
                            <h5>No Applications Found</h5>
                            <p class="text-muted">You haven't submitted any applications yet.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
