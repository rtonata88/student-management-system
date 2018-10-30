@extends('layouts.hwpl')

@section('content')
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">EXTERNAL EVENTS / <small>list</small></h4> </div>
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <a href="/external-events/create" class="btn btn-primary pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light"><span class="fa fa-plus"></span> CREATE EVENT</a>
            <ol class="breadcrumb">
                 <li class="active">Events</li>
            </ol>
        </div>
        <!-- /.col-lg-12 -->
    </div>
        
            <div class="row">
                @forelse($events as $event)
                    <div class="col-lg-6 col-md-6 col-sm-4 col-xs-12">
                        <div class="panel panel-black">
                            <div class="panel-heading">
                                {{strtoupper(date('M d', strtotime($event->start_date)))}} <small>{{$event->start_time}} - {{$event->end_time}}  
                            </small>
                            <div class="panel-action">
                                    <div class="dropdown"> <a class="dropdown-toggle" id="examplePanelDropdown" data-toggle="dropdown" href="#" aria-expanded="false" role="button"><span class="fa fa-bars"></span></a>
                                        <ul class="dropdown-menu bullet dropdown-menu-right " aria-labelledby="examplePanelDropdown" role="menu" >
                                            <li role="presentation"><a href="/events/{{$event->slug}}" role="menuitem">
                                                <i class="icon wb-reply"></i> <span style="color:#000">View </span></a>
                                            </li>
                                             <li role="presentation"><a href="/external-events/{{$event->slug}}/edit" role="menuitem">
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
                                       <strong>Outcome: </strong>
                                       <p>
                                           {{$event->report->summary}}
                                       </p>

                                </div>
                                <div class="panel-footer"> 
                                        <span class="fa fa-map-marker"></span> {{$event->address_line1}}, {{$event->address_line2}}, {{$event->city->name}}, {{$event->country->name}}
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                        <div class="row">
                            <div class="col-md-12 col-lg-12 col-sm-12">
                                <div class="white-box">
                                    There are no external events
                                </div>
                            </div>
                        </div>
                    @endforelse
                </div>
            
    </div>
</div>
@endsection
