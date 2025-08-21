<?php

namespace App\Http\Controllers;

use App\GradingScale;
use App\Module;
use App\AcademicYear;
use App\Examination;
use App\ResultCode;
use Illuminate\Http\Request;
use Auth;
use Session;

class GradingScaleController extends Controller
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
        if (!Auth::user()->hasPermission('grading-scales')) {
            abort(403, 'Unauthorized access to grading scales.');
        }
        
        $moduleId = $request->get('module_id');
        $academicYearId = $request->get('academic_year_id');
        $examinationId = $request->get('examination_id');
        
        $gradingScales = GradingScale::with(['module', 'academicYear', 'examination', 'resultCode'])
            ->when($moduleId, function ($query, $moduleId) {
                return $query->where('module_id', $moduleId);
            })
            ->when($academicYearId, function ($query, $academicYearId) {
                return $query->where('academic_year_id', $academicYearId);
            })
            ->when($examinationId, function ($query, $examinationId) {
                return $query->where('examination_id', $examinationId);
            })
            ->orderBy('module_id')
            ->orderBy('min_mark')
            ->paginate(10);

        // Get filter options
        $modules = Module::orderBy('subject_name')->get();
        $academicYears = AcademicYear::orderBy('academic_year')->get();
        $examinations = Examination::where('active', true)->orderBy('name')->get();

        return view('GradingScales.Index', compact('gradingScales', 'modules', 'academicYears', 'examinations', 'moduleId', 'academicYearId', 'examinationId'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Auth::user()->hasPermission('add-grading-scales')) {
            abort(403, 'Unauthorized access to create grading scales.');
        }
        
        $modules = Module::orderBy('subject_name')->get();
        $academicYears = AcademicYear::orderBy('academic_year')->get();
        $examinations = Examination::where('active', true)->orderBy('name')->get();
        $resultCodes = ResultCode::where('active', true)->orderBy('name')->get();
        
        return view('GradingScales.Create', compact('modules', 'academicYears', 'examinations', 'resultCodes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!Auth::user()->hasPermission('add-grading-scales')) {
            abort(403, 'Unauthorized access to create grading scales.');
        }
        
        $request->validate([
            'module_id' => 'required|exists:modules,id',
            'academic_year_id' => 'required|exists:academic_years,id',
            'examination_id' => 'required|exists:examinations,id',
            'grading_scales' => 'required|array|min:1',
            'grading_scales.*.min_mark' => 'required|numeric|min:0|max:100',
            'grading_scales.*.max_mark' => 'required|numeric|min:0|max:100|gte:grading_scales.*.min_mark',
            'grading_scales.*.grade' => 'required|string|max:255',
            'grading_scales.*.result_code_id' => 'required|exists:result_codes,id',
            'grading_scales.*.pass_fail' => 'required|in:Pass,Fail',
            'active' => 'boolean'
        ]);

        // Check for overlapping mark ranges within the submitted data
        $gradingScales = $request->grading_scales;
        for ($i = 0; $i < count($gradingScales); $i++) {
            for ($j = $i + 1; $j < count($gradingScales); $j++) {
                $range1 = $gradingScales[$i];
                $range2 = $gradingScales[$j];
                
                if ($this->rangesOverlap($range1['min_mark'], $range1['max_mark'], $range2['min_mark'], $range2['max_mark'])) {
                    return back()->withErrors(['grading_scales' => 'Mark ranges cannot overlap with each other.']);
                }
            }
        }

        // Check for overlapping mark ranges with existing records
        foreach ($gradingScales as $scale) {
            $overlapping = GradingScale::where('module_id', $request->module_id)
                ->where('academic_year_id', $request->academic_year_id)
                ->where('examination_id', $request->examination_id)
                ->where(function ($query) use ($scale) {
                    $query->whereBetween('min_mark', [$scale['min_mark'], $scale['max_mark']])
                          ->orWhereBetween('max_mark', [$scale['min_mark'], $scale['max_mark']])
                          ->orWhere(function ($q) use ($scale) {
                              $q->where('min_mark', '<=', $scale['min_mark'])
                                ->where('max_mark', '>=', $scale['max_mark']);
                          });
                })
                ->exists();

            if ($overlapping) {
                return back()->withErrors(['grading_scales' => 'One or more mark ranges overlap with existing grading scales.']);
            }
        }

        // Create all grading scales
        foreach ($gradingScales as $scale) {
            GradingScale::create([
                'module_id' => $request->module_id,
                'academic_year_id' => $request->academic_year_id,
                'examination_id' => $request->examination_id,
                'min_mark' => $scale['min_mark'],
                'max_mark' => $scale['max_mark'],
                'grade' => $scale['grade'],
                'result_code_id' => $scale['result_code_id'],
                'pass_fail' => $scale['pass_fail'],
                'active' => $request->has('active')
            ]);
        }

        return redirect()->route('grading-scales.index')->with('success', count($gradingScales) . ' grading scales created successfully.');
    }

    private function rangesOverlap($min1, $max1, $min2, $max2)
    {
        return !($max1 < $min2 || $max2 < $min1);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\GradingScale  $gradingScale
     * @return \Illuminate\Http\Response
     */
    public function edit(GradingScale $gradingScale)
    {
        if (!Auth::user()->hasPermission('edit-grading-scales')) {
            abort(403, 'Unauthorized access to edit grading scales.');
        }
        
        $modules = Module::orderBy('subject_name')->get();
        $academicYears = AcademicYear::orderBy('academic_year')->get();
        $examinations = Examination::orderBy('name')->get();
        $resultCodes = ResultCode::orderBy('name')->get();
        
        // Get all grading scales for the same module, academic year, and examination
        $allGradingScales = GradingScale::where('module_id', $gradingScale->module_id)
            ->where('academic_year_id', $gradingScale->academic_year_id)
            ->where('examination_id', $gradingScale->examination_id)
            ->orderBy('min_mark')
            ->get();
        
        return view('GradingScales.Edit', compact('gradingScale', 'allGradingScales', 'modules', 'academicYears', 'examinations', 'resultCodes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\GradingScale  $gradingScale
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GradingScale $gradingScale)
    {
        if (!Auth::user()->hasPermission('edit-grading-scales')) {
            abort(403, 'Unauthorized access to update grading scales.');
        }
        
        $request->validate([
            'module_id' => 'required|exists:modules,id',
            'academic_year_id' => 'required|exists:academic_years,id',
            'examination_id' => 'required|exists:examinations,id',
            'grading_scales' => 'required|array|min:1',
            'grading_scales.*.min_mark' => 'required|numeric|min:0|max:100',
            'grading_scales.*.max_mark' => 'required|numeric|min:0|max:100|gte:grading_scales.*.min_mark',
            'grading_scales.*.grade' => 'required|string|max:255',
            'grading_scales.*.result_code_id' => 'required|exists:result_codes,id',
            'grading_scales.*.pass_fail' => 'required|in:Pass,Fail',
            'active' => 'boolean'
        ]);

        // Check for overlapping mark ranges within the submitted data
        $gradingScales = $request->grading_scales;
        for ($i = 0; $i < count($gradingScales); $i++) {
            for ($j = $i + 1; $j < count($gradingScales); $j++) {
                $range1 = $gradingScales[$i];
                $range2 = $gradingScales[$j];
                
                if ($this->rangesOverlap($range1['min_mark'], $range1['max_mark'], $range2['min_mark'], $range2['max_mark'])) {
                    return back()->withErrors(['grading_scales' => 'Mark ranges cannot overlap with each other.']);
                }
            }
        }

        // Delete existing grading scales for this module/year/exam combination
        GradingScale::where('module_id', $request->module_id)
            ->where('academic_year_id', $request->academic_year_id)
            ->where('examination_id', $request->examination_id)
            ->delete();

        // Create all grading scales
        foreach ($gradingScales as $scale) {
            GradingScale::create([
                'module_id' => $request->module_id,
                'academic_year_id' => $request->academic_year_id,
                'examination_id' => $request->examination_id,
                'min_mark' => $scale['min_mark'],
                'max_mark' => $scale['max_mark'],
                'grade' => $scale['grade'],
                'result_code_id' => $scale['result_code_id'],
                'pass_fail' => $scale['pass_fail'],
                'active' => $request->has('active')
            ]);
        }

        Session::flash('success', count($gradingScales) . ' grading scales updated successfully');
        return redirect()->route('grading-scales.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\GradingScale  $gradingScale
     * @return \Illuminate\Http\Response
     */
    public function destroy(GradingScale $gradingScale)
    {
        if (!Auth::user()->hasPermission('delete-grading-scales')) {
            abort(403, 'Unauthorized access to delete grading scales.');
        }
        
        $gradingScale->delete();

        Session::flash('success', 'Grading scale deleted successfully');
        return redirect()->route('grading-scales.index');
    }
}
