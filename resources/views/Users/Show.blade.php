@extends('layouts.app')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Access Management</li>
        <li class="breadcrumb-item"><a href="{{route('users.index')}}">Users</a> </li>
        <li class="breadcrumb-item active">Show </li>
        <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection
@section('content')
<div class="row">
    <div class="offset-2 col-sm-12 col-md-8">
        <div class="card">
            <div class="card-header">
                <strong>User</strong>
            </div>
            <div class="card-body">
                @if ($errors->any())
                @foreach ($errors->all() as $error)
                <p class="text-danger">{{ $error }}</p>
                @endforeach
                @endif

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {{Form::label('name', 'Fullname')}}
                            {{Form::text('name', $user->name, ['class' => 'form-control', 'disabled'])}}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {{Form::label('email', 'Email')}}
                            {{Form::text('email', $user->email, ['class' => 'form-control', 'disabled'])}}
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <strong>Assigned Roles & Permissions</strong>
                            <br>
                            <br>
                            <table class="table table-responsive-sm table-bordered table-striped table-sm" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($user->roles as $role)
                                    <tr>
                                        <td><strong>{{$role->display_name}}</strong></td>
                                        <td><strong>{{$role->description}}</strong></td>
                                    </tr>
                                        @foreach($role->permissions as $permission)
                                        <tr>
                                            <td><small>{{$permission->display_name}}</small></td>
                                            <td><small>{{$permission->description}}</small></td>
                                        </tr>
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <a href="/users" class="btn"> Back</a>
            </div>
        </div>
    </div>
</div>
@endsection