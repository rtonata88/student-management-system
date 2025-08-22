<?php

namespace App\Http\Controllers;

use App\ClassDuration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TimeSlotsController extends Controller
{
    public function index()
    {
        if (!Auth::user()->hasPermission('view-time-slot')) {
            abort(403, 'Unauthorized action.');
        }

        $timeSlots = ClassDuration::orderBy('sort_order')->orderBy('start_time')->get();
        return view('time-slots.index', compact('timeSlots'));
    }

    public function create()
    {
        if (!Auth::user()->hasPermission('create-time-slot')) {
            abort(403, 'Unauthorized action.');
        }

        return view('time-slots.create');
    }

    public function store(Request $request)
    {
        if (!Auth::user()->hasPermission('create-time-slot')) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'period_name' => 'required|string|max:255',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'day_type' => 'required|string|max:50',
            'is_break' => 'boolean',
            'sort_order' => 'required|integer|min:1'
        ]);

        // Calculate duration in minutes
        $startTime = \Carbon\Carbon::createFromFormat('H:i', $request->start_time);
        $endTime = \Carbon\Carbon::createFromFormat('H:i', $request->end_time);
        $durationMinutes = $endTime->diffInMinutes($startTime);

        ClassDuration::create([
            'period_name' => $request->period_name,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'duration_minutes' => $durationMinutes,
            'day_type' => $request->day_type,
            'is_break' => $request->has('is_break'),
            'sort_order' => $request->sort_order,
            'is_active' => true
        ]);

        return redirect()->route('time-slots.index')
                        ->with('success', 'Time slot created successfully.');
    }

    public function edit(ClassDuration $timeSlot)
    {
        if (!Auth::user()->hasPermission('edit-time-slot')) {
            abort(403, 'Unauthorized action.');
        }

        return view('time-slots.edit', compact('timeSlot'));
    }

    public function update(Request $request, ClassDuration $timeSlot)
    {
        if (!Auth::user()->hasPermission('edit-time-slot')) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'period_name' => 'required|string|max:255',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'day_type' => 'required|string|max:50',
            'is_break' => 'boolean',
            'sort_order' => 'required|integer|min:1'
        ]);

        // Calculate duration in minutes
        $startTime = \Carbon\Carbon::createFromFormat('H:i', $request->start_time);
        $endTime = \Carbon\Carbon::createFromFormat('H:i', $request->end_time);
        $durationMinutes = $endTime->diffInMinutes($startTime);

        $timeSlot->update([
            'period_name' => $request->period_name,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'duration_minutes' => $durationMinutes,
            'day_type' => $request->day_type,
            'is_break' => $request->has('is_break'),
            'sort_order' => $request->sort_order
        ]);

        return redirect()->route('time-slots.index')
                        ->with('success', 'Time slot updated successfully.');
    }

    public function destroy(ClassDuration $timeSlot)
    {
        if (!Auth::user()->hasPermission('delete-time-slot')) {
            abort(403, 'Unauthorized action.');
        }

        $timeSlot->delete();

        return redirect()->route('time-slots.index')
                        ->with('success', 'Time slot deleted successfully.');
    }

    public function toggleStatus(ClassDuration $timeSlot)
    {
        if (!Auth::user()->hasPermission('edit-time-slot')) {
            abort(403, 'Unauthorized action.');
        }

        $timeSlot->update(['is_active' => !$timeSlot->is_active]);

        $status = $timeSlot->is_active ? 'activated' : 'deactivated';
        return redirect()->route('time-slots.index')
                        ->with('success', "Time slot {$status} successfully.");
    }
}
