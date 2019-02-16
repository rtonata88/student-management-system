@extends('layouts.hwpl')

@section('content')
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">CAMPAIGNS</h4> 
        </div>
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        </div>
        <!-- /.col-lg-12 -->
    </div>
        <div class="row">
            <div class="col-md-12 col-lg-12 col-sm-12">
                <div class="white-box">
                    <a href="/campaigns"> <span class="fa fa-arrow-circle-left"></span> Back</a>
                    <h3 class="box-title">{{$campaign->name}} [UPDATE]</h3>
                    {!! Form::model($campaign, array('route'=>array('campaigns.update', $campaign->id), 'class'=>'form-vertical form-material', 'method'=>'PATCH', 'enctype="multipart/form-data"')) !!}
                        <div class="form-group">
                          <div class="col-md-5">
                            {{Form::label('name', 'Campaign Name')}}
                            {{Form::text('name', null, ['class' => 'form-control'])}}
                          </div>
                        </div>

                        <div class="form-group">
                          <div class="col-md-5">
                            {{Form::label('status', 'Status')}}
                            {{Form::select('status', [1=>'Active', 0=>'Not Active'], null, ['class' => 'form-control select'])}}
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
