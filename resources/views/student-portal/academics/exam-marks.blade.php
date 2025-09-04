@extends('layouts.student-portal')

@section('content')
<div class="container-fluid px-4">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box mb-4">
                <h4 class="page-title">Exam Marks</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('student-portal.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="#">Academics</a></li>
                        <li class="breadcrumb-item active">Exam Marks</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    @if(isset($suppressed) && $suppressed)
        <div class="row">
            <div class="col-12">
                <div class="alert alert-warning text-center">
                    <i class="fas fa-ban fa-2x mb-3"></i>
                    <h5>Marks Currently Suppressed</h5>
                    <p class="mb-0">Your exam marks are currently suppressed by the administration. Please contact your academic office for more information.</p>
                </div>
            </div>
        </div>
    @elseif($examMarks && $examMarks->count() > 0)
        <div class="row">
            <div class="col-12">
                @foreach($examMarks as $index => $moduleData)
                    <div class="card mb-5" style="background: white; border-radius: 15px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08); border: none; margin-bottom: 2rem !important;">
                        <div class="card-header" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border-radius: 15px; border: none; cursor: pointer;" 
                             onclick="toggleModule({{ $index }})">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <strong><i class="fas fa-graduation-cap"></i> {{ $moduleData['module']->subject_name }} ({{ $moduleData['module']->subject_code }})</strong>
                                </div>
                                <div class="d-flex align-items-center">
                                    @if(isset($moduleData['has_marks']) && $moduleData['has_marks'])
                                        <span class="badge badge-success mr-2" style="font-size: 0.9rem; padding: 6px 12px;">
                                            Has Marks
                                        </span>
                                    @elseif(isset($moduleData['no_exam_structure']) && $moduleData['no_exam_structure'])
                                        <span class="badge badge-warning mr-2" style="font-size: 0.9rem; padding: 6px 12px;">
                                            No Structure
                                        </span>
                                    @else
                                        <span class="badge badge-info mr-2" style="font-size: 0.9rem; padding: 6px 12px;">
                                            No Marks
                                        </span>
                                    @endif
                                    <i class="fas fa-chevron-down" id="arrow-{{ $index }}"></i>
                                </div>
                            </div>
                        </div>
                        <div id="module-{{ $index }}" style="display: none;">
                            <div class="card-body p-4">
                                @if(isset($moduleData['no_exam_structure']) && $moduleData['no_exam_structure'])
                                    <!-- No exam structure defined -->
                                    <div class="alert alert-info text-center">
                                        <i class="fas fa-info-circle fa-2x mb-3"></i>
                                        <h5>No Exam Structure Defined</h5>
                                        <p class="mb-0">Exam paper weights have not been configured for this module yet. Please contact your lecturer for more information.</p>
                                    </div>
                                @elseif(!isset($moduleData['has_marks']) || !$moduleData['has_marks'])
                                    <!-- Exam structure exists but no marks captured -->
                                    <div class="alert alert-warning text-center">
                                        <i class="fas fa-clock fa-2x mb-3"></i>
                                        <h5>No Marks Captured Yet</h5>
                                        <p class="mb-0">Exam structure is configured, but no exam marks have been captured for this module yet.</p>
                                    </div>
                                    
                                    <!-- Show exam structure -->
                                    <div class="card mt-3" style="border: 1px solid #e9ecef; border-radius: 10px;">
                                        <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 10px 10px 0 0;">
                                            <strong><i class="fas fa-chart-bar"></i> Exam Structure</strong>
                                            <small class="ml-2">Configured exam types and papers</small>
                                        </div>
                                        <div class="card-body">
                                            @if(isset($moduleData['exam_types']) && count($moduleData['exam_types']) > 0)
                                                @foreach($moduleData['exam_types'] as $examTypeData)
                                                    <div class="mb-3">
                                                        <h6 class="text-primary mb-2">{{ $examTypeData['exam_type']->name }}</h6>
                                                        <div class="row">
                                                            @foreach($examTypeData['exam_papers'] as $paperData)
                                                                <div class="col-md-4">
                                                                    <div class="text-center">
                                                                        <p class="mb-1 small"><strong>{{ $paperData['exam_paper']->paper_name }}</strong></p>
                                                                        <p class="mb-0 small">Weight: {{ $paperData['weight'] }}%</p>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    @if(!$loop->last)<hr>@endif
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                @else
                                    <!-- Normal display with exam marks -->
                                    @foreach($moduleData['exam_types'] as $examTypeData)
                                        <div class="card mt-3" style="border: 1px solid #e9ecef; border-radius: 10px;">
                                            <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 10px 10px 0 0;">
                                                <strong><i class="fas fa-file-alt"></i> {{ $examTypeData['exam_type']->name }}</strong>
                                                <small class="ml-2">Exam papers and marks</small>
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table class="table table-striped table-bordered">
                                                        <thead class="table-dark">
                                                            <tr>
                                                                @foreach($examTypeData['exam_papers'] as $paperData)
                                                                    <th colspan="3" class="text-center">
                                                                        {{ $paperData['exam_paper']->paper_name }}
                                                                        <small class="d-block">(Weight: {{ $paperData['weight'] }}%)</small>
                                                                    </th>
                                                                @endforeach
                                                                <th rowspan="2" class="bg-success text-white align-middle text-center">{{ $examTypeData['exam_type']->name }} Total</th>
                                                            </tr>
                                                            <tr>
                                                                @foreach($examTypeData['exam_papers'] as $paperData)
                                                                    <th class="text-center small">Marks</th>
                                                                    <th class="text-center small">%</th>
                                                                    <th class="text-center small">Weighted</th>
                                                                @endforeach
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                @foreach($examTypeData['exam_papers'] as $paperData)
                                                                    <td class="text-center">
                                                                        @if($paperData['marks_obtained'] !== null)
                                                                            {{ $paperData['marks_obtained'] }}/{{ $paperData['total_marks'] }}
                                                                        @else
                                                                            <span class="text-muted">-</span>
                                                                        @endif
                                                                    </td>
                                                                    <td class="text-center">
                                                                        @if($paperData['percentage'] > 0)
                                                                            {{ $paperData['percentage'] }}%
                                                                        @else
                                                                            <span class="text-muted">-</span>
                                                                        @endif
                                                                    </td>
                                                                    <td class="text-center">
                                                                        @if($paperData['weighted_mark'] > 0)
                                                                            {{ $paperData['weighted_mark'] }}
                                                                        @else
                                                                            <span class="text-muted">-</span>
                                                                        @endif
                                                                    </td>
                                                                @endforeach
                                                                
                                                                <td class="text-center bg-success text-white">
                                                                    <strong>{{ $examTypeData['exam_type_total'] }}%</strong>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                
                                                <div class="mt-3 p-3" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 8px; border-left: 4px solid #667eea;">
                                                    <h6><i class="fas fa-calculator"></i> {{ $examTypeData['exam_type']->name }} Summary</h6>
                                                    <div class="row">
                                                        @foreach($examTypeData['exam_papers'] as $paperData)
                                                            <div class="col-md-{{ 12 / count($examTypeData['exam_papers']) }}">
                                                                <p class="mb-1"><strong>{{ $paperData['exam_paper']->paper_name }}:</strong> {{ $paperData['weight'] }}%</p>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    <hr>
                                                    <p class="mb-0"><strong>{{ $examTypeData['exam_type']->name }} Total:</strong> {{ $examTypeData['exam_type_total'] }}%</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    
                                    @if(count($moduleData['exam_types']) > 1)
                                        <!-- Overall module exam total -->
                                        <div class="card mt-3" style="border: 2px solid #28a745; border-radius: 10px;">
                                            <div class="card-header" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white; border-radius: 8px 8px 0 0;">
                                                <strong><i class="fas fa-trophy"></i> Overall Exam Total</strong>
                                                <small class="ml-2">Combined result from all exam types</small>
                                            </div>
                                            <div class="card-body text-center">
                                                <h2 class="text-success mb-0">{{ $moduleData['exam_total'] }}%</h2>
                                                <p class="text-muted mb-0">Total exam mark for {{ $moduleData['module']->subject_name }}</p>
                                            </div>
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <!-- No registrations/modules - student has only applied -->
        <div class="row">
            <div class="col-12">
                <div class="card" style="background: white; border-radius: 15px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08); border: none;">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-file-alt fa-4x text-muted mb-4"></i>
                        <h5 class="text-muted mb-3">No Subject Registrations</h5>
                        <p class="text-muted mb-4">You are not currently registered for any subjects. Exam marks will be available once you have been admitted and registered for subjects.</p>
                        <div class="alert alert-info" role="alert">
                            <i class="fas fa-info-circle"></i>
                            <strong>Note:</strong> If you have submitted an application, please wait for admission approval and subject registration to view your exam marks.
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

#arrow-0, #arrow-1, #arrow-2, #arrow-3, #arrow-4, #arrow-5, #arrow-6, #arrow-7, #arrow-8, #arrow-9 {
    transition: transform 0.3s ease;
}

.rotated {
    transform: rotate(180deg);
}
</style>

<script>
function toggleModule(index) {
    const content = document.getElementById('module-' + index);
    const arrow = document.getElementById('arrow-' + index);
    
    // Toggle current module
    if (content.style.display === 'none' || content.style.display === '') {
        content.style.display = 'block';
        arrow.classList.add('rotated');
    } else {
        content.style.display = 'none';
        arrow.classList.remove('rotated');
    }
}
</script>
