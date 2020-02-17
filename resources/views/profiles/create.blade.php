@extends('layouts.hwpl')

@section('content')
<div class="container-fluid">
  <div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
      <h4 class="page-title">CONTACT PROFILES</h4> </div>
      <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <ol class="breadcrumb">
          <li><a href="/profiles">Profiles</a></li>
          <li class="active">Add New</li>
        </ol>
      </div>
      <!-- /.col-lg-12 -->
    </div>
    <div class="row">
      <div class="white-box">
        <a href="/profiles"> <span class="fa fa-arrow-circle-left"></span> Back</a>
        <h3 class="box-title">PROFILE [NEW]</h3>
        <hr>
        {!! Form::open(array('url' => '/profiles', 'method' => 'post', 'class'=> 'form-vertical form-material', 'enctype="multipart/form-data"')) !!}
       <fieldset>
        <div class="row">
          <div class="col-md-">
           <div class="form-group">

            {{Form::label('photo', 'Photo')}}
            {{Form::file('photo', null, ['class' => 'form-control'])}}
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-4">
         <div class="form-group">
          {{Form::label('titles[]', 'Title(s)')}}<span class="text-danger">*</span>
          {{Form::select('titles[]', $titles, null, ['class' => 'form-control select2 select2-multiple', 'required', 'multiple'])}}
          <span class="help-text"><small>You may select more than one title</small></span>
        </div>
      </div>

      <div class="col-md-4">
       <div class="form-group">
        {{Form::label('gender_id', 'Gender')}}<span class="text-danger">*</span>
        {{Form::select('gender_id', $gender, null, ['class' => 'form-control select', 'required'])}}
      </div>
    </div>

    <div class="col-md-4">
       <div class="form-group">
        {{Form::label('dob', 'Date of Birth')}}
        {{Form::text('dob', null, ['class' => 'form-control mydatepicker'])}}
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-4">
     <div class="form-group">
      {{Form::label('languages[]', 'Language (s)')}}<span class="text-danger">*</span>
      {{Form::select('languages[]', $languages, null, ['class' => 'form-control select2 select2-multiple', 'required', 'multiple'])}}
      <span class="help-text"><small>You may select more than one language</small></span>
    </div>
  </div>

  <div class="col-md-4">
    <div class="form-group">

      {{Form::label('lastname', 'Lastname')}}<span class="text-danger">*</span>
      {{Form::text('lastname',null, ['class' => 'form-control', 'required', 'placeholder' => 'Type here'])}}
    </div>
  </div>
  <div class="col-md-4">
    <div class="form-group">

      {{Form::label('fullname', 'First Names')}}<span class="text-danger">*</span>
      {{Form::text('fullname',null, ['class' => 'form-control', 'required', 'placeholder' => 'Type here'])}}
    </div>
  </div>

</div>
<h6 class="m-t-10"><strong>ORGANISATION DETAILS</strong></h6>
<div class="row">
  <table class="table table-bordered">
      <thead>
        <th>#</th>
        <th>Organization Name</th>
        <th>Position</th>
        <th>Department</th>
        <th>Work Number</th>
        <th>Email</th>
      </thead>
      <tbody>
        <tr>
          <td>1</td>
          <td>{{Form::select('organization[]', $organizations, null, ['class' => 'form-control', 'required', 'placeholder'=>'Select organisation'])}}</td>
          <td>{{Form::text('position[]',null, ['class' => 'form-control', 'required', 'placeholder' => 'Type here'])}}</td>
          <td>{{Form::text('department[]',null, ['class' => 'form-control', 'placeholder' => 'Type here'])}}</td>
          <td>
            {{Form::text('work_number[]',null, ['class' => 'form-control', 'placeholder'=>'Primary Work Number'])}}
            {{Form::text('work_number2[]',null, ['class' => 'form-control', 'placeholder'=>'Secondary Work Number'])}}
            {{Form::text('work_number_other[]',null, ['class' => 'form-control', 'placeholder'=>'Other'])}}
          </td>
          <td>
            {{Form::email('email[]',null, ['class' => 'form-control', 'placeholder'=>'Primary Email'])}}
            {{Form::email('email2[]',null, ['class' => 'form-control', 'placeholder'=>'Secondary Email'])}}
            {{Form::email('email_other[]',null, ['class' => 'form-control', 'placeholder'=>'Other'])}}
          </td>
        </tr>
        <tr>
          <td>2</td>
          <td>{{Form::select('organization[]', $organizations, null, ['class' => 'form-control', 'placeholder'=>'Select organisation'])}}</td>
          <td>{{Form::text('position[]',null, ['class' => 'form-control', 'required', 'placeholder' => 'Type here'])}}</td>
          <td>
            {{Form::text('work_number[]',null, ['class' => 'form-control', 'placeholder'=>'Primary Work Number'])}}
            {{Form::text('work_number2[]',null, ['class' => 'form-control', 'placeholder'=>'Secondary Work Number'])}}
            {{Form::text('work_number_other[]',null, ['class' => 'form-control', 'placeholder'=>'Other'])}}
          </td>
          <td>
            {{Form::email('email[]',null, ['class' => 'form-control', 'placeholder'=>'Primary Email', ])}}
            {{Form::email('email2[]',null, ['class' => 'form-control', 'placeholder'=>'Secondary Email'])}}
            {{Form::email('email_other[]',null, ['class' => 'form-control', 'placeholder'=>'Other'])}}
          </td>
        </tr>
        <tr>
          <td>3</td>
          <td>{{Form::select('organization[]', $organizations, null, ['class' => 'form-control', 'placeholder'=>'Select organisation'])}}</td>
          <td>{{Form::text('position[]',null, ['class' => 'form-control', 'required', 'placeholder' => 'Type here'])}}</td>
          <td>
            {{Form::text('work_number[]',null, ['class' => 'form-control', 'placeholder'=>'Primary Work Number'])}}
            {{Form::text('work_number2[]',null, ['class' => 'form-control', 'placeholder'=>'Secondary Work Number'])}}
            {{Form::text('work_number_other[]',null, ['class' => 'form-control', 'placeholder'=>'Other'])}}
          </td>
          <td>
            {{Form::email('email[]',null, ['class' => 'form-control', 'placeholder'=>'Primary Email'])}}
            {{Form::email('email2[]',null, ['class' => 'form-control', 'placeholder'=>'Secondary Email'])}}
            {{Form::email('email_other[]',null, ['class' => 'form-control', 'placeholder'=>'Other'])}}
          </td>
        </tr>
      </tbody>
  </table>
</div>
<div class="row">
  <div class="col-md-12">
    {{Form::label('bio', 'Biography')}}
    {{Form::textarea('bio',null, ['class' => 'form-control', 'placeholder' => 'Education and Career'])}}
  </div>
</div>
</fieldset>
<br>
<fieldset>


 <h6 class="m-t-10"><strong>ASSISTANT DETAILS</strong></h6>
 <table class="table table-bordered">
  <thead>
    <tr>
      <th>#</th>
      <th>Assistant Name</th>
      <th>Assistant Email</th>
      <th>Assistant Number</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>1</td>
      <td>{{Form::text('assistant_name[]',null, ['class' => 'form-control', 'placeholder' => 'Type here'])}}</td>
      <td>
        {{Form::email('assistant_email1[]',null, ['class' => 'form-control', 'placeholder' => 'Primary Email'])}}
        {{Form::email('assistant_email2[]',null, ['class' => 'form-control', 'placeholder' => 'Secondary Email'])}}
        {{Form::email('assistant_email3[]',null, ['class' => 'form-control', 'placeholder' => 'Other'])}}
      </td>
      <td>
        {{Form::text('assistant_number1[]',null, ['class' => 'form-control', 'placeholder' => 'Primary Number'])}}
        {{Form::text('assistant_number2[]',null, ['class' => 'form-control', 'placeholder' => 'Secondary Number'])}}
        {{Form::text('assistant_number3[]',null, ['class' => 'form-control', 'placeholder' => 'Other'])}}
      </td>
    </tr>
    <tr>
      <td>2</td>
      <td>{{Form::text('assistant_name[]',null, ['class' => 'form-control', 'placeholder' => 'Type here'])}}</td>
      <td>
        {{Form::email('assistant_email1[]',null, ['class' => 'form-control', 'placeholder' => 'Primary Email'])}}
        {{Form::email('assistant_email2[]',null, ['class' => 'form-control', 'placeholder' => 'Secondary Email'])}}
        {{Form::email('assistant_email3[]',null, ['class' => 'form-control', 'placeholder' => 'Other'])}}
      </td>
      <td>
        {{Form::text('assistant_number1[]',null, ['class' => 'form-control', 'placeholder' => 'Primary Number'])}}
        {{Form::text('assistant_number2[]',null, ['class' => 'form-control', 'placeholder' => 'Secondary Number'])}}
        {{Form::text('assistant_number3[]',null, ['class' => 'form-control', 'placeholder' => 'Other'])}}
      </td>
    </tr>
    <tr>
      <td>3</td>
      <td>{{Form::text('assistant_name[]',null, ['class' => 'form-control', 'placeholder' => 'Type here'])}}</td>
      <td>
        {{Form::email('assistant_email1[]',null, ['class' => 'form-control', 'placeholder' => 'Primary Email'])}}
        {{Form::email('assistant_email2[]',null, ['class' => 'form-control', 'placeholder' => 'Secondary Email'])}}
        {{Form::email('assistant_email3[]',null, ['class' => 'form-control', 'placeholder' => 'Other'])}}
      </td>
      <td>
        {{Form::text('assistant_number1[]',null, ['class' => 'form-control', 'placeholder' => 'Primary Number'])}}
        {{Form::text('assistant_number2[]',null, ['class' => 'form-control', 'placeholder' => 'Secondary Number'])}}
        {{Form::text('assistant_number3[]',null, ['class' => 'form-control', 'placeholder' => 'Other'])}}
      </td>
    </tr>
  </tbody>

</table>

</fieldset>

<br>
<fieldset>
  <h4 class="box-title m-t-10">BASIC INFORMATION</h4>
  <hr>
  <div class="row">
    <div class="col-md-4">
     <div class="form-group">

      {{Form::label('sector_id', 'Sector')}}<span class="text-danger">*</span>
      {{Form::select('sector_id', $sectors, null, ['class' => 'form-control select', 'placeholder'=>'Select','required'])}}
    </div>
  </div>
  <div class="col-md-4">
   <div class="form-group">

    {{Form::label('team_id', 'Team')}}<span class="text-danger">*</span>
    {{Form::select('team_id', $teams, null, ['class' => 'form-control select', 'placeholder'=>'Select', 'required'])}}
  </div>
</div>
<div class="col-md-4">
 <div class="form-group">

  {{Form::label('religion_id', 'Religion')}}<span class="text-danger">*</span>
  {{Form::select('religion_id', $religions, null, ['class' => 'form-control select', 'placeholder'=>'Unknown','required'])}}
</div>
</div>
</div>
<div class="row">
  <div class="col-md-6">
    <div class="form-group">

      {{Form::label('country_id', 'Country')}}<span class="text-danger">*</span>
      {{Form::select('country_id', $countries, null, ['class' => 'form-control', 'placeholder'=>'Select', 'required'])}}
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">

      {{Form::label('city_id', 'City')}}<span class="text-danger">*</span>
      {{Form::select('city_id', $cities, null, ['class' => 'form-control', 'placeholder'=>'Select', 'required'])}}
    </div>
  </div>

</div>
</fieldset>

<fieldset>
  <h4 class="box-title m-t-10">RELATIONSHIP</h4>
  <hr>
  <div class="row">
    <div class="col-md-4">
     <div class="form-group">

      {{Form::label('fruit_level_id', 'Rank')}}<span class="text-danger">*</span>
      {{Form::select('fruit_level_id', $fruit_levels, null, ['class' => 'form-control select', 'placeholder'=>'Select', 'required'])}}
    </div>
  </div>
  <div class="col-md-4">
   <div class="form-group">

    {{Form::label('fruit_stage_id', 'Level')}}<span class="text-danger">*</span>
    {{Form::select('fruit_stage_id', $fruit_stages, null, ['class' => 'form-control select', 'placeholder'=>'Select','required'])}}
  </div>
</div>

<div class="col-md-4">
 <div class="form-group">

  {{Form::label('fruit_role_id', 'Status/Appointed Role')}}<span class="text-danger">*</span>
  {{Form::select('fruit_role_id', $fruit_roles, null, ['class' => 'form-control select', 'placeholder'=>'None','required'])}}
</div>
</div>
</div>
<div class="row">
  <div class="col-md-4">
    <div class="form-group">

      {{Form::label('pre_poisoned', 'Pre-poisoned')}}<span class="text-danger">*</span>
      {{Form::select('pre_poisoned', ['Not sure' => 'Not Sure', 'No' => 'No', 'Yes' => 'Yes'], null, ['class' => 'form-control', 'placeholder'=>'Select','required'])}}
    </div>
  </div>
  <div class="col-md-4">
    <div class="form-group">
      {{Form::label('cult_awareness', 'Cult-Awareness')}}<span class="text-danger">*</span>
      {{Form::select('cult_awareness', ['Not sure' => 'Not Sure', 'No' => 'No', 'Yes' => 'Yes'], null, ['class' => 'form-control', 'placeholder'=>'Select', 'required'])}}
    </div>
  </div>
  <div class="col-md-4">
    <div class="form-group">
      {{Form::label('warp_attendee', 'WARP Attendee')}}<span class="text-danger">*</span>
      {{Form::select('warp_attendee', ['No' => 'No', 'Yes' => 'Yes'], null, ['class' => 'form-control', 'required'])}}
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-4">
    <div class="form-group">

      {{Form::label('maintainer_id', 'Responsible Staff')}}<span class="text-danger">*</span>
      {{Form::select('maintainer_id', $maintainers, null, ['class' => 'form-control', 'placeholder'=>'Select','required'])}}
    </div>
  </div>
  {{-- <div class="col-md-4">
    <div class="form-group">
      {{{{Form::label('sector_relationship_id', 'Relationship with Sector')}}<span class="text-danger">*</span>
      {{Form::select('sector_relationship_id', $sector_relationships, null, ['class' => 'form-control', 'placeholder'=>'Select','required'])}}
    </div>
  </div> --}}
   <div class="col-md-4">
    <div class="form-group">
      {{Form::label('date_networked', 'Date Networked')}}<span class="text-danger">*</span>
      {{Form::text('date_networked', null, ['class' => 'form-control mydatepicker'])}}
    </div>
  </div>

</div>

<div class="row">
  <div class="col-md-12">
    {{Form::label('history', 'History')}}
    {{Form::textarea('history',null, ['class' => 'form-control', 'placeholder' => 'Type here'])}}
  </div>
</div>
<br>
</fieldset>


<button type="submit" class="btn btn-success"><span class="fa fa-check-circle"></span> Save</button>
<button type="reset" class="btn btn-warning"><span class="fa fa-ban"></span> Reset</button>
{!! Form::close() !!}
</div>
</div>
</div>

@endsection
