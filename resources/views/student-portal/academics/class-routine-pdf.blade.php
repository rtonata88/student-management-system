<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Class Routine - {{ $student ? $student->student_names . ' ' . $student->surname : 'Student' }}</title>
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
        .company-info {
            width: 70%;
        }
        .company-logo {
            width: 30%;
            text-align: right;
        }
        .company-logo img {
            max-width: 150px;
            height: auto;
        }
        .document-title {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin: 20px 0;
            text-decoration: underline;
        }
        .student-info {
            margin-bottom: 20px;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
        }
        .info-table th {
            text-align: left;
            width: 150px;
            padding: 3px 0;
            font-weight: bold;
        }
        .info-table td {
            padding: 3px 0;
        }
        .schedule-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .schedule-table th,
        .schedule-table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        .schedule-table th {
            background-color: #f0f0f0;
            font-weight: bold;
        }
        .day-cell {
            font-weight: bold;
            vertical-align: middle;
            text-align: center;
        }
        .time-cell {
            font-weight: bold;
        }
        .subject-cell {
            font-weight: bold;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
        .date-generated {
            text-align: right;
            margin-bottom: 20px;
            font-size: 11px;
        }
    </style>
</head>
<body>
    <!-- Header with Company Info and Logo -->
    <table class="header-table">
        <tr>
            <td class="company-info">
                @if($company)
                    <h3 style="margin: 0; color: #000;">{{ $company->company_name }}</h3>
                    <div style="margin-top: 5px;">
                        {{ $company->address1 }}<br>
                        @if($company->address2){{ $company->address2 }}<br>@endif
                        @if($company->address3){{ $company->address3 }}<br>@endif
                        @if($company->address4){{ $company->address4 }}<br>@endif
                        @if($company->contact_number)<strong>C:</strong> {{ $company->contact_number }}<br>@endif
                        @if($company->fax)<strong>F:</strong> {{ $company->fax }}<br>@endif
                        @if($company->email)<strong>E:</strong> {{ $company->email }}<br>@endif
                    </div>
                @else
                    <h3 style="margin: 0; color: #000;">Educational Institution</h3>
                @endif
            </td>
            <td class="company-logo">
                <img src="{{ public_path('assets/Logo.png') }}" alt="Logo" />
            </td>
        </tr>
    </table>

    <hr style="border: 1px solid #000; margin: 20px 0;">

    <!-- Date Generated -->
    <div class="date-generated">
        <strong>Date:</strong> {{ date('F d, Y') }}
    </div>

    <!-- Document Title -->
    <div class="document-title">
        CLASS ROUTINE / TIMETABLE
    </div>

    <!-- Student Information -->
    @if($student)
    <div class="student-info">
        <table class="info-table">
            <tr>
                <th>Student Number:</th>
                <td>{{ $student->student_number }}</td>
            </tr>
            <tr>
                <th>Allocated Number:</th>
                <td>{{ $student->student_number2 }}</td>
            </tr>
            <tr>
                <th>Student Names:</th>
                <td>{{ $student->student_names }} {{ $student->surname }}</td>
            </tr>
            <tr>
                <th>Center:</th>
                <td>{{ $student->center ? $student->center->center_name : 'N/A' }}</td>
            </tr>
            @if($currentAcademicYear)
            <tr>
                <th>Academic Year:</th>
                <td>{{ $currentAcademicYear->academic_year }}</td>
            </tr>
            @endif
        </table>
    </div>
    @endif

    <!-- Class Schedule Table -->
    @if($routines->count() > 0)
        <table class="schedule-table">
            <thead>
                <tr>
                    <th width="12%">Day</th>
                    <th width="15%">Time</th>
                    <th width="25%">Subject</th>
                    <th width="20%">Teacher</th>
                    <th width="20%">Venue</th>
                    <th width="8%">Duration</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $daysOrder = ['monday' => 1, 'tuesday' => 2, 'wednesday' => 3, 'thursday' => 4, 'friday' => 5, 'saturday' => 6, 'sunday' => 7];
                    $groupedRoutines = $routines->groupBy('day_of_week')->sortBy(function($group, $day) use ($daysOrder) {
                        return $daysOrder[strtolower($day)] ?? 8;
                    });
                @endphp
                
                @foreach($groupedRoutines as $day => $dayRoutines)
                    @foreach($dayRoutines->sortBy('start_time') as $index => $routine)
                        <tr>
                            @if($index === 0)
                                <td rowspan="{{ $dayRoutines->count() }}" class="day-cell">
                                    {{ strtoupper($routine->day_of_week) }}
                                </td>
                            @endif
                            <td class="time-cell">
                                {{ $routine->formatted_start_time }} - {{ $routine->formatted_end_time }}
                            </td>
                            <td class="subject-cell">
                                {{ $routine->subject_name }}<br>
                                <small style="color: #666;">{{ $routine->subject_code }}</small>
                            </td>
                            <td>
                                {{ $routine->teacher_name }}
                            </td>
                            <td>
                                {{ $routine->venue->venue_name ?? 'TBA' }}
                                @if($routine->venue && $routine->venue->capacity)
                                    <br><small style="color: #666;">Capacity: {{ $routine->venue->capacity }}</small>
                                @endif
                            </td>
                            <td style="text-align: center;">
                                @if($routine->classDuration)
                                    {{ $routine->classDuration->duration_minutes ?? '60' }} mins
                                @else
                                    Standard
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    @else
        <div style="text-align: center; padding: 40px; color: #666;">
            <p>No class schedule available for the current academic year.</p>
        </div>
    @endif

    <!-- Footer -->
    <div class="footer">
        <p><strong>Note:</strong> This schedule shows classes for your registered subjects in the current academic year at your center.</p>
        <p>If you notice any discrepancies, please contact your academic advisor.</p>
        <hr style="border: 0.5px solid #ccc; margin: 10px 0;">
        <p>Generated on {{ date('F d, Y \a\t g:i A') }} | {{ $company ? $company->company_name : 'Educational Institution' }}</p>
    </div>
</body>
</html>
