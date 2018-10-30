<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>PHILIPS List | Registration Page</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{asset('bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('bower_components/font-awesome/css/font-awesome.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{asset('bower_components/Ionicons/css/ionicons.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('dist/css/AdminLTE.css')}}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{asset('plugins/iCheck/square/blue.css')}}">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition register-page">
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

<!-- jQuery 3 -->
<script src="{{asset('bower_components/jquery/dist/jquery.min.js')}}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{asset('bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<!-- iCheck -->
<script src="{{asset('plugins/iCheck/icheck.min.js')}}"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>
</body>
</html>
