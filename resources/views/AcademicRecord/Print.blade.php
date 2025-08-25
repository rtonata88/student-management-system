<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Academic Record - {{ $student->student_names }} {{ $student->surname }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            font-size: 12px;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        .company-logo {
            max-height: 60px;
            margin-bottom: 10px;
        }
        .company-name {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin: 10px 0;
        }
        .company-info {
            color: #666;
            font-size: 11px;
        }
        .document-title {
            font-size: 20px;
            font-weight: bold;
            text-align: center;
            margin: 20px 0;
            color: #333;
            text-transform: uppercase;
        }
        .student-info {
            margin-bottom: 30px;
        }
        .student-info table {
            width: 100%;
            border-collapse: collapse;
        }
        .student-info td {
            padding: 8px;
            border: 1px solid #ddd;
            vertical-align: top;
        }
        .student-info .label {
            font-weight: bold;
            background-color: #f5f5f5;
            width: 25%;
        }
        .photo-cell {
            text-align: center;
            width: 120px;
            padding: 10px;
        }
        .student-photo {
            max-width: 100px;
            max-height: 120px;
            border: 2px solid #333;
        }
        .section-title {
            font-size: 16px;
            font-weight: bold;
            margin: 25px 0 15px 0;
            padding: 8px;
            background-color: #f0f0f0;
            border-left: 4px solid #333;
        }
        .marks-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .marks-table th,
        .marks-table td {
            border: 1px solid #333;
            padding: 6px;
            text-align: center;
        }
        .marks-table th {
            background-color: #333;
            color: white;
            font-weight: bold;
            font-size: 11px;
        }
        .marks-table td {
            font-size: 10px;
        }
        .marks-table .text-left {
            text-align: left;
        }
        .pass {
            background-color: #d4edda;
            color: #155724;
            font-weight: bold;
        }
        .fail {
            background-color: #f8d7da;
            color: #721c24;
            font-weight: bold;
        }
        .summary-section {
            margin-top: 30px;
            page-break-inside: avoid;
        }
        .summary-grid {
            display: table;
            width: 100%;
            border-collapse: collapse;
        }
        .summary-item {
            display: table-cell;
            width: 25%;
            text-align: center;
            border: 1px solid #333;
            padding: 15px;
            vertical-align: middle;
        }
        .summary-number {
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }
        .summary-label {
            font-size: 11px;
            color: #666;
            margin-top: 5px;
        }
        .footer {
            margin-top: 40px;
            border-top: 1px solid #333;
            padding-top: 20px;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
        .no-records {
            text-align: center;
            padding: 40px;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            margin: 20px 0;
        }
        @media print {
            body { margin: 0; }
            .page-break { page-break-before: always; }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        @if($company && $company->logo)
            <img src="{{ public_path('storage/' . $company->logo) }}" alt="Company Logo" class="company-logo">
        @endif
        @if($company)
            <div class="company-name">{{ $company->company_name }}</div>
            <div class="company-info">
                {{ $company->address1 }}@if($company->address2), {{ $company->address2 }}@endif<br>
                @if($company->contact_number)Tel: {{ $company->contact_number }}@endif
                @if($company->email) | Email: {{ $company->email }}@endif
            </div>
        @endif
    </div>

    <div class="document-title">Academic Record</div>

    <!-- Student Information -->
    <div class="student-info">
        <table>
            <tr>
                <td class="label">Student Number:</td>
                <td>{{ $student->student_number }}</td>
                <td class="label">Date of Birth:</td>
                <td>{{ $student->date_of_birth ? \Carbon\Carbon::parse($student->date_of_birth)->format('d M Y') : 'N/A' }}</td>
                <td rowspan="4" class="photo-cell">
                    @if($student->photo)
                        <img src="{{ public_path('storage/' . $student->photo) }}" alt="Student Photo" class="student-photo">
                    @else
                        <div style="width: 100px; height: 120px; border: 2px solid #333; display: flex; align-items: center; justify-content: center; background-color: #f5f5f5;">
                            No Photo
                        </div>
                    @endif
                </td>
            </tr>
            <tr>
                <td class="label">Full Names:</td>
                <td>{{ $student->student_names }} {{ $student->surname }}</td>
                <td class="label">Gender:</td>
                <td>{{ $student->gender->gender ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="label">Center:</td>
                <td>{{ $student->center->center_name ?? 'N/A' }}</td>
                <td class="label">Generated:</td>
                <td>{{ \Carbon\Carbon::now()->format('d M Y H:i') }}</td>
            </tr>
            <tr>
                <td class="label">Registered Modules:</td>
                <td>{{ $student->registered_modules->count() }}</td>
                <td class="label">Total Records:</td>
                <td>{{ $testMarks->count() + $examMarks->count() }}</td>
            </tr>
        </table>
    </div>

    <!-- Test Marks Section -->
    @if($testMarks->count() > 0)
        <div class="section-title">Test Marks</div>
        <table class="marks-table">
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
                    <td class="text-left">{{ $testMark->module->module_name ?? 'N/A' }}</td>
                    <td>{{ $testMark->assessmentType->assessment_type ?? 'N/A' }}</td>
                    <td>{{ $testMark->marks_obtained ?? 'N/A' }}</td>
                    <td>{{ $testMark->total_marks ?? 'N/A' }}</td>
                    <td class="{{ $testMark->percentage >= 50 ? 'pass' : 'fail' }}">
                        @if($testMark->marks_obtained !== null && $testMark->total_marks > 0)
                            {{ $testMark->percentage }}%
                        @else
                            N/A
                        @endif
                    </td>
                    <td class="text-left">{{ $testMark->remarks ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <!-- Exam Marks Section -->
    @if($examMarks->count() > 0)
        <div class="section-title">Exam Marks</div>
        <table class="marks-table">
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
                    <td class="text-left">{{ $examMark->module->module_name ?? 'N/A' }}</td>
                    <td>{{ $examMark->examType->assessment_type ?? 'N/A' }}</td>
                    <td class="text-left">{{ $examMark->examPaper->paper_name ?? 'N/A' }}</td>
                    <td>{{ $examMark->marks_obtained ?? 'N/A' }}</td>
                    <td>{{ $examMark->total_marks ?? 'N/A' }}</td>
                    <td class="{{ $examMark->percentage >= 50 ? 'pass' : 'fail' }}">
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

    <!-- Academic Summary -->
    <div class="summary-section">
        <div class="section-title">Academic Summary</div>
        <div class="summary-grid">
            <div class="summary-item">
                <div class="summary-number">{{ $testMarks->count() }}</div>
                <div class="summary-label">Test Records</div>
            </div>
            <div class="summary-item">
                <div class="summary-number">{{ $examMarks->count() }}</div>
                <div class="summary-label">Exam Records</div>
            </div>
            <div class="summary-item">
                <div class="summary-number">{{ $student->registered_modules->count() }}</div>
                <div class="summary-label">Registered Modules</div>
            </div>
            <div class="summary-item">
                <div class="summary-number">
                    @php
                        $totalRecords = $testMarks->count() + $examMarks->count();
                        $passedRecords = $testMarks->where('percentage', '>=', 50)->count() + $examMarks->where('percentage', '>=', 50)->count();
                        $passRate = $totalRecords > 0 ? round(($passedRecords / $totalRecords) * 100) : 0;
                    @endphp
                    {{ $passRate }}%
                </div>
                <div class="summary-label">Pass Rate</div>
            </div>
        </div>
    </div>

    @if($testMarks->count() == 0 && $examMarks->count() == 0)
        <div class="no-records">
            <strong>No academic records found for this student.</strong><br>
            The student may not have any test marks or exam marks recorded in the system.
        </div>
    @endif

    <!-- Footer -->
    <div class="footer">
        <p>This is an official academic record generated on {{ \Carbon\Carbon::now()->format('d M Y \a\t H:i') }}</p>
        <p>{{ $company->company_name ?? 'Institution Name' }} - Academic Records System</p>
    </div>
</body>
</html>
