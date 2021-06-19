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
                @if(Session::has('message'))
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> 
                    {!! Session::get('message') !!}
                </div>                            
                @endif
                {!! Form::model($activity, array('route'=>array('activities.edit', $activity->id, $profile->slug), 'class'=>'form-horizontal form-material', 'method'=>'POST', 'enctype="multipart/form-data"')) !!}

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
            </div>
            @if($activity_type == 'Meeting')
            <div class="row">
                <a href=""> <span class="fa fa-edit"></span> Photo Management</a>
             <div id="gallery">
                <div id="gallery-content">
                    <div id="gallery-content-center">
                        @foreach($profile->photos as $photo)
                        <a href="{{ asset('storage/'.$photo->path) }}" data-toggle="lightbox" data-effect="mfp-zoom-in" data-gallery="multiimages" data-title="{{$profile->fullname}} {{$profile->lastname}}"><img src="{{ asset('storage/'.$photo->path) }}" alt="gallery" class="all studio" /></a>
                        
                        @endforeach
                    </div>
                </div>
             </div>
             </div>
             <hr>
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

@endsection
