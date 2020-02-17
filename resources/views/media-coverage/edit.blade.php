@extends('layouts.hwpl')

@section('content')
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">CONTACT MEDIA COVERAGE</h4> </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <ol class="breadcrumb">
                    <li><a href="/profiles/{{$profile->slug}}">{{$profile->fullname}} {{$profile->lastname}}</a></li>
                    <li class="active">New Media Coverage</li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <div class="row">
            <div class="col-md-12 col-lg-12 col-sm-12">
                <div class="white-box">
                    <a href="/profiles/{{$profile->slug}}"> <span class="fa fa-user"></span> Profile Page</a>
                    <h3 class="box-title">COVERAGE FOR {{$profile->fullname}} {{$profile->lastname}} [EDIT]</h3>
                    {!! Form::model($media_coverage, array('route'=>array('media-coverage.edit', $media_coverage->id), 'method' => 'post', 'class'=> 'form-vertical form-material', 'enctype="multipart/form-data"')) !!}

                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">

                                {{Form::label('platform', 'Platform')}}
                                {{Form::select('platform', ['Online' => 'Online', 'Print'=>'Print', 'Broadcast'=>'Broadcast', 'Radio'=>'Radio'], null, ['class' => 'form-control', 'required'])}}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">

                                {{Form::label('media_house', 'Media House')}}
                                {{Form::hidden('profile_id', $profile->id, ['class' => 'form-control'])}}
                                {{Form::text('media_house', null, ['class' => 'form-control', 'placeholder' => 'Click here', 'required'])}}
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
                </div>
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">

                            {{Form::label('event_id', 'Event (optional)')}}
                            {{Form::select('event_id', $events, null, ['class' => 'form-control', 'placeholder' => 'Not attached to event'])}}
                            <span class="help-text">Only if the coverage is about an event.</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        {{Form::label('title', 'Title')}}
                        {{Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'Type here'])}}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    {{Form::label('short_summary', 'Short Summary')}}
                    {{Form::textarea('short_summary', null, ['class' => 'form-control', 'placeholder' => 'Type the first paragraph of the article'])}}
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    {{Form::label('url', 'URL')}}
                    {{Form::text('url', null, ['class' => 'form-control', 'placeholder' => 'Type here'])}}
                    <span class="help-text">Only if the platform is online.</span>
                </div>
            </div>

                 <div class="col-md-6">
                  <div class="form-group">
                    {{Form::label('location', 'Storage')}}
                    {{Form::text('location', null, ['class' => 'form-control', 'placeholder' => 'Type here'])}}
                    <span class="help-text">Please indicate where the physical file is stored. This is only applicable to Print, Broadcast and Radio</span>
                  </div>
                </div>

            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        {{Form::label('country_id', 'Country')}}
                        {{Form::select('country_id', $countries, $profile->country_id, ['class' => 'form-control', 'required'])}}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {{Form::label('city_id', 'City')}}
                        {{Form::select('city_id', $cities, $profile->city_id, ['class' => 'form-control', 'required'])}}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <a href=""> <span class="fa fa-edit"></span> Photo Management</a>
                    </div>
                </div>

             <div id="gallery">
                <div id="gallery-content">
                    <div id="gallery-content-center">
                        @foreach($media_coverage->photos as $photo)
                        <a href="{{ asset('storage/'.$photo->path) }}" data-toggle="lightbox" data-effect="mfp-zoom-in" data-gallery="multiimages" data-title="{{$photo->caption}}"><img src="{{ asset('storage/'.$photo->path) }}" alt="gallery" class="all studio" /></a>

                        @endforeach
                    </div>
                </div>
             </div>
             </div>
             <hr>
             <p>
                 <h3>Upload photos below</h3>
             </p>
             <br>
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
        <button type="reset" class="btn btn-warning"><span class="fa fa-ban"></span> Reset</button>
        {!! Form::close() !!}
    </div>
</div>
</div>
</div>
</div>
</div>
@endsection
