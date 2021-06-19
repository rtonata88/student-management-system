@extends('layouts.hwpl')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item">Reports</li>
    <li class="breadcrumb-item active">WARP Attendees </li>
    <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection
@section('content')
<div class="row">
    <div class="col-md-4 col-xs-12">
        <div class="card">
            <div class="card-header">
                <strong>Report filter</strong> 
            </div>
            <div class="card-body">
                {!! Form::open(array('route' => array('search-warp'), 'method' => 'post', 'class'=> 'form-vertical form-material', 'enctype="multipart/form-data"')) !!}
                        <div class="form-group">
                            <label for="fname" class="text-right control-label col-form-label">Date from: </label>
                                {{Form::date('date_from', null, ['class' => 'form-control form-control-sm'])}}
                        </div>
                        <div class="form-group">
                            <label for="lname" class="text-right control-label col-form-label">Date to: </label>
                                {{Form::date('date_to', null, ['class' => 'form-control form-control-sm'])}}
                        </div>
                        <hr>
                        <div class="form-actions">
                                <button type="submit" class="btn btn-info">Search</button>
                                <button type="reset" class="btn">Reset</button>
                        </div>

                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <div class="col-md-8 col-xs-12">
        <div class="card">
            <div class="card-header">
                <strong>Report results</strong> 
            </div>
            <div class="card-body">
                @if($attendees)
            <strong>{{$attendees->count()}} Results Found</strong>, <a href="{{route('export-warp-summit-attendees')}}">export to excel</a>
            <div class="col-md-12 col-lg-12 col-sm-12">
                <table class="table table-responsive-sm table-bordered table-striped table-sm" style="width:100%">
                    <thead>
                        <tr>
                            <th>Year Attended</th>
                            <th>Name</th>
                            <th>Organization (s)</th>
                            <th>Position</th>
                            <th>Financing</th>
                            <th>Country</th>
                            <th>City</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($attendees as $attendee)
                        <tr>
                            <td>{{date('Y', strtotime($attendee->date_attended))}}</td>
                            <td>{{$attendee->profile->fullname}} {{$attendee->profile->lastname}}</td>
                            <td>
                                @if($attendee->profile->organization_profile()->first())
                                {{$attendee->profile->organization_profile()->first()->organization->name}}
                                @endif
                            </td>
                            <td>
                                @if($attendee->profile->organization_profile()->first())
                                {{$attendee->profile->organization_profile()->first()->position}}
                                @endif
                            </td>
                            <td>{{$attendee->financing}}</td>
                            <td>{{$attendee->profile->country->name}}</td>
                            <td>{{$attendee->profile->city->name}}</td>
                            
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
            </div>
        </div>
    </div>
</div>
@endsection