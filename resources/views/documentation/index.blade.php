@extends('layouts.hwpl')

@section('content')
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">DOCUMENTATIONS</h4> 
        </div>
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <a href="{{route('documentation.create')}}" class="btn btn-primary pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light"><span class="fa fa-plus"></span> ADD DOCUMENT</a>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
        @foreach($statistics as $document_counter)
        <div class="col-lg-3 col-sm-6 col-xs-12">
            <div class="white-box analytics-info">
                <h3 class="box-title">{{$document_counter->type}}</h3>
                <ul class="list-inline two-part">
                    <li>
                        <div class="sparklinedash"></div>
                    </li>
                    <li class="text-right"><i class="ti-arrow-up text-success"></i> 
                        <span class="counter text-info">
                            {{$document_counter->counter}}
                        </span>
                    </li>
                </ul>
            </div>
        </div>
    @endforeach
    </div>
    

    <div class="row white-box">
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
                                <th>Document Type</th>
                                <th>Effective Date</th>
                                <th>Profile</th>
                                <th>Position</th>
                                <th>Organization</th>
                                <th>Country</th>
                                <th>City</th>
                                <th>Location</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($documents as $document)
                            <tr>
                                <td>{{$document->document_types->type}} </td>
                                <td>{{$document->effective_date}}</td>
                                <td>{{$document->profile->fullname}} {{$document->profile->lastname}}</td>
                                <td>{{$document->profile->position}}</td>
                                <td>{{$document->profile->organization->name}}</td>
                                <td>{{$document->profile->country->name}}</td>
                                <td>{{$document->profile->city->name}}</td>
                                <td>{{$document->file_location}}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button aria-haspopup="true" aria-expanded="false" data-toggle="dropdown" class="btn btn-info btn-outline dropdown-toggle waves-effect waves-light" type="button"> <i class="fa fa-align-justify m-r-5"></i> <span class="caret"></span></button>
                                        <ul role="menu" class="dropdown-menu dropdown-menu-right">
                                            <li><a href="{{route('documentation.edit', $document->id)}}">Edit</a></li>
                                            @if($document->files)
                                            <li><a href="{{route('documentation-download', $document->id)}}">Download</a></li>
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
