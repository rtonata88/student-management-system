@extends('layouts.app')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Assessment Management</li>
        <li class="breadcrumb-item">Assessments</li>
        <li class="breadcrumb-item">{{$subject_allocation->module->subject_name}}</li>
        <li class="breadcrumb-item"><a href="/assessment-types">{{$assessment_type->name}}</a></li>
        <li class="breadcrumb-item active">Create </li>
        <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection
@section('content')
<div class="row">
    <div class="offset-3 col-sm-12 col-md-6">
        <div class="card">
            <div class="card-header">
                <strong>Assessments</strong>
            </div>
            <div class="card-body">
                @if ($errors->any())
                @foreach ($errors->all() as $error)
                <p class="text-danger">{{ $error }}</p>
                @endforeach
                @endif

                {!! Form::open(array('url' => '/assessments/store', 'method' => 'post', 'class'=>'form-vertical form-material')) !!}

                <div class="row">
                    <input type="hidden" name="assessment_type" value="{{$assessment_type->id}}">
                    <div class="col-md-12">
                        <div class="form-group">
                            {{Form::label('name', 'Assessment')}}
                            {{Form::text('name', null, ['class' => 'form-control', 'required'])}}
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            {{Form::label('weight', 'Weight (%)')}}
                            {{Form::number('weight', null, ['class' => 'form-control', 'required'])}}
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-success"> Save</button>
                <a href="/assessments/show-assessments/{{$assessment_type->id}}" class="btn"> Cancel</a>

                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection