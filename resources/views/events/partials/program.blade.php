<div class="card">
    <div class="card-header">
        <strong>{{$section_title}}</strong> 
    </div>
    <div class="card-body">
        <strong>Instructions</strong>
        <ol>
            <li>Please <span class="text-danger"><strong>DO NOT</strong></span> copy text from Microsoft Word and Paste here. If you already have the Program on Word, first copy it to Notepad and then copy from Notepad onto here.</li>
            <li>If the writing space is too small, please expand by dragging the bottom border of this box</li>
        </ol>
                    
        <form method="post" action="/events/{{$event->slug}}" class="form-horizontal">
            <input name="_method" type="hidden" value="PATCH">  
            <input name="_token" type="hidden" value="">
            <input name="update" type="hidden" value="EventProgram">
            {{ csrf_field() }}
            <textarea class="form-control summernote" id="click2edit" name="content" rows="18">{{$event->event_program}}</textarea>
            <br>
            <button type="submit" class="btn btn-success btn-sm">
                 Save program
            </button>
        </form>
    </div>
</div>