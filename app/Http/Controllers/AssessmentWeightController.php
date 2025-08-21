<?php

namespace App\Http\Controllers;

use App\AssessmentWeight;
use App\Module;
use App\AcademicYear;
use App\AssessmentType;
use Illuminate\Http\Request;
use Auth;
use Session;

class AssessmentWeightController extends Controller
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
        if (!Auth::user()->hasPermission('assessment-weights')) {
            abort(403, 'Unauthorized access to assessment weights.');
        }
        
        $search = $request->get('search');
        
        $assessmentWeights = AssessmentWeight::with(['module', 'academicYear', 'assessmentType'])
            ->when($search, function ($query, $search) {
                return $query->whereHas('module', function ($q) use ($search) {
                    $q->where('subject_name', 'like', "%{$search}%")
                      ->orWhere('subject_code', 'like', "%{$search}%");
                })
                ->orWhereHas('academicYear', function ($q) use ($search) {
                    $q->where('academic_year', 'like', "%{$search}%");
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('Assessments.AssessmentWeights.Index', compact('assessmentWeights', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Auth::user()->hasPermission('add-assessment-weights')) {
            abort(403, 'Unauthorized access to create assessment weights.');
        }
        
        $modules = Module::orderBy('subject_name')->get();
        $academicYears = AcademicYear::orderBy('academic_year')->get();
        $assessmentTypes = AssessmentType::where('active', true)->orderBy('name')->get();
        
        return view('Assessments.AssessmentWeights.Create', compact('modules', 'academicYears', 'assessmentTypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!Auth::user()->hasPermission('add-assessment-weights')) {
            abort(403, 'Unauthorized access to create assessment weights.');
        }
        
        $request->validate([
            'module_id' => 'required|exists:modules,id',
            'academic_year_id' => 'required|exists:academic_years,id',
            'assessment_weights' => 'required|array|min:1',
            'assessment_weights.*.assessment_type_id' => 'required|exists:assessment_types,id',
            'assessment_weights.*.description' => 'nullable|string|max:255',
            'assessment_weights.*.weight' => 'required|numeric|min:0|max:100'
        ]);

        // Validate that weights add up to 100
        $totalWeight = array_sum(array_column($request->assessment_weights, 'weight'));
        if ($totalWeight != 100) {
            return back()->withErrors(['assessment_weights' => 'The total weight must equal 100%'])->withInput();
        }

        // Delete existing weights for this module and academic year
        AssessmentWeight::where('module_id', $request->module_id)
            ->where('academic_year_id', $request->academic_year_id)
            ->delete();

        // Create new weights
        foreach ($request->assessment_weights as $weight) {
            AssessmentWeight::create([
                'module_id' => $request->module_id,
                'academic_year_id' => $request->academic_year_id,
                'assessment_type_id' => $weight['assessment_type_id'],
                'description' => $weight['description'],
                'weight' => $weight['weight']
            ]);
        }

        Session::flash('success', 'Assessment weights created successfully');
        return redirect()->route('assessment-weights.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $moduleId
     * @param  int  $academicYearId
     * @return \Illuminate\Http\Response
     */
    public function edit($moduleId, $academicYearId)
    {
        if (!Auth::user()->hasPermission('edit-assessment-weights')) {
            abort(403, 'Unauthorized access to edit assessment weights.');
        }
        
        $module = Module::findOrFail($moduleId);
        $academicYear = AcademicYear::findOrFail($academicYearId);
        $assessmentWeights = AssessmentWeight::with('assessmentType')
            ->where('module_id', $moduleId)
            ->where('academic_year_id', $academicYearId)
            ->get();
        
        $assessmentTypes = AssessmentType::where('active', true)->orderBy('name')->get();
        
        return view('Assessments.AssessmentWeights.Edit', compact('module', 'academicYear', 'assessmentWeights', 'assessmentTypes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $moduleId
     * @param  int  $academicYearId
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $moduleId, $academicYearId)
    {
        if (!Auth::user()->hasPermission('edit-assessment-weights')) {
            abort(403, 'Unauthorized access to update assessment weights.');
        }
        
        $request->validate([
            'assessment_weights' => 'required|array|min:1',
            'assessment_weights.*.assessment_type_id' => 'required|exists:assessment_types,id',
            'assessment_weights.*.description' => 'nullable|string|max:255',
            'assessment_weights.*.weight' => 'required|numeric|min:0|max:100'
        ]);

        // Validate that weights add up to 100
        $totalWeight = array_sum(array_column($request->assessment_weights, 'weight'));
        if ($totalWeight != 100) {
            return back()->withErrors(['assessment_weights' => 'The total weight must equal 100%'])->withInput();
        }

        // Delete existing weights
        AssessmentWeight::where('module_id', $moduleId)
            ->where('academic_year_id', $academicYearId)
            ->delete();

        // Create updated weights
        foreach ($request->assessment_weights as $weight) {
            AssessmentWeight::create([
                'module_id' => $moduleId,
                'academic_year_id' => $academicYearId,
                'assessment_type_id' => $weight['assessment_type_id'],
                'description' => $weight['description'],
                'weight' => $weight['weight']
            ]);
        }

        Session::flash('success', 'Assessment weights updated successfully');
        return redirect()->route('assessment-weights.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $moduleId
     * @param  int  $academicYearId
     * @return \Illuminate\Http\Response
     */
    public function destroy($moduleId, $academicYearId)
    {
        if (!Auth::user()->hasPermission('delete-assessment-weights')) {
            abort(403, 'Unauthorized access to delete assessment weights.');
        }
        
        AssessmentWeight::where('module_id', $moduleId)
            ->where('academic_year_id', $academicYearId)
            ->delete();

        Session::flash('success', 'Assessment weights deleted successfully');
        return redirect()->route('assessment-weights.index');
    }
}
