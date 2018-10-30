@extends('layouts.hwpl')

@section('content')
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">EVENTS</h4> </div>
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <a href="/events/create" target="_blank" class="btn btn-primary pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light"><span class="fa fa-plus"></span> CREATE EVENT</a>
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
                            <div class="panel-action">
                                    <div class="dropdown"> <a class="dropdown-toggle" id="examplePanelDropdown" data-toggle="dropdown" href="#" aria-expanded="false" role="button"><span class="fa fa-bars"></span></a>
                                        <ul class="dropdown-menu bullet dropdown-menu-right " aria-labelledby="examplePanelDropdown" role="menu" >
                                            <li role="presentation"><a href="/events/{{$event->slug}}" role="menuitem">
                                                <i class="icon wb-reply"></i> <span style="color:#000">Manage</span></a>
                                            </li>
                                             <li role="presentation"><a href="/events/{{$event->slug}}/edit" role="menuitem">
                                                <i class="icon wb-reply"></i> <span style="color:#000"> Edit</span></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                        </div>

                            <div class="panel-wrapper collapse in">
                                <div class="panel-body">
                                    <p>
                                        <strong><h4 class="page-title">{{strtoupper($event->name)}}</h4></strong>
                                    </p>
                                    <hr>
                                        <div class="col-md-2 col-xs-2 b-r text-center"> <strong>{{$event->count_attendees_status('RSVP')}}</strong>
                                            <br>
                                            <p class="text-muted">RSVP</p>
                                        </div>
                                        <div class="col-md-2 col-xs-2 b-r text-center"> <strong>{{$event->count_attendees_status('DECLINE')}}</strong>
                                            <br>
                                            <p class="text-muted">Declined</p>
                                        </div>
                                        <div class="col-md-2 col-xs-2 b-r text-center"> <strong>{{$event->count_attendees_status('REVOKE')}}</strong>
                                            <br>
                                            <p class="text-muted b-r">Revoked</p>
                                        </div>
                                        <div class="col-md-2 col-xs-2 b-r text-center"> <strong>{{$event->count_attendees_status('PENDING')}}</strong>
                                            <br>
                                            <p class="text-muted">Pending</p>
                                        </div>
                                        <div class="col-md-2 col-xs-2 text-center"> <strong>{{$event->count_attendees_status('DECLINE')}}</strong>
                                            <br>
                                            <p class="text-muted">Attended</p>
                                        </div>

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
