@extends('layouts.app')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Setup</li>
        <li class="breadcrumb-item active">Subjects </li>
        <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection
@section('content')
<div class="row">
    <div class="col-md-12 col-xs-12">
        <div class="card">
            <div class="card-header">
                <a href="/subjects/create" class="btn btn-primary">
                    Add New
                </a>
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
                            <th>Subject name</th>
                            <th>Code</th>
                            <th>Subject Fee</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($subjects as $index=>$subject)
                        <tr>
                            <td>{{$subject->subject_name}}</td>
                            <td>{{$subject->subject_code}}</td>
                            <td>{{$subject->subject_fees}}</td>
                            <td>
                                <a href="{{route('subjects.edit', $subject->id)}}"> <span class="fa fa-pencil"></span> Edit</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection