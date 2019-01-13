@extends('layouts.hwpl')

@section('content')
@push('googleCharts')
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable({!! $data !!});

        var options = {
          chart: {
            title: 'Sector Performance',
            subtitle: 'Calls, Meetings, WhatsApp, Email, etc.',
          }
        };

        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
    </script>

@endpush
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">PERIODIC / <small>REPORTS</small></h4> </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <ol class="breadcrumb">
                    <li><a href="/reports">Reports</a></li>
                    <li class="active">Periodic</li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
    </div>
    <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12">
            <div class="white-box">
                <!-- .row -->
                <div class="row">
                    <div class="col-md-12 col-lg-12">
                        <div class="white-box">
                            <h3 class="box-title">Sector Activities</h3>
                            <div id="columnchart_material" style="width: auto; height: 400px;"></div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 col-lg-12">
                        <div class="white-box">                            
                            <table class="table">
                                <thead>
                                    @foreach($data1 as $key => $titles)
                                    <tr>
                                        @if($key == 0)
                                        @foreach($titles as $activities)
                                            <th class="text-center">
                                                @if($activities == 'Activities')
                                                    Sector
                                                @else
                                                    {{$activities}}
                                                @endif
                                            </th>
                                         @endforeach
                                         @endif
                                    </tr>
                                    @endforeach
                                </thead>
                                <tbody>
                                    @foreach($data1 as $key=>$data)
                                    @if($key != 0)
                                    <tr>
                                        @foreach($data as $activities)
                                            <td class="text-center">
                                                @if(is_numeric($activities))
                                                    {{$activities}} 
                                                @else
                                                    <a href="/reports/sector/{{$activities}} ">{{$activities}}</a>
                                                @endif
                                            </td>
                                         @endforeach
                                    </tr>
                                         @endif
                                    @endforeach
                                </tbody>
                            </table>
                            <hr>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
