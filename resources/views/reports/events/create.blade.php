@extends('layouts.hwpl')

@section('content')
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">POST EVENT REPORT</h4> </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <ol class="breadcrumb">
                 <li class="active">Events</li>
             </ol>
         </div>
         <!-- /.col-lg-12 -->
     </div>

     <div class="col-lg-12 col-md-12 col-sm-4 col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading"><h4 class="box-title m-t-20"><strong>EVENT /</strong> <small class="text-muted"> EVENT DETAILS AND STAFF MEMBERS</small></h4></div>
            <div class="panel-wrapper collapse in">
                <div class="panel-body">
                    <p>
                    <strong>EVENT NAME:</strong>
                    
                        {{$event->name}} (<i>{{$event->theme}}</i>)
                    </p>
                    <p>
                        <strong>DESCRIPTION:</strong>
                        {{$event->description}}
                    </p>
                    <p>
                        <strong>PURPOSE/OBJECTIVES:</strong>
                    {{$event->objectives}}
                    </p>
                    

                <strong>THEME: {{$event->theme}}</strong>
                <ul class="list-icons">
                    @foreach($event->discussions as $discussion)
                    <li><span class="fa fa-caret-right text-info"></span> {{$discussion->discussion_point}}</li>
                    @endforeach
                </ul>
                <p>
                <strong>GENERAL INFORMATION</strong>
                <div class="table-responsive">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td width="390"><strong>START DATE</strong></td>
                                <td> {{$event->start_date}} {{$event->start_time}} </td>
                            </tr>
                            <tr>
                                <td width="390"><strong>END DATE</strong></td>
                                <td> {{$event->end_date}} {{$event->end_time}} </td>
                            </tr>
                            <tr>
                                <td width="390"><strong>ADDRESS LINE 1</strong></td>
                                <td> {{$event->address_line1}}</td>
                            </tr>
                            <tr>
                                <td width="390"><strong>ADDRESS LINE 2</strong></td>
                                <td> {{$event->address_line2}} </td>
                            </tr>
                            <tr>
                                <td width="390"><strong>CITY</strong></td>
                                <td> {{$event->city->name}}</td>
                            </tr>
                            <tr>
                                <td width="390"><strong>COUNTRY</strong></td>
                                <td> {{$event->country->name}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                </p>
                <p>
                <strong>STAFF</strong>
                <div class="table-responsive">
                    <table class="table">
                        <tbody>
                            @foreach($event->event_staff as $index=>$staff)
                            <tr>
                                <td width="390"><strong>{{$staff->user->name}}</strong></td>
                                <td> {{$staff->role->role_name}} </td>
                                <td> {{$staff->user->country->name}} </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                </p>
            </div>
        </div>
    </div>
</div>

     <div class="col-lg-12 col-md-12 col-sm-4 col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading"><h4 class="box-title m-t-20"><strong>LIAISING /</strong> <small class="text-muted"> STATISTICS, INVITED GUESTS AND GENERAL AUDIENCE</small></h4></div>
            <div class="panel-wrapper collapse in">
                <div class="panel-body">
                    <p>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <td width="390"><strong>RSVP</strong></td>
                                        <td width="390"><strong>DECLINED</strong></td>
                                        <td width="390"><strong>REVOKED</strong></td>
                                        <td width="390"><strong>PENDING</strong></td>
                                        <td width="390"><strong>ATTENDED</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="text-center"> {{$event->count_attendees_status('RSVP')}} </td>
                                        <td class="text-center"> {{$event->count_attendees_status('DECLINE')}} </td>
                                        <td class="text-center"> {{$event->count_attendees_status('REVOKE')}}</td>
                                        <td class="text-center"> {{$event->count_attendees_status('PENDING')}}</td>
                                        <td class="text-center"> {{$event->check_ins()->count()}} </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </p>
                    <strong>INVITED GUESTS</strong>
                    <p>   
                    <div class="table-responsive">
                            <table class="table table-bordered" width="50%">
                                <tbody>
                                    <tr>
                                        <td width="390"><strong>GUEST NAME</strong></td>
                                        <td width="390"><strong>ROLE</strong></td>
                                        <td width="390"><strong>ORGANIZATION</strong></td>
                                    </tr>
                                    @foreach($event->guest_register() as $register)
                                        @if(!is_null($register->profile_id))
                                        <tr>
                                            <td> {{$register->fullname}} {{$register->lastname}} </td>
                                            <td> {{$event->guest_role($register->profile_id)->role_name}} </td>
                                            <td> {{$event->organization($register->profile_id)->name}} </td>
                                        </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>                       
                    </p>

                    <strong>GENERAL AUDIENCE</strong>
                    <p>   
                        <div class="table-responsive">
                            <table class="table table-bordered" width="50%">
                                <tbody>
                                    <tr>
                                        <td width="390"><strong>GUEST NAME</strong></td>
                                        <td width="390"><strong>EMAIL</strong></td>
                                        <td width="390"><strong>MOBILE NUMBER</strong></td>
                                    </tr>
                                    @foreach($event->guest_register() as $register)
                                        @if(is_null($register->profile_id))
                                        <tr>
                                            <td> {{$register->fullname}} {{$register->lastname}} </td>
                                            <td> {{$register->email}} </td>
                                            <td> {{$register->mobile_no}} </td>
                                        </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>             
                    </p>
                    @if($event->co_hosts)
                    <strong>EVENT CO-HOSTS</strong>
                    <p>   
                        <div class="table-responsive">
                            <table class="table table-bordered" width="50%">
                                <thead>
                                    <tr>
                                        <th>NAME</th>
                                        <th>ADDRESS</th>
                                        <th>CONTACT PERSONS</th>
                                        <th>LOGO</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($event->co_hosts as $index=>$co_host)
                                    <tr>
                                        <td>{{$co_host->name}}</td>
                                        <td>
                                            <p>
                                                {{$co_host->address_line1}} <br>
                                                {{$co_host->address_line2}} <br>
                                                {{$co_host->address_line3}} <br>
                                                {{$co_host->address_line4}}
                                            </p>
                                        </td>
                                        <td>
                                            @foreach($co_host->contacts as $contact)
                                            <p>
                                                <strong>{{$contact->contact_person}}</strong> <br>
                                                {{$contact->contact_number}} | 
                                                {{$contact->contact_email}}
                                            </p>
                                            @endforeach
                                        </td>
                                        <td>
                                            <img src="{{asset('storage/'.$co_host->logo) }}" width="200">
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>             
                    </p>
                    @endif

            </div>
        </div>
    </div>
</div>

 {!! Form::open(array('url' => '/report/events/create/{{$event->slug}}', 'method' => 'post')) !!}

     <div class="col-lg-12 col-md-12 col-sm-4 col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading"><h4 class="box-title m-t-20"><strong>FEEDBACK /</strong> <small class="text-muted"> DISCUSSION OUTCOME AND SWOT ANALYSIS</small></h4></div>
            <div class="panel-wrapper collapse in">
                <div class="panel-body">
                    <p>
                        As a rule of thumb, it's best to give a <strong>summary</strong> feedback for large events as opposed to <strong>detailed</strong> feedback. For small events such as the WARP Offices, you may provide <strong>detailed</strong> feedback. But do not feel discouraged to do a detailed outcome for large events.<br>

                        <strong>Summary </strong>- Summary outcome of the discussions. <br>
                        <strong>Detailed </strong>- Discussion outcome per guest/participant, what each participant has said during the event. <br>
                    </p>
                    <p>
                        <div class="radio-list">
                            <label class="radio-inline p-0">
                                <div class="radio radio-info">
                                    <input type="radio" name="feedback_type" class="feedback-type" id="radio1" value="summary">
                                    <label for="radio1"><strong>Summary </strong></label>
                                </div>
                            </label> 
                            <label class="radio-inline">
                                <div class="radio radio-info">
                                    <input type="radio" name="feedback_type" class="feedback-type" id="radio2" value="detailed">
                                    <label for="radio2"><strong>Detailed </strong> </label>
                                </div>
                            </label>

                            <label class="radio-inline">
                                <div class="radio radio-info">
                                    <input type="radio" name="feedback_type"   class="feedback-type" id="radio3" value="both">
                                    <label for="radio2"><strong>Both </strong> </label>
                                </div>
                            </label>
                        </div>
                    </p>
                    @foreach($event->guest_register() as $register)
                        @if(!is_null($register->profile_id))
                            <p class="detailed-feedback m-t-20">
                                <strong>{{strtoupper($register->fullname)}} {{strtoupper($register->lastname)}}: </strong> <br>
                                <textarea class="form-control" rows="10" name="detailed_outcome[{{$register->profile_id}}]"></textarea>
                            </p>
                        @endif
                    @endforeach
                    <p class="m-t-20 summary-feedback">
                        <strong>SUMMARY OUTCOME</strong> <br>
                        <textarea class="form-control" rows="10" name="summary_outcome"></textarea>
                    </p>


                    <p class="text-muted text-info">
                        <span class="fa fa-info-circle"></span> If the writing space is not enough the text area is expandable. To expand it, put your mouse over the bottom right corner and drag down..
                    </p>
                    <p>
                        <strong>STRENGTHS</strong> <br>
                        <textarea class="form-control" rows="10" name="strengths"></textarea>
                    </p>
                    <p>
                        <strong>WEAKNESSES</strong> <br>
                        <textarea class="form-control" rows="10" name="weaknesses"></textarea>
                    </p>
                    <p>
                        <strong>OPPORTUNITIES</strong> <br>
                        <textarea class="form-control" rows="10" name="opportunities"></textarea>
                    </p>
                    <p>
                        <strong>THREATS</strong> <br>
                        <textarea class="form-control" rows="10" name="threats"></textarea>
                    </p>

            </div>
        </div>
    </div>
</div>

     <div class="col-lg-12 col-md-12 col-sm-4 col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading"><h4 class="box-title m-t-20"><strong>MISCELLANEOUS /</strong> <small class="text-muted"> OTHER INFORMATION THAT SHOULD BE INCLUDED IN THIS REPORT</small></h4></div>
            <div class="panel-wrapper collapse in">
                <div class="panel-body">

                    @foreach($event->miscellaneous as $misc)
                        <div class="panel panel-default" style=" border: 1px solid #ddd">
                            <div class="panel-heading" style="background-color: #f5f5f5;">{{$misc->title}}
                                <div class="panel-action">
                                  <div class="checkbox checkbox-success">
                                            <input  type="checkbox" name="misc[{{$misc->id}}]">
                                            <label for="checkbox33">Include in this report</label>
                                        </div>
                                </div>
                            </div>
                            <div class="panel-wrapper collapse in">
                                <div class="panel-body">
                                    <p>
                                        {!! $misc->content !!}
                                    </p>

                                    @if(count($misc->files) > 0)
                                     <strong>Files</strong>
                                        <ul>
                                            @foreach($misc->files as $file)
                                            <li>
                                                <a href="/misc-file/download/{{$file->id}}">{{$file->description}}</a>
                                            </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
            </div>
        </div>
    </div>
</div>

     <div class="col-lg-12 col-md-12 col-sm-4 col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading"><h4 class="box-title m-t-20"><strong>GALLERY </strong> <small class="text-muted"></small></h4></div>
            <div class="panel-wrapper collapse in">
                <div class="panel-body">
                    <div class="m-t-20 row">
                        @foreach($event->photos as $photo)
                        <div class="col-md-4 col-xs-12">
                            <div class="white-box">
                                <div class="user-bg"> 
                                    <img width="100%" alt="user" src="{{ url('storage/'.$photo->path) }}">
                                </div>
                                <div class="user-btm-box">
                                    {{$photo->caption}}
                                </div>
                            </div>
                        </div>                      
                        @endforeach
                     </div>
                </div>
                <hr>
                <div class="pull-right">
                    <button type="submit" class="btn btn-success btn-lg">
                        <span class="fa fa-cog"></span> Save Report
                    </button>
                </div>
        </div>
    </div>
</div>


{!! Form::close() !!}
</div>

@endsection
