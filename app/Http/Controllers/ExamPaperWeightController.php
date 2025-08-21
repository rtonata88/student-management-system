<?php

namespace App\Http\Controllers;

use App\ExamPaperWeight;
use App\Module;
use App\AcademicYear;
use App\Examination;
use Illuminate\Http\Request;
use Auth;
use Session;

class ExamPaperWeightController extends Controller
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
    public function index(Request $request)
    {
        if (!Auth::user()->hasPermission('exam-paper-weights')) {
            abort(403, 'Unauthorized access to exam paper weights.');
        }
        
        $search = $request->get('search');
        
        $examPaperWeights = ExamPaperWeight::with(['module', 'academicYear', 'examination'])
            ->when($search, function ($query, $search) {
                return $query->whereHas('module', function ($q) use ($search) {
                    $q->where('subject_name', 'like', "%{$search}%")
                      ->orWhere('subject_code', 'like', "%{$search}%");
                })
                ->orWhereHas('academicYear', function ($q) use ($search) {
                    $q->where('academic_year', 'like', "%{$search}%");
                })
                ->orWhere('paper_name', 'like', "%{$search}%")
                ->orWhere('paper_code', 'like', "%{$search}%");
            })
            ->join('modules', 'exam_paper_weights.module_id', '=', 'modules.id')
            ->join('examinations', 'exam_paper_weights.examination_id', '=', 'examinations.id')
            ->orderBy('modules.subject_name')
            ->orderBy('examinations.name')
            ->orderBy('exam_paper_weights.paper_name')
            ->select('exam_paper_weights.*')
            ->get();

        return view('Assessments.ExamPaperWeights.Index', compact('examPaperWeights', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Auth::user()->hasPermission('add-exam-paper-weights')) {
            abort(403, 'Unauthorized access to create exam paper weights.');
        }
        
        $modules = Module::orderBy('subject_name')->get();
        $academicYears = AcademicYear::orderBy('academic_year')->get();
        $examinations = Examination::where('active', 1)->get();
        
        return view('Assessments.ExamPaperWeights.Create', compact('modules', 'academicYears', 'examinations'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!Auth::user()->hasPermission('add-exam-paper-weights')) {
            abort(403, 'Unauthorized access to create exam paper weights.');
        }
        
        $request->validate([
            'module_id' => 'required|exists:modules,id',
            'academic_year_id' => 'required|exists:academic_years,id',
            'examination_id' => 'required|exists:examinations,id',
            'exam_papers' => 'required|array|min:1',
            'exam_papers.*.paper_name' => 'required|string|max:255',
            'exam_papers.*.paper_code' => 'nullable|string|max:50',
            'exam_papers.*.weight' => 'required|numeric|min:0|max:100',
            'exam_papers.*.description' => 'nullable|string|max:500'
        ]);

        // Validate that weights add up to 100
        $totalWeight = array_sum(array_column($request->exam_papers, 'weight'));
        if ($totalWeight != 100) {
            return back()->withErrors(['exam_papers' => 'The total weight must equal 100%'])->withInput();
        }

        // Delete existing papers for this module, academic year, and exam type
        ExamPaperWeight::where('module_id', $request->module_id)
            ->where('academic_year_id', $request->academic_year_id)
            ->where('examination_id', $request->examination_id)
            ->delete();

        // Create new papers
        foreach ($request->exam_papers as $paper) {
            ExamPaperWeight::create([
                'module_id' => $request->module_id,
                'academic_year_id' => $request->academic_year_id,
                'examination_id' => $request->examination_id,
                'paper_name' => $paper['paper_name'],
                'paper_code' => $paper['paper_code'],
                'weight' => $paper['weight'],
                'description' => $paper['description']
            ]);
        }

        Session::flash('success', 'Exam paper weights created successfully');
        return redirect()->route('exam-paper-weights.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $moduleId
     * @param  int  $academicYearId
     * @param  int  $assessmentTypeId
     * @return \Illuminate\Http\Response
     */
    public function edit($moduleId, $academicYearId, $assessmentTypeId)
    {
        if (!Auth::user()->hasPermission('edit-exam-paper-weights')) {
            abort(403, 'Unauthorized access to edit exam paper weights.');
        }
        
        $modules = Module::orderBy('subject_name')->get();
        $academicYears = AcademicYear::orderBy('academic_year')->get();
        $module = Module::findOrFail($moduleId);
        $academicYear = AcademicYear::findOrFail($academicYearId);
        $examination = Examination::findOrFail($assessmentTypeId);
        $examPaperWeights = ExamPaperWeight::where('module_id', $moduleId)
            ->where('academic_year_id', $academicYearId)
            ->where('examination_id', $assessmentTypeId)
            ->get();
        $examinations = Examination::where('active', 1)->get();
        
        return view('Assessments.ExamPaperWeights.Edit', compact('examPaperWeights', 'modules', 'academicYears', 'examinations', 'moduleId', 'academicYearId', 'assessmentTypeId'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $moduleId
     * @param  int  $academicYearId
     * @param  int  $assessmentTypeId
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $moduleId, $academicYearId, $assessmentTypeId)
    {
        if (!Auth::user()->hasPermission('edit-exam-paper-weights')) {
            abort(403, 'Unauthorized access to update exam paper weights.');
        }
        
        $request->validate([
            'exam_papers' => 'required|array|min:1',
            'exam_papers.*.paper_name' => 'required|string|max:255',
            'exam_papers.*.paper_code' => 'nullable|string|max:50',
            'exam_papers.*.weight' => 'required|numeric|min:0|max:100',
            'exam_papers.*.description' => 'nullable|string|max:500'
        ]);

        // Validate that weights add up to 100
        $totalWeight = array_sum(array_column($request->exam_papers, 'weight'));
        if ($totalWeight != 100) {
            return back()->withErrors(['exam_papers' => 'The total weight must equal 100%'])->withInput();
        }

        // Delete existing papers
        ExamPaperWeight::where('module_id', $moduleId)
            ->where('academic_year_id', $academicYearId)
            ->where('examination_id', $assessmentTypeId)
            ->delete();

        // Create updated papers
        foreach ($request->exam_papers as $paper) {
            ExamPaperWeight::create([
                'module_id' => $moduleId,
                'academic_year_id' => $academicYearId,
                'examination_id' => $assessmentTypeId,
                'paper_name' => $paper['paper_name'],
                'paper_code' => $paper['paper_code'],
                'weight' => $paper['weight'],
                'description' => $paper['description']
            ]);
        }

        Session::flash('success', 'Exam paper weights updated successfully');
        return redirect()->route('exam-paper-weights.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $moduleId
     * @param  int  $academicYearId
     * @param  int  $assessmentTypeId
     * @return \Illuminate\Http\Response
     */
    public function destroy($moduleId, $academicYearId, $assessmentTypeId)
    {
        if (!Auth::user()->hasPermission('delete-exam-paper-weights')) {
            abort(403, 'Unauthorized access to delete exam paper weights.');
        }
        
        ExamPaperWeight::where('module_id', $moduleId)
            ->where('academic_year_id', $academicYearId)
            ->where('examination_id', $assessmentTypeId)
            ->delete();

        Session::flash('success', 'Exam paper weights deleted successfully');
        return redirect()->route('exam-paper-weights.index');
    }
}
