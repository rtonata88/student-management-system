@include('events.partials.modals.others')
<p>This section allows you to save any other information related to this event.</p>
<div class="card">
    
     <div class="card-header">
         
       <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#event-other-modal">
            <span class="fa fa-plus"></span> Add other information
        </button>
    </div>
    <div class="card-body">
    @foreach($event->miscellaneous as $misc)
        <table class="table table-responsive-sm table-bordered table-sm" id="invited-guests-table" cellspacing="0" width="100%">
            <thead>
                <tbody>
                    
                    <tr>
                        <td width="100px"><strong>Title</strong></td>
                        <td>{{$misc->title}}</td>
                    </tr>
                    <tr>
                        <td><strong>Content</strong></td>
                        <td>{!! $misc->content !!}</td>
                    </tr>
                    <tr>
                        <td><strong>Files</strong></td>
                        <td>
                             @if(count($misc->files) > 0)
                            <strong>Downloadable Files</strong>
                                <ul>
                                    @foreach($misc->files as $file)
                                    <li>
                                        <a href="/misc-file/download/{{$file->id}}">{{$file->description}}</a>
                                    </li>
                                    @endforeach
                                </ul>
                            @endif
                        </td>
                    </tr>
                     <tr>
                        <td><strong>Action</strong></td>
                        <td>
                            <a href="/event-other-information/edit/{{$misc->id}}">
                                <svg class="c-icon text-default">
                                    <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-pencil')}}"></use>
                                </svg>
                            </a>
                                <a href="/event-other-information/delete/{{$misc->id}}"  onclick="return confirm('are you sure you want to delete this document? This operation cannot be reversed.')">
                                <svg class="c-icon text-danger">
                                    <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-trash')}}"></use>
                                </svg>
                            </a>
                        </td>
                    </tr>
                    
                </tbody>
        </table>
        <hr>
        @endforeach
    </div>
</div>