@extends('layouts.hwpl')

@section('content')
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">CAMPAIGNS</h4> 
        </div>
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <a href="{{route('campaigns.create')}}" class="btn btn-primary pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light"><span class="fa fa-plus"></span> ADD CAMPAIGN</a>
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
                                    <a href="{{route('campaigns.edit', $campaign->id)}}"> <span class="fa fa-edit"></span> Edit</a>
                                     @if($campaign->status == 1)
                                    <strong>|</strong>
                                    <a href="{{route('campaigns.report', $campaign->id)}}"> <span class="fa fa-clock-o"></span> Report</a>
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
</div>
@endsection
