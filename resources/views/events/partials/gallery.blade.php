@include('events.partials.modals.gallery')
<div class="card">
    <div class="card-header">
       <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#event-gallery-modal">
            <span class="fa fa-plus"></span> Add photos
        </button>
    </div>
    <div class="card-body">
        @foreach($event->photos as $photo)
            <a href="{{ url('storage/'.$photo->path) }}" target="_blank" data-toggle="lightbox" data-effect="mfp-zoom-in" data-gallery="multiimages" data-title="{{$photo->caption}}">
                <img src="{{ url('storage/'.$photo->path) }}" alt="{{$photo->caption}}" class="all studio col-md-3 col-xs-12" style="background-color: rgba(245, 245, 245, 0.5); padding: 5px; border-radius: 5px;" />                 
            </a>
        @endforeach
    </div>
</div>