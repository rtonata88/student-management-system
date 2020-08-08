<div class="row white-box about-section">
  <div class="user-bg text-center">
      @if($profile->photo)
      <img  alt="user" src="/fruit_profiles/thumbnail/{{$profile->photo}}" class="img-circle">
      @else
      <center>
          <img  alt="user" src="/fruit_profiles/photos/no-image.png" class="img-circle">
      </center>
      @endif
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="pull-right">
        <a href="#" slug="{{$profile->slug}}" class="edit-btn" section="about"><span class="fa fa-pencil"></span> Edit</a></a>
      </div>
    </div>

  </div>
  <br>
    <div class="table-responsive">
      <table class="table">
          <tbody>
            <tr>
                <td><strong>Full name</strong></td>
                <td> @foreach($profile->title as $title) {{$title->title}} @endforeach {{$profile->fullname}} {{$profile->lastname}}</td>
            </tr>
            <tr>
                <td><strong>Gender</strong></td>
                <td> {{$profile->gender->gender}} </td>
            </tr>
            <tr>
                <td><strong>Date of Birth</strong></td>
                <td> {{$profile->dob}} </td>
            </tr>
            @if($profile->bio)
            <tr>
                <td><strong>Bio</strong></td>
                <td> {{$profile->bio}} </td>
            </tr>
            @endif
            <tr>
                <td><strong>Country</strong></td>
                <td> {{$profile->country->name}} </td>
            </tr>
            <tr>
                <td><strong>City</strong></td>
                <td> {{$profile->city->name}} </td>
            </tr>
              <tr>
                  <td><strong>Languages</strong></td>
                  <td>   @foreach($profile->language as $language)
                          {{$language->name}}.
                        @endforeach
                  </td>
              </tr>
              <tr>
                  <td><strong>Responsible Staff</strong></td>
                  <td>{{$profile->maintainer->name}}</td>
              </tr>
          </tbody>
      </table>
  </div>
</div>
<div class="row white-box other-information-secion">
<h4 class="page-title"><strong>OTHER INFORMATION</strong></h4>
  <div class="table-responsive">
    <table class="table">
        <tbody>
            <tr>
                <td><strong>Platform (Media only)</strong></td>
                <td> {{$profile->platform}} </td>
            </tr>
            <tr>
                <td><strong>History</strong></td>
                <td> {{$profile->history}} </td>
            </tr>
        </tbody>
    </table>
</div>
</div>
