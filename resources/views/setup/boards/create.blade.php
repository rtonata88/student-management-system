@extends('layouts.app')
@section('breadcrumb')
<div class="c-subheader px-3">
  <!-- Breadcrumb-->
  <ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item">Setup</li>
    <li class="breadcrumb-item"> <a href="/registration-boards"> Registration Boards </a></li>
    <li class="breadcrumb-item active">Create </li>
    <!-- Breadcrumb Menu-->
  </ol>
</div>
@endsection
@section('content')
<div class="offset-3 row">
  <div class="col-md-8 col-sm-12">
    <div class="card">
      <div class="card-header">
        <strong>Registration Boards</strong> | <a href="/registration-boards"> Back</a>
      </div>
      {!! Form::open(array('url' => '/registration-boards', 'method' => 'post', 'class'=> 'form-horizontal')) !!}
      <div class="card-body">
        <div class="col-md-12">
          <div class="col-md-12">
            <div class="form-group">
              {{Form::label('name', 'Board name')}}
              {{Form::text('name', null, ['class' => 'form-control', 'required'])}}
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              {{Form::label('country_id', 'Country')}}
              {{Form::select('country_id', $countries, null, ['class' => 'form-control select'])}}
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              {{Form::label('contact_number', 'Contact number')}}
              {{Form::text('contact_number', null, ['class' => 'form-control'])}}
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              {{Form::label('address', 'Address')}}
              {{Form::text('address', null, ['class' => 'form-control'])}}
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