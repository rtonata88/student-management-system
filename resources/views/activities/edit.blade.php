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
    <div class="col-md-2 col-xs-12"></div>
    <div class="col-md-8 col-xs-12">
        <div class="card">
            <div class="card-header">
                <strong>{{$activity_title}} for {{$profile->fullname}} {{$profile->lastname}}</strong> | 
                    <a href="/profiles/{{$profile->slug}}"> 
                     Cancel</a>
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
                        <div class="col-md-10 col-sm-12">
                            <div class="form-group">
                            <strong>{{Form::label('users[]', 'Staff')}}</strong>
                            {{Form::select('users[]', $users, null, ['class' => 'form-control select2', 'multiple'])}}
                            <small><span class="help-text text-info">Please include all staff associated with the {{$activity_type}} apart from yourself [<strong>{{Auth::user()->name}}</strong>]. If you were the only representative, please leave this field blank.</span></small>
                        </div>
                    </div> 
                </div>
                @if($activity_type != 'Meeting')
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <strong>{{Form::label('direction', 'Direction')}}</strong>
                                {{Form::select('direction', ['Out' => 'Out Going', 'In'=>'In Coming'], null, ['class' => 'form-control'])}}
                            </div>
                        </div> 
                    </div>
                    @else  
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="form-group">
                                <strong>{{Form::label('meeting_type', 'Type')}}</strong>
                                {{Form::select('meeting_type', ['InPerson' => 'In Person', 'Video'=>'Video', 'Telephonic' => 'Telephonic'], null, ['class' => 'form-control', 'placeholder'=>'Select'])}}
                            </div>
                        </div>
                    </div>
                    @endif
                <div class="row">
                    <div class="col-md-10">
                        <div class="form-group">

                            <strong>{{Form::label('profiles[]', 'Who')}}</strong>
                            {{Form::hidden('profile_id', $profile->id, ['class' => 'form-control'])}}
                            {{Form::hidden('activity_type', $activity_type, ['class' => 'form-control'])}}
                            {{Form::select('profiles[]', $profiles, null, ['class' => 'form-control select2 select2-multiple', 'multiple'])}}

                            <small><span class="help-text text-info">Please include all other fruits that were in attendance apart from <strong>{{$profile->fullname}} {{$profile->lastname}}. </strong> Leave this field blank if there were no other fruits.</span></small>
                        </div>
                    </div> 
                </div>
                @if($activity_type == 'Meeting')
                     <div class="row">
                        <div class="col-md-12">
                      <div class="form-group">
                        <strong>{{Form::label('where', 'Where')}}</strong>
                        {{Form::text('where', $activity->venue, ['class' => 'form-control', 'placeholder' => 'Where', 'autocomplete'=>'off', 'required'])}}

                        </div>
                    </div>
                    </div>
                    @endif
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <strong>{{Form::label('when', 'When')}}</strong>
                            {{Form::date('when', $activity->when, ['class' => 'form-control mydatepicker', 'placeholder' => 'Click here', 'autocomplete'=>'off', 'required'])}}

                        </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <strong>{{Form::label('time', 'Time')}}</strong>
                        {{Form::time('time', null, ['class' => 'form-control timepicker', 'placeholder' => 'Click here', 'autocomplete'=>'off', 'required'])}}

                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <strong>{{Form::label('why', 'Why')}}<span class="text-danger">*</span></strong>
                            {{Form::textarea('why', null, ['class' => 'form-control', 'placeholder' => 'Type here', 'require'])}}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <strong>{{Form::label('outcome', 'Outcome')}}<span class="text-danger">*</span></strong>
                        {{Form::textarea('outcome', null, ['class' => 'form-control', 'placeholder' => 'Type here', 'required'])}}
                    </div>
                </div>
            </div>
            @if($activity_type == 'Meeting')
                <strong>Uploaded photos</strong> <br>
                @forelse($activity->photos->where('profile_id', $profile->id) as $photo)
                <a href="{{ url('storage/'.$photo->path) }}" target="_blank" data-toggle="lightbox" data-effect="mfp-zoom-in" data-gallery="multiimages" data-title="{{$photo->caption}}">
                    <img src="{{ url('storage/'.$photo->path) }}" alt="{{$photo->caption}}" class="all studio col-md-3 col-xs-12" style="background-color: rgba(245, 245, 245, 0.5); padding: 5px; border-radius: 5px;" />
                </a>
                <a href="{{route('delete.activity.photo', $photo->id)}}" class="btn btn-sm btn-danger" onclick="return confirm('are you sure you want to delete this photo?')">x</a>
                @empty
                There are no uploaded photos.
                @endforelse
             <hr>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <strong>{{Form::label('photos', 'Upload photos')}}</strong> <br>
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
            <a href="/profiles/{{$profile->slug}}" class="btn"> Cancel</a>
            {!! Form::close() !!}
        </div>
    </div>
</div>
</div>

@endsection
