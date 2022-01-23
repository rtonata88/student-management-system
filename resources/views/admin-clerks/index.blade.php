@extends('layouts.app')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Access Management</li>
        <li class="breadcrumb-item active"><a href="/admin-clerks">Admin Clerks </a></li>
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
                {!! Form::open(array('route' => array('filter-admin-clerks'), 'method' => 'post', 'class'=> 'form-vertical form-material')) !!}
                <div class="form-group">
                    {{Form::text('name', null, ['class' => 'form-control form-control-sm', 'placeholder' => 'Name'])}}
                </div>
                <div class="form-group">
                    {{Form::text('surname', null, ['class' => 'form-control form-control-sm', 'placeholder' => 'Surname'])}}
                </div>
                <div class="form-group">
                    {{Form::select('country', $countries, null, ['class' => 'form-control select', 'placeholder'=>'All countries'])}}
                </div>
                <button type="submit" class="btn btn-sm btn-success">
                    Search
                </button>
                <a href="/admin-clerks" class="btn btn-sm">
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
                    <a href="{{route('admin-clerks.create')}}" class="btn btn-primary pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light"><span class="fa fa-plus"></span> ADD ADMIN CLERK</a>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-responsive-sm table-bordered table-striped table-sm" style="width:100%">
                    <thead>
                        <tr>
                            <th>Firstname</th>
                            <th>Surname</th>
                            <th>Email</th>
                            <th>Country</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($admin_clerks as $admin_clerk)
                        <tr>
                            <td>{{$admin_clerk->name}}</td>
                            <td>{{$admin_clerk->surname}}</td>
                            <td>{{$admin_clerk->email}}</td>
                            <td>{{$admin_clerk->country->name}}</td>
                            <td>
                                <a href="{{route('admin-clerks.show', $admin_clerk->id)}}">
                                    <svg class="c-icon mr-2">
                                        <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-search')}}"></use>
                                    </svg>
                                </a>
                                <a href="{{route('admin-clerks.edit', $admin_clerk->id)}}">
                                    <svg class="c-icon mr-2">
                                        <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-pencil')}}"></use>
                                    </svg>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $admin_clerks->links() }}
            </div>
        </div>
    </div>
</div>
@endsection