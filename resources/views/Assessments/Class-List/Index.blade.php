@extends('layouts.app')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Assessment Management</li>
        <li class="breadcrumb-item active"><a href="/enrolment">Class Lists</a></li>
        <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection
@section('content')

@if(count($class_lists) > 0)
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
                <strong>Class Lists</strong>
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
                        @foreach($class_lists->sortByDesc('academicYear.academic_year') as $class_list)
                        <tr>
                            <td>{{$class_list->module->subject_name}}</td>
                            <td>{{$class_list->module->subject_code}}</td>
                            <td>{{$class_list->center->center_name}}</td>
                            <td>{{$class_list->academicYear->academic_year}}</td>
                            <td>
                                <a href="{{route('class-lists.show', $class_list->id)}}">
                                    View
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
@endif

</div>
@endsection