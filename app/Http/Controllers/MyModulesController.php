<?php

namespace App\Http\Controllers;

use App\SubjectAllocation;
use App\ModuleRegistration;
use App\Student;
use App\Attendance;
use App\SubjectMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class MyModulesController extends Controller
{
    public function __construct() 
    {
        $this->middleware('auth');
        $this->middleware('permission:view-my-modules')->only(['index']);
        $this->middleware('permission:view-class-list')->only(['classList']);
        $this->middleware('permission:view-attendance')->only(['attendance', 'attendanceData']);
        $this->middleware('permission:mark-attendance')->only(['markAttendance', 'storeAttendance']);
        $this->middleware('permission:edit-attendance')->only(['editAttendance', 'updateAttendance']);
        $this->middleware('permission:view-subject-materials')->only(['subjectMaterials']);
        $this->middleware('permission:upload-subject-materials')->only(['uploadMaterial', 'storeMaterial']);
        $this->middleware('permission:download-subject-materials')->only(['downloadMaterial']);
        $this->middleware('permission:edit-subject-materials')->only(['editMaterial', 'updateMaterial']);
        $this->middleware('permission:delete-subject-materials')->only(['deleteMaterial']);
    }

    /**
     * Display modules allocated to the current user
     */
    public function index()
    {
        $myModules = SubjectAllocation::with(['module', 'academicYear', 'center'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('MyModules.index', compact('myModules'));
    }

    /**
     * Display class list for a specific module allocation
     */
    public function classList($allocationId)
    {
        $allocation = SubjectAllocation::with(['module', 'academicYear', 'center'])
            ->where('id', $allocationId)
            ->where('user_id', Auth::id())
            ->firstOrFail();
            
        // Fetch students enrolled in this module for the current academic year
        $students = Student::whereHas('registered_modules', function($query) use ($allocation) {
            $query->where('module_id', $allocation->module_id)
                  ->where('academic_year', $allocation->academicYear->academic_year)
                  ->where('registration_status', 'Registered');
        })->orderBy('surname')->orderBy('student_names')->get();
        
        return view('MyModules.class-list', compact('allocation', 'students'));
    }

    /**
     * Display attendance for a specific module allocation
     */
    public function attendance($allocationId)
    {
        $allocation = SubjectAllocation::with(['module', 'academicYear', 'center'])
            ->where('id', $allocationId)
            ->where('user_id', Auth::id())
            ->firstOrFail();
            
        // Get students enrolled in this module
        $students = Student::whereHas('registered_modules', function($query) use ($allocation) {
            $query->where('module_id', $allocation->module_id)
                  ->where('academic_year', $allocation->academicYear->academic_year)
                  ->where('registration_status', 'Registered');
        })->orderBy('surname')->orderBy('student_names')->get();
        
        // Get attendance records for today by default
        $selectedDate = request('date', Carbon::today()->format('Y-m-d'));
        $selectedTime = request('time');
        
        $attendanceRecords = Attendance::with(['student'])
            ->where('subject_allocation_id', $allocationId)
            ->where('attendance_date', $selectedDate)
            ->when($selectedTime, function($query) use ($selectedTime) {
                return $query->where('class_time', $selectedTime);
            })
            ->get()
            ->keyBy('student_id');
            
        return view('MyModules.attendance', compact('allocation', 'students', 'attendanceRecords', 'selectedDate', 'selectedTime'));
    }

    /**
     * Mark attendance for students
     */
    public function markAttendance($allocationId)
    {
        $allocation = SubjectAllocation::with(['module', 'academicYear', 'center'])
            ->where('id', $allocationId)
            ->where('user_id', Auth::id())
            ->firstOrFail();
            
        // Get students enrolled in this module
        $students = Student::whereHas('registered_modules', function($query) use ($allocation) {
            $query->where('module_id', $allocation->module_id)
                  ->where('academic_year', $allocation->academicYear->academic_year)
                  ->where('registration_status', 'Registered');
        })->orderBy('surname')->orderBy('student_names')->get();
        
        $selectedDate = request('date', Carbon::today()->format('Y-m-d'));
        $selectedTime = request('time', Carbon::now()->format('H:i'));
        
        return view('MyModules.mark-attendance', compact('allocation', 'students', 'selectedDate', 'selectedTime'));
    }

    /**
     * Store attendance records
     */
    public function storeAttendance(Request $request, $allocationId)
    {
        $request->validate([
            'attendance_date' => 'required|date',
            'class_time' => 'required',
            'attendance' => 'required|array',
            'attendance.*' => 'in:present,absent,late,excused',
            'notes' => 'array',
            'notes.*' => 'nullable|string|max:255'
        ]);

        $allocation = SubjectAllocation::where('id', $allocationId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        foreach ($request->attendance as $studentId => $status) {
            // Check if attendance already exists for this combination
            $existingAttendance = Attendance::where([
                'student_id' => $studentId,
                'subject_allocation_id' => $allocationId,
                'attendance_date' => $request->attendance_date,
                'class_time' => $request->class_time
            ])->first();

            if ($existingAttendance) {
                // Update existing record
                $existingAttendance->update([
                    'status' => $status,
                    'notes' => $request->notes[$studentId] ?? null,
                    'recorded_by' => Auth::id()
                ]);
            } else {
                // Create new record
                Attendance::create([
                    'student_id' => $studentId,
                    'subject_allocation_id' => $allocationId,
                    'attendance_date' => $request->attendance_date,
                    'class_time' => $request->class_time,
                    'status' => $status,
                    'notes' => $request->notes[$studentId] ?? null,
                    'recorded_by' => Auth::id()
                ]);
            }
        }

        return redirect()->route('my-modules.attendance', $allocationId)
            ->with('success', 'Attendance recorded successfully for ' . Carbon::parse($request->attendance_date)->format('d F Y') . ' at ' . $request->class_time);
    }

    /**
     * Get attendance data for AJAX requests
     */
    public function attendanceData($allocationId)
    {
        $allocation = SubjectAllocation::where('id', $allocationId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $date = request('date', Carbon::today()->format('Y-m-d'));
        $time = request('time');

        $attendanceRecords = Attendance::with(['student'])
            ->where('subject_allocation_id', $allocationId)
            ->where('attendance_date', $date)
            ->when($time, function($query) use ($time) {
                return $query->where('class_time', $time);
            })
            ->get();

        return response()->json($attendanceRecords);
    }

    /**
     * Display subject materials for a specific module allocation
     */
    public function subjectMaterials(Request $request, $allocationId)
    {
        // Verify the allocation belongs to the authenticated user
        $allocation = SubjectAllocation::where('id', $allocationId)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $query = SubjectMaterial::with(['uploader'])
            ->where('module_allocation_id', $allocationId)
            ->published()
            ->active();

        // Apply search filter if provided
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('document_name', 'LIKE', "%{$search}%")
                  ->orWhere('document_description', 'LIKE', "%{$search}%")
                  ->orWhere('category', 'LIKE', "%{$search}%");
            });
        }

        // Apply category filter if provided
        if ($request->filled('category') && $request->get('category') !== 'all') {
            $query->where('category', $request->get('category'));
        }

        $materials = $query->orderBy('category')
            ->orderBy('created_at', 'desc')
            ->paginate(15)
            ->appends($request->query());

        $categories = SubjectMaterial::getCategories();

        return view('MyModules.subject-materials', compact('materials', 'allocation', 'categories'));
    }

    /**
     * Show upload form for subject materials
     */
    public function uploadMaterial($allocationId)
    {
        $allocation = SubjectAllocation::with(['module', 'academicYear', 'center'])
            ->where('id', $allocationId)
            ->where('user_id', Auth::id())
            ->firstOrFail();
            
        $categories = SubjectMaterial::getCategories();
            
        return view('MyModules.upload-material', compact('allocation', 'categories'));
    }

    /**
     * Store uploaded subject material
     */
    public function storeMaterial(Request $request, $allocationId)
    {
        $request->validate([
            'document_name' => 'required|string|max:255',
            'document_description' => 'nullable|string',
            'category' => 'required|in:Syllabus,Class Notes,General Info,Exam Papers,Others',
            'published' => 'required|boolean',
            'end_date' => 'nullable|date|after:today',
            'file' => 'required|file|max:10240|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,txt,jpg,jpeg,png'
        ]);

        $allocation = SubjectAllocation::where('id', $allocationId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('subject-materials/' . $allocationId, $fileName, 'public');

            SubjectMaterial::create([
                'module_allocation_id' => $allocationId,
                'document_name' => $request->document_name,
                'document_description' => $request->document_description,
                'category' => $request->category,
                'file_path' => $filePath,
                'file_name' => $fileName,
                'file_type' => $file->getClientMimeType(),
                'file_size' => $file->getSize(),
                'published' => $request->published,
                'end_date' => $request->end_date,
                'uploaded_by' => Auth::id()
            ]);

            return redirect()->route('my-modules.subject-materials', $allocationId)
                ->with('success', 'Material uploaded successfully!');
        }

        return back()->with('error', 'Failed to upload file. Please try again.');
    }

    /**
     * Download subject material
     */
    public function downloadMaterial($materialId)
    {
        $material = SubjectMaterial::with(['moduleAllocation'])
            ->where('id', $materialId)
            ->whereHas('moduleAllocation', function($query) {
                $query->where('user_id', Auth::id());
            })
            ->firstOrFail();

        if (!Storage::disk('public')->exists($material->file_path)) {
            return back()->with('error', 'File not found.');
        }

        return Storage::disk('public')->download($material->file_path, $material->file_name);
    }

    /**
     * Show edit form for subject material
     */
    public function editMaterial($materialId)
    {
        $material = SubjectMaterial::with(['moduleAllocation.module', 'moduleAllocation.academicYear', 'moduleAllocation.center'])
            ->where('id', $materialId)
            ->whereHas('moduleAllocation', function($query) {
                $query->where('user_id', Auth::id());
            })
            ->firstOrFail();

        $categories = SubjectMaterial::getCategories();
        
        return view('MyModules.edit-material', compact('material', 'categories'));
    }

    /**
     * Update subject material
     */
    public function updateMaterial(Request $request, $materialId)
    {
        $request->validate([
            'document_name' => 'required|string|max:255',
            'document_description' => 'nullable|string',
            'category' => 'required|in:Syllabus,Class Notes,General Info,Exam Papers,Others',
            'published' => 'required|boolean',
            'end_date' => 'nullable|date|after:today',
            'file' => 'nullable|file|max:10240|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,txt,jpg,jpeg,png'
        ]);

        $material = SubjectMaterial::with(['moduleAllocation'])
            ->where('id', $materialId)
            ->whereHas('moduleAllocation', function($query) {
                $query->where('user_id', Auth::id());
            })
            ->firstOrFail();

        // Update basic fields
        $material->update([
            'document_name' => $request->document_name,
            'document_description' => $request->document_description,
            'category' => $request->category,
            'published' => $request->published,
            'end_date' => $request->end_date,
        ]);

        // Handle file replacement if new file is uploaded
        if ($request->hasFile('file')) {
            // Delete old file
            if (Storage::disk('public')->exists($material->file_path)) {
                Storage::disk('public')->delete($material->file_path);
            }

            // Store new file
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('subject-materials/' . $material->module_allocation_id, $fileName, 'public');

            $material->update([
                'file_path' => $filePath,
                'file_name' => $fileName,
                'file_type' => $file->getClientMimeType(),
                'file_size' => $file->getSize(),
            ]);
        }

        return redirect()->route('my-modules.subject-materials', $material->module_allocation_id)
            ->with('success', 'Material updated successfully!');
    }

    /**
     * Delete subject material
     */
    public function deleteMaterial($materialId)
    {
        $material = SubjectMaterial::with(['moduleAllocation'])
            ->where('id', $materialId)
            ->whereHas('moduleAllocation', function($query) {
                $query->where('user_id', Auth::id());
            })
            ->firstOrFail();

        $material->delete();

        return back()->with('success', 'Material deleted successfully!');
    }
}
