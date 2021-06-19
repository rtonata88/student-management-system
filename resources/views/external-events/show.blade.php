@extends('layouts.hwpl')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item">Events</li>
    <li class="breadcrumb-item"><a href="/external-events">External events </a></li>
    <li class="breadcrumb-item active">Setup</li>
    <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection
@section('content')

<div class="card">
    <div class="card-header">
        <strong>External events</strong> 
    </div>
    <div class="card-body">
                {!! Form::model($event, array('url' => '/external-events', 'method' => 'post', 'class'=> 'form-vertical form-material', 'enctype="multipart/form-data"')) !!}
                <!-- Step 1 -->
                <h4 class="page-title"><strong>BASIC INFO</strong></h4>
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
             <section>
               <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                {{Form::label('summary_outcome', 'Feedback/Outcome:')}}
                                {{Form::textarea('summary_outcome', $event->report->summary, ['class' => 'form-control', 'placeholder' => 'Type here', 'autocomplete'=>'off'])}}
                            </div>
                        </div>
                    </div>
            </section>                
                <h4 class="page-title"><strong>THEME</strong></h4>
                <section>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                {{Form::label('theme', 'Theme/Topic:')}} <span class="text-danger">*</span>
                                {{Form::textarea('theme', null, ['class' => 'form-control', 'placeholder' => 'We are one. SADC\'s Youth and President\'s united to achieve peace and development', 'required'])}}
                            </div>
                        </div>
                    </div>
                </section>
                <!-- Step 2 -->
                <h4 class="page-title"><strong>EVENT PROGRAM</strong></h4>
                <section>
                    <div class="row">
                        <p class="text-info">
                            The program can be left blank if it's not yet ready. You can complete this at the later stage.
                        </p>
                        <div class="col-md-12">
                            <div class="form-group">
                                 {{Form::textarea('event_program', null, ['class' => 'form-control summernote'])}}
                         </div>
                     </div>
                 </div>
             </section>
             <!-- Step 3 -->

             <!-- Step 4 -->
             <h4 class="page-title"><strong>INTERNAL ATTENDANCE</strong></h4>
             <section>
                <div class="row">
                    <div class="col-md-8">


                        <div class="table-responsive">
                            <table class="table table-bordered" id="tbl-external-events-participants">
                                <tbody>
                                    <tr>
                                        <th>FULLNAME</th>
                                        <th>ROLE</th>
                                        <th class="text-center">ACTION</th>
                                    </tr>
                                    @foreach($event->external_participants as $index=>$participant)
                                    <tr>
                                        <td>
                                            <input type="text" name="fullname[]" class="form-control" value="{{$participant->fullname}}" placeholder="John Doe" required="">
                                        </td>
                                        <td>
                                            <input type="text" name="role[]" class="form-control" value="{{$participant->role}}" placeholder="Ex. General Audience, Panelist, Guest Speaker" required="">
                                        </td>
                                        <td class="text-center">
                                            @if($index > 0)
                                            <button class="btn btn-danger btn-rounded btn-remove">
                                                <span class="fa fa-times"></span>
                                            </button>'
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <button type="button" class="btn btn-default" id="btn-external-events-participants">
                                <span class="fa fa-plus"></span> Add 
                            </button>
                            <hr>

                        </div>
                    </div>
                </div>
            </section>                  
            <h4 class="page-title"><strong>PHOTOS</strong></h4>
            <section>
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
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {{Form::label('path', 'SELECT PHOTOS')}}
                            {{Form::file('path[]', null, ['class' => 'form-control'])}}
                            {{Form::text('caption[]', null, ['class' => 'form-control', 'placeholder' => 'Caption'])}}
                        </div>
                        <div class="form-group">
                            {{Form::file('path[]', null, ['class' => 'form-control'])}}
                            {{Form::text('caption[]', null, ['class' => 'form-control', 'placeholder' => 'Caption'])}}
                        </div>
                        <div class="form-group">
                            {{Form::file('path[]', null, ['class' => 'form-control'])}}
                            {{Form::text('caption[]', null, ['class' => 'form-control', 'placeholder' => 'Caption'])}}
                        </div>
                    </div>
                </div>
                <button type="reset" class="btn">
                    <span class="fa fa-times"></span> Reset Form
                </button>
                <button type="submit" class="btn btn-success">
                    <span class="fa fa-check"></span> SUBMIT
                </button>
            </section>



            {!! Form::close() !!}
        </div>
    </div>

</div>
@endsection
