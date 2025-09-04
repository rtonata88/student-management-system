@extends('layouts.app')
@section('breadcrumb')
<div class="c-subheader px-3">
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Human Resources</li>
        <li class="breadcrumb-item"><a href="{{route('payroll.index')}}">Payroll</a></li>
        <li class="breadcrumb-item"><a href="{{route('payroll.periods')}}">Payroll Periods</a></li>
        <li class="breadcrumb-item active">Create Period</li>
    </ol>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Create Payroll Period</h5>
                <small class="text-muted">Define a new payroll processing period</small>
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

                {!! Form::open(['route' => 'payroll.periods.store', 'class' => 'form-horizontal']) !!}

                <div class="form-group">
                    {{Form::label('period_name', 'Period Name')}}
                    {{Form::text('period_name', null, ['class' => 'form-control', 'required', 'placeholder' => 'September 2025 Payroll'])}}
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {{Form::label('start_date', 'Start Date')}}
                            {{Form::date('start_date', null, ['class' => 'form-control', 'required'])}}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {{Form::label('end_date', 'End Date')}}
                            {{Form::date('end_date', null, ['class' => 'form-control', 'required'])}}
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    {{Form::label('pay_date', 'Pay Date')}}
                    {{Form::date('pay_date', null, ['class' => 'form-control', 'required'])}}
                    <small class="form-text text-muted">The date when employees will be paid</small>
                </div>

                <div class="form-group">
                    {{Form::label('description', 'Description (Optional)')}}
                    {{Form::textarea('description', null, ['class' => 'form-control', 'rows' => 3, 'placeholder' => 'Additional notes about this payroll period...'])}}
                </div>

                <div class="form-group mt-4">
                    <button type="submit" class="btn" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem; margin-right: 8px;">
                        <i class="fas fa-save"></i> Create Period
                    </button>
                    <a href="{{route('payroll.periods')}}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                </div>

                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
