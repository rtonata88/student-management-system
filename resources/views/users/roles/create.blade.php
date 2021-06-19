@extends('layouts.hwpl')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item">Access Management</li>
    <li class="breadcrumb-item"><a href="{{route('roles.index')}}"> Roles </a></li>
    <li class="breadcrumb-item active">Create</li>
    <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection
@section('content')
<div class="row">
    <div class="col-md-12 col-xs-12">
        <div class="card">
            <div class="card-header">
                <strong>Roles</strong>  | <a href="/roles"> Back</a>
            </div>
            <div class="card-body">
                 @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <p class="text-danger">{{ $error }}</p>
                    @endforeach
                @endif
                {!! Form::open(array('route'=>array('roles.store'), 'class'=>'form-vertical form-material', 'method'=>'post')) !!}
                <div class="row">
                    <div class="col-md-5">
                    <div class="form-group">
                        
                            {{Form::label('name', 'Role Name')}}
                            {{Form::text('name', null, ['class' => 'form-control', 'required', 'placeholder'=>'Type here', 'autocomplete'=>'off'])}}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5">
                    <div class="form-group">
                        
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

                <button type="reset" class="btn"><span class="fa fa-ban"></span> Reset</button>
                <button type="submit" class="btn btn-success"><span class="fa fa-check-circle"></span> Save</button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection

