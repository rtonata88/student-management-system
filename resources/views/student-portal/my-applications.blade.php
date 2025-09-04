@extends('layouts.student-portal')

@section('content')
<div class="container-fluid px-4">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box mb-4">
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

    @if($applications && $applications->count() > 0)
        <div class="row">
            <div class="col-12">
                @foreach($applications as $index => $application)
                    <div class="card mb-4" style="background: white; border-radius: 15px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08); border: none; margin-bottom: 3rem !important;">
                        <div class="card-header" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border-radius: 15px; border: none; cursor: pointer;" 
                             onclick="toggleApplication({{ $index }})">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <strong><i class="fas fa-clipboard-list"></i> Academic Year {{ $application->academic_year }}</strong>
                                    <small class="ml-2">Registration {{ $application->application_number }}</small>
                                </div>
                                <div class="d-flex align-items-center">
                                    @php
                                        $statusClass = match($application->status) {
                                            'under_review' => 'badge-warning',
                                            'approved' => 'badge-info', 
                                            'registered' => 'badge-success',
                                            'rejected' => 'badge-danger',
                                            default => 'badge-secondary'
                                        };
                                        $statusText = match($application->status) {
                                            'under_review' => 'Under Review',
                                            'approved' => 'Approved', 
                                            'registered' => 'Registered',
                                            'rejected' => 'Rejected',
                                            default => ucfirst($application->status)
                                        };
                                    @endphp
                                    <span class="badge {{ $statusClass }} mr-2" style="font-size: 0.9rem; padding: 6px 12px;">
                                        {{ $statusText }}
                                    </span>
                                    <i class="fas fa-chevron-down" id="arrow-{{ $index }}"></i>
                                </div>
                            </div>
                        </div>
                        <div id="application-{{ $index }}" style="display: none;">
                            <div class="card-body p-4">
                        <!-- Application Summary -->
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <h6><i class="fas fa-info-circle text-primary"></i> Application Details</h6>
                                <div class="mb-2">
                                    <small class="text-muted">Application Number:</small><br>
                                    <strong>{{ $application->application_number }}</strong>
                                </div>
                                <div class="mb-2">
                                    <small class="text-muted">Academic Year:</small><br>
                                    <strong>{{ $application->academic_year }}</strong>
                                </div>
                                <div class="mb-2">
                                    <small class="text-muted">Qualification:</small><br>
                                    <strong>Academic Advancement Programme</strong>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <h6><i class="fas fa-map-marker-alt text-primary"></i> Campus Information</h6>
                                <div class="mb-2">
                                    <small class="text-muted">Selected Campus:</small><br>
                                    <strong>{{ $application->student && $application->student->center ? $application->student->center->center_name : 'Not specified' }}</strong>
                                </div>
                                <div class="mb-2">
                                    <small class="text-muted">Application Status:</small><br>
                                    <span class="badge {{ $statusClass }}">
                                        {{ $statusText }}
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <h6><i class="fas fa-calendar text-primary"></i> Timeline</h6>
                                <div class="mb-2">
                                    <small class="text-muted">Submitted:</small><br>
                                    <strong>{{ $application->created_at->format('d M Y, H:i') }}</strong>
                                </div>
                                <div class="mb-2">
                                    <small class="text-muted">Last Updated:</small><br>
                                    <strong>{{ $application->updated_at->format('d M Y, H:i') }}</strong>
                                </div>
                            </div>
                        </div>

                        <!-- Selected Subjects Section -->
                        <div class="card mt-3" style="border: 1px solid #e9ecef; border-radius: 10px;">
                            <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 10px 10px 0 0;">
                                <strong><i class="fas fa-book"></i> Selected Subjects</strong>
                                <small class="ml-2">Your chosen subjects for this application</small>
                            </div>
                            <div class="card-body">
                                @if($application->subjects && $application->subjects->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                                                <tr>
                                                    <th>Subject</th>
                                                    <th>Code</th>
                                                    <th class="text-right">Monthly Fee</th>
                                                    <th class="text-center">Credits</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php $totalFee = 0; $totalCredits = 0; @endphp
                                                @foreach($application->subjects as $subject)
                                                    @php 
                                                        $totalFee += $subject->subject_fees ?? 0;
                                                        $totalCredits += $subject->credits ?? 3;
                                                    @endphp
                                                    <tr style="transition: all 0.3s ease;">
                                                        <td class="align-middle">
                                                            <div class="d-flex align-items-center">
                                                                <div class="subject-icon me-3" style="width: 35px; height: 35px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 6px; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; margin-right: 12px; font-size: 0.8rem;">
                                                                    {{ substr($subject->subject_name, 0, 1) }}
                                                                </div>
                                                                <div>
                                                                    <h6 class="mb-0">{{ $subject->subject_name }}</h6>
                                                                    <small class="text-muted">{{ $subject->description ?? 'No description available' }}</small>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="align-middle">
                                                            <span class="badge badge-light" style="background: #f8f9fa; color: #495057; padding: 4px 8px; border-radius: 4px;">
                                                                {{ $subject->subject_code }}
                                                            </span>
                                                        </td>
                                                        <td class="align-middle text-right">
                                                            <span style="font-weight: 600; color: #28a745;">
                                                                N${{ number_format($subject->subject_fees ?? 0, 2) }}
                                                            </span>
                                                        </td>
                                                        <td class="align-middle text-center">
                                                            <span class="badge badge-info" style="background: #17a2b8; padding: 4px 8px; border-radius: 4px;">
                                                                {{ $subject->credits ?? 3 }}
                                                            </span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    
                                    <div class="mt-3 p-3" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 8px; border-left: 4px solid #667eea;">
                                        <h6><i class="fas fa-calculator"></i> Subject Summary</h6>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <p class="mb-1"><strong>Total Subjects:</strong> {{ $application->subjects->count() }}</p>
                                            </div>
                                            <div class="col-md-4">
                                                <p class="mb-1"><strong>Total Credits:</strong> {{ $totalCredits }}</p>
                                            </div>
                                            <div class="col-md-4">
                                                <p class="mb-1"><strong>Total Monthly Fee:</strong> N${{ number_format($totalFee, 2) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="text-center py-4">
                                        <i class="fas fa-book-open fa-3x text-muted mb-3"></i>
                                        <h5 class="text-muted">No Subjects Selected</h5>
                                        <p class="text-muted">No subjects were selected for this application.</p>
                                    </div>
                                @endif
                            </div>
                            </div>
                        </div>
                    </div>
                    @if(!$loop->last)
                        <div style="margin-bottom: 1.5rem;"></div>
                    @endif
                @endforeach
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-12">
                <div class="card" style="background: white; border-radius: 15px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08); border: none;">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-clipboard-list fa-4x text-muted mb-4"></i>
                        <h5 class="text-muted mb-3">No Applications Found</h5>
                        <p class="text-muted mb-4">You haven't submitted any applications yet.</p>
                        <div class="alert alert-info" role="alert">
                            <i class="fas fa-info-circle"></i>
                            <strong>Note:</strong> To apply for admission, please visit the online application portal or contact the admissions office.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

<style>
.card-header:hover {
    opacity: 0.9;
}

#arrow-0, #arrow-1, #arrow-2, #arrow-3, #arrow-4 {
    transition: transform 0.3s ease;
}

.rotated {
    transform: rotate(180deg);
}
</style>

<script>
function toggleApplication(index) {
    const content = document.getElementById('application-' + index);
    const arrow = document.getElementById('arrow-' + index);
    
    // Toggle current application
    if (content.style.display === 'none' || content.style.display === '') {
        content.style.display = 'block';
        arrow.classList.add('rotated');
    } else {
        content.style.display = 'none';
        arrow.classList.remove('rotated');
    }
}
</script>
