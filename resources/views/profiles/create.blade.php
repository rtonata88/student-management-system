@extends('layouts.hwpl')

@section('content')
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">FRUIT PROFILES</h4> </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <ol class="breadcrumb">
                    <li><a href="/profiles">Profiles</a></li>
                    <li class="active">Add New</li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <div class="row">
                <div class="white-box">
                    <a href="/profiles"> <span class="fa fa-arrow-circle-left"></span> Back</a>
                    <h3 class="box-title">PROFILE [NEW]</h3>
                    <hr>
                     {!! Form::open(array('url' => '/profiles', 'method' => 'post', 'class'=> 'form-vertical form-material', 'enctype="multipart/form-data"')) !!}
                     <div class="row">
                         <div class="form-group">
                           <div class="col-md-2">
                             {{Form::label('language_id', 'Language')}}
                             {{Form::select('language_id', $languages, null, ['class' => 'form-control select'])}}
                           </div>
                         </div>
                    </div>
                    <br>
                    <fieldset>
                        <legend>PERSONAL INFORMATION</legend>
                        <div class="row">
                            <div class="col-md-6">
                             <div class="form-group">
                              
                                {{Form::label('photo', 'Photo')}}
                                {{Form::file('photo', null, ['class' => 'form-control'])}}
                              </div>
                            </div>
                        </div>
                        <div class="row">
                        <div class="col-md-2">
                         <div class="form-group">
                          
                            {{Form::label('title', 'Title')}}<span class="text-danger">*</span>
                            {{Form::select('title', $titles, null, ['class' => 'form-control select', 'required'])}}
                          </div>
                        </div>
                        <div class="col-md-5">
                        <div class="form-group">
                          
                            {{Form::label('lastname', 'Lastname')}}<span class="text-danger">*</span>
                            {{Form::text('lastname',null, ['class' => 'form-control', 'required', 'placeholder' => 'Type here'])}}
                          </div>
                        </div>
                        <div class="col-md-5">
                        <div class="form-group">
                          
                            {{Form::label('fullname', 'Fullname')}}<span class="text-danger">*</span>
                            {{Form::text('fullname',null, ['class' => 'form-control', 'required', 'placeholder' => 'Type here'])}}
                          </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-2">
                         <div class="form-group">
                          
                            {{Form::label('gender_id', 'Gender')}}<span class="text-danger">*</span>
                            {{Form::select('gender_id', $gender, null, ['class' => 'form-control select', 'required'])}}
                          </div>
                        </div>
                        <div class="col-md-5">
                        <div class="form-group">
                          
                            {{Form::label('organization_id', 'Organization')}}<span class="text-danger">*</span>
                            {{Form::select('organization_id', $organizations, null, ['class' => 'form-control', 'required'])}}
                          </div>
                        </div>
                        <div class="col-md-5">
                        <div class="form-group">
                          
                            {{Form::label('position', 'Position')}}<span class="text-danger">*</span>
                            {{Form::text('position',null, ['class' => 'form-control', 'required', 'placeholder' => 'Type here'])}}
                          </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-12">
                        {{Form::label('bio', 'Biography')}}
                        {{Form::textarea('bio',null, ['class' => 'form-control', 'placeholder' => 'Type here'])}}
                        </div>
                    </div>


                    </fieldset>
                    <br>
                    <fieldset>
                        <legend>CONTACT INFORMATION</legend>

                    <div class="row">
                        <div class="col-md-4">
                        <div class="form-group">
                          
                            {{Form::label('work_number', 'Work Number')}}
                            {{Form::text('work_number',null, ['class' => 'form-control', 'placeholder'=>'Primary Work Number'])}}
                            {{Form::text('work_number2',null, ['class' => 'form-control', 'placeholder'=>'Secondary Work Number'])}}
                            {{Form::text('work_number_other',null, ['class' => 'form-control', 'placeholder'=>'Other'])}}
                          </div>
                        </div>
                        <div class="col-md-4">
                        <div class="form-group">
                            {{Form::label('email', 'Email')}}<span class="text-danger">*</span>
                            {{Form::email('email',null, ['class' => 'form-control', 'placeholder'=>'Primary Email', 'required'])}}
                            {{Form::email('email2',null, ['class' => 'form-control', 'placeholder'=>'Secondary Email'])}}
                            {{Form::email('email_other',null, ['class' => 'form-control', 'placeholder'=>'Other'])}}
                          </div>
                           
                        </div>
                         <div class="col-md-4">
                        <div class="form-group">
                             {{Form::label('mobile_no', 'Mobile Number')}}<span class="text-danger">*</span>
                            {{Form::text('mobile_no',null, ['class' => 'form-control', 'placeholder'=>'Primary Mobile Number', 'required'])}}
                            {{Form::text('mobile_no2',null, ['class' => 'form-control', 'placeholder'=>'Secondary Mobile Number'])}}
                            {{Form::text('mobile_no_other',null, ['class' => 'form-control', 'placeholder'=>'Other'])}}
                          </div>
                      </div>

                    </div>

                    <div class="row">
                        <div class="col-md-4">
                        <div class="form-group">
                          
                            {{Form::label('assistant_name', 'Assistant Name')}}
                            {{Form::text('assistant_name',null, ['class' => 'form-control', 'placeholder' => 'Type here'])}}
                          </div>
                        </div>
                        <div class="col-md-4">
                        <div class="form-group">
                            {{Form::label('assistant_email', 'Assistant Email')}}
                            {{Form::email('assistant_email',null, ['class' => 'form-control', 'placeholder' => 'Type here'])}}
                          </div>
                           
                        </div>
                         <div class="col-md-4">
                        <div class="form-group">
                            {{Form::label('assistant_number', 'Assistant Number')}}
                            {{Form::text('assistant_number',null, ['class' => 'form-control', 'placeholder' => 'Type here'])}}
                          </div>
                      </div>

                    </div>


                    </fieldset>

                     <br>
                    <fieldset>
                        <legend>BASIC INFORMATION</legend>
                        <div class="row">
                        <div class="col-md-6">
                         <div class="form-group">
                          
                            {{Form::label('sector_id', 'Sector')}}<span class="text-danger">*</span>
                            {{Form::select('sector_id', $sectors, null, ['class' => 'form-control select', 'required'])}}
                          </div>
                        </div>
                        <div class="col-md-6">
                         <div class="form-group">
                          
                            {{Form::label('team_id', 'Team')}}<span class="text-danger">*</span>
                            {{Form::select('team_id', $teams, null, ['class' => 'form-control select', 'required'])}}
                          </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                        <div class="form-group">
                          
                            {{Form::label('country_id', 'Country')}}<span class="text-danger">*</span>
                            {{Form::select('country_id', $countries, null, ['class' => 'form-control', 'required'])}}
                          </div>
                        </div>
                        <div class="col-md-6">
                        <div class="form-group">
                          
                            {{Form::label('city_id', 'City')}}<span class="text-danger">*</span>
                            {{Form::select('city_id', $cities, null, ['class' => 'form-control', 'required'])}}
                          </div>
                        </div>

                    </div>
                    </fieldset>

                     <fieldset>
                        <legend>RELATIONSHIP</legend>
                        <div class="row">
                        <div class="col-md-4">
                         <div class="form-group">
                          
                            {{Form::label('fruit_level_id', 'Level')}}<span class="text-danger">*</span>
                            {{Form::select('fruit_level_id', $fruit_levels, null, ['class' => 'form-control select', 'required'])}}
                          </div>
                        </div>
                        <div class="col-md-4">
                         <div class="form-group">
                          
                            {{Form::label('fruit_stage_id', 'Fruit Stage')}}<span class="text-danger">*</span>
                            {{Form::select('fruit_stage_id', $fruit_stages, null, ['class' => 'form-control select', 'required'])}}
                          </div>
                        </div>

                         <div class="col-md-4">
                         <div class="form-group">
                          
                            {{Form::label('fruit_role_id', 'Fruit Role')}}<span class="text-danger">*</span>
                            {{Form::select('fruit_role_id', $fruit_roles, null, ['class' => 'form-control select', 'required'])}}
                          </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                        <div class="form-group">
                          
                            {{Form::label('maintainer_id', 'Maintainer')}}<span class="text-danger">*</span>
                            {{Form::select('maintainer_id', $maintainers, null, ['class' => 'form-control', 'required'])}}
                          </div>
                        </div>
                        <div class="col-md-6">
                        <div class="form-group">
                          
                            {{Form::label('sector_relationship_id', 'Relationship with Sector')}}<span class="text-danger">*</span>
                            {{Form::select('sector_relationship_id', $sector_relationships, null, ['class' => 'form-control', 'required'])}}
                          </div>
                        </div>

                    </div>
                     <div class="row">
                        <div class="col-md-12">
                        {{Form::label('history', 'History')}}
                        {{Form::textarea('history',null, ['class' => 'form-control', 'placeholder' => 'Type here'])}}
                        </div>
                    </div>
                    <br>
                    </fieldset>


                    <button type="submit" class="btn btn-success"><span class="fa fa-check-circle"></span> Save</button>
                    <button type="reset" class="btn btn-warning"><span class="fa fa-ban"></span> Reset</button>
                    {!! Form::close() !!}
                </div>
    </div>
</div>
</div>
</div>
@endsection
