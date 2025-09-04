@extends('layouts.app')
@section('breadcrumb')
<div class="c-subheader px-3">
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Human Resources</li>
        <li class="breadcrumb-item"><a href="{{route('payroll.index')}}">Payroll</a></li>
        <li class="breadcrumb-item"><a href="{{route('payroll.employees.index')}}">Employee Settings</a></li>
        <li class="breadcrumb-item active">Add Employee</li>
    </ol>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Add Employee to Payroll</h5>
                <small class="text-muted">Configure employee payroll settings and salary information</small>
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

                {!! Form::open(['route' => 'payroll.employees.store', 'class' => 'form-horizontal']) !!}

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {{Form::label('user_id', 'Select Employee')}}
                            {{Form::select('user_id', $users->pluck('name', 'id'), null, ['class' => 'form-control', 'placeholder' => 'Choose Employee', 'required', 'id' => 'user_id'])}}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {{Form::label('employee_number', 'Employee Number')}}
                            {{Form::text('employee_number', null, ['class' => 'form-control', 'required', 'readonly', 'id' => 'employee_number'])}}
                            <small class="form-text text-muted">Auto-populated from employee profile</small>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {{Form::label('basic_salary', 'Basic Salary (N$)')}}
                            {{Form::number('basic_salary', null, ['class' => 'form-control', 'step' => '0.01', 'min' => '0', 'required', 'readonly', 'id' => 'basic_salary'])}}
                            <small class="form-text text-muted">Auto-populated from employee profile</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {{Form::label('pay_frequency', 'Pay Frequency')}}
                            {{Form::select('pay_frequency', ['monthly' => 'Monthly', 'bi-weekly' => 'Bi-weekly', 'weekly' => 'Weekly'], 'monthly', ['class' => 'form-control', 'required'])}}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {{Form::label('tax_rate', 'Tax Rate (%)')}}
                            {{Form::number('tax_rate', 25, ['class' => 'form-control', 'step' => '0.01', 'min' => '0', 'max' => '100'])}}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {{Form::label('tax_number', 'Tax Number')}}
                            {{Form::text('tax_number', null, ['class' => 'form-control', 'readonly', 'id' => 'tax_number'])}}
                            <small class="form-text text-muted">Auto-populated from employee profile</small>
                        </div>
                    </div>
                </div>

                <h6 class="mt-4 mb-3">Banking Information</h6>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {{Form::label('bank_name', 'Bank Name')}}
                            {{Form::text('bank_name', null, ['class' => 'form-control', 'readonly', 'id' => 'bank_name'])}}
                            <small class="form-text text-muted">Auto-populated from employee profile</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {{Form::label('bank_branch', 'Bank Branch')}}
                            {{Form::text('bank_branch', null, ['class' => 'form-control', 'readonly', 'id' => 'bank_branch'])}}
                            <small class="form-text text-muted">Auto-populated from employee profile</small>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {{Form::label('account_number', 'Account Number')}}
                            {{Form::text('account_number', null, ['class' => 'form-control', 'readonly', 'id' => 'account_number'])}}
                            <small class="form-text text-muted">Auto-populated from employee profile</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {{Form::label('account_type', 'Account Type')}}
                            {{Form::text('account_type', null, ['class' => 'form-control', 'readonly', 'id' => 'account_type'])}}
                            <small class="form-text text-muted">Auto-populated from employee profile</small>
                        </div>
                    </div>
                </div>

                <div class="form-group mt-4">
                    <button type="submit" class="btn" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem; margin-right: 8px;">
                        <i class="fas fa-save"></i> Save Employee
                    </button>
                    <a href="{{route('payroll.employees.index')}}" class="btn btn-secondary">
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
    const userSelect = document.getElementById('user_id');
    const employeeData = @json($users->keyBy('id'));
    
    userSelect.addEventListener('change', function() {
        const userId = this.value;
        if (userId && employeeData[userId] && employeeData[userId].employee_profile) {
            const profile = employeeData[userId].employee_profile;
            
            // Auto-populate form fields
            document.getElementById('employee_number').value = profile.employee_number || '';
            document.getElementById('basic_salary').value = profile.salary || '';
            document.getElementById('tax_number').value = profile.tax_number || '';
            document.getElementById('bank_name').value = profile.bank_name || '';
            document.getElementById('bank_branch').value = profile.bank_branch || '';
            document.getElementById('account_number').value = profile.account_number || '';
            document.getElementById('account_type').value = profile.account_type || '';
        } else {
            // Clear fields if no selection
            document.getElementById('employee_number').value = '';
            document.getElementById('basic_salary').value = '';
            document.getElementById('tax_number').value = '';
            document.getElementById('bank_name').value = '';
            document.getElementById('bank_branch').value = '';
            document.getElementById('account_number').value = '';
            document.getElementById('account_type').value = '';
        }
    });
});
</script>
@endsection
