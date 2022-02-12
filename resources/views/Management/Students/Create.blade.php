@extends('layouts.app')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Management</li>
        <li class="breadcrumb-item"><a href="/students">Students </a></li>
        <li class="breadcrumb-item active">Add New</li>
        <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection

@section('content')
{!! Form::open(array('route' => array('students.store'), 'method' => 'post', 'class'=> 'form-vertical form-material', 'enctype="multipart/form-data"')) !!}
<div class="row">
    <div class="col-md-2 col-xs-12"></div>
    <div class="col-md-8 col-xs-12">
        <div class="card">
            <div class="card-header">
                <strong>Student information</strong>
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
                        <th style="background-color: rgba(227, 227, 227, 0.5)">Student number <span class="text-danger">*</span></th>
                        <td>{{Form::text('student_number2',null, ['class' => 'form-control input-no-border', 'required', 'placeholder' => 'Student number'])}}</td>
                    </tr>
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">Student names <span class="text-danger">*</span></th>
                        <td>{{Form::text('student_names',null, ['class' => 'form-control input-no-border', 'required', 'placeholder' => 'Student names'])}}</td>
                    </tr>
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">Surname <span class="text-danger">*</span></th>
                        <td>{{Form::text('surname',null, ['class' => 'form-control input-no-border', 'required', 'placeholder' => 'Surname'])}}</td>
                    </tr>
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">Initials <span class="text-danger">*</span></th>
                        <td>{{Form::text('initials',null, ['class' => 'form-control input-no-border', 'required', 'placeholder' => 'Inititals'])}}</td>
                    </tr>
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">Email </th>
                        <td>{{Form::email('contact_email',null, ['class' => 'form-control input-no-border', 'placeholder' => 'Email'])}}</td>
                    </tr>
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">Contact number <span class="text-danger">*</span></th>
                        <td>{{Form::text('contact_number',null, ['class' => 'form-control input-no-border', 'required', 'placeholder' => 'Contact number'])}}</td>
                    </tr>
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">Gender <span class="text-danger">*</span></th>
                        <td>{{Form::select('gender', ['Male' => 'Male', 'Female' => 'Female'], null, ['class' => 'form-control select input-no-border', 'required'])}}</td>
                    </tr>
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">Date of Birth</th>
                        <td>
                            {{Form::date('date_of_birth', null, ['class' => 'form-control input-no-border', 'placeholder'=>'Date of birth'])}}
                        </td>
                    </tr>
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">Birth Certificate</th>
                        <td>
                            {{Form::text('birth_certificate', null, ['class' => 'form-control input-no-border', 'placeholder'=>'Birth certificate number'])}}
                        </td>
                    </tr>
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">ID Number </th>
                        <td>
                            {{Form::number('id_number',null, ['class' => 'form-control input-no-border', 'placeholder'=>'ID number'])}}
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <strong>Guardian information</strong>
            </div>
            <div class="card-body qualifications-table">
                <table class="table table-responsive-sm table-bordered table-sm" style="width:100%">
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">Name <span class="text-danger">*</span></th>
                        <td>
                            {{Form::text('guardian_names[]',null, ['class' => 'form-control input-no-border', 'placeholder'=>'Guardian name', 'required'])}}
                        </td>
                    </tr>
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">Surname <span class="text-danger">*</span></th>
                        <td>
                            {{Form::text('guardian_surname[]',null, ['class' => 'form-control input-no-border', 'placeholder'=>'Surname', 'required'])}}
                        </td>
                    </tr>
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">Relationship <span class="text-danger">*</span></th>
                        <td>{{Form::select('relationship[]', ['Father' => 'Father', 'Mother' => 'Mother', 'Cousin' => 'Cousin', 'Aunt' => 'Aunt', 'Uncle' => 'Uncle', 'Sister' => 'Sister', 'Brother' => 'Brother'], null, ['class' => 'form-control select input-no-border', 'required'])}}</td>
                    </tr>
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">Contact number <span class="text-danger">*</span></th>
                        <td>
                            {{Form::text('guardian_contact_number[]',null, ['class' => 'form-control input-no-border', 'placeholder'=>'Contact number', 'required'])}}
                        </td>

                    </tr>
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">Contact email </th>
                        <td>
                            {{Form::text('guardian_contact_email[]',null, ['class' => 'form-control input-no-border', 'placeholder'=>'Contact email'])}}
                        </td>
                    </tr>
                </table>

                <table class="table table-responsive-sm table-bordered table-sm" style="width:100%">
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">Name <span class="text-danger">*</span></th>
                        <td>
                            {{Form::text('guardian_names[]',null, ['class' => 'form-control input-no-border', 'placeholder'=>'Guardian name'])}}
                        </td>
                    </tr>
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">Surname <span class="text-danger">*</span></th>
                        <td>
                            {{Form::text('guardian_surname[]',null, ['class' => 'form-control input-no-border', 'placeholder'=>'Surname'])}}
                        </td>
                    </tr>
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">Relationship <span class="text-danger">*</span></th>
                        <td>{{Form::select('relationship[]', ['Father' => 'Father', 'Mother' => 'Mother', 'Cousin' => 'Cousin', 'Aunt' => 'Aunt', 'Uncle' => 'Uncle', 'Sister' => 'Sister', 'Brother' => 'Brother'], null, ['class' => 'form-control select input-no-border'])}}</td>
                    </tr>
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">Contact number <span class="text-danger">*</span></th>
                        <td>
                            {{Form::text('guardian_contact_number[]',null, ['class' => 'form-control input-no-border', 'placeholder'=>'Contact number'])}}
                        </td>

                    </tr>
                    <tr>
                        <th style="background-color: rgba(227, 227, 227, 0.5)">Contact email </th>
                        <td>
                            {{Form::text('guardian_contact_email[]',null, ['class' => 'form-control input-no-border', 'placeholder'=>'Contact email'])}}
                        </td>
                    </tr>
                </table>
            </div>
            <!--
                UNCOMMENT this line if you wish to add more than one guardian 
                <div class="card-body" id="guardian-section">
            </div> 
            <div class="card-footer">
                <button typ="button" class="btn btn-sm btn-primary" id="add-qualification-btn">Add qualification</button>
            </div>-->
            <div class="card-footer">
                <button type="submit" class="btn btn-sm btn-success">Save</button>
                <a href="/students">Cancel</a>
            </div>
        </div>

    </div>
</div>
</div>
{!! Form::close() !!}
@endsection