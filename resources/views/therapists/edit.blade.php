@extends('layouts.app')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Management</li>
        <li class="breadcrumb-item"><a href="/profiles">Therapists </a></li>
        <li class="breadcrumb-item active">Edit</li>
        <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection

@section('content')
{!! Form::model($therapist, array('route' => array('therapists.update', $therapist->id), 'method' => 'post', 'class'=> 'form-vertical form-material', 'enctype="multipart/form-data"')) !!}
<input type="hidden" name="_method" value="patch">
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
                        <th style="background-color: rgba(227, 227, 227, 0.5); width: 300px;">Therapist photo</th>
                        <td>{{Form::file('photo', null, ['class' => 'form-control'])}}</td>
                    </tr>
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
                        <th style="background-color: rgba(227, 227, 227, 0.5)">Contact number <span class="text-danger">*</span></th>
                        <td>{{Form::text('contact_number',null, ['class' => 'form-control', 'required', 'placeholder' => 'Contact number'])}}</td>
                    </tr>
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">Sex <span class="text-danger">*</span></th>
                        <td>{{Form::select('sex', $sex, null, ['class' => 'form-control select', 'required'])}}</td>
                    </tr>
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">Spoken languages <span class="text-danger">*</span></th>
                        <td>
                            {{Form::select('languages[]', $languages, null, ['class' => 'form-control select2 select2-multiple', 'required', 'multiple'])}}
                            <span class="help-text text-info"><small>You may select more than one language</small></span>
                        </td>
                    </tr>
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">Country <span class="text-danger">*</span></th>
                        <td>{{Form::select('country_id', $countries, null, ['class' => 'form-control select'])}}</td>
                    </tr>
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">Practice number <span class="text-danger">*</span></th>
                        <td>{{Form::text('practice_number',null, ['class' => 'form-control', 'required', 'placeholder' => 'Practice number'])}}</td>
                    </tr>
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">Board </th>
                        <td>{{Form::select('board_id', $boards, null, ['class' => 'form-control select'])}}</td>
                    </tr>
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">License Type <span class="text-danger">*</span></th>
                        <td>{{Form::select('licence_type_id', $license_types, null, ['class' => 'form-control select', 'required'])}}</td>
                    </tr>
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">Area of specialities <span class="text-danger">*</span></th>
                        <td>
                            {{Form::select('specialties[]', $specialties, null, ['class' => 'form-control select2 select2-multiple', 'required', 'multiple'])}}
                            <span class="help-text text-info"><small>You may select more than one specialty</small></span>
                        </td>
                    </tr>
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">Do you have a work permit? <span class="text-danger">*</span></th>
                        <td>{{Form::select('work_permit_yn', ['Y' => 'Yes', 'N' => 'No', 'A' => 'Not applicable'], null, ['class' => 'form-control select', 'required'])}}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <strong>Qualification information</strong>
            </div>
            <div class="card-body qualifications-table">
                @foreach($therapist->qualification->where('model', 'Therapist') as $qualification)
                <table class="table table-responsive-sm table-bordered table-sm" style="width:100%">
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">Qualification title <span class="text-danger">*</span></th>
                        <td>
                            {{Form::text('qualification_name[]', $qualification->qualification_name, ['class' => 'form-control', 'placeholder'=>'Qualification name', 'required'])}}
                            <input type="hidden" name="model" value="Therapist">
                        </td>
                    </tr>
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">Institution <span class="text-danger">*</span></th>
                        <td>
                            {{Form::text('institution[]', $qualification->institution, ['class' => 'form-control', 'placeholder'=>'Institution', 'required'])}}
                        </td>
                    </tr>
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">Start year <span class="text-danger">*</span></th>
                        <td>
                            {{Form::number('start_year[]', $qualification->start_year, ['class' => 'form-control', 'placeholder'=>'Start year', 'required'])}}
                        </td>
                    </tr>
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">End year <span class="text-danger">*</span></th>
                        <td>
                            {{Form::number('end_year[]', $qualification->end_year, ['class' => 'form-control', 'placeholder'=>'End year', 'required'])}}
                        </td>
                    </tr>
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)"></th>
                        <td>
                            <button typ="button" class="btn btn-sm btn-danger delete-qualification">Delete qualification</button>
                            </td>
                        </tr>
                </table>
                @endforeach
            </div>
            <div class="card-body" id="qualifications-section">

            </div>
            <div class="card-footer">
                <button typ="button" class="btn btn-sm btn-primary" id="add-qualification-btn">Add qualification</button>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <strong>Publication information</strong>
            </div>
            <div class="card-body publications-table" id="publications-section">
                @foreach($therapist->publication as $publication)
                <table class="table table-responsive-sm table-bordered table-sm" style="width:100%">
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5); width: 200px;">Title</th>
                        <td>
                            {{Form::text('title[]', $publication->title, ['class' => 'form-control', 'placeholder'=>'Title', 'required'])}}
                        </td>
                    </tr>
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">Abstract</th>
                        <td>
                            {{Form::text('abstract[]', $publication->abstract, ['class' => 'form-control', 'placeholder'=>'Abstract'])}}
                        </td>
                    </tr>
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">Other information</th>
                        <td>
                            {{Form::text('other_information[]', $publication->other_information, ['class' => 'form-control', 'placeholder'=>'Other information'])}}
                        </td>
                    </tr>
                    <th style="background-color: rgba(227, 227, 227, 0.5)"></th>
                    <td>
                        <button typ="button" class="btn btn-sm btn-danger delete-publication">Delete publication</button>
                    </td>
                    </tr>
                </table>
                @endforeach
            </div>
            <div class="card-footer">
                <button typ="button" class="btn btn-sm btn-primary" id="add-publication-btn">Add publication</button>
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
                            {{Form::text('password',null, ['class' => 'form-control', 'required', 'disabled'])}}
                        </td>
                    </tr>
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">Confirm password <span class="text-danger">*</span></th>
                        <td>
                            {{Form::text('password_confirmation', null, ['class' => 'form-control', 'required', 'disabled'])}}
                        </td>
                    </tr>
                </table>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-sm btn-success">Save</button>
                <a href="/therapists">Cancel</a>
            </div>
        </div>
    </div>
</div>
</div>
{!! Form::close() !!}
@endsection