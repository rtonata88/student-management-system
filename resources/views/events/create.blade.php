@extends('layouts.hwpl')

@section('content')
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">EVENTS</h4> </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <ol class="breadcrumb">
                   <li class="active">Event Setup</li>
               </ol>
           </div>
           <!-- /.col-lg-12 -->
       </div>
       <div class="row" id="validation">
        <div class="col-md-12 col-lg-12 col-sm-12">
         <div class="white-box">
            <div class="card-body wizard-content">
              <form action="/events" method="post" class="validation-wizard wizard-circle form-material m-t-40" id="events-form">
                 <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <!-- Step 1 -->
                <h6>Basic Info</h6>
                <section>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                {{Form::label('name', 'Name of Event:')}} <span class="text-danger">*</span>
                                {{Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Type here', 'required', 'autocomplete'=>'off'])}}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                {{Form::label('description', 'Description:')}}
                                {{Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => 'Type here', 'autocomplete'=>'off'])}}
                                <span class="help-text">Just a small description about this event. You can extract the content from the concept note.</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                {{Form::label('objectives', 'Purpose/Objectives:')}}
                                {{Form::textarea('objectives', null, ['class' => 'form-control', 'placeholder' => 'Type here', 'autocomplete'=>'off'])}}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                 
                                {{Form::label('start_date', 'Event Start Date:')}} <span class="text-danger">*</span>
                                {{Form::text('start_date', null, ['class' => 'form-control mydatepicker', 'placeholder' => 'Click here...', 'required', 'autocomplete'=>'off'])}}
                                
                           
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                {{Form::label('start_time', 'Start Time:')}} <span class="text-danger">*</span>
                                {{Form::text('start_time', null, ['class' => 'form-control timepicker', 'placeholder' => 'Click here...', 'required', 'autocomplete'=>'off'])}}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                {{Form::label('end_date', 'Event End Date:')}} <span class="text-danger">*</span>
                                {{Form::text('end_date', null, ['class' => 'form-control mydatepicker', 'placeholder' => 'Click here...', 'required', 'autocomplete'=>'off'])}}
                                
                            </div>
                        </div>
                         <div class="col-md-2">
                            <div class="form-group">
                                {{Form::label('end_time', 'End Time:')}} <span class="text-danger">*</span>
                                {{Form::text('end_time', null, ['class' => 'form-control timepicker', 'placeholder' => 'Click here...', 'required', 'autocomplete'=>'off'])}}
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                {{Form::label('address_line1', 'Location Details:')}} <span class="text-danger">*</span>
                                {{Form::text('address_line1', null, ['class' => 'form-control', 'placeholder' => 'Address Line 1'])}}
                                {{Form::text('address_line2', null, ['class' => 'form-control', 'placeholder' => 'Address Line 2'])}}
                                {{Form::select('country_id', $countries, null, ['class' => 'form-control select'])}}
                                {{Form::select('city_id', $cities, null, ['class' => 'form-control select'])}}
                            </div>
                        </div>
                    </div>
                   
                   

                </section>
                <h6>Theme</h6>
                <section>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                {{Form::label('theme', 'Theme/Topic:')}} <span class="text-danger">*</span>
                                {{Form::text('theme', null, ['class' => 'form-control', 'placeholder' => 'We are one. SADC\'s Youth and President\'s united to achieve peace and development', 'required'])}}
                            </div>
                        </div>
                    </div>
                    <p class="text-info">

                        Add the discussion points below. For WARP Office event this would be the topics the leaders will discuss. Do not number the points, the system will number them after you save. To add or remove a point, please click the appropriate button below.
                    </p>
                     <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="discussion-points">
                                {{Form::label('event_discussion[]', 'Point 1:')}}
                                {{Form::textarea('event_discussion[]', null, ['class' => 'form-control event_discussion', 'placeholder' => 'Type here...', 'required', 'rows'=>'2'])}}
                                </div>
                                
                                <span class="help-text">
                                    <a class="btn btn-default" id="btn-add-discussion-point">
                                            <span class="fa fa-plus"></span> Add 
                                    </a>
                                    <a class="btn btn-danger" id="btn-remove-discussion-point">
                                            <span class="fa fa-times"></span> Remove 
                                    </a>
                                </span>
                            </div>
                        </div>
                        
                    </div>
                </section>
                <!-- Step 2 -->
                <h6>Event Program</h6>
                <section>
                    <div class="row">
                        <p class="text-info">
                            The program can be left blank if it's not yet ready. You can complete this at the later stage.
                        </p>
                        <div class="col-md-12">
                            <div class="form-group">
                               <div class="summernote">
                               </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- Step 3 -->
                
                    <!-- Step 4 -->
                    <h6>Participants and Staff</h6>
                    <section>
                        <p class="text-info">
                             Participants are the people we are inviting to the event. Use this screen to define different roles that will be played by each participant. At the stage of inviting the people to the event, each participant will be assigned into one of these roles.
                        </p>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="event-participant-roles">
                                        {{Form::label('participant_roles[]', 'Participant Roles')}} <span class="text-danger">*</span>
                                        {{Form::text('participant_roles[]', null, ['class' => 'form-control participant-role', 'placeholder' => 'Ex. Panelists, Media, Guest Speaker', 'required'])}}
                                    </div>
                                </div>
                                <span class="help-text">
                                    <a class="btn btn-default" id="btn-add-participant-role">
                                            <span class="fa fa-plus"></span> Add 
                                    </a>
                                    <a class="btn btn-danger" id="btn-remove-participant-role">
                                            <span class="fa fa-times"></span> Remove 
                                    </a>
                                </span>
                            </div>
                        </div>
                        <br>
                        <p class="text-info">
                             Staff are the internal members who will be helping with the event. Each member that gets assigned to an event needs to be allocated a role they will be playing.
                        </p>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="event-staff-roles">
                                    {{Form::label('staff_roles[]', 'Staff Roles')}} <span class="text-danger">*</span>
                                    {{Form::text('staff_roles[]', null, ['class' => 'form-control staff-role', 'placeholder' => 'Ex. Logistics, IPYG Representative, Media, Manager', 'required'])}}
                                    </div>
                                </div>
                                <span class="help-text">
                                    <a class="btn btn-default" id="btn-add-staff-role">
                                            <span class="fa fa-plus"></span> Add 
                                    </a>
                                    <a class="btn btn-danger" id="btn-remove-staff-role">
                                            <span class="fa fa-times"></span> Remove 
                                    </a>
                                </span>
                            </div>
                        </div>

                    </section>
                </form>
            </div>
        </div>

    </div>
</div>
</div>
@endsection
