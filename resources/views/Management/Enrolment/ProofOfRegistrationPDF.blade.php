<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Proof of Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            font-size: 12px;
        }
        .header-table {
            width: 100%;
            margin-bottom: 20px;
        }
        .header-table td {
            vertical-align: top;
        }
        .company-info h3 {
            margin: 0 0 10px 0;
            font-size: 18px;
        }
        .company-info {
            line-height: 1.4;
        }
        .logo {
            text-align: right;
        }
        .logo img {
            max-height: 80px;
            max-width: 200px;
        }
        .date {
            text-align: right;
            margin-bottom: 30px;
        }
        .document-title {
            text-align: center;
            margin-bottom: 30px;
        }
        .document-title h2 {
            margin: 0;
            font-size: 20px;
        }
        .student-details {
            margin-bottom: 30px;
        }
        .student-details p {
            margin: 5px 0;
        }
        .registration-details {
            margin-bottom: 20px;
        }
        .modules-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .modules-table th,
        .modules-table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        .modules-table th {
            background-color: #f5f5f5;
            font-weight: bold;
        }
        .declaration {
            margin-top: 30px;
        }
        .signature {
            margin-top: 50px;
        }
        hr {
            border: none;
            border-top: 1px solid #000;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <!-- Company Header -->
    <table class="header-table">
        <tr>
            <td class="company-info">
                <h3>{{ $company->company_name }}</h3>
                {{ $company->address1 }}<br>
                @if($company->address2){{ $company->address2 }}<br>@endif
                @if($company->address3){{ $company->address3 }}<br>@endif
                @if($company->address4){{ $company->address4 }}<br>@endif
                <strong>C:</strong> {{ $company->contact_number }}<br>
                <strong>F:</strong> {{ $company->fax ?? 'N/A' }}<br>
                <strong>E:</strong> {{ $company->email }}<br>
            </td>
            <td class="logo">
                @if($company->logo)
                    @php
                        $logoPath = public_path('storage/'.$company->logo);
                        if (file_exists($logoPath)) {
                            $logoData = file_get_contents($logoPath);
                            $logoBase64 = base64_encode($logoData);
                            $logoMimeType = mime_content_type($logoPath);
                        }
                    @endphp
                    @if(isset($logoBase64))
                        <img src="data:{{ $logoMimeType }};base64,{{ $logoBase64 }}" alt="Company Logo" style="max-height: 80px; max-width: 200px;" />
                    @endif
                @endif
            </td>
        </tr>
    </table>

    <hr>

    <!-- Date -->
    <div class="date">
        <strong>Date:</strong> {{ date('F d, Y') }}
    </div>

    <!-- Document Title -->
    <div class="document-title">
        <h2><strong>PROOF OF REGISTRATION</strong></h2>
        <p>Academic Year: {{ $academic_year }}</p>
    </div>

    <!-- Student Details -->
    <div class="student-details">
        <p><strong>{{ $student->student_names }} {{ $student->surname }}</strong></p>
        @if($student->email)
            <p>{{ $student->email }}</p>
        @endif
        @if($student->contact_number)
            <p>{{ $student->contact_number }}</p>
        @endif
        <p><strong>Ref #:</strong> {{ $student->student_number }} | {{ $student->student_number2 }}</p>
    </div>

    <!-- Registration Details -->
    <div class="registration-details">
        <p><strong>Registration Details:</strong></p>
        <p>Registration Date: {{ \Carbon\Carbon::parse($registration->registration_date)->format('F d, Y') }}</p>
        <p>Registration Status: {{ $registration->registration_status }}</p>
        <p>Academic Year: {{ $registration->academic_year }}</p>
        <p>Center: {{ $registration->center->center_name ?? 'N/A' }}</p>
    </div>

    @if($registered_modules->count() > 0)
        <p><strong>Registered Modules:</strong></p>
        <table class="modules-table">
            <thead>
                <tr>
                    <th>Module Code</th>
                    <th>Module Name</th>
                    <th>Subject Symbol</th>
                    <th>System</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                @php $totalAmount = 0; @endphp
                @foreach($registered_modules as $module_registration)
                    <tr>
                        <td>{{ $module_registration->module->subject_code ?? 'N/A' }}</td>
                        <td>{{ $module_registration->module->subject_name ?? 'N/A' }}</td>
                        <td>{{ $module_registration->subject_symbol ?? 'N/A' }}</td>
                        <td>{{ $module_registration->system ?? 'N/A' }}</td>
                        <td>N${{ number_format($module_registration->amount, 2) }}</td>
                    </tr>
                    @php $totalAmount += $module_registration->amount; @endphp
                @endforeach
                <tr>
                    <th colspan="4">Total Amount:</th>
                    <th>N${{ number_format($totalAmount, 2) }}</th>
                </tr>
            </tbody>
        </table>
    @else
        <p>No modules registered for this academic year.</p>
    @endif

    <!-- Declaration -->
    <div class="declaration">
        <p>This is to certify that <strong>{{ $student->student_names }} {{ $student->surname }}</strong> 
        (Student Number: <strong>{{ $student->student_number }}</strong>) is officially registered 
        for the {{ $academic_year }} academic year with the above-mentioned modules.</p>
    </div>

    <!-- Signature -->
    <div class="signature">
        <p>_________________________</p>
        <p><strong>Registrar</strong></p>
        <p>{{ $company->company_name }}</p>
    </div>
</body>
</html>
