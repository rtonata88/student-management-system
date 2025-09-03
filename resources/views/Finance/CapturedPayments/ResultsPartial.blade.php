@if($payments->count() > 0)
    <!-- Results Table -->
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>Receipt #</th>
                            <th>Student</th>
                            <th>Amount</th>
                            <th>Payment Method</th>
                            <th>Reference</th>
                            <th>Date</th>
                            <th>Source</th>
                            <th>Processed By</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($payments as $payment)
                            <tr>
                                <td>
                                    <strong>{{ $payment->receipt_number }}</strong>
                                </td>
                                <td>
                                    @if($payment->student)
                                        <div>
                                            <strong>{{ $payment->student->student_names }} {{ $payment->student->surname }}</strong><br>
                                            <small class="text-muted">{{ $payment->student->student_number }}</small>
                                        </div>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <td>
                                    <strong class="text-success">{{ number_format($payment->payment_amount, 2) }}</strong>
                                </td>
                                <td>
                                    <span class="badge" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">{{ $payment->payment_method }}</span>
                                </td>
                                <td>
                                    {{ $payment->reference_number ?? '-' }}
                                </td>
                                <td>
                                    {{ $payment->payment_date ? $payment->payment_date->format('d/m/Y H:i') : 'N/A' }}
                                </td>
                                <td>
                                    @if($payment->payment_source === 'Cashier')
                                        <span class="badge" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">Cashier</span>
                                    @else
                                        <span class="badge" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">Manual</span>
                                    @endif
                                </td>
                                <td>
                                    @if($payment->payment_source === 'Cashier')
                                        {{ $payment->cashier ? $payment->cashier->name : 'N/A' }}
                                    @else
                                        {{ $payment->user ? $payment->user->name : 'N/A' }}
                                    @endif
                                </td>
                                <td>
                                    @permission('reprint-payment-receipts')
                                    <form method="POST" action="{{ route('captured-payments.reprint') }}" style="display: inline;" target="_blank">
                                        @csrf
                                        <input type="hidden" name="payment_id" value="{{ $payment->id }}">
                                        <input type="hidden" name="payment_source" value="{{ $payment->payment_source }}">
                                        <button type="submit" class="btn btn-sm" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem; margin-right: 5px;" title="Reprint Receipt">
                                            <i class="fas fa-print"></i> Reprint
                                        </button>
                                    </form>
                                    @endpermission
                                    
                                    @permission('void-payments')
                                    <button type="button" class="btn btn-sm btn-danger" onclick="showVoidModal({{ $payment->id }}, '{{ $payment->payment_source }}', '{{ $payment->receipt_number }}', '{{ $payment->payment_source === 'Cashier' ? $payment->amount : $payment->payment_amount }}')" style="border-radius: 6px; padding: 0.375rem 0.75rem;" title="Void Payment">
                                        <i class="fas fa-ban"></i> Void
                                    </button>
                                    @endpermission
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $payments->appends(request()->query())->links() }}
    </div>

@else
    <!-- No Results -->
    <div class="card">
        <div class="card-body text-center py-5">
            <i class="fas fa-search fa-3x text-muted mb-3"></i>
            <h4>No Payments Found</h4>
            <p class="text-muted">No payments match your search criteria. Try adjusting your filters.</p>
            <a href="{{ route('captured-payments.index') }}" class="btn" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                <i class="fas fa-arrow-left"></i> Back to Search
            </a>
        </div>
    </div>
@endif
