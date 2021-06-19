@extends('layouts.hwpl')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item">Management</li>
    <li class="breadcrumb-item active"><a href="/warp-attendees">WARP attendees </a></li>
    <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection

@section('content')

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    // google.charts.load('current', {'packages':['corechart']});
    // google.charts.setOnLoadCallback(drawChart);

    // function drawChart() {
    // var data = google.visualization.arrayToDataTable({!! $line_graph_data !!});

    // var options = {
    //     title: 'WARP Summit Attendees Per Year',
    //     curveType: 'function',
    //     legend: { position: 'bottom' }
    // };

    // var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

    // chart.draw(data, options);
    // }
</script>
<!-- <div class="row">

    <div class="col-md-12 col-lg-12 col-sm-12">
        <div class="card">
            <div class="card-body">
                <div id="curve_chart" style="width: 100%; height: 500px"></div>
            </div>
        </div>    
    </div>
</div> -->
<div class="row">
<div class="col-md-12 col-lg-12 col-sm-12">
    @if(Session::has('message'))
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        {{ Session::get('message') }}
    </div>
    @endif
    <div class="card">
        <div class="card-header">
            <div class="float-left">
                <a href="{{route('warp-attendees.create')}}" class="btn btn-primary pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light"><span class="fa fa-plus"></span> ADD ATTENDANCE</a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-responsive-sm table-bordered table-striped table-sm" style="width:100%">
                <thead>
                    <tr>
                        <th>Year Attended</th>
                        <th>Name</th>
                        <th>Organization (s)</th>
                        <th>Position</th>
                        <th>Financing</th>
                        <th>Country</th>
                        <th>City</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($attendees as $attendee)
                    <tr>
                        <td>{{date('Y', strtotime($attendee->date_attended))}}</td>
                        <td><a href="/profiles/{{$attendee->profile->slug}}" >{{$attendee->profile->fullname}} {{$attendee->profile->lastname}}</a></td>
                        <td>
                            @if($attendee->profile->organization_profile()->first())
                            {{$attendee->profile->organization_profile()->first()->organization->name}}
                            @endif
                        </td>
                        <td>
                            @if($attendee->profile->organization_profile()->first())
                                {{$attendee->profile->organization_profile()->first()->position}}
                            @endif
                        </td>
                        <td>{{$attendee->financing}}</td>
                        <td>{{$attendee->profile->country->name}}</td>
                        <td>{{$attendee->profile->city->name}}</td>
                        <td>
                            <a href="{{route('warp-attendees.edit', $attendee->id)}}"> <span class="fa fa-pencil"></span> 
                            <svg class="c-icon c-icon-lg">
                                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-pencil')}}"></use>
                            </svg></a>
                            <a href="{{route('warp-attendees.delete', $attendee->id)}}"> <span class="fa fa-trash"></span> 
                                <svg class="c-icon c-icon-lg">
                                    <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-trash')}}"></use>
                                </svg>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

</div>

@endsection
