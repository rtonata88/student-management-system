<div class="row white-box edit-about-section">
  <div class="spinner"></div>
  <div class="user-bg text-center">
      @if($profile->photo)
      <img alt="user" src="/fruit_profiles/thumbnail/{{$profile->photo}}" class="img-circle">
      @else
      <center>
          <img  alt="user" src="/fruit_profiles/photos/no-image.png" >
      </center>
      @endif
  </div>

<br>
<br>
{!! Form::model($profile, array('route'=>array('profiles.show', $profile->slug), 'class'=> 'form-vertical form-material', 'enctype="multipart/form-data"', 'method'=>'PATCH', 'id'=>'profile-edit-form')) !!}
      <table class="table table-responsive-sm table-bordered table-striped table-sm">
          <tbody>
            <tr>
              <td><strong>Photo</strong> </td>
              <td>
                  {{Form::file('photo', null, ['class' => 'form-control', 'id'=>'photo'])}}
              </td>
            </tr>
            <tr>
                <td><strong>Titles</strong></td>
                <td>
                    {{Form::select('titles[]', $titles, $profile->title()->pluck('title_id'), ['class' => 'form-control select2 select2-multiple','id'=>'titles' ,'required', 'multiple'])}}
                    <div class="help-block text-info p-2">
                       <small>Ctrl + Click on the Title - to select multiple titles</small> 
                    </div>
                </td>
            </tr>
            <tr>
                <td><strong>Surname</strong></td>
                <td>
                    {{Form::text('lastname',$profile->lastname, ['class' => 'form-control', 'required', 'placeholder' => 'Type here'])}}
                    {{Form::hidden('profile-slug',$profile->slug, ['class' => 'form-control', 'required', 'placeholder' => 'Type here'])}}
                </td>
            </tr>
            <tr>
                <td><strong>Fullname</strong></td>
                <td>
                    {{Form::text('fullname',$profile->fullname, ['class' => 'form-control', 'required', 'placeholder' => 'Type here'])}}
                </td>
            </tr>
            <tr>
                <td><strong>Gender</strong></td>
                <td>
                  {{Form::select('gender_id', $gender, $profile->gender_id, ['class' => 'form-control select', 'required'])}}
                 </td>
            </tr>
            <tr>
                <td><strong>Date of Birth</strong></td>
                <td> {{Form::text('dob', $profile->dob, ['class' => 'form-control mydatepicker', 'placeholder' => 'Click here', 'autocomplete' => 'off'])}} </td>
            </tr>
            <tr>
                <td><strong>Bio</strong></td>
                <td> {{Form::textarea('bio', $profile->bio, ['class' => 'form-control', 'placeholder' => 'Type here'])}} </td>
            </tr>
            <tr>
                <td><strong>City</strong></td>
                <td> {{Form::select('city_id', $cities, $profile->city_id, ['class' => 'form-control', 'placeholder'=>'Select', 'required'])}} </td>
            </tr>
              <tr>
                  <td><strong>Languages</strong></td>
                  <td>
                    {{Form::select('languages[]', $languages, $profile->language()->pluck('language_id'), ['class' => 'form-control select2', 'id'=>'languages' ,'multiple'])}}
                    <div class="help-block text-info">
                        Ctrl + Click on the Language - to select multiple languages
                    </div>
                  </td>
              </tr>
              <tr>
                  <td><strong>Responsible Staff</strong></td>
                  <td>{{Form::select('maintainer_id', $maintainers, $profile->maintainer_id, ['class' => 'form-control', 'placeholder'=>'Select','required'])}}</td>
              </tr>
              <tr>
                  <td><strong>Platform (Media only)</strong></td>
                  <td> {{Form::select('platform', ['NA' => 'Not Applicable', 'online' => 'Online', 'radio' => 'Radio', 'website' => 'Website', 'print' => 'Print', 'broadcast' => 'Broadcast'], $profile->platform, ['class' => 'form-control', 'placeholder'=>'Select', 'required'])}} </td>
              </tr>
              <tr>
                  <td><strong>History</strong></td>
                  <td> {{Form::textarea('history',null, ['class' => 'form-control', 'placeholder' => 'Type here'])}} </td>
              </tr>
          </tbody>
      </table>
  <div class="pull-right">
    <a  href="" class="cancel-btn" section="about"><strong>Cancel</strong></a>
    <button type="submit" class="btn btn-success save-btn" section="about"> Save </button>
  </div>

</div>
{!! Form::close() !!}
