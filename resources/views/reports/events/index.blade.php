@extends('layouts.hwpl')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item">Reports</li>
    <li class="breadcrumb-item active"><a href="#">Post Event Report </a></li>
    <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection
@section('content')

        
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
                                            @if($event->report)
                                            <li role="presentation"><a href="/report/events/edit/{{$event->slug}}" role="menuitem">
                                                <i class="icon wb-reply"></i> <span style="color:#000">Edit Report</span></a>
                                            </li>
                                            @else
                                             <li role="presentation"><a href="/report/events/create/{{$event->slug}}" role="menuitem">
                                                <i class="icon wb-reply"></i> <span style="color:#000">Create Report</span></a>
                                            </li>
                                            @endif
                                             @if($event->report)
                                             <li role="presentation"><a href="/report/events/view/{{$event->slug}}" role="menuitem">
                                                <i class="icon wb-reply"></i> <span style="color:#000"> View Report</span></a>
                                            </li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                        </div>

                            <div class="panel-wrapper collapse in">
                                <div class="panel-body">

                                    @if($event->event_type == 'internal')
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
                                    @else
                                        <strong>Outcome: </strong>{{$event->report->summary}}
                                    @endif

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
