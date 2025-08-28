@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">
                            <i class="fas fa-graduation-cap"></i> Student Promotion - {{ $student->surname }}, {{ $student->student_names }}
                        </h4>
                        <a href="{{ route('promotions.search') }}" class="btn btn-light btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to Students
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Student Information -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="student-info-card">
                                <div class="student-info-header">
                                    <i class="fas fa-user-graduate"></i>
                                    <h5>Student Information</h5>
                                </div>
                                <div class="student-info-body">
                                    <div class="info-row">
                                        <div class="info-label">
                                            <i class="fas fa-user"></i>
                                            Student Name
                                        </div>
                                        <div class="info-value">{{ $student->student_names }} {{ $student->surname }}</div>
                                    </div>
                                    <div class="info-row">
                                        <div class="info-label">
                                            <i class="fas fa-id-card"></i>
                                            Student Number
                                        </div>
                                        <div class="info-value">{{ $student->student_number }}</div>
                                    </div>
                                    <div class="info-row">
                                        <div class="info-label">
                                            <i class="fas fa-hashtag"></i>
                                            Allocated Number
                                        </div>
                                        <div class="info-value">{{ $student->student_number2 ?? 'N/A' }}</div>
                                    </div>
                                    <div class="info-row">
                                        <div class="info-label">
                                            <i class="fas fa-map-marker-alt"></i>
                                            Centre
                                        </div>
                                        <div class="info-value">{{ $student->center->center_name ?? 'N/A' }}</div>
                                    </div>
                                    <div class="info-row">
                                        <div class="info-label">
                                            <i class="fas fa-envelope"></i>
                                            Contact
                                        </div>
                                        <div class="info-value">{{ $student->contact_email ?? 'N/A' }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="promotion-actions-card">
                                <div class="promotion-actions-header">
                                    <i class="fas fa-graduation-cap"></i>
                                    <h5>Promotion Actions</h5>
                                </div>
                                <div class="promotion-actions-body">
                                    <form method="POST" action="{{ route('promotions.promote', $student->id) }}">
                                        @csrf
                                        <div class="action-row">
                                            <div class="action-label">
                                                <i class="fas fa-award"></i>
                                                Promotional Status
                                            </div>
                                            <div class="action-value">
                                                <select class="form-control @error('promotional_status_id') is-invalid @enderror" 
                                                        name="promotional_status_id" 
                                                        id="promotional_status_select"
                                                        onchange="checkMissingMarks()"
                                                        required>
                                                    <option value="">Select Status</option>
                                                    @foreach($promotionalStatuses as $status)
                                                        <option value="{{ $status->id }}" 
                                                                {{ (old('promotional_status_id', $existingPromotion->promotional_status_id ?? '') == $status->id) ? 'selected' : '' }}>
                                                            {{ $status->description }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('promotional_status_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                @if(!empty($missingMarks))
                                                    <div id="missing-marks-warning" class="alert alert-warning mt-2" style="display: none;">
                                                        <i class="fas fa-exclamation-triangle"></i>
                                                        <strong>Warning:</strong> Cannot promote student - exam marks are missing for some subjects.
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="action-buttons">
                                            <button type="submit" class="btn promote-btn" id="promote-button">
                                                <i class="fas fa-graduation-cap"></i>
                                                {{ $existingPromotion ? 'Update Promotion' : 'Promote Student' }}
                                            </button>
                                            @if(Auth::user()->hasPermission('view-promotion-history'))
                                                <a href="{{ route('promotions.history', $student->id) }}" class="btn history-btn">
                                                    <i class="fas fa-history"></i>
                                                    Promotion History
                                                </a>
                                            @endif
                                            @if(!empty($missingMarks))
                                                <button type="button" class="btn warning-btn" data-toggle="modal" data-target="#missingMarksModal">
                                                    <i class="fas fa-exclamation-triangle"></i>
                                                    Warning
                                                </button>
                                            @endif
                                        </div>
                                    </form>
                                    
                                    <!-- Promotion Disclaimer -->
                                    <div class="promotion-disclaimer mt-3">
                                        <div class="alert alert-info">
                                            <i class="fas fa-info-circle mr-2"></i>
                                            <small><strong>Please note:</strong> Once students are promoted, their marks can no longer be edited and their academic registration for the year will no longer remain active.</small>
                                        </div>
                                    </div>
                                    
                                    @if($existingPromotion)
                                        <div class="current-status mt-3">
                                            <div class="status-header">Current Status</div>
                                            <div class="status-badge">
                                                <span class="badge {{ $existingPromotion->promotionalStatus->promoted === 'Yes' ? 'badge-success' : 'badge-danger' }}">
                                                    {{ $existingPromotion->promotionalStatus->description }}
                                                </span>
                                            </div>
                                            <small class="text-muted">
                                                Promoted on {{ $existingPromotion->promoted_at->format('d M Y') }}
                                            </small>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Missing Marks Warning Modal -->
                    @if(!empty($missingMarks))
                        <div class="modal fade" id="missingMarksModal" tabindex="-1" role="dialog" aria-labelledby="missingMarksModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header bg-warning text-dark">
                                        <h5 class="modal-title" id="missingMarksModalLabel">
                                            <i class="fas fa-exclamation-triangle mr-2"></i>
                                            Missing Exam Marks Warning
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="alert alert-warning">
                                            <h6><strong>Warning: Exam marks are missing for the following subjects:</strong></h6>
                                            <ul class="mt-3 mb-3">
                                                @foreach($missingMarks as $missing)
                                                    <li>{{ $missing }}</li>
                                                @endforeach
                                            </ul>
                                            <p class="mb-0"><strong>Promotion cannot proceed until all exam marks are captured.</strong></p>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Success/Error Messages -->
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle"></i> {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif


                    <!-- Exam Marks Table -->
                    <div class="card mb-4">
                        <div class="card-header" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white;">
                            <h5 class="mb-0"><i class="fas fa-chart-bar"></i> Exam Marks</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                                        <tr>
                                            <th style="border: none; padding: 16px 12px; font-weight: 600;">Subject</th>
                                            <th style="border: none; padding: 16px 12px; font-weight: 600;">Exam Type</th>
                                            <th style="border: none; padding: 16px 12px; font-weight: 600;">Marks Obtained</th>
                                            <th style="border: none; padding: 16px 12px; font-weight: 600;">Total Marks</th>
                                            <th style="border: none; padding: 16px 12px; font-weight: 600;">Percentage</th>
                                            <th style="border: none; padding: 16px 12px; font-weight: 600;">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($registeredModules as $registration)
                                            @php
                                                $moduleMarks = $examMarks[$registration->module_id] ?? collect();
                                                $hasMarks = $moduleMarks->isNotEmpty();
                                            @endphp
                                            @if($hasMarks)
                                                @foreach($moduleMarks as $mark)
                                                <tr>
                                                    <td style="padding: 16px 12px; font-weight: 500;">
                                                        {{ $registration->module->subject_name ?? 'Unknown Subject' }}
                                                        @if($registration->module->subject_code)
                                                            <br><small class="text-muted">{{ $registration->module->subject_code }}</small>
                                                        @endif
                                                    </td>
                                                    <td style="padding: 16px 12px;">
                                                        {{ $mark->examType->name ?? 'N/A' }}
                                                    </td>
                                                    <td style="padding: 16px 12px;">{{ $mark->marks_obtained }}</td>
                                                    <td style="padding: 16px 12px;">{{ $mark->total_marks }}</td>
                                                    <td style="padding: 16px 12px;">
                                                        <span class="badge {{ $mark->percentage >= 50 ? 'badge-success' : 'badge-danger' }}">
                                                            {{ $mark->percentage }}%
                                                        </span>
                                                    </td>
                                                    <td style="padding: 16px 12px;">
                                                        <span class="badge {{ $mark->percentage >= 50 ? 'badge-success' : 'badge-danger' }}">
                                                            {{ $mark->percentage >= 50 ? 'Pass' : 'Fail' }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td style="padding: 16px 12px; font-weight: 500;">
                                                        {{ $registration->module->subject_name ?? 'Unknown Subject' }}
                                                        @if($registration->module->subject_code)
                                                            <br><small class="text-muted">{{ $registration->module->subject_code }}</small>
                                                        @endif
                                                    </td>
                                                    <td style="padding: 16px 12px;">N/A</td>
                                                    <td style="padding: 16px 12px; color: #dc3545;">
                                                        <i class="fas fa-clock"></i> Results Pending
                                                    </td>
                                                    <td colspan="3" style="padding: 16px 12px;">-</td>
                                                </tr>
                                            @endif
                                        @empty
                                        <tr>
                                            <td colspan="6" class="text-center" style="padding: 40px; color: #6c757d;">
                                                <i class="fas fa-book fa-3x mb-3" style="opacity: 0.3;"></i>
                                                <p class="mb-0">No registered modules found for this student.</p>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<style>
/* Student Information Card Styling */
.student-info-card {
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.9) 0%, rgba(248, 249, 250, 0.9) 100%);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 12px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    transition: all 0.3s ease;
}

.student-info-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
}

.student-info-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 20px;
    display: flex;
    align-items: center;
    gap: 12px;
}

.student-info-header i {
    font-size: 1.5rem;
    opacity: 0.9;
}

.student-info-header h5 {
    margin: 0;
    font-weight: 600;
    font-size: 1.1rem;
}

.student-info-body {
    padding: 24px;
}

.info-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 0;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    transition: all 0.2s ease;
}

.info-row:last-child {
    border-bottom: none;
    padding-bottom: 0;
}

.info-row:hover {
    background: rgba(102, 126, 234, 0.05);
    margin: 0 -12px;
    padding-left: 12px;
    padding-right: 12px;
    border-radius: 6px;
}

.info-label {
    display: flex;
    align-items: center;
    gap: 8px;
    font-weight: 600;
    color: #495057;
    font-size: 0.9rem;
    min-width: 120px;
}

.info-label i {
    color: #667eea;
    width: 16px;
    text-align: center;
}

.info-value {
    font-weight: 500;
    color: #212529;
    text-align: right;
    flex: 1;
}

/* Promotion Actions Card Styling */
.promotion-actions-card {
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.9) 0%, rgba(248, 249, 250, 0.9) 100%);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 12px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    transition: all 0.3s ease;
}

.promotion-actions-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
}

.promotion-actions-header {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    color: white;
    padding: 20px;
    display: flex;
    align-items: center;
    gap: 12px;
}

.promotion-actions-header i {
    font-size: 1.5rem;
    opacity: 0.9;
}

.promotion-actions-header h5 {
    margin: 0;
    font-weight: 600;
    font-size: 1.1rem;
}

.promotion-actions-body {
    padding: 24px;
}

.action-row {
    margin-bottom: 20px;
}

.action-label {
    display: flex;
    align-items: center;
    gap: 8px;
    font-weight: 600;
    color: #495057;
    font-size: 0.9rem;
    margin-bottom: 8px;
}

.action-label i {
    color: #28a745;
    width: 16px;
    text-align: center;
}

.action-value select {
    border: 2px solid rgba(40, 167, 69, 0.2);
    border-radius: 8px;
    padding: 10px 12px;
    transition: all 0.3s ease;
}

.action-value select:focus {
    border-color: #28a745;
    box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
}

.action-buttons {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
}

.promote-btn {
    background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%);
    color: white;
    border: none;
    border-radius: 8px;
    padding: 12px 20px;
    font-weight: 600;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    text-align: center;
    min-height: 48px;
}

.promote-btn:hover {
    background: linear-gradient(135deg, #5a32a3 0%, #0056b3 100%);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(111, 66, 193, 0.3);
    color: white;
}

.history-btn {
    background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
    color: white;
    border: none;
    border-radius: 8px;
    padding: 12px 20px;
    font-weight: 600;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    text-decoration: none;
    text-align: center;
    min-height: 48px;
}

.history-btn:hover {
    background: linear-gradient(135deg, #138496 0%, #0f6674 100%);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(23, 162, 184, 0.3);
    color: white;
    text-decoration: none;
}

.warning-btn {
    background: linear-gradient(135deg, #ffc107 0%, #ff8c00 100%);
    color: #212529;
    border: none;
    border-radius: 8px;
    padding: 12px 20px;
    font-weight: 600;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    text-decoration: none;
    text-align: center;
    min-height: 48px;
}

.warning-btn:hover {
    background: linear-gradient(135deg, #e0a800 0%, #e67e00 100%);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(255, 193, 7, 0.3);
    color: #212529;
    text-decoration: none;
}

.current-status {
    background: rgba(40, 167, 69, 0.05);
    border: 1px solid rgba(40, 167, 69, 0.2);
    border-radius: 8px;
    padding: 16px;
}

.status-header {
    font-weight: 600;
    color: #495057;
    font-size: 0.9rem;
    margin-bottom: 8px;
}

.status-badge {
    margin-bottom: 4px;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .info-row {
        flex-direction: column;
        align-items: flex-start;
        gap: 4px;
    }
    
    .info-label {
        min-width: auto;
    }
    
    .info-value {
        text-align: left;
        width: 100%;
    }
    
    .action-buttons {
        flex-direction: column;
    }
    
    .promote-btn, .history-btn, .warning-btn {
        width: 100%;
        justify-content: center;
    }
}
</style>
@endsection

@section('scripts')
<script>
function toggleAllMarks() {
    var checkboxes = document.querySelectorAll('input[name="selected_marks[]"]');
    var selectAllCheckbox = document.getElementById('select-all');
    
    checkboxes.forEach(function(checkbox) {
        checkbox.checked = selectAllCheckbox.checked;
    });
}

function checkMissingMarks() {
    var select = document.getElementById('promotional_status_select');
    var warning = document.getElementById('missing-marks-warning');
    var button = document.getElementById('promote-button');
    
    @if(!empty($missingMarks))
        if (select.value !== '') {
            warning.style.display = 'block';
            button.disabled = true;
            button.style.opacity = '0.6';
            button.style.cursor = 'not-allowed';
        } else {
            warning.style.display = 'none';
            button.disabled = false;
            button.style.opacity = '1';
            button.style.cursor = 'pointer';
        }
    @endif
}

// Check on page load if there's a pre-selected value
document.addEventListener('DOMContentLoaded', function() {
    checkMissingMarks();
});
</script>
@endsection
