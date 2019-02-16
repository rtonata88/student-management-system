@extends('layouts.hwpl')

@section('content')
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">CAMPAIGN REPORT</h4> 
        </div>
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        </div>
        <!-- /.col-lg-12 -->
    </div>
        <div class="row">
            <div class="col-md-12 col-lg-12 col-sm-12">
                <div class="white-box">
                    <a href="/campaigns"> <span class="fa fa-arrow-circle-left"></span> Back</a>
                    <h3 class="box-title">CAMPAIGN REPORT [NEW]</h3>
                        <span class="text-primary">This report will be recorded with the following details:</span> <br>
                        <strong>Report By: </strong> {{Auth::user()->name}} <br>
                        <strong>Region: </strong> {{Auth::user()->city->name}} <br> 
                        <strong>Date: </strong> {{date('Y-m-d')}} <br>  <br> 

                        <span class="text-primary">You may change the details above by using the form below.</span> <br>
                        <hr>
                        {!! Form::open(array('route'=>array('campaigns.report.save', $campaign->id), 'class'=>'form-vertical form-material', 'method'=>'post', 'enctype="multipart/form-data"')) !!}
                        <div class="form-group">
                          <div class="col-md-5">
                            {{Form::label('name', 'Campaign Name')}}
                            {{Form::text('name', $campaign->name, ['class' => 'form-control', 'readonly'])}}
                          </div>
                        </div>

                        <div class="form-group">
                          <div class="col-md-5">
                            {{Form::label('city_id', 'Region')}}
                            {{Form::select('city_id', $cities, Auth::user()->city_id, ['class' => 'form-control select'])}}

                          </div>
                        </div>

                        <div class="form-group">
                          <div class="col-md-5">
                            {{Form::label('number_of_collections', 'Number of collections')}}
                            {{Form::number('number_of_collections', 0, ['class' => 'form-control'])}}
                          </div>
                        </div>

                        <div class="form-group">
                          <div class="col-md-5">
                            {{Form::label('report_date', 'Date Collected')}}
                            {{Form::text('report_date', date('Y-m-d'), ['class' => 'form-control mydatepicker'])}}
                            <div class="help-text">
                              <span>Defaulted to Today's date</span>
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
</div>
</div>
@endsection
