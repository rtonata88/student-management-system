
                  <div class="row white-box edit-organisations-section">
                    {!! Form::model($profile, array('route'=>array('profiles.show', $profile->slug), 'class'=> 'form-vertical form-material', 'enctype="multipart/form-data"', 'method'=>'PATCH', 'id'=>'profile-edit-form')) !!}

                    <div class="row">
                    <div class="col-md-8">
                        <h4 class="page-title"><strong>PERSONAL CONTACT INFORMATION</strong></h4>
                    </div>

                  </div>
                    <div class="table-responsive">
                      <table class="table">
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
                  </div>
                  <h4 class="page-title"><strong>ORGANISATION</strong></h4>
                  @foreach($profile->organization_profile->where('id', $organisation_id) as $index=>$profile_organization)
                  <div class="table-responsive">
                  <h6 class="page-title"><strong>{{$profile_organization->organization->name}}</strong></h6>
                    <br>
                    <table class="table" style="background-color: #fcfcfc; border: 1px solid #dbd9d9">
                        <tbody>
                            <tr>
                                <td><strong>Position</strong></td>
                                <td> {{Form::text('position[]',$profile_organization->position, ['class' => 'form-control', 'id'=>'position', 'placeholder' => 'Type here'])}}
                                  {{Form::hidden('profile-slug',$profile->slug, ['class' => 'form-control', 'required'])}}
                                  {{Form::hidden('organization_id',$profile_organization->organization_id, ['class' => 'form-control', 'id'=>'organization_id', 'required'])}}
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Department</strong></td>
                                <td> {{Form::text('department[]',null, ['class' => 'form-control', 'id'=>'department', 'placeholder' => 'Type here'])}} </td>
                            </tr>
                            <tr>
                                <td><strong>Work Number</strong></td>
                                <td> {{Form::text('work_number[]',$profile_organization->work_number, ['class' => 'form-control', 'id'=>'work_number', 'placeholder'=>'Primary'])}}
                                {{Form::text('work_number2[]',$profile_organization->work_number2, ['class' => 'form-control', 'id'=>'work_number2', 'placeholder'=>'Secondary'])}}
                                {{Form::text('work_number_other[]',$profile_organization->work_number_other, ['class' => 'form-control', 'id'=>'work_number_other', 'placeholder'=>'Other'])}}
                            </tr>
                            <tr>
                                <td><strong>Email</strong></td>
                                <td>{{Form::email('email[]',$profile_organization->email, ['class' => 'form-control', 'id'=>'email','placeholder'=>'Primary'])}}
                                  {{Form::email('email2[]',$profile_organization->email2, ['class' => 'form-control', 'id'=>'email2','placeholder'=>'Secondary'])}}
                                  {{Form::email('email_other[]',$profile_organization->email_other, ['class' => 'form-control', 'id'=>'email_other', 'placeholder'=>'Other'])}} </td>
                            </tr>

                        </tbody>
                    </table>

                </div>
                @endforeach
                <div class="pull-right">
                  <a  href="" class="cancel-btn" section="organisation"><strong>Cancel</strong></a>
                  <button type="submit" class="btn btn-default save-btn" section="organisation"><span class="fa fa-check-circle"></span> Save </button>
                </div>
                <br>
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
              {!! Form::close() !!}
                  </div>
