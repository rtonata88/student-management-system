@extends('layouts.hwpl')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item active">Dashboard</li>
    <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection
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
<div class="row">
    <div class="col-sm-12">
        <div class="row">
            <div class="col-3">
                <div class="c-callout c-callout-info"><small class="text-muted">HWPL Activities</small>
                    <div class="text-value-lg">
                    @if(!empty($sectors->where('name', 'HWPL')->first()))
                        {{$sectors->where('name', 'HWPL')->first()->count}}
                    @else
                    0
                    @endif            
                    </div>
                </div>
            </div>
            <!-- /.col-->
            <div class="col-3">
                <div class="c-callout c-callout-primary"><small class="text-muted">IPYG Activities</small>
                    <div class="text-value-lg">
                        @if(!empty($sectors->where('name', 'IPYG')->first()))
                            {{$sectors->where('name', 'IPYG')->first()->count}}
                        @else
                            0
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="c-callout c-callout-warning"><small class="text-muted">IWPG Activities</small>
                    <div class="text-value-lg">
                        @if(!empty($sectors->where('name', 'IWPG')->first()))
                            {{$sectors->where('name', 'IWPG')->first()->count}}
                        @else
                            0
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="c-callout c-callout-danger"><small class="text-muted">PROFILES Count</small>
                    <div class="text-value-lg">
                        {{count($profiles)}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="col-12">
                    <div>
                        <h4 class="card-title mb-0">Sector Activities</h4>
                        @if(Auth::user()->hasRole('Reports'))
                            <div class="small text-muted"><a href="/reports/periodic">See full report</a></div>
                        @endif
                    </div>
                    <div id="columnchart_material" style="width: auto; height: 400px;"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-12 col-md-4">
        <div class="card">
            <div class="card-body">
                    <div>
                    @push('googleCharts')
                        <script type="text/javascript">
                        google.charts.load('current', {'packages':['bar']});
                        google.charts.setOnLoadCallback(drawChart);
                        function drawChart() {
                            var data = google.visualization.arrayToDataTable({!! $email_activities !!});
                            var options = {
                                    chart: {
                                    title: 'Emails',
                                }
                            };
                            var chart = new google.charts.Bar(document.getElementById('emails_graph'));
                            chart.draw(data, google.charts.Bar.convertOptions(options));
                        }
                        </script>
                    @endpush
                    </div>
                    <div id="emails_graph" style="width: auto; height: 400px;"></div>
            </div>
        </div>
    </div>  
         <div class="col-sm-12 col-md-4">
        <div class="card">
            <div class="card-body">
                    <div>
                        @push('googleCharts')
                        <script type="text/javascript">
                        google.charts.load('current', {'packages':['bar']});
                        google.charts.setOnLoadCallback(drawChart);
                        function drawChart() {
                            var data = google.visualization.arrayToDataTable({!! $call_activities !!});
                            var options = {
                                chart: {
                                    title: 'Calls',
                                    }
                                };
                            var chart = new google.charts.Bar(document.getElementById('calls_graph'));
                            chart.draw(data, google.charts.Bar.convertOptions(options));
                        }
                        </script>
                        @endpush
                    </div>
                    <div id="calls_graph" style="width: auto; height: 400px;"></div>
            </div>
        </div>
    </div> 

     <div class="col-sm-12 col-md-4">
        <div class="card">
            <div class="card-body">
                    <div>
                        @push('googleCharts')
                        <script type="text/javascript">
                        google.charts.load('current', {'packages':['bar']});
                        google.charts.setOnLoadCallback(drawChart);
                        function drawChart() {
                            var data = google.visualization.arrayToDataTable({!! $meeting_activities !!});
                            var options = {
                                chart: {
                                    title: 'Meetings',
                                }
                            };
                            var chart = new google.charts.Bar(document.getElementById('meetings_graph'));
                            chart.draw(data, google.charts.Bar.convertOptions(options));
                        }
                        </script>
                        @endpush
                    </div>
                    <div id="meetings_graph" style="width: auto; height: 400px;"></div>
            </div>
        </div>
    </div>  
    <div class="col-sm-12 col-md-4">
        <div class="card">
            <div class="card-body">
                    <div>
                    @push('googleCharts')
                    <script type="text/javascript">
                    google.charts.load('current', {'packages':['bar']});
                    google.charts.setOnLoadCallback(drawChart);
                    function drawChart() {
                        var data = google.visualization.arrayToDataTable({!! $message_activities !!});
                        var options = {
                        chart: {
                                title: 'Messages',
                            }
                        };
                        var chart = new google.charts.Bar(document.getElementById('messages_graph'));
                        chart.draw(data, google.charts.Bar.convertOptions(options));
                    }
                    </script>
                    @endpush
                    </div>
                    <div id="messages_graph" style="width: auto; height: 400px;"></div>
                </div>
        </div>
    </div>  

    <div class="col-sm-12 col-md-4">
        <div class="card">
            <div class="card-body">
                    <div>
                    @push('googleCharts')
                    <script type="text/javascript">
                    google.charts.load('current', {'packages':['bar']});
                    google.charts.setOnLoadCallback(drawChart);
                    function drawChart() {
                        var data = google.visualization.arrayToDataTable({!! $internal_events_by_team !!});
                        var options = {
                        chart: {
                            title: 'Events Hosted',
                            }
                        };
                        var chart = new google.charts.Bar(document.getElementById('events_hosted_graph'));
                        chart.draw(data, google.charts.Bar.convertOptions(options));
                    }
                    </script>
                    @endpush
                    </div>
                    <div id="events_hosted_graph" style="width: auto; height: 400px;"></div>
                </div>
        </div>
    </div>  

    <div class="col-sm-12 col-md-4">
        <div class="card">
            <div class="card-body">
                    <div>
                    @push('googleCharts')
                    <script type="text/javascript">
                    google.charts.load('current', {'packages':['bar']});
                    google.charts.setOnLoadCallback(drawChart);
                    function drawChart() {
                        var data = google.visualization.arrayToDataTable({!! $external_events_by_team !!});
                        var options = {
                        chart: {
                            title: 'Events Attended',
                            }
                        };
                        var chart = new google.charts.Bar(document.getElementById('events_attended_graph'));
                        chart.draw(data, google.charts.Bar.convertOptions(options));
                    }
                    </script>
                    @endpush
                    </div>
                    <div id="events_attended_graph" style="width: auto; height: 400px;"></div>
                </div>
        </div>
    </div>  


    <div class="col-sm-12 col-md-6">
        <div class="card">
            <div class="card-body">
                    <div>
                    @push('googleCharts')
                    <script type="text/javascript">
                        google.charts.load('current', {'packages':['corechart']});
                        google.charts.setOnLoadCallback(drawChart);
                        function drawChart() {

                        var data = google.visualization.arrayToDataTable({!! $profiles_by_country !!});
                        var pieOptions = {
                        };
                        var chart = new google.visualization.PieChart(document.getElementById('profiles_by_country'));
                        chart.draw(data, pieOptions);
                        }
                    </script>
                    @endpush
                    <h4 class="card-title mb-0">Profiles <small>by status</small></h4>
                    </div>
                    <div id="profiles_by_country" style="width: auto; height: 400px;"></div>
                </div>
        </div>
    </div>  

    <div class="col-sm-12 col-md-6">
        <div class="card">
            <div class="card-body">
                    <div>
                     @push('googleCharts')
                    <script type="text/javascript">
                        google.charts.load('current', {'packages':['corechart']});
                        google.charts.setOnLoadCallback(drawChart);
                        function drawChart() {

                        var data = google.visualization.arrayToDataTable({!! $profiles_by_status !!});
                        var pieOptions = {
                        };
                        var chart = new google.visualization.PieChart(document.getElementById('profiles_by_status'));
                        chart.draw(data, pieOptions);
                        }
                    </script>
                    @endpush
                    <h4 class="card-title mb-0">Profiles <small>by status</small></h4>
                    </div>
                    <div id="profiles_by_status" style="width: auto; height: 400px;"></div>
                </div>
        </div>
    </div>

     <div class="col-sm-12 col-md-6">
        <div class="card">
            <div class="card-body">
                    <div>
                     @push('googleCharts')
                    <script type="text/javascript">
                        google.charts.load('current', {'packages':['corechart']});
                        google.charts.setOnLoadCallback(drawChart);
                        function drawChart() {
                            var data = google.visualization.arrayToDataTable({!! $profiles_by_stage !!});
                            var pieOptions = {
                            };
                            var chart = new google.visualization.PieChart(document.getElementById('profiles_by_stage'));
                            chart.draw(data, pieOptions);
                        }
                    </script>
                    @endpush
                    <h4 class="card-title mb-0">Profiles <small>by stage</small></h4>
                    </div>
                    <div id="profiles_by_stage" style="width: auto; height: 400px;"></div>
                </div>
        </div>
    </div>

    <div class="col-sm-12 col-md-6">
        <div class="card">
            <div class="card-body">
                    <div>
                     @push('googleCharts')
                    <script type="text/javascript">
                        google.charts.load('current', {'packages':['corechart']});
                        google.charts.setOnLoadCallback(drawChart);
                        function drawChart() {

                        var data = google.visualization.arrayToDataTable({!! $profiles_by_role !!});
                        var pieOptions = {
                        };
                        var chart = new google.visualization.PieChart(document.getElementById('profiles_by_role'));
                        chart.draw(data, pieOptions);
                        }
                    </script>
                    @endpush
                    <h4 class="card-title mb-0">Profiles <small>by role</small></h4>
                    </div>
                    <div id="profiles_by_role" style="width: auto; height: 400px;"></div>
                </div>
        </div>
    </div>
@endsection
