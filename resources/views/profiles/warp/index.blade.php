@extends('layouts.hwpl')

@section('content')
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">WARP SUMMIT ATTENDEES</h4>
        </div>
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <a href="{{route('warp-attendees.create')}}" class="btn btn-primary pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light"><span class="fa fa-plus"></span> ADD ATTENDANCE</a>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="white-box">
        <div class="row">
        	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
		    <script type="text/javascript">
		      google.charts.load('current', {'packages':['corechart']});
		      google.charts.setOnLoadCallback(drawChart);

		      function drawChart() {
		        var data = google.visualization.arrayToDataTable({!! $line_graph_data !!});

		        var options = {
		          title: 'WARP Summit Attendees Per Year',
		          curveType: 'function',
		          legend: { position: 'bottom' }
		        };

		        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

		        chart.draw(data, options);
		      }
		    </script>
		    <div id="curve_chart" style="width: 100%; height: 500px"></div>
            <div class="col-md-12 col-lg-12 col-sm-12">
                @if(Session::has('message'))
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    {{ Session::get('message') }}
                </div>
                @endif
                <div class="table-responsive">


                    <table class="table table-hover table-bordered" style="width:100%">
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
                                	<a href="{{route('warp-attendees.edit', $attendee->id)}}"> <span class="fa fa-pencil"></span> Edit</a> |
                                  <a href="{{route('warp-attendees.delete', $attendee->id)}}"> <span class="fa fa-trash"></span> Delete</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
