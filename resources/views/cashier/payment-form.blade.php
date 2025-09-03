@extends('layouts.app')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Finance</li>
        <li class="breadcrumb-item"><a href="/cashier">Cashier</a></li>
        <li class="breadcrumb-item active">Process Payment</li>
        <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection
@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Student Information Card -->
        <div class="col-md-4">
            <div class="card student-info-card">
                <div class="card-header bg-gradient-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-user me-2"></i>Student Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="student-detail">
                        <label>Student Number:</label>
                        <span class="value">{{$student->student_number}}</span>
                    </div>
                    <div class="student-detail">
                        <label>Allocated Number:</label>
                        <span class="value">{{$student->student_number2}}</span>
                    </div>
                    <div class="student-detail">
                        <label>Full Name:</label>
                        <span class="value">{{$student->student_names}} {{$student->surname}}</span>
                    </div>
                    <div class="student-detail">
                        <label>Date of Birth:</label>
                        <span class="value">{{$student->date_of_birth}}</span>
                    </div>
                    <div class="student-detail">
                        <label>Centre:</label>
                        <span class="value">
                            @if($student->center)
                                {{$student->center->center_name}}
                            @else
                                <span class="text-muted">Not assigned</span>
                            @endif
                        </span>
                    </div>
                </div>
            </div>

            <!-- Recent Payments -->
            @if($recentPayments->count() > 0)
            <div class="card mt-3">
                <div class="card-header bg-gradient-info text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-history me-2"></i>Recent Payments
                    </h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-sm mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Receipt</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentPayments as $payment)
                                <tr>
                                    <td>{{$payment->payment_date->format('d/m/Y')}}</td>
                                    <td>N$ {{number_format($payment->amount, 2)}}</td>
                                    <td>{{$payment->receipt_number}}</td>
                                    <td>
                                        <a href="{{route('cashier.print-receipt', $payment->id)}}" 
                                           target="_blank" 
                                           class="btn btn-sm btn-outline-primary reprint-btn" 
                                           title="Reprint Receipt">
                                            <i class="fas fa-print me-1"></i>Reprint
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Payment Form -->
        <div class="col-md-8">
            <div class="card payment-form-card">
                <div class="card-header bg-gradient-success text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-credit-card me-2"></i>Process Payment
                    </h5>
                </div>
                <div class="card-body">
                    @if(Session::has('error'))
                    <div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        {{ Session::get('error') }}
                    </div>
                    @endif

                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    {!! Form::open(['route' => ['cashier.process-payment', $student->id], 'method' => 'post', 'class' => 'payment-form']) !!}
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="amount" class="form-label required">
                                    <i class="fas fa-dollar-sign me-2"></i>Payment Amount
                                </label>
                                {{Form::number('amount', old('amount'), [
                                    'class' => 'form-control form-control-lg',
                                    'placeholder' => '0.00',
                                    'step' => '0.01',
                                    'min' => '0.01',
                                    'max' => '999999.99',
                                    'id' => 'amount',
                                    'required' => true
                                ])}}
                                <div class="form-text">Enter the payment amount in Namibian Dollars</div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="payment_method" class="form-label required">
                                    <i class="fas fa-credit-card me-2"></i>Payment Method
                                </label>
                                {{Form::select('payment_method', [
                                    '' => 'Select payment method...',
                                    'Cash' => 'Cash',
                                    'Card' => 'Card',
                                    'Bank Transfer' => 'Bank Transfer',
                                    'Mobile Money' => 'Mobile Money',
                                    'Cheque' => 'Cheque'
                                ], old('payment_method'), [
                                    'class' => 'form-control form-control-lg',
                                    'id' => 'payment_method',
                                    'required' => true
                                ])}}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="reference_number" class="form-label">
                                    <i class="fas fa-hashtag me-2"></i>Reference Number
                                </label>
                                {{Form::text('reference_number', old('reference_number'), [
                                    'class' => 'form-control',
                                    'placeholder' => 'Transaction/Reference number (optional)',
                                    'id' => 'reference_number',
                                    'maxlength' => 255
                                ])}}
                                <div class="form-text">Optional reference for tracking</div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="notes" class="form-label">
                                    <i class="fas fa-sticky-note me-2"></i>Notes
                                </label>
                                {{Form::textarea('notes', old('notes'), [
                                    'class' => 'form-control',
                                    'placeholder' => 'Additional notes (optional)',
                                    'id' => 'notes',
                                    'rows' => 3,
                                    'maxlength' => 1000
                                ])}}
                                <div class="form-text">Optional notes about this payment</div>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-gradient-success btn-lg">
                            <i class="fas fa-check me-2"></i>Process Payment
                        </button>
                        <a href="{{route('cashier.index')}}" class="btn btn-gradient-secondary btn-lg">
                            <i class="fas fa-arrow-left me-2"></i>Back to Search
                        </a>
                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.bg-gradient-success {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
}

.bg-gradient-info {
    background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
}

.student-info-card, .payment-form-card {
    border: none;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    border-radius: 15px;
    overflow: hidden;
}

.student-detail {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem 0;
    border-bottom: 1px solid #f0f0f0;
}

.student-detail:last-child {
    border-bottom: none;
}

.student-detail label {
    font-weight: 600;
    color: #6c757d;
    margin: 0;
    font-size: 0.9rem;
}

.student-detail .value {
    font-weight: 500;
    color: #495057;
    text-align: right;
}

.form-label {
    font-weight: 600;
    color: #495057;
    margin-bottom: 0.5rem;
}

.form-label.required::after {
    content: " *";
    color: #dc3545;
}

.form-control-lg {
    font-size: 1.1rem;
    padding: 0.75rem 1rem;
    border-radius: 10px;
    border: 2px solid #e9ecef;
    transition: all 0.3s ease;
}

.form-control-lg:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

.form-actions {
    display: flex;
    gap: 1rem;
    justify-content: center;
    margin-top: 2rem;
    padding-top: 2rem;
    border-top: 1px solid #e9ecef;
}

.btn-gradient-success {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    border: none;
    color: white;
    padding: 0.75rem 2rem;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-gradient-success:hover {
    background: linear-gradient(135deg, #218838 0%, #1e7e34 100%);
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(40, 167, 69, 0.3);
    color: white;
}

.btn-gradient-secondary {
    background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
    border: none;
    color: white;
    padding: 0.75rem 2rem;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-gradient-secondary:hover {
    background: linear-gradient(135deg, #5a6268 0%, #3d4142 100%);
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(108, 117, 125, 0.3);
    color: white;
}

@media (max-width: 768px) {
    .form-actions {
        flex-direction: column;
    }
    
    .btn-lg {
        width: 100%;
    }
}

.reprint-btn {
    border-radius: 6px;
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
    transition: all 0.2s ease;
}

.reprint-btn:hover {
    background-color: #007bff;
    color: white;
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0, 123, 255, 0.3);
}
</style>
@endsection
