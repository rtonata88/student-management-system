@extends('layouts.hwpl')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item">Management</li>
    <li class="breadcrumb-item active"><a href="/maintainer-assignment">Staff Assignment </a></li>
    <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 col-xs-12">
        <div class="card">
            <div class="card-header">
            <strong>Staff Assignment </strong> | 
                <a href="/maintainer-assignment">
                <svg class="c-icon">
                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-arrow-circle-left')}}"></use>
                </svg>
                Back</a>
            </div>
            <div class="card-body">
                    @if(Session::has('message'))
                        <div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            {{ Session::get('message') }}
                        </div>
                        @endif

                    {!! Form::open(array('route'=>array('maintainer-assignment.store'), 'class'=> 'form-vertical form-material', 'enctype="multipart/form-data"', 'method'=>'POST')) !!}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                            {{Form::label('countries[]', 'Select countries')}}
                            {{Form::select('countries[]', $countries, null, ['class' => 'form-control select2 select2-multiple', 'multiple', 'style'=>'height:200px'])}}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                            {{Form::label('profiles[]', 'Select profiles')}}
                            {{Form::select('profiles[]', $profiles, null, ['class' => 'form-control select2 select2-multiple', 'multiple', 'style'=>'height:200px'])}}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                {{Form::label('maintainer_id', 'Select staff')}}
                                {{Form::select('maintainer_id', $maintainers, null, ['class' => 'form-control select2'])}}

                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success"><span class="fa fa-check-circle"></span> Save</button>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
