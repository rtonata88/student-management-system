@extends('layouts.hwpl')

@section('content')
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">GUEST / <small>Check In</small></h4> </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <ol class="breadcrumb">
                   <li class="active">Check In</li>
               </ol>
           </div>
           <!-- /.col-lg-12 -->
       </div>
       <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12">
         <div class="white-box">
            <div class="card-body">
                 @if(Session::has('message'))
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> 
                    {{ Session::get('message') }}
                </div>                            
                @endif
              <form action="/event-check-in/{{$event->slug}}" method="post" class="form-material m-t-40" id="events-form">
                 <input type="hidden" name="_token" value="{{ csrf_token() }}">
                     <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                {{Form::label('guest_id', 'SELECT GUEST:')}} <span class="text-danger">*</span>
                                {{Form::select('guest_id', $guests, null, ['class' => 'form-control input-lg select2', 'placeholder' => 'Click here', 'autocomplete'=>'off'])}}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <p class="text-center m-t-40">
                            <strong>-OR CAPTURE GUEST DETAILS BELOW-</strong>
                        </p>
                    </div>
                    <div class="row m-t-40">
                        <div class="col-md-6">
                            <div class="form-group">
                                {{Form::label('fullname', 'FULLNAME:')}} <span class="text-danger">*</span>
                                {{Form::text('fullname', null, ['class' => 'form-control input-lg', 'placeholder' => 'Type here', 'autocomplete'=>'off'])}}
                                {{Form::hidden('profile_id', null, ['class' => 'form-control input-lg', 'placeholder' => 'Type here', 'id'=>'profile_id'])}}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{Form::label('lastname', 'LASTNAME:')}} <span class="text-danger">*</span>
                                {{Form::text('lastname', null, ['class' => 'form-control input-lg', 'placeholder' => 'Type here', 'autocomplete'=>'off'])}}
                            </div>
                        </div>
                    </div>
                    <div class="row m-t-40">
                        <div class="col-md-4">
                            <div class="form-group">
                                {{Form::label('email', 'EMAIL:')}} <span class="text-danger">*</span>
                                {{Form::text('email', null, ['class' => 'form-control input-lg', 'placeholder' => 'Type here', 'autocomplete'=>'off'])}}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                {{Form::label('mobile_no', 'MOBILE:')}} <span class="text-danger">*</span>
                                {{Form::text('mobile_no', null, ['class' => 'form-control input-lg', 'placeholder' => 'Type here', 'autocomplete'=>'off'])}}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                {{Form::label('work_number', 'TELEPHONE:')}} <span class="text-danger">*</span>
                                {{Form::text('work_number', null, ['class' => 'form-control input-lg', 'placeholder' => 'Type here', 'autocomplete'=>'off'])}}
                            </div>
                        </div>
                    </div>
                    <div class="row m-t-40">
                        <div class="col-md-12">
                            <div class="form-group">
                                {{Form::label('organization', 'ORGANIZATION:')}} <span class="text-danger">*</span>
                                {{Form::text('organization', null, ['class' => 'form-control input-lg', 'placeholder' => 'Type here', 'autocomplete'=>'off'])}}
                            </div>
                        </div>
                    </div>
                    <div class="row m-t-40">
                        <div class="col-md-12">
                            <div class="pull-right">
                                <button type="reset" class="btn btn-default btn-lg">
                                    RESET FORM
                                </button>
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <span class="fa fa-check"></span> CHECK IN
                                </button>
                            </div>
                            
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
</div>
@endsection
