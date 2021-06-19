@include('events.partials.modals.guest-modals')
<div class="card">
    <div class="card-header">
       <strong>Media coverage for this event</strong>
    </div>
    <div class="card-body">
      @if(count($event->media_coverage))
        <table class="table table-responsive-sm table-bordered table-striped table-sm" id="invited-guests-table" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Covered by</th>
                    <th>Date</th>
                    <th>Title</th>
                    <th>Platform</th>
                    <th>Media house</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>

                @foreach($event->media_coverage as $coverage)
                <tr>
                    <td>{{$coverage->profile->fullname}}</td>
                    <td>{{$coverage->when}}</td>
                    <td>{{$coverage->title}}</td>
                    <td>{{$coverage->platform}}</td>
                    <td>
                        {{$coverage->media_house}}
                    </td>
                    <td>

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
            There is no media coverage for this event at the moment. Media coverage is added by the media team.
        @endif
    </div>
</div>