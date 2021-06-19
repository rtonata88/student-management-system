<div id="event-other-modal" class="modal fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <strong>Add other information to this event</strong>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <svg class="c-icon mr-2">
                        <use xlink:href="{{asset('new/node_modules/@coreui/icons/sprites/free.svg#cil-x')}}"></use>
                    </svg>
                    </button>
            </div>
            <form method="post" action="/event-other-information/create/{{$event->slug}}" role="search" enctype="multipart/form-data">
            <div class="modal-body">
                    <input name="_token" type="hidden" value="">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <strong>{{Form::label('title', 'Section title')}}</strong>
                        {{Form::text('title', null, ['class' => 'form-control', 'required'])}}
                    </div>
                    
                    <div class="form-group">
                        <strong>{{Form::label('content', 'Content')}}</strong>
                        {{Form::textarea('content', null, ['class' => 'form-control', 'required'])}}
                    </div>

                    <div class="form-group">
                        <strong>{{Form::label('path', 'Add files (optional)')}} </strong><br>
                        {{Form::file('path[]', null, ['class' => 'form-control', 'required'])}}
                        {{Form::text('description[]', null, ['class' => 'form-control', 'placeholder' => 'Description'])}}
                    </div>
                    <div class="form-group">
                        {{Form::file('path[]', null, ['class' => 'form-control', 'required'])}}
                        {{Form::text('description[]', null, ['class' => 'form-control', 'placeholder' => 'Description'])}}
                    </div>
                    <div class="form-group">
                        {{Form::file('path[]', null, ['class' => 'form-control', 'required'])}}
                        {{Form::text('description[]', null, ['class' => 'form-control', 'placeholder' => 'Description'])}}
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn waves-effect" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-success">
                        <span class="fa fa-plus"></span> Save
                    </button>
            </div>
            </form>
            
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div> 