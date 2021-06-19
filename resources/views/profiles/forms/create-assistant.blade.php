<div id="assistantsModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myModalLabel">Add assistant</h4>
                <button type="button" class="close ml-auto" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            {!! Form::open(array('route'=>array('profiles.show', $profile->slug), 'class'=> 'form-vertical form-material', 'enctype="multipart/form-data"', 'method'=>'PATCH')) !!}
            <div class="modal-body organisation-modal-body">

                <table class="table table-responsive-sm table-bordered table-striped table-sm">
                    <tbody>
                        <tr>
                            <td><strong>Name</strong></td>
                            <td> {{Form::text('assistant_name',null, ['class' => 'form-control', 'id'=>'assistant_name', 'placeholder' => 'Type here'])}}
                              {{Form::hidden('profile-slug',$profile->slug, ['class' => 'form-control', 'required'])}}
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Email</strong></td>
                            <td>
                              {{Form::email('assistant_email1',null, ['class' => 'form-control', 'id'=>'assistant_email1', 'placeholder' => 'Primary'])}}
                              {{Form::email('assistant_email2',null, ['class' => 'form-control', 'id'=>'assistant_email2', 'placeholder' => 'Secondary'])}}
                              {{Form::email('assistant_email3',null, ['class' => 'form-control', 'id'=>'assistant_email3', 'placeholder' => 'Other'])}}
                             </td>
                        </tr>
                        <tr>
                            <td><strong>Contact Number</strong></td>
                            <td>
                              {{Form::text('assistant_number1',null, ['class' => 'form-control', 'id'=>'assistant_number1', 'placeholder'=>'Primary'])}}
                              {{Form::text('assistant_number2',null, ['class' => 'form-control', 'id'=>'assistant_number2', 'placeholder'=>'Secondary'])}}
                              {{Form::text('assistant_number3',null, ['class' => 'form-control', 'id'=>'assistant_number3', 'placeholder'=>'Other'])}}
                        </tr>
                    </tbody>
                </table>
            </div>
            {!! Form::close() !!}
            <div class="modal-footer">
              <a  href=""  data-dismiss="modal"><strong>Cancel</strong></a>
              <button type="button" class="btn btn-success waves-effect save-btn" section="new-assistant" data-dismiss="modal">Save</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
