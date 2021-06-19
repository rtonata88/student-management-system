@extends('layouts.hwpl')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item">Management</li>
    <li class="breadcrumb-item active"><a href="/warp-attendees">WARP attendees </a></li>
    <li class="breadcrumb-item active">Edit </li>
    <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection
@section('content')
<div class="col-md-12 col-lg-12 col-sm-12">
    @if(Session::has('message'))
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            {{ Session::get('message') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <strong>WARP attendees </strong> | 
            <a href="{{route('warp-attendees.index')}}">
            <svg class="c-icon c-icon-lg">
                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-arrow-left')}}"></use>
            </svg>Back</a>

            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <p class="text-danger">{{ $error }}</p>
                @endforeach
            @endif
            <hr>
                {!! Form::model($attendee, array('route'=>array('warp-attendees.update', $attendee->id), 'class'=>'form-vertical form-material', 'method'=>'PATCH')) !!}
                <div class="row">
                <div class="col-md-6">
                    <div class="database-profile">
                        <div class="form-group">
                            {{Form::label('profile_id', 'Select profile')}}
                            {{Form::select('profile_id', $profiles, null, ['class' => 'form-control select2'])}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        {{Form::label('current_or_former', 'Current or former')}}
                        {{Form::select('current_or_former', ['current' => 'Current Position', 'former' => 'Former Position'], null, ['class' => 'form-control'])}}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        {{Form::label('financing', 'Financing')}}
                        {{Form::select('financing', ['Sponsored' => 'Sponsored', 'Self funded' => 'Self funded'], null, ['class' => 'form-control'])}}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        {{Form::label('date_attended', 'Date Attended')}}
                        {{Form::date('date_attended', null, ['class' => 'form-control mydatepicker', 'required'])}}
                        {{Form::hidden('user', Auth::user()->id, ['class' => 'form-control'])}}
                    </div>
                </div>
            </div>
                 <a href="{{route('warp-attendees.index')}}"> Cancel</a>
                <button type="submit" class="btn btn-success"><span class="fa fa-check-circle"></span> Save</button>
                {!! Form::close() !!}
            </div>
        </div>
</div>
@endsection
