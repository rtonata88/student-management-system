@extends('layouts.app')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Assessment Management</li>
        <li class="breadcrumb-item"><a href="/assessment-marks">Assessment Marks</a></li>
        <li class="breadcrumb-item active">{{$subjects_allocated->module->subject_name}}</li>
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
            <div class="card-header">
                <strong>Subject Details</strong>
            </div>
            <div class="card-body">
                <table class="table table-responsive-sm table-bordered table-striped table-sm" style="width:100%">
                    <thead>
                        <tr>
                            <th>Subject Name</th>
                            <th>Subject Code</th>
                            <th>Center</th>
                            <th>Year</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{$subjects_allocated->module->subject_name}}</td>
                            <td>{{$subjects_allocated->module->subject_code}}</td>
                            <td>{{$subjects_allocated->center->center_name}}</td>
                            <td>{{$subjects_allocated->academicYear->academic_year}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


{!! Form::open(array('route' => array('assessment-marks.store'), 'method' => 'post')) !!}
<!-- user id -->
<input type="hidden" name="user_id" value="{{$user->id}}">
<div class="row">
    <div class="offset-1 col-md-10">
        <div class="card">
            <div class="card-header">
                <strong>Class List</strong>
            </div>
            <div class="card-body">
                
                <div class="form-group">
                    <strong><label>Select subjects below: </label></strong>
                    <table class="table table-responsive-sm table-bordered table-striped table-sm" style="width:100%">
                        <thead>
                            <tr>
                                <th>Student Number</th>
                                <th>Student Name</th>
                                <th>Student Surname</th>
                                <th>Assessment</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($subjects as $subject)
                            <tr>
                                <td>{{$subject->subject_name}}</td>
                                <td>{{$subject->subject_code}}</td>
                                <td>{{$subject->subject_code}}</td>
                                <td><input type="number" name="marks"></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-sm btn-success">Save</button>
                <a href="/assessment-marks">Cancel</a>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}
</div>
@endsection