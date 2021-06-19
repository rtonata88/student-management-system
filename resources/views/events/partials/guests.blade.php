@include('events.partials.modals.guest-modals')
<div class="card">
    <div class="card-header">
        <p>
            <strong>Invited guests with profiles</strong>
        </p>
        <hr>
        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#profileData">
            Generate liasing list
        </button>
        <div class="pull-right">
            <mark>
                <a href="{{route('event-guests', $event->slug)}}">
                    <svg class="c-icon">
                        <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-loop-circular')}}"></use>
                    </svg>Refresh
                </a>
            </mark>
        </div>
    </div>
    <div class="card-body">
      
        <table class="table table-responsive-sm table-bordered table-striped table-sm" id="invited-guests-table" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Position</th>
                    <th>Role</th>
                    <th>Email</th>
                    <th>RSVP status</th>
                    <th class="text-center" colspan="3">Action</th>
                </tr>
            </thead>
            <tbody>

                @foreach($event->participants as $index=>$participant)
                <tr>
                    <td>{{$participant->profile->fullname}} {{$participant->profile->lastname}}</td>
                    <td>{{$participant->profile->position}}</td>
                    <td>{{$participant->participant_role}}</td>
                    <td>{{$participant->profile->email}}</td>
                    <td>

                        @if($participant->rsvp_status == 'PENDING')
                            <span class="badge badge-secondary">Pending</span>
                        @elseif($participant->rsvp_status == 'RSVP')
                            <span class="badge badge-success">RSVP</span>
                        @elseif($participant->rsvp_status == 'DECLINE')
                            <span class="badge badge-danger">Declined</span>
                        @elseif($participant->rsvp_status == 'REVOKE')
                            <span class="badge badge-warning">Revoked</span>
                        @endif
                    </td>
                    <td>
                        <div class="dropdown">
                            <span class="c-header-nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                                    <svg class="c-icon">
                                    <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-calendar-check')}}"></use>
                                    </svg>
                            </span>
                            <div class="dropdown-menu dropdown-menu-right pt-0">
                                <div class="dropdown-header bg-light py-2"><strong>RSVP Status</strong></div>
                                <a class="dropdown-item" href="/events/{{$event->slug}}/rsvp/{{$participant->profile->slug}}">
                                    <svg class="c-icon mr-2">
                                    <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-check-circle')}}"></use>
                                    </svg> Confirmed 
                                </a>
                                <a class="dropdown-item" href="/events/{{$event->slug}}/decline/{{$participant->profile->slug}}">
                                    <svg class="c-icon mr-2">
                                    <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-x-circle')}}"></use>
                                    </svg> Declined 
                                </a>
                                <a class="dropdown-item" href="/events/{{$event->slug}}/pending/{{$participant->profile->slug}}">
                                    <svg class="c-icon mr-2">
                                    <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-scrubber')}}"></use>
                                    </svg> Pending
                                </a>
                                <a class="dropdown-item" href="/events/{{$event->slug}}/revoke/{{$participant->profile->slug}}">
                                    <svg class="c-icon mr-2">
                                    <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-ban')}}"></use>
                                    </svg> Cancel
                                </a>
                            </div>
                        </div>
                    
                    </td>
                    <td>
                        <div class="dropdown">
                            <span class="c-header-nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                                    <svg class="c-icon">
                                    <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-file')}}"></use>
                                    </svg>
                            </span>
                            <div class="dropdown-menu dropdown-menu-right pt-0">
                                <div class="dropdown-header bg-light py-2"><strong>Quick report</strong></div>
                                <a class="dropdown-item" href="{{route('main_attendees.activityReport', ['Meeting', $participant->profile->slug, $event->slug])}}">
                                    <svg class="c-icon mr-2">
                                    <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-voice-over-record')}}"></use>
                                    </svg> Meeting 
                                </a>
                                <a class="dropdown-item" href="{{route('main_attendees.activityReport', ['Call', $participant->profile->slug, $event->slug])}}">
                                    <svg class="c-icon mr-2">
                                    <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-phone')}}"></use>
                                    </svg> Call
                                </a>
                                <a class="dropdown-item" href="{{route('main_attendees.activityReport', ['Email',$participant->profile->slug, $event->slug])}}">
                                    <svg class="c-icon mr-2">
                                    <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-send')}}"></use>
                                    </svg> Email
                                </a>
                                <a class="dropdown-item" href="{{route('main_attendees.activityReport', ['Message', $participant->profile->slug, $event->slug])}}">
                                    <svg class="c-icon mr-2">
                                    <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-envelope-letter')}}"></use>
                                    </svg> Message 
                                </a>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="dropdown">
                            <span class="c-header-nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                                    <svg class="c-icon">
                                    <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-menu')}}"></use>
                                    </svg>
                            </span>
                            <div class="dropdown-menu dropdown-menu-right pt-0">
                                <div class="dropdown-header bg-light py-2"><strong>More actions</strong></div>
                                <a class="dropdown-item" href="/events/{{$event->slug}}/delete/{{$participant->profile->slug}}" onclick="return confirm('are you sure you want to delete this invitation?')">
                                    <svg class="c-icon mr-2">
                                        <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-trash')}}"></use>
                                    </svg> Delete invitation
                                </a>
                                <a class="dropdown-item" href="/profiles/{{$participant->profile->slug}}">
                                    <svg class="c-icon mr-2">
                                        <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-user')}}"></use>
                                    </svg> Go to profile
                                </a>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <p>
            <strong>Invited guests without profiles</strong>
        </p>
        <hr>
        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal">
            <span class="fa fa-user"></span> Invite attendee
        </button>
    </div>
    <div class="card-body">
        <table class="table table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Role description</th>
                    <th>Confirmation status</th>
                    <th class="text-center" colspan="3">Action</th>
                </tr>
            </thead>
                <tbody>
                @foreach($event->other_particpants as $index=>$other_participant)
                <tr>
                    <td>{{$index + 1}}</td>
                    <td>{{$other_participant->name}}</td>
                    <td>{{$other_participant->participant_role}}</td>
                    <td>

                        @if($other_participant->rsvp_status == 'PENDING')
                            <span class="badge badge-secondary">Pending</span>
                        @elseif($other_participant->rsvp_status == 'RSVP')
                            <span class="badge badge-success">RSVP</span>
                        @elseif($other_participant->rsvp_status == 'DECLINE')
                            <span class="badge badge-danger">Declined</span>
                        @elseif($other_participant->rsvp_status == 'REVOKE')
                            <span class="badge badge-warning">Revoked</span>
                        @endif
                    </td>
                    
                    <td>

                    <div class="dropdown">
                            <span class="c-header-nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                                    <svg class="c-icon">
                                    <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-calendar-check')}}"></use>
                                    </svg>
                            </span>
                            <div class="dropdown-menu dropdown-menu-right pt-0">
                                <div class="dropdown-header bg-light py-2"><strong>RSVP Status</strong></div>
                                <a class="dropdown-item" href="/events/other-attendees/{{$event->slug}}/rsvp/{{$other_participant->id}}">
                                    <svg class="c-icon mr-2">
                                    <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-check-circle')}}"></use>
                                    </svg> Confirmed 
                                </a>
                                <a class="dropdown-item" href="/events/other-attendees/{{$event->slug}}/decline/{{$other_participant->id}}"">
                                    <svg class="c-icon mr-2">
                                    <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-x-circle')}}"></use>
                                    </svg> Declined 
                                </a>
                                <a class="dropdown-item" href="/events/other-attendees/{{$event->slug}}/pending/{{$other_participant->id}}"">
                                    <svg class="c-icon mr-2">
                                    <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-scrubber')}}"></use>
                                    </svg> Pending
                                </a>
                                <a class="dropdown-item" href="/events/other-attendees/{{$event->slug}}/revoke/{{$other_participant->id}}"">
                                    <svg class="c-icon mr-2">
                                    <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-ban')}}"></use>
                                    </svg> Cancel
                                </a>
                            </div>
                        </div>

                    </td>
                    <td>
                        <div class="dropdown">
                            <span class="c-header-nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                                    <svg class="c-icon">
                                    <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-file')}}"></use>
                                    </svg>
                            </span>
                            <div class="dropdown-menu dropdown-menu-right pt-0">
                                <div class="dropdown-header bg-light py-2"><strong>Quick report</strong></div>
                                <a class="dropdown-item" href="{{route('other_participant.activityReport', ['Meeting', $other_participant->id, $event->slug])}}">
                                    <svg class="c-icon mr-2">
                                    <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-voice-over-record')}}"></use>
                                    </svg> Meeting 
                                </a>
                                <a class="dropdown-item" href="{{route('main_attendees.activityReport', ['Call', $participant->profile->slug, $event->slug])}}">
                                    <svg class="c-icon mr-2">
                                    <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-phone')}}"></use>
                                    </svg> Call
                                </a>
                                <a class="dropdown-item" href="{{route('other_participant.activityReport', ['Email', $other_participant->id, $event->slug])}}">
                                    <svg class="c-icon mr-2">
                                    <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-send')}}"></use>
                                    </svg> Email
                                </a>
                                <a class="dropdown-item" href="{{route('other_participant.activityReport', ['Message', $other_participant->id, $event->slug])}}">
                                    <svg class="c-icon mr-2">
                                    <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-envelope-letter')}}"></use>
                                    </svg> Message 
                                </a>
                            </div>
                        </div>
                    </td>
                    <td>
                         <div class="dropdown">
                            <span class="c-header-nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                                    <svg class="c-icon">
                                    <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-menu')}}"></use>
                                    </svg>
                            </span>
                            <div class="dropdown-menu dropdown-menu-right pt-0">
                                <div class="dropdown-header bg-light py-2"><strong>More actions</strong></div>
                                <a class="dropdown-item" href="/events/other-attendees/{{$event->slug}}/delete/{{$other_participant->id}}" onclick="return confirm('are you sure you want to delete this invitation?')">
                                    <svg class="c-icon mr-2">
                                        <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-trash')}}"></use>
                                    </svg> Delete invitation
                                </a>
                                <a class="dropdown-item" href="#">
                                    <svg class="c-icon mr-2">
                                        <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-send')}}"></use>
                                    </svg> Resend email
                                </a>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>                
    </div>
</div>