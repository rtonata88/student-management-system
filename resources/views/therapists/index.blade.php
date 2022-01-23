@extends('layouts.app')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Management</li>
        <li class="breadcrumb-item active"><a href="/profiles">Therapists </a></li>
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
                {!! Form::open(array('route' => array('filter-therapists'), 'method' => 'post', 'class'=> 'form-vertical form-material', 'enctype="multipart/form-data"')) !!}
                <div class="form-group">
                    {{Form::text('name', null, ['class' => 'form-control form-control-sm', 'placeholder' => 'Name'])}}
                </div>
                <div class="form-group">
                    {{Form::text('surname', null, ['class' => 'form-control form-control-sm', 'placeholder' => 'Surname'])}}
                </div>
                <div class="form-group">
                    {{Form::select('specialties', $specialiaties, null, ['class' => 'form-control select2 form-control-sm','placeholder'=>'All specialities'])}}
                </div>
                <div class="form-group">
                    {{Form::select('country', $countries, null, ['class' => 'form-control select', 'placeholder'=>'All countries'])}}
                </div>
                <div class="form-group">
                    {{Form::select('license_type', $license_types, null, ['class' => 'form-control select', 'placeholder'=>'All Types'])}}
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
                    <a href="{{route('therapists.create')}}" class="btn btn-primary pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light"><span class="fa fa-plus"></span> ADD THERAPIST</a>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-responsive-sm table-bordered table-striped table-sm" style="width:100%">
                    <thead>
                        <tr>
                            <th>Firstname</th>
                            <th>Surname</th>
                            <th>Email</th>
                            <th>Practice Number</th>
                            <th>License Type</th>
                            <th>Country</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($therapists as $therapist)
                        <tr>
                            <td>{{$therapist->name}}</td>
                            <td>{{$therapist->surname}}</td>
                            <td>{{$therapist->email}}</td>
                            <td>{{$therapist->practice_number}}</td>
                            <td>{{$therapist->licence_type->type}}</td>
                            <td>{{$therapist->country->name}}</td>
                            <td>
                                <a href="{{route('therapists.show', $therapist->id)}}">
                                    <svg class="c-icon mr-2">
                                        <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-search')}}"></use>
                                    </svg>
                                </a>
                                <a href="{{route('therapists.edit', $therapist->id)}}">
                                    <svg class="c-icon mr-2">
                                        <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-pencil')}}"></use>
                                    </svg>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>

                </table>
                {{ $therapists->links() }}
            </div>
        </div>
    </div>
</div>
@endsection