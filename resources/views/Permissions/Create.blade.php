@extends('layouts.app')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Access Management</li>
        <li class="breadcrumb-item"><a href="{{route('roles.index')}}">Permissions</a> </li>
        <li class="breadcrumb-item active">Create </li>
        <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection
@section('content')
<div class="row">
    <div class="offset-3 col-sm-12 col-md-6">
        <div class="card">
            <div class="card-header">
                <strong>Permissions</strong>
            </div>
            <div class="card-body">
                @if ($errors->any())
                @foreach ($errors->all() as $error)
                <p class="text-danger">{{ $error }}</p>
                @endforeach
                @endif

                {!! Form::open(array('route'=>array('permissions.store'), 'class'=>'form-vertical form-material', 'method'=>'post')) !!}
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {{Form::label('name', 'Permission Name')}}
                            {{Form::text('name', null, ['class' => 'form-control', 'required'])}}
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            {{Form::label('display_name', 'Display Name')}}
                            {{Form::text('display_name', null, ['class' => 'form-control', 'required'])}}
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            {{Form::label('description', 'Description')}}
                            {{Form::text('description', null, ['class' => 'form-control', 'required'])}}
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-success"> Save</button>
                <a href="/permissions" class="btn"> Cancel</a>

                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection