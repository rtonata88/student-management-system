@extends('layouts.hwpl')

@section('content')
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">{{$sector->name}} / <small>REPORTS</small></h4> </div>
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
            <!-- .row -->
            <div class=" row white-box">
                <div class="panel panel-default" style=" border: 1px solid #ddd">
                    <div class="panel-heading" style="background-color: #f5f5f5;">
                        REPORT FILTER
                    </div>

                    <div class="panel-wrapper collapse in">
                        <div class="panel-body">

                            {!! Form::open(array('url' => array('/reports/periodic/filters', $sector->name), 'method' => 'post', 'class'=> 'form-vertical form-material', 'enctype="multipart/form-data"')) !!}

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{Form::label('team_id', 'Team')}}
                                        {{Form::select('team_id', $teams, null, ['class' => 'form-control select','placeholder'=>'All teams'])}}
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{Form::label('start_date', 'Date From:')}}
                                        {{Form::text('start_date', date('Y-m-01'), ['class' => 'form-control mydatepicker', 'placeholder' => 'Choose start date', 'autocomplete'=>'off'])}}
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{Form::label('end_date', 'Date To:')}}
                                        {{Form::text('end_date', date('Y-m-d'), ['class' => 'form-control mydatepicker', 'placeholder' => 'Choose end date', 'autocomplete'=>'off'])}}
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary"><span class="fa fa-filter"></span> FILTER</button>
                            @if(count($team_report) > 0 || count($media_coverage_report)>0 || count($events) > 0)
                            <a href="/reports/periodic/excel/{{$sector->name}}" class="btn btn-success"><span class="fa fa-file-excel-o"></span> EXPORT TO EXCEL</a>
                            @endif
                            <button type="reset" class="btn btn-warning"><span class="fa fa-ban"></span> Reset</button>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>

                @if(count($team_report) > 0 || count($media_coverage_report)>0 || count($events) > 0)
                <span class="box-title"><strong>SUMMARY</strong></span>

                <table class="table">
                    <thead>
                    <th>Team</th>
                    <th>Activity</th>
                    <th>Count</th>
                    </thead>

                    <tbody>
                        @if($team_report)
                        @foreach($team_report as $report)
                        <tr>
                            <td>{{$report->Team}}</td>
                            <td>{{$report->Activity}}</td>
                            <td>{{$report->Occurence}}</td>
                        </tr>
                        @endforeach
                        @endif

                        @if($media_coverage_report)
                        @foreach($media_coverage_report as $report)
                        <tr>
                            <td>{{$report->Team}}</td>
                            <td>{{$report->Activity}}</td>
                            <td>{{$report->Occurence}}</td>
                        </tr>
                        @endforeach
                        @endif

                        @if($events)

                        @foreach($events as $report)
                        <tr>
                            <td>{{$report->Team}}</td>
                            <td>{{$report->Activity}}</td>
                            <td>{{$report->Occurence}}</td>
                        </tr>
                        @endforeach
                        @endif

                    </tbody>
                </table>
                @else
                There are no activities that took place in the selected period.
                @endif
                <hr>
            </div>
            @if($team_report->where('Activity', 'Text Message (SMS)')->count() > 0)
            <div class="row white-box">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-uppercase mb-0"><strong>Text Message (SMS) REPORTS</strong></h5>
                        <hr>
                        @foreach($team_report->where('Activity', 'Text Message (SMS)') as $activity)

                        @if($activity)
                        <?php $activities = \App\ActivityTeamReport::get_activities($activity->sector_id, $activity->team_id, $activity->activity_type_id, $start_date, $end_date) ?>

                        @foreach($activities as $activity)
                        <p>
                            <strong>Who:</strong> {{$activity->fullname}} {{$activity->lastname}} <br>
                            <strong>Country:</strong> {{$activity->country}} <br>
                            <strong>Organization:</strong> {{$activity->organization}} <br>
                            <strong>Position:</strong> {{$activity->position}} <br>
                            <strong>Direction:</strong> {{$activity->direction}} <br>
                            <strong>Where:</strong> {{$activity->venue}} <br>
                            <strong>When:</strong> {{$activity->when}} <br>
                            <strong>Why:</strong>  <br>{{$activity->why}}<br> <br>
                            <strong>Outcome:</strong>  <br>{{$activity->outcome}}
                        </p>
                        <hr>
                        @endforeach

                        @endif  
                        @endforeach  
                    </div>
                </div>
            </div>
            @endif

            @if($team_report->where('Activity', 'Call')->count() > 0)
            <div class="row white-box">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-uppercase mb-0"><strong>CALL REPORTS</strong></h5>
                        <hr>
                        @foreach($team_report->where('Activity', 'Call') as $activity)

                        @if($activity)
                        <?php $activities = \App\ActivityTeamReport::get_activities($activity->sector_id, $activity->team_id, $activity->activity_type_id, $start_date, $end_date) ?>

                        @foreach($activities as $activity)
                        <p>
                            <strong>Who:</strong> {{$activity->fullname}} {{$activity->lastname}} <br>
                            <strong>Country:</strong> {{$activity->country}} <br>
                            <strong>Organization:</strong> {{$activity->organization}} <br>
                            <strong>Position:</strong> {{$activity->position}} <br>
                            <strong>Direction:</strong> {{$activity->direction}} <br>
                            <strong>Where:</strong> {{$activity->venue}} <br>
                            <strong>When:</strong> {{$activity->when}} <br>
                            <strong>Why:</strong>  <br>{{$activity->why}}<br> <br>
                            <strong>Outcome:</strong>  <br>{{$activity->outcome}}
                        </p>
                        <hr>
                        @endforeach

                        @endif  
                        @endforeach  
                    </div>
                </div>
            </div>
            @endif

            @if($team_report->where('Activity', 'Email')->count() > 0)
            <div class="row white-box">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-uppercase mb-0"><strong>EMAIL REPORTS</strong></h5>
                        <hr>
                        @forelse($team_report->where('Activity', 'Email') as $activity)
                        @if($activity)
                        <?php $activities = \App\ActivityTeamReport::get_activities($activity->sector_id, $activity->team_id, $activity->activity_type_id, $start_date, $end_date) ?>

                        @foreach($activities as $activity)
                        <p>
                            <strong>Who:</strong> {{$activity->fullname}} {{$activity->lastname}} <br>
                            <strong>Country:</strong> {{$activity->country}} <br>
                            <strong>Organization:</strong> {{$activity->organization}} <br>
                            <strong>Position:</strong> {{$activity->position}} <br>
                            <strong>Direction:</strong> {{$activity->direction}} <br>
                            <strong>Where:</strong> {{$activity->venue}} <br>
                            <strong>When:</strong> {{$activity->when}} <br>
                            <strong>Why:</strong>  <br>{{$activity->why}}<br> <br>
                            <strong>Outcome:</strong>  <br>{{$activity->outcome}}
                        </p>
                        <hr>
                        @endforeach

                        @endif  
                        @empty
                        No emails where sent or received during the selected period
                        @endforelse
                    </div>
                </div>
            </div>
            @endif

            @if($team_report->where('Activity', 'Meeting')->count() > 0)
            <div class="row white-box">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-uppercase mb-0"><strong>MEETING REPORTS</strong></h5>
                        <hr>
                        @foreach($team_report->where('Activity', 'Meeting') as $activity)

                        @if($activity)
                        <?php $activities = \App\ActivityTeamReport::get_activities($activity->sector_id, $activity->team_id, $activity->activity_type_id, $start_date, $end_date) ?>

                        @foreach($activities as $activity)
                        <p>
                            <strong>Who:</strong> {{$activity->fullname}} {{$activity->lastname}} <br>
                            <strong>Country:</strong> {{$activity->country}} <br>
                            <strong>Organization:</strong> {{$activity->organization}} <br>
                            <strong>Position:</strong> {{$activity->position}} <br>
                            <strong>Where:</strong> {{$activity->venue}} <br>
                            <strong>When:</strong> {{$activity->when}} <br>
                            <strong>Why:</strong>  <br>{{$activity->why}}<br> <br>
                            <strong>Outcome:</strong>  <br>{{$activity->outcome}}
                        </p>
                        <hr> 
                        @endforeach

                        @endif 
                        
                        @endforeach
                    </div>
                </div>
            </div>       
            @endif

            @if($media_coverage_report->count() > 0)
            <div class="row white-box">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-uppercase mb-0"><strong>MEDIA COVERAGES</strong></h5>
                        <hr>
                        @foreach($media_coverage_report as $activity)
                        @if($activity)
                        <?php $activities = \App\ActivityTeamReport::get_media_coverage($activity->sector_id, $activity->team_id, $start_date, $end_date) ?>

                        @foreach($activities as $activity)

                        <p>
                            <strong>Who:</strong> {{$activity->fullname}} {{$activity->lastname}} <br>
                            <strong>Organization:</strong> {{$activity->organization}} <br>
                            <strong>Position:</strong> {{$activity->position}} <br>
                            <strong>Publish Country:</strong> {{$activity->country}} ({{$activity->city}})<br>
                            <strong>Location:</strong> {{$activity->location}} <br>
                            <strong>Platform:</strong> {{$activity->platform}} <br>
                            <strong>URL:</strong> {{$activity->url}} <br>
                            <strong>When:</strong> {{$activity->when}} <br>
                            <strong>Title:</strong>  <br>{{$activity->title}}<br> <br>
                            <strong>Short Summary:</strong>  <br>{{$activity->short_summary}}
                        </p>
                         <hr>
                        @endforeach

                        @endif  
                       
                        @endforeach
                    </div>
                </div>
            </div>   
            @endif
            @if($events->count() > 0)
            <div class="row white-box">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-uppercase mb-0"><strong>EVENTS</strong></h5>
                        <hr>
                        @foreach($events as $activity1)
                        @if($activity1)
                        <?php $activities = \App\ActivityTeamReport::get_events($activity1->sector_id, $activity1->team_id, $start_date, $end_date) ?>

                        @foreach($activities as $activity)
                                    <p>
                                        <strong>What:</strong> {{$activity->name}} <br>
                                        <strong>Type:</strong> {{$activity->event_type}} <br>
                                        <strong>When:</strong> {{$activity->start_date}} <br>
                                        <strong>Team:</strong> {{$activity1->Team}} <br>
                                        <strong>Purpose:</strong>  <br>{{$activity->objectives}}<br> <br>
                                    </p>

                         <hr>
                        @endforeach

                        @endif  
                        @endforeach
                    </div>
                </div>
            </div>  
            @endif    
        </div>
    </div>
</div>
@endsection
