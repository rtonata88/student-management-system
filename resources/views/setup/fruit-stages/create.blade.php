@extends('layouts.hwpl')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item">Setup</li>
    <li class="breadcrumb-item"> <a href="/fruit-stages"> Fruit stages </a></li>
    <li class="breadcrumb-item active">Create </li>
    <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection
@section('content')
<div class="row">
    <div class="col-md-12 col-xs-12">
         <div class="card-header">
                <strong>Fruit stages</strong> | <a href="/fruit-stages"> Back</a>
             
            </div>
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <p class="text-danger">{{ $error }}</p>
                @endforeach
            @endif
             {!! Form::open(array('url' => '/fruit-stages', 'method' => 'post', 'class'=> 'form-horizontal')) !!}
            <div class="card">
            
                <div class="col-md-5">
                    <div class="form-group">
                        {{Form::label('stage', 'Fruit stage')}}
                        {{Form::text('stage', null, ['class' => 'form-control'])}}
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                       {{Form::label('language_id', 'Language')}}
                    {{Form::select('language_id', $languages, null, ['class' => 'form-control select'])}}
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