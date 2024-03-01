@extends('layouts.app')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Access Management</li>
        <li class="breadcrumb-item"><a href="{{route('roles.index')}}">Roles</a> </li>
        <li class="breadcrumb-item active">Show </li>
        <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection
@section('content')
<div class="row">
    <div class="offset-1 col-sm-12 col-md-10">
        <div class="card">
            <div class="card-header">
                <strong>Roles</strong>
            </div>
            <div class="card-body">
                @if ($errors->any())
                @foreach ($errors->all() as $error)
                <p class="text-danger">{{ $error }}</p>
                @endforeach
                @endif

                {!! Form::model($role, array('route'=>array('roles.update', $role->id), 'autocomplete'=>"none", 'class'=>'form-vertical form-material', 'method'=>'PATCH')) !!}
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {{Form::label('name', 'Role Name')}}
                            {{Form::text('name', $role->name, ['class' => 'form-control', 'disabled'])}}
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            {{Form::label('display_name', 'Display Name')}}
                            {{Form::text('display_name', $role->display_name, ['class' => 'form-control', 'disabled'])}}
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            {{Form::label('description', 'Description')}}
                            {{Form::text('description', $role->description, ['class' => 'form-control', 'disabled'])}}
                        </div>
                    </div>
                </div>

                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {{Form::label('roles', 'Access Levels', array('class' => 'control-label'))}}
                            <table class="table table-responsive-sm table-bordered table-striped table-sm" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Display Name</th>
                                        <th>Description</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($permissions as $permission)
                                    <tr>
                                        <td>{{$permission->name}}</td>
                                        <td>{{$permission->display_name}}</td>
                                        <td>{{$permission->description}}</td>
                                        <td class="text-center">
                                            <input type="checkbox" value="{{$permission->id}}" @if(in_array($permission->id, $assigned_permissions)) checked @endif name="permissions[]">
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-success"> Save</button>
                <a href="/roles" class="btn"> Back</a>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection