@extends('layouts.app')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Management</li>
        <li class="breadcrumb-item"><a href="/students">Students </a></li>
        <li class="breadcrumb-item active">Add New</li>
        <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection

@section('content')
{!! Form::open(array('route' => array('students.store'), 'method' => 'post', 'class'=> 'form-vertical form-material', 'enctype="multipart/form-data"')) !!}
<div class="row">
    <div class="col-md-2 col-xs-12"></div>
    <div class="col-md-8 col-xs-12">
        <div class="card">
            <div class="card-header">
                <strong>Student information</strong>
            </div>
            <div class="card-body">
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <table class="table table-responsive-sm table-bordered table-sm" style="width:100%">
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">Student Photo</th>
                        <td>
                            <div class="form-group mb-0">
                                <input type="file" name="student_photo" id="student_photo" class="form-control input-no-border" accept="image/*" onchange="previewImage(this)">
                                <small class="form-text text-muted">Upload student photo for profile and ID cards (JPG, PNG, GIF - Max 2MB)</small>
                                <div id="image-preview" class="mt-2" style="display: none;">
                                    <img id="preview-img" src="" alt="Student Photo Preview" style="max-width: 150px; max-height: 150px; border: 1px solid #ddd; border-radius: 4px; padding: 5px;">
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">Student Number</th>
                        <td>
                            <input type="text" class="form-control input-no-border" value="{{$preGeneratedStudentNumber}}" readonly style="background-color: #f8f9fa; color: #6c757d;">
                        </td>
                    </tr>
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">Allocated Number <span class="text-danger">*</span></th>
                        <td>{{Form::text('student_number2',null, ['class' => 'form-control input-no-border', 'required', 'placeholder' => 'Allocated Number'])}}</td>
                    </tr>
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">Student names <span class="text-danger">*</span></th>
                        <td>{{Form::text('student_names',null, ['class' => 'form-control input-no-border', 'required', 'placeholder' => 'Student names'])}}</td>
                    </tr>
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">Surname <span class="text-danger">*</span></th>
                        <td>{{Form::text('surname',null, ['class' => 'form-control input-no-border', 'required', 'placeholder' => 'Surname'])}}</td>
                    </tr>
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">Initials <span class="text-danger">*</span></th>
                        <td>{{Form::text('initials',null, ['class' => 'form-control input-no-border', 'required', 'placeholder' => 'Inititals'])}}</td>
                    </tr>
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">Center <span class="text-danger">*</span></th>
                        <td>{{Form::select('center_id', $centers, null, ['class' => 'form-control select input-no-border', 'required', 'placeholder' => 'Select Center'])}}</td>
                    </tr>
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">Email </th>
                        <td>{{Form::email('contact_email',null, ['class' => 'form-control input-no-border', 'placeholder' => 'Email'])}}</td>
                    </tr>
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">Contact number <span class="text-danger">*</span></th>
                        <td>{{Form::text('contact_number',null, ['class' => 'form-control input-no-border', 'required', 'placeholder' => 'Contact number'])}}</td>
                    </tr>
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">Gender <span class="text-danger">*</span></th>
                        <td>{{Form::select('gender', ['Male' => 'Male', 'Female' => 'Female'], null, ['class' => 'form-control select input-no-border', 'required'])}}</td>
                    </tr>
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">Date of Birth</th>
                        <td>
                            <div class="input-group">
                                <input type="text" name="date_of_birth" id="date_of_birth_admin" class="form-control input-no-border" placeholder="DDMMYYYY" pattern="[0-9]{8}" maxlength="8">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-outline-secondary" onclick="openDatePickerAdmin()">
                                        <i class="fas fa-calendar-alt"></i>
                                    </button>
                                </div>
                                <input type="date" id="date_picker_helper_admin" style="position: absolute; left: -9999px; opacity: 0; pointer-events: none;" onchange="formatDateToDDMMYYYYAdmin(this.value)">
                            </div>
                            <small class="form-text text-muted">Enter date in DDMMYYYY format (e.g., 04092025) or use calendar picker</small>
                        </td>
                    </tr>
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">Birth Certificate</th>
                        <td>
                            {{Form::text('birth_certificate', null, ['class' => 'form-control input-no-border', 'placeholder'=>'Birth certificate number'])}}
                        </td>
                    </tr>
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">ID Number </th>
                        <td>
                            {{Form::number('id_number',null, ['class' => 'form-control input-no-border', 'placeholder'=>'ID number'])}}
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Subject Selection Section -->
        <div class="card">
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
        <div class="card">
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

        <div class="card">
            <div class="card-header">
                <strong>Guardian information</strong>
            </div>
            <div class="card-body qualifications-table">
                <table class="table table-responsive-sm table-bordered table-sm" style="width:100%">
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">Name <span class="text-danger">*</span></th>
                        <td>
                            {{Form::text('guardian_names[]',null, ['class' => 'form-control input-no-border', 'placeholder'=>'Guardian name', 'required'])}}
                        </td>
                    </tr>
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">Surname <span class="text-danger">*</span></th>
                        <td>
                            {{Form::text('guardian_surname[]',null, ['class' => 'form-control input-no-border', 'placeholder'=>'Surname', 'required'])}}
                        </td>
                    </tr>
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">Relationship <span class="text-danger">*</span></th>
                        <td>{{Form::select('relationship[]', ['Father' => 'Father', 'Mother' => 'Mother', 'Cousin' => 'Cousin', 'Aunt' => 'Aunt', 'Uncle' => 'Uncle', 'Sister' => 'Sister', 'Brother' => 'Brother'], null, ['class' => 'form-control select input-no-border', 'required'])}}</td>
                    </tr>
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">Contact number <span class="text-danger">*</span></th>
                        <td>
                            {{Form::text('guardian_contact_number[]',null, ['class' => 'form-control input-no-border', 'placeholder'=>'Contact number', 'required'])}}
                        </td>

                    </tr>
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">Contact email </th>
                        <td>
                            {{Form::text('guardian_contact_email[]',null, ['class' => 'form-control input-no-border', 'placeholder'=>'Contact email'])}}
                        </td>
                    </tr>
                </table>

                <table class="table table-responsive-sm table-bordered table-sm" style="width:100%">
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">Name</th>
                        <td>
                            {{Form::text('guardian_names[]',null, ['class' => 'form-control input-no-border', 'placeholder'=>'Guardian name'])}}
                        </td>
                    </tr>
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">Surname</th>
                        <td>
                            {{Form::text('guardian_surname[]',null, ['class' => 'form-control input-no-border', 'placeholder'=>'Surname'])}}
                        </td>
                    </tr>
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">Relationship</th>
                        <td>{{Form::select('relationship[]', ['Father' => 'Father', 'Mother' => 'Mother', 'Cousin' => 'Cousin', 'Aunt' => 'Aunt', 'Uncle' => 'Uncle', 'Sister' => 'Sister', 'Brother' => 'Brother'], null, ['class' => 'form-control select input-no-border'])}}</td>
                    </tr>
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">Contact number</th>
                        <td>
                            {{Form::text('guardian_contact_number[]',null, ['class' => 'form-control input-no-border', 'placeholder'=>'Contact number'])}}
                        </td>

                    </tr>
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">Contact email </th>
                        <td>
                            {{Form::text('guardian_contact_email[]',null, ['class' => 'form-control input-no-border', 'placeholder'=>'Contact email'])}}
                        </td>
                    </tr>
                </table>
            </div>
            <!--
                UNCOMMENT this line if you wish to add more than one guardian 
                <div class="card-body" id="guardian-section">
            </div> 
            <div class="card-footer">
                <button typ="button" class="btn btn-sm btn-primary" id="add-qualification-btn">Add qualification</button>
            </div>-->
            <div class="card-footer">
                @permission('add-student')
                <button type="submit" class="btn btn-sm" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">Save</button>
                @endpermission
                <a href="/students">Cancel</a>
            </div>
        </div>

    </div>
</div>
</div>
{!! Form::close() !!}

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

// Date picker functions for admin
function openDatePickerAdmin() {
    const datePicker = document.getElementById('date_picker_helper_admin');
    datePicker.focus();
    datePicker.click();
    
    // For mobile devices and some browsers
    if (datePicker.showPicker) {
        datePicker.showPicker();
    }
}

function formatDateToDDMMYYYYAdmin(dateValue) {
    if (dateValue) {
        // Convert YYYY-MM-DD to DDMMYYYY
        const dateParts = dateValue.split('-');
        const year = dateParts[0];
        const month = dateParts[1];
        const day = dateParts[2];
        
        document.getElementById('date_of_birth_admin').value = day + month + year;
    }
}

// Handle direct typing in the date field to ensure proper format
document.addEventListener('DOMContentLoaded', function() {
    const dateInput = document.getElementById('date_of_birth_admin');
    if (dateInput) {
        dateInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, ''); // Remove non-digits
            if (value.length > 8) {
                value = value.substring(0, 8);
            }
            e.target.value = value;
        });
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