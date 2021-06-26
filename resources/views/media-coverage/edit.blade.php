@extends('layouts.hwpl')

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
                {!! Form::model($media_coverage, array('route'=>array('media-coverage.edit', $media_coverage->id), 'method' => 'post', 'class'=> 'form-vertical form-material', 'enctype="multipart/form-data"')) !!}
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="form-group">

                            <strong>{{Form::label('platform', 'Platform')}}</strong>
                            {{Form::select('platform', ['Online' => 'Online', 'Print'=>'Print', 'Broadcast'=>'Broadcast', 'Radio'=>'Radio'], null, ['class' => 'form-control', 'required'])}}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="form-group">

                            <strong>{{Form::label('media_house', 'Media House')}}<span class="text-danger">*</span></strong>
                            {{Form::hidden('profile_id', $profile->id, ['class' => 'form-control'])}}
                            {{Form::text('media_house', null, ['class' => 'form-control', 'placeholder' => 'Click here', 'required'])}}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="form-group">
                            <strong>{{Form::label('when', 'When')}}<span class="text-danger">*</span></strong>
                            {{Form::date('when', null, ['class' => 'form-control mydatepicker', 'placeholder' => 'Click here', 'autocomplete'=>'off', 'required'])}}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="form-group">

                            <strong>{{Form::label('event_id', 'Event (optional)')}}</strong>
                            {{Form::select('event_id', $events, null, ['class' => 'form-control', 'placeholder' => 'Not attached to event'])}}
                            <span class="help-text text-info">Only if the coverage is about an event.</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <strong>{{Form::label('title', 'Title')}} <span class="text-danger">*</span></strong>
                            {{Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'Type here', 'required'])}}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <strong>{{Form::label('short_summary', 'Short Summary')}} <span class="text-danger">*</span></strong>
                            {{Form::textarea('short_summary', null, ['class' => 'form-control', 'placeholder' => 'Type the first paragraph of the article', 'required'])}}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <strong>{{Form::label('url', 'URL')}}</strong>
                            {{Form::text('url', null, ['class' => 'form-control', 'placeholder' => 'Type here'])}}
                            <span class="help-text text-info">Only if the platform is online.</span>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <strong>{{Form::label('location', 'Storage')}}</strong>
                            {{Form::text('location', null, ['class' => 'form-control', 'placeholder' => 'Type here'])}}
                            <span class="help-text text-info">Please indicate where the physical file is stored. This is only applicable to Print, Broadcast and Radio</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    
                    <div class="col-md-12">
                        <div class="form-group">
                            <strong>{{Form::label('city_id', 'City')}}</strong>
                            {{Form::select('city_id', $cities, null, ['class' => 'form-control select2', 'required'])}}
                        </div>
                    </div>
                </div>
                <hr>
                 <strong>Uploaded photos</strong> <br>
                        @forelse($media_coverage->photos as $photo)
                        <a href="{{ url('storage/'.$photo->path) }}" target="_blank" data-toggle="lightbox" data-effect="mfp-zoom-in" data-gallery="multiimages" data-title="{{$photo->caption}}">
                            <img src="{{ url('storage/'.$photo->path) }}" alt="{{$photo->caption}}" class="all studio col-md-3 col-xs-12" style="background-color: rgba(245, 245, 245, 0.5); padding: 5px; border-radius: 5px;" />
                        </a>
                        <a href="{{route('delete.media.photo', $photo->id)}}" class="btn btn-sm btn-danger" onclick="return confirm('are you sure you want to delete this photo?')">x</a>
                        @empty
                        There are no uploaded photos.
                        @endforelse
                    <hr>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <strong>{{Form::label('photos', 'Photo')}}</strong>
                            {{Form::file('photos[]', null, ['class' => 'form-control'])}} <br>
                            {{Form::text('caption[]', null, ['class' => 'form-control', 'placeholder' => 'Type caption here'])}}
                        </div>
                    </div>
                </div>
                
                    
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <strong>{{Form::label('photos', 'Photo')}}</strong>
                            {{Form::file('photos[]', null, ['class' => 'form-control'])}} <br>
                            {{Form::text('caption[]', null, ['class' => 'form-control', 'placeholder' => 'Type caption here'])}}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <strong>{{Form::label('photos', 'Photo')}}</strong>
                            {{Form::file('photos[]', null, ['class' => 'form-control'])}} <br>
                            {{Form::text('caption[]', null, ['class' => 'form-control', 'placeholder' => 'Type caption here'])}}
                            
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-success"> Save</button>
                <a href="/profiles/{{$profile->slug}}" class="btn">Cancel</button>
            {!! Form::close() !!}
     </div>
        </div>
    </div>
</div>
@endsection
