@extends('layouts.hwpl')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item">Management</li>
    <li class="breadcrumb-item active"><a href="/profiles">Profiles </a></li>
    <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection
@section('content')
<div class="row">
    <div class="col-md-3 col-xs-12">
        <div class="card">
            <div class="card-header">
                <strong>Filter</strong>
            </div>
            <div class="card-body">
                {!! Form::open(array('route' => array('filter-profiles'), 'method' => 'post', 'class'=> 'form-vertical form-material', 'enctype="multipart/form-data"')) !!}
                        <div class="form-group">
                            {{Form::text('fullname', null, ['class' => 'form-control form-control-sm', 'placeholder' => 'Firstname'])}}
                        </div>
                        <div class="form-group">
                            {{Form::text('surname', null, ['class' => 'form-control form-control-sm', 'placeholder' => 'Surname'])}}
                        </div>
                        <div class="form-group">
                            {{Form::select('organization', $organisations, null, ['class' => 'form-control select2 form-control-sm','placeholder'=>'All organisations'])}}
                        </div>
                        <div class="form-group">
                            {{Form::select('fruit_level', $fruit_levels, null, ['class' => 'form-control select', 'placeholder'=>'All ranks'])}}
                        </div>
                        <div class="form-group">
                            {{Form::select('team', $teams, null, ['class' => 'form-control select', 'placeholder'=>'All teams'])}}
                        </div>
                        <div class="form-group">
                            {{Form::select('city', $cities, null, ['class' => 'form-control select2 form-control-sm','placeholder'=>'All cities'])}}
                        </div>
                        <div class="form-group">
                            {{Form::select('country', $countries, null, ['class' => 'form-control select2 form-control-sm','placeholder'=>'All countries'])}}
                        </div>
                        <button type="submit" class="btn btn-sm btn-success">
                            Search
                        </button>
                        <a href="/profiles" class="btn btn-sm">
                            Clear
                        </a>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <div class="card">
            <div class="card-header">
                <div class="float-left">
                    <a href="/profiles/create" class="btn btn-primary pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light"><span class="fa fa-plus"></span> ADD PROFILE</a>
                </div>
            </div>
            <div class="card-body">
                    <table class="table table-responsive-sm table-bordered table-striped table-sm" style="width:100%">
                        <thead>
                        <tr>
                            <th>Firstname</th>
                            <th>Surname</th>
                            <th>Mobile</th>
                            <!--<th>Email</th> 
                            <th>Team</th>-->
                            <th>Country</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($profiles as $profile)
                        <tr>
                            <td>{{$profile->fullname}}</td>
                            <td>{{$profile->lastname}}</td>
                            <td>{{$profile->mobile_no}}</td>
                            <!--<td>{{$profile->email}}</td>
                            <td>{{$profile->team->name}}</td>-->
                            <td>{{$profile->country->name}}</td>
                            <td>
                                <a href="{{route('profiles.show', $profile->slug)}}">
                                    <svg class="c-icon mr-2">
                                        <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-search')}}"></use>
                                    </svg>
                                </a>
                                <a href="/profiles/{{$profile->slug}}/edit">
                                    <svg class="c-icon mr-2">
                                        <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-pencil')}}"></use>
                                    </svg>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                        
                    </table>
                    {{ $profiles->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
