@extends('layouts.hwpl')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item">Management</li>
    <li class="breadcrumb-item"><a href="/profiles">Profiles </a></li>
    <li class="breadcrumb-item active">Media Coverage Report</li>
    <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection

@section('content')
<div class="row">
<div class="col-md-2 col-xs-12">
</div>
    <div class="col-md-8 col-xs-12">
        <div class="card">
            <div class="card-header">
                <strong>Media coverage report</strong> | 
                    <a href="/profiles/{{$profile->slug}}"> 
                     Cancel</a>
            </div>
            <div class="card-body">
                   {!! Form::open(array('url' => '/media-coverage/create', 'method' => 'post', 'class'=> 'form-vertical form-material', 'enctype="multipart/form-data"')) !!}

                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="form-group">

                                {{Form::label('platform', 'Platform')}}
                                {{Form::select('platform', ['Online' => 'Online', 'Print'=>'Print', 'Broadcast'=>'Broadcast', 'Radio'=>'Radio'], null, ['class' => 'form-control', 'required'])}}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="form-group">

                                {{Form::label('media_house', 'Media House')}}<span class="text-danger">*</span>
                                {{Form::hidden('profile_id', $profile->id, ['class' => 'form-control'])}}
                                {{Form::text('media_house', null, ['class' => 'form-control', 'placeholder' => 'Click here', 'required'])}}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="form-group">
                                {{Form::label('when', 'When')}}<span class="text-danger">*</span>
                                {{Form::date('when', null, ['class' => 'form-control mydatepicker', 'placeholder' => 'Click here', 'autocomplete'=>'off', 'required'])}}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="form-group">

                                {{Form::label('event_id', 'Event (optional)')}}
                                {{Form::select('event_id', $events, null, ['class' => 'form-control', 'placeholder' => 'Not attached to event'])}}
                                <span class="help-text text-info">Only if the coverage is about an event.</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                {{Form::label('title', 'Title')}} <span class="text-danger">*</span>
                                {{Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'Type here', 'required'])}}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                {{Form::label('short_summary', 'Short Summary')}} <span class="text-danger">*</span>
                                {{Form::textarea('short_summary', null, ['class' => 'form-control', 'placeholder' => 'Type the first paragraph of the article', 'required'])}}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                {{Form::label('url', 'URL')}}
                                {{Form::text('url', null, ['class' => 'form-control', 'placeholder' => 'Type here'])}}
                                <span class="help-text text-info">Only if the platform is online.</span>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                {{Form::label('location', 'Storage')}}
                                {{Form::text('location', null, ['class' => 'form-control', 'placeholder' => 'Type here'])}}
                                <span class="help-text text-info">Please indicate where the physical file is stored. This is only applicable to Print, Broadcast and Radio</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        
                        <div class="col-md-12">
                            <div class="form-group">
                                {{Form::label('city_id', 'City')}}
                                {{Form::select('city_id', $cities, $profile->city_id, ['class' => 'form-control select2', 'required'])}}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                {{Form::label('photos', 'Photo')}}
                                {{Form::file('photos[]', null, ['class' => 'form-control'])}}
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                {{Form::label('caption', 'Photo Caption')}}
                                {{Form::text('caption[]', null, ['class' => 'form-control', 'placeholder' => 'Type caption here'])}}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                {{Form::label('photos', 'Photo')}}
                                {{Form::file('photos[]', null, ['class' => 'form-control'])}}
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                {{Form::label('caption', 'Photo Caption')}}
                                {{Form::text('caption[]', null, ['class' => 'form-control', 'placeholder' => 'Type caption here'])}}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                {{Form::label('photos', 'Photo')}}
                                {{Form::file('photos[]', null, ['class' => 'form-control'])}}
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                {{Form::label('caption', 'Photo Caption')}}
                                {{Form::text('caption[]', null, ['class' => 'form-control', 'placeholder' => 'Type caption here'])}}
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success"><span class="fa fa-check-circle"></span> Save</button>
                    <a href="/profiles/{{$profile->slug}}" class="btn">Cancel</button>
                    {!! Form::close() !!} 
            </div>
        </div>
    </div>
</div>
@endsection
