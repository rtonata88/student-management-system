@extends('layouts.student-portal')

@section('content')
<div class="container-fluid px-4">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box mb-4">
                <h4 class="page-title">Proof of Registration</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('student-portal.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('student-portal.academics') }}">Academics</a></li>
                        <li class="breadcrumb-item active">Proof of Registration</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    @if($registrationsData && count($registrationsData) > 0)
        <div class="row">
            <div class="col-12">
                @foreach($registrationsData as $index => $yearData)
                    <div class="card mb-4" style="background: white; border-radius: 15px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08); border: none; margin-bottom: 3rem !important;">
                        <div class="card-header" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border-radius: 15px; border: none; cursor: pointer;" 
                             onclick="toggleRegistration({{ $index }})">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <strong><i class="fas fa-certificate"></i> Academic Year {{ $yearData['academic_year'] }}</strong>
                                    <small class="ml-2">{{ $yearData['subject_count'] }} subjects registered</small>
                                </div>
                                <div class="d-flex align-items-center">
                                    <span class="badge badge-success mr-2" style="font-size: 0.9rem; padding: 6px 12px;">
                                        N${{ number_format($yearData['total_amount'], 2, '.', ',') }}
                                    </span>
                                    <i class="fas fa-chevron-down" id="arrow-{{ $index }}"></i>
                                </div>
                            </div>
                        </div>
                        <div id="registration-{{ $index }}" style="display: none;">
                            <div class="card-body p-4">

                                <!-- Company Header -->
                                @if($company)
                                    <div class="card-header" style="background: white; border: none; padding: 20px;">
                                        <table style="width: 100%;">
                                            <tr>
                                                <td>
                                                    <h3 style="color: #333; margin-bottom: 10px;">{{ $company->company_name }}</h3>
                                                    <div style="color: #666; line-height: 1.5;">
                                                        {{ $company->address1 }}<br>
                                                        @if($company->address2){{ $company->address2 }}<br>@endif
                                                        @if($company->address3){{ $company->address3 }}<br>@endif
                                                        @if($company->address4){{ $company->address4 }}<br>@endif
                                                        <strong>Tel:</strong> {{ $company->contact_number }}<br>
                                                        @if($company->fax_number)<strong>Fax:</strong> {{ $company->fax_number }}<br>@endif
                                                        <strong>Email:</strong> {{ $company->email }}<br>
                                                    </div>
                                                </td>
                                                <td width="200px" style="text-align: right;">
                                                    @if($company->logo && file_exists(public_path('storage/'.$company->logo)))
                                                        <img src="{{ asset('storage/'.$company->logo) }}" class="img-fluid" alt="Company Logo" style="max-height: 80px;" />
                                                    @else
                                                        <img src="{{ asset('assets/Logo.png') }}" class="img-fluid" alt="Company Logo" style="max-height: 80px;" />
                                                    @endif
                                                </td>
                                            </tr>
                                        </table>
                                        <hr style="border-top: 2px solid #f093fb; margin: 20px 0;">
                                    </div>
                                @endif

                                <!-- Document Title -->
                                <div class="text-center mb-4">
                                    <h2 style="color: #333; font-weight: bold; text-transform: uppercase; letter-spacing: 1px;">
                                        Proof of Registration
                                    </h2>
                                    <p style="color: #666; margin-top: 10px;">Academic Year: {{ $yearData['academic_year'] }}</p>
                                </div>

                                <!-- Student Information -->
                                <div class="row mb-4">
                                    <div class="col-md-8">
                                        <h5 style="color: #333; border-bottom: 2px solid #f093fb; padding-bottom: 10px; margin-bottom: 20px;">
                                            <i class="fa fa-user"></i> Student Information
                                        </h5>
                                        <table class="table table-borderless">
                                            <tr>
                                                <td style="width: 30%; font-weight: bold; color: #555;">Student Number:</td>
                                                <td style="color: #333;">{{ $student->student_number }}</td>
                                            </tr>
                                            <tr>
                                                <td style="font-weight: bold; color: #555;">Full Names:</td>
                                                <td style="color: #333;">{{ $student->student_names }} {{ $student->surname }}</td>
                                            </tr>
                                            <tr>
                                                <td style="font-weight: bold; color: #555;">Date of Birth:</td>
                                                <td style="color: #333;">{{ $student->date_of_birth ? \Carbon\Carbon::parse($student->date_of_birth)->format('d M Y') : 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td style="font-weight: bold; color: #555;">Gender:</td>
                                                <td style="color: #333;">{{ $student->gender->gender ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td style="font-weight: bold; color: #555;">Center:</td>
                                                <td style="color: #333;">{{ $student->center->center_name ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td style="font-weight: bold; color: #555;">Registration Date:</td>
                                                <td style="color: #333;">{{ \Carbon\Carbon::parse($yearData['registration']->registration_date)->format('d M Y') }}</td>
                                            </tr>
                                            <tr>
                                                <td style="font-weight: bold; color: #555;">Registration Status:</td>
                                                <td>
                                                    <span class="badge badge-success" style="font-size: 12px;">
                                                        <i class="fa fa-check-circle"></i> {{ $yearData['registration']->registration_status }}
                                                    </span>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        @if($student->photo)
                                            <img src="{{ asset('storage/' . $student->photo) }}" 
                                                 alt="Student Photo" 
                                                 class="img-fluid rounded" 
                                                 style="max-width: 150px; max-height: 180px; border: 3px solid #f093fb;">
                                        @else
                                            <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                                 style="width: 150px; height: 180px; border: 3px solid #f093fb; margin: 0 auto;">
                                                <i class="fa fa-user fa-3x text-muted"></i>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Registered Modules -->
                                <div class="card mt-3" style="border: 1px solid #e9ecef; border-radius: 10px;">
                                    <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 10px 10px 0 0;">
                                        <strong><i class="fas fa-book"></i> Registered Subjects</strong>
                                        <small class="ml-2">{{ $yearData['subject_count'] }} subjects registered</small>
                                    </div>
                                    <div class="card-body">
                                        @if($yearData['modules']->count() > 0)
                                            <div class="table-responsive">
                                                <table class="table table-hover">
                                                    <thead style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                                                        <tr>
                                                            <th>Subject Code</th>
                                                            <th>Subject Name</th>
                                                            <th class="text-center">Symbol</th>
                                                            <th class="text-center">System</th>
                                                            <th class="text-right">Amount</th>
                                                            <th class="text-center">Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($yearData['modules'] as $module)
                                                        <tr style="transition: all 0.3s ease;">
                                                            <td class="align-middle">
                                                                <span class="badge badge-light" style="background: #f8f9fa; color: #495057; padding: 4px 8px; border-radius: 4px;">
                                                                    {{ $module->module->subject_code ?? 'N/A' }}
                                                                </span>
                                                            </td>
                                                            <td class="align-middle">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="subject-icon me-3" style="width: 35px; height: 35px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 6px; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; margin-right: 12px; font-size: 0.8rem;">
                                                                        {{ substr($module->module->subject_name ?? 'N', 0, 1) }}
                                                                    </div>
                                                                    <div>
                                                                        <h6 class="mb-0">{{ $module->module->subject_name ?? 'N/A' }}</h6>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="align-middle text-center">
                                                                <span class="badge badge-info">{{ $module->subject_symbol ?? 'N/A' }}</span>
                                                            </td>
                                                            <td class="align-middle text-center">
                                                                <span class="badge badge-secondary">{{ $module->system ?? 'N/A' }}</span>
                                                            </td>
                                                            <td class="align-middle text-right">
                                                                <span style="font-weight: 600; color: #28a745;">
                                                                    N${{ number_format($module->amount ?? 0, 2) }}
                                                                </span>
                                                            </td>
                                                            <td class="align-middle text-center">
                                                                <span class="badge badge-success">
                                                                    <i class="fa fa-check"></i> {{ $module->registration_status ?? 'Active' }}
                                                                </span>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            
                                            <div class="mt-3 p-3" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 8px; border-left: 4px solid #667eea;">
                                                <h6><i class="fas fa-calculator"></i> Registration Summary</h6>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <p class="mb-1"><strong>Total Subjects:</strong> {{ $yearData['subject_count'] }}</p>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <p class="mb-1"><strong>Academic Year:</strong> {{ $yearData['academic_year'] }}</p>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <p class="mb-1"><strong>Total Fees:</strong> N${{ number_format($yearData['total_amount'], 2) }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="text-center py-4">
                                                <i class="fas fa-book-open fa-3x text-muted mb-3"></i>
                                                <h5 class="text-muted">No Subjects Registered</h5>
                                                <p class="text-muted">No subjects were registered for this academic year.</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Declaration -->
                                <div class="mt-4 p-4" style="background-color: #f8f9fa; border-left: 4px solid #f093fb; border-radius: 5px;">
                                    <h6 style="color: #333; font-weight: bold; margin-bottom: 15px;">
                                        <i class="fa fa-certificate"></i> Declaration
                                    </h6>
                                    <p style="color: #555; line-height: 1.6; margin-bottom: 10px;">
                                        This is to certify that <strong>{{ $student->student_names }} {{ $student->surname }}</strong> 
                                        (Student Number: <strong>{{ $student->student_number }}</strong>) is officially registered 
                                        at {{ $company->company_name ?? 'this institution' }} for the academic year 
                                        <strong>{{ $yearData['academic_year'] }}</strong>.
                                    </p>
                                    <p style="color: #555; line-height: 1.6; margin-bottom: 0;">
                                        The student is enrolled for {{ $yearData['subject_count'] }} subject(s) with a total 
                                        registration fee of <strong>N${{ number_format($yearData['total_amount'], 2) }}</strong>.
                                    </p>
                                </div>

                                <!-- Footer -->
                                <div class="mt-4 text-center" style="border-top: 1px solid #dee2e6; padding-top: 20px;">
                                    <p style="color: #666; font-size: 12px; margin-bottom: 5px;">
                                        This document was generated on {{ \Carbon\Carbon::now()->format('d M Y \a\t H:i') }}
                                    </p>
                                    <p style="color: #666; font-size: 12px; margin-bottom: 0;">
                                        {{ $company->company_name ?? 'Institution Name' }} - Student Registration System
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-12">
                <div class="card" style="background: white; border-radius: 15px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08); border: none;">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-certificate fa-4x text-muted mb-4"></i>
                        <h5 class="text-muted mb-3">No Registration Records Found</h5>
                        <p class="text-muted mb-4">You don't have any registration records yet.</p>
                        <div class="alert alert-info" role="alert">
                            <i class="fas fa-info-circle"></i>
                            <strong>Note:</strong> Registration records will appear here once you complete your subject registration.
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
function toggleRegistration(index) {
    const content = document.getElementById('registration-' + index);
    const arrow = document.getElementById('arrow-' + index);
    
    // Toggle current registration
    if (content.style.display === 'none' || content.style.display === '') {
        content.style.display = 'block';
        arrow.classList.add('rotated');
    } else {
        content.style.display = 'none';
        arrow.classList.remove('rotated');
    }
}
</script>
