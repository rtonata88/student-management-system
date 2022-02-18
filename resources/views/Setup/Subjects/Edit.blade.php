@extends('layouts.app')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Setup</li>
        <li class="breadcrumb-item"> <a href="/subjects"> Subjects </a></li>
        <li class="breadcrumb-item active">Edit </li>
        <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection
@section('content')
<div class="offset-3 row">
    <div class="col-md-8 col-xs-12">
        <div class="card-header">
            <strong>Subjects</strong> | <a href="/subjects"> Back</a>
        </div>
        {!! Form::model($subject, array('route'=>array('subjects.show', $subject->id), 'class'=>'form-horizontal', 'method'=>'PATCH')) !!}
        <div class="card">
            <div class="col-md-12 mt-2">
                <div class="form-group">
                    {{Form::label('subject_name', 'Subject name')}}
                    {{Form::text('subject_name', null, ['class' => 'form-control'])}}
                </div>
            </div>
            <div class="col-md-12 mt-2">
                <div class="form-group">
                    {{Form::label('subject_code', 'Subject code')}}
                    {{Form::text('subject_code', null, ['class' => 'form-control'])}}
                </div>
            </div>
            <div class="col-md-12 mt-2">
                <div class="form-group">
                    {{Form::label('subject_fees', 'Subject fees')}}
                    {{Form::number('subject_fees', null, ['class' => 'form-control'])}}
                </div>
            </div>

            <div class="col-md-12 mt-2">
                <div class="form-group">
                    {{Form::label('subject_fees', 'Subject extra fees')}}
                    <table class="table table-responsive-sm table-bordered table-striped table-sm" style="width:100%">
                        <thead>
                            <tr>
                                <th>Fee desscription</th>
                                <th>Amount</th>
                                <th class="text-center">Tick to Add</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($fees as $fee)
                            <tr>
                                <td>{{$fee->fee_description}}</td>
                                <td>{{$fee->amount}}</td>
                                <td class="text-center">
                                    <input type="checkbox" value="{{$fee->id}}" @if(in_array($fee->id, $module_extra_fees)) checked @endif name="fee_id[]">
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                @permission('edit-subjects')
                <button type="submit" class="btn btn-success"><span class="fa fa-check-circle"></span> Save</button>
                @endpermission
                <button type="reset" class="btn"><span class="fa fa-ban"></span> Reset</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection