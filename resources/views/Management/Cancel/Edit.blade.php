@extends('layouts.app')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Management</li>
        <li class="breadcrumb-item active"><a href="/enrolment-adjustment">Subject Cancellations</a></li>
        <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection
@section('content')
{!! Form::open(array('route' => array('cancellation.store', $subject->id), 'method' => 'post')) !!}
<div class="row">
    <div class="offset-2 col-md-9">
        <div class="card">
            <div class="card-header">
                <strong> Academic and Subject registration </strong>
            </div>
            <div class="card-body">
                @if ($errors->any())
                <ul class="text-danger">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
                @endif
                @if(Session::has('message'))
                <div class="alert alert-danger">
                    {{Session::get('message')}}
                </div>
                @endif
                <div class="form-group">
                    {{Form::label('academic_year', 'Academic Year')}}
                    {{Form::text('academic_year', $academic_year, ['class' => 'form-control', 'readonly', 'required'])}}
                </div>
                <div class="form-group">
                    {{Form::label('subject', 'Subject')}}
                    {{Form::text('subject', $subject->subject->subject_name, ['class' => 'form-control', 'readonly', 'required'])}}
                </div>

                <div class="form-group">
                    {{Form::label('registration_date', 'Registration Date')}}
                    {{Form::text('registration_date', $subject->registration_date, ['class' => 'form-control', 'readonly', 'required'])}}
                </div>

                <div class="form-group">
                    {{Form::label('cancellation_date', 'Cancellation date')}}
                    {{Form::date('cancellation_date', $subject->cancellation_date ?? old('cancellation_date'), ['class' => 'form-control', 'required'])}}
                    <input type="hidden" value="{{$subject->student_id}}" name="student_id" />
                    <input type="hidden" value="{{$subject->id}}" name="module_registration_id" />
                    <input type="hidden" value="{{$subject->module_id}}" name="module_id" />
                    <input type="hidden" value="{{$academic_year}}" name="academic_year" />
                    <input type="hidden" value="{{$subject->amount}}" name="amount" />
                </div>

                <div class="form-group">
                    {{Form::label('cancelation_reason', 'Cancellation Reason')}}
                    {{Form::textarea('cancelation_reason', $subject->cancellation_reason, ['class' => 'form-control', 'placeholder' => 'Cancellation Reason'])}}
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-sm btn-success">Confirm cancellation</button>
                <a href="/enrolment-adjustment/show-form/{{$subject->student_id}}">Cancel</a>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}
</div>
@endsection