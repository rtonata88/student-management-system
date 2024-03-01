@extends('layouts.app')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Assessment Management</li>
        <li class="breadcrumb-item active"><a href="/enrolment">Subject Allocations </a></li>
        <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection
@section('content')
@if(count($subject_allocations) > 0)
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
                <strong>User Subject Allocations information</strong>
            </div>
            <div class="card-body">
                <table class="table table-responsive-sm table-bordered table-striped table-sm" style="width:100%">
                    <thead>
                        <tr>
                            <th>Subject Name</th>
                            <th>Subject Code</th>
                            <th>Center</th>
                            <th>Year</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($subject_allocations->sortByDesc('academicYear.academic_year') as $allocation)
                        <tr>
                            <td>{{$allocation->module->subject_name}}</td>
                            <td>{{$allocation->module->subject_code}}</td>
                            <td>{{$allocation->center->center_name}}</td>
                            <td>{{$allocation->academicYear->academic_year}}</td>
                            <td>
                                <a href="/subject-allocations/un-allocate/{{$allocation->id}}">Un-Allocate</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endif

{!! Form::open(array('route' => array('subject-allocations.store'), 'method' => 'post')) !!}
<!-- user id -->
<input type="hidden" name="user_id" value="{{$user->id}}">
<div class="row">
    <div class="offset-2 col-md-8">
        <div class="card">
            <div class="card-header">
                <strong>Subject Allocations</strong>
            </div>
            <div class="card-body">
                
                <div class="form-group">
                    <strong><label>Select subjects below: </label></strong>
                    <table class="table table-responsive-sm table-bordered table-striped table-sm" style="width:100%">
                        <thead>
                            <tr>
                                <th>Subject Name</th>
                                <th>Subject Code</th>
                                <th>Center</th>
                                <th>Year</th>
                                <th class="text-center">Tick to Allocate</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($subjects as $subject)
                            <tr>
                                <td>{{$subject->subject_name}}</td>
                                <td>{{$subject->subject_code}}</td>
                                <td>
                                    <select class="form-control select form-control-sm input-no-border" name="center[{{$subject->id}}]">
                                        <option>Select</option>
                                        @foreach($centers as $center)
                                        <option value="{{$center->id}}">{{$center->center_name}}</option>
                                        @endforeach
                                    </select>
                                </td>

                                <td>
                                    <select class="form-control select form-control-sm input-no-border" name="academic_year[{{$subject->id}}]">
                                        <option>Select</option>
                                        @foreach($academic_years as $year)
                                        <option value="{{$year->id}}">{{$year->academic_year}}</option>
                                        @endforeach
                                    </select>
                                </td>

                                <td class=" text-center">
                                    <input type="checkbox" value="{{$subject->id}}" name="subject[]">                                    
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-sm btn-success">Confirm Allocation</button>
                <a href="/subject-allocations">Cancel</a>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}
</div>
@endsection