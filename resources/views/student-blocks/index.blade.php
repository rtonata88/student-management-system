@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="card-title">Student Blocks</h3>
                        </div>
                        <div class="col-md-6 text-right">
                            @can('view-student-blocks')
                                <a href="{{ route('student-blocks.create') }}" class="btn mr-2" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                                    <i class="fa fa-ban"></i> Block Student
                                </a>
                            @endcan
                            @can('bulk-block-students')
                                <button type="button" class="btn mr-2" data-toggle="modal" data-target="#bulkBlockModal" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                                    <i class="fa fa-users"></i> Bulk Block
                                </button>
                            @endcan
                            @can('create-student-blocks')
                                <a href="{{ route('student-blocks.create') }}" class="btn" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                                    <i class="fa fa-plus"></i> Add New
                                </a>
                            @endcan
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Filter Form -->
                    <form method="GET" action="{{ route('student-blocks.index') }}" class="mb-4">
                        <div class="row">
                            <div class="col-md-2">
                                <select name="center_id" id="center_id" class="form-control">
                                    <option value="">Select Center...</option>
                                    @foreach($centers as $center)
                                        <option value="{{ $center->id }}" {{ request('center_id') == $center->id ? 'selected' : '' }}>
                                            {{ $center->center_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="gender" id="gender" class="form-control">
                                    <option value="">Select Gender</option>
                                    @foreach($genders as $gender)
                                        <option value="{{ $gender }}" {{ request('gender') == $gender ? 'selected' : '' }}>
                                            {{ $gender }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <input type="text" name="search" class="form-control" placeholder="Search by student number or name..." value="{{ request('search') }}">
                            </div>
                            <div class="col-md-1">
                                <select name="status" class="form-control">
                                    <option value="">All Status</option>
                                    <option value="blocked" {{ request('status') == 'blocked' ? 'selected' : '' }}>Blocked</option>
                                    <option value="unblocked" {{ request('status') == 'unblocked' ? 'selected' : '' }}>Unblocked</option>
                                    <option value="exception" {{ request('status') == 'exception' ? 'selected' : '' }}>Exception</option>
                                </select>
                            </div>
                            <div class="col-md-1">
                                <button type="submit" class="btn" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                                    <i class="fa fa-search"></i> Search
                                </button>
                            </div>
                            <div class="col-md-1">
                                <a href="{{ route('student-blocks.index') }}" class="btn btn-secondary">Reset</a>
                            </div>
                            <div class="col-md-3 text-right">
                                <a href="{{ route('student-blocks.create') }}" class="btn btn-sm" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white; border: none; border-radius: 6px; padding: 0.25rem 0.5rem;">
                                    <i class="fa fa-ban"></i> Block Student
                                </a>
                                <button type="button" class="btn btn-sm ml-1" data-toggle="modal" data-target="#bulkBlockModal" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.25rem 0.5rem;">
                                    <i class="fa fa-users"></i> Bulk Block
                                </button>
                                <button type="button" class="btn btn-sm ml-1" data-toggle="modal" data-target="#bulkUnblockModal" style="background: linear-gradient(135deg, #dc3545 0%, #fd7e14 100%); color: white; border: none; border-radius: 6px; padding: 0.25rem 0.5rem;">
                                    <i class="fa fa-unlock"></i> Bulk Unblock
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Results Table -->
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Student #</th>
                                    <th>Surname</th>
                                    <th>First Names</th>
                                    <th>Center</th>
                                    <th>Gender</th>
                                    <th>Block Amount</th>
                                    <th>Reason</th>
                                    <th>Batch Number</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($studentBlocks as $block)
                                    <tr>
                                        <td>{{ $block->student_number }}</td>
                                        <td>{{ $block->student->surname ?? 'N/A' }}</td>
                                        <td>{{ $block->student->student_names ?? 'N/A' }}</td>
                                        <td>{{ $block->student->center->center_name ?? 'N/A' }}</td>
                                        <td>{{ $block->student->gender ?? 'N/A' }}</td>
                                        <td>{{ number_format($block->block_amount, 2) }}</td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#reasonModal{{ $block->id }}">
                                                <i class="fa fa-eye"></i> View
                                            </button>
                                        </td>
                                        <td>{{ $block->batch_number }}</td>
                                        <td>
                                            <form action="{{ route('student-blocks.unblock', $block->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to revoke this block? The student will be removed from the blocked list.')">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm" style="background: #dc3545; color: white; border: none; border-radius: 4px; padding: 0.25rem 0.5rem;">
                                                    <i class="fa fa-unlock"></i> Revoke
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">No student blocks found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center">
                        {{ $studentBlocks->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reason Modals -->
@foreach($studentBlocks as $block)
<div class="modal fade" id="reasonModal{{ $block->id }}" tabindex="-1" role="dialog" aria-labelledby="reasonModalLabel{{ $block->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reasonModalLabel{{ $block->id }}">Block Reason - {{ $block->student_number }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label><strong>Student:</strong></label>
                    <p>{{ $block->student->surname ?? 'N/A' }}, {{ $block->student->student_names ?? 'N/A' }} ({{ $block->student_number }})</p>
                </div>
                <div class="form-group">
                    <label><strong>Block Amount:</strong></label>
                    <p>{{ number_format($block->block_amount, 2) }}</p>
                </div>
                <div class="form-group">
                    <label><strong>Batch Number:</strong></label>
                    <p>{{ $block->batch_number }}</p>
                </div>
                <div class="form-group">
                    <label><strong>Blocked Date:</strong></label>
                    <p>{{ $block->blocked_at ? $block->blocked_at->format('d M Y, H:i') : 'N/A' }}</p>
                </div>
                <div class="form-group">
                    <label><strong>Reason:</strong></label>
                    <div class="border p-3 bg-light" style="min-height: 100px; white-space: pre-wrap;">{{ $block->reason }}</div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endforeach

<!-- Bulk Block Modal -->
<div class="modal fade" id="bulkBlockModal" tabindex="-1" role="dialog" aria-labelledby="bulkBlockModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bulkBlockModalLabel">Bulk Block Students</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('student-blocks.bulk-block.process') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="bulk_academic_year">Academic Year</label>
                                <select name="academic_year_id" id="bulk_academic_year" class="form-control">
                                    <option value="">All Academic Years</option>
                                    @foreach($academicYears as $academicYear)
                                        <option value="{{ $academicYear->id }}">{{ $academicYear->academic_year }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="bulk_center_id">Center <span class="text-danger">*</span></label>
                                <select name="center_id" id="bulk_center_id" class="form-control" required>
                                    <option value="">Select Center</option>
                                    @foreach($centers as $center)
                                        <option value="{{ $center->id }}">{{ $center->center_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="bulk_gender">Gender</label>
                                <select name="gender" id="bulk_gender" class="form-control">
                                    <option value="">All Genders</option>
                                    @foreach($genders as $gender)
                                        <option value="{{ $gender }}">{{ $gender }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="bulk_block_amount">Amount *</label>
                                <input type="number" name="block_amount" id="bulk_block_amount" class="form-control" step="0.01" min="0" placeholder="0.00">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="bulk_subject_id">Subject</label>
                                <select name="subject_id" id="bulk_subject_id" class="form-control">
                                    <option value="">Select Subject</option>
                                    @foreach($subjects as $subject)
                                        <option value="{{ $subject->id }}">{{ $subject->subject_code }} - {{ $subject->subject_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="form-check mt-4">
                                    <input type="checkbox" name="exclude_bursary" id="exclude_bursary" class="form-check-input">
                                    <label class="form-check-label" for="exclude_bursary">
                                        Do not block bursary-linked students
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="bulk_reason">Reason *</label>
                        <textarea name="reason" id="bulk_reason" class="form-control" rows="3" placeholder="Enter reason here..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                        <i class="fa fa-users"></i> Bulk Block Students
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Bulk Unblock Modal -->
<div class="modal fade" id="bulkUnblockModal" tabindex="-1" role="dialog" aria-labelledby="bulkUnblockModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bulkUnblockModalLabel">Bulk Block Revocations</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('student-blocks.bulk-unblock.process') }}" method="POST" onsubmit="return validateBulkUnblockForm()">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label><strong>Revoke Option:</strong></label>
                        <div class="mt-2">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="revoke_option" id="revoke_by_numbers" value="student_numbers" checked>
                                <label class="form-check-label" for="revoke_by_numbers">
                                    Student Numbers
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="revoke_option" id="revoke_by_batch" value="batch_number">
                                <label class="form-check-label" for="revoke_by_batch">
                                    Batch Number
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group" id="student_numbers_section">
                        <label for="unblock_student_numbers">Student Numbers <span class="text-danger">*</span></label>
                        <textarea name="student_numbers" id="unblock_student_numbers" class="form-control" rows="4" placeholder="Enter student numbers separated by commas (e.g., 202381892, 202298712)"></textarea>
                    </div>

                    <div class="form-group" id="batch_number_section" style="display: none;">
                        <label for="unblock_batch_number">Batch Number <span class="text-danger">*</span></label>
                        <input type="text" name="batch_number" id="unblock_batch_number" class="form-control" placeholder="Enter batch number (e.g., 25090352475)">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Revoke</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const studentNumbersRadio = document.getElementById('revoke_by_numbers');
    const batchNumberRadio = document.getElementById('revoke_by_batch');
    const studentNumbersSection = document.getElementById('student_numbers_section');
    const batchNumberSection = document.getElementById('batch_number_section');

    function toggleSections() {
        if (studentNumbersRadio.checked) {
            studentNumbersSection.style.display = 'block';
            batchNumberSection.style.display = 'none';
            document.getElementById('unblock_student_numbers').required = true;
            document.getElementById('unblock_batch_number').required = false;
        } else {
            studentNumbersSection.style.display = 'none';
            batchNumberSection.style.display = 'block';
            document.getElementById('unblock_student_numbers').required = false;
            document.getElementById('unblock_batch_number').required = true;
        }
    }

    studentNumbersRadio.addEventListener('change', toggleSections);
    batchNumberRadio.addEventListener('change', toggleSections);
});

function validateBulkUnblockForm() {
    const revokeOption = document.querySelector('input[name="revoke_option"]:checked').value;
    
    if (revokeOption === 'student_numbers') {
        const studentNumbers = document.getElementById('unblock_student_numbers').value.trim();
        if (!studentNumbers) {
            alert('Please enter at least one student number.');
            return false;
        }
    } else if (revokeOption === 'batch_number') {
        const batchNumber = document.getElementById('unblock_batch_number').value.trim();
        if (!batchNumber) {
            alert('Please enter a batch number.');
            return false;
        }
    }
    
    return confirm('Are you sure you want to revoke these student blocks? This action cannot be undone.');
}
</script>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip();
});
</script>
@endsection
