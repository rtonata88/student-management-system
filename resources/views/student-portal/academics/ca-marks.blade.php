@extends('layouts.student-portal')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">CA Marks</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('student-portal.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('student-portal.academics') }}">Academics</a></li>
                        <li class="breadcrumb-item active">CA Marks</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mb-3">Continuous Assessment Marks</h4>
                    
                    @if(isset($suppressed) && $suppressed)
                        <div class="alert alert-warning text-center">
                            <i class="fas fa-ban fa-2x mb-3"></i>
                            <h5>Marks Currently Suppressed</h5>
                            <p class="mb-0">Your CA marks are currently suppressed by the administration. Please contact your academic office for more information.</p>
                        </div>
                    @elseif($caMarks && $caMarks->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Subject</th>
                                        <th>Assessment Type</th>
                                        <th>Date</th>
                                        <th>Total Marks</th>
                                        <th>Obtained Marks</th>
                                        <th>Percentage</th>
                                        <th>Grade</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($caMarks as $mark)
                                    <tr>
                                        <td>{{ $mark->subject_name ?? 'N/A' }}</td>
                                        <td>{{ $mark->assessment_type ?? 'CA' }}</td>
                                        <td>{{ $mark->date ? \Carbon\Carbon::parse($mark->date)->format('M d, Y') : 'N/A' }}</td>
                                        <td>{{ $mark->total_marks ?? '0' }}</td>
                                        <td>{{ $mark->obtained_marks ?? '0' }}</td>
                                        <td>
                                            @php
                                                $percentage = $mark->total_marks > 0 ? round(($mark->obtained_marks / $mark->total_marks) * 100, 1) : 0;
                                            @endphp
                                            {{ $percentage }}%
                                        </td>
                                        <td>
                                            <span class="badge badge-{{ $percentage >= 80 ? 'success' : ($percentage >= 60 ? 'warning' : 'danger') }}">
                                                {{ $percentage >= 80 ? 'A' : ($percentage >= 60 ? 'B' : 'C') }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-chart-line fa-3x text-muted mb-3"></i>
                            <h5>No CA Marks Available</h5>
                            <p class="text-muted">Your continuous assessment marks will appear here once they are recorded.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
