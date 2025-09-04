@extends('layouts.student-portal')

@section('content')
<div class="container-fluid px-4">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box mb-4">
                <h4 class="page-title">Financial Statement</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('student-portal.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('student-portal.finance') }}">Finance</a></li>
                        <li class="breadcrumb-item active">Financial Statement</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    @if($financialData && $financialData->count() > 0)
        <div class="row">
            <div class="col-12">
                @foreach($financialData as $index => $yearData)
                    <div class="card mb-5" style="background: white; border-radius: 15px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08); border: none; margin-bottom: 2rem !important;">
                        <div class="card-header" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border-radius: 15px; border: none; cursor: pointer;" 
                             onclick="toggleStatement({{ $index }})">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <strong><i class="fas fa-file-invoice-dollar"></i> Academic Year {{ $yearData['academic_year'] }}</strong>
                                    <small class="ml-2">Financial Statement</small>
                                </div>
                                <div class="d-flex align-items-center">
                                    <span class="badge mr-2" style="background: {{ $yearData['course_balance'] > 0 ? 'linear-gradient(135deg, #dc3545 0%, #c82333 100%)' : 'linear-gradient(135deg, #28a745 0%, #20c997 100%)' }}; color: white; font-size: 0.9rem; padding: 6px 12px;">
                                        {{ $yearData['course_balance'] > 0 ? 'Outstanding: N$' . number_format($yearData['course_balance'], 2) : 'Paid Up' }}
                                    </span>
                                    <i class="fas fa-chevron-down" id="arrow-{{ $index }}"></i>
                                </div>
                            </div>
                        </div>
                        <div id="statement-{{ $index }}" style="display: none;">
                            <div class="card-body p-4">
                                <!-- Student Information -->
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <table class="table-sm" style="width:100%">
                                            <tr>
                                                <th style="width: 150px">Student Number</th>
                                                <td>{{ $student->student_number }}</td>
                                            </tr>
                                            <tr>
                                                <th style="width: 150px">Student Names</th>
                                                <td>{{ $student->student_names }}</td>
                                            </tr>
                                            <tr>
                                                <th style="width: 150px">Surname</th>
                                                <td>{{ $student->surname }}</td>
                                            </tr>
                                            <tr>
                                                <th style="width: 100px">Date of Birth</th>
                                                <td>{{ $student->date_of_birth }}</td>
                                            </tr>
                                            <tr>
                                                <th style="width: 100px">Center</th>
                                                <td>{{ $student->center->center_name ?? 'N/A' }}</td>
                                            </tr>
                                        </table>
                                    </div>

                                    <div class="col-md-6">
                                        <table class="table table-responsive-sm table-bordered table-striped table-sm" style="width:100%">
                                            <tbody>
                                                <tr>
                                                    <th>Total Payable</th>
                                                    <td>N${{ number_format($yearData['total_payable'], 2, '.', ',') }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Tuition Fees</th>
                                                    <td>N${{ number_format($yearData['tuition_fees'], 2, '.', ',') }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Other Fees</th>
                                                    <td>N${{ number_format($yearData['other_fees'], 2, '.', ',') }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Total Paid</th>
                                                    <td>N${{ number_format($yearData['total_paid'], 2, '.', ',') }}</td>
                                                </tr>
                                                <tr class="{{ $yearData['course_balance'] > 0 ? 'table-danger' : 'table-success' }}">
                                                    <th>Course Balance</th>
                                                    <td>N${{ number_format($yearData['course_balance'], 2, '.', ',') }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Transaction History -->
                                <div class="card mt-3" style="border: 1px solid #e9ecef; border-radius: 10px;">
                                    <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 10px 10px 0 0;">
                                        <strong><i class="fas fa-history"></i> Transaction History</strong>
                                        <small class="ml-2">Detailed account activity for {{ $yearData['academic_year'] }}</small>
                                    </div>
                                    <div class="card-body p-0">
                                        @if($yearData['transactions']->count() > 0)
                                            <div class="table-responsive">
                                                <table class="table table-hover table-bordered table-sm mb-0" style="width:100%">
                                                    <thead style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                                                        <tr>
                                                            <th>Date</th>
                                                            <th>Description</th>
                                                            <th>Debit</th>
                                                            <th>Credit</th>
                                                            <th>Balance</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php $balance = 0; @endphp
                                                        @foreach($yearData['transactions'] as $transaction)
                                                            @php
                                                                $balance = ($transaction->debit_amount > 0) ? $balance + $transaction->debit_amount : $balance - $transaction->credit_amount;
                                                            @endphp
                                                            <tr class="{{ str_contains($transaction->line_description, 'Balance B/F') ? 'table-warning' : '' }}">
                                                                <td>{{ \Carbon\Carbon::parse($transaction->transaction_date)->format('d/m/Y') }}</td>
                                                                <td>
                                                                    @if(str_contains($transaction->line_description, 'Balance B/F'))
                                                                        <strong><i class="fas fa-arrow-right text-warning"></i> {{ $transaction->line_description }}</strong>
                                                                        <br><small class="text-muted">Balance carried forward from previous year</small>
                                                                    @else
                                                                        {{ $transaction->line_description }}
                                                                    @endif
                                                                    @if($transaction->reference_number)
                                                                        <br><small class="text-muted">Ref: {{ $transaction->reference_number }}</small>
                                                                    @endif
                                                                </td>
                                                                <td class="text-right">
                                                                    @if($transaction->debit_amount > 0)
                                                                        <span class="{{ str_contains($transaction->line_description, 'Balance B/F') ? 'text-warning font-weight-bold' : 'text-danger' }}">
                                                                            {{ number_format($transaction->debit_amount, 2, '.', ',') }}
                                                                        </span>
                                                                    @else
                                                                        -
                                                                    @endif
                                                                </td>
                                                                <td class="text-right">
                                                                    @if($transaction->credit_amount > 0)
                                                                        <span class="{{ str_contains($transaction->line_description, 'Balance B/F') ? 'text-warning font-weight-bold' : 'text-success' }}">
                                                                            {{ number_format($transaction->credit_amount, 2, '.', ',') }}
                                                                        </span>
                                                                    @else
                                                                        -
                                                                    @endif
                                                                </td>
                                                                <td class="text-right">
                                                                    <strong class="{{ $balance > 0 ? 'text-danger' : ($balance < 0 ? 'text-success' : 'text-muted') }}">
                                                                        {{ number_format($balance, 2, '.', ',') }}
                                                                    </strong>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        <tr class="table-info">
                                                            <th colspan="4" class="text-right">
                                                                @if($balance > 0)
                                                                    You are owing
                                                                @elseif($balance < 0)
                                                                    We owe you
                                                                @else
                                                                    Account balanced
                                                                @endif
                                                            </th>
                                                            <th class="text-right">
                                                                <strong>{{ number_format($balance, 2, '.', ',') }}</strong>
                                                            </th>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        @else
                                            <div class="text-center py-4">
                                                <i class="fas fa-receipt fa-3x text-muted mb-3"></i>
                                                <h5 class="text-muted">No Transactions</h5>
                                                <p class="text-muted">No financial transactions found for this academic year.</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Registered Subjects -->
                                @if($yearData['registrations']->count() > 0)
                                <div class="card mt-3" style="border: 1px solid #e9ecef; border-radius: 10px;">
                                    <div class="card-header" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white; border-radius: 10px 10px 0 0;">
                                        <strong><i class="fas fa-book"></i> Registered Subjects</strong>
                                        <small class="ml-2">Subjects enrolled for {{ $yearData['academic_year'] }}</small>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white;">
                                                    <tr>
                                                        <th>Subject</th>
                                                        <th>Code</th>
                                                        <th class="text-right">Fee</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($yearData['registrations'] as $registration)
                                                        @if($registration->subjectAllocation && $registration->subjectAllocation->module)
                                                            @php $module = $registration->subjectAllocation->module; @endphp
                                                            <tr>
                                                                <td>
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="subject-icon me-3" style="width: 35px; height: 35px; background: linear-gradient(135deg, #28a745 0%, #20c997 100%); border-radius: 6px; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; margin-right: 12px; font-size: 0.8rem;">
                                                                            {{ substr($module->subject_name, 0, 1) }}
                                                                        </div>
                                                                        <div>
                                                                            <h6 class="mb-0">{{ $module->subject_name }}</h6>
                                                                            <small class="text-muted">{{ $module->description ?? 'No description available' }}</small>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <span class="badge badge-light" style="background: #f8f9fa; color: #495057; padding: 4px 8px; border-radius: 4px;">
                                                                        {{ $module->subject_code }}
                                                                    </span>
                                                                </td>
                                                                <td class="text-right">
                                                                    <span style="font-weight: 600; color: #28a745;">
                                                                        N${{ number_format($module->subject_fees ?? 0, 2) }}
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                @endif
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
                        <i class="fas fa-file-invoice-dollar fa-4x text-muted mb-4"></i>
                        <h5 class="text-muted mb-3">No Financial Records Found</h5>
                        <p class="text-muted mb-4">No financial data is available for your account yet.</p>
                        <div class="alert alert-info" role="alert">
                            <i class="fas fa-info-circle"></i>
                            <strong>Note:</strong> Financial records will appear here once you have registered for subjects and made payments.
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

#arrow-0, #arrow-1, #arrow-2, #arrow-3, #arrow-4 {
    transition: transform 0.3s ease;
}

.rotated {
    transform: rotate(180deg);
}

.table th {
    border-top: none;
    font-weight: 600;
    color: #495057;
}

.table td {
    vertical-align: middle;
}
</style>

<script>
function toggleStatement(index) {
    const content = document.getElementById('statement-' + index);
    const arrow = document.getElementById('arrow-' + index);
    
    // Toggle current statement
    if (content.style.display === 'none' || content.style.display === '') {
        content.style.display = 'block';
        arrow.classList.add('rotated');
    } else {
        content.style.display = 'none';
        arrow.classList.remove('rotated');
    }
}
</script>
