<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Student;
use App\Role;
use App\Permission;
use App\User;

use Session;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    public function index(Request $request){
        $query = User::with('employeeProfile')
            ->where('user_type', 'staff');

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('username', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        $users = $query->paginate(10);
        
        return view('Users.Index', compact('users'));
    }

    public function create(){
    
        $roles = Role::all();
    	return view('Users.Create', compact('roles'));
    }

    public function edit($username)
    {
    	$user = User::where('username', $username)->first();
		$roles = Role::all();
		$assigned_roles = $user->roles ? $user->roles->pluck('id')->toArray() : [];
		$permissions = Permission::all();
		$assigned_permissions = $user->permissions ? $user->permissions->pluck('id')->toArray() : [];
		$user_permissions = $user->permissions ? $user->permissions->pluck('name')->toArray() : [];
    	return view('Users.Edit', compact('user', 'roles', 'assigned_roles', 'permissions', 'assigned_permissions', 'user_permissions'));
    }

    public function show(Request $request)
    {
        // Show all non-staff users with search and pagination
        $query = User::where('user_type', '!=', 'staff');

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('username', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        $users = $query->paginate(15);
        
        return view('Users.Show', compact('users'));
    }

    public function showSingle($username)
    {
        $user = User::where('username', $username)->first();
        return view('Users.ShowSingle', compact('user'));
    }

    public function store(Request $requests)
    {
    	$validated = $this->validate($requests, [
            'email' => 'required|max:255|unique:users|email',
            'username' => 'required|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
        ]);

		$data = $requests->all();
		$data['username'] = Str::slug($requests->name, '.');
        $data['password'] = bcrypt($requests->password);
        $data['user_type'] = 'staff'; // Ensure all users created via Users/Create are staff
    	$user = User::create($data);
    	Session::flash('message', 'User created successfully!!');

    	return redirect('/users');
    }


    public function update(Request $requests, $id)
    {
    	$user = User::find($id);

    	$this->validate($requests, [
            'email' => 'required|max:255|email|unique:users,email,'.$id,
            'username' => 'required|max:255|unique:users,username,'.$id,
        ]);

		if(isset($requests->password)){
            $requests->validate([
                'password' => ['required', 'string', 'min:6', 'confirmed'],
            ]);

            $user->update(['password' => Hash::make($requests->password)]);
        }

    	$user->update($requests->except('password'));
        
        // Sync permissions directly
        if(isset($requests->permissions)){
            $user->syncPermissions($requests->permissions);
        } else {
            $user->syncPermissions([]);
        }
        
		Session::flash('message', 'User record updated successfully!!!');
    	return redirect('/users');
    }

    public function showChangePassword($username)
    {
        $user = User::with('employeeProfile')->where('username', $username)->first();
        return view('Users.ChangePassword', compact('user'));
    }

    public function updatePassword(Request $request, $username)
    {
        $user = User::where('username', $username)->first();
        
        $this->validate($request, [
            'password' => 'required|string|min:6|confirmed|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
        ]);

        $user->update(['password' => Hash::make($request->password)]);
        
        Session::flash('message', 'Password updated successfully!');
        return redirect('/users');
    }

    public function disableEnableUser($id){
    	$user = User::find($id);

    	if($user->approved == 1){
    		$user->approved = 0;
    	} else {
    		$user->approved = 1;
    	}
    	$user->save();

		Session::flash('message', 'User record updated successfully!!!');
    	return redirect('/users');
    }

    public function resetStudents(Request $request)
    {
        $currentYear = date('Y');
        
        // Build the query with proper joins
        $query = User::select(
                        'users.id',
                        'users.name',
                        'users.username',
                        'users.email',
                        'users.user_type',
                        'students.student_number',
                        'students.student_number2 as allocated_number',
                        'students.photo',
                        'centers.center_name',
                        'registrations.id as current_registration_id'
                    )
                    ->whereIn('users.user_type', ['student', 'parent'])
                    ->leftJoin('students', function($join) {
                        $join->on('users.username', '=', DB::raw("CONCAT('STU', students.student_number)"));
                    })
                    ->leftJoin('centers', 'students.center_id', '=', 'centers.id')
                    ->leftJoin('registrations', function($join) use ($currentYear) {
                        $join->on('students.id', '=', 'registrations.student_id')
                             ->where('registrations.academic_year', '=', $currentYear);
                    });

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('users.name', 'LIKE', "%{$search}%")
                  ->orWhere('users.username', 'LIKE', "%{$search}%")
                  ->orWhere('users.email', 'LIKE', "%{$search}%")
                  ->orWhere('students.student_number', 'LIKE', "%{$search}%")
                  ->orWhere('students.student_number2', 'LIKE', "%{$search}%");
            });
        }

        $students = $query->orderByRaw('registrations.id IS NULL ASC')
                          ->orderBy('users.name', 'ASC')
                          ->paginate(15);
        
        return view('Users.ResetStudents', compact('students'));
    }

    public function showStudentPasswordReset($username)
    {
        $user = User::where('username', $username)
                   ->where('user_type', 'student')
                   ->first();
        
        if (!$user) {
            Session::flash('error', 'Student not found!');
            return redirect()->route('users.reset-students');
        }
        
        return view('Users.StudentPasswordReset', compact('user'));
    }

    public function updateStudentPassword(Request $request, $username)
    {
        $user = User::where('username', $username)
                   ->where('user_type', 'student')
                   ->first();
        
        if (!$user) {
            Session::flash('error', 'Student not found!');
            return redirect()->route('users.reset-students');
        }
        
        $this->validate($request, [
            'password' => 'required|string|min:6|confirmed|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
        ]);

        $user->update(['password' => Hash::make($request->password)]);
        
        Session::flash('message', 'Student password updated successfully!');
        return redirect()->route('users.reset-students');
    }
}
