@extends('layouts.hwpl')

@section('content')
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">USERS</h4>
        </div>
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <a href="{{route('users.create')}}" class="btn btn-primary pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light"><span class="fa fa-plus"></span> ADD USER</a>
            <ol class="breadcrumb">
                <li class="active">Users</li>
            </ol>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="white-box">
        <div class="row">
            <div class="col-md-12 col-lg-12 col-sm-12">
                @if(Session::has('message'))
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    {{ Session::get('message') }}
                </div>
                @endif
                <div class="table-responsive">


                    <table id="dataTable" class="table table-hover" style="width:100%">
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
                                        <span class="label label-success">Active</span>
                                    @else
                                        <span class="label label-danger">Disabled</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button aria-haspopup="true" aria-expanded="false" data-toggle="dropdown" class="btn btn-info btn-outline dropdown-toggle waves-effect waves-light" type="button"> <i class="fa fa-align-justify m-r-5"></i> <span class="caret"></span></button>
                                        <ul role="menu" class="dropdown-menu dropdown-menu-right">
                                            <li><a href="{{route('users.edit', $user->id)}}">Edit</a></li>
                                            <li><a href="{{route('users.show', $user->id)}}">View</a></li>
                                            @if($user->approved == 1)
                                                <li><a href="{{route('users.disableEnable', $user->id)}}">Disable</a></li>
                                            @else
                                                <li><a href="{{route('users.disableEnable', $user->id)}}">Enable</a></li>
                                            @endif
                                        </ul>
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
</div>
@endsection
