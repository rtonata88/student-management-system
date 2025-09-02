@extends('layouts.student-portal')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white;">
                    <h4 class="mb-0"><i class="fas fa-book"></i> Select Your Subjects</h4>
                    <small>Step 3 of 5 - Choose the subjects you want to study</small>
                </div>
                
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                        <div class="card mb-4">
                            <div class="card-header">
                                <h5><i class="fas fa-list-check"></i> Available Subjects</h5>
                                <small class="text-muted">Select at least one subject to continue</small>
                            </div>
                            <div class="card-body">
                                <!-- Search Field -->
                                <div class="row mb-4">
                                    <div class="col-md-8">
                                        <form method="GET" action="{{ route('online-application.subject-selection') }}">
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="search" 
                                                       placeholder="Search subjects by name or code..." 
                                                       value="{{ $search ?? '' }}">
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-secondary" type="submit">
                                                        <i class="fas fa-search"></i>
                                                    </button>
                                                    <a href="{{ route('online-application.subject-selection') }}" class="btn btn-outline-danger" title="Clear search">
                                                        <i class="fas fa-times"></i> Clear
                                                    </a>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-md-4 text-right">
                                        <small class="text-muted">
                                            Showing {{ $subjects->firstItem() ?? 0 }} to {{ $subjects->lastItem() ?? 0 }} 
                                            of {{ $subjects->total() }} subjects
                                        </small>
                                    </div>
                                </div>

                    <form action="{{ route('online-application.store-subject-selection') }}" method="POST">
                        @csrf

                                @if($subjects->isEmpty())
                                    <div class="alert alert-warning">
                                        <i class="fas fa-exclamation-triangle"></i> 
                                        @if($search)
                                            No subjects found matching "{{ $search }}". <a href="{{ route('online-application.subject-selection') }}">Show all subjects</a>
                                        @else
                                            No subjects are currently available. Please contact the administration.
                                        @endif
                                    </div>
                                @else
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                                                <tr>
                                                    <th width="30%">Subject</th>
                                                    <th width="12%">Code</th>
                                                    <th width="12%" class="text-right">Monthly</th>
                                                    <th width="12%" class="text-center">Duration</th>
                                                    <th width="14%" class="text-right">Total Fee</th>
                                                    <th width="10%" class="text-center">Credits</th>
                                                    <th width="10%" class="text-center" style="vertical-align: middle;">
                                                        <div class="d-flex justify-content-center align-items-center" style="height: 100%;">
                                                            <input type="checkbox" id="select-all" class="form-check-input" style="width: 20px; height: 20px; cursor: pointer; margin: 0;">
                                                        </div>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($subjects as $subject)
                                                    <tr class="subject-row" data-subject-id="{{ $subject->id }}" data-subject-fee="{{ $subject->subject_fees ?? 0 }}" style="cursor: pointer; transition: all 0.3s ease;">
                                                        <td class="align-middle">
                                                            <div class="d-flex align-items-center">
                                                                <div class="subject-icon me-3" style="width: 40px; height: 40px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; margin-right: 12px;">
                                                                    {{ substr($subject->subject_name, 0, 1) }}
                                                                </div>
                                                                <div>
                                                                    <h6 class="mb-0 subject-name">{{ $subject->subject_name }}</h6>
                                                                    <small class="text-muted">{{ $subject->description ?? 'No description available' }}</small>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="align-middle">
                                                            <span class="badge badge-light" style="background: #f8f9fa; color: #495057; padding: 6px 12px; border-radius: 6px;">
                                                                {{ $subject->subject_code }}
                                                            </span>
                                                        </td>
                                                        <td class="align-middle text-right">
                                                            <span class="fee-amount" style="font-weight: 600; color: #28a745; font-size: 1.1em;">
                                                                N${{ number_format($subject->subject_fees ?? 0, 2) }}
                                                            </span>
                                                        </td>
                                                        <td class="align-middle text-center">
                                                            <span class="badge badge-secondary" style="background: #6c757d; padding: 6px 12px; border-radius: 6px;">
                                                                {{ $courseDurationMonths }} months
                                                            </span>
                                                        </td>
                                                        <td class="align-middle text-right">
                                                            <span class="fee-amount" style="font-weight: 600; color: #dc3545; font-size: 1.1em;">
                                                                N${{ number_format(($subject->subject_fees ?? 0) * $courseDurationMonths, 2) }}
                                                            </span>
                                                        </td>
                                                        <td class="align-middle text-center">
                                                            <span class="badge badge-info" style="background: #17a2b8; padding: 6px 12px; border-radius: 6px;">
                                                                {{ $subject->credits ?? 3 }}
                                                            </span>
                                                        </td>
                                                        <td class="text-center align-middle" style="vertical-align: middle;">
                                                            <div class="d-flex justify-content-center align-items-center" style="height: 100%; min-height: 60px;">
                                                                <input class="form-check-input subject-checkbox" type="checkbox" 
                                                                       name="subjects[]" value="{{ $subject->id }}" 
                                                                       id="subject_{{ $subject->id }}"
                                                                       style="width: 20px; height: 20px; cursor: pointer; margin: 0;"
                                                                       {{ in_array($subject->id, $selectedSubjects) ? 'checked' : '' }}>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    
                                    <!-- Pagination -->
                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <div>
                                            {{ $subjects->appends(request()->query())->links() }}
                                        </div>
                                        <div>
                                            <small class="text-muted">
                                                Page {{ $subjects->currentPage() }} of {{ $subjects->lastPage() }}
                                            </small>
                                        </div>
                                    </div>
                                    
                                    <div class="mt-4 p-4" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 12px; border-left: 4px solid #667eea;">
                                        <h6><i class="fas fa-calculator"></i> Fee Summary</h6>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <p class="mb-1"><strong>Selected Subjects:</strong> <span id="selected-count">{{ count($selectedSubjects) }}</span></p>
                                            </div>
                                            <div class="col-md-3">
                                                <p class="mb-1"><strong>Course Duration:</strong> {{ $courseDurationMonths }} months</p>
                                            </div>
                                            <div class="col-md-3">
                                                <p class="mb-1"><strong>Monthly Fee:</strong> N$<span id="monthly-fee">0.00</span></p>
                                            </div>
                                            <div class="col-md-3">
                                                <p class="mb-1" style="white-space: nowrap;"><strong>Total Subjects Fee:</strong> N$<span id="total-fee">0.00</span></p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Navigation Buttons -->
                        <div class="card">
                            <div class="card-footer text-center">
                                <button type="submit" class="btn btn-lg mr-3" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.75rem 2rem;" id="continue-btn" disabled>
                                    <i class="fas fa-arrow-right"></i> Continue to Document Upload
                                </button>
                                <a href="{{ route('online-application.student-info') }}" class="btn btn-secondary btn-lg" style="padding: 0.75rem 2rem;">
                                    <i class="fas fa-arrow-left"></i> Back
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.subject-row:hover {
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.subject-row.selected {
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
    border-left: 4px solid #667eea;
}

.subject-row.selected .subject-name {
    color: #667eea;
    font-weight: 600;
}

.subject-row.selected .fee-amount {
    color: #667eea !important;
    font-weight: 700;
}

.table th {
    border: none;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.85rem;
    letter-spacing: 0.5px;
}

.table td {
    border-top: 1px solid #e9ecef;
    vertical-align: middle;
}

.subject-icon {
    transition: all 0.3s ease;
}

.subject-row:hover .subject-icon {
    transform: scale(1.1);
}

.form-check-input:checked {
    background-color: #667eea;
    border-color: #667eea;
}

.badge {
    font-size: 0.8rem;
    font-weight: 500;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('.subject-checkbox');
    const continueBtn = document.getElementById('continue-btn');
    const selectedCountSpan = document.getElementById('selected-count');
    const totalFeeSpan = document.getElementById('total-fee');
    
    const selectAllCheckbox = document.getElementById('select-all');
    const monthlyFeeSpan = document.getElementById('monthly-fee');
    const courseDurationMonths = {{ $courseDurationMonths }};
    
    // All subject fees for calculations across pages
    const allSubjectFees = @json($allSubjectFees);
    
    // Get selected subjects from server (make it mutable)
    let selectedSubjects = @json($selectedSubjects);
    
    function updateSummary() {
        let selectedCount = selectedSubjects.length;
        let monthlyFee = 0;
        
        // Calculate fees for all selected subjects
        selectedSubjects.forEach(subjectId => {
            const fee = parseFloat(allSubjectFees[subjectId]) || 0;
            monthlyFee += fee;
        });
        
        // Update visual state for current page checkboxes based on selectedSubjects array
        checkboxes.forEach(checkbox => {
            const subjectId = parseInt(checkbox.value);
            const isSelected = selectedSubjects.includes(subjectId);
            checkbox.checked = isSelected;
            
            const row = checkbox.closest('.subject-row');
            if (isSelected) {
                row.classList.add('selected');
            } else {
                row.classList.remove('selected');
            }
        });
        
        const totalCourseFee = monthlyFee * courseDurationMonths;
        
        selectedCountSpan.textContent = selectedCount;
        monthlyFeeSpan.textContent = monthlyFee.toFixed(2);
        totalFeeSpan.textContent = totalCourseFee.toFixed(2);
        continueBtn.disabled = selectedCount === 0;
        
        // Update select all checkbox for current page only
        if (selectAllCheckbox) {
            const currentPageSelected = Array.from(checkboxes).filter(cb => cb.checked).length;
            selectAllCheckbox.checked = currentPageSelected === checkboxes.length && checkboxes.length > 0;
            selectAllCheckbox.indeterminate = currentPageSelected > 0 && currentPageSelected < checkboxes.length;
        }
    }
    
    // Individual checkbox change
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const subjectId = parseInt(this.value);
            if (this.checked) {
                // Add to selected subjects if not already there
                if (!selectedSubjects.includes(subjectId)) {
                    selectedSubjects.push(subjectId);
                }
            } else {
                // Remove from selected subjects
                const index = selectedSubjects.indexOf(subjectId);
                if (index > -1) {
                    selectedSubjects.splice(index, 1);
                }
            }
            updateSummary();
        });
    });
    
    // Row click to toggle checkbox
    document.querySelectorAll('.subject-row').forEach(row => {
        row.addEventListener('click', function(e) {
            if (e.target.type !== 'checkbox') {
                const checkbox = row.querySelector('.subject-checkbox');
                checkbox.checked = !checkbox.checked;
                checkbox.dispatchEvent(new Event('change'));
            }
        });
    });
    
    // Select all functionality
    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            if (selectAllCheckbox.checked) {
                // Select all subjects on current page
                checkboxes.forEach(checkbox => {
                    const subjectId = parseInt(checkbox.value);
                    if (!selectedSubjects.includes(subjectId)) {
                        selectedSubjects.push(subjectId);
                    }
                });
            } else {
                // Deselect all subjects on current page
                checkboxes.forEach(checkbox => {
                    const subjectId = parseInt(checkbox.value);
                    const index = selectedSubjects.indexOf(subjectId);
                    if (index > -1) {
                        selectedSubjects.splice(index, 1);
                    }
                });
            }
            updateSummary();
        });
    }
    
    // Initial update
    updateSummary();
});
</script>
@endsection

<style>
/* Custom pagination styling with gradient theme */
.pagination .page-link {
    color: #667eea;
    border-color: #dee2e6;
    background-color: #fff;
    transition: all 0.3s ease;
}

.pagination .page-link:hover {
    color: #fff;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-color: #667eea;
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(102, 126, 234, 0.3);
}

.pagination .page-item.active .page-link {
    color: #fff;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-color: #667eea;
    box-shadow: 0 2px 4px rgba(102, 126, 234, 0.3);
}

.pagination .page-item.disabled .page-link {
    color: #6c757d;
    background-color: #fff;
    border-color: #dee2e6;
}

.pagination .page-link:focus {
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}
</style>
