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
                <strong>Other information</strong> | 
                <a href="/events/other-details/{{$misc->event->slug}}">
            <svg class="c-icon c-icon-lg">
                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-arrow-left')}}"></use>
            </svg>Back</a> 
            </div>
            <div class="card-body">
                    @if(Session::has('message'))
                        <div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> 
                            {{ Session::get('message') }}
                        </div>                            
                    @endif
                    {!! Form::model($misc, array('route' => array('event-other-information.edit', $misc->id), 'method' => 'post', 'class'=> 'form-vertical form-material', 'enctype="multipart/form-data"')) !!}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                {{Form::label('title', 'SECTION TITLE')}}
                                {{Form::text('title', null, ['class' => 'form-control', 'required'])}}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            {{Form::label('content', 'CONTENT')}}
                            {{Form::textarea('content', null, ['class' => 'form-control', 'required'])}}

                        </div>
                    </div>
                    </div>

                    @if(count($misc->files) > 0)
                     <strong>Current Files</strong>
                        <ul>
                            @foreach($misc->files as $file)
                            <li>
                                <a href="/misc-file/download/{{$file->id}}">{{$file->description}}</a> <a href="/misc-file/delete/{{$file->id}}" onclick="return confirm('are you sure you want to delete this file? This operation cannot be reversed.')"><span class="fa fa-trash"></span></a>
                            </li>
                            @endforeach
                        </ul>
                    @endif

                     <div class="form-group">
                        {{Form::label('path', 'ADD FILES (optional)')}} <br>
                        {{Form::file('path[]', null, ['class' => 'form-control', 'required'])}}
                        {{Form::text('description[]', null, ['class' => 'form-control', 'placeholder' => 'Description'])}}
                    </div>
                    <div class="form-group">
                        {{Form::file('path[]', null, ['class' => 'form-control', 'required'])}}
                        {{Form::text('description[]', null, ['class' => 'form-control', 'placeholder' => 'Description'])}}
                    </div>
                    <div class="form-group">
                        {{Form::file('path[]', null, ['class' => 'form-control', 'required'])}}
                        {{Form::text('description[]', null, ['class' => 'form-control', 'placeholder' => 'Description'])}}
                    </div>

                <button type="submit" class="btn btn-success"><span class="fa fa-check-circle"></span> Save</button>
                <button type="reset" class="btn btn-warning"><span class="fa fa-ban"></span> Reset</button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
