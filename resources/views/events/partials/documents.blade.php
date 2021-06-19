@include('events.partials.modals.documents')
<div class="card">
    <div class="card-header">
       <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#event-documents-modal">
            <span class="fa fa-upload"></span> Upload document
        </button>
    </div>
    <div class="card-body">
      @foreach($event->documents as $index=>$document)
        <table class="table table-responsive-sm table-bordered table-sm" id="invited-guests-table" cellspacing="0" width="100%">
            <thead>
                <tbody>
                    
                    <tr>
                        <td width="100px"><strong>Name</strong></td>
                        <td>{{$document->document_name}}</td>
                    </tr>
                    <tr>
                        <td><strong>Description</strong></td>
                        <td>{{$document->description}}</td>
                    </tr>
                    <tr>
                        <td><strong>Uploaded by</strong></td>
                        <td>{{$document->user->name}}</td>
                    </tr>
                     <tr>
                        <td><strong>Action</strong></td>
                        <td>
                            <a href="/event-documents/download/{{$document->id}}">
                                <svg class="c-icon text-default">
                                    <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-cloud-download')}}"></use>
                                </svg>
                            </a>
                                <a href="/event-documents/delete/{{$document->id}}"  onclick="return confirm('are you sure you want to delete this document? This operation cannot be reversed.')">
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