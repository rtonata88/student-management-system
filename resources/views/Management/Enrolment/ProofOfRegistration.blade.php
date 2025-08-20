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
                        <button onclick="window.print()" class="btn btn-light btn-sm">
                            <i class="fa fa-print"></i> Print
                        </button>
                        <a href="/enrolment" class="btn btn-outline-light btn-sm">
                            <i class="fa fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body p-5" id="printable-content">
                    <!-- Header -->
                    <div class="text-center mb-5">
                        <h2 class="text-primary mb-2">PROOF OF REGISTRATION</h2>
                        <h4 class="text-muted">Academic Year: {{ $academic_year }}</h4>
                        <hr class="w-50 mx-auto">
                    </div>

                    <!-- Student Information -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5 class="text-primary border-bottom pb-2">Student Information</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Student Number:</strong></td>
                                    <td>{{ $student->student_number2 }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Full Name:</strong></td>
                                    <td>{{ $student->surname }}, {{ $student->student_names }}</td>
                                </tr>
                                <tr>
                                    <td><strong>ID Number:</strong></td>
                                    <td>{{ $student->id_number ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Date of Birth:</strong></td>
                                    <td>
                                        @if($student->date_of_birth)
                                            {{ \Carbon\Carbon::parse($student->date_of_birth)->format('d F Y') }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5 class="text-primary border-bottom pb-2">Registration Details</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Registration Date:</strong></td>
                                    <td>{{ \Carbon\Carbon::parse($registration->registration_date)->format('d F Y') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Registration Status:</strong></td>
                                    <td>
                                        <span class="badge bg-success">{{ $registration->registration_status }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Academic Year:</strong></td>
                                    <td>{{ $registration->academic_year }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Center:</strong></td>
                                    <td>{{ $registration->center->center_name ?? 'N/A' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- Registered Modules -->
                    <div class="mb-4">
                        <h5 class="text-primary border-bottom pb-2">Registered Modules</h5>
                        @if($registered_modules->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Module Code</th>
                                            <th>Module Name</th>
                                            <th>Subject Symbol</th>
                                            <th>System</th>
                                            <th class="text-end">Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $totalAmount = 0; @endphp
                                        @foreach($registered_modules as $index => $module_registration)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td><strong>{{ $module_registration->module->subject_code ?? 'N/A' }}</strong></td>
                                                <td>{{ $module_registration->module->subject_name ?? 'N/A' }}</td>
                                                <td>{{ $module_registration->subject_symbol ?? 'N/A' }}</td>
                                                <td>{{ $module_registration->system ?? 'N/A' }}</td>
                                                <td class="text-end">R {{ number_format($module_registration->amount, 2) }}</td>
                                            </tr>
                                            @php $totalAmount += $module_registration->amount; @endphp
                                        @endforeach
                                    </tbody>
                                    <tfoot class="table-light">
                                        <tr>
                                            <th colspan="5" class="text-end">Total Amount:</th>
                                            <th class="text-end">R {{ number_format($totalAmount, 2) }}</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        @else
                            <div class="alert alert-warning">
                                <i class="fa fa-exclamation-triangle"></i>
                                No modules registered for this academic year.
                            </div>
                        @endif
                    </div>

                    <!-- Declaration -->
                    <div class="mt-5 pt-4 border-top">
                        <p class="text-justify">
                            This is to certify that <strong>{{ $student->surname }}, {{ $student->student_names }}</strong> 
                            (Student Number: <strong>{{ $student->student_number2 }}</strong>) is officially registered 
                            for the {{ $academic_year }} academic year with the above-mentioned modules.
                        </p>
                        
                        <div class="row mt-5">
                            <div class="col-md-6">
                                <div class="text-center">
                                    <hr class="w-75">
                                    <p class="mb-0"><strong>Registrar Signature</strong></p>
                                    <small class="text-muted">Date: {{ date('d F Y') }}</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="text-center">
                                    <hr class="w-75">
                                    <p class="mb-0"><strong>Institution Stamp</strong></p>
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
