@extends('layouts.hwpl')

@section('content')
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">CONTACT MEDIA COVERAGE</h4> </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <ol class="breadcrumb">
                    <li><a href="/profiles">Fruit Profiles</a></li>
                    <li><a href="/profiles/{{$profile->slug}}">Profile</a></li>
                    <li class="active">Media Coverage Timeline</li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <div class="row">
            <div class="col-md-12 col-lg-12 col-sm-12">
                <div class="white-box">
                    <a href="/profiles/{{$profile->slug}}"> <span class="fa fa-user"></span> Profile Page</a>
                    <h3 class="box-title">COVERAGE TIMELINE FOR {{$profile->fullname}} {{$profile->lastname}}</h3>
                    <hr>
                       <div class="steamline">
                        @foreach($media_coverages as $coverage)
                                <div class="sl-item">
                                    <div class="sl-left"><img src="../plugins/images/img1.jpg" alt="user" class="img-circle" />  </div>
                                    <div class="sl-right">
                                        <div class="m-l-40"><a href="#" class="text-info">{{$coverage->user->name}}</a>
                                         <span class="sl-date">10 days ago</span>
                                            <p><strong>Date: </strong>{{$coverage->when}}</a> <br>
                                            <strong>Title: </strong>{{$coverage->title}}</a> <br>
                                            <strong>Platform: </strong>{{$coverage->platform}}</a></p>

                                                    <p> {{$coverage->short_summary}}</p>
                                            <br>
                                            <div class="m-t-20 row">
                                                <div id="gallery">
                                                   <div id="gallery-content">
                                                       <div id="gallery-content-center">
                                                           @foreach($coverage->photos as $photo)
                                                           <a href="{{ asset('storage/'.$photo->path) }}" data-toggle="lightbox" data-effect="mfp-zoom-in" data-gallery="multiimages" data-title="{{$photo->caption}}"><img src="{{ asset('storage/'.$photo->path) }}" alt="gallery" class="all studio col-md-3 col-xs-12" /></a>

                                                           @endforeach
                                                       </div>
                                                   </div>
                                                </div>

                                            </div>


                                        </div>
                                    </div>
                                </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
