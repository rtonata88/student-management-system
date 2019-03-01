@extends('layouts.hwpl')

@section('content')
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">DOCUMENTATION REPORT</h4> 
        </div>
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li class="active">Documentations</li>
            </ol>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="white-box">
        <div class="row">
            <div class="panel panel-default" style=" border: 1px solid #ddd">
                <div class="panel-heading" style="background-color: #f5f5f5;">
                    REPORT FILTER
                </div>

                <div class="panel-wrapper collapse in">
                    <div class="panel-body">

                        {!! Form::open(array('route' => array('search-documentation'), 'method' => 'post', 'class'=> 'form-vertical form-material', 'enctype="multipart/form-data"')) !!}

                        <div class="row">
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="email1" class="col-sm-3 text-right control-label col-form-label">
                                     TYPE</label>
                                    <div class="col-sm-4">
                                          {{Form::select('documentation', $documentation_type, null, ['class' => 'form-control select','placeholder'=>'All Documentations'])}}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="email1" class="col-sm-3 text-right control-label col-form-label">COUNTRY</label>
                                    <div class="col-sm-4">
                                        {{Form::select('country', $countries, null, ['class' => 'form-control select','placeholder'=>'All Countries'])}}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="email1" class="col-sm-3 text-right control-label col-form-label">SECTOR</label>
                                    <div class="col-sm-4">
                                        {{Form::select('sector', $sectors, null, ['class' => 'form-control select','placeholder'=>'All Sectors'])}}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="email1" class="col-sm-3 text-right control-label col-form-label">DATE FROM</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control mydatepicker" name="date_from">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="email1" class="col-sm-3 text-right control-label col-form-label">DATE TO</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control mydatepicker" name="date_to">
                                    </div>
                                </div>
                               
                              
                                <div class="form-actions">
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-info">SEARCH</button>
                                        <button type="reset" class="btn btn-dark">Reset</button>
                                    </div>
                                </div>

                            </div>
                        </div>

                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
            @if($documentations)
            <strong>{{$documentations->total()}} Results Found</strong>, <a href="{{route('export-documentations')}}">export to excel</a>
            <div class="col-md-12 col-lg-12 col-sm-12">
                <table id="dataTable2" class="table table-striped table-bordered dataTable" style="width:100%"> 
                    <thead>
                        <tr>
                            <th>Document Type</th>
                            <th>Firstnames</th>
                            <th>Lastname</th>
                            <th>Number</th>
                            <th>Email</th>
                            <th>Sector</th>
                            <th>Effective Date</th>
                            <th>Country</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($documentations as $documentation)
                        <tr>
                            <td>{{$documentation->type}} </td>
                            <td>{{$documentation->fullname}} </td>
                            <td>{{$documentation->lastname}}</td>
                            <td>{{$documentation->mobile_no}}</td>
                            <td>{{$documentation->email}}</td>
                            <td>{{$documentation->sector}}</td>
                            <td>{{$documentation->effective_date}}</td>
                            <td>{{$documentation->country}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
            @endif
        </div>
    </div>
</div>
@endsection
