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
                @permission('add-academic-years')
                <a href="{{route('academic-year.create')}}" class="btn" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                    <i class="fas fa-plus"></i> Add New
                </a>
                @endpermission
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
                            <th>Start</th>
                            <th>End</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($academic_years as $academic_year)
                        <tr>
                            <td>{{$academic_year->academic_year}}</td>
                            <td>{{$academic_year->start_date}}</td>
                            <td>{{$academic_year->end_date}}</td>
                            <td>
                                @permission('edit-academic-years')
                                @if($academic_year->status)
                                <span class="badge bg-success">Active</span>
                                @else
                                <span class="badge bg-light text-dark">Not active</span>
                                @endif
                                @endpermission
                            </td>
                            <td>
                                @permission('edit-academic-years')
                                <a href="{{route('academic-year.status', $academic_year->id)}}" class="btn btn-sm" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.25rem 0.5rem;"> <i class="fas fa-edit"></i> Update status</a>
                                @endpermission
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