@extends('layouts.app')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Applications</li>
        <li class="breadcrumb-item"><a href="/student-cards">Student Cards</a></li>
        <li class="breadcrumb-item active">Generate Card</li>
        <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <strong>Student Identification Card</strong>
                    <div>
                        <a href="{{ route('student-cards.print', $student->id) }}" class="btn btn-success btn-sm" target="_blank">
                            <i class="fas fa-print me-1"></i>Print Card
                        </a>
                        <a href="{{ route('student-cards.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left me-1"></i>Back to Search
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Student Card Preview -->
                    <div class="student-card-container">
                        <div class="student-card">
                            <!-- Card Header -->
                            <div class="card-header-section">
                                <div class="header-content">
                                    <div class="school-info">
                                        @if($company && $company->logo)
                                            <img src="{{ asset('storage/' . $company->logo) }}" alt="School Logo" class="school-logo" style="display: block;">
                                        @else
                                            <div class="logo-placeholder">
                                                <i class="fas fa-graduation-cap"></i>
                                            </div>
                                        @endif
                                        <div class="school-details">
                                            <h3 class="school-name">{{ $company->company_name ?? 'EDUCATIONAL INSTITUTION' }}</h3>
                                            <p class="card-type">STUDENT IDENTIFICATION CARD</p>
                                            <p class="academic-year">{{ date('Y') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Card Body -->
                            <div class="card-body-section">
                                <div class="student-info-row">
                                    <!-- Student Photo -->
                                    <div class="student-photo">
                                        @if($student->photo)
                                            <img src="{{ asset('storage/' . $student->photo) }}" alt="Student Photo" class="photo-img" onclick="openPhotoUpload({{ $student->id }}, '{{ addslashes($student->student_names) }} {{ addslashes($student->surname) }}')" style="cursor: pointer;" title="Click to change photo">
                                        @else
                                            <div class="photo-placeholder" onclick="openPhotoUpload({{ $student->id }}, '{{ addslashes($student->student_names) }} {{ addslashes($student->surname) }}')" style="cursor: pointer;" title="Click to upload photo">
                                                <i class="fas fa-user"></i>
                                                <span>No Photo</span>
                                                <small class="upload-hint">Click to Upload</small>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Student Details -->
                                    <div class="student-details">
                                        <div class="detail-row">
                                            <span class="label">Name:</span>
                                            <span class="value">{{ $student->student_names }} {{ $student->surname }}</span>
                                        </div>
                                        <div class="detail-row">
                                            <span class="label">Student #:</span>
                                            <span class="value">{{ $student->student_number }}</span>
                                        </div>
                                        <div class="detail-row">
                                            <span class="label">Allocated #:</span>
                                            <span class="value">{{ $student->student_number2 ?? 'N/A' }}</span>
                                        </div>
                                        <div class="detail-row">
                                            <span class="label">Centre:</span>
                                            <span class="value">
                                                @if($student->center)
                                                    {{ $student->center->center_name }}
                                                @else
                                                    Not Available
                                                @endif
                                            </span>
                                        </div>
                                        <div class="detail-row">
                                            <span class="label">Intake:</span>
                                            <span class="value">
                                                @if($student->currentRegistration)
                                                    {{ $student->currentRegistration->intake ?? 'Current Intake' }}
                                                @else
                                                    Current Intake
                                                @endif
                                            </span>
                                        </div>
                                        <div class="detail-row">
                                            <span class="label">Study Mode:</span>
                                            <span class="value">
                                                @if($student->currentRegistration)
                                                    {{ $student->currentRegistration->study_mode ?? 'Full Time' }}
                                                @else
                                                    Full Time
                                                @endif
                                            </span>
                                        </div>
                                    </div>

                                    <!-- QR Code -->
                                    <div class="qr-code-section">
                                        <div class="qr-code">
                                            <div id="qrcode"></div>
                                        </div>
                                        <p class="qr-label">Scan for Verification</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Card Footer -->
                            <div class="card-footer-section">
                                <p class="footer-text">This card remains the property of the institution. If found, kindly return it to the nearest campus.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Photo Upload Modal -->
<div class="modal fade" id="photoUploadModal" tabindex="-1" aria-labelledby="photoUploadModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="photoUploadModalLabel">
                    <i class="fas fa-camera me-2"></i>Upload Student Photo
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="photoUploadForm" enctype="multipart/form-data" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label"><strong>Student:</strong> <span id="studentName"></span></label>
                    </div>
                    <div class="mb-3">
                        <label for="photoInput" class="form-label">Select Photo</label>
                        <input type="file" class="form-control" id="photoInput" name="photo" accept="image/*" required>
                        <div class="form-text">Accepted formats: JPG, PNG, GIF. Max size: 2MB</div>
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="retainPhoto" checked>
                            <label class="form-check-label" for="retainPhoto">
                                Retain photo for future card generations
                            </label>
                            <div class="form-text">Photo will be saved and automatically used for future student cards</div>
                        </div>
                    </div>
                    <div id="photoPreview" class="text-center" style="display: none;">
                        <img id="previewImage" src="" alt="Photo Preview" style="max-width: 200px; max-height: 200px; border-radius: 8px;">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-upload me-1"></i>Upload Photo
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.student-card-container {
    display: flex;
    justify-content: center;
    padding: 2rem 0;
}

.student-card {
    width: 600px;
    height: 380px;
    background: linear-gradient(135deg, #1e88e5 0%, #1976d2 100%);
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.3);
    overflow: hidden;
    position: relative;
    font-family: 'Arial', sans-serif;
}

.card-header-section {
    background: rgba(255,255,255,0.95);
    padding: 15px 20px;
    border-bottom: 2px solid #1976d2;
}

.header-content {
    display: flex;
    align-items: center;
}

.school-info {
    display: flex;
    align-items: center;
    width: 100%;
}

.school-logo {
    width: 60px;
    height: 60px;
    object-fit: contain;
    margin-right: 15px;
}

.logo-placeholder {
    width: 60px;
    height: 60px;
    background: #1976d2;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 24px;
    margin-right: 15px;
}

.school-details {
    flex: 1;
}

.school-name {
    font-size: 18px;
    font-weight: bold;
    color: #1976d2;
    margin: 0;
    text-transform: uppercase;
}

.card-type {
    font-size: 14px;
    font-weight: 600;
    color: #333;
    margin: 2px 0;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.academic-year {
    font-size: 12px;
    color: #666;
    margin: 0;
}

.card-body-section {
    padding: 20px;
    background: white;
    height: calc(100% - 140px);
}

.student-info-row {
    display: flex;
    gap: 20px;
    height: 100%;
}

.student-photo {
    width: 120px;
    flex-shrink: 0;
}

.photo-img {
    width: 120px;
    height: 150px;
    object-fit: cover;
    border-radius: 8px;
    border: 2px solid #e0e0e0;
}

.photo-placeholder {
    width: 120px;
    height: 150px;
    background: #f5f5f5;
    border: 2px solid #e0e0e0;
    border-radius: 8px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    color: #999;
    font-size: 12px;
}

.photo-placeholder i {
    font-size: 40px;
    margin-bottom: 10px;
}

.photo-placeholder .upload-hint {
    display: block;
    font-size: 10px;
    color: #666;
    margin-top: 5px;
    font-weight: 500;
}

.photo-placeholder:hover, .photo-img:hover {
    opacity: 0.8;
    transition: opacity 0.3s ease;
}

.student-details {
    flex: 1;
    padding-left: 10px;
}

.detail-row {
    margin-bottom: 12px;
    display: flex;
    align-items: flex-start;
}

.label {
    font-weight: 600;
    color: #555;
    min-width: 100px;
    font-size: 14px;
}

.value {
    color: #333;
    font-size: 14px;
    font-weight: 500;
    flex: 1;
}

.qr-code-section {
    width: 100px;
    flex-shrink: 0;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding-top: 10px;
}

.card-footer-section {
    background: rgba(255,255,255,0.9);
    padding: 8px 20px;
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
}

.footer-text {
    font-size: 10px;
    color: #666;
    text-align: center;
    margin: 0;
    line-height: 1.3;
}

@media print {
    .student-card {
        width: 85.6mm;
        height: 54mm;
        transform: scale(0.8);
        margin: 0;
    }
    
    .card-header-section {
        padding: 8px 12px;
    }
    
    .school-name {
        font-size: 12px;
    }
    
    .card-type {
        font-size: 9px;
    }
    
    .academic-year {
        font-size: 8px;
    }
    
    .card-body-section {
        padding: 12px;
    }
    
    .photo-img, .photo-placeholder {
        width: 80px;
        height: 100px;
    }
    
    .label, .value {
        font-size: 9px;
    }
    
    .detail-row {
        margin-bottom: 6px;
    }
    
    .qr-code {
        width: 50px;
        height: 50px;
    }
    
    .footer-text {
        font-size: 7px;
    }
}

/* QR Code Styles */
.qr-code {
    width: 80px;
    height: 80px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 2px solid #1976d2;
    border-radius: 8px;
    background: white;
    padding: 4px;
}

.qr-code canvas {
    border-radius: 4px;
}

.qr-label {
    font-size: 10px;
    color: #666;
    text-align: center;
    margin: 5px 0 0 0;
    font-weight: 500;
}

.qr-fallback {
    font-size: 10px;
    font-weight: bold;
    color: #1976d2;
    text-align: center;
    line-height: 1.2;
}

@media print {
    .qr-code {
        width: 50px;
        height: 50px;
        padding: 2px;
    }
    
    .qr-label {
        font-size: 7px;
    }
}
</style>

<!-- QR Code Library -->
<script src="https://cdn.jsdelivr.net/npm/qrcode@1.5.3/build/qrcode.min.js"></script>
<script>
function generateQRCode() {
    console.log('Attempting to generate QR code...');
    
    // Check if QRCode library is available
    if (typeof QRCode === 'undefined') {
        console.error('QRCode library not loaded');
        handleQRError();
        return;
    }
    
    // Check if target element exists
    const qrElement = document.getElementById('qrcode');
    if (!qrElement) {
        console.error('QR code element not found');
        return;
    }
    
    // Generate QR code with student verification data
    const studentData = {
        name: "{{ $student->student_names }} {{ $student->surname }}",
        studentNumber: "{{ $student->student_number }}",
        allocatedNumber: "{{ $student->student_number2 ?? 'N/A' }}",
        centre: "{{ $student->center ? $student->center->center_name : 'Not Available' }}",
        institution: "{{ $company->company_name ?? 'EDUCATIONAL INSTITUTION' }}",
        year: "{{ date('Y') }}",
        verificationUrl: "{{ url('/verify-student/' . $student->id) }}"
    };
    
    // Use simpler data for QR code to avoid size issues
    const qrData = `Student: {{ $student->student_names }} {{ $student->surname }}
ID: {{ $student->student_number }}
Institution: {{ $company->company_name ?? 'EDUCATIONAL INSTITUTION' }}
Verify: {{ url('/verify-student/' . $student->id) }}`;
    
    // Clear any existing content
    qrElement.innerHTML = '';
    
    QRCode.toCanvas(qrElement, qrData, {
        width: 80,
        height: 80,
        margin: 1,
        color: {
            dark: '#1976d2',
            light: '#ffffff'
        },
        errorCorrectionLevel: 'M'
    }, function (error) {
        if (error) {
            console.error('QR Code generation failed:', error);
            handleQRError();
        } else {
            console.log('QR Code generated successfully');
        }
    });
}

function handleQRError() {
    console.log('Showing QR fallback');
    const qrElement = document.getElementById('qrcode');
    if (qrElement) {
        qrElement.innerHTML = '<div class="qr-fallback">QR<br>CODE</div>';
    }
}

// Initialize QR code generation
$(document).ready(function() {
    console.log('Document ready, initializing QR code...');
    
    // Wait a bit for the QR library to load
    setTimeout(function() {
        generateQRCode();
    }, 500);
    
    // Also try again after a longer delay as fallback
    setTimeout(function() {
        const qrElement = document.getElementById('qrcode');
        if (qrElement && qrElement.innerHTML.trim() === '') {
            console.log('QR code still empty, trying again...');
            generateQRCode();
        }
    }, 2000);
});

function openPhotoUpload(studentId, studentName) {
    console.log('Opening photo upload for student:', studentId, studentName);
    
    // Wait for DOM to be ready
    $(document).ready(function() {
        // Check if elements exist
        const studentNameEl = document.getElementById('studentName');
        const photoFormEl = document.getElementById('photoUploadForm');
        const photoInputEl = document.getElementById('photoInput');
        const photoPreviewEl = document.getElementById('photoPreview');
        
        if (!studentNameEl || !photoFormEl || !photoInputEl || !photoPreviewEl) {
            console.error('Modal elements not found');
            return;
        }
        
        studentNameEl.textContent = studentName;
        photoFormEl.action = `/student-cards/${studentId}/upload-photo`;
        
        // Reset form
        photoInputEl.value = '';
        photoPreviewEl.style.display = 'none';
        
        // Show modal using jQuery
        $('#photoUploadModal').modal('show');
    });
}

// Initialize event listeners when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded, initializing event listeners');
    
    // Photo preview functionality
    const photoInput = document.getElementById('photoInput');
    if (photoInput) {
        photoInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const previewImage = document.getElementById('previewImage');
                    const photoPreview = document.getElementById('photoPreview');
                    if (previewImage && photoPreview) {
                        previewImage.src = e.target.result;
                        photoPreview.style.display = 'block';
                    }
                };
                reader.readAsDataURL(file);
            } else {
                const photoPreview = document.getElementById('photoPreview');
                if (photoPreview) {
                    photoPreview.style.display = 'none';
                }
            }
        });
    }

    // Handle form submission
    const photoForm = document.getElementById('photoUploadForm');
    if (photoForm) {
        photoForm.addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Uploading...';
                submitBtn.disabled = true;
            }
        });
    }
    
    // Add modal close functionality using jQuery
    $('#photoUploadModal .close, #photoUploadModal [data-dismiss="modal"]').on('click', function() {
        $('#photoUploadModal').modal('hide');
    });
});
</script>
@endsection
