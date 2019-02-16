<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Documentation;
use App\Profile;
use App\DocumentationFile;
use App\DocumentationType;

use Session;

class DocumentationsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $documents = Documentation::with('profile', 'document_types', 'files')->get();
        return view('documentation.index', compact('documents'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $profiles = Profile::selectRaw('id, CONCAT(fullname," ",lastname) AS name')
                       ->pluck('name', 'id');
        $document_types = DocumentationType::pluck('type', 'id');


        return view('documentation.create', compact('profiles', 'document_types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $documentation = new Documentation;

        $documentation->profile_id = $request->profile_id;
        $documentation->documentation_type_id = $request->documentation_type_id;
        $documentation->file_location = $request->file_location;
        $documentation->effective_date = $request->effective_date;
        $documentation->current_or_former = $request->current_or_former;
        $documentation->save();

        //File uploads
        if ($request->hasFile('path')) {

            $path = $request->path->store('documentations/'.$documentation->document_types->type.'/'.$documentation->id,'public');
            $documentation_file = new DocumentationFile;
            $documentation_file->document_id = $documentation->id;
            $documentation_file->path = $path;
            
             if($request->file_name){

                $documentation_file->file_name = $request->file_name;
            } else {
                $documentation_file->file_name = $documentation->profile->fullname.' '.$documentation->profile->lastname.' - '.$documentation->document_types->type;
            }

            $documentation_file->save();
        }
        
        Session::flash('message', 'The record has been added, please confirm that it appears in the table below.');

        return redirect()->route('documentation.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $documentation = Documentation::find($id);
        return view('documentation.show', compact('documentation'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $documentation = Documentation::find($id);
        $profiles = Profile::selectRaw('id, CONCAT(fullname," ",lastname) AS name')
                       ->pluck('name', 'id');
        $document_types = DocumentationType::pluck('type', 'id');
        return view('documentation.edit', compact('documentation', 'profiles', 'document_types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $documentation =  Documentation::find($id);

        $documentation->profile_id = $request->profile_id;
        $documentation->documentation_type_id = $request->documentation_type_id;
        $documentation->file_location = $request->file_location;
        $documentation->effective_date = $request->effective_date;
        $documentation->current_or_former = $request->current_or_former;
        $documentation->save();

        //File uploads
        if ($request->hasFile('path')) {
            $path = $request->path->store('documentations/'.$documentation->document_types->type.'/'.$documentation->id,'public');

            $documentation_file = DocumentationFile::where('document_id', $id)->first();
            if($documentation_file){
                $documentation_file->path = $path;    
            } else {
                $documentation_file = new DocumentationFile;
                $documentation_file->path = $path;
            }
            $documentation_file->document_id = $documentation->id;
            
            if($request->file_name){

                $documentation_file->file_name = $request->file_name;
            } else {
                $documentation_file->file_name = $documentation->profile->fullname.' '.$documentation->profile->lastname.' - '.$documentation->document_types->type;
            }
            
            $documentation_file->save();
        }
        
        Session::flash('message', 'The record has been updated.');

        return redirect()->route('documentation.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function download($id)
    {
        $documentation = Documentation::find($id);
        $file_name = $documentation->profile->fullname.' '.$documentation->profile->lastname.' - '.$documentation->document_types->type;

        $extension = substr($documentation->files->path,strpos($documentation->files->path, "."));
        return response()->download(storage_path('app').'/public/'.$documentation->files->path, $file_name."".$extension);
    }
}
