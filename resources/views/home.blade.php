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
            subtitle: 'Calls, Meetings, WhatsApp, Email, Media Coverage, etc.',
          }
        };

        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
    </script>

@endpush

 <!-- Page Content -->
        <!-- ============================================================== -->
            <div class="container-fluid">
                <div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">Dashboard</h4> </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="#">Dashboard</a></li>
                        </ol>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <!-- ============================================================== -->
                <!-- Different data widgets -->
                <!-- ============================================================== -->
                <!-- .row -->
                <div class="row">
                    <div class="col-lg-3 col-sm-6 col-xs-12">
                        <div class="white-box analytics-info">
                            <h3 class="box-title">HWPL <small>Activities</small></h3>
                            <ul class="list-inline two-part">
                                <li>
                                    <div class="sparklinedash"></div>
                                </li>
                                <li class="text-right"><i class="ti-arrow-up text-success"></i> <span class="counter text-info">
                                    @if(count($sectors->where('name', 'HWPL')->first()))
                                        {{$sectors->where('name', 'HWPL')->first()->count}}
                                    @else
                                        0
                                    @endif
                                </span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-xs-12">
                        <div class="white-box analytics-info">
                            <h3 class="box-title">IPYG <small>Activities</small></h3>
                            <ul class="list-inline two-part">
                                <li>
                                    <div class="sparklinedash2"></div>
                                </li>
                                <li class="text-right"><i class="ti-arrow-up text-purple"></i> <span class="counter text-purple">
                                    @if(count($sectors->where('name', 'IPYG')->first()))
                                        {{$sectors->where('name', 'IPYG')->first()->count}}
                                    @else
                                        0
                                    @endif
                                </span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-xs-12">
                        <div class="white-box analytics-info">
                            <h3 class="box-title">IWPG <small>Activities</small></h3>
                            <ul class="list-inline two-part">
                                <li>
                                    <div class="sparklinedash3"></div>
                                </li>
                                <li class="text-right"><i class="ti-arrow-up text-info"></i> <span class="counter text-danger">
                                    @if(count($sectors->where('name', 'IWPG')->first()))
                                        {{$sectors->where('name', 'IWPG')->first()->count}}
                                    @else
                                        0
                                    @endif
                                </span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-xs-12">
                        <div class="white-box analytics-info">
                            <h3 class="box-title">PROFILES <small>Total count</small></h3>
                            <ul class="list-inline two-part">
                                <li>
                                    <div class="sparklinedash"></div>
                                </li>
                                <li class="text-right"><i class="ti-arrow-up text-info"></i> <span class="counter text-info">
                                    {{$profiles}}
                                </span></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!--/.row -->
                <!--row -->
                <!-- /.row -->
                <!-- ============================================================== -->
                <!-- table -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-md-12 col-lg-12 col-sm-12">
                            <div class="col-md-12 col-lg-12">
                                <div class="white-box">
                                    <h3 class="box-title">Sector Activities | <small><span class="fa fa-share"></span> <a href="/reports/periodic">Periodic Reports</a></small></h3>
                                    <div id="columnchart_material" style="width: auto; height: 400px;"></div>
                                </div>
                            </div>
                    </div>
                </div>
               
            </div>
            @endsection
