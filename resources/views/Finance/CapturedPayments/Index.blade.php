@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="animated fadeIn">
        <div class="row justify-content-center">
            <div class="col-md-12">
                
                <!-- Search Container -->
                <div class="search-container">
                    <div class="search-card">
                        <div class="search-header">
                            <h3><i class="fas fa-receipt"></i> Captured Payments</h3>
                            <p class="mb-0">Search and manage all student payments from cashier and manual systems</p>
                        </div>
                        
                        <form method="POST" action="{{ route('captured-payments.search') }}" class="search-form">
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="student_search"><i class="fas fa-user"></i> Student Search</label>
                                        <input type="text" 
                                               class="form-control" 
                                               id="student_search" 
                                               name="student_search" 
                                               placeholder="Student number, name, or surname"
                                               value="{{ old('student_search') }}">
                                        <small class="form-text text-muted">Search by student number or name</small>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="receipt_number"><i class="fas fa-hashtag"></i> Receipt Number</label>
                                        <input type="text" 
                                               class="form-control" 
                                               id="receipt_number" 
                                               name="receipt_number" 
                                               placeholder="Receipt number"
                                               value="{{ old('receipt_number') }}">
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="reference_number"><i class="fas fa-barcode"></i> Reference Number</label>
                                        <input type="text" 
                                               class="form-control" 
                                               id="reference_number" 
                                               name="reference_number" 
                                               placeholder="Reference number"
                                               value="{{ old('reference_number') }}">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="date_from"><i class="fas fa-calendar"></i> Date From</label>
                                        <input type="date" 
                                               class="form-control text-center" 
                                               id="date_from" 
                                               name="date_from" 
                                               value="{{ old('date_from') }}">
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="date_to"><i class="fas fa-calendar"></i> Date To</label>
                                        <input type="date" 
                                               class="form-control text-center" 
                                               id="date_to" 
                                               name="date_to" 
                                               value="{{ old('date_to') }}">
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="payment_method"><i class="fas fa-credit-card"></i> Payment Method</label>
                                        <select class="form-control" id="payment_method" name="payment_method">
                                            <option value="">All Methods</option>
                                            <option value="Cash" {{ old('payment_method') == 'Cash' ? 'selected' : '' }}>Cash</option>
                                            <option value="Card" {{ old('payment_method') == 'Card' ? 'selected' : '' }}>Card</option>
                                            <option value="Bank Transfer" {{ old('payment_method') == 'Bank Transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                            <option value="Mobile Money" {{ old('payment_method') == 'Mobile Money' ? 'selected' : '' }}>Mobile Money</option>
                                            <option value="Cheque" {{ old('payment_method') == 'Cheque' ? 'selected' : '' }}>Cheque</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="payment_source"><i class="fas fa-source"></i> Payment Source</label>
                                        <select class="form-control" id="payment_source" name="payment_source">
                                            <option value="">All Sources</option>
                                            <option value="Cashier" {{ old('payment_source') == 'Cashier' ? 'selected' : '' }}>Cashier</option>
                                            <option value="Manual" {{ old('payment_source') == 'Manual' ? 'selected' : '' }}>Manual</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-actions">
                                <button type="submit" class="btn btn-search" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                                    <i class="fas fa-search"></i> Search Payments
                                </button>
                                <button type="button" class="btn btn-clear" onclick="clearForm()" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                                    <i class="fas fa-eraser"></i> Clear
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                @if(session('message'))
                    <div class="alert alert-info alert-dismissible fade show mt-3" role="alert">
                        {{ session('message') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>

<style>
.search-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 2rem 1rem;
}

.search-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 20px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    overflow: hidden;
    position: relative;
}

.search-header {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    padding: 2rem;
    text-align: center;
    border-bottom: 1px solid rgba(255, 255, 255, 0.2);
}

.search-header h3 {
    color: white;
    font-weight: 600;
    margin-bottom: 0.5rem;
    font-size: 1.8rem;
}

.search-header p {
    color: rgba(255, 255, 255, 0.9);
    font-size: 1rem;
}

.search-form {
    padding: 2rem;
}

.form-group label {
    color: white;
    font-weight: 500;
    margin-bottom: 0.5rem;
    display: block;
}

.form-control {
    background: rgba(255, 255, 255, 0.9);
    border: 1px solid rgba(255, 255, 255, 0.3);
    border-radius: 8px;
    padding: 0.75rem;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    height: 48px;
}

.form-control:focus {
    background: rgba(255, 255, 255, 1);
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.form-text {
    color: rgba(255, 255, 255, 0.8);
    font-size: 0.875rem;
}

.form-actions {
    text-align: center;
    margin-top: 2rem;
}

.btn-search, .btn-clear {
    margin: 0 0.5rem;
    padding: 0.75rem 2rem;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
}

.btn-search:hover, .btn-clear:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.3);
}

@media (max-width: 768px) {
    .search-container {
        padding: 1rem;
    }
    
    .search-header {
        padding: 1.5rem;
    }
    
    .search-form {
        padding: 1.5rem;
    }
    
    .btn-search, .btn-clear {
        display: block;
        width: 100%;
        margin: 0.5rem 0;
    }
}
</style>

<script>
function clearForm() {
    document.getElementById('student_search').value = '';
    document.getElementById('receipt_number').value = '';
    document.getElementById('reference_number').value = '';
    document.getElementById('date_from').value = '';
    document.getElementById('date_to').value = '';
    document.getElementById('payment_method').value = '';
    document.getElementById('payment_source').value = '';
}

// Date validation - ensure date_to is not earlier than date_from
document.getElementById('date_from').addEventListener('change', function() {
    const dateFrom = this.value;
    const dateTo = document.getElementById('date_to');
    
    if (dateFrom && dateTo.value && dateTo.value < dateFrom) {
        dateTo.value = dateFrom;
    }
    
    dateTo.min = dateFrom;
});

document.getElementById('date_to').addEventListener('change', function() {
    const dateTo = this.value;
    const dateFrom = document.getElementById('date_from').value;
    
    if (dateFrom && dateTo && dateTo < dateFrom) {
        alert('Date To cannot be earlier than Date From');
        this.value = dateFrom;
    }
});
</script>
@endsection
