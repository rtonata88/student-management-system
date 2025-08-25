@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                    <div class="row">
                        <div class="col-md-8">
                            <h4 class="card-title mb-0">
                                <i class="fa fa-graduation-cap"></i> Academic Record
                            </h4>
                        </div>
                        <div class="col-md-4 text-right">
                            @can('download-academic-records')
                                <a href="{{ route('academic-records.download', $student->id) }}" class="btn btn-sm" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                                    <i class="fa fa-download"></i> Download PDF
                                </a>
                            @endcan
                            @can('print-academic-records')
                                <a href="{{ route('academic-records.print', $student->id) }}" target="_blank" class="btn btn-sm ml-2" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                                    <i class="fa fa-print"></i> Print
                                </a>
                            @endcan
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Company Header -->
                    @if($company)
                        <div class="text-center mb-4">
                            @if($company->logo)
                                <img src="{{ asset('storage/' . $company->logo) }}" alt="Company Logo" style="max-height: 80px;">
                            @endif
                            <h3 style="color: #333; margin: 10px 0;">{{ $company->company_name }}</h3>
                            <p style="color: #666; margin: 0;">
                                {{ $company->address1 }}@if($company->address2), {{ $company->address2 }}@endif<br>
                                @if($company->contact_number)Tel: {{ $company->contact_number }}@endif
                                @if($company->email) | Email: {{ $company->email }}@endif
                            </p>
                            <hr style="border-top: 2px solid #667eea; margin: 20px 0;">
                        </div>
                    @endif

                    <!-- Student Information -->
                    <div class="row mb-4">
                        <div class="col-md-8">
                            <h5 style="color: #333; border-bottom: 2px solid #667eea; padding-bottom: 10px;">
                                <i class="fa fa-user"></i> Student Information
                            </h5>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <p><strong>Student Number:</strong> {{ $student->student_number }}</p>
                                    <p><strong>Full Names:</strong> {{ $student->student_names }} {{ $student->surname }}</p>
                                    <p><strong>Center:</strong> {{ $student->center->center_name ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Date of Birth:</strong> {{ $student->date_of_birth ? \Carbon\Carbon::parse($student->date_of_birth)->format('d M Y') : 'N/A' }}</p>
                                    <p><strong>Gender:</strong> {{ $student->gender->gender ?? 'N/A' }}</p>
                                    <p><strong>Generated:</strong> {{ \Carbon\Carbon::now()->format('d M Y H:i') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-center">
                            @if($student->photo)
                                <img src="{{ asset('storage/' . $student->photo) }}" 
                                     alt="Student Photo" 
                                     class="img-fluid rounded" 
                                     style="max-width: 150px; max-height: 180px; border: 3px solid #667eea;">
                            @else
                                <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                     style="width: 150px; height: 180px; border: 3px solid #667eea; margin: 0 auto;">
                                    <i class="fa fa-user fa-3x text-muted"></i>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Test Marks Section -->
                    @if($testMarks->count() > 0)
                        <div class="mb-4">
                            <h5 style="color: #333; border-bottom: 2px solid #11998e; padding-bottom: 10px;">
                                <i class="fa fa-pencil"></i> Test Marks
                            </h5>
                            <div class="table-responsive mt-3">
                                <table class="table table-striped table-bordered">
                                    <thead style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); color: white;">
                                        <tr>
                                            <th>Academic Year</th>
                                            <th>Module</th>
                                            <th>Assessment Type</th>
                                            <th>Marks Obtained</th>
                                            <th>Total Marks</th>
                                            <th>Percentage</th>
                                            <th>Remarks</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($testMarks as $testMark)
                                        <tr>
                                            <td>{{ $testMark->academicYear->academic_year ?? 'N/A' }}</td>
                                            <td>{{ $testMark->module->subject_name ?? 'N/A' }}</td>
                                            <td>{{ $testMark->assessmentType->name ?? 'N/A' }}</td>
                                            <td class="text-center">{{ $testMark->marks_obtained ?? 'N/A' }}</td>
                                            <td class="text-center">{{ $testMark->total_marks ?? 'N/A' }}</td>
                                            <td class="text-center">
                                                @if($testMark->marks_obtained !== null && $testMark->total_marks > 0)
                                                    <span class="badge badge-{{ $testMark->percentage >= 50 ? 'success' : 'danger' }}">
                                                        {{ $testMark->percentage }}%
                                                    </span>
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td>{{ $testMark->remarks ?? '-' }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif

                    <!-- Exam Marks Section -->
                    @if($examMarks->count() > 0)
                        <div class="mb-4">
                            <h5 style="color: #333; border-bottom: 2px solid #f093fb; padding-bottom: 10px;">
                                <i class="fa fa-file-text"></i> Exam Marks
                            </h5>
                            <div class="table-responsive mt-3">
                                <table class="table table-striped table-bordered">
                                    <thead style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white;">
                                        <tr>
                                            <th>Academic Year</th>
                                            <th>Module</th>
                                            <th>Exam Type</th>
                                            <th>Exam Paper</th>
                                            <th>Marks Obtained</th>
                                            <th>Total Marks</th>
                                            <th>Percentage</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($examMarks as $examMark)
                                        <tr>
                                            <td>{{ $examMark->academicYear->academic_year ?? 'N/A' }}</td>
                                            <td>{{ $examMark->module->subject_name ?? 'N/A' }}</td>
                                            <td>{{ $examMark->examType->name ?? 'N/A' }}</td>
                                            <td>{{ $examMark->examPaper->paper_name ?? 'N/A' }}</td>
                                            <td class="text-center">{{ $examMark->marks_obtained ?? 'N/A' }}</td>
                                            <td class="text-center">{{ $examMark->total_marks ?? 'N/A' }}</td>
                                            <td class="text-center">
                                                @if($examMark->marks_obtained !== null && $examMark->total_marks > 0)
                                                    <span class="badge badge-{{ $examMark->percentage >= 50 ? 'success' : 'danger' }}">
                                                        {{ $examMark->percentage }}%
                                                    </span>
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif

                    <!-- Summary Section -->
                    <div class="mt-4">
                        <h5 style="color: #333; border-bottom: 2px solid #667eea; padding-bottom: 10px;">
                            <i class="fa fa-bar-chart"></i> Academic Summary
                        </h5>
                        <div class="row mt-3">
                            <div class="col-md-3">
                                <div class="card text-center" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); color: white;">
                                    <div class="card-body">
                                        <h4>{{ $testMarks->count() }}</h4>
                                        <p class="mb-0">Test Records</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card text-center" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white;">
                                    <div class="card-body">
                                        <h4>{{ $examMarks->count() }}</h4>
                                        <p class="mb-0">Exam Records</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card text-center" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                                    <div class="card-body">
                                        <h4>{{ $student->registered_modules->count() }}</h4>
                                        <p class="mb-0">Registered Modules</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card text-center" style="background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%); color: #333;">
                                    <div class="card-body">
                                        <h4>
                                            @php
                                                $totalRecords = $testMarks->count() + $examMarks->count();
                                                $passedRecords = $testMarks->where('percentage', '>=', 50)->count() + $examMarks->where('percentage', '>=', 50)->count();
                                                $passRate = $totalRecords > 0 ? round(($passedRecords / $totalRecords) * 100) : 0;
                                            @endphp
                                            {{ $passRate }}%
                                        </h4>
                                        <p class="mb-0">Pass Rate</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($testMarks->count() == 0 && $examMarks->count() == 0)
                        <div class="text-center mt-4">
                            <div class="alert alert-info">
                                <i class="fa fa-info-circle"></i> No academic records found for this student.
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
