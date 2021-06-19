@include('events.partials.modals.staff')
<div class="card">
    <div class="card-header">
        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#staff">
            Add staff
        </button>
    </div>
    <div class="card-body">
      
        <table class="table table-responsive-sm table-bordered table-striped table-sm" id="invited-guests-table" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Country</th>
                    <th>Responsibility</th>
                    <th class="text-center">Action</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($event->event_staff as $index=>$staff)
                    <tr>
                        <td>{{$staff->user->name}}</td>
                        <td>{{$staff->user->country->name}}</td>
                        <td>{{$staff->responsibility}}</td>
                        <td class="text-center">
                            <a href="/event-staff/remove/{{$staff->id}}" class="text-danger" onclick="return confirm('are you sure you want to remove {{$staff->user->name}} from the event?')">
                                <svg class="c-icon mr-2">
                                    <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-trash')}}"></use>
                                </svg>
                             </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
        </table>
    </div>
</div>