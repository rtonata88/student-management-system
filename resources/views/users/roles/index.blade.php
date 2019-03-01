@extends('layouts.hwpl')

@section('content')
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">USERS</h4> 
        </div>
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <a href="{{route('roles.create')}}" class="btn btn-primary pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light"><span class="fa fa-plus"></span> ADD ROLE</a>
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
                    <table class="table table-hover table-bordered" style="width:100%"> 
                        <thead>
                            <tr>
                                <th>Role Name</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($roles as $role)
                            <tr>
                                <td>{{$role->display_name}} </td>
                                <td>{{$role->description}}</td>
                                <td>
                                    <a href="{{route('roles.edit', $role->id)}}" class=""> <span class="fa fa-edit"></span>Edit </a>
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
