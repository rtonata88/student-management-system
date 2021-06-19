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
                <strong>New Campaign Report</strong> | <a href="/campaigns">  
                                <svg class="c-icon mr-2">
                                    <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-arrow-left')}}"></use>
                                </svg> Back</a>
            </div>
            <div class="card-body">
                <span class="text-primary">This report will be recorded with the following details:</span> <br>
                <strong>Report By: </strong> {{Auth::user()->name}} <br>
                <strong>Region: </strong> {{Auth::user()->city->name}} <br> 
                <strong>Date: </strong> {{date('Y-m-d')}} <br>  <br> 

                <span class="text-primary">You may change the details above by using the form below.</span> <br>
                <hr>
                {!! Form::open(array('route'=>array('campaigns.report.save', $campaign->id), 'class'=>'form-vertical form-material', 'method'=>'post', 'enctype="multipart/form-data"')) !!}
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        {{Form::label('name', 'Campaign Name')}}
                        {{Form::text('name', $campaign->name, ['class' => 'form-control', 'readonly'])}}
                      </div>
                    </div>
                  </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                    {{Form::label('city_id', 'Region')}}
                    {{Form::select('city_id', $cities, Auth::user()->city_id, ['class' => 'form-control select'])}}
                    </div>
                  </div>
                </div>
                   <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                      {{Form::label('number_of_collections', 'Number of collections')}}
                      {{Form::number('number_of_collections', 0, ['class' => 'form-control'])}}
                    </div>
                  </div>
                  </div>

                   <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        {{Form::label('report_date', 'Date Collected')}}
                        {{Form::text('report_date', date('Y-m-d'), ['class' => 'form-control mydatepicker'])}}
                        <div class="help-text">
                          <span>Defaulted to Today's date</span>
                        </div>
                      </div>
                    </div>
                  </div>

                  <button type="submit" class="btn btn-success"><span class="fa fa-check-circle"></span> Save</button>
                  <button type="reset" class="btn btn-warning"><span class="fa fa-ban"></span> Reset</button>
              {!! Form::close() !!}
          </div>
      </div>
    </div>
</div>
@endsection
