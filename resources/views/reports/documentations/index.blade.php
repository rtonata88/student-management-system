@extends('layouts.app')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item">Reports</li>
    <li class="breadcrumb-item active">Documentation </li>
    <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection
@section('content')
<div class="row">
    <div class="col-md-4 col-xs-12">
        <div class="card">
            <div class="card-header">
                <strong>Report filter</strong> 
            </div>
            <div class="card-body">
                {!! Form::open(array('route' => array('search-documentation'), 'method' => 'post', 'class'=> 'form-vertical form-material', 'enctype="multipart/form-data"')) !!}
                                <div class="form-group">
                                    <label for="email1" class="text-right control-label col-form-label">
                                     Type</label>
                                    {{Form::select('documentation', $documentation_type, null, ['class' => 'form-control form-control-sm select','placeholder'=>'All Documentations'])}}
                                </div>
                                <div class="form-group">
                                    <label for="email1" class="text-right control-label col-form-label">Country</label>
                                        {{Form::select('country', $countries, null, ['class' => 'form-control form-control-sm select','placeholder'=>'All Countries'])}}
                                </div>
                                <div class="form-group">
                                    <label for="email1" class="text-right control-label col-form-label">Sector</label>
                                        {{Form::select('sector', $sectors, null, ['class' => 'form-control form-control-sm select','placeholder'=>'All Sectors'])}}
                                </div>
                                <div class="form-group">
                                    <label for="email1" class="text-right control-label col-form-label">Date from</label>
                                        <input type="date" class="form-control form-control-sm" name="date_from">
                                </div>
                                <div class="form-group">
                                    <label for="email1" class="text-right control-label col-form-label">Date to</label>
                                        <input type="date" class="form-control form-control-sm" name="date_to">
                                </div>
                               
                              <hr>
                                <div class="form-actions">
                                        <button type="submit" class="btn btn-info btn-sm">Search</button>
                                        <button type="reset" class="btn btn-sm">Reset</button>
                                </div>
                        {!! Form::close() !!}
            </div>
        </div>
    </div>
    <div class="col-md-8 col-xs-12">
        <div class="card">
            <div class="card-header">
                <strong>Report results</strong> 
            </div>
            <div class="card-body">
                 @if($documentations)
            <strong>{{$documentations->total()}} Results Found</strong>, <a href="{{route('export-documentations')}}">export to excel</a>
                <table class="table table-responsive-sm table-bordered table-striped table-sm" style="width:100%">
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

            @endif
            </div>
        </div>
    </div>
</div>
@endsection