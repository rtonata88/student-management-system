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
    <div class="row white-box">
        <div class="col-lg-3 col-sm-6 col-xs-12">
            <div class="white-box analytics-info">
                <h3 class="box-title">HWPL <small>Activities</small></h3>
                <ul class="list-inline two-part">
                    <li>
                        <div class="sparklinedash"></div>
                    </li>
                    <li class="text-right"><i class="ti-arrow-up text-success"></i> <span class="counter text-info">
                            @if(!empty($sectors->where('name', 'HWPL')->first()))
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
                            @if(!empty($sectors->where('name', 'IPYG')->first()))
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
                            @if(!empty($sectors->where('name', 'IWPG')->first()))
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
                <h3 class="box-title">PROFILES <small>Total Count</small></h3>
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
    <h4 class="box-title">SECTOR ACTIVITIES 
                        @if(Auth::user()->hasRole('Reports'))
                        | <small><span class="fa fa-share"></span> <a href="/reports/periodic">PERIODIC REPORTS</a></small>
                        @endif
                    </h4>
    <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12 white-box">
            <div class="col-md-12 col-lg-12">
                <div class="white-box">
                    <div id="columnchart_material" style="width: auto; height: 400px;"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        @push('googleCharts')
            <script type="text/javascript">
            google.charts.load('current', {'packages':['bar']});
            google.charts.setOnLoadCallback(drawChart);
            function drawChart() {
            var data = google.visualization.arrayToDataTable({!! $email_activities !!});
            var options = {
            chart: {
            title: 'Emails',            }
            };
            var chart = new google.charts.Bar(document.getElementById('emails_graph'));
            chart.draw(data, google.charts.Bar.convertOptions(options));
            }
            </script>
            @endpush
        <div class="col-md-4 col-lg-4">
            <div class="white-box">
                <div id="emails_graph" style="width: auto; height: 400px;"></div>
            </div>
        </div>
            @push('googleCharts')
            <script type="text/javascript">
            google.charts.load('current', {'packages':['bar']});
            google.charts.setOnLoadCallback(drawChart);
            function drawChart() {
            var data = google.visualization.arrayToDataTable({!! $call_activities !!});
            var options = {
            chart: {
            title: 'Calls',            }
            };
            var chart = new google.charts.Bar(document.getElementById('calls_graph'));
            chart.draw(data, google.charts.Bar.convertOptions(options));
            }
            </script>
            @endpush
        <div class="col-md-4 col-lg-4">
            <div class="white-box">
                <div id="calls_graph" style="width: auto; height: 400px;"></div>
            </div>
        </div>
            @push('googleCharts')
            <script type="text/javascript">
            google.charts.load('current', {'packages':['bar']});
            google.charts.setOnLoadCallback(drawChart);
            function drawChart() {
            var data = google.visualization.arrayToDataTable({!! $meeting_activities !!});
            var options = {
            chart: {
            title: 'Meetings',            }
            };
            var chart = new google.charts.Bar(document.getElementById('meetings_graph'));
            chart.draw(data, google.charts.Bar.convertOptions(options));
            }
            </script>
            @endpush
        <div class="col-md-4 col-lg-4">
            <div class="white-box">
                <div id="meetings_graph" style="width: auto; height: 400px;"></div>
            </div>
        </div>
    </div>

    <div class="row">
        @push('googleCharts')
            <script type="text/javascript">
            google.charts.load('current', {'packages':['bar']});
            google.charts.setOnLoadCallback(drawChart);
            function drawChart() {
            var data = google.visualization.arrayToDataTable({!! $message_activities !!});
            var options = {
            chart: {
            title: 'Messages',            }
            };
            var chart = new google.charts.Bar(document.getElementById('messages_graph'));
            chart.draw(data, google.charts.Bar.convertOptions(options));
            }
            </script>
            @endpush
        <div class="col-md-4 col-lg-4">
            <div class="white-box">
                <div id="messages_graph" style="width: auto; height: 400px;"></div>
            </div>
        </div>
            @push('googleCharts')
            <script type="text/javascript">
            google.charts.load('current', {'packages':['bar']});
            google.charts.setOnLoadCallback(drawChart);
            function drawChart() {
            var data = google.visualization.arrayToDataTable({!! $internal_events_by_team !!});
            var options = {
            chart: {
            title: 'Events Hosted',            }
            };
            var chart = new google.charts.Bar(document.getElementById('events_hosted_graph'));
            chart.draw(data, google.charts.Bar.convertOptions(options));
            }
            </script>
            @endpush
        <div class="col-md-4 col-lg-4">
            <div class="white-box">
                <div id="events_hosted_graph" style="width: auto; height: 400px;"></div>
            </div>
        </div>
            @push('googleCharts')
            <script type="text/javascript">
            google.charts.load('current', {'packages':['bar']});
            google.charts.setOnLoadCallback(drawChart);
            function drawChart() {
            var data = google.visualization.arrayToDataTable({!! $external_events_by_team !!});
            var options = {
            chart: {
            title: 'Events Attended',            }
            };
            var chart = new google.charts.Bar(document.getElementById('events_attended_graph'));
            chart.draw(data, google.charts.Bar.convertOptions(options));
            }
            </script>
            @endpush
        <div class="col-md-4 col-lg-4">
            <div class="white-box">
                <div id="events_attended_graph" style="width: auto; height: 400px;"></div>
            </div>
        </div>
    </div>

    <h4 class="box-title">PROFILES | <small><span class="fa fa-share"></span> <a href="/reports/profiles">PROFILE REPORTS</a></small></h4>

    <div class="row">
            <div class="col-md-6 col-lg-6">
                <div id="profiles_by_country" style="width: auto; height: 400px;"></div>
            </div>
            @push('googleCharts')
            <script type="text/javascript">
                google.charts.load('current', {'packages':['corechart']});
                google.charts.setOnLoadCallback(drawChart);
                function drawChart() {

                var data = google.visualization.arrayToDataTable({!! $profiles_by_country !!});
                var pieOptions = {
                title: 'Per Country'
                };
                var chart = new google.visualization.PieChart(document.getElementById('profiles_by_country'));
                chart.draw(data, pieOptions);
                }
            </script>
            @endpush

            <div class="col-md-6 col-lg-6">
                <div id="profiles_by_status" style="width: auto; height: 400px;"></div>
            </div>
            @push('googleCharts')
            <script type="text/javascript">
                google.charts.load('current', {'packages':['corechart']});
                google.charts.setOnLoadCallback(drawChart);
                function drawChart() {

                var data = google.visualization.arrayToDataTable({!! $profiles_by_status !!});
                var pieOptions = {
                title: 'Per Status'
                };
                var chart = new google.visualization.PieChart(document.getElementById('profiles_by_status'));
                chart.draw(data, pieOptions);
                }
            </script>
            @endpush
    </div>

    <div class="row">

            <div class="col-md-6 col-lg-6">
                <div id="profiles_by_role" style="width: auto; height: 400px;"></div>
            </div>
            @push('googleCharts')
            <script type="text/javascript">
                google.charts.load('current', {'packages':['corechart']});
                google.charts.setOnLoadCallback(drawChart);
                function drawChart() {

                var data = google.visualization.arrayToDataTable({!! $profiles_by_role !!});
                var pieOptions = {
                title: 'Per Role'
                };
                var chart = new google.visualization.PieChart(document.getElementById('profiles_by_role'));
                chart.draw(data, pieOptions);
                }
            </script>
            @endpush

            <div class="col-md-6 col-lg-6">
                <div id="profiles_by_stage" style="width: auto; height: 400px;"></div>
            </div>
            @push('googleCharts')
            <script type="text/javascript">
                google.charts.load('current', {'packages':['corechart']});
                google.charts.setOnLoadCallback(drawChart);
                function drawChart() {

                var data = google.visualization.arrayToDataTable({!! $profiles_by_stage !!});
                var pieOptions = {
                title: 'Per Stage'
                };
                var chart = new google.visualization.PieChart(document.getElementById('profiles_by_stage'));
                chart.draw(data, pieOptions);
                }
            </script>
            @endpush
        </div>
</div>
@endsection
