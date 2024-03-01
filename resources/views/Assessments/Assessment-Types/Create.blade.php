@extends('layouts.app')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Assessment Management</li>
        <li class="breadcrumb-item"><a href="">Assessment Types</a> </li>
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
                <strong>Assessment Types</strong>
            </div>
            <div class="card-body">
                @if ($errors->any())
                @foreach ($errors->all() as $error)
                <p class="text-danger">{{ $error }}</p>
                @endforeach
                @endif

                {!! Form::open(array('url' => '/assessment-types/store', 'method' => 'post', 'class'=>'form-vertical form-material')) !!}

                <div class="row">
                    <input type="hidden" name="subject_allocation_id" value="{{$subject_allocation->id}}">
                    <div class="col-md-12">
                        <div class="form-group">
                            {{Form::label('name', 'Assessment Type')}}
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
                <a href="/assessment-types" class="btn"> Cancel</a>

                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection