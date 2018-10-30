@extends('layouts.hwpl')

@section('content')
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">CO-HOSTS / <small>Edit</small></h4> </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <ol class="breadcrumb">
                    <li><a href="/events">Events</a></li>
                    <li><a href="/events/{{$co_host->event->slug}}">{{$co_host->event->name}}</a></li>
                    <li class="active">Co-hosts</li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <div class="row">
            <div class="col-md-12 col-lg-12 col-sm-12">
                <div class="white-box">
                    <a href="/events/{{$co_host->event->slug}}"> <span class="fa fa-calendar"></span> {{$co_host->event->name}}</a>
                    <hr>
                    {!! Form::model($co_host, array('route' => array('co-hosts.edit', $co_host->id), 'method' => 'post', 'class'=> 'form-vertical form-material', 'enctype="multipart/form-data"')) !!}
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                {{Form::label('name', 'Name')}}
                                {{Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Type here', 'autocomplete'=>'off', 'required'])}}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5">
                          <div class="form-group">
                            {{Form::label('address_line1', 'Address')}}
                            {{Form::text('address_line1', null, ['class' => 'form-control', 'placeholder' => 'Address Line 1', 'autocomplete'=>'off', 'required'])}}
                            {{Form::text('address_line2', null, ['class' => 'form-control', 'placeholder' => 'Address Line 2', 'autocomplete'=>'off', 'required'])}}
                            {{Form::text('address_line3', null, ['class' => 'form-control', 'placeholder' => 'Address Line 3', 'autocomplete'=>'off'])}}
                            {{Form::text('address_line4', null, ['class' => 'form-control', 'placeholder' => 'Address Line 4', 'autocomplete'=>'off'])}}

                        </div>
                    </div>
                </div>

                <div class="row">
                    <h4 class="box-title m-t-5">Contact Persons</h4>
                    
                    <div class="event-co-hosts-contacts">
                        <div class="col-md-4">
                            <div class="form-group">
                                {{Form::label('contact_person[]', 'Name')}}
                                @foreach($co_host->contacts as $contact)
                                {{Form::text('contact_person[]', $contact->contact_person, ['class' => 'form-control co-host-contact', 'placeholder' => 'First and lastname', 'autocomplete'=>'off', 'required'])}}
                                @endforeach
                            </div>
                        </div> 

                        <div class="col-md-4">
                            <div class="form-group">
                                {{Form::label('contact_number[]', 'Number')}}
                                @foreach($co_host->contacts as $contact)
                                {{Form::text('contact_number[]', $contact->contact_number, ['class' => 'form-control', 'placeholder' => 'Contact Number', 'autocomplete'=>'off', 'required'])}}
                                @endforeach
                            </div>
                        </div> 

                        <div class="col-md-4">
                            <div class="form-group">

                                {{Form::label('contact_email[]', 'Email')}}
                                @foreach($co_host->contacts as $contact)
                                {{Form::text('contact_email[]', $contact->contact_email, ['class' => 'form-control', 'placeholder' => 'Email', 'autocomplete'=>'off', 'required'])}}
                                @endforeach
                            </div>
                        </div>
                    </div> 
                    
                    <span class="help-text">
                        <a class="btn btn-default" id="btn-add-co-host-contact">
                            <span class="fa fa-plus"></span> Add 
                        </a>
                        <a class="btn btn-danger" id="btn-remove-co-host-contact">
                            <span class="fa fa-times"></span> Remove 
                        </a>
                    </span>
                </div>

                <br>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {{Form::label('logo', 'Logo')}}
                            {{Form::file('logo', null, ['class' => 'form-control'])}}
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-success"><span class="fa fa-check-circle"></span> Save</button>
                <button type="reset" class="btn btn-warning"><span class="fa fa-ban"></span> Reset</button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
