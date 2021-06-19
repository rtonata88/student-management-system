
                  <div class="row white-box edit-assistant-section">
                    {!! Form::model($profile, array('route'=>array('profiles.show', $profile->slug), 'class'=> 'form-vertical form-material', 'enctype="multipart/form-data"', 'method'=>'PATCH', 'id'=>'profile-edit-form')) !!}

                    <div class="row">
                    <div class="col-md-8">
                        <strong>PERSONAL CONTACT INFORMATION</strong>
                    </div>

                  </div>
                      <table class="table table-responsive-sm table-bordered table-striped table-sm">
                          <tbody>
                              <tr>
                                  <td><strong>Mobile</strong></td>
                                  <td> {{$profile->mobile_no}} <br>
                                      {{$profile->mobile_no2}} <br>
                                      {{$profile->mobile_no_other}} </td>
                              </tr>
                              <tr>
                                  <td><strong>Email</strong></td>
                                  <td> {{$profile->email}} <br>
                                      {{$profile->email2}} </td>
                              </tr>

                          </tbody>
                      </table>
                  <strong>ORGANISATION</strong>
                  @forelse($organizations as $index=>$profile_organization)
                  <h6 class="page-title"><strong>{{$profile_organization->organization->name}}</strong></h6>
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
                  @empty
                  Not affiliated to any organisation
                  @endforelse
                <br>
                <strong>ASSISTANTS</strong>

                  <table class="table table-responsive-sm table-bordered table-striped table-sm" style="background-color: #fcfcfc; border: 1px solid #dbd9d9">
                      <tbody>
                          <tr>
                              <td><strong>Name</strong></td>
                              <td> {{Form::text('assistant_name',$assistant->assistant_name, ['class' => 'form-control', 'id'=>'assistant_name', 'placeholder' => 'Type here'])}}
                                {{Form::hidden('profile-slug',$profile->slug, ['class' => 'form-control', 'required'])}}
                                {{Form::hidden('id',$assistant->id, ['class' => 'form-control', 'id'=>'assistant_id', 'required'])}}
                              </td>
                          </tr>
                          <tr>
                              <td><strong>Email</strong></td>
                              <td>
                                {{Form::email('assistant_email1',$assistant->assistant_email1, ['class' => 'form-control', 'id'=>'assistant_email1', 'placeholder' => 'Primary'])}}
                                {{Form::email('assistant_email2',$assistant->assistant_email2, ['class' => 'form-control', 'id'=>'assistant_email2', 'placeholder' => 'Secondary'])}}
                                {{Form::email('assistant_email3',$assistant->assistant_email3, ['class' => 'form-control', 'id'=>'assistant_email3', 'placeholder' => 'Other'])}}
                               </td>
                          </tr>
                          <tr>
                              <td><strong>Contact Number</strong></td>
                              <td>
                                {{Form::text('assistant_number1',$assistant->assistant_number1, ['class' => 'form-control', 'id'=>'assistant_number1', 'placeholder'=>'Primary'])}}
                                {{Form::text('assistant_number2',$assistant->assistant_number2, ['class' => 'form-control', 'id'=>'assistant_number2', 'placeholder'=>'Secondary'])}}
                                {{Form::text('assistant_number3',$assistant->assistant_number3, ['class' => 'form-control', 'id'=>'assistant_number3', 'placeholder'=>'Other'])}}
                          </tr>
                      </tbody>
                  </table>
                  <div class="pull-right">
                    <a  href="" class="cancel-btn" section="assistant"><strong>Cancel</strong></a>
                    <button type="submit" class="btn btn-success save-btn" section="assistant"><span class="fa fa-check-circle"></span> Save </button>
                  </div>
              {!! Form::close() !!}
          </div>
