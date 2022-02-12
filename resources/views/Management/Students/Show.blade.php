@extends('layouts.app')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Management</li>
        <li class="breadcrumb-item"><a href="/students">Student Info </a></li>
        <li class="breadcrumb-item active">{{$student->student_names}} {{$student->surname}}</li>
        <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-2 col-xs-12"></div>
    <div class="col-md-8 col-xs-12">
        <div class="card">
            <div class="card-header">
                <strong>Student information</strong> | <a href="{{route('students.edit', $student->id)}}">Edit</a>
            </div>
            <div class="card-body">
                <table class="table table-responsive-sm table-bordered table-sm" style="width:100%">
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5);width:250px;">Student Number </th>
                        <td>{{$student->student_number2}}</td>
                    </tr>
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5);width:250px;">Reference Number </th>
                        <td>{{$student->student_number2}}</td>
                    </tr>
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">Student names </th>
                        <td>{{$student->student_names}}</td>
                    </tr>
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">Surname </th>
                        <td>{{$student->surname}}</td>
                    </tr>
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">Initials </th>
                        <td>{{$student->initials}}</td>
                    </tr>
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">Email </th>
                        <td>{{$student->contact_email}}</td>
                    </tr>
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">Contact number </th>
                        <td>{{$student->contact_number}}</td>
                    </tr>
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">Gender </th>
                        <td>{{$student->gender}}</td>
                    </tr>
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">Date of Birth</th>
                        <td>{{$student->date_of_birth}}</td>
                    </tr>
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">Birth Certificate</th>
                        <td>{{$student->birth_certificate}}</td>
                    </tr>
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">ID Number </th>
                        <td>{{$student->id_number}}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <strong>Guardian information</strong>
            </div>
            <div class="card-body qualifications-table">
                @foreach($student->guardian as $guardian)
                <table class="table table-responsive-sm table-bordered table-sm" style="width:100%">
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5); width:250px;">Name </th>
                        <td>{{$guardian->guardian_names}}</td>
                    </tr>
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">Surname </th>
                        <td>{{$guardian->surname}}</td>
                    </tr>
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">Relationship </th>
                        <td>{{$guardian->relationship}}</td>
                    </tr>
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">Contact number </th>
                        <td>{{$guardian->contact_number}}</td>
                    </tr>
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">Contact email </th>
                        <td>{{$guardian->contact_email}}</td>
                    </tr>
                </table>
                @endforeach
            </div>
            <!--
                UNCOMMENT this line if you wish to add more than one guardian 
                <div class="card-body" id="guardian-section">
            </div> 
            <div class="card-footer">
                <button typ="button" class="btn btn-sm btn-primary" id="add-qualification-btn">Add qualification</button>
            </div>-->
            <div class="card-footer">
                <a href="/students">Back</a>
            </div>
        </div>

    </div>
</div>
</div>
{!! Form::close() !!}
@endsection