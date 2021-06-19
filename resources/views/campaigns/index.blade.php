@extends('layouts.hwpl')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item">Management</li>
    <li class="breadcrumb-item active"><a href="/campaigns">Campaigns </a></li>
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
                    <a href="{{route('campaigns.create')}}" class="btn btn-primary pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light"><span class="fa fa-plus"></span> ADD CAMPAIGN</a>
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
                        <th>Campaign Name</th>
                        <th>Number of Collections</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($campaigns as $campaign)
                    <tr>
                        <td>{{$campaign->name}} </td>
                        <td>{{$campaign->report->sum('number_of_collections')}} </td>
                        <td>
                            @if($campaign->status == 1)
                            <span class="badge badge-success">Running</span>
                            @else 
                                <span class="badge">Dormant</span>
                            @endif
                        </td>
                        <td>   
                            <a href="{{route('campaigns.edit', $campaign->id)}}"> 
                            <svg class="c-icon mr-2">
                                            <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-pencil')}}"></use>
                                        </svg>  
                            </a>
                             @if($campaign->status == 1)
                            <a href="{{route('campaigns.report', $campaign->id)}}"> 
                                <svg class="c-icon mr-2">
                                    <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-equalizer')}}"></use>
                                </svg>  
                            </a>
                            @endif
                            <a href="{{route('campaigns.report.view', $campaign->id)}}"> 
                            <svg class="c-icon mr-2">
                                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-search')}}"></use>
                            </svg>  
                            </a>
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
