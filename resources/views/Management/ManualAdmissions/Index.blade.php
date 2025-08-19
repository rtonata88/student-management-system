@extends('layouts.app')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Admissions</li>
        <li class="breadcrumb-item active"><a href="/manual-admissions">Manual Admissions</a></li>
        <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection
@section('content')
<div class="container-fluid">
    <!-- Header Section with Title, Filters and Add Button -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div class="mb-2 mb-md-0">
                    <h2 class="mb-1">Manual Admissions</h2>
                    <p class="text-muted mb-0">Manage students with full admission status</p>
                </div>
                <div class="d-flex align-items-center flex-wrap gap-2">
                    <!-- Search Filters -->
                    {!! Form::open(array('route' => array('manual-admissions.filter'), 'method' => 'post', 'class'=> 'd-flex align-items-center flex-wrap gap-2 me-3')) !!}
                    <div class="input-group" style="width: 200px;">
                        {{Form::text('student_number', null, ['class' => 'form-control form-control-sm', 'placeholder' => 'Student Number'])}}
                    </div>
                    <div class="input-group" style="width: 200px;">
                        {{Form::text('names', null, ['class' => 'form-control form-control-sm', 'placeholder' => 'Student Name'])}}
                    </div>
                    <button type="submit" class="btn btn-sm btn-outline-primary">
                        <i class="fa fa-search"></i> Search
                    </button>
                    <a href="/manual-admissions" class="btn btn-sm btn-outline-secondary">
                        <i class="fa fa-refresh"></i> Clear
                    </a>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Card -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" style="width:100%">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0 ps-3">STUDENT #</th>
                                    <th class="border-0">SURNAME</th>
                                    <th class="border-0">FIRST NAMES</th>
                                    <th class="border-0">D.O.B</th>
                                    <th class="border-0">ID NUMBER</th>
                                    <th class="border-0">MOBILE #</th>
                                    <th class="border-0">EMAIL ADDRESS</th>
                                    <th class="border-0 text-center">ACTION</th>
                                    <th class="border-0 text-center">STATUS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($students as $student)
                                <tr class="border-bottom">
                                    <td class="ps-3 py-3">
                                        <strong class="text-primary">{{$student->student_number2}}</strong>
                                    </td>
                                    <td class="py-3">{{$student->surname}}</td>
                                    <td class="py-3">{{$student->student_names}}</td>
                                    <td class="py-3">
                                        @if($student->date_of_birth)
                                            {{\Carbon\Carbon::parse($student->date_of_birth)->format('Y-m-d')}}
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="py-3">
                                        @if($student->id_number)
                                            {{$student->id_number}}
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="py-3">
                                        @if($student->contact_number)
                                            {{$student->contact_number}}
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="py-3">
                                        @if($student->contact_email)
                                            {{$student->contact_email}}
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="py-3 text-center">
                                        <div class="dropdown d-flex justify-content-center">
                                            <button class="btn btn-sm btn-light border" type="button" data-toggle="dropdown" aria-expanded="false" style="width: 30px; height: 30px; display: flex; align-items: center; justify-content: center;">
                                                <span style="font-weight: bold; font-size: 18px; color: #333; line-height: 1;">⋯</span>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                @permission('show-student')
                                                <a class="dropdown-item" href="{{route('students.show', $student->id)}}?return=manual-admissions">
                                                    <i class="fa fa-eye"></i> View
                                                </a>
                                                @endpermission
                                                @permission('edit-student')
                                                <a class="dropdown-item" href="{{route('students.edit', $student->id)}}?return=manual-admissions">
                                                    <i class="fa fa-edit"></i> Update
                                                </a>
                                                @endpermission
                                                <a class="dropdown-item" href="#" onclick="event.preventDefault(); openAdmissionModal({{$student->id}}, '{{str_replace("'", "\\'", $student->student_names)}} {{str_replace("'", "\\'", $student->surname)}}'); return false;">
                                                    <i class="fa fa-graduation-cap"></i> Admissions
                                                </a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item text-success" href="#" onclick="event.preventDefault(); generateAdmissionLetter({{$student->id}}); return false;">
                                                    <i class="fa fa-file-pdf-o"></i> Admission Letter
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3 text-center d-flex justify-content-center align-items-center">
                                        <div class="status-dot status-dot-admitted" title="Full Admission"></div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="fa fa-graduation-cap fa-3x mb-3"></i>
                                            <h5>No Fully Admitted Students Found</h5>
                                            <p>There are no students with full admission status matching your search criteria.</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    @if($students->hasPages())
                    <div class="card-footer bg-light border-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-muted">
                                Showing {{ $students->firstItem() }} to {{ $students->lastItem() }} of {{ $students->total() }} results
                            </div>
                            <div>
                                {{$students->links()}}
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
:root {
    --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --primary-color: #667eea;
    --secondary-color: #764ba2;
    --hover-gradient: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
}

.gap-2 {
    gap: 0.5rem;
}

.table-hover tbody tr:hover {
    background-color: rgba(0,0,0,.02);
}

.dropdown-toggle::after {
    display: none;
}

/* Primary button with gradient */
.btn-primary {
    background: var(--primary-gradient) !important;
    border: none !important;
    color: white !important;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    background: var(--hover-gradient) !important;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
}

/* Search button styling */
.btn-outline-primary {
    border: 2px solid var(--primary-color) !important;
    color: var(--primary-color) !important;
    background: transparent !important;
    transition: all 0.3s ease;
}

.btn-outline-primary:hover {
    background: var(--primary-gradient) !important;
    border-color: transparent !important;
    color: white !important;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
}

/* Student number styling */
.text-primary {
    background: var(--primary-gradient);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    font-weight: 600 !important;
}

/* Pagination styling */
.pagination .page-link {
    color: var(--primary-color) !important;
    border-color: #dee2e6;
    transition: all 0.3s ease;
}

.pagination .page-link:hover {
    background: var(--primary-gradient) !important;
    border-color: transparent !important;
    color: white !important;
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);
}

.pagination .page-item.active .page-link {
    background: var(--primary-gradient) !important;
    border-color: transparent !important;
    color: white !important;
}

/* Clear button styling */
.btn-outline-secondary:hover {
    background: linear-gradient(135deg, #6c757d 0%, #495057 100%) !important;
    border-color: transparent !important;
    color: white !important;
    transform: translateY(-1px);
}

/* Three dots button hover */
.btn-light:hover {
    background: var(--primary-gradient) !important;
    border-color: transparent !important;
    color: white !important;
}

/* Status dot styling */
.status-dot {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    display: inline-block;
    cursor: help;
    transition: all 0.3s ease;
}

.status-dot:hover {
    transform: scale(1.2);
    box-shadow: 0 2px 8px rgba(0,0,0,0.2);
}

.status-dot-admitted {
    background: linear-gradient(135deg, #66bb6a 0%, #4caf50 100%);
    opacity: 0.7;
}

/* Admission Letter button styling */
.dropdown-item.text-success:hover {
    background-color: #d4edda !important;
    color: #155724 !important;
}

@media (max-width: 768px) {
    .d-flex.flex-wrap .input-group {
        width: 100% !important;
        margin-bottom: 0.5rem;
    }
    .d-flex.flex-wrap .btn {
        margin-bottom: 0.5rem;
    }
}
</style>

<!-- Admission Status Modal -->
<div class="modal fade" id="admissionModal" tabindex="-1" role="dialog" aria-labelledby="admissionModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="admissionModalLabel">Update Admission Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="admissionForm" method="POST" action="#">
                @csrf
                <div class="modal-body">
                    <input type="hidden" id="studentId" name="student_id" value="">
                    
                    <div class="form-group">
                        <label for="studentName"><strong>Student:</strong></label>
                        <p id="studentName" class="form-control-plaintext"></p>
                    </div>
                    
                    <div class="form-group">
                        <label for="admissionStatus">Admission Status <span class="text-danger">*</span></label>
                        <select class="form-control" id="admissionStatus" name="admission_status" required>
                            <option value="">Select Status</option>
                            <option value="rejected">Rejected</option>
                            <option value="provisionally_admitted">Provisionally Admitted</option>
                            <option value="full_admission">Full Admission</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="remarks">Remarks</label>
                        <textarea class="form-control" id="remarks" name="remarks" rows="4" placeholder="Enter reason for the selected status..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeAdmissionModal()">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Status</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openAdmissionModal(studentId, studentName) {
    console.log('Opening modal for student:', studentId, studentName);
    
    // Set form values
    document.getElementById('studentId').value = studentId;
    document.getElementById('studentName').textContent = studentName;
    
    // Fetch existing admission status
    fetch('/manual-admissions/' + studentId + '/admission-status', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success && data.admission) {
            // Pre-fill form with existing data
            document.getElementById('admissionStatus').value = data.admission.admission_status;
            document.getElementById('remarks').value = data.admission.remarks || '';
        } else {
            // Clear form for new admission
            document.getElementById('admissionStatus').value = '';
            document.getElementById('remarks').value = '';
        }
    })
    .catch(error => {
        console.error('Error fetching admission status:', error);
        // Clear form on error
        document.getElementById('admissionStatus').value = '';
        document.getElementById('remarks').value = '';
    });
    
    // Show modal using Bootstrap 4 approach (most compatible)
    var modal = document.getElementById('admissionModal');
    modal.style.display = 'block';
    modal.classList.add('show');
    modal.setAttribute('aria-hidden', 'false');
    document.body.classList.add('modal-open');
    
    // Add backdrop
    var existingBackdrop = document.querySelector('.modal-backdrop');
    if (!existingBackdrop) {
        var backdrop = document.createElement('div');
        backdrop.className = 'modal-backdrop fade show';
        backdrop.id = 'modal-backdrop';
        document.body.appendChild(backdrop);
        
        // Close modal when clicking backdrop
        backdrop.onclick = function() {
            closeAdmissionModal();
        };
    }
}

function closeAdmissionModal() {
    var modal = document.getElementById('admissionModal');
    modal.style.display = 'none';
    modal.classList.remove('show');
    modal.setAttribute('aria-hidden', 'true');
    document.body.classList.remove('modal-open');
    
    var backdrop = document.getElementById('modal-backdrop');
    if (backdrop) {
        backdrop.remove();
    }
}

function generateAdmissionLetter(studentId) {
    // Show loading state
    const originalText = event.target.innerHTML;
    event.target.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Generating...';
    event.target.disabled = true;
    
    // Create a temporary link to trigger download
    const link = document.createElement('a');
    link.href = '/manual-admissions/' + studentId + '/admission-letter';
    link.download = '';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    
    // Reset button state after a short delay
    setTimeout(() => {
        event.target.innerHTML = originalText;
        event.target.disabled = false;
    }, 2000);
}

// Handle form submission
document.getElementById('admissionForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const studentId = formData.get('student_id');
    const status = formData.get('admission_status');
    const remarks = formData.get('remarks');
    
    // Submit to backend
    fetch('/manual-admissions/' + studentId + '/admission-status', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            admission_status: status,
            remarks: remarks
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Admission status updated successfully!');
            closeAdmissionModal();
            location.reload(); // Refresh to show updated data
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while updating admission status');
    });
});
</script>

@endsection
