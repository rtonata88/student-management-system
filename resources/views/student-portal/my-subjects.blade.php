@extends('layouts.student-portal')

@section('content')
<div class="container-fluid px-4">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box mb-4">
                <h4 class="page-title">My Subjects</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('student-portal.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">My Subjects</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    @if($subjectsByYear && $subjectsByYear->count() > 0)
        <div class="row">
            <div class="col-12">
                @foreach($subjectsByYear as $year => $subjects)
                    <div class="card mb-4" style="background: white; border-radius: 15px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08); border: none; margin-bottom: 3rem !important;">
                        <div class="card-header" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border-radius: 15px; border: none; cursor: pointer;" 
                             onclick="toggleYear({{ $loop->index }})">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <strong><i class="fas fa-calendar-alt"></i> Academic Year {{ $year }}</strong>
                                    <small class="ml-2">{{ $subjects->count() }} {{ $subjects->count() == 1 ? 'Subject' : 'Subjects' }}</small>
                                </div>
                                <div class="d-flex align-items-center">
                                    @if($year == 2025)
                                        <span class="badge badge-success mr-2" style="font-size: 0.9rem; padding: 6px 12px;">
                                            Current Year
                                        </span>
                                    @endif
                                    <i class="fas fa-chevron-down" id="arrow-{{ $loop->index }}"></i>
                                </div>
                            </div>
                        </div>
                        <div id="year-{{ $loop->index }}" style="display: none;">
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                                            <tr>
                                                <th>Subject Code</th>
                                                <th>Subject Name</th>
                                                <th>Teacher</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($subjects as $subject)
                                                @if($subject->module)
                                                <tr>
                                                    <td>
                                                        <span class="badge" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white;">{{ $subject->module->subject_code ?? 'N/A' }}</span>
                                                    </td>
                                                    <td>
                                                        <strong>{{ $subject->module->subject_name ?? 'N/A' }}</strong>
                                                    </td>
                                                    <td>
                                                        @if($subject->subjectAllocation && $subject->subjectAllocation->user)
                                                            {{ $subject->subjectAllocation->user->first_name }} {{ $subject->subjectAllocation->user->surname }}
                                                        @else
                                                            <span class="text-muted">Not Assigned</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($subject->subjectAllocation)
                                                            <a href="{{ route('student-portal.my-attendance', $subject->subjectAllocation->id) }}" 
                                                               class="btn btn-sm me-2" 
                                                               style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                                                                <i class="fas fa-calendar-check"></i> My Attendance
                                                            </a>
                                                            <a href="{{ route('student-portal.subject-materials', $subject->subjectAllocation->id) }}" 
                                                               class="btn btn-sm" 
                                                               style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                                                                <i class="fas fa-file-alt"></i> Subject Materials
                                                            </a>
                                                        @else
                                                            <span class="text-muted small">
                                                                <i class="fas fa-exclamation-triangle"></i> Teacher not allocated yet
                                                            </span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-12">
                <div class="card" style="background: white; border-radius: 15px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08); border: none;">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-book fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted mb-3">No Subjects Found</h5>
                        <p class="text-muted mb-0">You are not currently registered for any subjects.</p>
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
function toggleYear(index) {
    const content = document.getElementById('year-' + index);
    const arrow = document.getElementById('arrow-' + index);
    
    // Toggle current year section
    if (content.style.display === 'none' || content.style.display === '') {
        content.style.display = 'block';
        arrow.classList.add('rotated');
    } else {
        content.style.display = 'none';
        arrow.classList.remove('rotated');
    }
}
</script>
