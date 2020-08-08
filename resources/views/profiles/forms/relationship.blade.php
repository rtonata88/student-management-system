{!! Form::model($profile, array('route'=>array('profiles.show', $profile->slug), 'class'=> 'form-vertical form-material', 'enctype="multipart/form-data"', 'method'=>'PATCH', 'id'=>'profile-edit-form')) !!}
<div class="row white-box edit-relationship-section">
  <div class="table-responsive">
    <table class="table">
        <tbody>
            <tr>
                <td><strong>Sector</strong></td>
                <td> {{Form::select('sector_id', $sectors, null, ['class' => 'form-control select', 'placeholder'=>'Select','required'])}}</td>
            </tr>
            <tr>
                <td><strong>Team</strong></td>
                <td> {{Form::select('team_id', $teams, null, ['class' => 'form-control select', 'placeholder'=>'Select', 'required'])}}</td>
            </tr>
            <tr>
                <td><strong>Appointed Role</strong></td>
                <td> {{Form::select('fruit_role_id', $fruit_roles, null, ['class' => 'form-control select', 'placeholder'=>'None', 'required'])}} </td>
            </tr>
            <tr>
                <td><strong>Level</strong></td>
                <td> {{Form::select('fruit_stage_id', $fruit_stages, null, ['class' => 'form-control select', 'placeholder'=>'Select', 'required'])}} </td>
            </tr>
            <tr>
                <td><strong>Rank</strong></td>
                <td> {{Form::select('fruit_level_id', $fruit_levels, null, ['class' => 'form-control select', 'placeholder'=>'Select', 'required'])}} </td>
            </tr>
            <tr>
                <td><strong>Cult Awareness</strong></td>
                <td> {{Form::select('cult_awareness', ['Not sure' => 'Not Sure', 'No' => 'No', 'Yes' => 'Yes'], null, ['class' => 'form-control', 'placeholder'=>'Select', 'required'])}} </td>
            </tr>
            <tr>
                <td><strong>Pre-Poisoned</strong></td>
                <td> {{Form::select('pre_poisoned', ['Not sure' => 'Not Sure', 'No' => 'No', 'Yes' => 'Yes'], null, ['class' => 'form-control', 'placeholder'=>'Select', 'required'])}} </td>
            </tr>
            <tr>
                <td><strong>WARP Attendee</strong></td>
                <td> {{Form::select('warp_attendee', ['No' => 'No', 'Yes' => 'Yes'], null, ['class' => 'form-control', 'required'])}} </td>
            </tr>
            <tr>
                <td><strong>Religion</strong></td>
                <td> {{Form::select('religion_id', $religions, null, ['class' => 'form-control select', 'placeholder'=>'Unknown','required'])}} </td>
            </tr>
        </tbody>
    </table>
    <div class="pull-right">
      <a  href="" class="cancel-btn" section="relationship"><strong>Cancel</strong></a>
      <button type="submit" class="btn btn-default save-btn" section="relationship"><span class="fa fa-check-circle"></span> Save </button>
    </div>
</div>
</div>
{!! Form::close() !!}
