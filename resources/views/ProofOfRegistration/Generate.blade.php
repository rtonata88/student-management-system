@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white;">
                    <div class="row">
                        <div class="col-md-8">
                            <h4 class="card-title mb-0">
                                <i class="fa fa-certificate"></i> Proof of Registration
                            </h4>
                        </div>
                        <div class="col-md-4 text-right">
                            @can('download-proof-of-registration')
                                <a href="{{ route('proof-of-registration.download', $student->id) }}" class="btn btn-light btn-sm">
                                    <i class="fa fa-download"></i> Download PDF
                                </a>
                            @endcan
                            @can('print-proof-of-registration')
                                <a href="{{ route('proof-of-registration.print', $student->id) }}" target="_blank" class="btn btn-light btn-sm ml-2">
                                    <i class="fa fa-print"></i> Print
                                </a>
                            @endcan
                        </div>
                    </div>
                </div>
                <div class="card-body" id="printable-content">
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
                        <p style="color: #666; margin-top: 10px;">Academic Year: {{ $currentYear->academic_year }}</p>
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
                                    <td style="color: #333;">{{ \Carbon\Carbon::parse($registration->registration_date)->format('d M Y') }}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold; color: #555;">Registration Status:</td>
                                    <td>
                                        <span class="badge badge-success" style="font-size: 12px;">
                                            <i class="fa fa-check-circle"></i> {{ $registration->registration_status }}
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
                    <div class="mb-4">
                        <h5 style="color: #333; border-bottom: 2px solid #f093fb; padding-bottom: 10px; margin-bottom: 20px;">
                            <i class="fa fa-book"></i> Registered Modules ({{ $registered_modules->count() }} modules)
                        </h5>
                        
                        @if($registered_modules->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white;">
                                        <tr>
                                            <th style="text-align: center;">#</th>
                                            <th>Module Code</th>
                                            <th>Module Name</th>
                                            <th style="text-align: center;">Symbol</th>
                                            <th style="text-align: center;">System</th>
                                            <th style="text-align: center;">Amount</th>
                                            <th style="text-align: center;">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($registered_modules as $index => $module)
                                        <tr>
                                            <td style="text-align: center; font-weight: bold;">{{ $index + 1 }}</td>
                                            <td style="font-weight: bold; color: #333;">{{ $module->module->module_code ?? 'N/A' }}</td>
                                            <td style="color: #333;">{{ $module->module->module_name ?? 'N/A' }}</td>
                                            <td style="text-align: center;">
                                                <span class="badge badge-info">{{ $module->subject_symbol ?? 'N/A' }}</span>
                                            </td>
                                            <td style="text-align: center;">
                                                <span class="badge badge-secondary">{{ $module->system ?? 'N/A' }}</span>
                                            </td>
                                            <td style="text-align: center; font-weight: bold; color: #28a745;">
                                                ${{ number_format($module->amount ?? 0, 2) }}
                                            </td>
                                            <td style="text-align: center;">
                                                <span class="badge badge-success">
                                                    <i class="fa fa-check"></i> {{ $module->registration_status }}
                                                </span>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot style="background-color: #f8f9fa;">
                                        <tr>
                                            <td colspan="5" style="text-align: right; font-weight: bold; color: #333;">
                                                <strong>Total Amount:</strong>
                                            </td>
                                            <td style="text-align: center; font-weight: bold; color: #28a745; font-size: 16px;">
                                                <strong>${{ number_format($registered_modules->sum('amount'), 2) }}</strong>
                                            </td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        @else
                            <div class="alert alert-warning">
                                <i class="fa fa-exclamation-triangle"></i> No modules registered for this student.
                            </div>
                        @endif
                    </div>

                    <!-- Registration Summary -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card text-center" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white;">
                                <div class="card-body">
                                    <h4>{{ $registered_modules->count() }}</h4>
                                    <p class="mb-0">Modules Registered</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-center" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                                <div class="card-body">
                                    <h4>{{ $currentYear->academic_year }}</h4>
                                    <p class="mb-0">Academic Year</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-center" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); color: white;">
                                <div class="card-body">
                                    <h4>${{ number_format($registered_modules->sum('amount'), 2) }}</h4>
                                    <p class="mb-0">Total Fees</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-center" style="background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%); color: #333;">
                                <div class="card-body">
                                    <h4>{{ \Carbon\Carbon::parse($registration->registration_date)->format('d M Y') }}</h4>
                                    <p class="mb-0">Registration Date</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Declaration -->
                    <div class="mt-5 p-4" style="background-color: #f8f9fa; border-left: 4px solid #f093fb; border-radius: 5px;">
                        <h6 style="color: #333; font-weight: bold; margin-bottom: 15px;">
                            <i class="fa fa-certificate"></i> Declaration
                        </h6>
                        <p style="color: #555; line-height: 1.6; margin-bottom: 10px;">
                            This is to certify that <strong>{{ $student->student_names }} {{ $student->surname }}</strong> 
                            (Student Number: <strong>{{ $student->student_number }}</strong>) is officially registered 
                            at {{ $company->company_name ?? 'this institution' }} for the academic year 
                            <strong>{{ $currentYear->academic_year }}</strong>.
                        </p>
                        <p style="color: #555; line-height: 1.6; margin-bottom: 0;">
                            The student is enrolled for {{ $registered_modules->count() }} module(s) with a total 
                            registration fee of <strong>${{ number_format($registered_modules->sum('amount'), 2) }}</strong>.
                        </p>
                    </div>

                    <!-- Footer -->
                    <div class="mt-5 text-center" style="border-top: 1px solid #dee2e6; padding-top: 20px;">
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
    </div>
</div>
@endsection
