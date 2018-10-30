@extends('layouts.hwpl')

@section('content')
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">EVENT OTHER INFORMATION / <small>Edit</small></h4> </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <ol class="breadcrumb">
                    <li><a href="/events">Events</a></li>
                    <li><a href="/events/{{$misc->event->slug}}">{{$misc->event->name}}</a></li>
                    <li class="active">Other Information</li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <div class="row">
            <div class="col-md-12 col-lg-12 col-sm-12">
                <div class="white-box">
                    <a href="/events/{{$misc->event->slug}}"> <span class="fa fa-calendar"></span> {{$misc->event->name}}</a>
                    <hr>
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
                            {{Form::textarea('content', null, ['class' => 'form-control summernote', 'required'])}}

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
                        {{Form::label('path', 'ADD FILES (optional)')}}
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
