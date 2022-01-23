@extends('layouts.app')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item">Reports</li>
    <li class="breadcrumb-item active">Periodic Profiles </li>
    <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection
@section('content')
<div class="row">
<div class="col-md-4 col-xs-12">
        <div class="card">
            <div class="card-header">
                <strong>Report filter</strong> 
            </div>
            <div class="card-body">
                {!! Form::open(array('route' => array('periodic.reports.filter'), 'method' => 'post', 'class'=> 'form-vertical form-material', 'enctype="multipart/form-data"')) !!}
                    <div class="form-group">
                    <strong>{{Form::label('date_from', 'From date')}}</strong>
                    {{Form::date('date_from', $date_from, ['class' => 'form-control form-control-sm'])}}
                    </div>
                    <div class="form-group">
                    <strong>{{Form::label('date_to', 'To date')}}</strong>
                    {{Form::date('date_to', $date_to, ['class' => 'form-control form-control-sm'])}}
                    </div>

                    <div class="form-group">
                        {{Form::select('team', $teams, $teams, ['class' => 'form-control select', 'placeholder'=>'All teams'])}}
                    </div>
                  
                    <button type="submit" class="btn btn-sm btn-success">
                        Search
                    </button>
                    <a href="/reports/periodic" class="btn btn-sm">
                        Clear
                    </a>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <div class="col-md-8 col-xs-12">
        <div class="card">
            <div class="card-header">
                <strong>Report Summary</strong> 
                <div class="pull-right">
                     @if(count($summary_report) > 0 || count($media_coverage_report)>0 || count($events) > 0)
                        <a href="/reports/periodic/excel" class="btn btn-primary btn-sm"> Export to excel</a>
                    @endif
                </div>
            </div>
            <div class="card-body">
                @if(count($summary_report) > 0)
                <table class="table table-responsive-sm table-bordered table-sm" style="width:100%">
                    <thead>
                        <th>Team</th>
                        <th>Report type</th>
                        <th>Count</th>
                    </thead>
                    <tbody>
                        @if($summary_report)
                            @foreach($summary_report as $key=>$report)                                
                                <tr>
                                    <td>{{$report['team']}}</td>
                                    <td>{{$report['report_type']}}</td>
                                    <td>{{$report['count']}}</td> 
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                @else
                    There are no activities that took place in the selected period.
                @endif
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <strong>Meeting reports 
                <span class="badge badge-primary">
                    {{$summary_report->where('report_type', 'Meeting')->sum('count')}}
                </span></strong> 
            </div>
            <div class="card-body">
                @if(count($team_report_detail->where('activity_type_name', 'Meeting')) > 0)
                @foreach($team_report_detail->where('activity_type_name', 'Meeting') as $report)                                
                <table class="table table-responsive-sm table-bordered table-sm" style="width:100%">
                        <tr>
                            <th style="background-color: rgba(227, 227, 227, 0.5)" width="150px">Who</th>
                            <td>
                            
                                @foreach($profiles->where('activity_id', $report->activity_id) as $profile)
                                    {{$profile->fullname}} {{$profile->lastname}} <br>
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <th style="background-color: rgba(227, 227, 227, 0.5)" width="150px">Team</th>
                            <td>{{$report->team_name}}</td>
                        </tr>
                        <tr>
                            <th style="background-color: rgba(227, 227, 227, 0.5)" width="150px">Meeting type</th>
                            <td>{{$report->meeting_type}}</td>
                        </tr>
                        <tr>
                            <th style="background-color: rgba(227, 227, 227, 0.5)" >Venue</th>
                            <td>{{$report->venue}}</td>
                        </tr>
                        <tr>
                            <th style="background-color: rgba(227, 227, 227, 0.5)" >When</th>
                            <td>{{$report->when}} {{$report->time}}</td>
                        </tr>
                        <tr>
                            <th style="background-color: rgba(227, 227, 227, 0.5)" >Why</th>
                            <td>{{$report->why}}</td>
                        </tr>
                        <tr>
                            <th style="background-color: rgba(227, 227, 227, 0.5)" >Outcome</th>
                            <td>{{$report->outcome}}</td>
                        </tr>
                </table>
                @endforeach
                @else
                    There are no meetings that took place between the selected period.
                @endif
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <strong>Call reports
                <span class="badge badge-primary">
                    {{$summary_report->where('report_type', 'Call')->sum('count')}}
                </span>
                </strong> 
            </div>
            <div class="card-body">
                @if(count($team_report_detail->where('activity_type_name', 'Call')) > 0)
                @foreach($team_report_detail->where('activity_type_name', 'Call') as $report)                                
                <table class="table table-responsive-sm table-bordered table-sm" style="width:100%">
                         <tr>
                            <th style="background-color: rgba(227, 227, 227, 0.5)" width="150px">Who</th>
                            <td>
                            
                                @foreach($profiles->where('activity_id', $report->activity_id) as $profile)
                                    {{$profile->fullname}} {{$profile->lastname}} <br>
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <th style="background-color: rgba(227, 227, 227, 0.5)" width="150px">Team</th>
                            <td>{{$report->team_name}}</td>
                        </tr>
                        <tr>
                            <th style="background-color: rgba(227, 227, 227, 0.5)" width="150px">Direction</th>
                            <td>{{$report->direction}}</td>
                        </tr>
                        <tr>
                            <th style="background-color: rgba(227, 227, 227, 0.5)" >When</th>
                            <td>{{$report->when}} {{$report->time}}</td>
                        </tr>
                        <tr>
                            <th style="background-color: rgba(227, 227, 227, 0.5)" >Why</th>
                            <td>{{$report->why}}</td>
                        </tr>
                        <tr>
                            <th style="background-color: rgba(227, 227, 227, 0.5)" >Outcome</th>
                            <td>{{$report->outcome}}</td>
                        </tr>
                </table>
                @endforeach
                @else
                    There are no calls that took place between the selected period.
                @endif
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <strong>Email reports
                    <span class="badge badge-primary">
                    {{$summary_report->where('report_type', 'Email')->sum('count')}}
                </span>
                </strong> 
            </div>
            <div class="card-body">
                @if(count($team_report_detail->where('activity_type_name', 'Email')) > 0)
                @foreach($team_report_detail->where('activity_type_name', 'Email') as $report)                                
                <table class="table table-responsive-sm table-bordered table-sm" style="width:100%">
                        <tr>
                            <th style="background-color: rgba(227, 227, 227, 0.5)" width="150px">Who</th>
                            <td>
                            
                                @foreach($profiles->where('activity_id', $report->activity_id) as $profile)
                                    {{$profile->fullname}} {{$profile->lastname}} <br>
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <th style="background-color: rgba(227, 227, 227, 0.5)" width="150px">Team</th>
                            <td>{{$report->team_name}}</td>
                        </tr>
                        <tr>
                            <th style="background-color: rgba(227, 227, 227, 0.5)" width="150px">Direction</th>
                            <td>{{$report->direction}}</td>
                        </tr>
                        <tr>
                            <th style="background-color: rgba(227, 227, 227, 0.5)" >When</th>
                            <td>{{$report->when}} {{$report->time}}</td>
                        </tr>
                        <tr>
                            <th style="background-color: rgba(227, 227, 227, 0.5)" >Why</th>
                            <td>{{$report->why}}</td>
                        </tr>
                        <tr>
                            <th style="background-color: rgba(227, 227, 227, 0.5)" >Outcome</th>
                            <td>{{$report->outcome}}</td>
                        </tr>
                </table>
                @endforeach
                @else
                    There are no calls that took place between the selected period.
                @endif
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <strong>Text message reports
                <span class="badge badge-primary">
                    {{$summary_report->where('report_type', 'TextMessage')->sum('count')}}
                </span>
                </strong> 
            </div>
            <div class="card-body">
                 @if(count($team_report_detail->where('activity_type_name', 'TextMessage')) > 0)
                @foreach($team_report_detail->where('activity_type_name', 'TextMessage') as $report)                                
                <table class="table table-responsive-sm table-bordered table-sm" style="width:100%">
                         <tr>
                            <th style="background-color: rgba(227, 227, 227, 0.5)" width="150px">Who</th>
                            <td>
                            
                                @foreach($profiles->where('activity_id', $report->activity_id) as $profile)
                                    {{$profile->fullname}} {{$profile->lastname}} <br>
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <th style="background-color: rgba(227, 227, 227, 0.5)" width="150px">Team</th>
                            <td>{{$report->team_name}}</td>
                        </tr>
                        <tr>
                            <th style="background-color: rgba(227, 227, 227, 0.5)" width="150px">Direction</th>
                            <td>{{$report->direction}}</td>
                        </tr>
                        <tr>
                            <th style="background-color: rgba(227, 227, 227, 0.5)" >When</th>
                            <td>{{$report->when}} {{$report->time}}</td>
                        </tr>
                        <tr>
                            <th style="background-color: rgba(227, 227, 227, 0.5)" >Why</th>
                            <td>{{$report->why}}</td>
                        </tr>
                        <tr>
                            <th style="background-color: rgba(227, 227, 227, 0.5)" >Outcome</th>
                            <td>{{$report->outcome}}</td>
                        </tr>
                </table>
                @endforeach
                @else
                    There are no calls that took place between the selected period.
                @endif
            </div>
        </div>
        <!-- <div class="card">
            <div class="card-header">
                <strong>Media coverage reports</strong> 
            </div>
            <div class="card-body">
                goes here
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <strong>Event reports</strong> 
            </div>
            <div class="card-body">
                goes here
            </div>
        </div> -->
    </div>
</div>
@endsection