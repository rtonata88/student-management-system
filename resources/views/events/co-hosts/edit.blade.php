@extends('layouts.hwpl')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item">Events</li>
    <li class="breadcrumb-item "><a href="/events">Internal events </a></li>
    <li class="breadcrumb-item active">Co-hosts</li>
    <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection
@section('content')
<div class="row">
    <div class="col-md-8 col-xs-12">
        <div class="card">
            <div class="card-header">
                <strong>Add co-hosts to this event</strong> | 
                <a href="/events/co-hosts/{{$co_host->event->slug}}">
            <svg class="c-icon c-icon-lg">
                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-arrow-left')}}"></use>
            </svg>Back</a> 
            </div>
            <div class="card-body">
                    {!! Form::open(array('route' => array('co-hosts.create', $event->slug), 'method' => 'post', 'class'=> 'form-vertical form-material', 'enctype="multipart/form-data"')) !!}
                        <div class="col-md-8">
                            <div class="form-group">
                                {{Form::label('name', 'Name of co-host')}}
                                {{Form::text('name', $co_host->name, ['class' => 'form-control', 'placeholder' => 'Type here', 'autocomplete'=>'off', 'required'])}}
                            </div>
                        </div>
                        <div class="col-md-8">
                          <div class="form-group">
                            {{Form::label('address_line1', 'Address information')}}
                            {{Form::text('address_line1', $co_host->address_line1, ['class' => 'form-control', 'placeholder' => 'Address Line 1', 'autocomplete'=>'off', 'required'])}} </br>
                            {{Form::text('address_line2', $co_host->address_line2, ['class' => 'form-control', 'placeholder' => 'Address Line 2', 'autocomplete'=>'off', 'required'])}} </br>
                            {{Form::text('address_line3', $co_host->address_line3, ['class' => 'form-control', 'placeholder' => 'Address Line 3', 'autocomplete'=>'off'])}} </br>
                            {{Form::text('address_line4', $co_host->address_line4, ['class' => 'form-control', 'placeholder' => 'Address Line 4', 'autocomplete'=>'off'])}}

                        </div>
                        </div>
                    <hr>
                <div class="row">
                    <div class="col-md-12">
                    <strong>Contact information</strong>
                    
                    <table class="table table-responsive-sm table-bordered table-striped table-sm" id="co-host-table" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Contact person</th>
                                <th>Contact number</th>
                                <th>Email</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($co_host->contacts as $contact)
                            <tr>
                                <td>{{Form::text('contact_person[]', $contact->contact_person, ['class' => 'form-control co-host-contact', 'placeholder' => 'First and lastname', 'autocomplete'=>'off', 'required'])}}</td>
                                <td>{{Form::text('contact_number[]', $contact->contact_number, ['class' => 'form-control', 'placeholder' => 'Contact person First and lastname', 'autocomplete'=>'off', 'required'])}}</td>
                                <td>{{Form::text('contact_email[]', $contact->contact_email, ['class' => 'form-control', 'placeholder' => 'Contact Person Email', 'autocomplete'=>'off', 'required'])}}</td>
                                <td>                                       
                                    <a class='btn btn-danger remove-cohost-contact text-white'>
                                        X
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                     <button class="btn btn-primary btn-sm" id="btn-add-co-host-contact">
                        Add contact information
                    </button>
                </div>
                </div>

                <br>
                <hr>
                 <p>
                        <img src="{{asset('storage/'.$co_host->logo) }}" width="250">
                    </p>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {{Form::label('logo', 'Logo')}}
                            {{Form::file('logo', null, ['class' => 'form-control'])}}
                        </div>
                    </div>
                </div>
                <hr>
                <a href="/events/co-hosts/{{$co_host->event->slug}}" class="btn"> Cancel</a>
                <button type="submit" class="btn btn-success"> Save</button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
