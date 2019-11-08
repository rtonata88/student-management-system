@extends('layouts.hwpl')

@section('content')
<script type="text/javascript">
    function myFunction(profile) {
    var myWindow = window.open("/profile/print/" + profile, "", "width=auto,height=auto");
    }
</script>
{{($profile->profile_organization)}}
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-3 col-md-9 col-sm-4 col-xs-12">
            <h4 class="page-title">{{$profile->fullname}} {{$profile->lastname}} [<a href="/profiles/{{$profile->slug}}/edit">Update Profile</a>]</h4> </div>
        <div class="col-lg-9 col-sm-8 col-md-3 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="/profiles">Fruit Profiles</a></li>
                <li class="active">Detail</li>
            </ol>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- row -->

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-2 col-xs-6 b-r">
                    <strong>MEETINGS <small><span class="counter">{{$profile->meetings_count()}}</span></small></strong>
                    <br>
                    <p class="text-muted">
                        <a href="/meetings/create/{{$profile->slug}}"><span class="fa fa-plus"></span> Report New</a> <br>
                    </p>

                </div>
                <div class="col-md-2 col-xs-6 b-r">
                    <strong>CALLS <small><span class="counter">{{$profile->calls_count()}}</span></small></strong>
                    <br>
                    <p class="text-muted">
                        <a href="/calls/create/{{$profile->slug}}"><span class="fa fa-plus"></span> Report New</a> <br>
                    </p>
                </div>
                <div class="col-md-2 col-xs-6 b-r">
                    <strong>EMAILS <small><span class="counter">{{$profile->emails_count()}}</span></small></strong>
                    <br>
                    <p class="text-muted">
                        <a href="/emails/create/{{$profile->slug}}"><span class="fa fa-plus"></span> Report New</a> <br>
                    </p>
                </div>
                <div class="col-md-2 col-xs-6">
                    <strong>MESSAGES <small><span class="counter">{{$profile->messages_count()}}</span></small></strong>
                    <br>
                    <p class="text-muted">
                        <a href="/messages/create/{{$profile->slug}}"><span class="fa fa-plus"></span> Report New</a> <br>
                    </p>

                </div>
                <div class="col-md-2 col-xs-6">
                    <strong>MEDIA COVERAGE <small><span class="counter">{{$profile->coverage_count()}}</span></small></strong>
                    <br>
                    <p class="text-muted">
                        <a href="/media-coverage/create/{{$profile->slug}}"><span class="fa fa-plus"></span> Report New</a> <br>
                    </p>

                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-4 col-xs-12">
            <div class="white-box">
                <div class="user-bg">
                    @if($profile->photo)
                    <img width="100%" alt="user" src="/fruit_profiles/photos/{{$profile->photo}}">
                    @else
                    <center>
                        <img  alt="user" src="/fruit_profiles/photos/no-image.png" >
                    </center>

                    @endif

                </div>
                <div class="user-btm-box">
                    <!-- .row -->
                    <div class="row m-t-10">
                        <div class="col-md-6 b-r"><strong>Date Networked</strong>
                            <p>{{$profile->date_networked}}</p>
                        </div>
                        <div class="col-md-6"><strong>Maintainer</strong>
                            <p>{{$profile->maintainer->name}}</p>
                        </div>
                    </div>
                    <!-- /.row -->
                    <hr>
                    <!-- .row -->
                    <div class="row m-t-10">
                        <div class="col-md-6 b-r"><strong>Appointed Role</strong>

                            <p>{{ $profile->fruit_role->role}}</p>
                        </div>
                        <div class="col-md-6"><strong>Fruit Stage</strong>
                            <p>{{ $profile->fruit_stage->stage}}</p>
                        </div>
                    </div>
                    <div class="row m-t-10">
                        <div class="col-md-6 b-r"><strong>Fruit Level</strong>
                            <p>{{$profile->fruit_level->level}}</p>
                        </div>

                    </div>
                    <!-- /.row -->
                    <hr>
                    <!-- .row -->
                    <div class="row m-t-10">
                        <div class="col-md-12"><strong>History</strong>
                            <p>{{$profile->history}}</p>
                        </div>
                    </div>
                    <hr>
                    <h5><strong>Quick Actions</strong></h5>
                    <ul>
                        <li><a href="#upload-documents" data-toggle="modal" data-target="#upload-documents">Upload Document</a></li>
                        <li><a href="/profiles/{{$profile->slug}}/edit">Update Profile</a></li>
                        <li><a href="#" onclick="myFunction('{{$profile->slug}}')">Print Profile</a></li>
                    </ul>

                    <!-- /.row -->

                </div>
            </div>
        </div>
        <div class="col-md-8 col-xs-12">
            <div class="row white-box">
                <!-- .tabs -->
                <ul class="nav nav-tabs tabs customtab">
                    <li class="active tab">
                        <a href="#home" data-toggle="tab"> <span class="visible-xs"><i class="fa fa-home"></i></span> <span class="hidden-xs">Activity Timeline</span> </a>
                    </li>
                    <li class="tab">
                        <a href="#events" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i class="fa fa-cog"></i></span> <span class="hidden-xs">Events</span> </a>
                    </li>
                    <li class="tab">
                        <a href="#profile" data-toggle="tab"> <span class="visible-xs"><i class="fa fa-user"></i></span> <span class="hidden-xs">Profile Details</span> </a>
                    </li>
                    <li class="tab">
                        <a href="#settings" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i class="fa fa-cog"></i></span> <span class="hidden-xs">Profile Documents</span> </a>
                    </li>
                    <li class="tab">
                        <a href="#other-information" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i class="fa fa-cog"></i></span> <span class="hidden-xs">Other Information</span> </a>
                    </li>
                </ul>
            </div>
            <!-- /.tabs -->
            <div class="tab-content">
                <!-- .tabs 1 -->
                <div class="tab-pane active" id="home">
                    @forelse($profile->activities as $activity)
                    <div class="row white-box">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title text-uppercase mb-0"><strong>{{$activity->activity_type->name}} Report</strong></h5>
                                <hr>
                                <p>
                                    @if($activity->activity_type->name != "Meeting")
                                    <strong>Direction:</strong> {{$activity->direction}} <br>
                                    @endif
                                    <strong>Where:</strong> {{$activity->venue}} <br>
                                    <strong>When:</strong> {{$activity->when}} <br>
                                    <strong>Why</strong>  <br>{{$activity->why}}<br> <br>
                                    <strong>Outcome</strong>  <br>{{$activity->outcome}}
                                </p>
                                <div class="m-t-20 row">
                                    @foreach($activity->photos as $photo)
                                    <img src="{{ asset('storage/'.$photo->path) }}" alt="user" class="col-md-3 col-xs-12" />
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    No activities recorded for this profile
                    @endforelse
                </div>
                <!-- /.tabs1 -->
                <!-- .tabs2 -->
                <div class="tab-pane" id="profile">
                    <div class="row white-box">



                        <div class="row">
                            <div class="col-md-8 col-xs-6 b-r"> <strong>Full Name</strong>
                                <br>
                                <p class="text-muted">@foreach($profile->title as $title) {{$title->title}} @endforeach {{$profile->fullname}} {{$profile->lastname}}</p>
                            </div>
                            <div class="col-md-3 col-xs-6"> <strong>Gender</strong>
                                <br>
                                <p class="text-muted">{{$profile->gender->gender}}</p>
                            </div>
                        </div>
                        <br>
                        @if($profile->bio)
                        <div class="row">
                            <div class="col-md-12 col-xs-8"> <strong>Bio</strong>
                                <br>
                                <p class="text-muted">{{$profile->bio}}</p>
                            </div>
                        </div>
                        @endif
                        <hr>

                        <div class="row">
                            <div class="col-md-6 col-xs-6 b-r"> <strong>Sector</strong>
                                <br>
                                <p class="text-muted">{{$profile->sector->name}}</p>
                            </div>
                            <div class="col-md-6 col-xs-6"> <strong>Team</strong>
                                <br>
                                <p class="text-muted">{{$profile->team->name}}</p>
                            </div>
                        </div>
                        <br>


                        <div class="row">
                            <div class="col-md-6 col-xs-8 b-r"> <strong>Country</strong>
                                <br>
                                <p class="text-muted">{{$profile->country->name}}</p>
                            </div>
                            <div class="col-md-6 col-xs-6"> <strong>City</strong>
                                <br>
                                <p class="text-muted">{{$profile->city->name}}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6 col-xs-8 b-r"> <strong>Mobile Numbers</strong>
                                <br>
                                <p class="text-muted">{{$profile->mobile_no}} <br>
                                {{$profile->mobile_no2}} <br> {{$profile->mobile_no_other}}</p>
                            </div>
                            <div class="col-md-6 col-xs-6"> <strong>Emails</strong>
                                <br>
                                <p class="text-muted">{{$profile->email}} <br>
                                {{$profile->email2}} </p>
                            </div>
                        </div>

                        <table class="table table-bordered">
                            <thead>
                            <th>#</th>
                            <th>Organization Name</th>
                            <th>Position</th>
                            <th>Department</th>
                            <th>Website</th>
                            <th>Work Number</th>
                            <th>Email</th>
                            </thead>
                            <tbody>
                              @forelse($organizations as $index=>$profile_organization)
                              <tr>
                                <td>{{$index + 1}}</td>
                                <td>{{$profile_organization->organization->name}}</td>
                                <td>{{$profile_organization->position}}</td>
                                <td>{{$profile_organization->department}}</td>
                                <td><a href="http://{{$profile_organization->organization->website}}" target="_blank">{{$profile_organization->organization->website}}</a></td>
                                <td>
                                  {{$profile_organization->work_number}} <br>
                                  {{$profile_organization->work_number2}}
                                  {{$profile_organization->work_number_other}}
                                </td>
                                <td>
                                  {{$profile_organization->email}} <br>
                                  {{$profile_organization->email2}} <br>
                                  {{$profile_organization->email_other}}
                                </td>
                              </tr>
                              @empty
                                Not affiliated to any organizations
                                @endforelse
                            </tbody>
                        </table>

                        <h6 class="m-t-10"><strong>ASSISTANTS</strong></h6>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Assistant Name</th>
                                    <th>Assistant Email</th>
                                    <th>Assistant Number</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($assistants as $index=>$assistant)
                                <tr>
                                    <td>{{$index + 1}}</td>
                                    <td>{{$assistant->assistant_name}}</td>
                                    <td>
                                        <strong>P</strong>: {{$assistant->assistant_email1}} <br>
                                        <strong>S</strong>: {{$assistant->assistant_email2}} <br>
                                        <strong>O</strong>: {{$assistant->assistant_email3}} <br>
                                    </td>
                                    <td>
                                        <strong>P</strong>: {{$assistant->assistant_number1}} <br>
                                        <strong>S</strong>: {{$assistant->assistant_number2}} <br>
                                        <strong>O</strong>: {{$assistant->assistant_number3}} <br>
                                    </td>
                                </tr>
                                @empty
                                No assistants
                                @endforelse
                            </tbody>
                        </table>

                        <hr>
                        <a href="/profiles/{{$profile->slug}}/edit" class="btn btn-success">
                            <span class="fa fa-edit"></span> Update Profile
                        </a>
                    </div>
                </div>
                <!-- /.tabs2 -->
                <!-- .tabs3 -->
                <div class="tab-pane" id="settings">
                    <div class="row white-box">
                        <h4 class="page-title"><strong>PERSONAL DOCUMENTS</strong></h4>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>DESCRIPTION</th>
                                        <th>UPLOADED BY</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($profile->documents as $index=>$document)
                                    <tr>
                                        <td>{{$index + 1}}</td>
                                        <td>{{$document->description}}</td>
                                        <td>{{$document->user->name}}</td>
                                        <td>
                                            <a href="/profile/documents/{{$document->id}}/download"> <span class="fa fa-download"></span></a> <strong>|</strong>
                                            <a href="/profile/documents/{{$document->id}}/delete"> <span class="fa fa-trash"></span></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <hr>
                            <a href="#" data-toggle="modal" data-target="#upload-documents" class="btn btn-success">
                                <span class="fa fa-upload"></span> Upload Document
                            </a>
                        </div>
                    </div>

                    <div class="row white-box">
                        <h4 class="page-title"><strong>DOCUMENTATIONS</strong></h4>
                        <hr>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>DOCUMENT TYPE</th>
                                        <th>EFFECTIVE DATE</th>
                                        <th>LOCATION</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   @foreach($profile->documentation as $index=>$document)
                                    <tr>
                                        <td>{{$index + 1}}</td>
                                        <td>{{$document->document_types->type}}</td>
                                        <td>{{$document->effective_date}}</td>
                                        <td>{{$document->file_location}}</td>
                                        <td>
                                            <a href="{{route('documentation.edit', $document->id)}}">  <span class="fa fa-pencil"></span> </a> |
                                            @if($document->files)
                                                <a href="{{route('documentation-download', $document->id)}}">  <span class="fa fa-download"></span> </a>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="tab-pane active" id="events">
                    @forelse($profile->events as $event)
                    <div class="row white-box">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title text-uppercase mb-0"><strong>{{$event->name}}: <i>{{$event->theme}}</i></strong></h5>
                                <hr>
                                <p>
                                    <strong>Event Type:</strong> {{$event->event_type}}<br>
                                    <strong>Start Date:</strong> {{$event->start_date}} {{$event->start_time}} <br>
                                    <strong>End Date:</strong> {{$event->end_date}} {{$event->end_time}} <br>
                                    <strong>Where: </strong>  <br>{{$event->address_line1}}<br> {{$event->address_line2}}<br>
                                    <strong>Description</strong>  <br>{{$event->description}}
                                </p>
                                <div class="m-t-20 row">
                                    @foreach($event->photos as $photo)
                                    <a href="{{ url('storage/'.$photo->path) }}" data-toggle="lightbox" data-effect="mfp-zoom-in" data-gallery="multiimages" data-title="{{$photo->caption}}"><img src="{{ url('storage/'.$photo->path) }}" alt="gallery" class="all studio col-md-3 col-xs-12" /></a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    No events recorded for this profile
                    @endforelse
                </div>
                <!-- /.tabs3 -->

                <div class="tab-pane active" id="other-information">
                    <div class="row white-box">
                        <h4 class="page-title"><strong>WARP SUMMIT ATTENDANCE</strong></h4>
                        <hr>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>YEAR ATTENDED</th>
                                        <th>FINANCING</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   @foreach($profile->warp_summit as $index=>$summit)
                                    <tr>
                                        <td>{{$index + 1}}</td>
                                        <td>{{date('Y', strtotime($summit->date_attended))}}</td>
                                        <td>{{$summit->financing}}</td>
                                        <td>
                                           <a href="{{route('warp-attendees.edit', $summit->id)}}"> <span class="fa fa-pencil"></span> Edit</a>
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
    <!-- /.row -->

    <!-- sample modal content -->
    <div id="upload-documents" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                {!! Form::open(array('url' => '/profiles/documents', 'method' => 'post', 'class'=> 'form-vertical form-material', 'enctype="multipart/form-data"')) !!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myModalLabel">Upload Profile Documents</h4> </div>
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
</div>
<!-- /.container-fluid -->
@endsection
