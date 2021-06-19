@extends('layouts.hwpl')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item">Events</li>
    <li class="breadcrumb-item active"><a href="/external-events">External events </a></li>
    <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection
@section('content')
<div class="card">
    <div class="card-header">
        <div class="float-left">
            <a href="/external-events/create" class="btn btn-primary pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light"><span class="fa fa-plus"></span> CREATE EVENT</a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-responsive-sm table-bordered table-striped table-sm" style="width:100%">
            <thead>
            <tr>
                <th>Name</th>
                <th>Start date & time</th>                    
                <th>Location</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($events as $event)
            <tr>
                <td>{{$event->name}}</td>
                <td>{{date('d M Y', strtotime($event->start_date))}} <small>{{$event->start_time}} - {{$event->end_time}}  </small></td>
                <td>{{$event->address_line1}}, {{$event->address_line2}}, {{$event->city->name}}, {{$event->country->name}}</td>
                <td>
                    <a href="/report/events/edit/{{$event->slug}}">
                        <svg class="c-icon mr-2">
                            <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-search')}}"></use>
                        </svg>
                    </a>
                    <a href="/external-events/{{$event->slug}}/edit">
                        <svg class="c-icon mr-2">
                            <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-pencil')}}"></use>
                        </svg>
                    </a>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
