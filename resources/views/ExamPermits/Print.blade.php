<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examination Permit - {{ $student->student_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background: white;
            color: #000;
            font-size: 12px;
            line-height: 1.4;
        }
        
        .header {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }
        
        .header-left {
            display: table-cell;
            width: 70%;
            vertical-align: top;
        }
        
        .header-right {
            display: table-cell;
            width: 30%;
            text-align: right;
            vertical-align: top;
        }
        
        .company-name {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .company-info {
            margin: 2px 0;
        }
        
        .logo {
            max-height: 80px;
            max-width: 150px;
        }
        
        .separator {
            border-top: 2px solid #000;
            margin: 20px 0;
        }
        
        .document-title {
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            text-decoration: underline;
            margin: 20px 0;
        }
        
        .student-info {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }
        
        .student-details {
            display: table-cell;
            width: 70%;
            vertical-align: top;
        }
        
        .student-photo {
            display: table-cell;
            width: 30%;
            text-align: center;
            vertical-align: top;
        }
        
        .info-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .info-table td {
            padding: 4px 0;
            vertical-align: top;
        }
        
        .info-label {
            font-weight: bold;
            width: 30%;
        }
        
        .photo-container {
            width: 120px;
            height: 150px;
            border: 2px solid #000;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8f9fa;
        }
        
        .photo {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .section-title {
            font-size: 14px;
            font-weight: bold;
            margin: 20px 0 10px 0;
        }
        
        .exam-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        .exam-table th,
        .exam-table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        
        .exam-table th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        
        .instructions {
            margin: 20px 0;
        }
        
        .instructions ul {
            margin: 10px 0;
            padding-left: 20px;
        }
        
        .instructions li {
            margin: 5px 0;
        }
        
        .signatures {
            display: table;
            width: 100%;
            margin-top: 40px;
        }
        
        .signature-box {
            display: table-cell;
            width: 50%;
            text-align: center;
            padding: 0 20px;
        }
        
        .signature-line {
            border-top: 1px solid #000;
            padding-top: 10px;
            margin-top: 40px;
        }
        
        .signature-label {
            font-weight: bold;
            margin: 0;
        }
        
        .signature-date {
            font-size: 11px;
            margin: 5px 0 0 0;
        }
        
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 10px;
            color: #666;
        }
        
        .alert {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 4px;
            padding: 10px;
            margin: 10px 0;
        }
        
        @media print {
            body {
                margin: 0;
                padding: 15px;
            }
            
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <!-- Company Header -->
    <div class="header">
        <div class="header-left">
            <div class="company-name">{{ $company->company_name ?? 'EDUCIMS TUTORIALS' }}</div>
            <div class="company-info">{{ $company->address ?? 'P.O. Box 123, Windhoek, Namibia' }}</div>
            <div class="company-info">Phone: {{ $company->phone ?? '+264 81 370 3726' }}</div>
            <div class="company-info">Email: {{ $company->email ?? 'info@educims.com' }}</div>
        </div>
        <div class="header-right">
            @if($company && $company->logo)
                <img src="{{ public_path('storage/' . $company->logo) }}" alt="Company Logo" class="logo">
            @endif
        </div>
    </div>

    <div class="separator"></div>

    <!-- Document Title -->
    <div class="document-title">EXAMINATION PERMIT</div>

    <!-- Student Information -->
    <div class="student-info">
        <div class="student-details">
            <div class="section-title">Student Information</div>
            <table class="info-table">
                <tr>
                    <td class="info-label">Student Number:</td>
                    <td>{{ $student->student_number }}</td>
                </tr>
                @if($student->student_number2)
                <tr>
                    <td class="info-label">Allocated Number:</td>
                    <td>{{ $student->student_number2 }}</td>
                </tr>
                @endif
                <tr>
                    <td class="info-label">Full Name:</td>
                    <td>{{ $student->student_names }} {{ $student->surname }}</td>
                </tr>
                <tr>
                    <td class="info-label">Date of Birth:</td>
                    <td>{{ $student->date_of_birth ? \Carbon\Carbon::parse($student->date_of_birth)->format('d F Y') : 'N/A' }}</td>
                </tr>
                <tr>
                    <td class="info-label">Centre:</td>
                    <td>{{ $student->center ? $student->center->center_name : 'N/A' }}</td>
                </tr>
            </table>
        </div>
        <div class="student-photo">
            <div class="photo-container">
                @if($student->photo)
                    <img src="{{ public_path('storage/' . $student->photo) }}" alt="Student Photo" class="photo">
                @else
                    <div style="font-size: 24px; color: #ccc;">📷</div>
                @endif
            </div>
            <div style="margin-top: 5px; font-size: 10px;">Student Photo</div>
        </div>
    </div>

    <!-- Examination Schedule -->
    <div class="section-title">Examination Schedule</div>
    @if($examSchedules->count() > 0)
        <table class="exam-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Subject</th>
                    <th>Venue</th>
                    <th>Duration</th>
                </tr>
            </thead>
            <tbody>
                @foreach($examSchedules as $schedule)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($schedule->exam_date)->format('d M Y') }}</td>
                    <td>
                        @if($schedule->classDuration)
                            {{ $schedule->classDuration->start_time ? \Carbon\Carbon::parse($schedule->classDuration->start_time)->format('H:i') : 'TBA' }}
                            @if($schedule->classDuration->end_time)
                                - {{ \Carbon\Carbon::parse($schedule->classDuration->end_time)->format('H:i') }}
                            @endif
                        @else
                            TBA
                        @endif
                    </td>
                    <td>{{ $schedule->subjectAllocation->module->module_name ?? 'N/A' }}</td>
                    <td>{{ $schedule->venue->name ?? 'TBA' }}</td>
                    <td>
                        @if($schedule->classDuration)
                            {{ $schedule->classDuration->duration ?? 'N/A' }}
                        @else
                            N/A
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="alert">
            ⚠️ No examination schedule found for this student's registered subjects.
        </div>
    @endif

    <!-- Important Instructions -->
    <div class="instructions">
        <div class="section-title">Important Instructions</div>
        <ul>
            <li>This permit must be presented at each examination session.</li>
            <li>Students must arrive at the examination venue 30 minutes before the scheduled time.</li>
            <li>Valid identification document must be presented along with this permit.</li>
            <li>Mobile phones and electronic devices are strictly prohibited in the examination room.</li>
            <li>Students must occupy their assigned seats as directed by the invigilator.</li>
            <li>Late arrivals may not be permitted to sit for the examination.</li>
        </ul>
    </div>

    <!-- Signatures -->
    <div class="signatures">
        <div class="signature-box">
            <div class="signature-line">
                <p class="signature-label">Student Signature</p>
                <p class="signature-date">Date: _______________</p>
            </div>
        </div>
        <div class="signature-box">
            <div class="signature-line">
                <p class="signature-label">Registrar's Office</p>
                <p class="signature-date">Date: {{ date('d F Y') }}</p>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        This document is computer generated and does not require a signature.<br>
        Generated on {{ date('d F Y \a\t H:i') }}
    </div>
</body>
</html>
