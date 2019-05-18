@extends('layouts.hwpl')

@section('content')
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">MAINTAINER ASSIGNMENTS</h4> </div>
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="/profiles">Profiles</a></li>
                <li class="active">Maintainer Assignments</li>
            </ol>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <div class="row">
        <div class="white-box">
            @if(Session::has('message'))
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> 
                    {{ Session::get('message') }}
                </div>                            
                @endif
                
            {!! Form::open(array('route'=>array('maintainer-assignment.store'), 'class'=> 'form-vertical form-material', 'enctype="multipart/form-data"', 'method'=>'POST')) !!}
            <div class="row">
                <div class="form-group">

                    {{Form::label('countries[]', 'COUNTRIES FILTER')}}
                    {{Form::select('countries[]', $countries, null, ['class' => 'form-control select2 select2-multiple', 'multiple'])}}
                </div>
            </div>


            <div class="row">
                <div class="form-group">

                    {{Form::label('profiles[]', 'PROFILES FILTER')}}
                    {{Form::select('profiles[]', $profiles, null, ['class' => 'form-control select2 select2-multiple', 'multiple'])}}
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        {{Form::label('maintainer_id', 'SELECT MAINTAINER')}}
                        {{Form::select('maintainer_id', $maintainers, null, ['class' => 'form-control select2'])}}

                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-success"><span class="fa fa-check-circle"></span> Save</button>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection