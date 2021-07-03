@extends('layouts.hwpl')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item">Management</li>
    <li class="breadcrumb-item active"><a href="/organizations">Organisation </a></li>
    <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-4 col-xs-12">
        <div class="card">
            <div class="card-header">
                <strong>Filter</strong>
            </div>
            <div class="card-body">
                {!! Form::open(array('route' => array('organizations.index'), 'method' => 'get','class'=> 'form-vertical form-material')) !!}
                    <div class="form-group">
                        {{Form::text('name', null, ['class' => 'form-control form-control-sm', 'placeholder' => 'Organisation name'])}}
                    </div>
                     <button type="submit" class="btn btn-sm btn-success">
                            Search
                        </button>
                        <a href="/organizations" class="btn btn-sm">
                            Clear
                        </a>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <div class="col-md-8 col-xs-12">
        <div class="card">
            <div class="card-header">
                <a href="/organizations/create" class="btn btn-primary">
                    ADD ORGANISATION
                </a>
            </div>
            <div class="card-body">
                @if(Session::has('message'))
                    <div class="alert alert-success alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> 
                        {{ Session::get('message') }}
                    </div>                            
                @endif
                <div class="alert alert-warning alert-rounded"> <i class="ti-user"></i>
                    The Platform column in the table below applies to media organisations only.
                </div>
                <table class="table table-responsive-sm table-bordered table-striped table-sm" style="width:100%">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Platform</th>
                            <th>Industry</th>
                            <th width="100px">Country</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($organizations as $index=>$organization)
                        <tr>
                            <td><a href="{{$organization->website}}" target="_blank">{{$organization->name}}</a></td>
                            <td>@if($organization->platform) {{$organization->platform}} @else N/A @endif</td>
                            <td>{{$organization->industry->name}}</td>
                            <td>{{$organization->country->name}}</td>
                            <td>
                             <a href="/organizations/{{$organization->slug}}">
                                    <svg class="c-icon mr-2">
                                        <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-pencil')}}"></use>
                                    </svg>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $organizations->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
