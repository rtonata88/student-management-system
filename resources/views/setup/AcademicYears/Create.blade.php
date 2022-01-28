@extends('layouts.app')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Setup</li>
        <li class="breadcrumb-item"> <a href="/registration-boards"> Academic Years</a></li>
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
                <strong>Academic Years</strong> | <a href="/academic-year"> Back</a>
            </div>
            {!! Form::open(array('url' => '/academic-year', 'method' => 'post', 'class'=> 'form-horizontal')) !!}
            <div class="card-body">
                <div class="col-md-12">
                    <div class="col-md-12">
                        <div class="form-group">
                            {{Form::label('academic_year', 'Academic Year')}}
                            {{Form::number('academic_year', null, ['class' => 'form-control', 'required'])}}
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            {{Form::label('status', 'Status')}}
                            {{Form::text('status', 0, ['class' => 'form-control', 'readonly'])}}
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