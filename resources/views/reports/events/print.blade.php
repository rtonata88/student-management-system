@extends('layouts.print')

@section('content')
<script type="text/javascript">
function myFunction(slug) {
    var myWindow = window.open("/report/events/print/"+slug, "", "width=auto,height=auto");
}
</script>
<div class="container-fluid">

     <div class="col-lg-12 col-md-12 col-sm-4 col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading"><h4 class="box-title m-t-20"><strong>POST EVENT REPORT</strong></h4>
               
            </div>
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
                    <table class="table" width="50%">
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
                    <table class="table" width="50%">
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

     <div class="col-lg-12 col-md-12 col-sm-4 col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading"><h4 class="box-title m-t-20"><strong>FEEDBACK /</strong> <small class="text-muted"> DISCUSSION OUTCOME AND SWOT ANALYSIS</small></h4></div>
            <div class="panel-wrapper collapse in">
                <div class="panel-body">
                    <p>
                        <?php $feedback_type =  $event->report->feedback_type; ?>
                        @if($feedback_type == 'both')
                        <p>
                            <strong>Feedback Type</strong>: Summary and Detailed<br>
                        </p>
                        @foreach($event->guest_register() as $register)
                            @if(!is_null($register->profile_id))
                                <p class="detailed-feedback m-t-20">
                                    <strong>{{strtoupper($register->fullname)}} {{strtoupper($register->lastname)}}: </strong> <br>
                                    <p>
                                        {{$event->participant->feedback}}
                                    </p>
                                </p>
                            @endif
                        @endforeach

                        <p class="m-t-20 summary-feedback">
                            <strong>Summary Outcome</strong> <br>
                            {{$event->report->summary}}
                        </p>

                        @elseif($feedback_type == 'detailed')
                            <strong>Feedback Type</strong>: {{ucwords($event->report->feedback_type)}}<br>

                            @foreach($event->guest_register() as $register)
                                @if(!is_null($register->profile_id))
                                <p class="detailed-feedback m-t-20">
                                    <strong>{{strtoupper($register->fullname)}} {{strtoupper($register->lastname)}}: </strong> <br>
                                    <p>
                                        {!!$event->guest_feedback($register->profile_id)->feedback!!}
                                    </p>
                                </p>
                                 @endif
                            @endforeach
                        @else
                            <strong>Feedback Type</strong>: {{ucwords($event->report->feedback_type)}}<br>
                            <p class="m-t-20 summary-feedback">
                                <strong>Summary Outcome</strong> <br>
                                {{$event->report->summary}}
                            </p>
                        @endif
                        </p>

                        <p>
                            <span class="m-t-20"><strong>SWOT ANALYSIS</strong></span> <br>
                            <strong>Strengths</strong> <br>
                            {{$event->report->summary}}
                        </p>
                        <p>
                            <strong>Weaknesses</strong> <br>
                            {{$event->report->summary}}
                        </p>
                        <p>
                            <strong>Opportunities</strong> <br>
                            {{$event->report->summary}}
                        </p>
                        <p>
                            <strong>Threats</strong> <br>
                            {{$event->report->summary}}
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

                    @foreach($event->report->misc_report() as $misc)
                        <div class="panel panel-default" style=" border: 1px solid #ddd">
                            <div class="panel-heading" style="background-color: #f5f5f5;">{{$misc->title}}
                                <div class="panel-action">
                                </div>
                            </div>
                            <div class="panel-wrapper collapse in">
                                <div class="panel-body">
                                    <p>
                                        {!! $misc->content !!}
                                    </p>

                                    @if(count($misc->files) > 0)
                                     <strong>Files that were uploaded for this section</strong>
                                     <p>
                                         If you would like these files to be part of the printed report, please download and print them seperately.
                                     </p>
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
                    <table class="table table-bordered">
                        <tr>
                    @foreach($event->photos as $index => $photo)
                        <td>
                            <!-- /.usercard -->
                            <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
                                <div class="white-box">
                                    <div class="el-card-item">
                                        <div class="el-card-avatar el-overlay-1"> <img src="{{ url('storage/'.$photo->path) }}" width="100%" alt="user" />
                                        </div>
                                        <div class="el-card-content">
                                            <p>
                                                {{$photo->caption}}
                                            </p>
                                           
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.usercard-->
                        </td>
                        @if(($index + 1) % 2 == 0)
                            </tr>
                            <tr>
                        @endif
                        
                        
                     @endforeach
                     </table>
                </div>
                <hr>
        </div>
    </div>
</div>

</div>

@endsection
