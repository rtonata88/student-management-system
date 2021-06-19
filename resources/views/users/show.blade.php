@extends('layouts.hwpl')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item">Access Management</li>
    <li class="breadcrumb-item"><a href="{{route('users.index')}}">Users</a> </li>
    <li class="breadcrumb-item active">View </li>
    <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection
@section('content')
<div class="row">
    <div class="col-md-12 col-xs-12">
        <div class="card">
            <div class="card-header">
                 <strong>{{$user->name}}</strong> @if($user->approved == 1)
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-warning">Disabled</span>
                                    @endif
                                    <br>
                <em>({{$user->username}})</em>
            </div>
            <div class="card-body">
                    <div class="row">
                    <div class="col-md-12">
                           <table class="table table-responsive-sm table-bordered table-striped table-sm" style="width:100%">
                                <tbody>
                                    <tr>
                                        <td width="390"><strong>Email</strong></td>
                                        <td> {{$user->email}}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Gender</strong></td>
                                        <td>{{$user->gender}}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Sector</strong></td>
                                        <td> {{$user->sector->name}} </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Team</strong></td>
                                        <td> {{$user->team->name}} </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Department</strong></td>
                                        <td> {{$user->department->name}} </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Country</strong></td>
                                        <td> {{$user->country->name}} </td>
                                    </tr>
                                    <tr>
                                        <td><strong>City</strong></td>
                                        <td> {{$user->city->name}} </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Prefered Language</strong></td>
                                        <td> {{$user->language->name}} </td>
                                    </tr>

                                    <tr>
                                        <td><strong>Roles</strong></td>
                                        <td> 
                                            @foreach($user->roles as $role)
                                                {{$role->display_name}} <br>
                                            @endforeach
                                         </td>
                                    </tr>
                                </tbody>
                            </table>
                            <hr>
                    <a href="/users"> <span class="fa fa-arrow-circle-left"></span> Back</a>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

