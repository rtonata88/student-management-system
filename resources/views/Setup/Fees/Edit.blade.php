@extends('layouts.app')
@section('breadcrumb')
<div class="c-subheader px-3">
  <!-- Breadcrumb-->
  <ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item">Setup</li>
    <li class="breadcrumb-item"> <a href="/specialties"> Fees </a></li>
    <li class="breadcrumb-item active">Edit </li>
    <!-- Breadcrumb Menu-->
  </ol>
</div>
@endsection
@section('content')
<div class="offset-3 row">
  <div class="col-md-8 col-sm-12">
    <div class="card">
      <div class="card-header">
        <strong>Fees</strong> | <a href="/fees"> Back</a>
      </div>
      {!! Form::model($fee, array('route'=>array('fees.show', $fee->id), 'class'=>'form-horizontal', 'method'=>'PATCH')) !!}
      <div class="card-body">
        <div class="col-md-12">
          <div class="form-group">
            {{Form::label('fee_description', 'Fee description')}}
            {{Form::text('fee_description', null, ['class' => 'form-control'])}}
          </div>
        </div>
        <div class="col-md-12">
          <div class="form-group">
            {{Form::label('amount', 'Amount')}}
            {{Form::text('amount', null, ['class' => 'form-control'])}}
          </div>
        </div>
        <div class="col-md-12">
          <div class="form-group">
            {{Form::label('automatic_charge', 'Mandatory fee')}}
            {{Form::select('automatic_charge', ['Yes' => 'Yes', 'No' => 'No'],null, ['class' => 'form-control'])}}
          </div>
        </div>
        <div class="col-md-12">
          <div class="form-group">
            {{Form::label('charge_type', 'How should this fee be charged?')}}
            {{Form::select('charge_type', ['Once-off' => 'Once off', 'Recurring' => 'Recurring'],null, ['class' => 'form-control'])}}
          </div>
        </div>
        <hr>
        @permission('edit-fees')
        <button type="submit" class="btn" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;"><i class="fas fa-save"></i> Save</button>
        @endpermission
        <button type="reset" class="btn" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;"><i class="fas fa-undo"></i> Reset</button>
        {!! Form::close() !!}
      </div>
    </div>
  </div>
  @endsection