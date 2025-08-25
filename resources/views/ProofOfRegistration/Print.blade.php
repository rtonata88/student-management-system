<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Proof of Registration - {{ $student->student_names }} {{ $student->surname }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            font-size: 12px;
            line-height: 1.4;
        }
        .header {
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        .header table {
            width: 100%;
            border-collapse: collapse;
        }
        .header td {
            vertical-align: top;
        }
        .company-logo {
            max-height: 60px;
            text-align: right;
        }
        .company-name {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
        }
        .company-info {
            color: #666;
            font-size: 11px;
            line-height: 1.5;
        }
        .document-title {
            font-size: 20px;
            font-weight: bold;
            text-align: center;
            margin: 20px 0;
            color: #333;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .academic-year {
            text-align: center;
            color: #666;
            margin-bottom: 30px;
            font-size: 14px;
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
        .modules-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .modules-table th,
        .modules-table td {
            border: 1px solid #333;
            padding: 6px;
            text-align: center;
        }
        .modules-table th {
            background-color: #333;
            color: white;
            font-weight: bold;
            font-size: 11px;
        }
        .modules-table td {
            font-size: 10px;
        }
        .modules-table .text-left {
            text-align: left;
        }
        .modules-table .text-right {
            text-align: right;
        }
        .total-row {
            background-color: #f8f9fa;
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
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }
        .summary-label {
            font-size: 10px;
            color: #666;
            margin-top: 5px;
        }
        .declaration {
            margin-top: 30px;
            padding: 15px;
            background-color: #f8f9fa;
            border-left: 4px solid #333;
            border-radius: 5px;
        }
        .declaration h6 {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #333;
        }
        .declaration p {
            color: #555;
            line-height: 1.6;
            margin-bottom: 10px;
        }
        .footer {
            margin-top: 40px;
            border-top: 1px solid #333;
            padding-top: 20px;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
        .status-badge {
            background-color: #28a745;
            color: white;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 9px;
        }
        .symbol-badge {
            background-color: #17a2b8;
            color: white;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 9px;
        }
        .system-badge {
            background-color: #6c757d;
            color: white;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 9px;
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
        <table>
            <tr>
                <td>
                    @if($company)
                        <div class="company-name">{{ $company->company_name }}</div>
                        <div class="company-info">
                            {{ $company->address1 }}<br>
                            @if($company->address2){{ $company->address2 }}<br>@endif
                            @if($company->address3){{ $company->address3 }}<br>@endif
                            @if($company->address4){{ $company->address4 }}<br>@endif
                            <strong>Tel:</strong> {{ $company->contact_number }}<br>
                            @if($company->fax_number)<strong>Fax:</strong> {{ $company->fax_number }}<br>@endif
                            <strong>Email:</strong> {{ $company->email }}
                        </div>
                    @endif
                </td>
                <td width="120px" class="company-logo">
                    @if($company && $company->logo)
                        <img src="{{ public_path('storage/' . $company->logo) }}" alt="Company Logo" class="company-logo">
                    @endif
                </td>
            </tr>
        </table>
    </div>

    <div class="document-title">Proof of Registration</div>
    <div class="academic-year">Academic Year: {{ $currentYear->academic_year }}</div>

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
                <td class="label">Registration Date:</td>
                <td>{{ \Carbon\Carbon::parse($registration->registration_date)->format('d M Y') }}</td>
            </tr>
            <tr>
                <td class="label">Registration Status:</td>
                <td><span class="status-badge">{{ $registration->registration_status }}</span></td>
                <td class="label">Total Modules:</td>
                <td>{{ $registered_modules->count() }}</td>
            </tr>
        </table>
    </div>

    <!-- Registered Modules -->
    @if($registered_modules->count() > 0)
        <div class="section-title">Registered Modules ({{ $registered_modules->count() }} modules)</div>
        <table class="modules-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Module Code</th>
                    <th>Module Name</th>
                    <th>Symbol</th>
                    <th>System</th>
                    <th>Amount</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($registered_modules as $index => $module)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td class="text-left">{{ $module->module->module_code ?? 'N/A' }}</td>
                    <td class="text-left">{{ $module->module->module_name ?? 'N/A' }}</td>
                    <td><span class="symbol-badge">{{ $module->subject_symbol ?? 'N/A' }}</span></td>
                    <td><span class="system-badge">{{ $module->system ?? 'N/A' }}</span></td>
                    <td class="text-right">${{ number_format($module->amount ?? 0, 2) }}</td>
                    <td><span class="status-badge">{{ $module->registration_status }}</span></td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="total-row">
                    <td colspan="5" class="text-right"><strong>Total Amount:</strong></td>
                    <td class="text-right"><strong>${{ number_format($registered_modules->sum('amount'), 2) }}</strong></td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    @endif

    <!-- Registration Summary -->
    <div class="summary-section">
        <div class="section-title">Registration Summary</div>
        <div class="summary-grid">
            <div class="summary-item">
                <div class="summary-number">{{ $registered_modules->count() }}</div>
                <div class="summary-label">Modules Registered</div>
            </div>
            <div class="summary-item">
                <div class="summary-number">{{ $currentYear->academic_year }}</div>
                <div class="summary-label">Academic Year</div>
            </div>
            <div class="summary-item">
                <div class="summary-number">${{ number_format($registered_modules->sum('amount'), 2) }}</div>
                <div class="summary-label">Total Fees</div>
            </div>
            <div class="summary-item">
                <div class="summary-number">{{ \Carbon\Carbon::parse($registration->registration_date)->format('d M Y') }}</div>
                <div class="summary-label">Registration Date</div>
            </div>
        </div>
    </div>

    <!-- Declaration -->
    <div class="declaration">
        <h6>Declaration</h6>
        <p>
            This is to certify that <strong>{{ $student->student_names }} {{ $student->surname }}</strong> 
            (Student Number: <strong>{{ $student->student_number }}</strong>) is officially registered 
            at {{ $company->company_name ?? 'this institution' }} for the academic year 
            <strong>{{ $currentYear->academic_year }}</strong>.
        </p>
        <p>
            The student is enrolled for {{ $registered_modules->count() }} module(s) with a total 
            registration fee of <strong>${{ number_format($registered_modules->sum('amount'), 2) }}</strong>.
        </p>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>This document was generated on {{ \Carbon\Carbon::now()->format('d M Y \a\t H:i') }}</p>
        <p>{{ $company->company_name ?? 'Institution Name' }} - Student Registration System</p>
    </div>
</body>
</html>
