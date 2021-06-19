@extends('layouts.hwpl')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item">Events</li>
    <li class="breadcrumb-item "><a href="/events">Internal events </a></li>
    <li class="breadcrumb-item active">Setup</li>
    <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection
@section('content')
<div class="row">
    <div class="col-md-4 col-xs-12">
        <div class="card">
            <div class="card-header">
                <strong>Event management options</strong> 
            </div>
            <div class="card-body">
                <ul class="list-group">
                    <li class="list-group-item d-flex list-group-item-action justify-content-between align-items-center"><a href="{{route('event-details', $event->slug)}}">Event details</a> 
                        @if($event->start_date)
                        <span class="text-success">
                            <svg class="c-icon">
                                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-check-circle')}}"></use>
                            </svg>
                        </span>
                        @else
                        <span class="text-danger">
                            <svg class="c-icon">
                                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-x-circle')}}"></use>
                            </svg>
                        </span>
                        @endif
                    </li>
                    <li class="list-group-item d-flex list-group-item-action justify-content-between align-items-center"><a href="{{route('event-program', $event->slug)}}">Program management</a>
                       
                        @if(strlen($event->event_program)>20)
                        <span class="text-success">
                            <svg class="c-icon">
                                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-check-circle')}}"></use>
                            </svg>
                        </span>
                        @else
                        <span class="text-danger">
                            <svg class="c-icon">
                                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-x-circle')}}"></use>
                            </svg>
                        </span>
                        @endif
                    </li>
                    <li class="list-group-item d-flex list-group-item-action justify-content-between align-items-center"><a href="{{route('event-guests', $event->slug)}}">Guest management</a>
                     @if(count($event->participants))
                        <span class="text-success">
                            <svg class="c-icon">
                                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-check-circle')}}"></use>
                            </svg>
                        </span>
                        @else
                        <span class="text-danger">
                            <svg class="c-icon">
                                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-x-circle')}}"></use>
                            </svg>
                        </span>
                        @endif
                </li>
                    <li class="list-group-item d-flex list-group-item-action justify-content-between align-items-center"><a href="{{route('event-staff', $event->slug)}}">Internal staff management</a>
                    
                    @if(count($event->event_staff))
                        <span class="text-success">
                            <svg class="c-icon">
                                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-check-circle')}}"></use>
                            </svg>
                        </span>
                        @else
                        <span class="text-danger">
                            <svg class="c-icon">
                                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-x-circle')}}"></use>
                            </svg>
                        </span>
                        @endif
                </li>
                    <li class="list-group-item d-flex list-group-item-action justify-content-between align-items-center"><a href="{{route('event-co-hosts', $event->slug)}}">Co-host management</a>
                    @if(count($event->co_hosts))
                        <span class="text-success">
                            <svg class="c-icon">
                                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-check-circle')}}"></use>
                            </svg>
                        </span>
                        @else
                        <span class="text-danger">
                            <svg class="c-icon">
                                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-x-circle')}}"></use>
                            </svg>
                        </span>
                        @endif
                </li>
                    <li class="list-group-item d-flex list-group-item-action justify-content-between align-items-center"><a href="{{route('event-media-coverage', $event->slug)}}">Media coverage management</a>
                    @if(count($event->media_coverage))
                        <span class="text-success">
                            <svg class="c-icon">
                                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-check-circle')}}"></use>
                            </svg>
                        </span>
                        @else
                        <span class="text-danger">
                            <svg class="c-icon">
                                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-x-circle')}}"></use>
                            </svg>
                        </span>
                        @endif
                </li>
                    <li class="list-group-item d-flex list-group-item-action justify-content-between align-items-center"><a href="{{route('event-documents', $event->slug)}}">Document management</a>
                    @if(count($event->documents))
                        <span class="text-success">
                            <svg class="c-icon">
                                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-check-circle')}}"></use>
                            </svg>
                        </span>
                        @else
                        <span class="text-danger">
                            <svg class="c-icon">
                                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-x-circle')}}"></use>
                            </svg>
                        </span>
                        @endif
                </li>
                    <li class="list-group-item d-flex list-group-item-action justify-content-between align-items-center"><a href="{{route('event-other-details', $event->slug)}}">Other information</a>
                    @if(count($event->miscellaneous))
                        <span class="text-success">
                            <svg class="c-icon">
                                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-check-circle')}}"></use>
                            </svg>
                        </span>
                        @else
                        <span class="text-danger">
                            <svg class="c-icon">
                                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-x-circle')}}"></use>
                            </svg>
                        </span>
                        @endif
                </li>
                    <li class="list-group-item d-flex list-group-item-action justify-content-between align-items-center"><a href="{{route('event-gallery', $event->slug)}}">Gallery</a>
                    @if(count($event->photos))
                        <span class="text-success">
                            <svg class="c-icon">
                                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-check-circle')}}"></use>
                            </svg>
                        </span>
                        @else
                        <span class="text-danger">
                            <svg class="c-icon">
                                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-x-circle')}}"></use>
                            </svg>
                        </span>
                        @endif
                </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-md-8 col-xs-12">
        @include($partial_file_path)
    </div>
</div>
    
@endsection
