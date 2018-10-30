<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use App\EventMiscellaneous;
use App\EventMiscellaneousFile;

use Auth;
use Session;

class EventMiscellaneousController extends Controller
{
    public function __construct()
	{
		$this->middleware('auth');
	}

	public function edit($id){
		$misc = EventMiscellaneous::find($id);

		return view('events.other-information.edit', compact('misc'));
	}

	public function download($id){
		$file = EventMiscellaneousFile::find($id);
		$extension = pathinfo(storage_path('app').'/public/'.$file->path, PATHINFO_EXTENSION);

		return response()->download(storage_path('app').'/public/'.$file->path, $file->description.".".$extension);
	}

	public function delete($id){
		$misc = EventMiscellaneous::find($id);
		if(count($misc->files) > 0){
			foreach ($misc->files as $file) {
				if(file_exists(storage_path('app').'/public/'.$file->path)){
					unlink(storage_path('app').'/public/'.$file->path);
				}
			}

			$misc->files()->delete();
		}
		EventMiscellaneous::destroy($id);
		return redirect()->back();
	}

	public function delete_file($id){
		$file = EventMiscellaneousFile::find($id);
		if(file_exists(storage_path('app').'/public/'.$file->path)){
			unlink(storage_path('app').'/public/'.$file->path);
		}
		EventMiscellaneousFile::destroy($id);

		Session::flash('message', 'The selected file has been deleted');
		return redirect()->back();
	}

	public function store(Request $request, $slug){
		$event = Event::whereSlug($slug)->first();
		$misc = new EventMiscellaneous;

		$misc->event_id = $event->id;
		$misc->title = $request->title;
		$misc->content = $request->content;
		$misc->created_by = Auth::user()->id;
		$misc->save();

		if(isset($request->path)){
			foreach ($request->path as $key => $value) {
				if($request->hasFile('path')){
					$misc_file = new EventMiscellaneousFile;
					$path = $request->path[$key]->store('events/misc/'.$event->id, 'public');
					$misc_file->event_miscellaneous_id = $misc->id;
					$misc_file->description = $request->description[$key];
					$misc_file->path = $path;
					$misc_file->save();
				}	
			}
		}	

		
		return redirect()->back();
	}

	public function update(Request $request, $id){
		$misc =  EventMiscellaneous::find($id);

		$misc->title = $request->title;
		$misc->content = $request->content;
		$misc->save();

		if(isset($request->path)){
			foreach ($request->path as $key => $value) {
				if($request->hasFile('path')){
					$misc_file = new EventMiscellaneousFile;
					$path = $request->path[$key]->store('events/misc/'.$misc->event->id, 'public');
					$misc_file->event_miscellaneous_id = $misc->id;
					$misc_file->description = $request->description[$key];
					$misc_file->path = $path;
					$misc_file->save();
				}	
			}
		}	
		return redirect()->back();
	}
}
