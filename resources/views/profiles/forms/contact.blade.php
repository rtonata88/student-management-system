<div class="row white-box edit-contacts-section">
  {!! Form::model($profile, array('route'=>array('profiles.show', $profile->slug), 'class'=> 'form-vertical form-material', 'enctype="multipart/form-data"', 'method'=>'PATCH', 'id'=>'profile-edit-form')) !!}
  <strong>Personal contact information</strong>
    <table class="table table-responsive-sm table-bordered table-striped table-sm">
        <tbody>
            <tr>
                <td><strong>Mobile</strong></td>
                <td>
                    {{Form::text('mobile_no',$profile->mobile_no, ['class' => 'form-control', 'placeholder' => 'Primary Number'])}} <br>
                    {{Form::text('mobile_no2',$profile->mobile_no2, ['class' => 'form-control', 'placeholder' => 'Secondary Number'])}} <br>
                    {{Form::text('mobile_no_other',$profile->mobile_no_other, ['class' => 'form-control', 'placeholder' => 'Other'])}} <br>
                </td>
            </tr>
            <tr>
                <td><strong>Email</strong></td>
                <td>
                  {{Form::text('email',$profile->email, ['class' => 'form-control', 'placeholder' => 'Primary Email'])}} <br>
                  {{Form::text('email2',$profile->email2, ['class' => 'form-control', 'placeholder' => 'Secondary Email'])}} <br>
                  {{Form::hidden('profile-slug',$profile->slug, ['class' => 'form-control', 'required'])}}
                </td>
            </tr>

        </tbody>
    </table>
    <div class="pull-right">
      <button type="submit" class="btn btn-success save-btn" section="contact"><span class="fa fa-check-circle"></span> Save </button>
       <a  href="" class="cancel-btn" section="contact"><strong>Cancel</strong></a>
    </div>
<strong>Organisation</strong>
@forelse($organizations as $index=>$profile_organization)
<div class="table-responsive">
<h6 class="page-title"><strong>{{$profile_organization->organization->name}}</strong></h6>
  <br>
  <table class="table" style="background-color: #fcfcfc; border: 1px solid #dbd9d9">
      <tbody>
          <tr>
              <td><strong>Position</strong></td>
              <td> {{$profile_organization->position}} </td>
          </tr>
          <tr>
              <td><strong>Department</strong></td>
              <td> {{$profile_organization->department}} </td>
          </tr>
          <tr>
              <td><strong>Website</strong></td>
              <td> <a href="http://{{$profile_organization->organization->website}}" target="_blank">{{$profile_organization->organization->website}}</a> </td>
          </tr>
          <tr>
              <td><strong>Number</strong></td>
              <td> {{$profile_organization->work_number}} <br>
              {{$profile_organization->work_number2}} <br>
              {{$profile_organization->work_number_other}} </td>
          </tr>
          <tr>
              <td><strong>Email</strong></td>
              <td> {{$profile_organization->email}} <br>
              {{$profile_organization->email2}} <br>
              {{$profile_organization->email_other}} </td>
          </tr>
      </tbody>
  </table>
</div>
@empty
Not affiliated to any organisation
@endforelse

<strong>ASSISTANTS</strong>
@forelse($assistants as $index=>$assistant)
<div class="table-responsive">
<h6 class="page-title"><strong>{{$assistant->assistant_name}}</strong></h6>
<table class="table">
    <tbody>
        <tr>
            <td><strong>Email</strong></td>
            <td>
              <strong>P</strong>: {{$assistant->assistant_email1}} <br>
              <strong>S</strong>: {{$assistant->assistant_email2}} <br>
              <strong>O</strong>: {{$assistant->assistant_email3}} <br></td>
        </tr>
        <tr>
            <td><strong>Number</strong></td>
            <td>
              <strong>P</strong>: {{$assistant->assistant_number1}} <br>
              <strong>S</strong>: {{$assistant->assistant_number2}} <br>
              <strong>O</strong>: {{$assistant->assistant_number3}} <br>
             </td>
        </tr>
    </tbody>
</table>
</div>
@empty
No assistants
@endforelse
{!! Form::close() !!}
</div>
