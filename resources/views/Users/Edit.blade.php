@extends('layouts.app')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Access Management</li>
        <li class="breadcrumb-item"><a href="{{route('users.index')}}">Users</a> </li>
        <li class="breadcrumb-item active">Edit </li>
        <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection
@section('content')
<div class="row">
    <div class="offset-2 col-sm-12 col-md-8">
        <div class="card">
            <div class="card-header">
                <strong>Users</strong>
            </div>
            <div class="card-body">
                @if ($errors->any())
                @foreach ($errors->all() as $error)
                <p class="text-danger">{{ $error }}</p>
                @endforeach
                @endif

                {!! Form::model($user, array('route'=>array('users.update', $user->id), 'autocomplete'=>"none", 'class'=>'form-vertical form-material', 'method'=>'PATCH')) !!}

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {{Form::label('name', 'Full Names')}}
                            {{Form::text('name', $user->name, ['class' => 'form-control', 'required'])}}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {{Form::label('email', 'Email')}}
                            {{Form::text('email', $user->email, ['class' => 'form-control', 'required'])}}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {{Form::label('password', 'Password')}}
                            {{Form::password('password', ['class' => 'form-control', 'autocomplete'=>"none"])}}
                            <span class="text-help text-info">
                                The password field can be left blank. Only fill it in if you wish to change/update the user's password.
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {{Form::label('password_confirmation', 'Confirm Password')}}
                            {{Form::password('password_confirmation', ['class' => 'form-control'])}}
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
                                        <th>Display Name</th>
                                        <th>Description</th>
                                        <th class="text-center">Tick to Assign</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($roles as $role)
                                    <tr>
                                        <td>{{$role->display_name}}</td>
                                        <td>{{$role->description}}</td>
                                        <td class="text-center">
                                            <input type="checkbox" value="{{$role->id}}" @if(in_array($role->id, $assigned_roles)) checked @endif name="roles[]">
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-success"> Save</button>
                <a href="/users" class="btn"> Cancel</a>

                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection