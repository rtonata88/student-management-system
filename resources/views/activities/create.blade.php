@extends('layouts.hwpl')

@section('content')
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">FRUIT ACTIVITY REPORT</h4> </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <ol class="breadcrumb">
                    <li><a href="/profiles">Fruit Profiles</a></li>
                    <li><a href="/profiles/{{$profile->slug}}">Profile</a></li>
                    <li class="active">New {{$activity_type}}</li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <div class="row">
            <div class="col-md-12 col-lg-12 col-sm-12">
                <div class="white-box">
                    <a href="/profiles/{{$profile->slug}}"> <span class="fa fa-user"></span> Profile Page</a>
                    <h3 class="box-title">{{$activity_title}}</h3>
                    {!! Form::open(array('url' => '/activities', 'method' => 'post', 'class'=> 'form-vertical form-material', 'enctype="multipart/form-data"')) !!}
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">

                                {{Form::label('users[]', 'Representatives')}}
                                {{Form::select('users[]', $users, null, ['class' => 'form-control select2 select2-multiple', 'multiple'])}}
                                <small><span class="help-text">Please include all representatives in attendance apart from yourself [<strong>{{Auth::user()->name}}</strong>]. If you were the only representative, please leave this field blank.</span></small>
                            </div>
                        </div> 
                    </div>
                    @if($activity_type != 'Meeting')
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">

                                {{Form::label('direction', 'Direction')}}
                                {{Form::select('direction', ['Out' => 'Out Going', 'In'=>'In Coming'], null, ['class' => 'form-control'])}}
                            </div>
                        </div> 
                    </div>
                    @endif
                    <div class="row">
                        <div class="col-md-5">
                        <div class="form-group">

                            {{Form::label('profiles[]', 'Who')}}
                            {{Form::hidden('profile_id', $profile->id, ['class' => 'form-control'])}}
                            {{Form::hidden('activity_type', $activity_type, ['class' => 'form-control'])}}
                            {{Form::select('profiles[]', $profiles, null, ['class' => 'form-control select2 select2-multiple', 'multiple'])}}

                            <small><span class="help-text">Please include all other fruits that were in attendance apart from <strong>{{$profile->fullname}} {{$profile->lastname}}. </strong> Leave this field blank if there were no other fruits.</span></small>
                        </div>
                    </div> 
                    </div>
                    <div class="row">
                        <div class="col-md-5">
                      <div class="form-group">
                        {{Form::label('where', 'Where')}}
                        {{Form::text('where', null, ['class' => 'form-control', 'placeholder' => 'Where', 'autocomplete'=>'off', 'required'])}}

                        </div>
                    </div>
                    </div>
                   <div class="row">
                    <div class="col-md-5">
                      <div class="form-group">
                        {{Form::label('when', 'When')}}
                        {{Form::text('when', null, ['class' => 'form-control mydatepicker', 'placeholder' => 'Click here', 'autocomplete'=>'off', 'required'])}}

                        </div>
                    </div>
                    <div class="col-md-5">
                      <div class="form-group">
                        {{Form::label('time', 'Time')}}
                        {{Form::text('time', null, ['class' => 'form-control timepicker', 'placeholder' => 'Click here', 'autocomplete'=>'off', 'required'])}}

                        </div>
                    </div>
                    </div>
            <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    {{Form::label('why', 'Why')}}
                    {{Form::textarea('why', null, ['class' => 'form-control', 'placeholder' => 'Type here'])}}
                </div>
            </div>
        </div>
           <div class="row">
                <div class="col-md-12">
              <div class="form-group">
                {{Form::label('outcome', 'Outcome')}}
                {{Form::textarea('outcome', null, ['class' => 'form-control', 'placeholder' => 'Type here'])}}
            </div>
           </div>
           @if($activity_type == 'Meeting')
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        {{Form::label('photos', 'Photos')}}
                        {{Form::file('photos[]', null, ['class' => 'form-control'])}}
                    </div>
                    <div class="form-group">
                        {{Form::file('photos[]', null, ['class' => 'form-control'])}}
                    </div>
                     <div class="form-group">
                        {{Form::file('photos[]', null, ['class' => 'form-control'])}}
                    </div>
                </div>
            </div>
            @endif

    <button type="submit" class="btn btn-success"><span class="fa fa-check-circle"></span> Save</button>
    <button type="reset" class="btn btn-warning"><span class="fa fa-ban"></span> Reset</button>
    {!! Form::close() !!}
</div>
</div>
</div>
</div>
</div>
</div>
@endsection
