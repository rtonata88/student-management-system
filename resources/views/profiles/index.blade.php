@extends('layouts.hwpl')

@section('content')
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">FRUIT PROFILES</h4> </div>
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                 <li class="active">Fruit Profiles</li>
            </ol>
        </div>
        <!-- /.col-lg-12 -->
    </div>
                <div class="row">
                    <div class="col-md-12 col-lg-12 col-sm-12">
                        @foreach($profiles as $index=>$profile)
                        <!-- /.usercard -->
                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                        <div class="white-box">
                            <div class="el-card-item">
                                <div class="el-card-avatar el-overlay-1"> <img src="/fruit_profiles/photos/{{$profile->photo}}" width="100%" alt="user" />
                                </div>
                                <div class="el-card-content">
                                    <h3 class="box-title"><small><strong>{{$profile->lastname}}, {{$profile->fullname}}</strong></small> </h3> <small>{{$profile->position}}</small>
                                    <br/> 
                                    <hr>
                            <a href="/profiles/{{$profile->slug}}" class="btn btn btn-rounded btn-default btn-outline m-r-5"><i class="fa fa-eye"></i> View</a>
                            <a href="/profiles/{{$profile->slug}}/edit" class="btn btn btn-rounded btn-primary btn-outline m-r-5"><i class="fa fa-edit"></i> Update</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.usercard-->
                     @endforeach
                    </div>
                </div>
            </div>
    </div>
</div>
@endsection
