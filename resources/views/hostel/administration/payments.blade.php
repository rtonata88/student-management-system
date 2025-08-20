@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Hostel Payments</h4>
                    <div class="card-tools">
                        <a href="{{ route('hostel.administration.payments.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Record Payment
                        </a>
                        <a href="{{ route('hostel.administration.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to Dashboard
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if($payments->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" id="paymentsTable">
                                <thead>
                                    <tr>
                                        <th>Payment ID</th>
                                        <th>Student</th>
                                        <th>Hostel</th>
                                        <th>Amount</th>
                                        <th>Payment Date</th>
                                        <th>Payment Method</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($payments as $payment)
                                    <tr class="@if($payment->status == 'overdue') table-danger @elseif($payment->status == 'pending' && $payment->due_date && $payment->due_date->isPast()) table-warning @endif">
                                        <td>
                                            {{ $payment->payment_reference ?? 'PAY-' . str_pad($payment->id, 6, '0', STR_PAD_LEFT) }}
                                            <br><small class="text-muted">{{ ucfirst(str_replace('_', ' ', $payment->payment_type)) }}</small>
                                        </td>
                                        <td>
                                            @if($payment->student)
                                                {{ $payment->student->surname }}, {{ $payment->student->student_names }}
                                                <br><small class="text-muted">{{ $payment->student->student_number2 }}</small>
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($payment->allocation && $payment->allocation->hostel)
                                                {{ $payment->allocation->hostel->name }}
                                                <br><small class="text-muted">Room {{ $payment->allocation->room->room_number ?? 'N/A' }}</small>
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>
                                        <td>
                                            ${{ number_format($payment->amount, 2) }}
                                            @if($payment->due_date)
                                                <br><small class="text-muted">Due: {{ $payment->due_date->format('M d, Y') }}</small>
                                            @endif
                                        </td>
                                        <td>{{ $payment->payment_date ? $payment->payment_date->format('M d, Y') : 'Not Paid' }}</td>
                                        <td>
                                            <span class="badge badge-info">{{ ucfirst($payment->payment_method ?? 'N/A') }}</span>
                                        </td>
                                        <td>
                                            @if($payment->status == 'paid')
                                                <span class="badge badge-success">Paid</span>
                                            @elseif($payment->status == 'pending')
                                                @if($payment->due_date && $payment->due_date->isPast())
                                                    <span class="badge badge-danger">Overdue</span>
                                                @else
                                                    <span class="badge badge-warning">Pending</span>
                                                @endif
                                            @else
                                                <span class="badge badge-danger">{{ ucfirst($payment->status) }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <button class="btn btn-info btn-sm" title="View Details" onclick="viewPayment({{ $payment->id }})">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                @if($payment->status == 'pending')
                                                <button class="btn btn-success btn-sm" title="Record Payment" onclick="recordPayment({{ $payment->id }})">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-money-bill fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No payments found</h5>
                            <p class="text-muted">Payment records will appear here once students start making payments.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<!-- Payment Recording Modal -->
<div class="modal fade" id="recordPaymentModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="recordPaymentForm" method="POST" action="{{ route('hostel.administration.payments.record') }}">
                @csrf
                <input type="hidden" id="payment_id" name="payment_id">
                <div class="modal-header">
                    <h5 class="modal-title">Record Payment</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="amount">Amount</label>
                        <input type="number" step="0.01" class="form-control" id="amount" name="amount" required>
                    </div>
                    <div class="form-group">
                        <label for="payment_method">Payment Method</label>
                        <select class="form-control" id="payment_method" name="payment_method" required>
                            <option value="">Select Method</option>
                            <option value="cash">Cash</option>
                            <option value="bank_transfer">Bank Transfer</option>
                            <option value="online">Online Payment</option>
                            <option value="cheque">Cheque</option>
                            <option value="card">Card</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="payment_reference">Reference Number</label>
                        <input type="text" class="form-control" id="payment_reference" name="payment_reference">
                    </div>
                    <div class="form-group">
                        <label for="payment_date">Payment Date</label>
                        <input type="date" class="form-control" id="payment_date" name="payment_date" value="{{ date('Y-m-d') }}" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Record Payment</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('dataTableScript')
<script>
$(document).ready(function() {
    $('#paymentsTable').DataTable({
        responsive: true,
        order: [[4, 'desc']], // Sort by payment date descending
        columnDefs: [
            { orderable: false, targets: [7] } // Disable sorting on actions column
        ]
    });
});

function recordPayment(paymentId) {
    $('#payment_id').val(paymentId);
    $('#recordPaymentModal').modal('show');
}

function viewPayment(paymentId) {
    // You can implement payment details view here
    alert('Payment details for ID: ' + paymentId);
}
</script>
@endpush
