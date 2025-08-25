<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notice;
use App\User;
use App\Center;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class NoticeBoardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Notice::with('creator')->orderBy('created_at', 'desc');

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Filter by status
        if ($request->filled('status')) {
            if ($request->status === 'published') {
                $query->where('publish', true);
            } elseif ($request->status === 'draft') {
                $query->where('publish', false);
            }
        }

        // Search by title or description
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('short_description', 'like', "%{$search}%");
            });
        }

        $notices = $query->paginate(15);

        $categories = ['Announcement', 'Deadline', 'Information', 'Event', 'Academic'];

        return view('notice-board.index', compact('notices', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = ['Announcement', 'Deadline', 'Information', 'Event', 'Academic'];
        $centers = Center::all();
        
        return view('notice-board.create', compact('categories', 'centers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required|string',
            'title' => 'required|string|max:255',
            'short_description' => 'required|string|max:500',
            'body' => 'required|string',
            'target_center' => 'required|string',
            'attachments.*' => 'file|max:10240|mimes:pdf,doc,docx,jpg,jpeg,png,gif'
        ]);

        $attachments = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('notice-attachments', $filename, 'public');
                $attachments[] = [
                    'name' => $file->getClientOriginalName(),
                    'path' => $path,
                    'size' => $file->getSize()
                ];
            }
        }

        Notice::create([
            'category' => $request->category,
            'title' => $request->title,
            'short_description' => $request->short_description,
            'body' => $request->body,
            'publish' => $request->has('publish'),
            'target_campus' => $request->target_center,
            'attachments' => $attachments,
            'created_by' => Auth::id()
        ]);

        return redirect()->route('notice-board.index')->with('success', 'Notice created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $notice = Notice::with('creator')->findOrFail($id);
        return view('notice-board.show', compact('notice'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $notice = Notice::findOrFail($id);
        $categories = ['Announcement', 'Deadline', 'Information', 'Event', 'Academic'];
        $centers = Center::all();
        
        return view('notice-board.edit', compact('notice', 'categories', 'centers'));
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
        $notice = Notice::findOrFail($id);

        $request->validate([
            'category' => 'required|string',
            'title' => 'required|string|max:255',
            'short_description' => 'required|string|max:500',
            'body' => 'required|string',
            'target_center' => 'required|string',
            'attachments.*' => 'file|max:10240|mimes:pdf,doc,docx,jpg,jpeg,png,gif'
        ]);

        $attachments = $notice->attachments ?? [];
        
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('notice-attachments', $filename, 'public');
                $attachments[] = [
                    'name' => $file->getClientOriginalName(),
                    'path' => $path,
                    'size' => $file->getSize()
                ];
            }
        }

        $notice->update([
            'category' => $request->category,
            'title' => $request->title,
            'short_description' => $request->short_description,
            'body' => $request->body,
            'publish' => $request->has('publish'),
            'target_campus' => $request->target_center,
            'attachments' => $attachments
        ]);

        return redirect()->route('notice-board.index')->with('success', 'Notice updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $notice = Notice::findOrFail($id);
        
        // Delete attachments from storage
        if ($notice->attachments) {
            foreach ($notice->attachments as $attachment) {
                Storage::disk('public')->delete($attachment['path']);
            }
        }
        
        $notice->delete();

        return redirect()->route('notice-board.index')->with('success', 'Notice deleted successfully!');
    }

    /**
     * Toggle publish status
     */
    public function togglePublish($id)
    {
        $notice = Notice::findOrFail($id);
        $notice->update(['publish' => !$notice->publish]);

        $status = $notice->publish ? 'published' : 'unpublished';
        return redirect()->back()->with('success', "Notice {$status} successfully!");
    }

    /**
     * Remove attachment
     */
    public function removeAttachment(Request $request, $id)
    {
        $notice = Notice::findOrFail($id);
        $attachments = $notice->attachments ?? [];
        
        if (isset($attachments[$request->index])) {
            // Delete file from storage
            Storage::disk('public')->delete($attachments[$request->index]['path']);
            
            // Remove from array
            unset($attachments[$request->index]);
            $attachments = array_values($attachments); // Re-index array
            
            $notice->update(['attachments' => $attachments]);
        }

        return response()->json(['success' => true]);
    }
}
