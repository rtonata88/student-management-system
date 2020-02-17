@extends('layouts.hwpl')

@section('content')
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">FRUIT PROFILES REPORT</h4>
        </div>
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li class="active">Fruit Profiles</li>
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

                <div class="panel-wrapper collapse in">
                    <div class="panel-body">

                        {!! Form::open(array('route' => array('search-profiles'), 'method' => 'post', 'class'=> 'form-vertical form-material', 'enctype="multipart/form-data"')) !!}

                        <div class="row">
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="fname" class="col-sm-3 text-right control-label col-form-label">NAME</label>
                                    <div class="col-sm-4">
                                         {{Form::text('fullname', null, ['class' => 'form-control'])}}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="lname" class="col-sm-3 text-right control-label col-form-label">SURNAME</label>
                                    <div class="col-sm-4">
                                        {{Form::text('surname', null, ['class' => 'form-control'])}}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="email1" class="col-sm-3 text-right control-label col-form-label">ORGANIZATION</label>
                                    <div class="col-sm-4">
                                          {{Form::select('organization', $organizations, null, ['class' => 'form-control select','placeholder'=>'All Organisations'])}}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="email1" class="col-sm-3 text-right control-label col-form-label">POSITION</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" name="position">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="email1" class="col-sm-3 text-right control-label col-form-label">CITY</label>
                                    <div class="col-sm-4">
                                        {{Form::select('city', $cities, null, ['class' => 'form-control select','placeholder'=>'All Cities'])}}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="email1" class="col-sm-3 text-right control-label col-form-label">COUNTRY</label>
                                    <div class="col-sm-4">
                                        {{Form::select('country', $countries, null, ['class' => 'form-control select','placeholder'=>'All Countries'])}}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="email1" class="col-sm-3 text-right control-label col-form-label">SECTOR</label>
                                    <div class="col-sm-4">
                                        {{Form::select('sector', $sectors, null, ['class' => 'form-control select','placeholder'=>'All Sectors'])}}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="email1" class="col-sm-3 text-right control-label col-form-label">TEAM</label>
                                    <div class="col-sm-4">
                                        {{Form::select('team', $teams, null, ['class' => 'form-control select','placeholder'=>'All Teams'])}}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="email1" class="col-sm-3 text-right control-label col-form-label">STATUS</label>
                                    <div class="col-sm-4">
                                        {{Form::select('status', $fruit_levels, null, ['class' => 'form-control select','placeholder'=>'All Statuses'])}}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="email1" class="col-sm-3 text-right control-label col-form-label">ROLE</label>
                                    <div class="col-sm-4">
                                        {{Form::select('role', $fruit_roles, null, ['class' => 'form-control select','placeholder'=>'All Roles'])}}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="email1" class="col-sm-3 text-right control-label col-form-label">STAGE</label>
                                    <div class="col-sm-4">
                                        {{Form::select('stage', $fruit_stages, null, ['class' => 'form-control select','placeholder'=>'All Stages'])}}
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
            @if($profiles)
            <strong>{{$profiles->total()}} Results Found</strong>, <a href="{{route('export-profiles')}}">export to excel</a>
            <div class="col-md-12 col-lg-12 col-sm-12">
                <table id="dataTable2" class="table table-striped table-bordered dataTable" style="width:100%">
                    <thead>
                        <tr>
                            <th>Firstnames</th>
                            <th>Lastname</th>
                            <th>Number</th>
                            <th>Email</th>
                            <th>Team</th>
                            <th>Country</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($profiles as $profile)
                        <tr>
                            <td>{{$profile->fullname}} </td>
                            <td>{{$profile->lastname}}</td>
                            <td>{{$profile->mobile_no}}</td>
                            <td>{{$profile->email}}</td>
                            <td>{{$profile->team->name}}</td>
                            <td>{{$profile->country->name}}</td>
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
