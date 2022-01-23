@extends('layouts.app')
@section('breadcrumb')
<div class="c-subheader px-3">
  <!-- Breadcrumb-->
  <ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item">Setup</li>
    <li class="breadcrumb-item"> <a href="/registration-boards"> Centers </a></li>
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
        <strong>Centers</strong> | <a href="/centers"> Back</a>
      </div>
      {!! Form::model($center, array('route'=>array('centers.show', $center->id), 'class'=>'form-horizontal', 'method'=>'PATCH')) !!}
      <div class="card-body">
        <div class="col-md-12">
          <div class="col-md-12">
            <div class="form-group">
              {{Form::label('center_name', 'Center name')}}
              {{Form::text('center_name', null, ['class' => 'form-control', 'required'])}}
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              {{Form::label('location', 'Location')}}
              {{Form::text('location', null, ['class' => 'form-control'])}}
            </div>
          </div>
          <hr>
          <button type="submit" class="btn btn-success"><span class="fa fa-check-circle"></span> Save</button>
          <a href="/centers" class="btn"><span class="fa fa-ban"></span> Cancel</a>
        </div>
      </div>
      {!! Form::close() !!}
    </div>
    @endsection