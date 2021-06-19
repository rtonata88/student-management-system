@extends('layouts.hwpl')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item">Access Management</li>
    <li class="breadcrumb-item">Users </li>
    <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection
@section('content')
<div class="row">
    <div class="col-md-12 col-xs-12">
        <div class="card">
            <div class="card-header">
                <a href="{{route('users.create')}}" class="btn btn-primary waves-effect waves-light"> ADD USER</a>
            </div>
            <div class="card-body">
                @if(Session::has('message'))
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    {{ Session::get('message') }}
                </div>
                @endif
                <table class="table table-responsive-sm table-bordered table-striped table-sm" style="width:100%">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Username</th>
                                <th>Gender</th>
                                <th>Email</th>
                                <th>Sector</th>
                                <th>Team</th>
                                <th>Country</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td>{{$user->name}} </td>
                                <td>{{$user->username}}</td>
                                <td>{{$user->gender}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->sector->name}}</td>
                                <td>{{$user->team->name}}</td>
                                <td>{{$user->country->name}}</td>
                                <td>
                                    @if($user->approved == 1)
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-warning">Disabled</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="dropdown">
                                    <span class="c-header-nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                                            <svg class="c-icon">
                                            <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-menu')}}"></use>
                                            </svg>
                                    </span>
                                    <div class="dropdown-menu dropdown-menu-right pt-0">
                                        <a class="dropdown-item" href="{{route('users.show', $user->id)}}">
                                            <svg class="c-icon mr-2">
                                            <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-search')}}"></use>
                                            </svg> View 
                                        </a>
                                        <a class="dropdown-item" href="{{route('users.edit', $user->id)}}">
                                            <svg class="c-icon mr-2">
                                            <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-pencil')}}"></use>
                                            </svg> Edit 
                                        </a>
                                        @if($user->approved == 1)
                                        <a class="dropdown-item" href="{{route('users.disableEnable', $user->id)}}">
                                            <svg class="c-icon mr-2">
                                            <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-x-circle')}}"></use>
                                            </svg> Disable
                                        </a>
                                        @else
                                        <a class="dropdown-item" href="{{route('users.disableEnable', $user->id)}}">
                                            <svg class="c-icon mr-2">
                                            <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-check-circle')}}"></use>
                                            </svg> Enable
                                        </a>
                                        @endif
                            </div>
                        </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
            </div>
        </div>
    </div>
</div>
@endsection