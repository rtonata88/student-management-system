@extends('layouts.app')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item">Reports</li>
    <li class="breadcrumb-item">Periodic report </li>
    <li class="breadcrumb-item active">{{$sector->name}} </li>
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
                {!! Form::open(array('url' => array('/reports/periodic/filters', $sector->name), 'method' => 'post', 'class'=> 'form-vertical form-material', 'enctype="multipart/form-data"')) !!}

                        <div class="form-group">
                            {{Form::label('team_id', 'Team')}}
                            {{Form::select('team_id', $teams, null, ['class' => 'form-control select','placeholder'=>'All teams'])}}
                        </div>
                        <div class="form-group">
                            {{Form::label('start_date', 'Date From:')}}
                            {{Form::date('start_date', date('Y-m-01'), ['class' => 'form-control mydatepicker', 'placeholder' => 'Choose start date', 'autocomplete'=>'off'])}}
                        </div>

                        <div class="form-group">
                            {{Form::label('end_date', 'Date To:')}}
                            {{Form::date('end_date', date('Y-m-d'), ['class' => 'form-control mydatepicker', 'placeholder' => 'Choose end date', 'autocomplete'=>'off'])}}
                        </div>
                <button type="submit" class="btn btn-success btn-sm"> Search</button>
                <button type="reset" class="btn btn-sm">Reset</button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <div class="col-md-8 col-xs-12">
        <div class="card">
            <div class="card-header">
                <strong>Summary</strong>
                <hr>
                @if(count($team_report) > 0 || count($media_coverage_report)>0 || count($events) > 0)
                <a href="/reports/periodic/excel/{{$sector->name}}" class="btn btn-primary btn-sm"> Export to excel</a>
                @endif
            </div>
            <div class="card-body">

                @if(count($team_report) > 0 || count($media_coverage_report)>0 || count($events) > 0)
                <table class="table table-responsive-sm table-bordered table-striped table-sm" style="width:100%">
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
        </div>
        @if($events->count() > 0)
        <div class="card">
            <div class="card-header">
                <strong>Event reports</strong> 
            </div>
            <div class="card-body">
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
    @endif

    @if($team_report->where('Activity', 'Text Message (SMS)')->count() > 0)
        <div class="card">
            <div class="card-header">
                <strong>Text Message (SMS) Reports</strong> 
            </div>
            <div class="card-body">
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
    @endif

    @if($team_report->where('Activity', 'Call')->count() > 0)
        <div class="card">
            <div class="card-header">
                <strong>Call Reports</strong> 
            </div>
            <div class="card-body">
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
    @endif
    @if($team_report->where('Activity', 'Email')->count() > 0)
        <div class="card">
            <div class="card-header">
                <strong>Email Reports</strong> 
            </div>
            <div class="card-body">
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
    @endif

    @if($team_report->where('Activity', 'Meeting')->count() > 0)
        <div class="card">
            <div class="card-header">
                <strong>Meeting Reports</strong> 
            </div>
            <div class="card-body">
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
    @endif

    @if($media_coverage_report->count() > 0)
        <div class="card">
            <div class="card-header">
                <strong>Media coverage reports</strong> 
            </div>
            <div class="card-body">
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
    @endif   
</div>
@endsection
