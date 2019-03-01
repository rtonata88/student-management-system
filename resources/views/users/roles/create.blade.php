@extends('layouts.hwpl')

@section('content')
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">ROLES</h4> </div>
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="/setup">Setup</a></li>
                <li class="active">Roles</li>
            </ol>
        </div>
        <!-- /.col-lg-12 -->
    </div>
        <div class="col-md-12 col-lg-12 col-sm-12">
            <div class="white-box">
                <a href="/roles"> <span class="fa fa-arrow-circle-left"></span> Back</a>
                <h3 class="box-title">New Role</h3>
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <p class="text-danger">{{ $error }}</p>
                        @endforeach
                    @endif
                <hr>
                {!! Form::open(array('route'=>array('roles.store'), 'class'=>'form-vertical form-material', 'method'=>'post')) !!}
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-5">
                            {{Form::label('name', 'Role Name')}}
                            {{Form::text('name', null, ['class' => 'form-control', 'required', 'placeholder'=>'Type here', 'autocomplete'=>'off'])}}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-5">
                            {{Form::label('display_name', 'Display Name')}}
                            {{Form::text('display_name', null, ['class' => 'form-control', 'required', 'placeholder'=>'Type here', 'autocomplete'=>'off'])}}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            {{Form::label('description', 'Description')}}
                            {{Form::text('description', null, ['class' => 'form-control', 'required'])}}
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-success"><span class="fa fa-check-circle"></span> Save</button>
                <button type="reset" class="btn btn-warning"><span class="fa fa-ban"></span> Reset</button>
                {!! Form::close() !!}
            </div>
        </div>
</div>
@endsection
