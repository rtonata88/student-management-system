@extends('layouts.hwpl')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item">Management</li>
    <li class="breadcrumb-item active"><a href="/campaigns">Campaigns </a></li>
    <li class="breadcrumb-item">View report</li>
    <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection
@section('content')
<div class="row">
    <div class="col-md-12 col-lg-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <strong>View Campaign Report</strong> | <a href="/campaigns">  
                                <svg class="c-icon mr-2">
                                    <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-arrow-left')}}"></use>
                                </svg> Back</a>
            </div>
            <div class="card-body">
            <table class="table table-responsive-sm table-bordered table-striped table-sm" style="width:100%">
                <thead>
                    <tr>
                        <th>Campaign name</th>
                        <th>Reported by</th>
                        <th>Region</th>
                        <th>Date reported</th>
                        <th>Count</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($campaign_report as $report)
                    <tr>
                        <td>{{$report->campaign->name}} </td>
                        <td>{{$report->reportedBy->name}} </td>
                        <td>{{$report->region->name}} </td>
                        <td>{{$report->report_date}}</td>
                        <td>{{$report->number_of_collections}}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <td colspan="3"></td>
                        <td><strong>Total</strong></td>
                        <td><strong>{{$campaign_report->sum('number_of_collections')}}</strong></td>
                    </tr>
                </tbody>
            </table>
            </div>
      </div>
    </div>
</div>
@endsection
