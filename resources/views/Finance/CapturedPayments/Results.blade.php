@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-md-12">
                
                <!-- Header with Back Button -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2><i class="fas fa-receipt"></i> Captured Payments Results</h2>
                        <p class="text-muted" id="results-count">{{ $payments->total() }} payment(s) found</p>
                    </div>
                    <div>
                        <a href="{{ route('captured-payments.index') }}" class="btn" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                            <i class="fas fa-arrow-left"></i> Back to Search
                        </a>
                        @permission('export-captured-payments')
                        <form method="POST" action="{{ route('captured-payments.export') }}" style="display: inline;">
                            @csrf
                            @foreach($request->all() as $key => $value)
                                @if($key !== '_token')
                                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                @endif
                            @endforeach
                            <button type="submit" class="btn" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                                <i class="fas fa-download"></i> Export CSV
                            </button>
                        </form>
                        @endpermission
                    </div>
                </div>

                <!-- Quick Search Field -->
                <div class="card mb-4" style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2); border-radius: 12px;">
                    <div class="card-body py-3">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none;">
                                            <i class="fas fa-search"></i>
                                        </span>
                                    </div>
                                    <input type="text" 
                                           id="quick-search" 
                                           class="form-control" 
                                           placeholder="Search across all results (student name, receipt number, reference, amount...)"
                                           value="{{ request('quick_search') }}"
                                           style="border-left: none; border-right: none;">
                                    <div class="input-group-append">
                                        <button type="button" id="search-button" class="btn" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 0 6px 6px 0;">
                                            <i class="fas fa-search"></i> Search
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 text-right">
                                <button type="button" id="clear-search" class="btn btn-outline-secondary btn-sm" style="border-radius: 6px;">
                                    <i class="fas fa-times"></i> Clear
                                </button>
                                <div class="spinner-border spinner-border-sm ml-2 d-none" id="search-loading" role="status">
                                    <span class="sr-only">Searching...</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Results Container (will be updated via AJAX) -->
                <div id="results-container">
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
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Void Payment Modal -->
<div class="modal fade" id="voidPaymentModal" tabindex="-1" role="dialog" aria-labelledby="voidPaymentModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="voidPaymentModalLabel">Void Payment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="voidPaymentForm" method="POST" action="{{ route('captured-payments.void') }}">
                @csrf
                <div class="modal-body">
                    <input type="hidden" id="void_payment_id" name="payment_id">
                    <input type="hidden" id="void_payment_source" name="payment_source">
                    
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i>
                        <strong>Warning:</strong> This action will permanently void the payment and reverse it from the student's account. This cannot be undone.
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Receipt Number:</strong>
                            <span id="void_receipt_number"></span>
                        </div>
                        <div class="col-md-6">
                            <strong>Amount:</strong>
                            <span id="void_amount"></span>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <div class="form-group">
                        <label for="void_reason"><strong>Void Reason <span class="text-danger">*</span></strong></label>
                        <select class="form-control" id="void_reason" name="void_reason" required>
                            <option value="">Select a reason...</option>
                            <option value="Duplicate Payment">Duplicate Payment</option>
                            <option value="Incorrect Amount">Incorrect Amount</option>
                            <option value="Wrong Student">Wrong Student</option>
                            <option value="Payment Error">Payment Error</option>
                            <option value="Refund Request">Refund Request</option>
                            <option value="System Error">System Error</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    
                    <div class="form-group" id="other_reason_group" style="display: none;">
                        <label for="other_reason">Specify Other Reason</label>
                        <textarea class="form-control" id="other_reason" name="other_reason" rows="3" placeholder="Please specify the reason for voiding this payment..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-ban"></i> Void Payment
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.table th {
    border-top: none;
    font-weight: 600;
    color: #495057;
    background-color: #f8f9fa;
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

.pagination .page-link {
    color: #6f42c1;
    border-color: #dee2e6;
}

.pagination .page-item.active .page-link {
    background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%);
    border-color: #6f42c1;
}

.pagination .page-link:hover {
    color: #007bff;
    background-color: #e9ecef;
}

.search-highlight {
    background-color: #fff3cd;
    padding: 2px 4px;
    border-radius: 3px;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let searchTimeout;
    const searchInput = document.getElementById('quick-search');
    const searchButton = document.getElementById('search-button');
    const clearButton = document.getElementById('clear-search');
    const loadingSpinner = document.getElementById('search-loading');
    const resultsContainer = document.getElementById('results-container');
    const resultsCount = document.getElementById('results-count');

    // Get current URL parameters
    function getCurrentParams() {
        const urlParams = new URLSearchParams(window.location.search);
        const params = {};
        for (const [key, value] of urlParams) {
            if (key !== 'quick_search' && key !== 'page') {
                params[key] = value;
            }
        }
        return params;
    }

    // Perform AJAX search
    function performSearch(searchTerm, page = 1) {
        loadingSpinner.classList.remove('d-none');
        
        const params = getCurrentParams();
        params.quick_search = searchTerm;
        params.page = page;
        params.ajax = 1;

        // Build query string
        const queryString = new URLSearchParams(params).toString();
        const url = '{{ route("captured-payments.search") }}?' + queryString;

        fetch(url, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => {
            console.log('Response status:', response.status);
            console.log('Response headers:', response.headers);
            return response.json();
        })
        .then(data => {
            console.log('Search response data:', data);
            if (data && data.success && data.html) {
                resultsContainer.innerHTML = data.html;
                resultsCount.textContent = data.total + ' payment(s) found';
                
                // Update URL without page reload
                const newUrl = new URL(window.location);
                if (searchTerm) {
                    newUrl.searchParams.set('quick_search', searchTerm);
                } else {
                    newUrl.searchParams.delete('quick_search');
                }
                newUrl.searchParams.delete('page');
                window.history.replaceState({}, '', newUrl);
            } else if (data && data.error) {
                console.error('Server error:', data.message);
                resultsContainer.innerHTML = data.html || '<div class="alert alert-danger">' + data.message + '</div>';
            } else {
                console.error('Invalid response format:', data);
                resultsContainer.innerHTML = '<div class="alert alert-danger">Invalid response format received.</div>';
            }
        })
        .catch(error => {
            console.error('Search error:', error);
            resultsContainer.innerHTML = '<div class="alert alert-danger">An error occurred while searching. Please try again.</div>';
        })
        .finally(() => {
            loadingSpinner.classList.add('d-none');
        });
    }

    // Handle search input with debouncing
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.trim();
            
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(function() {
                performSearch(searchTerm);
            }, 500); // 500ms delay
        });
    }

    // Handle search button
    if (searchButton) {
        searchButton.addEventListener('click', function() {
            clearTimeout(searchTimeout);
            const searchTerm = searchInput.value.trim();
            performSearch(searchTerm);
        });
    }

    // Handle clear button - reload page to show all results
    if (clearButton) {
        clearButton.addEventListener('click', function() {
            // Get current URL without search parameters
            const currentUrl = new URL(window.location);
            currentUrl.searchParams.delete('quick_search');
            currentUrl.searchParams.delete('page');
            
            // Reload page to show all results
            window.location.href = currentUrl.toString();
        });
    }

    // Handle pagination clicks (delegated event)
    document.addEventListener('click', function(e) {
        if (e.target.closest('.pagination a')) {
            e.preventDefault();
            const url = new URL(e.target.closest('.pagination a').href);
            const page = url.searchParams.get('page') || 1;
            const searchTerm = searchInput.value.trim();
            
            performSearch(searchTerm, page);
        }
    });

    // Handle Enter key
    if (searchInput) {
        searchInput.addEventListener('keypress', function(e) {
            if (e.which === 13 || e.keyCode === 13) { // Enter key
                clearTimeout(searchTimeout);
                const searchTerm = this.value.trim();
                performSearch(searchTerm);
            }
        });
    }
});

// Void Payment Modal Functions
function showVoidModal(paymentId, paymentSource, receiptNumber, amount) {
    console.log('showVoidModal called with:', paymentId, paymentSource, receiptNumber, amount);
    
    document.getElementById('void_payment_id').value = paymentId;
    document.getElementById('void_payment_source').value = paymentSource;
    document.getElementById('void_receipt_number').textContent = receiptNumber;
    document.getElementById('void_amount').textContent = parseFloat(amount).toFixed(2);
    
    // Reset form
    document.getElementById('void_reason').value = '';
    document.getElementById('other_reason').value = '';
    document.getElementById('other_reason_group').style.display = 'none';
    
    // Show modal using Bootstrap 4 method
    $('#voidPaymentModal').modal('show');
}

// Handle void reason change - moved inside main DOMContentLoaded
document.addEventListener('DOMContentLoaded', function() {
    // Existing search functionality code above...
    
    // Void reason dropdown handler
    const voidReasonSelect = document.getElementById('void_reason');
    const otherReasonGroup = document.getElementById('other_reason_group');
    const otherReasonTextarea = document.getElementById('other_reason');
    
    if (voidReasonSelect) {
        voidReasonSelect.addEventListener('change', function() {
            if (this.value === 'Other') {
                otherReasonGroup.style.display = 'block';
                otherReasonTextarea.required = true;
            } else {
                otherReasonGroup.style.display = 'none';
                otherReasonTextarea.required = false;
                otherReasonTextarea.value = '';
            }
        });
    }
    
    // Test void modal functionality
    console.log('Void modal elements check:');
    console.log('Modal:', document.getElementById('voidPaymentModal'));
    console.log('Form:', document.getElementById('voidPaymentForm'));
    console.log('jQuery loaded:', typeof $ !== 'undefined');
});
</script>
@endsection
