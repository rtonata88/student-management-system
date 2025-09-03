@extends('layouts.app')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Finance</li>
        <li class="breadcrumb-item"><a href="/cashier">Cashier</a></li>
        <li class="breadcrumb-item active">Payment Receipt</li>
        <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="receipt-container">
                <!-- Receipt Header -->
                <div class="receipt-header">
                    <div class="company-info">
                        <h2 class="company-name">Student Management System</h2>
                        <p class="company-subtitle">Payment Receipt</p>
                    </div>
                    <div class="receipt-status">
                        <span class="status-badge">PAID</span>
                    </div>
                </div>

                <!-- Receipt Details -->
                <div class="receipt-details">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="detail-section">
                                <h5 class="section-title">Receipt Information</h5>
                                <div class="detail-item">
                                    <span class="label">Receipt Number:</span>
                                    <span class="value receipt-number">{{$payment->receipt_number}}</span>
                                </div>
                                <div class="detail-item">
                                    <span class="label">Payment Date:</span>
                                    <span class="value">{{$payment->payment_date->format('d F Y, H:i')}}</span>
                                </div>
                                <div class="detail-item">
                                    <span class="label">Payment Method:</span>
                                    <span class="value">{{$payment->payment_method}}</span>
                                </div>
                                @if($payment->reference_number)
                                <div class="detail-item">
                                    <span class="label">Reference:</span>
                                    <span class="value">{{$payment->reference_number}}</span>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-section">
                                <h5 class="section-title">Student Information</h5>
                                <div class="detail-item">
                                    <span class="label">Student Number:</span>
                                    <span class="value">{{$payment->student->student_number}}</span>
                                </div>
                                <div class="detail-item">
                                    <span class="label">Allocated Number:</span>
                                    <span class="value">{{$payment->student->student_number2}}</span>
                                </div>
                                <div class="detail-item">
                                    <span class="label">Name:</span>
                                    <span class="value">{{$payment->student->student_names}} {{$payment->student->surname}}</span>
                                </div>
                                <div class="detail-item">
                                    <span class="label">Center:</span>
                                    <span class="value">{{$payment->student->center->center_name ?? 'N/A'}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Summary -->
                <div class="payment-summary">
                    <div class="summary-row">
                        <span class="summary-label">Payment Amount:</span>
                        <span class="summary-amount">N$ {{number_format($payment->amount, 2)}}</span>
                    </div>
                    <div class="summary-row total">
                        <span class="summary-label">Total Paid:</span>
                        <span class="summary-amount">N$ {{number_format($payment->amount, 2)}}</span>
                    </div>
                </div>

                @if($payment->notes)
                <!-- Notes Section -->
                <div class="notes-section">
                    <h5 class="section-title">Notes</h5>
                    <p class="notes-text">{{$payment->notes}}</p>
                </div>
                @endif

                <!-- Cashier Information -->
                <div class="cashier-info">
                    <div class="detail-item">
                        <span class="label">Processed by:</span>
                        <span class="value">{{$payment->cashier->name}}</span>
                    </div>
                    <div class="detail-item">
                        <span class="label">Date & Time:</span>
                        <span class="value">{{$payment->created_at->format('d F Y, H:i:s')}}</span>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="receipt-actions">
                    <a href="{{route('cashier.print-receipt', $payment->id)}}" target="_blank" class="btn btn-gradient-primary">
                        <i class="fas fa-print me-2"></i>Print Receipt
                    </a>
                    <a href="{{route('cashier.index')}}" class="btn btn-gradient-secondary">
                        <i class="fas fa-plus me-2"></i>New Payment
                    </a>
                    <a href="{{route('cashier.payment-form', $payment->student->id)}}" class="btn btn-gradient-info">
                        <i class="fas fa-credit-card me-2"></i>Another Payment
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.receipt-container {
    background: white;
    border-radius: 15px;
    box-shadow: 0 15px 35px rgba(0,0,0,0.1);
    overflow: hidden;
    margin: 2rem 0;
}

.receipt-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 2rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.company-name {
    font-size: 1.8rem;
    font-weight: 700;
    margin: 0;
}

.company-subtitle {
    font-size: 1rem;
    margin: 0.5rem 0 0 0;
    opacity: 0.9;
}

.status-badge {
    background: rgba(255, 255, 255, 0.2);
    padding: 0.5rem 1.5rem;
    border-radius: 25px;
    font-weight: 600;
    font-size: 0.9rem;
    backdrop-filter: blur(10px);
    border: 2px solid rgba(255, 255, 255, 0.3);
}

.receipt-details {
    padding: 2rem;
}

.detail-section {
    margin-bottom: 2rem;
}

.section-title {
    color: #495057;
    font-weight: 600;
    margin-bottom: 1rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid #e9ecef;
}

.detail-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem 0;
    border-bottom: 1px solid #f8f9fa;
}

.detail-item:last-child {
    border-bottom: none;
}

.detail-item .label {
    font-weight: 500;
    color: #6c757d;
}

.detail-item .value {
    font-weight: 600;
    color: #495057;
}

.receipt-number {
    font-family: 'Courier New', monospace;
    font-size: 1.1rem;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.payment-summary {
    background: #f8f9fa;
    padding: 1.5rem 2rem;
    margin: 0 2rem;
    border-radius: 10px;
    border: 2px solid #e9ecef;
}

.summary-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.5rem 0;
}

.summary-row.total {
    border-top: 2px solid #dee2e6;
    margin-top: 1rem;
    padding-top: 1rem;
    font-size: 1.2rem;
    font-weight: 700;
}

.summary-label {
    font-weight: 600;
    color: #495057;
}

.summary-amount {
    font-weight: 700;
    color: #28a745;
    font-size: 1.1rem;
}

.summary-row.total .summary-amount {
    font-size: 1.4rem;
}

.notes-section {
    padding: 2rem;
    background: #f8f9fa;
    margin: 2rem;
    border-radius: 10px;
    border-left: 4px solid #667eea;
}

.notes-text {
    color: #495057;
    margin: 0;
    line-height: 1.6;
}

.cashier-info {
    padding: 1.5rem 2rem;
    background: #e9ecef;
    border-top: 1px solid #dee2e6;
}

.receipt-actions {
    padding: 2rem;
    display: flex;
    gap: 1rem;
    justify-content: center;
    flex-wrap: wrap;
}

.btn-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    color: white;
    padding: 0.75rem 1.5rem;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
    text-decoration: none;
}

.btn-gradient-primary:hover {
    background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
    color: white;
    text-decoration: none;
}

.btn-gradient-secondary {
    background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
    border: none;
    color: white;
    padding: 0.75rem 1.5rem;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
    text-decoration: none;
}

.btn-gradient-secondary:hover {
    background: linear-gradient(135deg, #5a6268 0%, #3d4142 100%);
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(108, 117, 125, 0.3);
    color: white;
    text-decoration: none;
}

.btn-gradient-info {
    background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
    border: none;
    color: white;
    padding: 0.75rem 1.5rem;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
    text-decoration: none;
}

.btn-gradient-info:hover {
    background: linear-gradient(135deg, #138496 0%, #0f6674 100%);
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(23, 162, 184, 0.3);
    color: white;
    text-decoration: none;
}

@media (max-width: 768px) {
    .receipt-header {
        flex-direction: column;
        text-align: center;
        gap: 1rem;
    }
    
    .receipt-actions {
        flex-direction: column;
    }
    
    .receipt-actions .btn {
        width: 100%;
    }
}
</style>
@endsection
