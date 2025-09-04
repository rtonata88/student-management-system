@extends('layouts.student-portal')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white;">
                    <h4 class="mb-0"><i class="fas fa-user-graduate"></i> Complete Your Student Information</h4>
                    <small>Step 2 of 5 - Please fill in all required information</small>
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

                    <form action="{{ route('online-application.store-student-info') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Student Information Section -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5><i class="fas fa-user"></i> Student Information</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th style="background-color: rgba(227, 227, 227, 0.5); width: 30%;">Student Photo <span class="text-danger">*</span></th>
                                            <td>
                                                <div class="form-group mb-0">
                                                    <input type="file" name="student_photo" id="student_photo" class="form-control" accept="image/*" onchange="previewImage(this)" required>
                                                    <small class="form-text text-muted">Upload student photo for profile and ID cards (JPG, PNG, GIF - Max 2MB)</small>
                                                    <div id="image-preview" class="mt-2" style="display: none;">
                                                        <img id="preview-img" src="" alt="Student Photo Preview" style="max-width: 150px; max-height: 150px; border: 1px solid #ddd; border-radius: 4px; padding: 5px;">
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="background-color: rgba(227, 227, 227, 0.5); width: 30%;">Student Number</th>
                                            <td>
                                                <input type="text" class="form-control" value="{{ $studentNumber ?? $student->student_number ?? 'Generating...' }}" readonly style="background-color: #f8f9fa; color: #6c757d;">
                                                <input type="hidden" name="student_number" value="{{ $studentNumber ?? $student->student_number ?? '' }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="background-color: rgba(227, 227, 227, 0.5);">Allocated Number <span class="text-danger">*</span></th>
                                            <td>
                                                <input type="text" name="student_number2" class="form-control" value="{{ old('student_number2', $student->student_number2 ?? ($studentNumber ?? $student->student_number ?? '')) }}" readonly style="background-color: #f8f9fa; color: #6c757d;" required>
                                                <small class="form-text text-muted">This number is automatically assigned and matches your Student Number</small>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="background-color: rgba(227, 227, 227, 0.5);">Student Names <span class="text-danger">*</span></th>
                                            <td>
                                                <input type="text" name="student_names" class="form-control" placeholder="Student names" value="{{ old('student_names', $student->student_names ?? '') }}" required>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="background-color: rgba(227, 227, 227, 0.5);">Surname <span class="text-danger">*</span></th>
                                            <td>
                                                <input type="text" name="surname" class="form-control" placeholder="Surname" value="{{ old('surname', $student->surname ?? '') }}" required>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="background-color: rgba(227, 227, 227, 0.5);">Initials <span class="text-danger">*</span></th>
                                            <td>
                                                <input type="text" name="initials" class="form-control" placeholder="Initials" value="{{ old('initials', $student->initials ?? '') }}" required>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="background-color: rgba(227, 227, 227, 0.5);">Center <span class="text-danger">*</span></th>
                                            <td>
                                                <select name="center_id" class="form-control" required>
                                                    <option value="">Choose study centre</option>
                                                    @foreach($centers as $id => $name)
                                                        <option value="{{ $id }}" {{ old('center_id', $student->center_id ?? '') == $id ? 'selected' : '' }}>{{ $name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="background-color: rgba(227, 227, 227, 0.5);">Email</th>
                                            <td>
                                                <input type="email" name="contact_email" class="form-control" placeholder="Email" value="{{ old('contact_email', $student->contact_email ?? '') }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="background-color: rgba(227, 227, 227, 0.5);">Contact Number <span class="text-danger">*</span></th>
                                            <td>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">+264</span>
                                                    </div>
                                                    <input type="text" name="contact_number" class="form-control" placeholder="812345678" value="{{ old('contact_number', $student->contact_number ? str_replace('+264', '', $student->contact_number) : '') }}" pattern="[1-9][0-9]{8}" maxlength="9" required>
                                                </div>
                                                <small class="form-text text-muted">Enter 9 digits starting with 1-9 (no leading 0)</small>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="background-color: rgba(227, 227, 227, 0.5);">Gender <span class="text-danger">*</span></th>
                                            <td>
                                                <select name="gender" class="form-control" required>
                                                    <option value="">Select Gender</option>
                                                    <option value="Male" {{ old('gender', $student->gender ?? '') == 'Male' ? 'selected' : '' }}>Male</option>
                                                    <option value="Female" {{ old('gender', $student->gender ?? '') == 'Female' ? 'selected' : '' }}>Female</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="background-color: rgba(227, 227, 227, 0.5);">Date of Birth <span class="text-danger">*</span></th>
                                            <td>
                                                <div class="input-group">
                                                    <input type="text" name="date_of_birth" id="date_of_birth_display" class="form-control" placeholder="DDMMYYYY" value="{{ old('date_of_birth', $student->date_of_birth ?? '') }}" pattern="[0-9]{8}" maxlength="8" required readonly>
                                                    <input type="date" name="date_of_birth_picker" id="date_of_birth_picker" class="form-control" style="position: absolute; left: 0; opacity: 0; width: 100%; height: 100%; cursor: pointer;" onchange="updateDateDisplay(this.value)">
                                                    <div class="input-group-append">
                                                        <button type="button" class="btn btn-outline-secondary" onclick="document.getElementById('date_of_birth_picker').focus(); document.getElementById('date_of_birth_picker').click();">
                                                            <i class="fas fa-calendar-alt"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <small class="form-text text-muted">Click the calendar icon to select date - will be formatted as DDMMYYYY</small>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="background-color: rgba(227, 227, 227, 0.5);">Birth Certificate</th>
                                            <td>
                                                <input type="text" name="birth_certificate" class="form-control" placeholder="Birth certificate number" value="{{ old('birth_certificate', $student->birth_certificate ?? '') }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="background-color: rgba(227, 227, 227, 0.5);">ID Number</th>
                                            <td>
                                                <input type="number" name="id_number" class="form-control" placeholder="ID number" value="{{ old('id_number', $student->id_number ?? '') }}">
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Subject Selection Section -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <strong><i class="fas fa-book"></i> Subject Selection</strong>
                                <small class="text-muted ml-2">Select subjects for this student</small>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Available Subjects</label>
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                                                <tr>
                                                    <th>Subject</th>
                                                    <th>Code</th>
                                                    <th class="text-right">Monthly Fee</th>
                                                    <th class="text-center">Credits</th>
                                                    <th class="text-center">Select</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(isset($subjects))
                                                    @foreach($subjects as $subject)
                                                        <tr class="subject-row" style="cursor: pointer; transition: all 0.3s ease;">
                                                            <td class="align-middle">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="subject-icon me-3" style="width: 35px; height: 35px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 6px; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; margin-right: 12px; font-size: 0.8rem;">
                                                                        {{ substr($subject->subject_name, 0, 1) }}
                                                                    </div>
                                                                    <div>
                                                                        <h6 class="mb-0">{{ $subject->subject_name }}</h6>
                                                                        <small class="text-muted">{{ $subject->subject_code }}</small>
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
                                                                    3
                                                                </span>
                                                            </td>
                                                            <td class="text-center align-middle">
                                                                <input class="form-check-input subject-checkbox" type="checkbox" 
                                                                       name="subjects[]" value="{{ $subject->id }}" 
                                                                       id="subject_{{ $subject->id }}"
                                                                       style="width: 18px; height: 18px; cursor: pointer;">
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="5" class="text-center text-muted">No subjects available</td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                
                                <div class="mt-3 p-3" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 8px; border-left: 4px solid #667eea;">
                                    <h6><i class="fas fa-calculator"></i> Subject Summary</h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p class="mb-1"><strong>Selected Subjects:</strong> <span id="selected-count">0</span></p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="mb-1"><strong>Total Monthly Fee:</strong> N$<span id="total-fee">0.00</span></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Document Upload Section -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <strong><i class="fas fa-upload"></i> Document Upload</strong>
                                <small class="text-muted ml-2">Upload required documents for this student</small>
                            </div>
                            <div class="card-body">
                                <div id="document-upload-section">
                                    <div class="document-upload-item mb-3 p-3" style="border: 1px solid #dee2e6; border-radius: 8px; background: #f8f9fa;">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group mb-2">
                                                    <label class="form-label">Document Type</label>
                                                    <select name="document_types[]" class="form-control form-control-sm">
                                                        <option value="">Select Document Type</option>
                                                        <option value="id_certificate">ID Certificate</option>
                                                        <option value="birth_certificate">Birth Certificate</option>
                                                        <option value="school_certificate">School Certificate</option>
                                                        <option value="proof_of_payment">Proof of Payment</option>
                                                        <option value="other">Other</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group mb-2">
                                                    <label class="form-label">Document Name</label>
                                                    <input type="text" name="document_names[]" class="form-control form-control-sm" placeholder="Enter document name">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group mb-2">
                                                    <label class="form-label">Choose File</label>
                                                    <input type="file" name="document_files[]" class="form-control-file form-control-sm" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <button type="button" class="btn btn-sm btn-outline-primary" id="add-document-btn">
                                    <i class="fas fa-plus"></i> Add Another Document
                                </button>
                                
                                <div class="mt-3">
                                    <div class="alert alert-info">
                                        <h6><i class="fas fa-info-circle"></i> Document Guidelines:</h6>
                                        <ul class="mb-0 small">
                                            <li>Maximum file size is 10MB per file</li>
                                            <li>Allowed file types: PDF, DOC, DOCX, JPG, JPEG, PNG</li>
                                            <li>Ensure all documents are clear and readable</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Guardian Information Section -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5><i class="fas fa-users"></i> Guardian Information</h5>
                            </div>
                            <div class="card-body">
                                <h6 class="text-primary">Primary Guardian <span class="text-danger">*</span></h6>
                                <div class="table-responsive mb-4">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th style="background-color: rgba(227, 227, 227, 0.5); width: 30%;">Name <span class="text-danger">*</span></th>
                                            <td>
                                                @php
                                                    $guardianNames = $student && $student->guardian_names ? json_decode($student->guardian_names, true) : [];
                                                @endphp
                                                <input type="text" name="guardian_names[]" class="form-control" placeholder="Guardian name" value="{{ old('guardian_names.0', $guardianNames[0] ?? '') }}" required>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="background-color: rgba(227, 227, 227, 0.5);">Surname <span class="text-danger">*</span></th>
                                            <td>
                                                @php
                                                    $guardianSurnames = $student && $student->guardian_surname ? json_decode($student->guardian_surname, true) : [];
                                                @endphp
                                                <input type="text" name="guardian_surname[]" class="form-control" placeholder="Surname" value="{{ old('guardian_surname.0', $guardianSurnames[0] ?? '') }}" required>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="background-color: rgba(227, 227, 227, 0.5);">Relationship <span class="text-danger">*</span></th>
                                            <td>
                                                @php
                                                    $relationships = $student && $student->relationship ? json_decode($student->relationship, true) : [];
                                                    $currentRelationship = old('relationship.0', $relationships[0] ?? '');
                                                @endphp
                                                <select name="relationship[]" class="form-control" required>
                                                    <option value="">Select Relationship</option>
                                                    <option value="Father" {{ $currentRelationship == 'Father' ? 'selected' : '' }}>Father</option>
                                                    <option value="Mother" {{ $currentRelationship == 'Mother' ? 'selected' : '' }}>Mother</option>
                                                    <option value="Cousin" {{ $currentRelationship == 'Cousin' ? 'selected' : '' }}>Cousin</option>
                                                    <option value="Aunt" {{ $currentRelationship == 'Aunt' ? 'selected' : '' }}>Aunt</option>
                                                    <option value="Uncle" {{ $currentRelationship == 'Uncle' ? 'selected' : '' }}>Uncle</option>
                                                    <option value="Sister" {{ $currentRelationship == 'Sister' ? 'selected' : '' }}>Sister</option>
                                                    <option value="Brother" {{ $currentRelationship == 'Brother' ? 'selected' : '' }}>Brother</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="background-color: rgba(227, 227, 227, 0.5);">Contact Number <span class="text-danger">*</span></th>
                                            <td>
                                                @php
                                                    $guardianContacts = $student && $student->guardian_contact_number ? json_decode($student->guardian_contact_number, true) : [];
                                                @endphp
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">+264</span>
                                                    </div>
                                                    <input type="text" name="guardian_contact_number[]" class="form-control" placeholder="812345678" value="{{ old('guardian_contact_number.0', isset($guardianContacts[0]) ? str_replace('+264', '', $guardianContacts[0]) : '') }}" pattern="[1-9][0-9]{8}" maxlength="9" required>
                                                </div>
                                                <small class="form-text text-muted">Enter 9 digits starting with 1-9 (no leading 0)</small>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="background-color: rgba(227, 227, 227, 0.5);">Contact Email</th>
                                            <td>
                                                @php
                                                    $guardianEmails = $student && $student->guardian_contact_email ? json_decode($student->guardian_contact_email, true) : [];
                                                @endphp
                                                <input type="email" name="guardian_contact_email[]" class="form-control" placeholder="Contact email" value="{{ old('guardian_contact_email.0', $guardianEmails[0] ?? '') }}">
                                            </td>
                                        </tr>
                                    </table>
                                </div>

                                <h6 class="text-secondary">Secondary Guardian (Optional)</h6>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th style="background-color: rgba(227, 227, 227, 0.5); width: 30%;">Name</th>
                                            <td>
                                                <input type="text" name="guardian_names[]" class="form-control" placeholder="Guardian name" value="{{ old('guardian_names.1', $guardianNames[1] ?? '') }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="background-color: rgba(227, 227, 227, 0.5);">Surname</th>
                                            <td>
                                                <input type="text" name="guardian_surname[]" class="form-control" placeholder="Surname" value="{{ old('guardian_surname.1', $guardianSurnames[1] ?? '') }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="background-color: rgba(227, 227, 227, 0.5);">Relationship</th>
                                            <td>
                                                @php
                                                    $currentRelationship2 = old('relationship.1', $relationships[1] ?? '');
                                                @endphp
                                                <select name="relationship[]" class="form-control">
                                                    <option value="">Select Relationship</option>
                                                    <option value="Father" {{ $currentRelationship2 == 'Father' ? 'selected' : '' }}>Father</option>
                                                    <option value="Mother" {{ $currentRelationship2 == 'Mother' ? 'selected' : '' }}>Mother</option>
                                                    <option value="Cousin" {{ $currentRelationship2 == 'Cousin' ? 'selected' : '' }}>Cousin</option>
                                                    <option value="Aunt" {{ $currentRelationship2 == 'Aunt' ? 'selected' : '' }}>Aunt</option>
                                                    <option value="Uncle" {{ $currentRelationship2 == 'Uncle' ? 'selected' : '' }}>Uncle</option>
                                                    <option value="Sister" {{ $currentRelationship2 == 'Sister' ? 'selected' : '' }}>Sister</option>
                                                    <option value="Brother" {{ $currentRelationship2 == 'Brother' ? 'selected' : '' }}>Brother</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="background-color: rgba(227, 227, 227, 0.5);">Contact Number</th>
                                            <td>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">+264</span>
                                                    </div>
                                                    <input type="text" name="guardian_contact_number[]" class="form-control" placeholder="812345678" value="{{ old('guardian_contact_number.1', isset($guardianContacts[1]) ? str_replace('+264', '', $guardianContacts[1]) : '') }}" pattern="[1-9][0-9]{8}" maxlength="9">
                                                </div>
                                                <small class="form-text text-muted">Enter 9 digits starting with 1-9 (no leading 0)</small>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="background-color: rgba(227, 227, 227, 0.5);">Contact Email</th>
                                            <td>
                                                <input type="email" name="guardian_contact_email[]" class="form-control" placeholder="Contact email" value="{{ old('guardian_contact_email.1', $guardianEmails[1] ?? '') }}">
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Navigation Buttons -->
                        <div class="card">
                            <div class="card-footer text-center">
                                <button type="submit" class="btn btn-lg mr-3" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.75rem 2rem;">
                                    <i class="fas fa-save"></i> Save & Continue to Review
                                </button>
                                <a href="{{ route('login') }}" class="btn btn-secondary btn-lg" style="padding: 0.75rem 2rem;">
                                    <i class="fas fa-times"></i> Cancel
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function previewImage(input) {
    const preview = document.getElementById('image-preview');
    const previewImg = document.getElementById('preview-img');
    
    if (input.files && input.files[0]) {
        const file = input.files[0];
        
        // Check file size (2MB limit)
        if (file.size > 2 * 1024 * 1024) {
            alert('File size must be less than 2MB');
            input.value = '';
            preview.style.display = 'none';
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(file);
    } else {
        preview.style.display = 'none';
    }
}

// Subject selection functionality
document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('.subject-checkbox');
    const selectedCountSpan = document.getElementById('selected-count');
    const totalFeeSpan = document.getElementById('total-fee');
    
    function updateSummary() {
        let selectedCount = 0;
        let totalFee = 0;
        
        checkboxes.forEach(checkbox => {
            if (checkbox.checked) {
                selectedCount++;
                const row = checkbox.closest('.subject-row');
                const feeText = row.querySelector('td:nth-child(3) span').textContent;
                const fee = parseFloat(feeText.replace('N$', '').replace(',', ''));
                totalFee += fee;
                row.classList.add('selected');
            } else {
                checkbox.closest('.subject-row').classList.remove('selected');
            }
        });
        
        selectedCountSpan.textContent = selectedCount;
        totalFeeSpan.textContent = totalFee.toFixed(2);
    }
    
    // Individual checkbox change
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateSummary);
    });
    
    // Row click to toggle checkbox
    document.querySelectorAll('.subject-row').forEach(row => {
        row.addEventListener('click', function(e) {
            if (e.target.type !== 'checkbox') {
                const checkbox = row.querySelector('.subject-checkbox');
                checkbox.checked = !checkbox.checked;
                updateSummary();
            }
        });
    });
    
    // Document upload functionality
    const addDocumentBtn = document.getElementById('add-document-btn');
    const documentSection = document.getElementById('document-upload-section');
    
    addDocumentBtn.addEventListener('click', function() {
        const newDocumentItem = document.querySelector('.document-upload-item').cloneNode(true);
        
        // Clear the values in the cloned item
        newDocumentItem.querySelectorAll('select, input').forEach(input => {
            input.value = '';
        });
        
        // Add remove button
        const removeBtn = document.createElement('button');
        removeBtn.type = 'button';
        removeBtn.className = 'btn btn-sm btn-outline-danger mt-2';
        removeBtn.innerHTML = '<i class="fas fa-trash"></i> Remove';
        removeBtn.addEventListener('click', function() {
            newDocumentItem.remove();
        });
        
        newDocumentItem.appendChild(removeBtn);
        documentSection.appendChild(newDocumentItem);
    });
    
    // File validation for document uploads
    document.addEventListener('change', function(e) {
        if (e.target.name === 'document_files[]') {
            const file = e.target.files[0];
            if (file) {
                // Check file size (10MB limit)
                if (file.size > 10 * 1024 * 1024) {
                    alert('File size must be less than 10MB');
                    e.target.value = '';
                    return;
                }
                
                // Auto-fill document name if empty
                const documentNameField = e.target.closest('.document-upload-item').querySelector('input[name="document_names[]"]');
                if (!documentNameField.value) {
                    documentNameField.value = file.name.replace(/\.[^/.]+$/, "");
                }
            }
        }
    });
});

// Date picker function
function updateDateDisplay(dateValue) {
    if (dateValue) {
        // Convert YYYY-MM-DD to DDMMYYYY
        const dateParts = dateValue.split('-');
        const year = dateParts[0];
        const month = dateParts[1];
        const day = dateParts[2];
        
        const formattedDate = day + month + year;
        document.getElementById('date_of_birth_display').value = formattedDate;
        
        // Update the hidden field that gets submitted
        const hiddenInput = document.querySelector('input[name="date_of_birth"]');
        if (hiddenInput) {
            hiddenInput.value = formattedDate;
        }
    }
}

// Initialize date picker functionality
document.addEventListener('DOMContentLoaded', function() {
    const dateDisplay = document.getElementById('date_of_birth_display');
    const datePicker = document.getElementById('date_of_birth_picker');
    
    // Make the display field clickable to open date picker
    if (dateDisplay && datePicker) {
        dateDisplay.addEventListener('click', function() {
            datePicker.focus();
            datePicker.click();
        });
        
        // Convert existing DDMMYYYY value to date picker format if present
        if (dateDisplay.value && dateDisplay.value.length === 8) {
            const ddmmyyyy = dateDisplay.value;
            const day = ddmmyyyy.substring(0, 2);
            const month = ddmmyyyy.substring(2, 4);
            const year = ddmmyyyy.substring(4, 8);
            datePicker.value = year + '-' + month + '-' + day;
        }
    }
});
</script>

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

.subject-row.selected h6 {
    color: #667eea;
    font-weight: 600;
}

.form-check-input:checked {
    background-color: #667eea;
    border-color: #667eea;
}
</style>
@endsection
