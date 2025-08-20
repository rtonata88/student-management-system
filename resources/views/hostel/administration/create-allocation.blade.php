@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Allocate Student to Hostel</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('hostel.administration.allocations.store') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="student_id">Student <span class="text-danger">*</span></label>
                                    <select class="form-control select2 @error('student_id') is-invalid @enderror" 
                                            id="student_id" name="student_id" required>
                                        <option value="">Select Student</option>
                                        @foreach($students as $student)
                                        <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                            {{ $student->name }} ({{ $student->email }})
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('student_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="bed_id">Available Bed <span class="text-danger">*</span></label>
                                    <select class="form-control select2 @error('bed_id') is-invalid @enderror" 
                                            id="bed_id" name="bed_id" required>
                                        <option value="">Select Available Bed</option>
                                        @foreach($availableBeds as $bed)
                                        <option value="{{ $bed->id }}" {{ old('bed_id') == $bed->id ? 'selected' : '' }}>
                                            {{ $bed->hostel->name }} - {{ $bed->block->name }} - Room {{ $bed->room->room_number }} - Bed {{ $bed->bed_number }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('bed_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="allocation_date">Allocation Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('allocation_date') is-invalid @enderror" 
                                           id="allocation_date" name="allocation_date" value="{{ old('allocation_date', date('Y-m-d')) }}" required>
                                    @error('allocation_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="expected_checkout_date">Expected Checkout Date</label>
                                    <input type="date" class="form-control @error('expected_checkout_date') is-invalid @enderror" 
                                           id="expected_checkout_date" name="expected_checkout_date" value="{{ old('expected_checkout_date') }}">
                                    @error('expected_checkout_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="monthly_fee">Monthly Fee <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">$</span>
                                        </div>
                                        <input type="number" step="0.01" class="form-control @error('monthly_fee') is-invalid @enderror" 
                                               id="monthly_fee" name="monthly_fee" value="{{ old('monthly_fee') }}" required>
                                    </div>
                                    @error('monthly_fee')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="security_deposit">Security Deposit <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">$</span>
                                        </div>
                                        <input type="number" step="0.01" class="form-control @error('security_deposit') is-invalid @enderror" 
                                               id="security_deposit" name="security_deposit" value="{{ old('security_deposit') }}" required>
                                    </div>
                                    @error('security_deposit')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="remarks">Remarks</label>
                            <textarea class="form-control @error('remarks') is-invalid @enderror" 
                                      id="remarks" name="remarks" rows="3">{{ old('remarks') }}</textarea>
                            @error('remarks')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Allocate Student</button>
                            <a href="{{ route('hostel.administration.allocations') }}" class="btn btn-secondary">Cancel</a>
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
});
</script>
@endpush
