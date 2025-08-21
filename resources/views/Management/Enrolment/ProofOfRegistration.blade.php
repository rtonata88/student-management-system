@extends('layouts.app')

@section('breadcrumb')
<div class="c-subheader px-3">
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Management</li>
        <li class="breadcrumb-item"><a href="/enrolment">Enrolment</a></li>
        <li class="breadcrumb-item active">Proof of Registration</li>
    </ol>
</div>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Proof of Registration</h4>
                    <div>
                        <a href="{{ route('enrolment.proof.download', $student->id) }}" class="btn btn-light btn-sm">
                            <i class="fa fa-download"></i> Download
                        </a>
                        <a href="/enrolment" class="btn btn-outline-light btn-sm">
                            <i class="fa fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body" id="printable-content">
                    <!-- Company Header - Following Finance.Invoice.Print format -->
                    <div class="card-header" style="background: white; border: none; padding: 20px;">
                        <table style="width: 100%;">
                            <tr>
                                <td>
                                    <h3>{{ $company->company_name }}</h3><br>
                                    {{ $company->address1 }}<br>
                                    @if($company->address2){{ $company->address2 }}<br>@endif
                                    @if($company->address3){{ $company->address3 }}<br>@endif
                                    @if($company->address4){{ $company->address4 }}<br>@endif
                                    <strong>C:</strong> {{ $company->contact_number }}<br>
                                    <strong>F:</strong> {{ $company->fax ?? 'N/A' }}<br>
                                    <strong>E:</strong> {{ $company->email }}<br>
                                </td>
                                <td width="200px; margin-right:20px;">
                                    @if($company->logo && file_exists(public_path('storage/'.$company->logo)))
                                        <img src="{{ asset('storage/'.$company->logo) }}" class="img-fluid" alt="Company Logo" />
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>

                    <hr style="margin: 20px 0;">

                    <!-- Date and Document Title -->
                    <div style="text-align: right; margin-bottom: 30px;">
                        <strong>Date:</strong> {{ date('F d, Y') }}
                    </div>

                    <div style="text-align: center; margin-bottom: 30px;">
                        <h2><strong>PROOF OF REGISTRATION</strong></h2>
                        <p>Academic Year: {{ $academic_year }}</p>
                    </div>

                    <!-- Student Details - Following Finance.Invoice.Print format -->
                    <div style="margin-bottom: 30px;">
                        <p><strong>{{ $student->student_names }} {{ $student->surname }}</strong></p>
                        @if($student->email)
                            <p>{{ $student->email }}</p>
                        @endif
                        @if($student->contact_number)
                            <p>{{ $student->contact_number }}</p>
                        @endif
                        <p><strong>Ref #:</strong> {{ $student->student_number }} | {{ $student->student_number2 }}</p>
                    </div>

                    <!-- Registration Details and Modules -->
                    <p><strong>Registration Details:</strong></p>
                    <p>Registration Date: {{ \Carbon\Carbon::parse($registration->registration_date)->format('F d, Y') }}</p>
                    <p>Registration Status: {{ $registration->registration_status }}</p>
                    <p>Academic Year: {{ $registration->academic_year }}</p>
                    <p>Center: {{ $registration->center->center_name ?? 'N/A' }}</p>

                    @if($registered_modules->count() > 0)
                        <br>
                        <p><strong>Registered Modules:</strong></p>
                        <table class="table table-bordered table-sm" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Module Code</th>
                                    <th>Module Name</th>
                                    <th>Subject Symbol</th>
                                    <th>System</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $totalAmount = 0; @endphp
                                @foreach($registered_modules as $module_registration)
                                    <tr>
                                        <td>{{ $module_registration->module->subject_code ?? 'N/A' }}</td>
                                        <td>{{ $module_registration->module->subject_name ?? 'N/A' }}</td>
                                        <td>{{ $module_registration->subject_symbol ?? 'N/A' }}</td>
                                        <td>{{ $module_registration->system ?? 'N/A' }}</td>
                                        <td>N${{ number_format($module_registration->amount, 2) }}</td>
                                    </tr>
                                    @php $totalAmount += $module_registration->amount; @endphp
                                @endforeach
                                <tr>
                                    <th colspan="4">Total Amount:</th>
                                    <th>N${{ number_format($totalAmount, 2) }}</th>
                                </tr>
                            </tbody>
                        </table>
                    @else
                        <p>No modules registered for this academic year.</p>
                    @endif

                    <!-- Declaration -->
                    <br><br>
                    <p>This is to certify that <strong>{{ $student->student_names }} {{ $student->surname }}</strong> 
                    (Student Number: <strong>{{ $student->student_number }}</strong>) is officially registered 
                    for the {{ $academic_year }} academic year with the above-mentioned modules.</p>
                    
                    <br><br><br>
                    <p>_________________________</p>
                    <p><strong>Registrar</strong></p>
                    <p>{{ $company->company_name }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    .card-header,
    .btn,
    .breadcrumb,
    .c-subheader {
        display: none !important;
    }
    
    .card {
        border: none !important;
        box-shadow: none !important;
    }
    
    .card-body {
        padding: 0 !important;
    }
    
    body {
        background: white !important;
    }
    
    .table {
        font-size: 12px;
    }
}

.text-primary {
    color: #667eea !important;
}

.bg-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
}

.badge.bg-success {
    background: linear-gradient(135deg, #66bb6a 0%, #4caf50 100%) !important;
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
    border: none;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%) !important;
}
</style>
@endsection
