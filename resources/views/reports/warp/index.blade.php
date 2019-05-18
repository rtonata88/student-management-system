@extends('layouts.hwpl')

@section('content')
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">WARP SUMMIT ATTENDEES REPORT</h4> 
        </div>
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li class="active">Warp Summit Attendees</li>
            </ol>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="white-box">
        <div class="row">
            <div class="panel panel-default" style=" border: 1px solid #ddd">
                <div class="panel-heading" style="background-color: #f5f5f5;">
                    REPORT FILTER
                </div>
                @if(Session::has('message'))
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> 
                    {{ Session::get('message') }}
                </div>                            
                @endif
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">

                        {!! Form::open(array('route' => array('search-warp'), 'method' => 'post', 'class'=> 'form-vertical form-material', 'enctype="multipart/form-data"')) !!}

                        <div class="row">
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="fname" class="col-sm-3 text-right control-label col-form-label">DATE FROM: </label>
                                    <div class="col-sm-4">
                                        {{Form::text('date_from', null, ['class' => 'form-control mydatepicker'])}}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="lname" class="col-sm-3 text-right control-label col-form-label">DATE TO: </label>
                                    <div class="col-sm-4">
                                        {{Form::text('date_to', null, ['class' => 'form-control mydatepicker'])}}
                                    </div>
                                </div>
                                <div class="form-actions">
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-info">SEARCH</button>
                                        <button type="reset" class="btn btn-dark">Reset</button>
                                    </div>
                                </div>

                            </div>
                        </div>

                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
            @if($attendees)
            <strong>{{$attendees->count()}} Results Found</strong>, <a href="{{route('export-warp-summit-attendees')}}">export to excel</a>
            <div class="col-md-12 col-lg-12 col-sm-12">
                <table id="dataTable2" class="table table-striped table-bordered dataTable" style="width:100%"> 
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
@endsection
