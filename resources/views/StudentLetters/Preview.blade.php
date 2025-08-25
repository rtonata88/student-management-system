@extends('layouts.app')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Applications</li>
        <li class="breadcrumb-item"><a href="/student-letters">Student Letters</a></li>
        <li class="breadcrumb-item active">Preview Letter</li>
        <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Action Buttons -->
            <div class="action-bar mb-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="fas fa-eye me-2"></i>Letter Preview
                    </h4>
                    <div class="action-buttons">
                        <a href="{{ route('student-letters.generate', $student->id) }}" class="btn btn-outline-secondary">
                            <i class="fas fa-edit me-2"></i>Edit Letter
                        </a>
                        <form method="POST" action="{{ route('student-letters.download', $student->id) }}" class="d-inline">
                            @csrf
                            <input type="hidden" name="letter_type" value="{{ $letterType }}">
                            <input type="hidden" name="custom_content" value="{{ $letterContent }}">
                            <button type="submit" class="btn btn-gradient-success">
                                <i class="fas fa-download me-2"></i>Download PDF
                            </button>
                        </form>
                        <button onclick="window.print()" class="btn btn-gradient-primary">
                            <i class="fas fa-print me-2"></i>Print
                        </button>
                    </div>
                </div>
            </div>

            <!-- Letter Preview -->
            <div class="letter-preview" id="letterPreview">
                <div class="letterhead">
                    <table style="width: 100%;">
                        <tr>
                            <td style="vertical-align: top;">
                                <h2 class="company-name">{{ $company->company_name }}</h2>
                                <div class="company-address">
                                    {{ $company->address1 }}<br>
                                    {{ $company->address2 }}<br>
                                    @if($company->address3)
                                        {{ $company->address3 }}<br>
                                    @endif
                                    @if($company->address4)
                                        {{ $company->address4 }}<br>
                                    @endif
                                </div>
                                <div class="company-contact">
                                    <strong>Tel:</strong> {{ $company->contact_number }}<br>
                                    @if($company->fax_number)
                                        <strong>Fax:</strong> {{ $company->fax_number }}<br>
                                    @endif
                                    <strong>Email:</strong> {{ $company->email }}
                                </div>
                            </td>
                            <td style="width: 200px; text-align: right; vertical-align: top;">
                                @if($company->logo)
                                    <img src="{{ asset('storage/' . $company->logo) }}" alt="Company Logo" class="company-logo">
                                @else
                                    <img src="{{ asset('assets/Logo.png') }}" alt="Company Logo" class="company-logo">
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>

                <div class="letter-body">
                    <div class="letter-date">
                        {{ date('F j, Y') }}
                    </div>

                    <div class="letter-title">
                        @php
                            $letterTitles = [
                                'testimonial' => 'Testimonial Letter',
                                'completion' => 'Letter of Completion',
                                'achievement' => 'Letter of Achievement',
                                'enrollment' => 'Letter of Enrollment',
                                'conduct' => 'Letter of Good Conduct',
                                'recommendation' => 'Letter of Recommendation',
                                'attendance' => 'Letter of Attendance',
                                'verification' => 'Student Verification Letter'
                            ];
                        @endphp
                        {{ $letterTitles[$letterType] ?? ucwords(str_replace('_', ' ', $letterType)) }}
                    </div>

                    <div class="letter-salutation">
                        To Whom It May Concern:
                    </div>

                    <div class="letter-content">
                        {{ $letterContent }}
                    </div>

                    <div class="letter-student-details">
                        <strong>Student Details:</strong><br>
                        <strong>Name:</strong> {{ $student->student_names }} {{ $student->surname }}<br>
                        <strong>Student Number:</strong> {{ $student->student_number }}<br>
                        @if($student->student_number2)
                            <strong>Allocated Number:</strong> {{ $student->student_number2 }}<br>
                        @endif
                        @if($student->center)
                            <strong>Centre:</strong> {{ $student->center->center_name }}<br>
                        @endif
                        @if($student->date_of_birth)
                            <strong>Date of Birth:</strong> {{ $student->date_of_birth }}<br>
                        @endif
                    </div>

                    <div class="letter-closing">
                        <p>Should you require any further information, please do not hesitate to contact our office.</p>
                        
                        <p>Yours sincerely,</p>
                        
                        <div class="signature-section">
                            <div class="signature-line"></div>
                            <div class="signature-title">Registrar</div>
                            <div class="signature-company">{{ $company->company_name }}</div>
                        </div>

                        <div class="stamp-section">
                            <div class="stamp-placeholder">
                                <div class="stamp-text">
                                    <span>OFFICIAL</span><br>
                                    <span>STAMP</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.action-bar {
    background: white;
    padding: 1rem;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.action-buttons {
    display: flex;
    gap: 0.5rem;
}

.letter-preview {
    background: white;
    padding: 3rem;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    border-radius: 10px;
    min-height: 800px;
    font-family: 'Times New Roman', serif;
    line-height: 1.6;
}

.letterhead {
    border-bottom: 2px solid #333;
    padding-bottom: 1rem;
    margin-bottom: 2rem;
}

.company-name {
    font-size: 1.8rem;
    font-weight: bold;
    color: #333;
    margin-bottom: 0.5rem;
}

.company-address {
    font-size: 0.95rem;
    color: #666;
    margin-bottom: 0.5rem;
}

.company-contact {
    font-size: 0.9rem;
    color: #666;
}

.company-logo {
    max-width: 200px;
    max-height: 150px;
    object-fit: contain;
}

.letter-body {
    font-size: 1rem;
    color: #333;
}

.letter-date {
    text-align: right;
    margin-bottom: 2rem;
    font-weight: 500;
}

.letter-title {
    text-align: center;
    font-size: 1.3rem;
    font-weight: bold;
    text-transform: uppercase;
    margin-bottom: 2rem;
    text-decoration: underline;
}

.letter-salutation {
    margin-bottom: 1.5rem;
    font-weight: 500;
}

.letter-content {
    margin-bottom: 2rem;
    text-align: justify;
    text-indent: 2rem;
}

.letter-student-details {
    background: #f8f9fa;
    padding: 1rem;
    border-left: 4px solid #667eea;
    margin-bottom: 2rem;
    font-size: 0.95rem;
}

.letter-closing {
    margin-top: 2rem;
}

.signature-section {
    margin-top: 3rem;
    margin-bottom: 2rem;
}

.signature-line {
    width: 250px;
    border-bottom: 1px solid #333;
    margin-bottom: 0.5rem;
}

.signature-title {
    font-weight: bold;
    margin-bottom: 0.25rem;
}

.signature-company {
    font-size: 0.9rem;
    color: #666;
}

.stamp-section {
    position: relative;
    float: right;
    margin-top: -6rem;
    margin-right: 2rem;
}

.stamp-placeholder {
    width: 120px;
    height: 120px;
    border: 2px dashed #ccc;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f8f9fa;
    position: relative;
}

.stamp-text {
    font-size: 0.7rem;
    font-weight: bold;
    color: #999;
    text-align: center;
    line-height: 1.2;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 100%;
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

@media print {
    /* Hide all non-letter elements */
    .action-bar,
    .sidebar,
    .c-sidebar,
    .c-header,
    .c-subheader,
    .breadcrumb,
    nav,
    .navbar,
    .btn,
    button {
        display: none !important;
    }
    
    /* Reset all containers and body for full width printing */
    * {
        box-sizing: border-box !important;
    }
    
    html, body {
        width: 100% !important;
        height: auto !important;
        margin: 0 !important;
        padding: 0 !important;
        background: white !important;
        font-size: 12pt !important;
    }
    
    .container-fluid,
    .row,
    .col-lg-10 {
        width: 100% !important;
        max-width: none !important;
        padding: 0 !important;
        margin: 0 !important;
    }
    
    .letter-preview {
        width: 100% !important;
        max-width: none !important;
        box-shadow: none !important;
        padding: 15mm !important;
        margin: 0 !important;
        background: white !important;
        position: static !important;
        transform: none !important;
        page-break-inside: avoid;
    }
    
    /* Ensure letter content uses full width */
    .letterhead table,
    .letter-body {
        width: 100% !important;
    }
}
</style>
@endsection
