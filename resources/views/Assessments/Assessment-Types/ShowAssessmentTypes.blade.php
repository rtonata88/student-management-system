@extends('layouts.app')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Assessment Management</li>
        <li class="breadcrumb-item">Assessment Types</li>
        <li class="breadcrumb-item active"><a href="/assessment-types">{{$subject_allocation->module->subject_name}}</a></li>
        <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection
@section('content')

<div class="row">
    <div class="offset-2 col-md-8">
        @if (Session::has('success'))
        <div class="alert alert-success">
            {{Session::get('success')}}
        </div>
        @elseif(Session::has('error'))
        <div class="alert alert-danger">
            {{Session::get('error')}}
        </div>
        @endif
        <div class="card">
            <div class="card-header">
                <a href="/assessment-types/create/{{$subject_allocation->id}}" class="btn btn-primary">
                    Add New
                </a>
            </div>
            <div class="card-body">
                <table class="table table-responsive-sm table-bordered table-striped table-sm" style="width:100%">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Weight</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($assessment_types as $assessment_type)
                        <tr>
                            <td>{{$assessment_type->name}}</td>
                            <td>{{$assessment_type->weight}}</td>
                            <td>
                                <a href="/assessment-types/edit/{{$assessment_type->id}}">
                                    Edit
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