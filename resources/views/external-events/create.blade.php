@extends('layouts.hwpl')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item">Events</li>
    <li class="breadcrumb-item active"><a href="/campaigns">External events </a></li>
    <li class="breadcrumb-item">Create</li>
    <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection
@section('content')
<div class="row">
    <div class="col-md-12 col-lg-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <strong>New external event</strong> | <a href="/external-events">  
                                <svg class="c-icon mr-2">
                                    <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-arrow-left')}}"></use>
                                </svg> Back</a>
            </div>
            <div class="card-body">
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <p class="text-danger">{{ $error }}</p>
                        @endforeach
                    @endif
                {!! Form::open(array('url' => '/external-events', 'method' => 'post', 'class'=> 'form-vertical form-material', 'enctype="multipart/form-data"')) !!}
                <!-- Step 1 -->
                <strong>BASIC INFO</strong>
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
                                {{Form::date('start_date', null, ['class' => 'form-control mydatepicker', 'placeholder' => 'Click here...', 'required', 'autocomplete'=>'off'])}}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{Form::label('start_time', 'Start Time:')}} <span class="text-danger">*</span>
                                {{Form::time('start_time', null, ['class' => 'form-control timepicker', 'placeholder' => 'Click here...', 'required', 'autocomplete'=>'off'])}}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                {{Form::label('end_date', 'Event End Date:')}} <span class="text-danger">*</span>
                                {{Form::date('end_date', null, ['class' => 'form-control mydatepicker', 'placeholder' => 'Click here...', 'required', 'autocomplete'=>'off'])}}
                                
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{Form::label('end_time', 'End Time:')}} <span class="text-danger">*</span>
                                {{Form::time('end_time', null, ['class' => 'form-control timepicker', 'placeholder' => 'Click here...', 'required', 'autocomplete'=>'off'])}}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                        {{Form::label('address_line1', 'Location Details:')}} <span class="text-danger">*</span>
                            <div class="form-group">
                                {{Form::text('address_line1', null, ['class' => 'form-control', 'placeholder' => 'Address Line 1'])}}
                            </div>
                             <div class="form-group">
                                {{Form::text('address_line2', null, ['class' => 'form-control', 'placeholder' => 'Address Line 2'])}}
                            </div>
                             <div class="form-group">
                                {{Form::select('country_id', $countries, null, ['class' => 'form-control select'])}}
                            </div>
                             <div class="form-group">
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

                    <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{Form::label('sector[]', 'Select Sector:')}} <span class="text-danger">*</span>
                                    {{Form::select('sector[]', $sectors, null, ['class' => 'form-control select2 select2-multiple', 'multiple'])}}
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    {{Form::label('team[]', 'Select Team:')}} <span class="text-danger">*</span>
                                    {{Form::select('team[]', $teams, null, ['class' => 'form-control select2 select2-multiple', 'multiple'])}}
                                </div>
                            </div>
                        </div>
            </section>                
                <strong>THEME</strong>
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
                <strong>EVENT PROGRAM</strong>
                <section>
                    <div class="row">
                        
                        <div class="col-md-12">
                        <p class="text-info">
                            The program can be left blank if it's not yet ready. You can complete this at the later stage.
                        </p>
                            <div class="form-group">
                             <div class="summernote">
                             </div>
                         </div>
                     </div>
                 </div>
             </section>
             <!-- Step 3 -->

             <!-- Step 4 -->
             <strong>INTERNAL ATTENDANCE</strong>
             <section>
                <div class="row">
                    <div class="col-md-10">
                        <table class="table table-responsive-sm table-bordered table-striped table-sm" id="tbl-external-events-participants">
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
                        <button type="button" class="btn btn-primary btn-sm" id="btn-external-events-participants">
                             
                                <svg class="c-icon mr-2">
                                    <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-plus')}}"></use>
                                </svg> Add participant
                        </button>
                        <hr>
                    </div>
                </div>
            </section>                  
            <strong>PHOTOS</strong>
            <section>
                
                <div class="row">
                    <div class="col-md-6">

                        {{Form::label('path', 'Select photos')}}
                        <div class="form-group">
                            
                            {{Form::file('path[]', null, ['class' => 'form-control', 'required'])}}
                            {{Form::text('caption[]', null, ['class' => 'form-control', 'placeholder' => 'Caption', 'required'])}}
                        </div>
                        <div class="form-group">
                            {{Form::file('path[]', null, ['class' => 'form-control', 'required'])}}
                            {{Form::text('caption[]', null, ['class' => 'form-control', 'placeholder' => 'Caption', 'required'])}}
                        </div>
                        <div class="form-group">
                            {{Form::file('path[]', null, ['class' => 'form-control', 'required'])}}
                            {{Form::text('caption[]', null, ['class' => 'form-control', 'placeholder' => 'Caption', 'required'])}}
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-success">
                    <span class="fa fa-check"></span> Save
                </button>
                <button type="reset" class="btn">
                    <span class="fa fa-times"></span> Reset
                </button>
            </section>
            {!! Form::close() !!}
            </div>
        </div>

    </div>
</div>

@endsection
