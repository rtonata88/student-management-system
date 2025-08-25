@extends('layouts.print')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Academic Records</li>
        <li class="breadcrumb-item"><a href="{{ route('academic-records.index') }}">Students</a></li>
        <li class="breadcrumb-item active">{{$student->student_names}} {{$student->surname}}</li>
        <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 col-xs-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <table style="width: 100%;">
                        <tr>
                            <td>
                                <h3>{{$company->company_name}}</h3><br>
                                {{$company->address1}} <br>
                                @if($company->address2){{$company->address2}} <br>@endif
                                @if($company->address3){{$company->address3}} <br>@endif
                                @if($company->address4){{$company->address4}} <br>@endif
                                @if($company->contact_number)<strong>C: </strong> {{$company->contact_number}} <br>@endif
                                @if($company->fax)<strong>F: </strong>{{$company->fax}} <br>@endif
                                @if($company->email)<strong>E: </strong>{{$company->email}} <br>@endif
                            </td>
                            <td width="200px; margin-right:20px;">
                                @if($company->logo)
                                    <img src="{{asset('storage/' . $company->logo)}}" class="img-fluid" />
                                @else
                                    <img src="{{asset('assets/Logo.png')}}" class="img-fluid" />
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table-sm" style="width:100%">
                            <tr>
                                <th style="width: 150px">Student Number</th>
                                <td>{{$student->student_number2}}</td>
                            </tr>
                            <tr>
                                <th style="width: 150px">Student Names</th>
                                <td>{{$student->student_names}}</td>
                            </tr>
                            <tr>
                                <th style="width: 150px">Surname</th>
                                <td>{{$student->surname}}</td>
                            </tr>
                            <tr>
                                <th style="width: 100px">Date of Birth</th>
                                <td>{{$student->date_of_birth}}</td>
                            </tr>
                            <tr>
                                <th style="width: 100px">Center</th>
                                <td>{{$student->center->center_name ?? 'N/A'}}</td>
                            </tr>
                        </table>
                    </div>

                    <div class="col-md-6">
                        <strong>Academic Summary: </strong>
                        <table class="table table-responsive-sm table-bordered table-striped table-sm" style="width:100%">
                            <tbody>
                                <tr>
                                    <th>Test Records</th>
                                    <td>{{ $testMarks->count() }}</td>
                                </tr>
                                <tr>
                                    <th>Exam Records</th>
                                    <td>{{ $examMarks->count() }}</td>
                                </tr>
                                <tr>
                                    <th>Registered Modules</th>
                                    <td>{{ $student->registered_modules ? $student->registered_modules->count() : 0 }}</td>
                                </tr>
                                <tr>
                                    <th>Pass Rate</th>
                                    <td>
                                        @php
                                            $totalMarks = $testMarks->count() + $examMarks->count();
                                            $passedMarks = $testMarks->where('percentage', '>=', 50)->count() + $examMarks->where('percentage', '>=', 50)->count();
                                            $passRate = $totalMarks > 0 ? round(($passedMarks / $totalMarks) * 100) : 0;
                                        @endphp
                                        {{ $passRate }}%
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <hr>
                <!-- Test Marks Section -->
                @if($testMarks->count() > 0)
                <strong>Test Marks:</strong>
                <table class="table table-responsive-sm table-bordered table-sm" style="width:100%">
                    <thead>
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
                            <td>{{ $testMark->marks_obtained ?? 'N/A' }}</td>
                            <td>{{ $testMark->total_marks ?? 'N/A' }}</td>
                            <td>
                                @if($testMark->marks_obtained !== null && $testMark->total_marks > 0)
                                    {{ $testMark->percentage }}%
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>{{ $testMark->remarks ?? '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <br>
                @endif

                <!-- Exam Marks Section -->
                @if($examMarks->count() > 0)
                <strong>Exam Marks:</strong>
                <table class="table table-responsive-sm table-bordered table-sm" style="width:100%">
                    <thead>
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
                            <td>{{ $examMark->marks_obtained ?? 'N/A' }}</td>
                            <td>{{ $examMark->total_marks ?? 'N/A' }}</td>
                            <td>
                                @if($examMark->marks_obtained !== null && $examMark->total_marks > 0)
                                    {{ $examMark->percentage }}%
                                @else
                                    N/A
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
