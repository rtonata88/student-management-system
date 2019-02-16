@extends('layouts.hwpl')

@section('content')
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">USER</h4> 
        </div>
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li class="active">User</li>
            </ol>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- Column -->
    <div class="col-lg-12 white-box">
        <div class="card">
            <div class="card-body">
                <a href="/users"> <span class="fa fa-arrow-circle-left"></span> Back</a>
                <h3 class="card-title"><strong>{{$user->name}}</strong> <small>@if($user->approved == 1)
                                        <span class="text-success">Active</span>
                                    @else
                                        <span class="text-danger">Disabled</span>
                                    @endif</small></h3>
                <h6 class="card-subtitle">{{$user->username}}</h6>
                <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-6">
                        <div class="white-box text-center"> <img src="/fruit_profiles/photos/no-image.png" class="img-responsive"> </div>
                    </div>
                    <div class="col-lg-9 col-md-9 col-sm-6">
                            <div class="table-responsive">
                            <table class="table">
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
                                </tbody>
                            </table>
                        </div>
                    </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    <!-- Column -->
    @endsection