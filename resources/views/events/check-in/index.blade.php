@extends('layouts.hwpl')

@section('content')
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">EVENTS</h4> </div>
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                 <li class="active">Events</li>
            </ol>
        </div>
        <!-- /.col-lg-12 -->
    </div>
       
            <div class="row">
                 @foreach($events as $event)
                    <div class="col-lg-6 col-md-6 col-sm-4 col-xs-12">
                        <div class="panel panel-black">
                            <div class="panel-heading">
                                {{strtoupper(date('M d', strtotime($event->start_date)))}} <small>{{$event->start_time}} - {{$event->end_time}}  
                            </small>
                            <div class="pull-right">
                                <a href="/event-check-in/{{$event->slug}}" class="btn btn-default btn-outline" style="color:#000"> Check In</a>
                            </div>
                            
                        </div>

                            <div class="panel-wrapper collapse in">
                                <div class="panel-body">
                                    <p>
                                        <strong><h4 class="page-title">{{strtoupper($event->name)}}</h4></strong>
                                    </p>
                                    <hr>
                                        <i>THEME: {{$event->theme}}</i>

                                </div>
                                <div class="panel-footer"> 
                                        <span class="fa fa-map-marker"></span> {{$event->address_line1}}, {{$event->address_line2}}, {{$event->city->name}}, {{$event->country->name}}
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            
    </div>
</div>
@endsection
