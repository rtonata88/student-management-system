<div class="card">
    <div class="card-header">
        <strong>{{$section_title}}</strong> 
    </div>
    <div class="card-body">
         <table class="table table-responsive-sm table-bordered table-striped table-sm" style="width:100%">
            <tbody>
                <tr>
                    <td width="390"><strong>Start date</strong></td>
                    <td> {{$event->start_date}} {{$event->start_time}} </td>
                </tr>
                <tr>
                    <td width="390"><strong>End date</strong></td>
                    <td> {{$event->end_date}} {{$event->end_time}} </td>
                </tr>
                <tr>
                    <td width="390"><strong>Address</strong></td>
                    <td> {{$event->address_line1}}</td>
                </tr>
                <tr>
                    <td width="390"></td>
                    <td> {{$event->address_line2}} </td>
                </tr>
                <tr>
                    <td width="390"></td>
                    <td> {{$event->city->name}}</td>
                </tr>
                <tr>
                    <td width="390"></td>
                    <td> {{$event->country->name}}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="card">
    <div class="card-body">
         <table class="table table-responsive-sm table-bordered table-striped table-sm" style="width:100%">
            <tbody>
                <tr>
                    <td><strong>Description</strong></td>
                    <td>{{$event->description}}</td>
                </tr> 
                <tr>
                    <td><strong>Purpose</strong></td>
                    <td>
                        {{$event->objectives}}
                    </td>
                </tr>
                <tr>
                    <td><strong>Theme</strong></td>
                    <td>{{$event->theme}}</td>
                </tr> 
                <tr>
                    <td><strong>Points of discussion</strong></td>
                    <td>
                        <ul>
                            @foreach($event->discussions as $discussion)
                            <li>{{$discussion->discussion_point}}</li>
                            @endforeach
                        </ul>
                    </td>
                </tr> 
                <tr>
                    <td>Participant roles</td>
                    <td>
                        <ul>
                            @foreach($event->participant_roles as $participant_role)
                            <li>{{$participant_role->role_name}}</li>
                            @endforeach
                        </ul>
                    </td>
                </tr>
                <tr>
                    <td>Staff roles</td>
                    <td>
                        <ul>
                            @foreach($event->staff_roles as $staff_role)
                            <li>{{$staff_role->role_name}}</li>
                            @endforeach
                        </ul>
                    </td>
                </tr>
                 <tr>
                    <td>Responsible teams</td>
                    <td>
                        <ul>
                            @foreach($event->team as $team)
                            <li> {{$team->name}} ({{$team->sector->name}})</li>
                            @endforeach
                        </ul>
                    </td>
                </tr>
            </tbody>
        </table>
         <a href="/events/{{$event->slug}}/edit" class="btn btn-success btn-sm">
            Update event details 
        </a>
    </div>               
</div>