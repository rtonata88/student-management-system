@extends('layouts.app')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Applications</li>
        <li class="breadcrumb-item"><a href="/student-letters">Student Letters</a></li>
        <li class="breadcrumb-item active">Generate Letter</li>
        <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-lg">
                <div class="card-header bg-gradient-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-file-alt me-2"></i>
                        Generate Student Letter
                    </h4>
                </div>
                <div class="card-body">
                    <!-- Student Information -->
                    <div class="student-info-section mb-4">
                        <h5 class="section-title">
                            <i class="fas fa-user me-2"></i>Student Information
                        </h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-item">
                                    <label>Student Name:</label>
                                    <span>{{ $student->student_names }} {{ $student->surname }}</span>
                                </div>
                                <div class="info-item">
                                    <label>Student Number:</label>
                                    <span>{{ $student->student_number }}</span>
                                </div>
                                <div class="info-item">
                                    <label>Allocated Number:</label>
                                    <span>{{ $student->student_number2 ?? 'N/A' }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-item">
                                    <label>Centre:</label>
                                    <span>{{ $student->center ? $student->center->center_name : 'Not Available' }}</span>
                                </div>
                                <div class="info-item">
                                    <label>Date of Birth:</label>
                                    <span>{{ $student->date_of_birth }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Letter Generation Form -->
                    <div class="letter-form-section">
                        <h5 class="section-title">
                            <i class="fas fa-edit me-2"></i>Letter Details
                        </h5>
                        
                        {!! Form::open(['route' => ['student-letters.preview', $student->id], 'method' => 'post', 'id' => 'letterForm']) !!}
                        
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="letter_type" class="form-label d-block">
                                        <i class="fas fa-list me-1"></i>Letter Type <span class="text-danger">*</span>
                                    </label>
                                    {{ Form::select('letter_type', $letterTypes, null, [
                                        'class' => 'form-select',
                                        'id' => 'letter_type',
                                        'required' => true,
                                        'placeholder' => 'Select letter type...'
                                    ]) }}
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="letter_date" class="form-label d-block">
                                        <i class="fas fa-calendar me-1"></i>Letter Date
                                    </label>
                                    <input type="text" id="letter_date" class="form-control" value="{{ date('F j, Y') }}" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <label for="custom_content" class="form-label">
                                <i class="fas fa-pen me-1"></i>Custom Content (Optional)
                            </label>
                            {{ Form::textarea('custom_content', null, [
                                'class' => 'form-control',
                                'id' => 'custom_content',
                                'rows' => 6,
                                'placeholder' => 'Enter custom letter content or leave blank to use default template...'
                            ]) }}
                            <div class="form-text">
                                If left blank, a standard letter template will be used based on the selected letter type.
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="submit" name="action" value="preview" class="btn btn-gradient-primary btn-lg me-3">
                                <i class="fas fa-eye me-2"></i>Preview Letter
                            </button>
                            <button type="submit" name="action" value="download" class="btn btn-gradient-success btn-lg">
                                <i class="fas fa-download me-2"></i>Download PDF
                            </button>
                            <a href="{{ route('student-letters.index') }}" class="btn btn-outline-secondary btn-lg ms-3">
                                <i class="fas fa-arrow-left me-2"></i>Back to Search
                            </a>
                        </div>
                        
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('letterForm').addEventListener('submit', function(e) {
    const action = e.submitter.value;
    
    if (action === 'download') {
        this.action = '{{ route("student-letters.download", $student->id) }}';
    } else {
        this.action = '{{ route("student-letters.preview", $student->id) }}';
    }
    
    // Show loading state
    const submitBtn = e.submitter;
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Processing...';
    submitBtn.disabled = true;
    
    // Re-enable after a delay (in case of errors)
    setTimeout(() => {
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    }, 5000);
});

// Letter type change handler to show description
document.getElementById('letter_type').addEventListener('change', function() {
    const selectedType = this.value;
    const descriptions = {
        'testimonial': 'A formal letter providing character reference and academic standing.',
        'completion': 'Confirms successful completion of studies and program requirements.',
        'achievement': 'Acknowledges outstanding academic performance and achievements.',
        'enrollment': 'Verifies current enrollment status and academic standing.',
        'conduct': 'Certifies exemplary behavior and adherence to institutional policies.',
        'recommendation': 'Provides professional recommendation for future opportunities.',
        'attendance': 'Confirms regular attendance and commitment to studies.',
        'verification': 'Official verification of student status for external purposes.'
    };
    
    // You could add a description area if needed
    console.log('Selected:', selectedType, descriptions[selectedType]);
});
</script>

<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.student-info-section {
    background: #f8f9fa;
    border-radius: 10px;
    padding: 1.5rem;
    border-left: 4px solid #667eea;
}

.letter-form-section {
    background: white;
    border-radius: 10px;
    padding: 1.5rem;
    border: 1px solid #e9ecef;
}

.section-title {
    color: #495057;
    font-weight: 600;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
}

.info-item {
    margin-bottom: 0.75rem;
}

.info-item label {
    font-weight: 600;
    color: #6c757d;
    margin-right: 0.5rem;
    min-width: 120px;
    display: inline-block;
}

.info-item span {
    color: #495057;
}

.form-actions {
    text-align: center;
    padding-top: 1rem;
    border-top: 1px solid #e9ecef;
}

.btn-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    color: white;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
}

.btn-gradient-primary:hover {
    background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
    color: white;
}

.btn-gradient-success {
    background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
    border: none;
    color: white;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(17, 153, 142, 0.3);
}

.btn-gradient-success:hover {
    background: linear-gradient(135deg, #0e8078 0%, #32d96a 100%);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(17, 153, 142, 0.4);
    color: white;
}

.form-select:focus,
.form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

.card {
    border: none;
    border-radius: 15px;
}

.card-header {
    border-radius: 15px 15px 0 0 !important;
    border: none;
}

/* Ensure form controls have consistent height */
.form-select,
.form-control {
    height: 38px;
    padding: 0.375rem 0.75rem;
    line-height: 1.5;
}
</style>
@endsection
