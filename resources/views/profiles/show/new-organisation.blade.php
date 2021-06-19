<div class="organisation-{{$profile_organization->id}}">
  <div class="row">
    <div class="col-md-8">
      <h6 class="page-title"><strong>{{$profile_organization->organization->name}}</strong></h6>

    </div>
    <div class="col-md-4">
      <div class="pull-right">
        <a href="#" slug="{{$profile->slug}}" class="edit-btn" id="{{$profile_organization->id}}" section="organisation"><span class="fa fa-pencil"></span> Edit</a> |
        <a href="#" slug="{{$profile->slug}}" class="delete-btn" id="{{$profile_organization->id}}" section="organisation"><span class="fa fa-trash"></span> Detach</a>
      </div>
    </div>
  </div>
  <br>
  <table class="table table-responsive-sm table-bordered table-striped table-sm" style="background-color: #fcfcfc; border: 1px solid #dbd9d9">
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
