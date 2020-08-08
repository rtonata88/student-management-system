<div id="organisationsModal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myModalLabel">Add organisation</h4>
                <button type="button" class="close ml-auto" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            {!! Form::open(array('route'=>array('profiles.show', $profile->slug), 'class'=> 'form-vertical form-material', 'enctype="multipart/form-data"', 'method'=>'PATCH')) !!}
            <div class="modal-body organisation-modal-body">
              <div class="table-responsive">

                <table class="table">
                    <tbody>
                      <tr>
                          <td><strong>Organisation</strong></td>
                          <td> {{Form::select('organisation_id', $organizations_list, null, ['class' => 'form-control select', 'id'=>'organisation_id', 'placeholder' => 'Select organisation'])}}
                            {{Form::hidden('profile-slug',$profile->slug, ['class' => 'form-control', 'required'])}}
                          </td>
                      </tr>
                        <tr>
                            <td><strong>Position</strong></td>
                            <td> {{Form::text('position',null, ['class' => 'form-control', 'id'=>'position', 'placeholder' => 'Type here'])}}
                              {{Form::hidden('profile-slug',$profile->slug, ['class' => 'form-control', 'required'])}}
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Department</strong></td>
                            <td> {{Form::text('department',null, ['class' => 'form-control', 'id'=>'department', 'placeholder' => 'Type here'])}} </td>
                        </tr>
                        <tr>
                            <td><strong>Work Number</strong></td>
                            <td> {{Form::text('work_number',null, ['class' => 'form-control', 'id'=>'work_number', 'placeholder'=>'Primary'])}}
                            {{Form::text('work_number2',null, ['class' => 'form-control', 'id'=>'work_number2', 'placeholder'=>'Secondary'])}}
                            {{Form::text('work_number_other',null, ['class' => 'form-control', 'id'=>'work_number_other', 'placeholder'=>'Other'])}}
                        </tr>
                        <tr>
                            <td><strong>Email</strong></td>
                            <td>{{Form::email('email',null, ['class' => 'form-control', 'id'=>'email','placeholder'=>'Primary'])}}
                              {{Form::email('email2',null, ['class' => 'form-control', 'id'=>'email2','placeholder'=>'Secondary'])}}
                              {{Form::email('email_other',null, ['class' => 'form-control', 'id'=>'email_other', 'placeholder'=>'Other'])}} </td>
                        </tr>

                    </tbody>
                </table>
              </div>
            </div>
            {!! Form::close() !!}
            <div class="modal-footer">
              <a  href=""  data-dismiss="modal"><strong>Cancel</strong></a>
                <button type="button" class="btn btn-info waves-effect save-btn" section="new-organisation" data-dismiss="modal">Save</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
