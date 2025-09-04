@extends('layouts.app')
@section('breadcrumb')
<div class="c-subheader px-3">
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Human Resources</li>
        <li class="breadcrumb-item"><a href="{{route('payroll.index')}}">Payroll</a></li>
        <li class="breadcrumb-item"><a href="{{route('payroll.items')}}">Payroll Items</a></li>
        <li class="breadcrumb-item active">Create Item</li>
    </ol>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Create Payroll Item</h5>
                <small class="text-muted">Define a new earning or deduction item for payroll processing</small>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {!! Form::open(['route' => 'payroll.items.store', 'class' => 'form-horizontal']) !!}

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {{Form::label('item_name', 'Item Name')}}
                            {{Form::text('item_name', null, ['class' => 'form-control', 'required', 'placeholder' => 'Housing Allowance'])}}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {{Form::label('item_type', 'Item Type')}}
                            {{Form::select('item_type', ['earning' => 'Earning', 'deduction' => 'Deduction'], null, ['class' => 'form-control', 'required', 'placeholder' => 'Select Type'])}}
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    {{Form::label('description', 'Description')}}
                    {{Form::textarea('description', null, ['class' => 'form-control', 'rows' => 2, 'placeholder' => 'Brief description of this payroll item...'])}}
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {{Form::label('calculation_method', 'Calculation Method')}}
                            {{Form::select('calculation_method', [
                                'fixed_amount' => 'Fixed Amount',
                                'percentage' => 'Percentage of Salary',
                                'hours_worked' => 'Hours Worked',
                                'days_worked' => 'Days Worked'
                            ], null, ['class' => 'form-control', 'required', 'id' => 'calculation_method'])}}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {{Form::label('amount', 'Amount/Rate')}}
                            <div class="input-group">
                                <div class="input-group-prepend" id="amount_prefix">
                                    <span class="input-group-text">N$</span>
                                </div>
                                {{Form::number('amount', null, ['class' => 'form-control', 'step' => '0.01', 'min' => '0', 'required', 'id' => 'amount'])}}
                                <div class="input-group-append" id="amount_suffix" style="display: none;">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                            <small class="form-text text-muted" id="amount_help">Enter the fixed amount in Namibian Dollars</small>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="form-check">
                                {{Form::checkbox('is_taxable', 1, true, ['class' => 'form-check-input', 'id' => 'is_taxable'])}}
                                {{Form::label('is_taxable', 'Taxable', ['class' => 'form-check-label'])}}
                            </div>
                            <small class="form-text text-muted">Check if this item affects taxable income</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="form-check">
                                {{Form::checkbox('is_active', 1, true, ['class' => 'form-check-input', 'id' => 'is_active'])}}
                                {{Form::label('is_active', 'Active', ['class' => 'form-check-label'])}}
                            </div>
                            <small class="form-text text-muted">Active items are available for payroll processing</small>
                        </div>
                    </div>
                </div>

                <div class="form-group mt-4">
                    <button type="submit" class="btn" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem; margin-right: 8px;">
                        <i class="fas fa-save"></i> Create Item
                    </button>
                    <a href="{{route('payroll.items')}}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                </div>

                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const calculationMethod = document.getElementById('calculation_method');
    const amountPrefix = document.getElementById('amount_prefix');
    const amountSuffix = document.getElementById('amount_suffix');
    const amountHelp = document.getElementById('amount_help');
    
    calculationMethod.addEventListener('change', function() {
        const method = this.value;
        
        if (method === 'percentage') {
            amountPrefix.style.display = 'none';
            amountSuffix.style.display = 'flex';
            amountHelp.textContent = 'Enter percentage (0-100)';
        } else {
            amountPrefix.style.display = 'flex';
            amountSuffix.style.display = 'none';
            
            switch(method) {
                case 'fixed_amount':
                    amountHelp.textContent = 'Enter the fixed amount in Namibian Dollars';
                    break;
                case 'hours_worked':
                    amountHelp.textContent = 'Enter rate per hour in Namibian Dollars';
                    break;
                case 'days_worked':
                    amountHelp.textContent = 'Enter rate per day in Namibian Dollars';
                    break;
                default:
                    amountHelp.textContent = 'Enter the amount in Namibian Dollars';
            }
        }
    });
});
</script>
@endsection
