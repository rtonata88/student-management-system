@extends('layouts.print')

@section('content')
<div class="container-fluid">
    <!-- Column -->
    <div class="col-lg-12 white-box">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title"><strong>{{$profile->fullname}} {{$profile->lastname}}</strong></h3>
                <h6 class="card-subtitle">{{$profile->sector->name}} | <i>{{$profile->team->name}}</i></h6>
                <div class="row">
                    <table class="table table-bordered" width="100%" style="font-size: 10px">
                        <tr>
                            <td rowspan="6">
                                @if($profile->photo)
                                    <img width="300" height="300" alt="user" src="/fruit_profiles/photos/{{$profile->photo}}" class="img-responsive" >
                                @else
                                    <center>
                                        <img  alt="user" src="/fruit_profiles/photos/no-image.png" class="img-responsive">
                                    </center>
                                @endif
                            </td>
                            <td style="background-color: #eaebed"><strong>Country</strong></td>
                            <td> {{$profile->country->name}} </td>

                            <td style="background-color: #eaebed"><strong>Fruit Level</strong></td>
                            <td> {{$profile->fruit_level->level}} </td>

                        </tr>
                        <tr>
                            <td style="background-color: #eaebed"><strong>City</strong></td>
                            <td> {{$profile->city->name}} </td>

                            <td style="background-color: #eaebed"><strong>Organization</strong></td>
                            <td>
                                @if($profile->organization_profile()->first())
                                    {{$profile->organization_profile()->first()->organization->name}}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td style="background-color: #eaebed"><strong>Gender</strong></td>
                            <td>{{$profile->gender->gender}}</td>

                            <td style="background-color: #eaebed"><strong>Position</strong></td>
                            <td>
                                @if($profile->organization_profile()->first())
                                    {{$profile->organization_profile()->first()->organization->position}}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td style="background-color: #eaebed"><strong>Date Networked</strong></td>
                            <td> {{$profile->date_networked}} </td>

                            <td style="background-color: #eaebed"><strong>Work Number</strong></td>
                            <td>
                                @if($profile->organization_profile()->first())
                                    {{$profile->organization_profile()->first()->organization->work_number}}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td style="background-color: #eaebed"><strong>Appointed Role</strong></td>
                            <td> {{ @$profile->fruit_role->role}} </td>

                            <td style="background-color: #eaebed"><strong>Work Email</strong></td>
                            <td>
                                @if($profile->organization_profile()->first())
                                    {{$profile->organization_profile()->first()->organization->email}}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td style="background-color: #eaebed"><strong>Fruit Stage</strong></td>
                            <td> {{ @$profile->fruit_stage->stage}} </td>

                            <td style="background-color: #eaebed"><strong>Maintainer</strong></td>
                            <td> {{$profile->maintainer->name}} </td>
                        </tr>
                        <tr>
                            <td colspan="5"><strong>Bio: </strong>{{$profile->bio}}</td>
                        </tr>
                        <tr>
                            <td colspan="5"><strong>History: </strong>{{$profile->history}}</td>
                        </tr>
                    </table>
                    <h3 class="card-title"><strong>Most recent activities</strong></h3>
                    <table class="table table-bordered" width="100%" style="font-size: 10px">
                        @forelse($profile->activities->take(5) as $activity)
                        <tr>
                            <td colspan="2"><h5><strong>{{$activity->activity_type->name}} Report</strong></h5></td>
                        </tr>
                        @if($activity->activity_type->name != "Meeting")
                        <tr>
                            <td style="background-color: #eaebed"><strong>Direction</strong></td>
                            <td>{{$activity->direction}}</td>
                        </tr>
                        @endif
                         <tr>
                            <td style="background-color: #eaebed"><strong>Where</strong></td>
                            <td>{{$activity->venue}}</td>
                        </tr>
                         <tr>
                            <td style="background-color: #eaebed"><strong>When</strong></td>
                            <td>{{$activity->when}}</td>
                        </tr>
                         <tr>
                            <td style="background-color: #eaebed"><strong>Why</strong></td>
                            <td>{{$activity->why}}</td>
                        </tr>
                        <tr>
                            <td style="background-color: #eaebed"><strong>Outcome</strong></td>
                            <td>{{$activity->outcome}}</td>
                        </tr>
                        <tr>
                            <td style="background-color: #eaebed"><strong>Photos</strong></td>
                            <td>
                                @if($activity->photos)
                                <table>
                                    <tr>
                                        @foreach($activity->photos as $photo)
                                        <td style="width: 100px;">
                                            <img src="{{ asset('storage/'.$photo->path) }}" alt="user" />
                                        </td>
                                        @endforeach
                                    </tr>
                                </table>
                                @endif
                            </td>
                        </tr>
                        @empty
                        No activities recorded for this profile
                        @endforelse
                    </table>

                    <h3 class="card-title"><strong>Most recent events</strong></h3>
                    <table class="table table-bordered" width="100%" style="font-size: 10px">
                        @forelse($profile->events->take(5) as $event)
                        <tr>
                            <td colspan="2"><h5><strong>{{$event->name}} : <i>{{$event->theme}}</i></strong></h5></td>
                        </tr>
                        <tr>
                            <td style="background-color: #eaebed"><strong>Event Type</strong></td>
                            <td>{{$event->event_type}}</td>
                        </tr>
                         <tr>
                            <td style="background-color: #eaebed"><strong>Start Date</strong></td>
                            <td>{{$event->start_date}} {{$event->start_time}}</td>
                        </tr>
                         <tr>
                            <td style="background-color: #eaebed"><strong>End Date</strong></td>
                            <td>{{$event->end_date}} {{$event->end_time}}</td>
                        </tr>
                         <tr>
                            <td style="background-color: #eaebed"><strong>Where</strong></td>
                            <td>{{$event->address_line1}} <br>
                                {{$event->address_line2}}

                            </td>
                        </tr>
                        <tr>
                            <td style="background-color: #eaebed"><strong>Description</strong></td>
                            <td>{{$event->description}}</td>
                        </tr>
                        @empty
                        No events recorded for this profile
                        @endforelse
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Column -->
@endsection
