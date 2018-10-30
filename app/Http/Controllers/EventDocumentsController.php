<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use App\EventDocument;
use Auth;

class EventDocumentsController extends Controller
{
    public function __construct()
	{
		$this->middleware('auth');
	}

	public function download($id){
		$document = EventDocument::find($id);
		$extension = pathinfo(storage_path('app').'/public/'.$document->path, PATHINFO_EXTENSION);

		return response()->download(storage_path('app').'/public/'.$document->path, $document->document_name.".".$extension);
	}

	public function delete($id){
		$document = EventDocument::find($id);
		//$extension = pathinfo(storage_path('app').'/public/'.$document->path, PATHINFO_EXTENSION);

		if(file_exists(storage_path('app').'/public/'.$document->path)){
			unlink(storage_path('app').'/public/'.$document->path);
		}
		EventDocument::destroy($id);
		return redirect()->back();
	}

	public function store(Request $request, $slug){
		$event = Event::whereSlug($slug)->first();

		$path = $request->path->store('events/documents/'.$event->id,'public');
		$document = new EventDocument;
		$document->document_name = $request->document_name;
		$document->description = $request->description;
		$document->path = $path;
		$document->event_id = $event->id;
		$document->uploaded_by = Auth::user()->id;
		$document->save();

		return redirect()->back();
	}
}
