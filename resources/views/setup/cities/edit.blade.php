@extends('layouts.hwpl')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item">Setup</li>
    <li class="breadcrumb-item"> <a href="/cities"> Cities </a></li>
    <li class="breadcrumb-item active">Edit </li>
    <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection
@section('content')
<div class="row">
    <div class="col-md-12 col-xs-12">
        <div class="card">
            <div class="card-header">
                <strong>Cities</strong> | <a href="/cities"> Back</a>
             
            </div>
          {!! Form::model($city, array('route'=>array('cities.show', $city->id), 'class'=>'form-horizontal', 'method'=>'PATCH')) !!}
            <div class="card-body">
              <div class="col-md-5">
                  <div class="form-group">
                            {{Form::label('language_id', 'Language')}}
                            {{Form::select('language_id', $languages, $city->language_id, ['class' => 'form-control select'])}}
                          </div>
                        </div>
                      <div class="col-md-5"> 
                         <div class="form-group">
                            {{Form::label('name', 'Name')}}
                            {{Form::text('name', null, ['class' => 'form-control'])}}
                          </div>
                        </div>
                        <div class="col-md-5">
                        <div class="form-group">
                            {{Form::label('country_id', 'Country')}}
                            {{Form::select('country_id', $countries, $city->country_id, ['class' => 'form-control select'])}}
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

