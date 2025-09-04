@extends('layouts.student-portal')

@section('content')
<div class="container-fluid px-4">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box mb-4">
                <h4 class="page-title">My Payments</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('student-portal.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('student-portal.finance') }}">Finance</a></li>
                        <li class="breadcrumb-item active">My Payments</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    @if($paymentsByYear && count($paymentsByYear) > 0)
        <div class="row">
            <div class="col-12">
                @foreach($paymentsByYear as $index => $yearData)
                    <div class="card mb-4" style="background: white; border-radius: 15px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08); border: none; margin-bottom: 3rem !important;">
                        <div class="card-header" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border-radius: 15px; border: none; cursor: pointer;" 
                             onclick="togglePayments({{ $loop->index }})">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <strong><i class="fas fa-credit-card"></i> Year {{ $yearData['year'] }}</strong>
                                    <small class="ml-2">{{ $yearData['payment_count'] }} payment(s)</small>
                                </div>
                                <div class="d-flex align-items-center">
                                    <span class="badge badge-success mr-2" style="font-size: 0.9rem; padding: 6px 12px;">
                                        N${{ number_format($yearData['total_amount'], 2) }}
                                    </span>
                                    <i class="fas fa-chevron-down" id="arrow-{{ $loop->index }}"></i>
                                </div>
                            </div>
                        </div>
                        <div id="payments-{{ $loop->index }}" style="display: none;">
                            <div class="card-body p-4">
                                
                                <!-- Payments Table -->
                                <div class="card mt-3" style="border: 1px solid #e9ecef; border-radius: 10px;">
                                    <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 10px 10px 0 0;">
                                        <strong><i class="fas fa-list"></i> Payment History</strong>
                                        <small class="ml-2">{{ $yearData['payment_count'] }} transactions in {{ $yearData['year'] }}</small>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                            <table class="table table-hover mb-0">
                                                <thead style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                                                    <tr>
                                                        <th>Receipt #</th>
                                                        <th>Amount</th>
                                                        <th>Method</th>
                                                        <th>Reference</th>
                                                        <th>Date</th>
                                                        <th>Source</th>
                                                        <th>Processed By</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($yearData['payments'] as $payment)
                                                        <tr style="transition: all 0.3s ease;">
                                                            <td class="align-middle">
                                                                <strong>{{ $payment->receipt_number }}</strong>
                                                            </td>
                                                            <td class="align-middle">
                                                                <span style="font-weight: 600; color: #28a745;">
                                                                    N${{ number_format($payment->payment_amount, 2) }}
                                                                </span>
                                                            </td>
                                                            <td class="align-middle">
                                                                <span class="badge badge-light" style="background: #f8f9fa; color: #495057; padding: 4px 8px; border-radius: 4px;">
                                                                    {{ $payment->payment_method }}
                                                                </span>
                                                            </td>
                                                            <td class="align-middle">
                                                                {{ $payment->reference_number ?? '-' }}
                                                            </td>
                                                            <td class="align-middle">
                                                                {{ $payment->payment_date ? $payment->payment_date->format('d/m/Y H:i') : 'N/A' }}
                                                            </td>
                                                            <td class="align-middle">
                                                                @if($payment->payment_source === 'Cashier')
                                                                    <span class="badge badge-success">Cashier</span>
                                                                @else
                                                                    <span class="badge badge-secondary">Manual</span>
                                                                @endif
                                                            </td>
                                                            <td class="align-middle">
                                                                @if($payment->payment_source === 'Cashier')
                                                                    {{ $payment->cashier ? $payment->cashier->name : 'N/A' }}
                                                                @else
                                                                    {{ $payment->user ? $payment->user->name : 'N/A' }}
                                                                @endif
                                                            </td>
                                                            <td class="align-middle">
                                                                <a href="{{ route('student-portal.print-payment-receipt', ['paymentId' => $payment->id, 'paymentSource' => $payment->payment_source]) }}" 
                                                                   class="btn btn-sm" 
                                                                   style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;" 
                                                                   target="_blank" 
                                                                   title="Print Receipt">
                                                                    <i class="fas fa-print"></i> Print
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <!-- Payment Summary for Year -->
                                <div class="mt-3 p-3" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 8px; border-left: 4px solid #667eea;">
                                    <h6><i class="fas fa-calculator"></i> Payment Summary for {{ $yearData['year'] }}</h6>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <p class="mb-1"><strong>Total Payments:</strong> {{ $yearData['payment_count'] }}</p>
                                        </div>
                                        <div class="col-md-4">
                                            <p class="mb-1"><strong>Year:</strong> {{ $yearData['year'] }}</p>
                                        </div>
                                        <div class="col-md-4">
                                            <p class="mb-1"><strong>Total Amount:</strong> N${{ number_format($yearData['total_amount'], 2) }}</p>
                                        </div>
                                    </div>
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
                        <i class="fas fa-credit-card fa-4x text-muted mb-4"></i>
                        <h5 class="text-muted mb-3">No Payments Found</h5>
                        <p class="text-muted mb-4">You haven't made any payments yet. Your payment history will appear here once payments are processed.</p>
                        <div class="alert alert-info" role="alert">
                            <i class="fas fa-info-circle"></i>
                            <strong>Note:</strong> Payment records will appear here once you make payments through the cashier or manual payment system.
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

.table th {
    border-top: none;
    font-weight: 600;
    color: #495057;
}

.table td {
    vertical-align: middle;
}

.badge {
    font-size: 0.75rem;
    padding: 0.375rem 0.75rem;
}

.card {
    border: none;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    border-radius: 0.375rem;
}

.btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}
</style>

<script>
function togglePayments(index) {
    const content = document.getElementById('payments-' + index);
    const arrow = document.getElementById('arrow-' + index);
    
    // Toggle current payments
    if (content.style.display === 'none' || content.style.display === '') {
        content.style.display = 'block';
        arrow.classList.add('rotated');
    } else {
        content.style.display = 'none';
        arrow.classList.remove('rotated');
    }
}
</script>
