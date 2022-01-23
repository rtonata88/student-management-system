@extends('layouts.app')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item">Reports</li>
    <li class="breadcrumb-item active"><a href="#">Post Event Report </a></li>
    <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection
@section('content')
<script type="text/javascript">
function myFunction(slug) {
    var myWindow = window.open("/report/events/print/"+slug, "", "width=auto,height=auto");
}
</script>
<div class="row">
    <div class="col-md-12 col-lg-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <strong>Date & time, location</strong>
                <div class="pull-right">
                    <a href="/report/events/edit/{{$event->slug}}" class="btn btn-primary btn-sm"> <span class="fa fa-edit"></span>Edit Report</a>
                    <button type="button" class="btn btn-default btn-sm" onclick="myFunction('{{$event->slug}}')" ><i class="fa fa-print"></i> Print Report</button>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-responsive-sm table-bordered table-striped table-sm">
                    <tbody>
                        <tr>
                            <td width="390"><strong>Start date</strong></td>
                            <td> {{$event->start_date}} {{$event->start_time}} </td>
                        </tr>
                        <tr>
                            <td width="390"><strong>End date</strong></td>
                            <td> {{$event->end_date}} {{$event->end_time}} </td>
                        </tr>
                        <tr>
                            <td width="390"><strong>Address</strong></td>
                            <td> {{$event->address_line1}}</td>
                        </tr>
                        <tr>
                            <td width="390"><strong></strong></td>
                            <td> {{$event->address_line2}} </td>
                        </tr>
                        <tr>
                            <td width="390"><strong></strong></td>
                            <td> {{$event->city->name}}</td>
                        </tr>
                        <tr>
                            <td width="390"><strong></strong></td>
                            <td> {{$event->country->name}}</td>
                        </tr>
                    </tbody>
                </table>
          </div>
        </div>
    </div> 
</div>
<div class="row">
    <div class="col-md-12 col-lg-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <strong>Event details</strong>
            </div>
            <div class="card-body">
                <table class="table table-responsive-sm table-bordered table-striped table-sm">
                    <tbody>
                        <tr>
                            <td width="390"><strong>Event name:</strong></td>
                            <td> {{$event->name}} (<i>{{$event->theme}}</i>) </td>
                        </tr>
                         <!-- <tr>
                            <td width="390"><strong>Theme:</strong></td>
                            <td> {{$event->theme}}</td>
                        </tr> -->
                        <tr>
                            <td width="390"><strong>Description</strong></td>
                            <td>  {{$event->description}} </td>
                        </tr>
                        <tr>
                            <td width="390"><strong>Purpose / objectives:</strong></td>
                            <td> {{$event->objectives}}</td>
                        </tr>
                        <tr>
                            <td width="390"><strong>Outcome:</strong></td>
                            <td>  {{$event->report->summary}} </td>
                        </tr>
                       
                        @if($event->type == 'external')
                        <tr>
                            <td width="390" colspan="2"><strong>Discussion</strong></td>
                        </tr>
                        <tr>
                            <td colspan="2"> 
                                <ul class="list-icons">
                                    @foreach($event->discussions as $discussion)
                                    <li>{{$discussion->discussion_point}}</li>
                                    @endforeach
                                </ul> 
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div> 
</div>
<div class="row">
    <div class="col-md-12 col-lg-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <strong>Staff in attendance</strong>
            </div>
            <div class="card-body">
                <table class="table table-responsive-sm table-bordered table-striped table-sm">
                    <tbody>
                        @if($event->type == 'internal')
                            @foreach($event->event_staff as $index=>$staff)
                                <tr>
                                    <td width="390"><strong>{{$staff->user->name}} (<em>{{$staff->role->role_name}}</em>)</strong></td>
                                    <td> {{$staff->user->country->name}} </td>
                                </tr>
                            @endforeach
                        @else
                            @foreach($event->external_participants as $index=>$participant)
                            <tr>
                                <td width="390"><strong>{{$participant->fullname}} (<em>{{$participant->role}}</em>)</strong></td>
                            </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div> 
</div>
@if($event->type == 'external')
<div class="row">
    <div class="col-md-12 col-lg-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <strong>Summary outcome</strong>
            </div>
            <div class="card-body">
                <textarea class="form-control summernote" rows="10" name="summary_outcome">{{$report_config->summary}}</textarea>
            </div>
        </div>
    </div>
</div>
@endif 
@if($event->type == 'internal')
<div class="row">
    <div class="col-md-12 col-lg-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <strong>Liaising, statistics, invited guests and general audience</strong>
            </div>
            <div class="card-body">
                <table class="table table-responsive-sm table-bordered table-striped table-sm">
                    <tbody>
                        <tr>
                            <td width="390"><strong>RSVP</strong></td>
                            <td width="390"><strong>Declined</strong></td>
                            <td width="390"><strong>Revoked</strong></td>
                            <td width="390"><strong>Pending</strong></td>
                            <td width="390"><strong>Attended</strong></td>
                        </tr>
                        <tr>
                            <td class="text-center"> {{$event->count_attendees_status('RSVP')}} </td>
                            <td class="text-center"> {{$event->count_attendees_status('DECLINE')}} </td>
                            <td class="text-center"> {{$event->count_attendees_status('REVOKE')}}</td>
                            <td class="text-center"> {{$event->count_attendees_status('PENDING')}}</td>
                            <td class="text-center"> {{$event->check_ins()->count()}} </td>
                        </tr>
                    </tbody>
                </table>
                        </div>
                    </p>
                    <strong>Invited guests</strong>
                    <p>   
                        <table class="table table-responsive-sm table-bordered table-striped table-sm">
                                <tbody>
                                    <tr>
                                        <td width="390"><strong>Guest name</strong></td>
                                        <td width="390"><strong>Role</strong></td>
                                        <td width="390"><strong>Organisation</strong></td>
                                    </tr>
                                    @foreach($event->guest_register() as $register)
                                    @if(!is_null($register->profile_id))
                                    <tr>
                                        <td> {{$register->fullname}} {{$register->lastname}} </td>
                                        <td> {{$event->guest_role($register->profile_id)->role_name}} </td>
                                        <td> {{$event->organization($register->profile_id)->name}} </td>
                                    </tr>
                                    @endif
                                    @endforeach
                                </tbody>
                            </table>
                    </p>

                    <strong>General audience</strong>
                    <p>   
                        <table class="table table-responsive-sm table-bordered table-striped table-sm">
                                <tbody>
                                    <tr>
                                        <td width="390"><strong>Guest name</strong></td>
                                        <td width="390"><strong>Email</strong></td>
                                        <td width="390"><strong>Mobile number</strong></td>
                                    </tr>
                                    @foreach($event->guest_register() as $register)
                                    @if(is_null($register->profile_id))
                                    <tr>
                                        <td> {{$register->fullname}} {{$register->lastname}} </td>
                                        <td> {{$register->email}} </td>
                                        <td> {{$register->mobile_no}} </td>
                                    </tr>
                                    @endif
                                    @endforeach
                                </tbody>
                            </table>
                    </p>
                    @if($event->co_hosts)
                    <strong>Event co-hosts</strong>
                    <p>   
                        <table class="table table-responsive-sm table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Address</th>
                                        <th>Contact persons</th>
                                        <th>logo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($event->co_hosts as $index=>$co_host)
                                    <tr>
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
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </p>
                    @endif

                </div>
            </div>
        </div>
    </div>
@endif
@if($event->type == 'internal')
<div class="row">
    <div class="col-md-12 col-lg-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <strong>Feedback - Discussion outcome</strong>
            </div>
            <div class="card-body">
                <p>
                    As a rule of thumb, it's best to give a <strong>summary</strong> feedback for large events as opposed to <strong>detailed</strong> feedback. For small events such as the WARP Offices, you may provide <strong>detailed</strong> feedback. But do not feel discouraged to do a detailed outcome for large events.<br>

                    <strong>Summary </strong>- Summary outcome of the discussions. <br>
                    <strong>Detailed </strong>- Discussion outcome per guest/participant, what each participant has said during the event. <br>
                </p>
                <p>
                <?php 
                $feedback_type =  $event->report->feedback_type; 
                ?>
                @if($feedback_type == 'both')
                <strong>Feedback Type</strong>: Summary and Detailed<br>
                </p>

                 <table class="table table-responsive-sm table-bordered table-striped table-sm">
                    <tbody>
                        @foreach($event->guest_register() as $register)
                        @if(!is_null($register->profile_id))
                        <tr>
                            <td>
                                <strong>{{$register->fullname}} {{$register->lastname}}</strong>
                            </td>
                            <td>
                               {{$event->participant->feedback}}
                            </td>
                        </tr>
                        @endif
                        @endforeach
                        <tr>
                            <td><strong>Summary outcome</strong></td>
                            <td>
                               {{$event->report->summary}}
                            </td>
                        </tr>
                    </tbody>
                </table>
                @elseif($feedback_type == 'detailed')
                <strong>Feedback type</strong>: Detailed<br>
                <span class="m-t-20"><strong>Guest feedback</strong></span> <br>
                <table class="table table-responsive-sm table-bordered table-striped table-sm">
                    <tbody>
                        @foreach($event->guest_register() as $register)
                        @if(!is_null($register->profile_id))
                        <tr>
                            <td>
                                <strong>{{$register->fullname}} {{$register->lastname}}</strong>
                            </td>
                            <td>
                               {{$event->participant->feedback}}
                            </td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
                @else
                    <table class="table table-responsive-sm table-bordered table-striped table-sm">
                        <tbody>
                            <tr>
                                <td><strong>Summary outcome</strong></td>
                                <td>
                                {{$event->report->summary}}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 col-lg-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <strong>SWOT analysis</strong>
            </div>
            <div class="card-body">
                 <table class="table table-responsive-sm table-bordered table-striped table-sm">
                    <tbody>
                        <tr>
                            <td><strong>Strengths</strong></td>
                            <td> {{$event->report->strengths}} </td>
                        </tr>
                         <tr>
                            <td><strong>Weaknesses</strong></td>
                            <td>{{$event->report->weaknesses}} </td>
                        </tr>
                         <tr>
                            <td><strong>Opportunities</strong></td>
                            <td>{{$event->report->opportunities}}</td>
                        </tr>
                         <tr>
                            <td><strong>Threats</strong></td>
                            <td>{{$event->report->threats}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 col-lg-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <strong>Miscellaneous - other information that should be included in this report</strong>
            </div>
            <div class="card-body">
                <p>
                    Click the checkbox on the right if you would like to include this in the report
                </p>
                <table class="table table-responsive-sm table-bordered table-striped table-sm">
                    <thead>
                        <th>Title</th>
                        <th>Content</th>
                    </thead>
                    <tbody>
                    @foreach($event->miscellaneous as $misc)
                        <tr>
                            <td>{{$misc->title}}</td>
                            <td>{!! $misc->content !!}
                                <br>
                                @if(count($misc->files) > 0)
                                    <strong>Files</strong>
                                    <ul>
                                        @foreach($misc->files as $file)
                                        <li>
                                            <a href="/misc-file/download/{{$file->id}}">{{$file->description}}</a>
                                        </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endif

<div class="row">
    <div class="col-md-12 col-lg-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <strong>Gallery</strong>
            </div>
            <div class="card-body">
                    @foreach($event->photos as $photo)
                    <div class="col-md-4 col-xs-12">
                            <div class="user-bg"> 
                                <img width="100%" alt="user" src="{{ url('storage/'.$photo->path) }}">
                            </div>
                            {{$photo->caption}}
                    </div>                      
                    @endforeach
                <hr>
                <div class="float-left">
                    <a href="/report/events/edit/{{$event->slug}}" class="btn btn-primary btn-sm"> <span class="fa fa-edit"></span>Edit Report</a>
                    <button type="button" class="btn btn-default btn-sm" onclick="myFunction('{{$event->slug}}')" ><i class="fa fa-print"></i> Print Report</button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
