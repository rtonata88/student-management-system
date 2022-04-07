@extends('layouts.app')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Management</li>
        <li class="breadcrumb-item active"><a href="/students">Students </a></li>
        <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection
@section('content')
<div class="row">
    <div class="col-md-3 col-xs-12">
        <div class="card">
            <div class="card-header">
                <strong>Filter</strong>
            </div>
            <div class="card-body">
                {!! Form::open(array('route' => array('students.filter'), 'method' => 'post', 'class'=> 'form-vertical form-material')) !!}
                <div class="form-group">
                    {{Form::text('student_number', null, ['class' => 'form-control form-control-sm', 'placeholder' => 'Student number'])}}
                </div>
                <div class="form-group">
                    {{Form::text('names', null, ['class' => 'form-control form-control-sm', 'placeholder' => 'Student name'])}}
                </div>
                <button type="submit" class="btn btn-sm btn-success">
                    Search
                </button>
                <a href="/students" class="btn btn-sm">
                    Clear
                </a>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <div class="card">
            <div class="card-header">
                @permission('add-student')
                <div class="float-left">
                    <a href="{{route('students.create')}}" class="btn btn-primary pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light"><span class="fa fa-plus"></span> ADD STUDENT</a>
                </div>
                @endpermission
            </div>
            <div class="card-body">
                <table class="table table-responsive-sm table-bordered table-striped table-sm" style="width:100%">
                    <thead>
                        <tr>
                            <th>Student number</th>
                            <th>Student names</th>
                            <th>Surname</th>
                            <th>DOB</th>
                            <th>Contact Number</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $student)
                        <tr>
                            <td>{{$student->student_number2}}</td>
                            <td>{{$student->student_names}}</td>
                            <td>{{$student->surname}}</td>
                            <td>{{$student->date_of_birth}}</td>
                            <td>{{$student->contact_number}}</td>
                            <td>
                                @permission('show-student')
                                <a href="{{route('students.show', $student->id)}}">
                                    <svg class="c-icon mr-2">
                                        <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-search')}}"></use>
                                    </svg>
                                </a>
                                @endpermission
                                @permission('edit-student')
                                <a href="{{route('students.edit', $student->id)}}">
                                    <svg class="c-icon mr-2">
                                        <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-pencil')}}"></use>
                                    </svg>
                                </a>
                                @endpermission
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{$students->links()}}
            </div>
        </div>
    </div>
</div>
@endsection