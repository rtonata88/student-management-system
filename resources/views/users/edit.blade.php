@extends('layouts.hwpl')
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
    <div class="col-md-12 col-xs-12">
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

                 {!! Form::model($user, array('route'=>array('users.update', $user->id), 'class'=>'form-vertical form-material', 'method'=>'PATCH')) !!}
                <div class="row">
                    <div class="col-md-6">
                    <div class="form-group">
                        
                            {{Form::label('username', 'Username')}}
                            {{Form::text('username', null, ['class' => 'form-control', 'required', 'placeholder'=>'Type here', 'autocomplete'=>'off'])}}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                    <div class="form-group">
                        
                            {{Form::label('password', 'Password')}}
                            {{Form::password('password', ['class' => 'form-control', 'required', 'placeholder'=>'Password here'])}}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                    <div class="form-group">
                        
                            {{Form::label('password_confirmation', 'Confirm Password')}}
                            {{Form::password('password_confirmation', ['class' => 'form-control' , 'required', 'placeholder'=>'Password again'])}}
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {{Form::label('name', 'Fullname')}}
                            {{Form::text('name', null, ['class' => 'form-control', 'required'])}}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                       <div class="form-group">
                            {{Form::label('email', 'Email')}}
                            {{Form::text('email', null, ['class' => 'form-control', 'required'])}}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {{Form::label('gender', 'Gender')}}
                            {{Form::select('gender', ['Male'=>'Male', 'Female'=>'Female'],null, ['class' => 'form-control select'])}}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            {{Form::label('sector_id', 'Sector')}}
                            {{Form::select('sector_id', $sectors,null, ['class' => 'form-control select'])}}
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            {{Form::label('team_id', 'Team')}}
                            {{Form::select('team_id', $teams,null, ['class' => 'form-control select'])}}
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            {{Form::label('department_id', 'Department')}}
                            {{Form::select('department_id', $departments,null, ['class' => 'form-control select'])}}
                        </div>
                    </div>
                </div>

                 <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            {{Form::label('country_id', 'Counter')}}
                            {{Form::select('country_id', $countries, null, ['class' => 'form-control select'])}}
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            {{Form::label('city_id', 'City')}}
                            {{Form::select('city_id', $cities,null, ['class' => 'form-control select'])}}
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            {{Form::label('language_id', 'Preferred Language')}}
                            {{Form::select('language_id', $languages,null, ['class' => 'form-control select'])}}
                        </div>
                    </div>
                </div>

                <div class="row">
                         
                            <div class="col-md-12">
                                <div class="form-group">
                              {{Form::label('roles', 'Access', array('class' => 'control-label'))}}
                            {{Form::select('roles[]', $roles, $user->roles->pluck('id')->toArray() ,array('class' => 'form-control select2', 'multiple', 'required'))}}
                              <div class="help-block text-info">Ctrl + Click on the role - to assign  a permission to multiple roles</div>
                              </div>
                          </div>
                </div>  
                <button type="reset" class="btn"> Reset</button>
                <button type="submit" class="btn btn-success"> Save</button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection