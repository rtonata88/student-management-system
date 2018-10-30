@extends('layouts.hwpl')

@section('content')
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
                <a href="/activities/meetings/{{$profile->slug}}">
                    <strong>MEETINGS <small><span class="counter">{{$profile->meetings_count()}}</span></small></strong>
                </a>
                <br>
                <p class="text-muted">
                    <a href="/meetings/create/{{$profile->slug}}"><span class="fa fa-plus"></span> Add New</a> <br>
                </p>

            </div> 
            <div class="col-md-2 col-xs-6 b-r">
                <a href="/activities/calls/{{$profile->slug}}">
                    <strong>CALLS <small><span class="counter">{{$profile->calls_count()}}</span></small></strong>
                </a>
                <br>
                <p class="text-muted">
                    <a href="/calls/create/{{$profile->slug}}"><span class="fa fa-plus"></span> Add New</a> <br>
                </p>
            </div> 
            <div class="col-md-2 col-xs-6 b-r"> 
                <a href="/activities/emails/{{$profile->slug}}">
                    <strong>EMAILS <small><span class="counter">{{$profile->emails_count()}}</span></small></strong>
                </a>
                <br>
                <p class="text-muted">
                    <a href="/emails/create/{{$profile->slug}}"><span class="fa fa-plus"></span> Add New</a> <br>
                </p>
            </div> 
            <div class="col-md-2 col-xs-6"> 
             <a href="/activities/messages/{{$profile->slug}}">
                <strong>MESSAGES <small><span class="counter">{{$profile->messages_count()}}</span></small></strong>
            </a>
            <br>
            <p class="text-muted">
                <a href="/messages/create/{{$profile->slug}}"><span class="fa fa-plus"></span> Add New</a> <br>
            </p>

        </div> 
        <div class="col-md-2 col-xs-6"> 
         <a href="/media-coverage/{{$profile->slug}}">
            <strong>MEDIA COVERAGE <small><span class="counter">{{$profile->coverage_count()}}</span></small></strong>
        </a>
        <br>
        <p class="text-muted">
            <a href="/media-coverage/create/{{$profile->slug}}"><span class="fa fa-plus"></span> Add New</a> <br>
        </p>

    </div> 
</div>
</div>
</div>
<hr>
<div class="row">
    <div class="col-md-4 col-xs-12">
        <div class="white-box">
            <div class="user-bg"> <img width="100%" alt="user" src="/fruit_profiles/photos/{{$profile->photo}}"> </div>
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
                        <p>{{$profile->fruit_role->role}}</p>
                    </div>
                    <div class="col-md-6"><strong>Fruit Stage</strong>
                        <p>{{$profile->fruit_stage->stage}}</p>
                    </div>
                </div>
                <div class="row m-t-10">
                    <div class="col-md-6 b-r"><strong>Fruit Level</strong>
                        <p>{{$profile->fruit_level->level}}</p>
                    </div>
                    <div class="col-md-6"><strong>Sector Relationship</strong>
                        <p>{{$profile->sector_relationship->relationship}}</p>
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
                    <li>Add to Event Guest list</li>
                </ul>
                <!-- /.row -->

            </div>
        </div>
    </div>
    <div class="col-md-8 col-xs-12">
        <div class="white-box">
            <!-- .tabs -->
            <ul class="nav nav-tabs tabs customtab">
                <li class="active tab">
                    <a href="#home" data-toggle="tab"> <span class="visible-xs"><i class="fa fa-home"></i></span> <span class="hidden-xs">Activity Timeline</span> </a>
                </li>
                <li class="tab">
                    <a href="#profile" data-toggle="tab"> <span class="visible-xs"><i class="fa fa-user"></i></span> <span class="hidden-xs">Profile</span> </a>
                </li>
                <li class="tab">
                    <a href="#settings" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i class="fa fa-cog"></i></span> <span class="hidden-xs">Documents</span> </a>
                </li>
            </ul>
            <!-- /.tabs -->
            <div class="tab-content">
                <!-- .tabs 1 -->
                <div class="tab-pane active" id="home">    
                    <div class="steamline">
                        @foreach($profile->activities as $activity)
                        <div class="sl-item">
                            <div class="sl-left"> <span class="fa fa-at"></span> </div>
                            <div class="sl-right">
                                
                                <div class="m-l-40"><a href="#" class="text-info"> <span class="box-title">{{$activity->activity_type->name}} Report</span></a> <span class="sl-date"></span>
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
                        @endforeach
                        </div>
                    </div>
                    <!-- /.tabs1 -->
                    <!-- .tabs2 -->
                    <div class="tab-pane" id="profile">


                        <div class="row">
                            <div class="col-md-8 col-xs-6 b-r"> <strong>Full Name</strong>
                                <br>
                                <p class="text-muted">{{$profile->title}} {{$profile->fullname}} {{$profile->lastname}}</p>
                            </div>
                            <div class="col-md-3 col-xs-6"> <strong>Gender</strong>
                                <br>
                                <p class="text-muted">{{$profile->gender->gender}}</p>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-8 col-xs-8 b-r"> <strong>Organization</strong>
                                <br>
                                <p class="text-muted">{{$profile->organization->name}}</p>
                            </div>
                            <div class="col-md-4 col-xs-6"> <strong>Position</strong>
                                <br>
                                <p class="text-muted">{{$profile->position}}</p>
                            </div>
                        </div>
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
                            <div class="col-md-4 col-xs-6 b-r"> <strong>Work Number</strong>
                                <br>
                                <p class="text-muted">P: {{$profile->work_number}} <br> 
                                    S: {{$profile->work_number2}} <br>
                                    O: {{$profile->work_number_other}}</p>
                                </div>
                                <div class="col-md-4 col-xs-6 b-r"> <strong>Email</strong>
                                    <br>
                                    <p class="text-muted">P: {{$profile->email}} <br>
                                        S: {{$profile->email2}} <br>
                                        O: {{$profile->email_other}}
                                    </p>

                                </div>
                                <div class="col-md-4 col-xs-6 b-r"> <strong>Mobile Number</strong>
                                    <br>
                                    <p class="text-muted">P: {{$profile->mobile_no}} <br>
                                        S: {{$profile->mobile_no2}} <br>
                                        O: {{$profile->mobile_no_other}}
                                    </p>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 col-xs-6 b-r"> <strong>Assistant Name</strong>
                                    <br>
                                    <p class="text-muted">{{$profile->assistant_name}} </p>
                                </div>
                                <div class="col-md-4 col-xs-6 b-r"> <strong>Assistant Number</strong>
                                    <br>
                                    <p class="text-muted">{{$profile->assistant_number}} </p>
                                </div>
                                <div class="col-md-4 col-xs-6 b-r"> <strong>Assistant Email</strong>
                                    <br>
                                    <p class="text-muted">{{$profile->assistant_email}} </p>
                                </div>
                            </div>


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
                            <a href="/profiles/{{$profile->slug}}/edit" class="btn btn-success">
                                <span class="fa fa-edit"></span> Update Profile
                            </a>
                        </div>
                        <!-- /.tabs2 -->
                        <!-- .tabs3 -->
                        <div class="tab-pane" id="settings">
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
                    <!-- /.tabs3 -->
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
            <!-- /.container-fluid -->
            @endsection