@extends('layouts.hwpl')

@section('content')
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">EVENT TYPES</h4> </div>
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="/setup">Setup</a></li>
                 <li class="active">Event Type</li>
            </ol>
        </div>
        <!-- /.col-lg-12 -->
    </div>
                <div class="row">
                    <div class="col-md-12 col-lg-12 col-sm-12">
                        <div class="white-box">
                            <h3 class="box-title"> <a href="/event-types/create" class="btn btn-info btn-outline">
                                   <span class="fa fa-plus-circle"></span> Add New
                                </a></h3>
                                 @if(Session::has('message'))
                                <div class="alert alert-success alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> 
                                    {{ Session::get('message') }}
                                </div>                            
                                @endif
                                <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>EVENT TYPE NAME</th>
                                            <th>LANGUAGE</th>
                                            <th>ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                     @foreach($event_types as $index=>$event_type)
                                        <tr>
                                            <td>{{$index + 1}}</td>
                                            <td>{{$event_type->type}}</td>
                                            <td>{{$event_type->language->name}}</td>
                                           
                                            <td>
                                                <a href="/event-types/{{$event_type->slug}}"> <span class="fa fa-pencil"></span> Edit</a>
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
