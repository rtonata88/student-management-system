@extends('layouts.app')
@section('breadcrumb')
<div class="c-subheader px-3">
  <!-- Breadcrumb-->
  <ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item">Setup</li>
    <li class="breadcrumb-item"> <a href="/registration-boards"> Centers </a></li>
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
        <strong>Centers</strong> | <a href="/centers"> Back</a>
      </div>
      {!! Form::open(array('url' => '/centers', 'method' => 'post', 'class'=> 'form-horizontal')) !!}
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
          @permission('add-centers')
          <button type="submit" class="btn" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;"><i class="fas fa-save"></i> Save</button>
          @endpermission
          <a href="/centers" class="btn" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;"><i class="fas fa-times"></i> Cancel</a>
        </div>
      </div>
      {!! Form::close() !!}
    </div>
    @endsection