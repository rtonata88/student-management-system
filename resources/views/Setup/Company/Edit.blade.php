@extends('layouts.app')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Setup</li>
        <li class="breadcrumb-item active">Company Setup</li>
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
                <strong>Company information</strong> | <a href="{{route('company.show', 1)}}">Back</a>
            </div>
            {!! Form::model($company, array('route' => array('company.update', 1), 'method' => 'post', 'enctype="multipart/form-data"')) !!}
            <input type="hidden" name="_method" value="patch">
            <div class="card-body">
                <table class="table table-responsive-sm table-bordered table-sm" style="width:100%">
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5); width: 200px">Company name <span class="text-danger">*</span></th>
                        <td>{{Form::text('company_name',null, ['class' => 'form-control input-no-border', 'required', 'placeholder' => 'Company name'])}}</td>
                    </tr>
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">Address <span class="text-danger">*</span></th>
                        <td>
                            {{Form::text('address1',null, ['class' => 'form-control input-no-border', 'required', 'placeholder' => 'Address Line 1'])}}
                            {{Form::text('address2',null, ['class' => 'form-control input-no-border', 'required', 'placeholder' => 'Address Line 2'])}}
                            {{Form::text('address3',null, ['class' => 'form-control input-no-border', 'placeholder' => 'Address Line 3'])}}
                            {{Form::text('address4',null, ['class' => 'form-control input-no-border', 'placeholder' => 'Address Line 4'])}}
                        </td>
                    </tr>
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">Contact number <span class="text-danger">*</span> </th>
                        <td>{{Form::text('contact_number', null, ['class' => 'form-control input-no-border', 'required', 'placeholder' => 'Contact number'])}}</td>
                    </tr>
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">Fax </th>
                        <td>{{Form::text('fax_number', null, ['class' => 'form-control input-no-border', 'placeholder' => 'Fax number'])}}</td>
                    </tr>
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">Email </th>
                        <td> {{Form::email('email', null, ['class' => 'form-control input-no-border', 'placeholder' => 'Emaill address'])}}</td>
                    </tr>
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">Logo </th>
                        <td>
                            {{Form::file('logo', null, ['class' => 'form-control'])}}
                        </td>
                    </tr>
                </table>
            </div>
            <div class="card-footer">
                @permission('edit-company')
                <button type="submit" class="btn btn-sm btn-success">Save</button>
                @endpermission
                <a href="{{route('company.show', 1)}}">Cancel</a>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
</div>
@endsection