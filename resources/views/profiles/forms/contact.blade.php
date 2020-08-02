<div class="row white-box contacts-section">
  <h4 class="page-title"><strong>CONTACT INFORMATION</strong></h4>
  <div class="table-responsive">
    <table class="table">
        <tbody>
            <tr>
                <td><strong>Mobile</strong></td>
                <td> {{$profile->mobile_no}} <br>
              {{$profile->mobile_no2}} <br> {{$profile->mobile_no_other}} </td>
            </tr>
            <tr>
                <td><strong>Email</strong></td>
                <td> {{$profile->email}} <br>
                    {{$profile->email2}} </td>
            </tr>

        </tbody>
    </table>
</div>
<h4 class="page-title"><strong>ORGANISATION</strong></h4>
@forelse($organizations as $index=>$profile_organization)
<div class="table-responsive">
  <h6 class="page-title"><strong>{{$profile_organization->organization->name}}</strong></h6>
  <table class="table">
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
              {{$profile_organization->work_number2}}
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

<h4 class="page-title"><strong>ASSISTANTS</strong></h4>
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
</div>
