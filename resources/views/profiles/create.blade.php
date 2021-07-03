@extends('layouts.hwpl')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
    <li class="breadcrumb-item">Management</li>
    <li class="breadcrumb-item"><a href="/profiles">Profiles </a></li>
    <li class="breadcrumb-item active">Add New</li>
    <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection

@section('content')
 {!! Form::open(array('route' => array('profiles.store'), 'method' => 'post', 'class'=> 'form-vertical form-material', 'enctype="multipart/form-data"')) !!}
<div class="row">
<div class="col-md-2 col-xs-12">
       
    </div>
   
     <div class="col-md-8 col-xs-12">
        <div class="card">
            <div class="card-header">
                <strong>Biographical information</strong> 
            </div>
            <div class="card-body">
              <table class="table table-responsive-sm table-bordered table-sm" style="width:100%">
                  <tr>
                    <th style="background-color: rgba(227, 227, 227, 0.5)">Profile photo</th>
                    <td>{{Form::file('photo', null, ['class' => 'form-control'])}}</td>
                  </tr>
                  <tr>
                    <th style="background-color: rgba(227, 227, 227, 0.5)">Firstname <span class="text-danger">*</span></th>
                    <td>{{Form::text('fullname',null, ['class' => 'form-control', 'required', 'placeholder' => 'Firstname'])}}</td>
                  </tr>
                  <tr>
                    <th style="background-color: rgba(227, 227, 227, 0.5)">Surname <span class="text-danger">*</span></th>
                    <td>{{Form::text('lastname',null, ['class' => 'form-control', 'required', 'placeholder' => 'Surname'])}}</td>
                  </tr>
                  <tr>
                    <th style="background-color: rgba(227, 227, 227, 0.5)">Gender <span class="text-danger">*</span></th>
                    <td>{{Form::select('gender_id', $gender, null, ['class' => 'form-control select', 'required'])}}</td>
                  </tr>
                   <tr>
                    <th style="background-color: rgba(227, 227, 227, 0.5)">Title (s) <span class="text-danger">*</span></th>
                    <td>
                      {{Form::select('titles[]', $titles, null, ['class' => 'form-control select2 select2-multiple', 'required', 'multiple'])}}
                      <span class="help-text text-info"><small>You may select more than one title</small></span>
                    </td>
                  </tr>
                  <tr>
                    <th style="background-color: rgba(227, 227, 227, 0.5)">Date of Birth</th>
                    <td>{{Form::date('dob', null, ['class' => 'form-control'])}}</td>
                  </tr>
                  <tr>
                    <th style="background-color: rgba(227, 227, 227, 0.5)">Spoken languages <span class="text-danger">*</span></th>
                    <td>
                      {{Form::select('languages[]', $languages, null, ['class' => 'form-control select2 select2-multiple', 'required', 'multiple'])}}
                      <span class="help-text text-info"><small>You may select more than one language</small></span>
                    </td>
                  </tr>
                  <tr>
                    <th style="background-color: rgba(227, 227, 227, 0.5)">Sector<span class="text-danger">*</span></th>
                    <td>{{Form::select('sector_id', $sectors, null, ['class' => 'form-control select', 'placeholder'=>'Select','required'])}}</td>
                  </tr>
                  <tr>
                    <th style="background-color: rgba(227, 227, 227, 0.5)">Team<span class="text-danger">*</span></th>
                    <td>{{Form::select('team_id', $teams, null, ['class' => 'form-control select', 'placeholder'=>'Select', 'required'])}}</td>
                  </tr>
                  <tr>
                    <th style="background-color: rgba(227, 227, 227, 0.5)">Religion<span class="text-danger">*</span></th>
                    <td>{{Form::select('religion_id', $religions, null, ['class' => 'form-control select', 'placeholder'=>'Select','required'])}}</td>
                  </tr>
                  <tr>
                    <th style="background-color: rgba(227, 227, 227, 0.5)">City<span class="text-danger">*</span></th>
                    <td>{{Form::select('city_id', $cities, null, ['class' => 'form-control', 'placeholder'=>'Select', 'required'])}}</td>
                  </tr>
                  <tr>
                    <th style="background-color: rgba(227, 227, 227, 0.5)">Platform (Media contacts)</th>
                    <td>{{Form::select('platform', ['NA' => 'Not Applicable', 'online' => 'Online', 'radio' => 'Radio', 'website' => 'Website', 'print' => 'Print', 'broadcast' => 'Broadcast'], null, ['class' => 'form-control', 'placeholder'=>'Select', 'required'])}}</td>
                  </tr>
                  <tr>
                    <th style="background-color: rgba(227, 227, 227, 0.5)">Responsible staff<span class="text-danger">*</span></th>
                    <td>{{Form::select('maintainer_id', $maintainers, null, ['class' => 'form-control select2', 'placeholder'=>'Select','required'])}}</td>
                  </tr>
                  <tr>
                    <th style="background-color: rgba(227, 227, 227, 0.5)">Biography</th>
                    <td>{{Form::textarea('bio',null, ['class' => 'form-control', 'placeholder' => 'Type here'])}}</td>
                  </tr>
              </table>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <strong>Contact information</strong> 
            </div>
            <div class="card-body">
                 <table class="table table-responsive-sm table-bordered table-sm" style="width:100%">
                  <tr>
                    <th style="background-color: rgba(227, 227, 227, 0.5)">Mobile number</th>
                    <td>
                      {{Form::text('personal_mobile_no',null, ['class' => 'form-control', 'placeholder'=>'Primary mobile number'])}}
                      {{Form::text('personal_mobile_no2',null, ['class' => 'form-control', 'placeholder'=>'Secondary mobile number'])}}
                      {{Form::text('personal_mobile_no_other',null, ['class' => 'form-control', 'placeholder'=>'Other'])}}
                    </td>
                  </tr>
                  <tr>
                    <th style="background-color: rgba(227, 227, 227, 0.5)">Email</th>
                    <td>
                      {{Form::email('personal_email',null, ['class' => 'form-control', 'placeholder'=>'Primary Email'])}}
                      {{Form::email('personal_email2',null, ['class' => 'form-control', 'placeholder'=>'Secondary Email'])}}
                    </td>
                  </tr>
              </table>
            </div>
          </div>

        <div class="card">
            <div class="card-header">
                <strong>Organisation information</strong> 
            </div>
            <div class="card-body" id="organisations-section"></div>
            <div class="card-footer">
              <button typ="button" class="btn btn-sm btn-primary" id="add-organisation-btn">Add organisation</button>
            </div>
          </div>
          <div class="card">
            <div class="card-header">
                <strong>Assistant information</strong> 
            </div>
            <div class="card-body" id="assistant-section"></div>
            <div class="card-footer">
              <button typ="button" class="btn btn-sm btn-primary" id="add-assistant-btn">Add assistant</button>
            </div>
          </div>
          <div class="card">
            <div class="card-header">
                <strong>Other information</strong> 
            </div>
            <div class="card-body" >
              <table class="table table-responsive-sm table-bordered table-sm" style="width:100%">
                  <tr>
                    <th style="background-color: rgba(227, 227, 227, 0.5)">Rank  <span class="text-danger">*</span></th>
                    <td>{{Form::select('fruit_level_id', $fruit_levels, null, ['class' => 'form-control select', 'placeholder'=>'Select', 'required'])}}</td>
                  </tr>
                  <tr>
                    <th style="background-color: rgba(227, 227, 227, 0.5)">Level <span class="text-danger">*</span></th>
                    <td>{{Form::select('fruit_stage_id', $fruit_stages, null, ['class' => 'form-control select', 'placeholder'=>'Select','required'])}}</td>
                  </tr>
                  <tr>
                    <th style="background-color: rgba(227, 227, 227, 0.5)">Appointed role<span class="text-danger">*</span></th>
                    <td>{{Form::select('fruit_role_id', $fruit_roles, null, ['class' => 'form-control select', 'placeholder'=>'None','required'])}}</td>
                  </tr>
                  <tr>
                    <th style="background-color: rgba(227, 227, 227, 0.5)">Pre-poisoned<span class="text-danger">*</span></th>
                    <td>{{Form::select('pre_poisoned', ['Not sure' => 'Not Sure', 'No' => 'No', 'Yes' => 'Yes'], null, ['class' => 'form-control', 'placeholder'=>'Select','required'])}}</td>
                  </tr>
                  <tr>
                    <th style="background-color: rgba(227, 227, 227, 0.5)">Cult-awareness<span class="text-danger">*</span></th>
                    <td>{{Form::select('cult_awareness', ['Not sure' => 'Not Sure', 'No' => 'No', 'Yes' => 'Yes'], null, ['class' => 'form-control', 'placeholder'=>'Select', 'required'])}}</td>
                  </tr>
                  <tr>
                    <th style="background-color: rgba(227, 227, 227, 0.5)">WARP Attendee<span class="text-danger">*</span></th>
                    <td>{{Form::select('warp_attendee', ['No' => 'No', 'Yes' => 'Yes'], null, ['class' => 'form-control', 'required'])}}</td>
                  </tr>
                  <tr>
                    <th style="background-color: rgba(227, 227, 227, 0.5)">Date networked</th>
                    <td>{{Form::date('date_networked', null, ['class' => 'form-control'])}}</td>
                  </tr>
                  <tr>
                    <th style="background-color: rgba(227, 227, 227, 0.5)">History log</th>
                    <td>{{Form::textarea('history',null, ['class' => 'form-control', 'placeholder' => 'Type here'])}}</td>
                  </tr>
              </table>
            </div>
            <div class="card-footer">
              <button type="submit" class="btn btn-success"><span class="fa fa-check-circle"></span> Save</button>
              <a href="/profiles" class="btn"> Cancel</a>
            </div>
          </div>
        </div>
      </div>
      
</div>
{!! Form::close() !!}
@endsection
