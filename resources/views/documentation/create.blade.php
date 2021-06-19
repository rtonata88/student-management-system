@extends('layouts.hwpl')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item">Management</li>
    <li class="breadcrumb-item active"><a href="/documentation">Documentation </a></li>
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
                New Document | <a href="{{route('documentation.index')}}">  
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
                {!! Form::open(array('route'=>array('documentation.store'), 'class'=>'form-vertical form-material', 'method'=>'post', 'enctype="multipart/form-data"')) !!}
                <div class="row">
                    <div class="col-md-6">
                        <div class="database-profile">
                            <div class="form-group">
                                {{Form::label('profile_id', 'SELECT PROFILE')}}
                                {{Form::select('profile_id', $profiles, null, ['class' => 'form-control select2'])}}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {{Form::label('current_or_former', 'CURRENT OR FORMER')}}
                            {{Form::select('current_or_former', ['current' => 'Current Position', 'former' => 'Former Position'], null, ['class' => 'form-control'])}}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {{Form::label('documentation_type_id', 'Document Type')}}
                            {{Form::select('documentation_type_id', $document_types, null, ['class' => 'form-control'])}}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {{Form::label('file_location', 'File Location')}}
                            {{Form::text('file_location', null, ['class' => 'form-control' , 'required', 'placeholder'=>'Example; HWPL Harddrive'])}}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {{Form::label('effective_date', 'Effective Date')}}
                            {{Form::date('effective_date', null, ['class' => 'form-control mydatepicker', 'required'])}}
                            <div class="help-text">
                                <span>
                                    For example; Date Signed or Issue Date of the document
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
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
</div>
@endsection
