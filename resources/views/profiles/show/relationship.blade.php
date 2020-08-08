<div class="row white-box relationship-section">
  <div class="row">
    <div class="col-md-12">
      <div class="pull-right">
      <a href="#" slug="{{$profile->slug}}" class="edit-btn" section="relationship"><span class="fa fa-pencil"></span> Edit</a></a>
      </div>
    </div>
  </div>

  <div class="table-responsive">
    <table class="table">
        <tbody>
            <tr>
                <td><strong>Sector</strong></td>
                <td> {{$profile->sector->name}}</td>
            </tr>
            <tr>
                <td><strong>Team</strong></td>
                <td> {{$profile->team->name}} </td>
            </tr>
            <tr>
                <td><strong>Appointed Role</strong></td>
                <td> {{ $profile->fruit_role->role}} </td>
            </tr>
            <tr>
                <td><strong>Level</strong></td>
                <td> {{ $profile->fruit_stage->stage}} </td>
            </tr>
            <tr>
                <td><strong>Rank</strong></td>
                <td> {{$profile->fruit_level->level}} </td>
            </tr>
            <tr>
                <td><strong>Cult Awareness</strong></td>
                <td> {{$profile->cult_awareness}} </td>
            </tr>
            <tr>
                <td><strong>Pre-Poisoned</strong></td>
                <td> {{$profile->pre_poisoned}} </td>
            </tr>
            <tr>
                <td><strong>WARP Attendee</strong></td>
                <td> {{$profile->warp_attendee}} </td>
            </tr>
            <tr>
                <td><strong>Religion</strong></td>
                <td> {{$profile->religion->name}} </td>
            </tr>
        </tbody>
    </table>
</div>
</div>
