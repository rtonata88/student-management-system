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
            {{Form::label('automatic_charge', 'Automatic charge at registration')}}
            {{Form::select('automatic_charge', ['Yes' => 'Yes', 'No' => 'No'],null, ['class' => 'form-control'])}}
          </div>
        </div>
        <hr>
        <button type="submit" class="btn btn-success"><span class="fa fa-check-circle"></span> Save</button>
        <button type="reset" class="btn"><span class="fa fa-ban"></span> Reset</button>
        {!! Form::close() !!}
      </div>
    </div>
  </div>
  @endsection