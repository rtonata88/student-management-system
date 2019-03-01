@extends('layouts.hwpl')

@section('content')
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">USERS</h4> </div>
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="/setup">Setup</a></li>
                <li class="active">Users</li>
            </ol>
        </div>
        <!-- /.col-lg-12 -->
    </div>
        <div class="col-md-12 col-lg-12 col-sm-12">
            <div class="white-box">
                <a href="/users"> <span class="fa fa-arrow-circle-left"></span> Back</a>
                <h3 class="box-title">{{$user->name}} [update]</h3>
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <p class="text-danger">{{ $error }}</p>
                        @endforeach
                    @endif
                <hr>
                {!! Form::model($user, array('route'=>array('users.update', $user->id), 'class'=>'form-vertical form-material', 'method'=>'PATCH')) !!}
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-5">
                            {{Form::label('username', 'Username')}}
                            {{Form::text('username', null, ['class' => 'form-control', 'disabled', 'readonly'])}}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            {{Form::label('name', 'Fullname')}}
                            {{Form::text('name', null, ['class' => 'form-control'])}}
                        </div>
                    </div>
                    <div class="col-md-5">
                       <div class="form-group">
                            {{Form::label('email', 'Email')}}
                            {{Form::text('email', null, ['class' => 'form-control'])}}
                        </div>
                    </div>

                    <div class="col-md-2">
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
                    <div class="form-group">
                        <div class="col-sm-6">
                          {{Form::label('roles', 'Roles', array('class' => 'control-label'))}}
                          {{Form::select('roles[]', $roles, $user->roles->pluck('id')->toArray() ,array('class' => 'form-control select2', 'multiple', 'required'))}}
                          <div class="help-block text-info">Ctrl + Click on the role - to assign  a user to multiple roles and permissions</div>
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
