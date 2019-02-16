@extends('layouts.register')

@section('content')
<div class="register-box">
  <div class="register-logo">
    <a href="#"><b>PHILIPS</b>List</a>
  </div>

  <div class="register-box-body">
    <h3 class="content-max-width">Request for access</h3>
    <hr>
      {!! Form::open(['route' => ['register']]) !!}
      <div class="row">
        <div class="col-md-6">
          <div class="form-group has-feedback">
            {!! Form::label('username', 'Username') !!}
            {!! Form::text('username', old('username'), ['class' => 'form-control']) !!}
            @if ($errors->has('username'))
                <span class="help-block text-red">
                    <strong>{{ $errors->first('username') }}</strong>
                </span>
            @endif
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group has-feedback">
            {!! Form::label('name', 'Full Name') !!}
            {!! Form::text('name', old('name'), ['class' => 'form-control']) !!}
            @if ($errors->has('name'))
                <span class="help-block text-red">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
          </div>
        </div>
      </div>
            <div class="row">
        <div class="col-md-6">
          <div class="form-group has-feedback">
            {!! Form::label('password', 'Password') !!}
            <input type="password" name="password" class="form-control">
            @if ($errors->has('password'))
                <span class="help-block text-red">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group has-feedback">
            {!! Form::label('password_confirmation', 'Confirm Password') !!}
             <input type="password" name="password_confirmation" class="form-control">
          </div>
        </div>
      </div>
        <div class="row">
        <div class="col-md-6">
          <div class="form-group has-feedback">
            {!! Form::label('email', 'Email') !!}
            {!! Form::email('email', old('email'), ['class' => 'form-control']) !!}
            @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group has-feedback">
            {!! Form::label('gender_id', 'Gender') !!}
            {!! Form::select('gender_id', $gender, old('gender'), ['class' => 'form-control']); !!}
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-4">
          <div class="form-group has-feedback">
            {!! Form::label('sector_id', 'Sector') !!}
            {!! Form::select('sector_id', $sectors, old('sector_id'), ['class' => 'form-control']); !!}
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group has-feedback">
            {!! Form::label('team_id', 'Team') !!}
            {!! Form::select('team_id', $teams, old('team_id'), ['class' => 'form-control']); !!}
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group has-feedback">
            {!! Form::label('department_id', 'Department') !!}
            {!! Form::select('department_id', $departments, old('department_id'), ['class' => 'form-control']); !!}
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-4">
          <div class="form-group has-feedback">
            {!! Form::label('prefered_language', 'Prefered Language') !!}
            {!! Form::select('prefered_language', $languages, old('prefered_language'), ['class' => 'form-control']); !!}
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group has-feedback">
            {!! Form::label('country_id', 'Country') !!}
            {!! Form::select('country_id', $countries, old('country_id'), ['class' => 'form-control']); !!}
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group has-feedback">
            {!! Form::label('city_id', 'City') !!}
            {!! Form::select('city_id', $cities, old('city_id'), ['class' => 'form-control']); !!}
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <input type="checkbox"> I agree to the <a href="#">terms</a>
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Register</button>
        </div>
        <!-- /.col -->
      </div>
    {!! Form::close() !!}
    <hr>
    <a href="{{ url('/login') }}" class="text-center">I already have access</a>
  </div>
  <!-- /.form-box -->
</div>
<!-- /.register-box -->

@endsection
