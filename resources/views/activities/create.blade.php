@extends('layouts.hwpl')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item">Management</li>
    <li class="breadcrumb-item"><a href="/profiles">Profiles </a></li>
    <li class="breadcrumb-item active">{{$activity_title}}</li>
    <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection
@section('content')
<div class="row">
    <div class="col-md-12 col-xs-12">
        <div class="card">
            <div class="card-header">
                <strong>{{$activity_title}}</strong> | 
                    <a href="/profiles/{{$profile->slug}}"> 
                      <svg class="c-icon c-icon-lg">
                        <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-arrow-left')}}"></use>
                    </svg>
                     Back</a>
            </div>
            <div class="card-body">
                {!! Form::open(array('url' => '/activities', 'method' => 'post', 'class'=> 'form-vertical form-material', 'enctype="multipart/form-data"')) !!}
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                {{Form::label('users[]', 'Staff')}}
                                {{Form::select('users[]', $users, null, ['class' => 'form-control select2 select2-multiple', 'multiple'])}}
                                <small><span class="help-text">Please include all staff associated with the {{$activity_type}} apart from yourself [<strong>{{Auth::user()->name}}</strong>]. If you were the only representative, please leave this field blank.</span></small>
                            </div>
                        </div>
                    </div>

                    @if($activity_type != 'Meeting')
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                {{Form::label('direction', 'Direction')}}
                                {{Form::select('direction', ['Out' => 'Out Going', 'In'=>'In Coming'], null, ['class' => 'form-control', 'placeholder'=>'Select'])}}
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                {{Form::label('meeting_type', 'Type')}}
                                {{Form::select('meeting_type', ['InPerson' => 'In Person', 'Video'=>'Video', 'Telephonic' => 'Telephonic'], null, ['class' => 'form-control', 'placeholder'=>'Select'])}}
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                {{Form::label('profiles[]', 'Who')}}
                                {{Form::hidden('profile_id', $profile->id, ['class' => 'form-control'])}}
                                {{Form::hidden('activity_type', $activity_type, ['class' => 'form-control'])}}
                                {{Form::select('profiles[]', $profiles, null, ['class' => 'form-control select2 select2-multiple', 'multiple'])}}

                                <small><span class="help-text">Please include all other fruits that were in attendance apart from <strong>{{$profile->fullname}} {{$profile->lastname}}. </strong> Leave this field blank if there were no other fruits.</span></small>
                            </div>
                        </div>
                    </div>
                    @if($activity_type == 'Meeting')
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                {{Form::label('where', 'Where')}}
                                {{Form::text('where', null, ['class' => 'form-control', 'placeholder' => 'Where', 'autocomplete'=>'off', 'required'])}}
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                {{Form::label('when', 'When')}}
                                {{Form::date('when', null, ['class' => 'form-control mydatepicker', 'placeholder' => 'Click here', 'autocomplete'=>'off', 'required'])}}
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                {{Form::label('time', 'Time')}}
                                {{Form::time('time', null, ['class' => 'form-control timepicker', 'placeholder' => 'Click here', 'autocomplete'=>'off', 'required'])}}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                {{Form::label('why', 'Why')}}
                                {{Form::textarea('why', null, ['class' => 'form-control', 'placeholder' => 'Type here'])}}
                            </div>

                            <div class="form-group">
                                {{Form::label('outcome', 'Outcome')}}
                                {{Form::textarea('outcome', null, ['class' => 'form-control', 'placeholder' => 'Type here'])}}
                            </div>
                        </div>
                    </div>

                     @if($activity_type == 'Meeting')
                <div class="row">
                    <div class="col-md-12">
                        {{Form::label('photos', 'Select meeting photos')}}
                        <div class="form-group">
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
                <div class="row">
                    <button type="submit" class="btn btn-success"><span class="fa fa-check-circle"></span> Save</button>
                    <button type="reset" class="btn btn-warning"><span class="fa fa-ban"></span> Reset</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
