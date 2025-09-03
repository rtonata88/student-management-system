<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Student;
use App\StudentBlock;
use App\Center;
use App\Module;
use App\AcademicYear;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StudentBlockController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'permission:view-student-blocks'])->only(['index', 'show']);
        // $this->middleware(['auth', 'permission:create-student-blocks'])->only(['create', 'store']);
        $this->middleware(['auth', 'permission:edit-student-blocks'])->only(['edit', 'update']);
        $this->middleware(['auth', 'permission:delete-student-blocks'])->only(['destroy']);
        $this->middleware(['auth', 'permission:block-students'])->only(['blockStudent']);
        $this->middleware(['auth', 'permission:unblock-students'])->only(['unblockStudent']);
        // $this->middleware(['auth', 'permission:bulk-block-students'])->only(['bulkBlock', 'processBulkBlock']);
        $this->middleware(['auth', 'permission:manage-block-exceptions'])->only(['toggleException']);
    }

    /**
     * Display a listing of student blocks
     */
    public function index(Request $request)
    {
        $query = StudentBlock::with(['student', 'blockedBy', 'unblockedBy'])
                                ->where('is_active', true);

        // Filter by center
        if ($request->filled('center_id')) {
            $query->whereHas('student', function($q) use ($request) {
                $q->where('center_id', $request->center_id);
            });
        }

        // Filter by gender
        if ($request->filled('gender')) {
            $query->whereHas('student', function($q) use ($request) {
                $q->where('gender', $request->gender);
            });
        }

        // Filter by search term (student number or name)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('student_number', 'like', "%{$search}%")
                  ->orWhereHas('student', function($studentQuery) use ($search) {
                      $studentQuery->where('surname', 'like', "%{$search}%")
                                  ->orWhere('student_names', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            switch ($request->status) {
                case 'blocked':
                    $query->where('is_active', true)->where('is_exception', false);
                    break;
                case 'unblocked':
                    $query->where('is_active', false);
                    break;
                case 'exception':
                    $query->where('is_exception', true);
                    break;
            }
        }

        $studentBlocks = $query->orderBy('created_at', 'desc')->paginate(15);
        
        $centers = Center::all();
        $genders = ['Male', 'Female'];
        $subjects = Module::all();
        $academicYears = AcademicYear::all();

        return view('student-blocks.index', compact('studentBlocks', 'centers', 'genders', 'subjects', 'academicYears'));
    }

    /**
     * Show the form for creating a new student block
     */
    public function create()
    {
        return view('student-blocks.create');
    }

    /**
     * Store a newly created student block
     */
    public function store(Request $request)
    {
        // Debug output
        \Log::info('StudentBlock store method called', [
            'request_data' => $request->all(),
            'user_id' => Auth::id()
        ]);

        $request->validate([
            'student_numbers' => 'required|string',
            'reason' => 'required|string|max:1000',
            'block_amount' => 'nullable|numeric|min:0'
        ]);

        $studentNumbers = array_map('trim', explode(',', $request->student_numbers));
        $batchNumber = StudentBlock::generateBatchNumber();
        $blockedCount = 0;
        $errors = [];

        DB::beginTransaction();
        try {
            foreach ($studentNumbers as $studentNumber) {
                if (empty($studentNumber)) continue;

                $student = Student::where('student_number', $studentNumber)
                                ->first();

                if (!$student) {
                    $errors[] = "Student number {$studentNumber} not found";
                    continue;
                }

                // Check if student is already blocked
                $existingBlock = StudentBlock::where('student_id', $student->id)
                                           ->where('is_active', true)
                                           ->first();

                if ($existingBlock) {
                    $errors[] = "Student {$studentNumber} is already blocked";
                    continue;
                }

                StudentBlock::create([
                    'student_id' => $student->id,
                    'student_number' => $student->student_number,
                    'reason' => $request->reason,
                    'block_amount' => $request->block_amount ?? 0,
                    'batch_number' => $batchNumber,
                    'blocked_by' => Auth::id(),
                    'blocked_at' => Carbon::now(),
                    'is_active' => true
                ]);

                $blockedCount++;
            }

            DB::commit();

            $message = "Successfully blocked {$blockedCount} student(s)";
            if (!empty($errors)) {
                $message .= ". Errors: " . implode(', ', $errors);
            }

            \Log::info('StudentBlock store success', [
                'blocked_count' => $blockedCount,
                'errors' => $errors
            ]);

            return redirect()->route('student-blocks.index')->with('success', $message);

        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('StudentBlock store error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->with('error', 'An error occurred while blocking students: ' . $e->getMessage());
        }
    }

    /**
     * Show bulk block form
     */
    public function bulkBlock()
    {
        $centers = \App\Center::all();
        $genders = Student::distinct()->pluck('gender')->filter();

        return view('student-blocks.bulk-block', compact(
            'centers', 
            'genders'
        ));
    }

    /**
     * Process bulk block
     */
    public function processBulkBlock(Request $request)
    {
        $request->validate([
            'center_id' => 'required|exists:centers,id',
            'gender' => 'nullable|string',
            'reason' => 'required|string|max:1000',
            'block_amount' => 'nullable|numeric|min:0'
        ]);

        $query = Student::where('center_id', $request->center_id);
        
        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }

        // Exclude bursary-linked students if requested
        if ($request->has('exclude_bursary')) {
            // Add logic to exclude bursary students if needed
        }

        $students = $query->get();
        $batchNumber = StudentBlock::generateBatchNumber();
        $blockedCount = 0;

        DB::beginTransaction();
        try {
            foreach ($students as $student) {
                // Check if student is already blocked
                $existingBlock = StudentBlock::where('student_id', $student->id)
                                           ->where('is_active', true)
                                           ->first();

                if ($existingBlock) {
                    continue;
                }

                StudentBlock::create([
                    'student_id' => $student->id,
                    'student_number' => $student->student_number,
                    'reason' => $request->reason,
                    'block_amount' => $request->block_amount ?? 0,
                    'batch_number' => $batchNumber,
                    'blocked_by' => Auth::id(),
                    'blocked_at' => Carbon::now(),
                    'is_active' => true
                ]);

                $blockedCount++;
            }

            DB::commit();

            return redirect()->route('student-blocks.index')
                           ->with('success', "Successfully blocked {$blockedCount} students in batch {$batchNumber}");

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'An error occurred during bulk blocking: ' . $e->getMessage());
        }
    }

    /**
     * Revoke (delete) a student block
     */
    public function unblockStudent($id)
    {
        $studentBlock = StudentBlock::findOrFail($id);
        $studentNumber = $studentBlock->student_number;
        
        $studentBlock->delete();

        return redirect()->route('student-blocks.index')->with('success', "Student {$studentNumber} block revoked and removed from list");
    }

    /**
     * Toggle exception status
     */
    public function toggleException($id)
    {
        $studentBlock = StudentBlock::findOrFail($id);

        $studentBlock->update([
            'is_exception' => !$studentBlock->is_exception
        ]);

        $status = $studentBlock->is_exception ? 'added to' : 'removed from';
        return redirect()->back()->with('success', "Student {$status} block exceptions");
    }

    /**
     * Remove the specified resource from storage
     */
    public function destroy($id)
    {
        $studentBlock = StudentBlock::findOrFail($id);
        $studentBlock->delete();

        return redirect()->route('student-blocks.index')->with('success', 'Student block record deleted successfully');
    }

    /**
     * Process bulk unblock request
     */
    public function processBulkUnblock(Request $request)
    {
        \Log::info('Bulk unblock request received', ['request_data' => $request->all(), 'user_id' => Auth::id()]);

        try {
            $request->validate([
                'revoke_option' => 'required|in:student_numbers,batch_number',
                'student_numbers' => 'required_if:revoke_option,student_numbers|string|nullable',
                'batch_number' => 'required_if:revoke_option,batch_number|string|nullable'
            ]);

            $unblockedCount = 0;
            $errors = [];

            DB::beginTransaction();

            if ($request->revoke_option === 'student_numbers') {
                $studentNumbers = array_map('trim', explode(',', $request->student_numbers));
                \Log::info('Processing student numbers', ['numbers' => $studentNumbers]);
                
                foreach ($studentNumbers as $studentNumber) {
                    if (empty($studentNumber)) continue;

                    $blocks = StudentBlock::whereHas('student', function($q) use ($studentNumber) {
                        $q->where('student_number', $studentNumber);
                    })->get();

                    \Log::info('Found blocks for student', ['student_number' => $studentNumber, 'blocks_count' => $blocks->count()]);

                    if ($blocks->isEmpty()) {
                        $errors[] = "No blocks found for student number {$studentNumber}";
                        continue;
                    }

                    foreach ($blocks as $block) {
                        \Log::info('Deleting block', ['block_id' => $block->id, 'student_number' => $studentNumber]);
                        $block->delete();
                        $unblockedCount++;
                    }
                }
            } else {
                // Unblock by batch number
                \Log::info('Processing batch number', ['batch_number' => $request->batch_number]);
                $blocks = StudentBlock::where('batch_number', $request->batch_number)->get();

                \Log::info('Found blocks for batch', ['batch_number' => $request->batch_number, 'blocks_count' => $blocks->count()]);

                if ($blocks->isEmpty()) {
                    $errors[] = "No blocks found for batch number {$request->batch_number}";
                } else {
                    foreach ($blocks as $block) {
                        \Log::info('Deleting block', ['block_id' => $block->id, 'batch_number' => $request->batch_number]);
                        $block->delete();
                        $unblockedCount++;
                    }
                }
            }

            DB::commit();
            \Log::info('Bulk unblock completed', ['unblocked_count' => $unblockedCount, 'errors' => $errors]);

            $message = "Successfully unblocked {$unblockedCount} student(s).";
            if (!empty($errors)) {
                $message .= " Errors: " . implode(', ', $errors);
            }

            return redirect()->route('student-blocks.index')->with('success', $message);

        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Bulk unblock error', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'An error occurred while unblocking students: ' . $e->getMessage());
        }
    }
}
