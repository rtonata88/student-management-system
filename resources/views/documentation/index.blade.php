@extends('layouts.hwpl')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item">Management</li>
    <li class="breadcrumb-item active"><a href="/documentation">Documentation </a></li>
    <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection
@section('content')

<div class="row">
    <div class="col-md-12 col-lg-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <div class="float-left">
                    <a href="{{route('documentation.create')}}" class="btn btn-primary pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light"><span class="fa fa-plus"></span> ADD DOCUMENT</a>
                </div>
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
                                <a href="{{route('documentation.edit', $document->id)}}">
                                        <svg class="c-icon mr-2">
                                            <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-pencil')}}"></use>
                                        </svg>  
                                </a>
                                @if($document->files)
                                <a href="{{route('documentation-download', $document->id)}}">
                                    <svg class="c-icon mr-2">
                                        <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-cloud-download')}}"></use>
                                    </svg>
                                </a>
                                @endif
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
