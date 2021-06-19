@include('events.partials.modals.co-hosts')
<div class="card">
    <div class="card-header">
        <a class="btn btn-primary btn-sm" href="/event-co-host/create/{{$event->slug}}">
            Add co-host
        </a>
    </div>
    <div class="card-body">
      
        <table class="table table-responsive-sm table-bordered table-striped table-sm" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Contact persons</th>
                    <!-- <th>Logo</th> -->
                    <th>Action</th>
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
                            {{$contact->contact_number}} <br>
                            <em>{{$contact->contact_email}}</em>
                        </p>
                        @endforeach
                    </td>
                    <!-- <td>
                        <img src="{{asset('storage/'.$co_host->logo) }}" width="200">
                    </td> -->
                    <td width="100px"> 
                        
                        <a href="/event-co-host/view/{{$co_host->id}}">
                            <svg class="c-icon mr-2">
                                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-search')}}"></use>
                            </svg>
                        </a>

                        <a href="/event-co-host/edit/{{$co_host->id}}">
                            <svg class="c-icon mr-2">
                                <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-pencil')}}"></use>
                            </svg>
                        </a>

                        <a href="/event-co-host/delete/{{$co_host->id}}">
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