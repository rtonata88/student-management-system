@extends('layouts.hwpl')

@section('content')
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">ORGANISATIONS</h4> </div>
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="/setup">Setup</a></li>
                 <li class="active">Organisations</li>
            </ol>
        </div>
        <!-- /.col-lg-12 -->
    </div>
                <div class="row">
                    <div class="col-md-12 col-lg-12 col-sm-12">
                        <div class="white-box">
                            <h3 class="box-title"> <a href="/organizations/create" class="btn btn-info btn-outline">
                                   <span class="fa fa-plus-circle"></span> Add New
                                </a></h3>
                                 @if(Session::has('message'))
                                <div class="alert alert-success alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    {{ Session::get('message') }}
                                </div>
                                @endif
                                <div class="alert alert-warning alert-rounded"> <i class="ti-user"></i>
                                    The Platform column in the table below applies to media organisations only.
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                                </div>
                                <div class="table-responsive">
                                <table class="table table-striped border" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>NAME</th>
                                            <th>ACRONYM</th>
                                            <th>PLATFORM</th>
                                            <th>INDUSTRY</th>
                                            <th>SECTOR</th>
                                            <th>COUNTRY</th>
                                            <th>LANGUAGE</th>
                                            <th>ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                     @foreach($organizations as $index=>$organization)
                                        <tr>
                                            <td>{{$index + 1}}</td>
                                            <td><a href="{{$organization->website}}" target="_blank">{{$organization->name}}</a></td>
                                            <td>{{$organization->acronym}}</td>
                                            <td>@if($organization->platform) {{$organization->platform}} @else N/A @endif</td>
                                            <td>{{$organization->industry->name}}</td>
                                            <td>{{$organization->sector->name}}</td>
                                            <td>{{$organization->country->name}}</td>
                                            <td>{{$organization->language->name}}</td>

                                            <td>
                                                <a href="/organizations/{{$organization->slug}}"> <span class="fa fa-pencil"></span> Edit</a>
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
    </div>
</div>
@endsection
