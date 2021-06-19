@extends('layouts.hwpl')

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

@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item">Reports</li>
    <li class="breadcrumb-item active">Periodic </li>
    <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection
@section('content')
<div class="row">
    <div class="col-md-12 col-xs-12">
        <div class="card">
            <div class="card-header">
                <strong>Sector activities</strong> 
            </div>
            <div class="card-body">
                <div id="columnchart_material" style="width: auto; height: 400px;"></div>
                <br>
                <strong>Data</strong>
                <table class="table table-responsive-sm table-bordered table-striped table-sm" style="width:100%">
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
            </div>
        </div>
    </div>
</div>
@endsection