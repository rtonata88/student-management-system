@extends('layouts.app')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Reports</li>
        <li class="breadcrumb-item active">Students </li>
        <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection
@section('content')
<div class="row">
    <div class="col-md-3 col-xs-12">
        <div class="card">
            <div class="card-header">
                <strong>Report filter</strong>
            </div>
            <div class="card-body">
                {!! Form::open(array('route' => array('reports.students.search'), 'method' => 'post', 'class'=> 'form-vertical form-material')) !!}
                <div class="form-group">
                    <label class="text-right control-label col-form-label">Academic year</label>
                    {{Form::select('academic_year', $academic_years, date('Y'), ['class' => 'form-control form-control-sm select', 'placeholder'=>"All years"])}}
                </div>

                <div class="form-group">
                    <label class="text-right control-label col-form-label">Registration status</label>
                    {{Form::select('registration_status', ['Registered' => 'Registered', 'Canceled' => 'Cancelled'], null, ['class' => 'form-control form-control-sm select','placeholder'=>"Doesn't matter"])}}
                </div>

                <div class="form-group">
                    <label class="text-right control-label col-form-label">Registered Subjects</label>
                    {{Form::select('subject_id', $subjects, null, ['class' => 'form-control form-control-sm select','placeholder'=>"All subjects"])}}
                </div>

                <hr>
                <div class="form-actions">
                    <button type="submit" class="btn btn-success btn-sm">Search</button>
                    <a href="{{route('reports.students.index')}}" class="btn btn-sm">Clear</a>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <div class="col-md-9 col-xs-12">
        <div class="card">
            <div class="card-header">
                <strong>Report results</strong>
            </div>
            <div class="card-body">
                @if($subject_registration)
                <strong>{{$subject_registration->count()}} Results Found</strong>, <a href="{{route('reports.students.export')}}">Export to excel</a>
                <table class="table table-responsive-sm table-bordered table-striped table-sm" style="width:100%">
                    <thead>
                        <tr>
                            <th>Student number</th>
                            <th>Names</th>
                            <th>Center</th>
                            <th>Subject</th>
                            <th>Registration Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($subject_registration->take(25) as $registration)

                        <tr>
                            <td>{{$registration->student->student_number2}}</td>
                            <td>{{$registration->student->student_names}} {{$registration->student->surname}}</td>
                            <td>
                                {{$registration->registration
                                                ->where('student_id', $registration->student_id)
                                                ->first()
                                                ->center
                                                ->center_name}}
                            </td>
                            <td>{{$registration->subject->subject_name}}</td>
                            <td>{{$registration->registration_date}}</td>
                            <td>{{$registration->registration_status}}</td>
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