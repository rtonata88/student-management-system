@extends('layouts.hwpl')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item">Events</li>
    <li class="breadcrumb-item "><a href="/events">Internal events </a></li>
    <li class="breadcrumb-item active">Co-hosts</li>
    <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection
@section('content')
<div class="row">
    <div class="col-md-8 col-xs-12">
        <div class="card">
            <div class="card-header">
                <strong>Co-host information </strong> |  
                <a href="/events/co-hosts/{{$co_host->event->slug}}">
            <svg class="c-icon c-icon-lg">
                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-arrow-left')}}"></use>
            </svg>Back</a>
            </div>
            <div class="card-body">
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
                 <a href="/events/co-hosts/{{$co_host->event->slug}}">
            <svg class="c-icon c-icon-lg">
                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-arrow-left')}}"></use>
            </svg>Back</a> 
                <a href="/event-co-host/edit/{{$co_host->id}}" class="btn btn-primary btn-sm">
                    Update co-host information
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
