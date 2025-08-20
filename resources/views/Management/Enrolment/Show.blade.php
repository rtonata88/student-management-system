@extends('layouts.app')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Management</li>
        <li class="breadcrumb-item"><a href="/enrolment">Enrolment</a></li>
        <li class="breadcrumb-item active">{{$student->student_names}} {{$student->surname}}</li>
        <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Registration Details</h4>
                    <div>
                        <button onclick="window.print()" class="btn btn-light btn-sm">
                            <i class="fa fa-print"></i> Print
                        </button>
                        <a href="/enrolment" class="btn btn-outline-light btn-sm">
                            <i class="fa fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Student Information -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5 class="text-primary border-bottom pb-2">Student Information</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Student Number:</strong></td>
                                    <td>{{$student->student_number2}}</td>
                                </tr>
                                <tr>
                                    <td><strong>Full Name:</strong></td>
                                    <td>{{$student->student_names}} {{$student->surname}}</td>
                                </tr>
                                <tr>
                                    <td><strong>Date of Birth:</strong></td>
                                    <td>
                                        @if($student->date_of_birth)
                                            {{\Carbon\Carbon::parse($student->date_of_birth)->format('d F Y')}}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>ID Number:</strong></td>
                                    <td>{{$student->id_number ?? 'N/A'}}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5 class="text-primary border-bottom pb-2">Registration Status</h5>
                            @if($registration)
                                <table class="table table-borderless">
                                    <tr>
                                        <td><strong>Registration Date:</strong></td>
                                        <td>{{\Carbon\Carbon::parse($registration->registration_date)->format('d F Y')}}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Status:</strong></td>
                                        <td><span class="badge bg-success">{{$registration->registration_status}}</span></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Academic Year:</strong></td>
                                        <td>{{$academic_year}}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Center:</strong></td>
                                        <td>{{$registration->center->center_name ?? 'N/A'}}</td>
                                    </tr>
                                </table>
                            @else
                                <div class="alert alert-warning">
                                    <i class="fa fa-exclamation-triangle"></i>
                                    No registration found for the current academic year.
                                </div>
                            @endif
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
                                            <th>Registration Date</th>
                                            <th class="text-end">Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($registered_modules as $index => $module)
                                            <tr>
                                                <td>{{$index + 1}}</td>
                                                <td><strong>{{$module->module->subject_code ?? 'N/A'}}</strong></td>
                                                <td>{{$module->module->subject_name ?? 'N/A'}}</td>
                                                <td>{{\Carbon\Carbon::parse($module->registration_date)->format('d F Y')}}</td>
                                                <td class="text-end">R {{number_format($module->amount, 2)}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="alert alert-warning">
                                <i class="fa fa-exclamation-triangle"></i>
                                No modules registered for this academic year.
                            </div>
                        @endif
                    </div>

                    <!-- Financial Summary -->
                    @if($invoices->count() > 0)
                        <div class="mb-4">
                            <h5 class="text-primary border-bottom pb-2">Financial Summary</h5>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Date</th>
                                            <th>Description</th>
                                            <th class="text-end">Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($invoices as $invoice)
                                            <tr>
                                                <td>{{\Carbon\Carbon::parse($invoice->transaction_date)->format('d F Y')}}</td>
                                                <td>{{$invoice->line_description}}</td>
                                                <td class="text-end">R {{number_format($invoice->debit_amount, 2)}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="table-light">
                                        <tr>
                                            <th colspan="2" class="text-end">Total Amount:</th>
                                            <th class="text-end">R {{number_format($total, 2)}}</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.text-primary {
    color: #667eea !important;
}

.bg-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
}

.badge.bg-success {
    background: linear-gradient(135deg, #66bb6a 0%, #4caf50 100%) !important;
}

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
}
</style>
@endsection