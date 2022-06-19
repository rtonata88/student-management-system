@extends('layouts.app')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Management</li>
        <li class="breadcrumb-item active"><a href="/debit-memos">Debit Memos </a></li>
        <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection
@section('content')
<div class="row">
    <div class="col-md-3 col-xs-12">
        <div class="card">
            <div class="card-header">
                <strong>Search</strong>
            </div>
            <div class="card-body">
                {!! Form::open(array('route' => array('debit-memos.filter'), 'method' => 'post', 'class'=> 'form-vertical form-material')) !!}
                <div class="form-group">
                    {{Form::text('student_number', null, ['class' => 'form-control form-control-sm', 'placeholder' => 'Student number'])}}
                </div>
                <div class="form-group">
                    {{Form::text('names', null, ['class' => 'form-control form-control-sm', 'placeholder' => 'Student names'])}}
                </div>
                <button type="submit" class="btn btn-sm btn-success">
                    Search
                </button>
                <a href="/debit-memos" class="btn btn-sm">
                    Clear
                </a>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    <div class="col-md-9 col-sm-12">
        @if(Session::has('message'))
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            {{ Session::get('message') }}
        </div>
        @endif
        @if(isset($students))
        <div class="card">
            <div class="card-header">
                <strong> Select student </strong>
            </div>
            <div class="card-body">
                <table class="table table-responsive-sm table-bordered table-striped table-hover table-sm" style="width:100%">
                    <thead>
                        <tr>
                            <th>Student number</th>
                            <th>Student names</th>
                            <th>Surname</th>
                            <th>DOB</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $student)
                        <tr style="cursor: pointer" onclick="window.location='{{route('debit-memos.edit', $student->id)}}'">
                            <td>{{$student->student_number2}}</td>
                            <td>{{$student->student_names}}</td>
                            <td>{{$student->surname}}</td>
                            <td>{{$student->date_of_birth}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection