@extends('layouts.hwpl')

@section('content')
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">EXTERNAL EVENTS <small>create</small></h4> </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <ol class="breadcrumb">
                 <li class="active">Event Setup</li>
             </ol>
         </div>
         <!-- /.col-lg-12 -->
     </div>
     <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12">
           <div class="white-box">
            <div class="card-body">
                {!! Form::open(array('url' => '/external-events', 'method' => 'post', 'class'=> 'form-vertical form-material', 'enctype="multipart/form-data"')) !!}
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
                                {{Form::textarea('summary_outcome', null, ['class' => 'form-control', 'placeholder' => 'Type here', 'autocomplete'=>'off'])}}
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
                             <div class="summernote">
                             </div>
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
                                    <tr>
                                        <td>
                                            <input type="text" name="fullname[]" class="form-control" placeholder="John Doe" required="">
                                        </td>
                                        <td>
                                            <input type="text" name="role[]" class="form-control" placeholder="Ex. General Audience, Panelist, Guest Speaker" required="">
                                        </td>
                                        <td class="text-center">

                                        </td>
                                    </tr>
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
                
                <div class="row">
                    <div class="col-md-6">


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
</div>
</div>
@endsection
