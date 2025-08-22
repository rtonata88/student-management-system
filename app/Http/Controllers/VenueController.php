<?php

namespace App\Http\Controllers;

use App\Venue;
use App\Center;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VenueController extends Controller
{
    public function index()
    {
        if (!Auth::user()->hasPermission('view-venue')) {
            abort(403, 'Unauthorized action.');
        }

        $venues = Venue::with('center')->orderBy('venue_name')->get();
        return view('venues.index', compact('venues'));
    }

    public function create()
    {
        if (!Auth::user()->hasPermission('create-venue')) {
            abort(403, 'Unauthorized action.');
        }

        $centers = Center::all();
        return view('venues.create', compact('centers'));
    }

    public function store(Request $request)
    {
        if (!Auth::user()->hasPermission('create-venue')) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'venue_name' => 'required|string|max:255',
            'venue_code' => 'required|string|max:50|unique:venues',
            'capacity' => 'required|integer|min:1',
            'center_id' => 'required|exists:centers,id',
            'venue_type' => 'required|string|max:100',
            'description' => 'nullable|string|max:1000'
        ]);

        Venue::create([
            'venue_name' => $request->venue_name,
            'venue_code' => $request->venue_code,
            'capacity' => $request->capacity,
            'center_id' => $request->center_id,
            'venue_type' => $request->venue_type,
            'description' => $request->description,
            'is_active' => true
        ]);

        return redirect()->route('venues.index')
                        ->with('success', 'Venue created successfully.');
    }

    public function edit(Venue $venue)
    {
        if (!Auth::user()->hasPermission('edit-venue')) {
            abort(403, 'Unauthorized action.');
        }

        $centers = Center::all();
        return view('venues.edit', compact('venue', 'centers'));
    }

    public function update(Request $request, Venue $venue)
    {
        if (!Auth::user()->hasPermission('edit-venue')) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'venue_name' => 'required|string|max:255',
            'venue_code' => 'required|string|max:50|unique:venues,venue_code,' . $venue->id,
            'capacity' => 'required|integer|min:1',
            'center_id' => 'required|exists:centers,id',
            'venue_type' => 'required|string|max:100',
            'description' => 'nullable|string|max:1000'
        ]);

        $venue->update([
            'venue_name' => $request->venue_name,
            'venue_code' => $request->venue_code,
            'capacity' => $request->capacity,
            'center_id' => $request->center_id,
            'venue_type' => $request->venue_type,
            'description' => $request->description
        ]);

        return redirect()->route('venues.index')
                        ->with('success', 'Venue updated successfully.');
    }

    public function destroy(Venue $venue)
    {
        if (!Auth::user()->hasPermission('delete-venue')) {
            abort(403, 'Unauthorized action.');
        }

        $venue->delete();

        return redirect()->route('venues.index')
                        ->with('success', 'Venue deleted successfully.');
    }

    public function toggleStatus(Venue $venue)
    {
        if (!Auth::user()->hasPermission('edit-venue')) {
            abort(403, 'Unauthorized action.');
        }

        $venue->update(['is_active' => !$venue->is_active]);

        $status = $venue->is_active ? 'activated' : 'deactivated';
        return redirect()->route('venues.index')
                        ->with('success', "Venue {$status} successfully.");
    }
}
