@extends('layouts.login')

@section('content')
<div class="new-login-box">
                <div class="white-box">
                    <h3 class="box-title m-b-0">Sign In</h3>
                    <small>Enter your details below</small>

                  <form action="{{ route('login') }}" method="post" class="form-horizontal new-lg-form" id="loginform">
                        {{ csrf_field() }}
                    <div class="form-group  m-t-20 has-feedback">
                      <div class="col-xs-12">
                        <label>Username</label>
                        <input class="form-control" type="text" required="" name="username" placeholder="Username">
                        @if ($errors->has('username'))
                            <span class="help-block text-danger">
                                <strong>{{ $errors->first('username') }}</strong>
                            </span>
                        @endif
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-xs-12">
                        <label>Password</label>
                        <input class="form-control" type="password" required="" name="password" placeholder="Password">
                        @if ($errors->has('password'))
                            <span class="help-block text-danger ">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-md-12">
                        <div class="checkbox checkbox-info pull-left p-t-0">
                          <input id="checkbox-signup" type="checkbox">
                          <label for="checkbox-signup"> Remember me </label>
                        </div>
                        <a href="javascript:void(0)" id="to-recover" class="text-dark pull-right"><i class="fa fa-lock m-r-5"></i> Forgot password?</a> </div>
                    </div>
                    <div class="form-group text-center m-t-20">
                      <div class="col-xs-12">
                        <button class="btn btn-info btn-lg btn-block btn-rounded text-uppercase waves-effect waves-light" type="submit">Log In</button>
                      </div>
                    </div>
                    
                    <div class="form-group m-b-0">
                      <div class="col-sm-12 text-center">
                        <p>Don't have an access? <a href="/register" class="text-primary m-l-5"><b>Request for Access</b></a></p>
                      </div>
                    </div>
                  </form>
                  <form class="form-horizontal" id="recoverform" action="index.html">
                    <div class="form-group ">
                      <div class="col-xs-12">
                        <h3>Recover Password</h3>
                        <p class="text-muted">Enter your Email and instructions will be sent to you! </p>
                      </div>
                    </div>
                    <div class="form-group ">
                      <div class="col-xs-12">
                        <input class="form-control" type="text" required="" placeholder="Email">
                      </div>
                    </div>
                    <div class="form-group text-center m-t-20">
                      <div class="col-xs-12">
                        <button class="btn btn-primary btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Reset</button>
                      </div>
                    </div>
                  </form>
                </div>
      </div> 

  @endsection           