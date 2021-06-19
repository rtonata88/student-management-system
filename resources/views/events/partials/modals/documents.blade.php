<div id="event-documents-modal" class="modal fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
               <strong>Upload documents related to this event</strong>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                 <svg class="c-icon mr-2">
                    <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-x')}}"></use>
                </svg>
                </button>
            </div>
            <form method="post" action="/event-documents/upload/{{$event->slug}}" role="search" enctype="multipart/form-data">
            <div class="modal-body">
                    <input name="_token" type="hidden" value="">
                    {{ csrf_field() }}
                    <div class="form-group">
                        {{Form::label('document_name', 'Name of document')}}
                        {{Form::text('document_name', null, ['class' => 'form-control', 'required', 'placeholder' => 'Concept Note, Invitation Template, Thank You Template, Event Permit, Sponsorship letter'])}}
                    </div>
                    
                    <div class="form-group">
                        {{Form::label('description', 'What is this document about')}}
                        {{Form::textarea('description', null, ['class' => 'form-control', 'required'])}}
                    </div>

                        <div class="form-group">
                        {{Form::label('path', 'Browse')}}
                        {{Form::file('path', null, ['class' => 'form-control', 'required'])}}
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn  waves-effect" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-success">
                    Upload document
                </button>
            </div>
            </form>
            
        </div>
        <!-- /.modal-content -->
    </div>
</div>
    <!-- /.modal-dialog -->