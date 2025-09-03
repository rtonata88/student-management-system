@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Record New Payment</h4>
                    <div class="card-tools">
                        <a href="{{ route('hostel.administration.payments') }}" class="btn btn-sm" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.25rem 0.5rem;">
                            <i class="fas fa-arrow-left"></i> Back to Payments
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if($allocations->count() == 0)
                        <div class="alert alert-warning">
                            <h5><i class="icon fas fa-exclamation-triangle"></i> No Active Allocations</h5>
                            There are currently no active student allocations. You need to allocate students to hostel rooms first before recording payments.
                            <br><br>
                            <a href="{{ route('hostel.administration.allocations.create') }}" class="btn" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                                <i class="fas fa-plus"></i> Allocate Student to Room
                            </a>
                        </div>
                    @endif
                    
                    <form action="{{ route('hostel.administration.payments.store') }}" method="POST" @if($allocations->count() == 0) style="display: none;" @endif>
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="allocation_id">Student Allocation <span class="text-danger">*</span></label>
                                    <select class="form-control select2 @error('allocation_id') is-invalid @enderror" 
                                            id="allocation_id" name="allocation_id" required>
                                        <option value="">Select Student Allocation</option>
                                        @if($allocations->count() > 0)
                                            @foreach($allocations as $allocation)
                                            <option value="{{ $allocation->id }}" {{ old('allocation_id') == $allocation->id ? 'selected' : '' }}>
                                                {{ $allocation->student->surname ?? 'N/A' }}, {{ $allocation->student->student_names ?? 'N/A' }} 
                                                ({{ $allocation->hostel->name ?? 'N/A' }} - Room {{ $allocation->room->room_number ?? 'N/A' }})
                                            </option>
                                            @endforeach
                                        @else
                                            <option value="" disabled>No active student allocations found</option>
                                        @endif
                                    </select>
                                    @error('allocation_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="payment_type">Payment Type <span class="text-danger">*</span></label>
                                    <select class="form-control @error('payment_type') is-invalid @enderror" 
                                            id="payment_type" name="payment_type" required>
                                        <option value="">Select Payment Type</option>
                                        <option value="monthly_fee" {{ old('payment_type') == 'monthly_fee' ? 'selected' : '' }}>Monthly Fee</option>
                                        <option value="security_deposit" {{ old('payment_type') == 'security_deposit' ? 'selected' : '' }}>Security Deposit</option>
                                        <option value="maintenance" {{ old('payment_type') == 'maintenance' ? 'selected' : '' }}>Maintenance Fee</option>
                                        <option value="fine" {{ old('payment_type') == 'fine' ? 'selected' : '' }}>Fine</option>
                                        <option value="other" {{ old('payment_type') == 'other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    @error('payment_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="amount">Amount <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">$</span>
                                        </div>
                                        <input type="number" step="0.01" class="form-control @error('amount') is-invalid @enderror" 
                                               id="amount" name="amount" value="{{ old('amount') }}" required>
                                    </div>
                                    @error('amount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="payment_method">Payment Method <span class="text-danger">*</span></label>
                                    <select class="form-control @error('payment_method') is-invalid @enderror" 
                                            id="payment_method" name="payment_method" required>
                                        <option value="">Select Payment Method</option>
                                        <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                                        <option value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                        <option value="online" {{ old('payment_method') == 'online' ? 'selected' : '' }}>Online Payment</option>
                                        <option value="cheque" {{ old('payment_method') == 'cheque' ? 'selected' : '' }}>Cheque</option>
                                        <option value="card" {{ old('payment_method') == 'card' ? 'selected' : '' }}>Card</option>
                                    </select>
                                    @error('payment_method')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="payment_date">Payment Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('payment_date') is-invalid @enderror" 
                                           id="payment_date" name="payment_date" value="{{ old('payment_date', date('Y-m-d')) }}" required>
                                    @error('payment_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="due_date">Due Date</label>
                                    <input type="date" class="form-control @error('due_date') is-invalid @enderror" 
                                           id="due_date" name="due_date" value="{{ old('due_date') }}">
                                    @error('due_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="payment_reference">Reference Number</label>
                            <input type="text" class="form-control @error('payment_reference') is-invalid @enderror" 
                                   id="payment_reference" name="payment_reference" value="{{ old('payment_reference') }}" 
                                   placeholder="Transaction ID, Cheque Number, etc.">
                            @error('payment_reference')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">Record Payment</button>
                            <a href="{{ route('hostel.administration.payments') }}" class="btn" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('dataTableScript')
<script>
$(document).ready(function() {
    $('.select2').select2({
        theme: 'bootstrap4',
        width: '100%'
    });
    
    // Auto-populate amount based on allocation and payment type
    $('#allocation_id, #payment_type').change(function() {
        var allocationId = $('#allocation_id').val();
        var paymentType = $('#payment_type').val();
        
        if (allocationId && paymentType) {
            // You can add AJAX call here to get suggested amount
            // For now, we'll leave it empty for manual entry
        }
    });
});
</script>
@endpush
