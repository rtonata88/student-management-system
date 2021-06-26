@extends('layouts.hwpl')
    <div id="upload-documents" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                
                <div class="modal-header">
                    <strong>Upload Profile Documents</strong>
                     <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <svg class="c-icon mr-2">
                        <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-x')}}"></use>
                    </svg>
                    </button>
                </div>
                {!! Form::open(array('url' => '/profiles/documents', 'method' => 'post', 'class'=> 'form-vertical form-material', 'enctype="multipart/form-data"')) !!}
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                {{Form::label('description', 'Description')}}
                                {{Form::text('description', null, ['class' => 'form-control', 'placeholder' => 'Type here'])}}
                                {{Form::hidden('profile', $profile->slug, ['class' => 'form-control', 'placeholder' => 'Type here'])}}
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                {{Form::label('document', 'Select file')}}
                                {{Form::file('document', null, ['class' => 'form-control'])}}
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-info waves-effect">Upload</button>
                </div>
                {!! Form::close() !!}
            </div>
            <!-- /.modal-content -->

        </div>
    </div>

@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item">Management</li>
    <li class="breadcrumb-item"><a href="/profiles">Profiles </a></li>
    <li class="breadcrumb-item active">Show</li>
    <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection

@section('content')
<script type="text/javascript">
    function myFunction(profile) {
    var myWindow = window.open("/profile/print/" + profile, "", "width=auto,height=auto");
    }
</script>
<div class="row">
    <div class="col-md-3 col-xs-12">
        <div class="card">
            <div class="card-header">
                <strong>Quick actions</strong>
            </div>
            <div class="card-body">
                
                <div class="list-group">
                    <a class="list-group-item list-group-item-action" href="/meetings/create/{{$profile->slug}}">
                    <svg class="c-icon c-icon-lg">
                        <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-people')}}"></use>
                    </svg>
                    Meeting report</a>
                    <a class="list-group-item list-group-item-action" href="/calls/create/{{$profile->slug}}">
                     <svg class="c-icon c-icon-lg">
                        <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-phone')}}"></use>
                    </svg>
                    Call report</a>
                    <a class="list-group-item list-group-item-action" href="/emails/create/{{$profile->slug}}">
                    <svg class="c-icon c-icon-lg">
                        <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-send')}}"></use>
                    </svg>
                    Email report</a>
                    <a class="list-group-item list-group-item-action" href="/messages/create/{{$profile->slug}}">
                     <svg class="c-icon c-icon-lg">
                        <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-envelope-letter')}}"></use>
                    </svg>
                    Message report</a>
                    <a class="list-group-item list-group-item-action" href="/media-coverage/create/{{$profile->slug}}">
                     <svg class="c-icon c-icon-lg">
                        <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-newspaper')}}"></use>
                    </svg>
                    Media coverage report</a>
                    <a class="list-group-item list-group-item-action" href="/profiles/{{$profile->slug}}/edit">
                     <svg class="c-icon c-icon-lg">
                        <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-pencil')}}"></use>
                    </svg>
                    Update Profile</a>
                    <a class="list-group-item list-group-item-action" href="#" onclick="myFunction('{{$profile->slug}}')">
                     <svg class="c-icon c-icon-lg">
                        <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-print')}}"></use>
                    </svg>
                    Print Profile</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-9 col-xs-12">
        <div class="card">
            <div class="card-header">
                <strong>{{$profile->fullname}} {{$profile->lastname}} </strong> | <a href="/profiles/{{$profile->slug}}/edit">Update Profile</a>
            </div>
            <div class="card-body">
                <ul class="nav nav-tabs tabcontent-border" role="tablist" id="profiles-tab">
                    <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#activity-timeline" role="tab"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">Activities</span></a> </li>
                    <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#events-attended" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Events & Media</span></a> </li>
                    <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#documents" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Documents</span></a> </li>
                    <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#about" role="tab"><span class="hidden-sm-up"><i class="ti-email"></i></span> <span class="hidden-xs-down">About</span></a> </li>
                    <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#contacts" role="tab"><span class="hidden-sm-up"><i class="ti-email"></i></span> <span class="hidden-xs-down">Contacts & Organisation</span></a> </li>
                    <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#relationship" role="tab"><span class="hidden-sm-up"><i class="ti-email"></i></span> <span class="hidden-xs-down">Relationship</span></a> </li>
                </ul>
                <div class="tab-content tabcontent-border">
                    <div class="tab-pane active p-2" id="activity-timeline" role="tabpanel">
                            @forelse($profile->activities as $activity)
                                <div class="card">
                                    <div class="card-header">
                                        <strong>{{$activity->activity_type->name}} Report</strong>
                                    </div>
                                    <div class="card-body">
                                    <p>
                                        @if($activity->activity_type->name != "Meeting")
                                            <strong>Direction:</strong> {{$activity->direction}} <br>
                                        @else
                                            <strong>Type:</strong> {{$activity->meeting_type}} <br>
                                        @endif
                                        @if($activity->activity_type->name == "Meeting")
                                            <strong>Where:</strong> {{$activity->venue}} <br>
                                        @endif
                                        <strong>Staff:</strong> @foreach($activity->users as $rep) {{$rep->name}}, @endforeach<br>
                                        <strong>When:</strong> {{$activity->when}} {{$activity->time}} <br>
                                        <strong>Why</strong>  <br>{{$activity->why}}<br> <br>
                                        <strong>Outcome</strong>  <br>{{$activity->outcome}}
                                    </p>
                                    @forelse($activity->photos->where('profile_id', $profile->id) as $photo)
                                    <a href="{{ url('storage/'.$photo->path) }}" target="_blank" data-toggle="lightbox" data-effect="mfp-zoom-in" data-gallery="multiimages" data-title="{{$photo->caption}}">
                                        <img src="{{ url('storage/'.$photo->path) }}" alt="{{$photo->caption}}" class="all studio col-md-3 col-xs-12" style="background-color: rgba(245, 245, 245, 0.5); padding: 5px; border-radius: 5px;" />
                                    </a>
                                    @empty
                                    <mark><em>This report does not have any photos</em></mark>
                                    @endforelse
                                    </div>
                                    <div class="card-footer">
                                    <a href="/activities/{{$activity->activity_type->name}}/{{$activity->id}}/{{$profile->slug}}/edit">
                                     <svg class="c-icon c-icon-lg">
                                        <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-pencil')}}"></use>
                                    </svg>
                                    Update report</a>
                                    </div>
                                </div>
                                
                            @empty
                                No activities recorded for this profile.
                            @endforelse
                    </div>
                    <div class="tab-pane  p-4 b-r b-l" id="events-attended" role="tabpanel">
                     @foreach($profile->media_coverage as $coverage)
                        <div class="card">
                            <div class="card-header">
                                <strong>{{$coverage->media_house}} : <em>{{$coverage->title}}</em></strong>
                            </div>
                            <div class="card-body">
                                 <p>
                                    <strong>Media house:</strong> {{$coverage->media_house}}<br>
                                    <strong>Title:</strong> {{$coverage->title}}<br>
                                    <strong>Platform:</strong> {{$coverage->platform}}<br>
                                    <strong>When:</strong> {{$coverage->when}} <br>
                                    <strong>Country:</strong> {{$coverage->country->name}} <br>
                                    <strong>City: </strong> {{$coverage->city->name}}<br>
                                    <strong>URL: </strong> {{$coverage->url}}<br>
                                    <strong>Location: </strong> {{$coverage->location}}<br>
                                    <strong>Short summary: </strong>  <br>{{$coverage->short_summary}}
                                </p>
                                    @foreach($coverage->photos as $photo)
                                        <a href="{{ url('storage/'.$photo->path) }}" data-toggle="lightbox" data-effect="mfp-zoom-in" data-gallery="multiimages" data-title="{{$photo->caption}}">
                                        <img src="{{ url('storage/'.$photo->path) }}" alt="gallery" class="all studio col-md-3 col-xs-12" /></a>
                                    @endforeach
                            </div>
                            <div class="card-footer">
                            <a href="/media-coverage/{{$coverage->id}}/edit">
                                     <svg class="c-icon c-icon-lg">
                                        <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-pencil')}}"></use>
                                    </svg>
                                    Update report</a>
                            </div>
                        </div>
                        @endforeach
                        @forelse($profile->events as $event)
                        <div class="card">
                            <div class="card-header">
                                <strong>{{$event->name}} : <em>{{$event->theme}}</em></strong>
                            </div>
                            <div class="card-body">
                                 <p>
                                    <strong>Event Type:</strong> {{$event->event_type}}<br>
                                    <strong>Start Date:</strong> {{$event->start_date}} {{$event->start_time}} <br>
                                    <strong>End Date:</strong> {{$event->end_date}} {{$event->end_time}} <br>
                                    <strong>Where: </strong> {{$event->address_line1}}<br> {{$event->address_line2}}<br>
                                    <strong>Description</strong>  <br>{{$event->description}}
                                </p>
                                    @foreach($event->photos as $photo)
                                    
                                    <a href="{{ url('storage/'.$photo->path) }}" data-toggle="lightbox" data-effect="mfp-zoom-in" data-gallery="multiimages" data-title="{{$photo->caption}}">
                                    <img src="{{ url('storage/'.$photo->path) }}" alt="gallery" class="all studio col-md-3 col-xs-12" /></a>
                                    @endforeach
                            </div>
                        </div>
                        @empty
                        No events recorded for this profile
                        @endforelse
                    </div>
                    <div class="tab-pane p-4" id="documents" role="tabpanel">
                         <div class="card">
                            <div class="card-header">
                                <strong>Personal documents</strong>
                                <a href="#" class="pull-right" data-toggle="modal" data-target="#upload-documents">
                                <svg class="c-icon">
                                    <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-cloud-upload')}}"></use>
                                </svg>
                                Upload new
                            </a>
                            </div>
                            <div class="card-body">
                            <table class="table table-responsive-sm table-bordered table-hover table-sm table-striped">
                            <thead>
                                <tr>
                                    <th>Description</th>
                                    <th>Uploaded by</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($profile->documents as $index=>$document)
                                <tr>
                                    <td style="width: 50%;">{{$document->description}}</td>
                                    <td style="width: 40%;">{{$document->user->name}}</td>
                                    <td style="width: 10%;">
                                        <a href="/profile/documents/{{$document->id}}/download">
                                            <svg class="c-icon">
                                                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-cloud-download')}}"></use>
                                            </svg>
                                        </a>
                                        <a href="/profile/documents/{{$document->id}}/delete">
                                            <svg class="c-icon">
                                                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-trash')}}"></use>
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                            </div>
                        </div>
                           
                        <div class="card">
                            <div class="card-header">
                                <strong>Other documents</strong>
                            </div>
                            <div class="card-body">
                                <table class="table table-responsive-sm table-bordered table-hover table-sm table-striped">
                                    <thead>
                                        <tr>
                                            <th>Document type</th>
                                            <th>Effective date</th>
                                            <th>Location</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($profile->documentation as $index=>$document)
                                        <tr>
                                            <td>{{$document->document_types->type}}</td>
                                            <td>{{$document->effective_date}}</td>
                                            <td>{{$document->file_location}}</td>
                                            <td>
                                                <a href="{{route('documentation.edit', $document->id)}}">
                                                    <svg class="c-icon">
                                                        <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-pencil')}}"></use>
                                                    </svg>
                                                </a>
                                                @if($document->files)
                                                    <a href="{{route('documentation-download', $document->id)}}">
                                                        <svg class="c-icon">
                                                            <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-cloud-download')}}"></use>
                                                        </svg>
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane p-4" id="about" role="tabpanel">
                        <div class="row about-section">
                            <br>
                            <div class="user-bg p-2">
                                @if($profile->photo)
                                <a href="/fruit_profiles/thumbnail/{{$profile->photo}}" data-toggle="lightbox" data-effect="mfp-zoom-in" data-gallery="multiimages">
                                    <img src="/fruit_profiles/thumbnail/{{$profile->photo}}" alt="gallery" /></a>

                                <!-- <img alt="user" src="/fruit_profiles/thumbnail/{{$profile->photo}}" class="img-circle"> -->
                                @else
                                <center>
                                    <img  alt="user" src="/fruit_profiles/photos/no-image.png" class="img-circle">
                                </center>
                                No photo selected
                                @endif
                            </div>
                            <br>
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
                                    </tbody>
                                </table>
                        </div>
                    </div>
                    <div class="tab-pane p-4" id="contacts" role="tabpanel">
                        <div class="card">
                            <div class="card-header"><strong>Personal contact information</strong></div>
                                <div class="card-body">
                                    <table class="table table-bordered table-sm table-responsive-sm" style="font-size: 12px;">
                                        <tbody>
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
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header"><strong>Organisation information</strong></div>
                                <div class="card-body">
                                
                                    @forelse($profile->organization_profile as $index=>$organization)
                                    <table class="table table-bordered table-sm table-responsive-sm" style="font-size: 12px;">
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
                                    </table>
                                    @empty
                                        Not affiliated to any organisation
                                    @endforelse
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header"><strong>Assistant information</strong></div>
                                    <div class="card-body">
                                    @forelse($assistants as $index=>$assistant)
                                        <table class="table table-bordered table-sm table-responsive-sm" style="font-size: 12px;">
                                            <tbody>
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
                                            </tbody>
                                        </table>
                                         @empty
                                            No assistants
                                        @endforelse
                                    </div>
                                </div>                                   
                    </div>
                    <div class="tab-pane p-4" id="relationship" role="tabpanel">
                        <div class="row relationship-section">
                                <table class="table table-bordered table-sm table-responsive-sm">
                                    <tbody>
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
                                    </tbody>
                                </table>
                        </div>
                        <div class="row">
                            <strong>WARP Summit attendance</strong>
                            <hr>
                                <table class="table table-bordered table-sm table-responsive-sm table-striped">
                                    <thead>
                                        <tr>
                                            <th>Year attended</th>
                                            <th>Financing</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($profile->warp_summit as $index=>$summit)
                                        <tr>
                                            <td>{{date('Y', strtotime($summit->date_attended))}}</td>
                                            <td>{{$summit->financing}}</td>
                                            <td>
                                                <a href="{{route('warp-attendees.edit', $summit->id)}}" onclick="return confirm('Are you sure you want to delete this record?');">
                                                <svg class="c-icon">
                                                    <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-pencil')}}"></use>
                                                </svg>
                                                </a>
                                                <a href="{{route('warp-attendees.delete', $summit->id)}}">
                                                    <svg class="c-icon">
                                                        <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-trash')}}"></use>
                                                    </svg>
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('contactsJS')
<script src="{{asset('js/contacts.js')}}"></script>
@endpush
@endsection
