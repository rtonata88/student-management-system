@extends('layouts.hwpl')

@section('content')
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">EVENT PAGE DETAILS</h4> </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <ol class="breadcrumb">
                   <li class="active">Events</li>
               </ol>
           </div>
           <!-- /.col-lg-12 -->
       </div>
       <div class="row">
        @foreach($event->participant_roles as $participant_role)
        <div class="col-lg-{{floor(12/$event->participant_roles->count())}} col-sm-{{floor(12/$event->participant_roles->count())}} col-xs-12">
            <div class="white-box analytics-info">
                <h3 class="box-title">{{$participant_role->role_name}}</h3>
                <ul class="list-inline two-part">
                    <li>
                        <div class="sparklinedash"></div>
                    </li>
                    <li class="text-right"><i class="ti-arrow-up text-purple"></i> <span class="counter text-purple">4</span></li>
                </ul>
            </div>
        </div>
        @endforeach
    </div>
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div class="white-box">
            <h3 class="box-title">{{$event->name}}</h3>
            <p class="text-muted m-b-30">
                {{$event->theme}}
            </p>
            <!-- Nav tabs -->
            <ul class="nav customtab nav-tabs" role="tablist" id="events-tabs">
                <!-- <li role="presentation" class="active"><a href="#activity-log" aria-controls="home" role="tab" data-toggle="tab" aria-expanded="true"><span class="visible-xs"><i class="ti-home"></i></span><span class="hidden-xs"> Activity Log</span></a>
                </li> -->
                <li role="presentation" class=""><a href="#event-details" aria-controls="settings" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-settings"></i></span> <span class="hidden-xs">Event Details</span></a>
                </li>
                <li role="presentation" class=""><a href="#event-program" aria-controls="profile" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-user"></i></span> <span class="hidden-xs">Event Program</span></a>
                </li>
                <li role="presentation" class=""><a href="#participants" aria-controls="profile" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-user"></i></span> <span class="hidden-xs">Guests</span></a>
                </li>
                <li role="presentation" class=""><a href="#event-staff" aria-controls="profile" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-user"></i></span> <span class="hidden-xs">Event Staff</span></a>
                </li>
                <li role="presentation" class=""><a href="#co-hosts" aria-controls="messages" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-email"></i></span> <span class="hidden-xs">Co-Hosts</span></a>
                </li>
                <li role="presentation" class=""><a href="#media-coverage" aria-controls="settings" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-settings"></i></span> <span class="hidden-xs">Media Coverage</span></a>
                </li>
                <li role="presentation" class=""><a href="#documents" aria-controls="settings" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-settings"></i></span> <span class="hidden-xs">Documents</span></a>
                </li>
                <li role="presentation" class=""><a href="#other" aria-controls="settings" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-settings"></i></span> <span class="hidden-xs">Other Information</span></a>
                </li>
                <li role="presentation" class=""><a href="#event-gallery" aria-controls="settings" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-settings"></i></span> <span class="hidden-xs">Gallery</span></a>
                </li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                <!-- ACTIVITY LOG -->
<!--                 <div role="tabpanel" class="tab-pane fade active" id="activity-log">
                    <div class="col-md-12 col-lg-8 col-sm-12">
                        <ul class="feeds">
                            @foreach($event->activities_log as $log)
                            @if ($log->action == 'CreateEvent')
                            <li>
                                <a href="/users/{{$log->user->id}}">{{$log->user->name}}</a> {{$log->description}}
                                <span class="text-muted">{{$log->created_at}}</span>
                            </li>
                            @endif
                            @if ($log->action == 'UpdateEvent')
                            <li>
                                <a href="/users/{{$log->user->id}}">{{$log->user->name}}</a>  {{$log->description}}
                                <span class="text-muted">{{$log->created_at}}</span>
                            </li>
                            @endif
                             @if ($log->action == 'EventProgram')
                            <li>
                                <a href="/users/{{$log->user->id}}">{{$log->user->name}}</a>  {{$log->description}}
                                <span class="text-muted">{{$log->created_at}}</span>
                            </li>
                            @endif
                            @if ($log->action == 'InviteAttendee')
                            <li>
                                <a href="/profiles/{{$log->user->id}}">{{$log->user->name}}</a> {!!$log->description!!}
                                <span class="text-muted">{{$log->created_at}}</span>
                            </li>
                            @endif
                             @if ($log->action == 'AttendeeStatus')
                            <li>
                                <a href="/profiles/{{$log->user->id}}">{{$log->user->name}}</a> {!!$log->description!!}
                                <span class="text-muted">{{$log->created_at}}</span>
                            </li>
                            @endif
                            @endforeach
                        </ul>

                    </div>
                    <div class="clearfix"></div>
                </div> -->
                <!-- ACTIVITY LOG -->
                <!-- EVENT DETAILS -->
                <div role="tabpanel" class="tab-pane fade active in" id="event-details">
                    <div class="col-md-12 col-lg-8 col-sm-12">
                        <h4 class="box-title m-t-10">DESCRIPTION</h4>
                        <p>
                            {{$event->description}}
                        </p>

                        <h4 class="box-title m-t-10">PURPOSE</h4>
                        <p>
                            {{$event->objectives}}
                        </p>

                        <h4 class="box-title m-t-10">Theme: {{$event->theme}}</h4>
                        <ul class="list-icons">
                            @foreach($event->discussions as $discussion)
                            <li><span class="fa fa-caret-right text-info"></span> {{$discussion->discussion_point}}</li>
                            @endforeach
                        </ul>

                        <h4 class="box-title m-t-10">Participant Roles for this event</h4>
                        <ul class="list-icons">
                            @foreach($event->participant_roles as $participant_role)
                            <li><span class="fa fa-caret-right text-info"></span> {{$participant_role->role_name}}</li>
                            @endforeach
                        </ul>

                        <h4 class="box-title m-t-10">Staff roles for this event</font></h4>
                        <ul class="list-icons">
                            @foreach($event->staff_roles as $staff_role)
                            <li><span class="fa fa-caret-right text-info"></span> {{$staff_role->role_name}}</li>
                            @endforeach
                        </ul>

                        <!-- <li><i class="fa fa-check text-success"></i> Sturdy structure</li> -->
                        <h4 class="box-title m-t-40">General Info</h4>
                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td width="390"><strong>START DATE</strong></td>
                                        <td> {{$event->start_date}} {{$event->start_time}} </td>
                                    </tr>
                                    <tr>
                                        <td width="390"><strong>END DATE</strong></td>
                                        <td> {{$event->end_date}} {{$event->end_time}} </td>
                                    </tr>
                                    <tr>
                                        <td width="390"><strong>ADDRESS LINE 1</strong></td>
                                        <td> {{$event->address_line1}}</td>
                                    </tr>
                                    <tr>
                                        <td width="390"><strong>ADDRESS LINE 2</strong></td>
                                        <td> {{$event->address_line2}} </td>
                                    </tr>
                                    <tr>
                                        <td width="390"><strong>CITY</strong></td>
                                        <td> {{$event->city->name}}</td>
                                    </tr>
                                    <tr>
                                        <td width="390"><strong>COUNTRY</strong></td>
                                        <td> {{$event->country->name}}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <hr>
                            <a href="/events/{{$event->slug}}/edit" class="btn btn-success">
                                <span class="fa fa-edit"></span> UPDATE DETAILS 
                            </a>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <!-- EVENT DETAILS -->
                <!-- EVENT PROGRAM -->
                <div role="tabpanel" class="tab-pane fade" id="event-program">
                    <div class="col-md-12 col-lg-12 col-sm-12">
                        <form method="post" action="/events/{{$event->slug}}" class="form-horizontal">
                            <input name="_method" type="hidden" value="PATCH">  
                            <input name="_token" type="hidden" value="">
                            <input name="update" type="hidden" value="EventProgram">
                            {{ csrf_field() }}
                            <textarea class="form-control summernote" id="click2edit" name="content" rows="18">
                                @if($event->event_program == '')
                                     <h4><strong>INSTRUCTIONS</strong></h4>
                                    <ol>
                                        <li>Please <span class="text-danger"><strong>DO NOT</strong></span> copy text from Microsoft Word and Paste here. If you already have the Program on Word, first copy it to Notepad and then copy from Notepad onto here.</li>
                                        <li>If the writing space is too small, please expand by dragging the bottom border of this box</li>
                                        <li>When you are ready to write, clear this content.</li>
                                    </ol>
                                 @else
                                 {{$event->event_program}}
                                 @endif
                            </textarea>
                             <br>
                              <button type="submit" class="btn btn-success">
                                 <span class="fa fa-save"></span> SAVE PROGRAM
                             </button>
                        </form>
                       

                    </div>
                    <div class="clearfix"></div>
                </div>
                <!-- EVENT PROGRAM -->

                <!-- PARTICIPANTS -->
                <div role="tabpanel" class="tab-pane fade" id="participants">
                    <div class="col-md-12 col-lg-12 col-sm-12">
                        <div class="row">
                            <button class="btn btn-info" data-toggle="modal" data-target="#myModal">
                                <span class="fa fa-user"></span> INVITE ATTENDEE
                            </button>
                             <button class="btn btn-info" data-toggle="modal" data-target="#profileData">
                                <span class="fa fa-users"></span> GENERATE LIAISING LIST
                            </button>
                            <button class="btn btn-info">
                                <span class="fa fa-file-excel-o"></span> EXPORT LIST
                            </button>
                        </div>
                        

                        <br>
                        <div class="row">
                            
                        
                        <h4 class="box-title m-t-40">MAIN ATTENDEES</h4>
                            <table class="table table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>NAME</th>
                                        <th>POSITION</th>
                                        <th>ORGANIZATION</th>
                                        <th>ROLE</th>
                                        <th>EMAIL</th>
                                        <th>RSVP STATUS</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($event->participants as $index=>$participant)
                                    <tr>
                                        <td>{{$index + 1}}</td>
                                        <td>{{$participant->profile->fullname}} {{$participant->profile->lastname}}</td>
                                        <td>{{$participant->profile->position}}</td>
                                        <td>{{$participant->profile->organization->acronym}}</td>
                                        <td>{{$participant->role->role_name}}</td>
                                        <td>{{$participant->profile->email}}</td>
                                        <td>
                                            @if($participant->rsvp_status == 'PENDING')
                                                <span class="label label-default">PENDING</span>
                                            @elseif($participant->rsvp_status == 'RSVP')
                                                <span class="label label-success">RSVP</span>
                                            @elseif($participant->rsvp_status == 'DECLINE')
                                                <span class="label label-danger">DECLINED</span>
                                            @elseif($participant->rsvp_status == 'REVOKE')
                                                <span class="label label-warning">REVOKED</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button aria-haspopup="true" aria-expanded="false" data-toggle="dropdown" class="btn btn-default btn-outline dropdown-toggle waves-effect waves-light" type="button"> <i class="fa fa-align-justify m-r-5"></i> <span class="caret"></span></button>
                                                <ul role="menu" class="dropdown-menu dropdown-menu-right">
                                                    <li><a href="/events/{{$event->slug}}/rsvp/{{$participant->profile->slug}}">RSVP</a></li>
                                                    <li><a href="/events/{{$event->slug}}/decline/{{$participant->profile->slug}}">Decline</a></li>
                                                    <li><a href="/events/{{$event->slug}}/pending/{{$participant->profile->slug}}">Pending</a></li>
                                                    <li><a href="/events/{{$event->slug}}/revoke/{{$participant->profile->slug}}">Revoke</a></li>

                                                    <li class="divider"></li>

                                                    <li><a href="{{route('main_attendees.activityReport', ['Meeting', $participant->profile->slug, $event->slug])}}" >Meeting Report</a></li>

                                                    <li><a href="{{route('main_attendees.activityReport', ['Call',$participant->profile->slug, $event->slug])}}">Call Report</a></li>

                                                    <li><a href="{{route('main_attendees.activityReport', ['Email', $participant->profile->slug, $event->slug])}}">Email Report</a></li>
                                                    <li><a href="{{route('main_attendees.activityReport', ['Message', $participant->profile->slug, $event->slug])}}">Message Report</a></li>

                                                    <li class="divider"></li>

                                                    <li><a href="/events/{{$event->slug}}/delete/{{$participant->profile->slug}}" onclick="return confirm('are you sure you want to delete this invitation?')">Delete Invitation</a></li>
                                                    <li><a href="/profiles/{{$participant->profile->slug}}">Attendee Profile</a></li>
                                                    <li><a href="#">Resend Email</a></li>
                                                </ul>
                                            </div>

                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        <hr>
                        <h4 class="box-title m-t-20">OTHER ATTENDEES</h4>
                            <table class="table table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>NAME</th>
                                        <th>ROLE DESCRIPTION</th>
                                        <th>CONFIRMATION STATUS</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                                 <tbody>
                                    @foreach($event->other_particpants as $index=>$other_participant)
                                    <tr>
                                        <td>{{$index + 1}}</td>
                                        <td>{{$other_participant->name}}</td>
                                        <td>{{$other_participant->role->role_name}}</td>
                                        <td>

                                            @if($other_participant->rsvp_status == 'PENDING')
                                                <span class="label label-default">PENDING</span>
                                            @elseif($other_participant->rsvp_status == 'RSVP')
                                                <span class="label label-success">RSVP</span>
                                            @elseif($other_participant->rsvp_status == 'DECLINE')
                                                <span class="label label-danger">DECLINED</span>
                                            @elseif($other_participant->rsvp_status == 'REVOKE')
                                                <span class="label label-warning">REVOKED</span>
                                            @endif
                                        </td>
                                       
                                        <td>
                                            <div class="btn-group m-r-10">
                                                <button aria-expanded="false" data-toggle="dropdown" class="btn btn-default btn-outline dropdown-toggle waves-effect waves-light" type="button"> <i class="fa fa-align-justify m-r-5"></i> <span class="caret"></span></button>
                                                <ul role="menu" class="dropdown-menu dropdown-menu-right">
                                                    <li><a href="/events/other-attendees/{{$event->slug}}/rsvp/{{$other_participant->id}}">RSVP</a></li>
                                                    <li><a href="/events/other-attendees/{{$event->slug}}/decline/{{$other_participant->id}}">Decline</a></li>
                                                    <li><a href="/events/other-attendees/{{$event->slug}}/pending/{{$other_participant->id}}">Pending</a></li>
                                                    <li><a href="/events/other-attendees/{{$event->slug}}/revoke/{{$other_participant->id}}">Revoke</a></li>
                                                    <li class="divider"></li>
                                                    <li><a href="{{route('other_participant.activityReport', ['Meeting', $other_participant->id, $event->slug])}}" >Meeting Report</a></li>
                                                    <li><a href="{{route('other_participant.activityReport', ['Call',$other_participant->id, $event->slug])}}">Call Report</a></li>
                                                    <li><a href="{{route('other_participant.activityReport', ['Email', $other_participant->id, $event->slug])}}">Email Report</a></li>
                                                    <li><a href="{{route('other_participant.activityReport', ['Message', $other_participant->id, $event->slug])}}">Message Report</a></li>
                                                    <li class="divider"></li>
                                                    <li><a href="/events/other-attendees/{{$event->slug}}/delete/{{$other_participant->id}}" onclick="return confirm('are you sure you want to delete this invitation?')">Delete Invitation</a></li>
                                                    <li><a href="#">Resend Email</a></li>
                                                    
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            
                            </div>
                    </div>

                    <div id="myModal" class="modal fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    <h4 class="modal-title" id="myModalLabel">INVITE ATTENDEE</h4> 
                                </div>
                                <form method="post" action="/events/{{$event->slug}}" class="typeahead" role="search">
                                <div class="modal-body">
                                    
                                        <input name="_method" type="hidden" value="PATCH">  
                                        <input name="_token" type="hidden" value="">
                                        <input name="update" type="hidden" value="InviteAttendee">
                                        {{ csrf_field() }}
                                        <div class="form-group">
                                            {{Form::label('profile_y_n', 'DOES THE ATTENDEE HAVE A PROFILE')}}
                                            {{Form::select('profile_y_n', ['y'=>'Yes', 'n'=>'No'], null, ['class' => 'form-control'])}}
                                        </div>
                                        <div class="database-profile">
                                            <div class="form-group">
                                                {{Form::label('profile_id', 'SELECT PROFILE')}}
                                                {{Form::select('profile_id', $profiles, null, ['class' => 'form-control select2', 'style'=> 'width:100%'])}}
                                                
                                            </div>
                                           
                                        </div>
                                        <div class="other-attendee">
                                             <div class="form-group">
                                                {{Form::label('name', 'FIRST AND LASTNAME / NAME OF ORGANIZATION')}}
                                                {{Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter person full name or name of organization', 'autocomplete' => 'off'])}}
                                            </div>
                                            <div class="form-group">
                                                {{Form::label('email', 'EMAIL ADDRESS')}}
                                                {{Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'Email address', 'autocomplete' => 'off'])}}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            {{Form::label('participant_role_id', 'ATTENDEE ROLE')}}
                                            {{Form::select('participant_role_id', $participant_roles, null, ['class' => 'form-control', 'style'=> 'width:100%'])}}
                                            
                                        </div>
                                         <div class="form-group">
                                            {{Form::label('send_email', 'SEND INVITATION TO THE ATTENDEE')}}
                                            {{Form::select('send_email', ['n'=>'No', 'y'=>'Yes'], null, ['class' => 'form-control'])}}
                                          </div>
                                    
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">CANCEL</button>
                                    <button type="submit" class="btn btn-success">
                                             <span class="fa fa-save"></span> INVITE ATTENDEE
                                         </button>
                                </div>
                                </form>
                                
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>  


                    <div id="profileData" class="modal fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    <h4 class="modal-title" id="myModalLabel">GENERATE LIAISING LIST</h4> 
                                </div>
                                <form method="post" action="/events/{{$event->slug}}" class="typeahead" role="search">
                                <div class="modal-body">
                                    
                                        <input name="_method" type="hidden" value="PATCH">  
                                        <input name="_token" type="hidden" value="">
                                        <input name="update" type="hidden" value="InviteAttendee">
                                        {{ csrf_field() }}
                                    <table id="profiles-table" class="table table-hover" style="width:100%"> 
                                        <thead>
                                               <tr>
                                                   <th>Fullname</th>
                                                   <th>Lastname</th>
                                                   <th>Organization</th>
                                                   <th>Gender</th>
                                                   <th>Country</th>
                                                   <th>Action</th>
                                               </tr>
                                           </thead>
                                    </table>
                                    @push('dataTableScript')
                                        <script>
                                            $(document).ready(function() {
                                                $('#profiles-table').DataTable({
                                                    serverSide: true,
                                                    processing: true,
                                                    responsive: true,
                                                    ajax: "{{ route('profiles-table') }}",
                                                    columns: [
                                                        { name: 'fullname' },
                                                        { name: 'lastname' },
                                                        { name: 'organization_id' },
                                                        { name: 'gender_id' },
                                                        { name: 'country_id' },
                                                        { name: 'action', orderable: false, searchable: false }
                                                    ]
                                                });
                                                $('#profiles-table').on('click', 'tr', function () {
                                                    alert('Clicked row id is: ' + $(this).data('id'));
                                                });
                                            });
                                        </script>
                                    @endpush
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">CANCEL</button>
                                    <button type="submit" class="btn btn-success">
                                             <span class="fa fa-save"></span> INVITE SELECTED
                                         </button>
                                </div>
                                </form>
                                
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>  
                    <div class="clearfix"></div>
                </div>
                <!-- EVENT -->
                <div role="tabpanel" class="tab-pane fade" id="event-staff">
                    <div class="col-md-12 col-lg-12 col-sm-12">
                        <div class="row">
                            <button class="btn btn-info" data-toggle="modal" data-target="#staff">
                                <span class="fa fa-plus"></span> ADD STAFF
                            </button>
                        </div>
                        

                        <br>
                        <h4 class="box-title m-t-10">STAFF</h4>
                        <div class="table-responsive">
                            <table class="table table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>NAME</th>
                                        <th>POSITION</th>
                                        <th>ROLE</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($event->event_staff as $index=>$staff)
                                    <tr>
                                        <td>{{$index + 1}}</td>
                                        <td>{{$staff->user->name}}</td>
                                        <td>{{$staff->user->country->name}}</td>
                                        <td>{{$staff->role->role_name}}</td>
                                        <td>
                                            <a href="/event-staff/remove/{{$staff->id}}" onclick="return confirm('are you sure you want to remove {{$staff->user->name}} from the event?')"> <span class="fa fa-trash"></span> Remove</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div id="staff" class="modal fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    <h4 class="modal-title" id="myModalLabel">ADD STAFF</h4> 
                                </div>
                                <form method="post" action="/event-staff/add/{{$event->slug}}" class="typeahead" role="search">
                                <div class="modal-body">
                                        <input name="_token" type="hidden" value="">
                                        <input name="update" type="hidden" value="InviteAttendee">
                                        {{ csrf_field() }}
                                        <div class="database-profile">
                                            <div class="form-group">
                                                {{Form::label('staff_id', 'SELECT STAFF PROFILE')}}
                                                {{Form::select('staff_id', $users, null, ['class' => 'form-control select2', 'style'=> 'width:100%'])}}
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            {{Form::label('staff_role_id', 'STAFF ROLE')}}
                                            {{Form::select('staff_role_id', $staff_roles, null, ['class' => 'form-control', 'style'=> 'width:100%'])}}
                                        </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">CANCEL</button>
                                    <button type="submit" class="btn btn-success">
                                             <span class="fa fa-plus"></span> ADD STAFF
                                         </button>
                                </div>
                                </form>
                                
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>  
                    <div class="clearfix"></div>
                </div>
                <!-- EVENT STAFF -->
                <!-- CO-HOSTS -->
                <div role="tabpanel" class="tab-pane fade" id="co-hosts">
                    <div class="col-md-12 col-lg-12 col-sm-12">
                        <div class="row">
                            <a href="/event-co-host/create/{{$event->slug}}" class="btn btn-info">
                                <span class="fa fa-plus"></span> ADD CO-HOST
                            </a>
                        </div>
                        

                        <br>
                        <h4 class="box-title m-t-10">CO-HOSTS</h4>
                        <div class="table-responsive">
                            <table class="table table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>NAME</th>
                                        <th>ADDRESS</th>
                                        <th>CONTACT PERSONS</th>
                                        <th>LOGO</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($event->co_hosts as $index=>$co_host)
                                    <tr>
                                        <td>{{$index + 1}}</td>
                                        <td>{{$co_host->name}}</td>
                                        <td>
                                            <p>
                                                {{$co_host->address_line1}} <br>
                                                {{$co_host->address_line2}} <br>
                                                {{$co_host->address_line3}} <br>
                                                {{$co_host->address_line4}}
                                            </p>
                                        </td>
                                        <td>
                                            @foreach($co_host->contacts as $contact)
                                            <p>
                                                <strong>{{$contact->contact_person}}</strong> <br>
                                                {{$contact->contact_number}} | 
                                                {{$contact->contact_email}}
                                            </p>
                                            @endforeach
                                        </td>
                                        <td>
                                            <img src="{{asset('storage/'.$co_host->logo) }}" width="200">
                                        </td>
                                        <td>
                                             <div class="btn-group m-r-10">
                                                <button aria-expanded="false" data-toggle="dropdown" class="btn btn-default btn-outline dropdown-toggle waves-effect waves-light" type="button"> <i class="fa fa-align-justify m-r-5"></i> <span class="caret"></span></button>
                                                <ul role="menu" class="dropdown-menu dropdown-menu-right">
                                                    <li><a href="/event-co-host/view/{{$co_host->id}}">View</a></li>
                                                    <li><a href="/event-co-host/edit/{{$co_host->id}}">Edit</a></li>
                                                    <li><a href="/event-co-host/delete/{{$co_host->id}}" onclick="return confirm('are you sure you want to delete {{$co_host->name}} from the list of co-hosts for this event?')">Delete</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div> 
                    <div class="clearfix"></div>
                </div>
                <!-- CO-HOSTS -->
                <!-- MEDIA COVERAGE -->
                <div role="tabpanel" class="tab-pane fade" id="media-coverage">
                    <div class="row">
                        <div class="col-md-12 col-lg-12 col-sm-12">
                            <div class="white-box">
                                   <div class="steamline">
                                        @forelse($event->media_coverage as $coverage)
                                            <div class="sl-item">
                                                <div class="sl-left"><img src="../plugins/images/no-image.jpg" alt="user" class="img-circle" />  </div>
                                                <div class="sl-right">
                                                    <div class="m-l-40"><a href="#" class="text-info">{{$coverage->profile->fullname}}</a>
                                                        <p>
                                                            <strong>Covered By: </strong>{{$coverage->profile->fullname}}<br>
                                                            <strong>Date: </strong>{{$coverage->when}}<br>
                                                            <strong>Title: </strong>{{$coverage->title}}<br>
                                                            <strong>Platform: </strong>{{$coverage->platform}} <br>
                                                            <strong>Media House: </strong>{{$coverage->media_house}}
                                                        </p>
                                                        <p> {{$coverage->short_summary}}</p> 
                                                        <br>
                                                        <div class="m-t-20 row">
                                                            <div id="gallerys">
                                                               <div id="gallery-content">
                                                                   <div id="gallery-content-center">
                                                                       @foreach($coverage->photos as $photo)
                                                                       <a href="{{ asset('storage/'.$photo->path) }}" data-toggle="lightbox" data-effect="mfp-zoom-in" data-gallery="multiimages" data-title="{{$photo->caption}}"><img src="{{ asset('storage/'.$photo->path) }}" alt="gallery" class="all studio col-md-3 col-xs-12" /></a>
                                                                       
                                                                       @endforeach
                                                                   </div>
                                                               </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    @empty
                                        <p class="text-danger">
                                            There is no media coverage for this event at the moment.
                                        </p>
                                    @endforelse
                                   
                                </div>         
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <!-- MEDIA COVERAGE -->
                <!-- DOCUMENTS -->
                <div role="tabpanel" class="tab-pane fade" id="documents">
                      <div class="row">
                            <button class="btn btn-info" data-toggle="modal" data-target="#event-documents-modal">
                                <span class="fa fa-upload"></span> UPLOAD DOCUMENT
                            </button>
                        </div>
                        

                        <br>
                          <div class="table-responsive">
                            <table class="table table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>NAME</th>
                                        <th>DESCRIPTION</th>
                                        <th>UPLOADED BY</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($event->documents as $index=>$document)
                                    <tr>
                                        <td>{{$index + 1}}</td>
                                        <td>{{$document->document_name}}</td>
                                        <td>{{$document->description}}</td>
                                        <td>{{$document->user->name}}</td>
                                        <td>
                                            <a href="/event-documents/download/{{$document->id}}">Download</a> <br>
                                            <a href="/event-documents/delete/{{$document->id}}" onclick="return confirm('are you sure you want to delete this document? This operation cannot be reversed.')">Delete</a>
                                        </td>
                                    </tr>
                                    @empty
                                    <p class="text-danger">
                                        No documents available
                                    </p>
                                    @endforelse

                                </tbody>
                            </table>
                        </div>

                        <div id="event-documents-modal" class="modal fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    <h4 class="modal-title" id="myModalLabel"> DOCUMENTS / <small>Upload</small></h4> 
                                </div>
                                <form method="post" action="/event-documents/upload/{{$event->slug}}" role="search" enctype="multipart/form-data">
                                <div class="modal-body">
                                        <input name="_token" type="hidden" value="">
                                        {{ csrf_field() }}
                                        <div class="form-group">
                                            {{Form::label('document_name', 'DOCUMENT NAME')}}
                                            {{Form::text('document_name', null, ['class' => 'form-control', 'required', 'placeholder' => 'Concept Note, Invitation Template, Thank You Template, Event Permit, Sponsorship letter'])}}
                                        </div>
                                        
                                        <div class="form-group">
                                            {{Form::label('description', 'DESCRIPTION')}}
                                            {{Form::textarea('description', null, ['class' => 'form-control', 'required'])}}
                                        </div>

                                         <div class="form-group">
                                            {{Form::label('path', 'SELECT DOCUMENT')}}
                                            {{Form::file('path', null, ['class' => 'form-control', 'required'])}}
                                        </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">CANCEL</button>
                                    <button type="submit" class="btn btn-success">
                                             <span class="fa fa-upload"></span> UPLOAD
                                         </button>
                                </div>
                                </form>
                                
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div> 
                    <div class="clearfix"></div>
                </div>
                <!-- DOCUMENTS -->

                <!-- OTHER -->
                <div role="tabpanel" class="tab-pane fade" id="other">
                      <div class="row">
                            <button class="btn btn-info" data-toggle="modal" data-target="#event-other-modal">
                                <span class="fa fa-plus"></span> ADD NEW
                            </button>
                        </div>
                        
                        <br>
                        @foreach($event->miscellaneous as $misc)
                        <div class="panel panel-default" style=" border: 1px solid #ddd">
                            <div class="panel-heading" style="background-color: #f5f5f5;">{{$misc->title}}
                                <div class="panel-action">
                                    <div class="dropdown"> <a class="dropdown-toggle" id="examplePanelDropdown" data-toggle="dropdown" href="#" aria-expanded="false" role="button">Options <span class="caret"></span></a>
                                        <ul class="dropdown-menu bullet dropdown-menu-right" aria-labelledby="examplePanelDropdown" role="menu">
                                            <li role="presentation"><a href="/event-other-information/edit/{{$misc->id}}" role="menuitem"><i class="icon wb-reply" aria-hidden="true"></i> Edit</a></li>
                                            
                                            <li role="presentation"><a href="/event-other-information/delete/{{$misc->id}}" onclick="return confirm('are you sure you want to delete this section? This operation cannot be reversed.')" role="menuitem"><i class="icon wb-trash" aria-hidden="true"></i> Delete</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-wrapper collapse in">
                                <div class="panel-body">
                                    <p>
                                        {!! $misc->content !!}
                                    </p>

                                    @if(count($misc->files) > 0)
                                     <strong>Downloadable Files</strong>
                                        <ul>
                                            @foreach($misc->files as $file)
                                            <li>
                                                <a href="/misc-file/download/{{$file->id}}">{{$file->description}}</a>
                                            </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach

                        <div id="event-other-modal" class="modal fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    <h4 class="modal-title" id="myModalLabel"> OTHER INFORMATION / <small>New</small></h4> 
                                </div>
                                <hr>
                                <form method="post" action="/event-other-information/create/{{$event->slug}}" role="search" enctype="multipart/form-data">
                                <div class="modal-body">
                                        <input name="_token" type="hidden" value="">
                                        {{ csrf_field() }}
                                        <div class="form-group">
                                            {{Form::label('title', 'SECTION TITLE')}}
                                            {{Form::text('title', null, ['class' => 'form-control', 'required'])}}
                                        </div>
                                        
                                        <div class="form-group">
                                            {{Form::label('content', 'CONTENT')}}
                                            {{Form::textarea('content', null, ['class' => 'form-control summernote', 'required'])}}
                                        </div>

                                         <div class="form-group">
                                            {{Form::label('path', 'ADD FILES (optional)')}}
                                            {{Form::file('path[]', null, ['class' => 'form-control', 'required'])}}
                                            {{Form::text('description[]', null, ['class' => 'form-control', 'placeholder' => 'Description'])}}
                                        </div>
                                        <div class="form-group">
                                            {{Form::file('path[]', null, ['class' => 'form-control', 'required'])}}
                                            {{Form::text('description[]', null, ['class' => 'form-control', 'placeholder' => 'Description'])}}
                                        </div>
                                        <div class="form-group">
                                            {{Form::file('path[]', null, ['class' => 'form-control', 'required'])}}
                                            {{Form::text('description[]', null, ['class' => 'form-control', 'placeholder' => 'Description'])}}
                                        </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">CANCEL</button>
                                    <button type="submit" class="btn btn-success">
                                             <span class="fa fa-plus"></span> CREATE
                                         </button>
                                </div>
                                </form>
                                
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div> 
                    <div class="clearfix"></div>
                </div>
                <!-- OTHER -->
                 <!-- GALLERY -->
                <div role="tabpanel" class="tab-pane fade" id="event-gallery">
                      <div class="row">
                            <button class="btn btn-info" data-toggle="modal" data-target="#event-gallery-modal">
                                <span class="fa fa-plus"></span> ADD PHOTOS
                            </button>
                        </div>
                        <br>
                         <div class="m-t-20 row">
                             <div id="gallery">
                                <div id="gallery-content">
                                    <div id="gallery-content-center">
                                        @foreach($event->photos as $photo)
                                        <a href="{{ url('storage/'.$photo->path) }}" data-toggle="lightbox" data-effect="mfp-zoom-in" data-gallery="multiimages" data-title="{{$photo->caption}}"><img src="{{ url('storage/'.$photo->path) }}" alt="gallery" class="all studio col-md-3 col-xs-12" /></a>
                                        
                                        @endforeach
                                    </div>
                                </div>
                             </div>
                         </div>

                        <div id="event-gallery-modal" class="modal fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    <h4 class="modal-title" id="myModalLabel"> EVENT GALLERY / <small>Upload</small></h4> 
                                </div>
                                <form method="post" action="/event-gallery/create/{{$event->slug}}" role="search" enctype="multipart/form-data">
                                <div class="modal-body">
                                        <input name="_token" type="hidden" value="">
                                        {{ csrf_field() }}

                                         <div class="form-group">
                                            {{Form::label('path', 'SELECT PHOTOS')}}
                                            {{Form::file('path[]', null, ['class' => 'form-control', 'required'])}}
                                            {{Form::text('description[]', null, ['class' => 'form-control', 'placeholder' => 'Caption', 'required'])}}
                                        </div>
                                        <div class="form-group">
                                            {{Form::file('path[]', null, ['class' => 'form-control', 'required'])}}
                                            {{Form::text('description[]', null, ['class' => 'form-control', 'placeholder' => 'Caption', 'required'])}}
                                        </div>
                                        <div class="form-group">
                                            {{Form::file('path[]', null, ['class' => 'form-control', 'required'])}}
                                            {{Form::text('description[]', null, ['class' => 'form-control', 'placeholder' => 'Caption', 'required'])}}
                                        </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">CANCEL</button>
                                    <button type="submit" class="btn btn-success">
                                             <span class="fa fa-plus"></span> CREATE
                                         </button>
                                </div>
                                </form>
                                
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div> 
                    <div class="clearfix"></div>
                </div>
                <!-- GALLERY -->
            </div>
        </div>
    </div>
</div>
@endsection
