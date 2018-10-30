@extends('layouts.hwpl')

@section('content')
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">CO-HOST / <small>View</small></h4> </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <ol class="breadcrumb">
                    <li><a href="/events">Events</a></li>
                    <li><a href="/events/{{$co_host->event->slug}}">{{$co_host->event->name}}</a></li>
                    <li class="active">Co-hosts</li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <div class="row">
            <div class="col-md-12 col-lg-12 col-sm-12">
                <div class="white-box">
                    <a href="/events/{{$co_host->event->slug}}"> <span class="fa fa-calendar"></span> {{$co_host->event->name}}</a>
                    <hr>
                    <h2 class="box-title m-t-5">{{$co_host->name}}</h2>
                    
                    <p>
                        <img src="{{asset('storage/'.$co_host->logo) }}" width="250">
                    </p>
                    
                <!-- /.row -->
                <!-- .row -->
                <div class="row m-t-10">
                    <div class="col-md-12"><strong>Address</strong>
                        <p>{{$co_host->address_line1}} <br>
                        {{$co_host->address_line2}} <br>
                        {{$co_host->address_line3}} <br>
                        {{$co_host->address_line4}}</p>
                    </div>
                </div>
                <h4 class="box-title m-t-5">Contact Persons</h4>
                <div class="row m-t-10">
                    @foreach($co_host->contacts as $contact)
                        <div class="col-md-4"><strong>{{$contact->contact_person}}</strong>
                        <p>{{$contact->contact_number}} <br>
                        {{$contact->contact_email}} <br>
                        </p>
                    </div>
                    @endforeach
                    
                </div>
                <hr>
                <a href="/event-co-host/edit/{{$co_host->id}}" class="btn btn-info">
                    <span class="fa fa-edit"></span> Edit
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
