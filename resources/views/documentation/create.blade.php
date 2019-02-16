@extends('layouts.hwpl')

@section('content')
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">DOCUMENTATIONS</h4> </div>
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="/setup">Setup</a></li>
                <li class="active">Documentations</li>
            </ol>
        </div>
        <!-- /.col-lg-12 -->
    </div>
        <div class="col-md-12 col-lg-12 col-sm-12">
            <div class="white-box">
                <a href="{{route('documentation.index')}}"> <span class="fa fa-arrow-circle-left"></span> Back</a>
                <h3 class="box-title">New Document</h3>
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <p class="text-danger">{{ $error }}</p>
                        @endforeach
                    @endif
                <hr>
                {!! Form::open(array('route'=>array('documentation.store'), 'class'=>'form-vertical form-material', 'method'=>'post', 'enctype="multipart/form-data"')) !!}
                <div class="row">
                        <div class="database-profile">
                            <div class="form-group">
                                {{Form::label('profile_id', 'SELECT PROFILE')}}
                                {{Form::select('profile_id', $profiles, null, ['class' => 'form-control select2'])}}
                                
                            </div>
                           
                        </div>

                <div class="col-md-5">
                       <div class="form-group">
                            {{Form::label('current_or_former', 'CURRENT OR FORMER')}}
                            {{Form::select('current_or_former', ['current' => 'Current Position', 'former' => 'Former Position'], null, ['class' => 'form-control'])}}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-5">
                            {{Form::label('documentation_type_id', 'Document Type')}}
                            {{Form::select('documentation_type_id', $document_types, null, ['class' => 'form-control'])}}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-5">
                            {{Form::label('file_location', 'File Location')}}
                            {{Form::text('file_location', null, ['class' => 'form-control' , 'required', 'placeholder'=>'Example; HWPL Harddrive'])}}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            {{Form::label('effective_date', 'Effective Date')}}
                            {{Form::text('effective_date', null, ['class' => 'form-control mydatepicker', 'required'])}}
                            <div class="help-text">
                                <span>
                                    For example; Date Signed or Issue Date of the document
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            {{Form::label('path', 'Upload File')}}
                            {{Form::file('path', null, ['class' => 'form-control'])}}
                            {{Form::text('file_name', null, ['class' => 'form-control', 'placeholder'=>'Please type file name here'])}}
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-success"><span class="fa fa-check-circle"></span> Save</button>
                <button type="reset" class="btn btn-warning"><span class="fa fa-ban"></span> Reset</button>
                {!! Form::close() !!}
            </div>
        </div>
</div>
@endsection
