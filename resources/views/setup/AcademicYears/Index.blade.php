@extends('layouts.app')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Setup</li>
        <li class="breadcrumb-item active">Academic Years </li>
        <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection
@section('content')
<div class="row">
    <div class="col-md-12 col-xs-12">
        <div class="card">
            <div class="card-header">
                <a href="{{route('academic-year.create')}}" class="btn btn-primary">
                    Add New
                </a>
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
                            <th>Academic Year</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($academic_years as $academic_year)
                        <tr>
                            <td>{{$academic_year->academic_year}}</td>
                            <td>
                                @if($academic_year->status)
                                <span class="badge bg-success">Active</span>
                                @else
                                <span class="badge bg-light text-dark">Not active</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{route('academic-year.status', $academic_year->id)}}"> <span class="fa fa-pencil"></span> Update status</a>
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