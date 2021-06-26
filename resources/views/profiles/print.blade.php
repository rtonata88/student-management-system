@extends('layouts.print')

@section('content')

    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <strong>{{$profile->fullname}} {{$profile->lastname}}</strong> <br><small>{{$profile->sector->name}} | <i>{{$profile->team->name}}</i></small>
                
            </div>
            <div class="card-body">
                <div class="row">
                     <table class="table table-bordered table-sm table-responsive-sm" style="font-size: 12px;">
                                    <tbody>
                                    <tr>
                                        <td style="background-color: rgba(227, 227, 227, 0.5); width: 150px;"><strong>Firstname</strong></td>
                                        <td> @foreach($profile->title as $title) {{$title->title}} @endforeach {{$profile->fullname}} {{$profile->lastname}}</td>
                                    </tr>
                                    <tr>
                                        <td style="background-color: rgba(227, 227, 227, 0.5)"><strong>Gender</strong></td>
                                        <td> {{$profile->gender->gender}} </td>
                                    </tr>
                                    <tr>
                                        <td style="background-color: rgba(227, 227, 227, 0.5)"><strong>Date of Birth</strong></td>
                                        <td> {{$profile->dob}} </td>
                                    </tr>
                                    @if($profile->bio)
                                    <tr>
                                        <td style="background-color: rgba(227, 227, 227, 0.5)" ><strong>Bio</strong></td>
                                        <td> {{$profile->bio}} </td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <td style="background-color: rgba(227, 227, 227, 0.5)"><strong>Country</strong></td>
                                        <td> {{$profile->country->name}} </td>
                                    </tr>
                                    <tr>
                                        <td style="background-color: rgba(227, 227, 227, 0.5)"><strong>City</strong></td>
                                        <td> {{$profile->city->name}} </td>
                                    </tr>
                                        <tr>
                                            <td style="background-color: rgba(227, 227, 227, 0.5)"><strong>Languages</strong></td>
                                            <td>@foreach($profile->language as $language)
                                                    {{$language->name}}.
                                                @endforeach
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="background-color: rgba(227, 227, 227, 0.5)"><strong>Responsible Staff</strong></td>
                                            <td>{{$profile->maintainer->name}}</td>
                                        </tr>
                                         <tr>
                                        <td style="background-color: rgba(227, 227, 227, 0.5)"><strong>Platform (Media only)</strong></td>
                                        <td> {{$profile->platform}} </td>
                                    </tr>
                                    <tr>
                                        <td style="background-color: rgba(227, 227, 227, 0.5)"><strong>History</strong></td>
                                        <td> {{$profile->history}} </td>
                                    </tr>
                                    <tr>
                                            <th style="background-color: rgba(227, 227, 227, 0.5); width: 50px;">Sector</th>
                                            <td> {{$profile->sector->name}}</td>
                                        </tr>
                                        <tr>
                                            <th style="background-color: rgba(227, 227, 227, 0.5)" >Team</th>
                                            <td> {{$profile->team->name}} </td>
                                        </tr>
                                        <tr>
                                            <th style="background-color: rgba(227, 227, 227, 0.5)" >Appointed Role</th>
                                            <td> {{ $profile->fruit_role->role}} </td>
                                        </tr>
                                        <tr>
                                            <th style="background-color: rgba(227, 227, 227, 0.5)" >Level</th>
                                            <td> {{ $profile->fruit_stage->stage}} </td>
                                        </tr>
                                        <tr>
                                            <th style="background-color: rgba(227, 227, 227, 0.5)" >Rank</th>
                                            <td> {{$profile->fruit_level->level}} </td>
                                        </tr>
                                        <tr>
                                            <th style="background-color: rgba(227, 227, 227, 0.5)" >Cult Awareness</th>
                                            <td> {{$profile->cult_awareness}} </td>
                                        </tr>
                                        <tr>
                                            <th style="background-color: rgba(227, 227, 227, 0.5)" >Pre-Poisoned</th>
                                            <td> {{$profile->pre_poisoned}} </td>
                                        </tr>
                                        <tr>
                                            <th style="background-color: rgba(227, 227, 227, 0.5)" >WARP Attendee</th>
                                            <td> {{$profile->warp_attendee}} </td>
                                        </tr>
                                        <tr>
                                            <th style="background-color: rgba(227, 227, 227, 0.5)" >Religion</th>
                                            <td> {{$profile->religion->name}} </td>
                                        </tr>
                                    <tr>
                                        <td style="background-color: rgba(227, 227, 227, 0.5)"><strong>Mobile</strong></td>
                                            <td> {{$profile->mobile_no}} <br>
                                                {{$profile->mobile_no2}} <br> 
                                                {{$profile->mobile_no_other}} 
                                                </td>
                                        </tr>
                                        <tr>
                                            <td style="background-color: rgba(227, 227, 227, 0.5)"><strong>Email</strong></td>
                                            <td> {{$profile->email}} <br>
                                                {{$profile->email2}} 
                                            </td>
                                        </tr>
                                        <tr>
                                            <th colspan="2"></th>
                                        </tr>
                                        <tr>
                                            <th style="background-color: rgba(227, 227, 227, 0.5)" colspan="2">Organisation information</th>
                                        </tr>
                                        @foreach($profile->organization_profile as $index=>$organization)
                                        <tr>
                                            <td style="background-color: rgba(227, 227, 227, 0.5)" colspan="2"><strong>{{$organization->organization->name}}</strong></td>
                                        </tr>
                                        <tr>
                                            <td style="background-color: rgba(227, 227, 227, 0.5)" ><strong>Position</strong></td>
                                            <td> {{$organization->position}} </td>
                                        </tr>
                                        <tr>
                                            <td style="background-color: rgba(227, 227, 227, 0.5)" ><strong>Department</strong></td>
                                            <td> {{$organization->department}} </td>
                                        </tr>
                                        <tr>
                                            <td style="background-color: rgba(227, 227, 227, 0.5)" ><strong>Website</strong></td>
                                            <td> <a href="http://{{$organization->organization->website}}" target="_blank">{{$organization->organization->website}}</a> </td>
                                        </tr>
                                        <tr>
                                            <td style="background-color: rgba(227, 227, 227, 0.5)" ><strong>Number</strong></td>
                                            <td> {{$organization->work_number}} <br>
                                            {{$organization->work_number2}} <br>
                                            {{$organization->work_number_other}} </td>
                                        </tr>
                                        <tr>
                                            <td style="background-color: rgba(227, 227, 227, 0.5)" ><strong>Email</strong></td>
                                            <td> {{$organization->email}} <br>
                                            {{$organization->email2}} <br>
                                            {{$organization->email_other}} </td>
                                        </tr>
                                        <tr>
                                            <th colspan="2"></th>
                                        </tr>
                                        @endforeach
                                        <tr>
                                            <th style="background-color: rgba(227, 227, 227, 0.5)" colspan="2">Assistant information</th>
                                        </tr>
                                        @foreach($profile->profile_assistant as $index=>$assistant)
                                            <tr>
                                                <th style="background-color: rgba(227, 227, 227, 0.5)" colspan="2" >{{$assistant->assistant_name}}</th>
                                            </tr>
                                            <tr>
                                                <th style="background-color: rgba(227, 227, 227, 0.5)" >Email</th>
                                                <td>
                                                    <strong>P</strong>: {{$assistant->assistant_email1}} <br>
                                                    <strong>S</strong>: {{$assistant->assistant_email2}} <br>
                                                    <strong>O</strong>: {{$assistant->assistant_email3}} <br>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th style="background-color: rgba(227, 227, 227, 0.5)" >Number</th>
                                                <td>
                                                    <strong>P</strong>: {{$assistant->assistant_number1}} <br>
                                                    <strong>S</strong>: {{$assistant->assistant_number2}} <br>
                                                    <strong>O</strong>: {{$assistant->assistant_number3}} <br>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th colspan="2"></th>
                                            </tr>
                                        @endforeach
                                    </div>
                                    </tbody>
                                </table>
                    <p style="page-break-after: always;">&nbsp;</p>

                    <h3 class="card-title"><strong>Most recent activities</strong></h3>
                    <table class="table table-bordered table-sm table-responsive-sm" style="font-size: 12px;">
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
                    <table class="table table-bordered table-sm table-responsive-sm" style="font-size: 12px;">
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
