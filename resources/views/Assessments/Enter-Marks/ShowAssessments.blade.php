@extends('layouts.app')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Assessment Management</li>
        <li class="breadcrumb-item active">Enter Marks</li>
        <li class="breadcrumb-item"><a href="/assessment-marks">{{$subjects_allocated->module->subject_name}}</a></li>
        <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection
@section('content')

<div class="row">
    <div class="offset-1 col-md-10">
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
            <div class="card-body">
                <table class="table table-responsive-sm table-bordered table-striped table-sm" style="width:100%">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Assessment Weight (%)</th>
                            <th>Marks Entered</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($assessment_types as $assessment_type)
                        <tr>
                            <td><strong>{{$assessment_type->name}}</strong></td>
                            <td><strong>{{$assessment_type->weight}}</strong></td>
                            <td>-</td>
                            <td>-</td>
                        </tr>
                            @foreach($assessment_type->assessments as $assessment)
                            <tr>
                                <td>{{$assessment->name}}</td>
                                <td>{{$assessment->weight}}</td>
                                <td>0/30</td>
                                <td>
                                <a href="/assessment-marks/create/{{$assessment->id}}">
                                    View
                                    <svg class="c-icon mr-2">
                                        <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-search')}}"></use>
                                    </svg>
                                </a>
                            </td>
                            </tr>
                            @endforeach

                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection