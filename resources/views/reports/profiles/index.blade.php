@extends('layouts.hwpl')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item">Reports</li>
    <li class="breadcrumb-item active">Profiles </li>
    <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection
@section('content')
<div class="row">
    <div class="col-md-12 col-xs-12">
        <div class="card">
            <div class="card-header">
                <strong>Report filter</strong> 
            </div>
            <div class="card-body">
                {!! Form::open(array('route' => array('search-profiles'), 'method' => 'post', 'class'=> 'form-vertical form-material', 'enctype="multipart/form-data"')) !!}
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label for="fname" class="text-right control-label col-form-label">Name</label>
                                        {{Form::text('fullname', null, ['class' => 'form-control form-control-sm'])}}
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="lname" class="text-right control-label col-form-label">Surname</label>
                                            {{Form::text('surname', null, ['class' => 'form-control form-control-sm'])}}
                                    </div>
                                
                                
                                    <div class="form-group col-md-4">
                                        <label for="email1" class="text-right control-label col-form-label">Organisation</label>
                                            {{Form::select('organization', $organizations, null, ['class' => 'form-control select form-control-sm','placeholder'=>'All Organisations'])}}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-3 col-xs-12">
                                        <label for="email1" class="text-right control-label col-form-label">Position</label>
                                            <input type="text" class="form-control form-control-sm" name="position">
                                    </div>
                                
                                    <div class="form-group col-md-3 col-xs-12">
                                        <label for="email1" class="text-right control-label col-form-label">City</label>
                                            {{Form::select('city', $cities, null, ['class' => 'form-control select form-control-sm','placeholder'=>'All Cities'])}}
                                    </div>
                                    <div class="form-group col-md-3 col-xs-12">
                                        <label for="email1" class="text-right control-label col-form-label">Country</label>
                                            {{Form::select('country', $countries, null, ['class' => 'form-control select form-control-sm','placeholder'=>'All Countries'])}}
                                    </div>
                                     <div class="form-group col-md-3 col-xs-12">
                                        <label for="email1" class="text-right control-label col-form-label">Sector</label>
                                            {{Form::select('sector', $sectors, null, ['class' => 'form-control select form-control-sm','placeholder'=>'All Sectors'])}}
                                    </div>
                                </div>
                                <div class="row">
                                   
                                    <div class="form-group col-md-3 col-xs-12">
                                        <label for="email1" class="text-right control-label col-form-label">Team</label>
                                            {{Form::select('team', $teams, null, ['class' => 'form-control select','placeholder'=>'All Teams'])}}
                                    </div>
                                    <div class="form-group col-md-3 col-xs-12">
                                        <label for="email1" class="text-right control-label col-form-label">Status</label>
                                            {{Form::select('status', $fruit_levels, null, ['class' => 'form-control select','placeholder'=>'All Statuses'])}}
                                    </div>
                                    <div class="form-group col-md-3 col-xs-12">
                                        <label for="email1" class="text-right control-label col-form-label">Role</label>
                                            {{Form::select('role', $fruit_roles, null, ['class' => 'form-control select','placeholder'=>'All Roles'])}}
                                    </div>
                                    <div class="form-group col-md-3 col-xs-12">
                                        <label for="email1" class="text-right control-label col-form-label">Stage</label>
                                            {{Form::select('stage', $fruit_stages, null, ['class' => 'form-control select','placeholder'=>'All Stages'])}}
                                    </div>
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
    <div class="col-md-12 col-xs-12">
        <div class="card">
            <div class="card-header">
                <strong>Report results</strong> 
            </div>
            <div class="card-body">
             @if($profiles)
            <strong>{{$profiles->total()}} Results Found</strong>, <a href="{{route('export-profiles')}}">export to excel</a> <br>
                <table class="table table-responsive-sm table-bordered table-striped table-sm" style="width:100%">
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
            @endif
            </div>
        </div>
    </div>
</div>
@endsection
