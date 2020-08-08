@extends('layouts.hwpl')

@section('content')
<div class="container-fluid">
  <div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
      <h4 class="page-title">CONTACT PROFILES</h4> </div>
      <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <ol class="breadcrumb">
          <li><a href="/profiles">Profiles</a></li>
          <li class="active">Update</li>
        </ol>
      </div>
      <!-- /.col-lg-12 -->
    </div>

    <div class="row">
      <div class="white-box">
        <a href="/profiles/{{$profile->slug}}"> <span class="fa fa-arrow-circle-left"></span> Cancel</a>
        <h3 class="box-title">{{$profile->fullname}} {{$profile->lastname}}</h3>
        <hr>
        {!! Form::model($profile, array('route'=>array('profiles.show', $profile->slug), 'class'=> 'form-vertical form-material', 'enctype="multipart/form-data"', 'method'=>'PATCH')) !!}
        <div class="row">
         <div class="form-group">
           <div class="col-md-2">
             {{Form::label('language_id', 'Language')}}
             {{Form::select('language_id', $languages, null, ['class' => 'form-control select'])}}
           </div>
         </div>
       </div>
       <br>
       <fieldset>
        <div class="row">
          <div class="col-md-6">
           <div class="form-group">
            {{Form::label('photo', 'Photo')}}
            {{Form::file('photo', null, ['class' => 'form-control'])}}
          </div>
          @if($profile->photo)
          <img alt="Profile Picture" width="50%" src="/fruit_profiles/photos/{{$profile->photo}}" class="img-responsive">
          @else
          <img width="150" height="150" alt="Profile Picture" width="50%" src="/fruit_profiles/photos/no-image.png" class="img-responsive">
          @endif

        </div>
      </div>
      <br>
      <div class="row">
        <div class="col-md-4">
         <div class="form-group">
          {{Form::label('titles[]', 'Title(s)')}}<span class="text-danger">*</span>
          {{Form::select('titles[]', $titles, $profile->title()->pluck('title_id'), ['class' => 'form-control select2 select2-multiple', 'required', 'multiple'])}}
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
    {{Form::select('languages[]', $languages, $profile->language()->pluck('language_id'), ['class' => 'form-control select2 select2-multiple', 'required', 'multiple'])}}
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
<div class="row">
  <table class="table table-bordered">
    <thead>
      <th>Organisation</th>
      <th>Position</th>
      <th>Department</th>
      <th>Work Number</th>
      <th>Email</th>
    </thead>
    <tbody>
      @forelse($profile_organizations as $index=>$profile_organization)
      <tr>
        <td>{{$profile_organization->organization->name}}</td>
        <td>{{$profile_organization->position}}</td>
        <td>{{$profile_organization->department}}</td>
        <td>
          {{$profile_organization->work_number}} <br>
          {{$profile_organization->work_number2}}
          {{$profile_organization->work_number_other}}
        </td>
        <td>
          {{$profile_organization->email}} <br>
          {{$profile_organization->email2}} <br>
          {{$profile_organization->email_other}}
        </td>
      </tr>
      @empty
      Not affiliated to any organisations use the fields below to affiliate an organization to this profile
      @endforelse
      <tr>
        <td>{{Form::select('organization[]', $organizations, null, ['class' => 'form-control', 'placeholder'=>'Select organization'])}}</td>
        <td>{{Form::text('position[]',null, ['class' => 'form-control', 'placeholder' => 'Type here'])}}</td>
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
    </tbody>
  </table>
</div>
<div class="row">
  <div class="col-md-12">
    {{Form::label('bio', 'Biography')}}
    {{Form::textarea('bio',null, ['class' => 'form-control', 'placeholder' => 'Type here'])}}
  </div>
</div>


</fieldset>
<br>
<fieldset>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Assistant Name</th>
        <th>Assistant Email</th>
        <th>Assistant Number</th>
      </tr>
    </thead>
    <tbody>
      @forelse($assistants as $index=>$assistant)
      <tr>
        <td>{{$assistant->assistant_name}}</td>
        <td>
          <strong>P</strong>: {{$assistant->assistant_email1}} <br>
          <strong>S</strong>: {{$assistant->assistant_email2}} <br>
          <strong>O</strong>: {{$assistant->assistant_email3}} <br>
        </td>
        <td>
          <strong>P</strong>: {{$assistant->assistant_number1}} <br>
          <strong>S</strong>: {{$assistant->assistant_number2}} <br>
          <strong>O</strong>: {{$assistant->assistant_number3}} <br>
        </td>
      </tr>
      @empty
      No assistants
      @endforelse
      <tr>
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
  <div class="col-md-4">
    <div class="form-group">

      {{Form::label('country_id', 'Country')}}<span class="text-danger">*</span>
      {{Form::select('country_id', $countries, null, ['class' => 'form-control', 'placeholder'=>'Select', 'required'])}}
    </div>
  </div>
  <div class="col-md-4">
    <div class="form-group">

      {{Form::label('city_id', 'City')}}<span class="text-danger">*</span>
      {{Form::select('city_id', $cities, null, ['class' => 'form-control', 'placeholder'=>'Select', 'required'])}}
    </div>
  </div>
  <div class="col-md-4">
    <div class="form-group">

      {{Form::label('platform', 'Platform (Media contacts)')}}<span class="text-danger">*</span>
      {{Form::select('platform', ['NA' => 'Not Applicable', 'online' => 'Online', 'radio' => 'Radio', 'website' => 'Website', 'print' => 'Print', 'broadcast' => 'Broadcast'], $profile->platform, ['class' => 'form-control', 'placeholder'=>'Select', 'required'])}}
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

    {{Form::label('fruit_stage_id', 'Contact Stage')}}<span class="text-danger">*</span>
    {{Form::select('fruit_stage_id', $fruit_stages, null, ['class' => 'form-control select', 'placeholder'=>'Select', 'required'])}}
  </div>
</div>

<div class="col-md-4">
 <div class="form-group">

  {{Form::label('fruit_role_id', 'Appointed Role')}}<span class="text-danger">*</span>
  {{Form::select('fruit_role_id', $fruit_roles, null, ['class' => 'form-control select', 'placeholder'=>'None', 'required'])}}
</div>
</div>
</div>
<div class="row">
  <div class="col-md-4">
    <div class="form-group">

      {{Form::label('pre_poisoned', 'Pre-poisoned')}}<span class="text-danger">*</span>
      {{Form::select('pre_poisoned', ['Not sure' => 'Not Sure', 'No' => 'No', 'Yes' => 'Yes'], null, ['class' => 'form-control', 'placeholder'=>'Select', 'required'])}}
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
  {{--
  <div class="col-md-4">
    <div class="form-group">
      {{Form::label('sector_relationship_id', 'Relationship with Sector')}}<span class="text-danger">*</span>
      {{Form::select('sector_relationship_id', $sector_relationships, null, ['class' => 'form-control', 'placeholder'=>'Select', 'required'])}}
    </div>
  </div>
  --}}
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
