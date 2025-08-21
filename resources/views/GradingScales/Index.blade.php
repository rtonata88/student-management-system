@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                        <h4 class="card-title mb-0">
                            <i class="fa fa-chart-line"></i> Grading Scales Management
                        </h4>
                        <div class="card-header-actions">
                            @if(Auth::user()->hasPermission('add-grading-scales'))
                                <a href="{{ route('grading-scales.create') }}" class="btn btn-sm" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none;">
                                    <i class="fa fa-plus"></i> Add New
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Search Filters -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <form method="GET" action="{{ route('grading-scales.index') }}">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="module_id" class="form-control-label">Module <span class="text-danger">*</span></label>
                                                <select name="module_id" id="module_id" class="form-control">
                                                    <option value="">Select module</option>
                                                    @foreach($modules as $module)
                                                        <option value="{{ $module->id }}" {{ $moduleId == $module->id ? 'selected' : '' }}>
                                                            {{ $module->subject_name }} ({{ $module->subject_code }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="academic_year_id" class="form-control-label">Academic Year <span class="text-danger">*</span></label>
                                                <select name="academic_year_id" id="academic_year_id" class="form-control">
                                                    <option value="">Select academic year</option>
                                                    @foreach($academicYears as $year)
                                                        <option value="{{ $year->id }}" {{ $academicYearId == $year->id ? 'selected' : '' }}>
                                                            {{ $year->academic_year }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="examination_id" class="form-control-label">Exam Type <span class="text-danger">*</span></label>
                                                <select name="examination_id" id="examination_id" class="form-control">
                                                    <option value="">Select Exam Type</option>
                                                    @foreach($examinations as $exam)
                                                        <option value="{{ $exam->id }}" {{ $examinationId == $exam->id ? 'selected' : '' }}>
                                                            {{ $exam->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>&nbsp;</label><br>
                                                <button type="submit" class="btn" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; margin-right: 10px;">
                                                    <i class="fa fa-search"></i> Search
                                                </button>
                                                <a href="{{ route('grading-scales.index') }}" class="btn btn-secondary">
                                                    <i class="fa fa-refresh"></i> Reset
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Results Table -->
                        <div class="table-responsive">
                            <table class="table table-striped table-hover" style="border-radius: 8px; overflow: hidden; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                                <thead style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                                    <tr>
                                        <th style="font-weight: 600; color: white; text-transform: uppercase; font-size: 12px; letter-spacing: 0.5px;">MODULE NAME</th>
                                        <th style="font-weight: 600; color: white; text-transform: uppercase; font-size: 12px; letter-spacing: 0.5px;">MODULE CODE</th>
                                        <th style="font-weight: 600; color: white; text-transform: uppercase; font-size: 12px; letter-spacing: 0.5px;">ACADEMIC YEAR</th>
                                        <th style="font-weight: 600; color: white; text-transform: uppercase; font-size: 12px; letter-spacing: 0.5px;">EXAM TYPE</th>
                                        <th style="font-weight: 600; color: white; text-transform: uppercase; font-size: 12px; letter-spacing: 0.5px;">MARK RANGE</th>
                                        <th style="font-weight: 600; color: white; text-transform: uppercase; font-size: 12px; letter-spacing: 0.5px;">GRADE</th>
                                        <th style="font-weight: 600; color: white; text-transform: uppercase; font-size: 12px; letter-spacing: 0.5px;">RESULT</th>
                                        <th style="font-weight: 600; color: white; text-transform: uppercase; font-size: 12px; letter-spacing: 0.5px;">PASS/FAIL</th>
                                        <th style="font-weight: 600; color: white; text-transform: uppercase; font-size: 12px; letter-spacing: 0.5px;">ACTIVE</th>
                                        <th style="font-weight: 600; color: white; text-transform: uppercase; font-size: 12px; letter-spacing: 0.5px;">ACTIONS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($gradingScales as $gradingScale)
                                    <tr>
                                        <td style="padding: 16px 12px; font-weight: 500;">{{ $gradingScale->module->subject_name }}</td>
                                        <td style="padding: 16px 12px; color: #6c757d;">{{ $gradingScale->module->subject_code }}</td>
                                        <td style="padding: 16px 12px; color: #6c757d;">{{ $gradingScale->academicYear->academic_year }}</td>
                                        <td style="padding: 16px 12px; color: #6c757d;">{{ $gradingScale->examination->name }}</td>
                                        <td style="padding: 16px 12px; color: #6c757d;">{{ $gradingScale->min_mark }} - {{ $gradingScale->max_mark }}</td>
                                        <td style="padding: 16px 12px; font-weight: 600; color: #495057;">{{ $gradingScale->grade }}</td>
                                        <td style="padding: 16px 12px; color: #6c757d;">{{ $gradingScale->resultCode->name }}</td>
                                        <td style="padding: 16px 12px;">
                                            <span class="badge {{ $gradingScale->pass_fail == 'Pass' ? 'badge-success' : 'badge-danger' }}">
                                                {{ $gradingScale->pass_fail }}
                                            </span>
                                        </td>
                                        <td style="padding: 16px 12px;">
                                            <label class="c-switch c-switch-pill c-switch-success">
                                                <input type="checkbox" class="c-switch-input" {{ $gradingScale->active ? 'checked' : '' }} disabled>
                                                <span class="c-switch-slider"></span>
                                            </label>
                                        </td>
                                        <td style="padding: 16px 12px;">
                                            <div class="btn-group" role="group">
                                                @if(Auth::user()->hasPermission('edit-grading-scales'))
                                                    <a href="{{ route('grading-scales.edit', $gradingScale->id) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                @endif
                                                @if(Auth::user()->hasPermission('delete-grading-scales'))
                                                    <form action="{{ route('grading-scales.destroy', $gradingScale->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this grading scale?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="10" class="text-center" style="padding: 40px; color: #6c757d;">
                                            <i class="fas fa-chart-line fa-3x mb-3" style="opacity: 0.3;"></i>
                                            <p class="mb-0">No grading scales found. Use the filters above to search or <a href="{{ route('grading-scales.create') }}">add a new grading scale</a>.</p>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if($gradingScales->hasPages())
                            <div class="d-flex justify-content-center mt-4">
                                {{ $gradingScales->appends(request()->query())->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
