@extends('layouts.app')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Access Management</li>
        <li class="breadcrumb-item active"><a href="/admin-clerks">Admin Clerks </a></li>
        <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection
@section('content')
{!! Form::open(array('route' => array('admin-clerks.store'), 'method' => 'post', 'class'=> 'form-vertical form-material', 'enctype="multipart/form-data"')) !!}
<div class="row">
    <div class="col-md-2 col-xs-12"></div>
    <div class="col-md-8 col-xs-12">
        <div class="card">
            <div class="card-header">
                <strong>Biographical information</strong>
            </div>
            <div class="card-body">
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <table class="table table-responsive-sm table-bordered table-sm" style="width:100%">
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">Firstname <span class="text-danger">*</span></th>
                        <td>{{Form::text('name',null, ['class' => 'form-control', 'required', 'placeholder' => 'Firstname'])}}</td>
                    </tr>
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">Surname <span class="text-danger">*</span></th>
                        <td>{{Form::text('surname',null, ['class' => 'form-control', 'required', 'placeholder' => 'Surname'])}}</td>
                    </tr>
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">Email <span class="text-danger">*</span></th>
                        <td>{{Form::email('email',null, ['class' => 'form-control', 'required', 'placeholder' => 'Email'])}}</td>
                    </tr>
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">Country <span class="text-danger">*</span></th>
                        <td>{{Form::select('country_id', $countries, null, ['class' => 'form-control select'])}}</td>
                    </tr>     
                </table>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <strong>Qualification information</strong>
            </div>
            <div class="card-body qualifications-table">
                <table class="table table-responsive-sm table-bordered table-sm" style="width:100%">
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">Qualification title <span class="text-danger">*</span></th>
                        <td>
                            {{Form::text('qualification_name[]',null, ['class' => 'form-control', 'placeholder'=>'Qualification name', 'required'])}}
                            <input type="hidden" name="model" value="AdminClerk">
                        </td>
                    </tr>
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">Institution <span class="text-danger">*</span></th>
                        <td>
                            {{Form::text('institution[]',null, ['class' => 'form-control', 'placeholder'=>'Institution', 'required'])}}
                        </td>
                    </tr>
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">Start year <span class="text-danger">*</span></th>
                        <td>
                            {{Form::number('start_year[]',null, ['class' => 'form-control', 'placeholder'=>'Start year', 'required'])}}
                        </td>
                    </tr>
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">End year <span class="text-danger">*</span></th>
                        <td>
                            {{Form::number('end_year[]',null, ['class' => 'form-control', 'placeholder'=>'End year', 'required'])}}
                        </td>
                    </tr>
                </table>
            </div>
            <div class="card-body" id="qualifications-section">

            </div>
            <div class="card-footer">
                <button typ="button" class="btn btn-sm btn-primary" id="add-qualification-btn">Add qualification</button>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <strong>Create user account</strong>
            </div>
            <div class="card-body">
                <table class="table table-responsive-sm table-bordered table-sm" style="width:100%">
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">Password <span class="text-danger">*</span></th>
                        <td>
                            {{Form::password('password',null, ['class' => 'form-control', 'required'])}}
                        </td>
                    </tr>
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">Confirm password <span class="text-danger">*</span></th>
                        <td>
                            {{Form::password('password_confirmation', null, ['class' => 'form-control', 'required'])}}
                        </td>
                    </tr>
                </table>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-sm btn-success">Save</button>
                <a href="/admin-clerks">Cancel</a>
            </div>
        </div>
    </div>
</div>
</div>
{!! Form::close() !!}
@endsection