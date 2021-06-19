@extends('layouts.hwpl')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item">Setup</li>
    <li class="breadcrumb-item"> <a href="/document-types"> Document types </a></li>
    <li class="breadcrumb-item active">Create </li>
    <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection
@section('content')
<div class="row">
    <div class="col-md-12 col-xs-12">
         <div class="card-header">
                <strong>Document types</strong> | <a href="/document-types"> Back</a>
             
            </div>
             {!! Form::open(array('url' => '/document-types', 'method' => 'post', 'class'=> 'form-horizontal')) !!}
            <div class="card">
           
                <div class="col-md-5">
                    <div class="form-group">
                         {{Form::label('type', 'Document Type')}}
                        {{Form::text('type', null, ['class' => 'form-control', 'required'])}}
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                       {{Form::label('description', 'Description')}}
                    {{Form::text('description', null, ['class' => 'form-control'])}}
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-success"><span class="fa fa-check-circle"></span> Save</button>
                    <button type="reset" class="btn"><span class="fa fa-ban"></span> Reset</button>
                </div>
                {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection

