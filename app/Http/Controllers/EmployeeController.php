<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\EmployeeProfile;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    /**
     * Display a listing of all users as employees.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = User::with('employeeProfile');
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('username', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhereHas('employeeProfile', function($ep) use ($search) {
                      $ep->where('employee_number', 'LIKE', "%{$search}%")
                        ->orWhere('department', 'LIKE', "%{$search}%")
                        ->orWhere('position', 'LIKE', "%{$search}%");
                  });
            });
        }
        
        // Department filter
        if ($request->filled('department')) {
            $query->whereHas('employeeProfile', function($ep) use ($request) {
                $ep->where('department', $request->get('department'));
            });
        }
        
        // Status filter
        if ($request->filled('status')) {
            if ($request->get('status') === 'active') {
                $query->whereHas('employeeProfile', function($ep) {
                    $ep->where('is_active', true);
                });
            } elseif ($request->get('status') === 'inactive') {
                $query->whereHas('employeeProfile', function($ep) {
                    $ep->where('is_active', false);
                });
            } elseif ($request->get('status') === 'no_profile') {
                $query->doesntHave('employeeProfile');
            }
        }
        
        $users = $query->paginate(15)->appends($request->query());
        
        // Get unique departments for filter dropdown
        $departments = EmployeeProfile::whereNotNull('department')
                                     ->distinct()
                                     ->pluck('department')
                                     ->sort();
        
        return view('employees.index', compact('users', 'departments'));
    }


    /**
     * Display the specified employee profile.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::with('employeeProfile')->findOrFail($id);
        return view('employees.show', compact('user'));
    }

    /**
     * Show the form for editing the specified employee profile.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::with('employeeProfile')->findOrFail($id);
        return view('employees.edit', compact('user'));
    }

    /**
     * Update the specified employee profile in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $request->validate([
            'employee_number' => 'nullable|unique:employee_profiles,employee_number,' . ($user->employeeProfile->id ?? 'NULL'),
            'department' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
            'employment_type' => 'nullable|string|max:255',
            'hire_date' => 'nullable|date',
            'salary' => 'nullable|numeric|min:0',
            'personal_email' => 'nullable|email|max:255',
            'work_phone' => 'nullable|string|max:255',
            'personal_phone' => 'nullable|string|max:255',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->all();

        // Handle profile photo upload
        if ($request->hasFile('profile_photo')) {
            // Delete old photo if exists
            if ($user->employeeProfile && $user->employeeProfile->profile_photo) {
                Storage::disk('public')->delete($user->employeeProfile->profile_photo);
            }
            $data['profile_photo'] = $request->file('profile_photo')->store('employee_photos', 'public');
        }

        // Create or update employee profile
        if ($user->employeeProfile) {
            $user->employeeProfile->update($data);
        } else {
            $data['user_id'] = $user->id;
            EmployeeProfile::create($data);
        }

        return redirect()->route('employees.show', $user->id)->with('message', 'Employee profile updated successfully.');
    }

    /**
     * Remove the specified employee profile from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        if ($user->employeeProfile) {
            // Delete profile photo if exists
            if ($user->employeeProfile->profile_photo) {
                Storage::disk('public')->delete($user->employeeProfile->profile_photo);
            }
            $user->employeeProfile->delete();
        }

        return redirect()->route('employees.index')->with('message', 'Employee profile deleted successfully.');
    }
}
