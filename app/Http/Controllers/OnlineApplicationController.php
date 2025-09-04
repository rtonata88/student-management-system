<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\OnlineApplication;
use App\ApplicationDocument;
use App\User;
use App\Student;
use App\Module;
use App\Center;
use App\AcademicYear;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cache;

class OnlineApplicationController extends Controller
{
    /**
     * Show the account creation form
     */
    public function showSignupForm()
    {
        return view('online-application.signup');
    }

    /**
     * Create new student account
     */
    public function createAccount(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_names' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'email.unique' => 'This email address is already taken. Please use a different email address.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Generate unique username from email
        $emailParts = explode('@', $request->email);
        $baseUsername = $emailParts[0];
        $username = $baseUsername;
        
        // Ensure username is unique
        $counter = 1;
        while (User::where('username', $username)->exists()) {
            $username = $baseUsername . $counter;
            $counter++;
        }

        // Create user account
        $user = User::create([
            'name' => $request->first_names . ' ' . $request->surname,
            'username' => $username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'user_type' => 'student'
        ]);

        // Create online application record
        $application = OnlineApplication::create([
            'user_id' => $user->id,
            'application_number' => OnlineApplication::generateApplicationNumber(),
            'status' => 'pending'
        ]);

        // Log in the user
        Auth::login($user);

        return redirect()->route('online-application.student-info')
            ->with('success', 'Account created successfully! Please complete your student information.');
    }

    /**
     * Download application manual PDF
     */
    public function downloadApplicationManual()
    {
        $company = \App\CompanySetup::first();
        
        if (!$company) {
            return redirect()->back()->with('error', 'Company information not found.');
        }

        $pdf = \PDF::loadView('online-application.application-manual', compact('company'));
        
        return $pdf->download('Online_Application_Manual.pdf');
    }

    /**
     * Show student information form
     */
    public function showStudentInfoForm()
    {
        $user = Auth::user();
        $application = OnlineApplication::where('user_id', $user->id)->first();
        
        if (!$application) {
            return redirect()->route('login')->with('error', 'Application not found.');
        }

        $centers = Center::pluck('center_name', 'id');
        $subjects = Module::all(); // Get all available subjects
        $student = Student::where('user_id', $user->id)->first();
        
        // Generate student number immediately when page loads
        $studentNumber = $this->generateStudentNumber();
        
        // Reserve the generated number for 30 minutes to prevent conflicts
        Cache::put('reserved_number_' . $studentNumber, true, 30);
        
        // Pre-populate with user data from signup if student record doesn't exist
        if (!$student) {
            $student = (object) [
                'student_names' => explode(' ', $user->name)[0] ?? '',
                'surname' => explode(' ', $user->name)[1] ?? '',
                'contact_email' => $user->email,
                'student_number' => $studentNumber,
            ];
        } else {
            // If student exists but doesn't have a student number, assign the generated one
            if (empty($student->student_number)) {
                $student->student_number = $studentNumber;
            }
        }

        return view('online-application.student-info', compact('application', 'centers', 'student', 'subjects', 'studentNumber'));
    }

    /**
     * Store student information
     */
    public function storeStudentInfo(Request $request)
    {
        $user = Auth::user();
        $application = OnlineApplication::where('user_id', $user->id)->first();

        // Validation rules including new fields
        $rules = [
            'student_names' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'initials' => 'required|string|max:10',
            'student_number2' => 'required|string|max:255',
            'center_id' => 'required|exists:centers,id',
            'contact_email' => 'nullable|email',
            'contact_number' => 'required|string|regex:/^[1-9][0-9]{8}$/|max:9',
            'gender' => 'required|in:Male,Female',
            'date_of_birth' => 'required|string|regex:/^[0-9]{8}$/|size:8',
            'birth_certificate' => 'nullable|string|max:255',
            'id_number' => 'nullable|numeric',
            'student_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'subjects' => 'nullable|array',
            'subjects.*' => 'exists:modules,id',
            'document_types.*' => 'nullable|string',
            'document_names.*' => 'nullable|string|max:255',
            'document_files.*' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
        ];

        // Guardian validation
        if ($request->has('guardian_names') && is_array($request->guardian_names)) {
            $rules['guardian_names.*'] = 'nullable|string|max:255';
            $rules['guardian_surname.*'] = 'nullable|string|max:255';
            $rules['relationship.*'] = 'nullable|in:Father,Mother,Cousin,Aunt,Uncle,Sister,Brother';
            $rules['guardian_contact_number.*'] = 'nullable|string|regex:/^[1-9][0-9]{8}$/|max:9';
            $rules['guardian_contact_email.*'] = 'nullable|email';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Use the pre-generated student number from the form (passed via hidden field)
            $preGeneratedStudentNumber = $request->input('student_number');

            // Handle student photo upload
            $photoPath = null;
            if ($request->hasFile('student_photo')) {
                $photo = $request->file('student_photo');
                $photoName = time() . '_' . $photo->getClientOriginalName();
                $photoPath = $photo->storeAs('student_photos', $photoName, 'public');
            }

            // Create or update student record
            $studentData = [
                'user_id' => $user->id,
                'student_number' => $preGeneratedStudentNumber,
                'student_number2' => $request->student_number2,
                'photo' => $photoPath,
                'student_names' => $request->student_names,
                'surname' => $request->surname,
                'initials' => $request->initials,
                'center_id' => $request->center_id,
                'contact_email' => $request->contact_email,
                'contact_number' => '+264' . $request->contact_number,
                'gender' => $request->gender,
                'date_of_birth' => $request->date_of_birth,
                'birth_certificate' => $request->birth_certificate,
                'id_number' => $request->id_number,
            ];

            if ($photoPath) {
                $studentData['photo'] = $photoPath;
            }

            $student = Student::updateOrCreate(
                ['user_id' => $user->id],
                $studentData
            );

            // Handle guardian information
            if ($request->has('guardian_names') && is_array($request->guardian_names)) {
                // Clear existing guardians
                \DB::table('student_guardians')->where('student_id', $student->id)->delete();
                
                foreach ($request->guardian_names as $index => $guardianName) {
                    if (!empty($guardianName)) {
                        \DB::table('student_guardians')->insert([
                            'student_id' => $student->id,
                            'guardian_names' => $guardianName,
                            'surname' => $request->guardian_surname[$index] ?? '',
                            'relationship' => $request->relationship[$index] ?? '',
                            'contact_number' => isset($request->guardian_contact_number[$index]) ? '+264' . $request->guardian_contact_number[$index] : null,
                            'contact_email' => $request->guardian_contact_email[$index] ?? null,
                            'created_at' => now(),
                            'updated_at' => now()
                        ]);
                    }
                }
            }

            // Handle subject selection
            if ($request->has('subjects') && is_array($request->subjects)) {
                // Save to online_application_subjects table
                $application->subjects()->sync($request->subjects);
            }

            // Handle document uploads
            $this->handleDocumentUploads($request, $application->id);

            // Log success for debugging
            \Log::info('Student information saved successfully', [
                'user_id' => $user->id,
                'student_id' => $student->id,
                'student_names' => $student->student_names
            ]);

            return redirect()->route('online-application.review')
                ->with('success', 'Student information saved successfully!');
                
        } catch (\Exception $e) {
            \Log::error('Error saving student information', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->back()
                ->with('error', 'An error occurred while saving your information. Please try again.')
                ->withInput();
        }
    }

    /**
     * Handle document uploads for student
     */
    private function handleDocumentUploads($request, $applicationId)
    {
        if ($request->has('document_files') && is_array($request->document_files)) {
            foreach ($request->document_files as $index => $file) {
                if ($file && $file->isValid()) {
                    $documentType = $request->document_types[$index] ?? 'other';
                    $documentName = $request->document_names[$index] ?? $file->getClientOriginalName();
                    
                    $fileName = time() . '_' . $index . '_' . $file->getClientOriginalName();
                    $filePath = $file->storeAs('application-documents/' . $applicationId, $fileName, 'public');
                    
                    // Save to application_documents table to match the relationship
                    ApplicationDocument::create([
                        'application_id' => $applicationId,
                        'document_type' => $documentType,
                        'document_name' => $documentName,
                        'file_path' => $filePath,
                        'file_name' => $fileName,
                        'file_type' => $file->getClientMimeType(),
                        'file_size' => $file->getSize(),
                        'verified' => false
                    ]);
                }
            }
        }
    }

    /**
     * Show subject selection form
     */
    public function showSubjectSelection()
    {
        $user = Auth::user();
        $application = OnlineApplication::where('user_id', $user->id)->first();
        
        if (!$application) {
            return redirect()->route('login')->with('error', 'Application not found.');
        }

        // Handle search and pagination
        $search = request('search');
        $perPage = 15;
        
        $subjectsQuery = Module::query();
        
        if ($search) {
            $subjectsQuery->where(function($query) use ($search) {
                $query->where('subject_name', 'LIKE', "%{$search}%")
                      ->orWhere('subject_code', 'LIKE', "%{$search}%");
            });
        }
        
        $subjects = $subjectsQuery->paginate($perPage);
        $selectedSubjects = $application->subjects->pluck('id')->toArray();
        
        // Get all subject fees for JavaScript calculations (not just current page)
        $allSubjectFees = Module::pluck('subject_fees', 'id')->toArray();
        
        // Get active academic year to calculate course duration
        $activeAcademicYear = AcademicYear::where('status', 1)->first();
        $courseDurationMonths = 12; // Default fallback
        
        if ($activeAcademicYear && $activeAcademicYear->start_date && $activeAcademicYear->end_date) {
            $startDate = \Carbon\Carbon::parse($activeAcademicYear->start_date);
            $endDate = \Carbon\Carbon::parse($activeAcademicYear->end_date);
            $courseDurationMonths = $startDate->diffInMonths($endDate) + 1; // Include both start and end months
        }

        return view('online-application.subject-selection', compact('application', 'subjects', 'selectedSubjects', 'courseDurationMonths', 'search', 'allSubjectFees'));
    }

    /**
     * Store subject selection
     */
    public function storeSubjectSelection(Request $request)
    {
        $user = Auth::user();
        $application = OnlineApplication::where('user_id', $user->id)->first();

        $validator = Validator::make($request->all(), [
            'subjects' => 'required|array|min:1',
            'subjects.*' => 'exists:modules,id'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Sync selected subjects
        $application->subjects()->sync($request->subjects);

        return redirect()->route('online-application.document-upload')
            ->with('success', 'Subject selection saved successfully!');
    }

    /**
     * Show document upload form
     */
    public function showDocumentUpload()
    {
        $user = Auth::user();
        $application = OnlineApplication::where('user_id', $user->id)->first();
        
        if (!$application) {
            return redirect()->route('login')->with('error', 'Application not found.');
        }

        $documents = $application->documents;
        $documentTypes = ApplicationDocument::getDocumentTypes();

        return view('online-application.document-upload', compact('application', 'documents', 'documentTypes'));
    }

    /**
     * Upload document
     */
    public function uploadDocument(Request $request)
    {
        $user = Auth::user();
        $application = OnlineApplication::where('user_id', $user->id)->first();

        $validator = Validator::make($request->all(), [
            'document_type' => 'required|in:id_certificate,school_certificate,proof_of_payment,other',
            'document_name' => 'required|string|max:255',
            'document_file' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240' // 10MB max
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $file = $request->file('document_file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('application-documents/' . $application->id, $fileName, 'public');

        ApplicationDocument::create([
            'application_id' => $application->id,
            'document_type' => $request->document_type,
            'document_name' => $request->document_name,
            'file_path' => $filePath,
            'file_name' => $fileName,
            'file_type' => $file->getClientMimeType(),
            'file_size' => $file->getSize()
        ]);

        return redirect()->back()
            ->with('success', 'Document uploaded successfully!');
    }

    /**
     * Delete document
     */
    public function deleteDocument($id)
    {
        $user = Auth::user();
        $document = ApplicationDocument::whereHas('application', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })->findOrFail($id);

        $document->delete();

        return redirect()->back()
            ->with('success', 'Document deleted successfully!');
    }

    /**
     * Show application review
     */
    public function showReview()
    {
        $user = Auth::user();
        $application = OnlineApplication::where('user_id', $user->id)->first();
        
        if (!$application) {
            return redirect()->route('login')->with('error', 'Application not found.');
        }

        $student = Student::where('user_id', $user->id)->first();
        $subjects = $application->subjects;
        $documents = $application->documents;
        
        // Get active academic year to calculate course duration
        $activeAcademicYear = AcademicYear::where('status', 1)->first();
        $courseDurationMonths = 12; // Default fallback

        if ($activeAcademicYear && $activeAcademicYear->start_date && $activeAcademicYear->end_date) {
            $startDate = \Carbon\Carbon::parse($activeAcademicYear->start_date);
            $endDate = \Carbon\Carbon::parse($activeAcademicYear->end_date);
            $courseDurationMonths = $startDate->diffInMonths($endDate) + 1; // Include both start and end months
        }

        return view('online-application.review', compact('application', 'student', 'subjects', 'documents', 'courseDurationMonths'));
    }

    /**
     * Submit application
     */
    public function submitApplication()
    {
        $user = Auth::user();
        $application = OnlineApplication::where('user_id', $user->id)->first();

        if (!$application) {
            return redirect()->route('login')->with('error', 'Application not found.');
        }

        // Validate that all required information is complete
        $student = Student::where('user_id', $user->id)->first();
        $subjects = $application->subjects;
        $documents = $application->documents;

        $errors = [];
        if (!$student) {
            $errors[] = 'Student information is incomplete.';
        }
        if ($subjects->isEmpty()) {
            $errors[] = 'No subjects have been selected.';
        }
        if ($documents->isEmpty()) {
            $errors[] = 'No documents have been uploaded.';
        }

        if (!empty($errors)) {
            \Log::warning('Application submission failed validation', [
                'user_id' => $user->id,
                'application_id' => $application->id,
                'errors' => $errors,
                'student_exists' => $student ? true : false,
                'subjects_count' => $subjects->count(),
                'documents_count' => $documents->count()
            ]);
            
            return redirect()->back()
                ->with('error', 'Please complete all sections before submitting your application: ' . implode(' ', $errors));
        }

        $application->update([
            'submitted_at' => now(),
            'status' => 'under_review'
        ]);

        return redirect()->route('online-application.acknowledgement')
            ->with('success', 'Application submitted successfully!');
    }

    /**
     * Show acknowledgement and download letter
     */
    public function showAcknowledgement()
    {
        $user = Auth::user();
        $application = OnlineApplication::where('user_id', $user->id)->first();
        
        if (!$application || !$application->isSubmitted()) {
            return redirect()->route('login')->with('error', 'Application not found or not submitted.');
        }

        return view('online-application.acknowledgement', compact('application'));
    }

    /**
     * Download acknowledgement letter
     */
    public function downloadAcknowledgement()
    {
        $user = Auth::user();
        $application = OnlineApplication::where('user_id', $user->id)->first();
        
        if (!$application || !$application->isSubmitted()) {
            return redirect()->route('login')->with('error', 'Application not found or not submitted.');
        }

        $student = Student::where('user_id', $user->id)->first();
        $subjects = $application->subjects;
        $company = \App\CompanySetup::first();

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('online-application.acknowledgement-pdf', compact('application', 'student', 'subjects', 'company'));
        
        return $pdf->download('acknowledgement-letter-' . $application->application_number . '.pdf');
    }

    /**
     * Generate unique student number using active academic year
     */
    private function generateStudentNumber()
    {
        // Get the active academic year
        $activeAcademicYear = AcademicYear::where('status', 1)->first();
        
        // Extract the year from the academic year (e.g., "2024/2025" -> "2025")
        $yearPrefix = '2025'; // Default fallback
        if ($activeAcademicYear && $activeAcademicYear->academic_year) {
            // Handle formats like "2024/2025" or "2025"
            if (strpos($activeAcademicYear->academic_year, '/') !== false) {
                $years = explode('/', $activeAcademicYear->academic_year);
                $yearPrefix = trim($years[1]); // Use the second year (2025)
            } else {
                $yearPrefix = trim($activeAcademicYear->academic_year);
            }
        }
        
        // Generate random 5-digit number
        $randomNumber = str_pad(rand(10000, 99999), 5, '0', STR_PAD_LEFT);
        
        // Combine year prefix with random number (e.g., 202523765)
        $student_number = $yearPrefix . $randomNumber;

        // Check if this student number already exists in students table OR is cached as reserved
        $existsInStudents = Student::where('student_number', $student_number)->exists();
        $isReserved = Cache::has('reserved_number_' . $student_number);
        
        if($existsInStudents || $isReserved){
            return $this->generateStudentNumber(); // Recursively generate a new number
        }

        return $student_number;
    }
}
