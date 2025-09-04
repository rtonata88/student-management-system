<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Exam Timetable - {{ $student ? $student->student_number : 'Student' }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            font-size: 12px;
            line-height: 1.4;
        }
        
        .card {
            border: none;
            box-shadow: none;
        }
        
        .card-header {
            background: white;
            border-bottom: 1px solid #ddd;
            padding: 20px 0;
        }
        
        .company-info-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .company-info-table td {
            vertical-align: top;
            padding: 0;
        }
        
        .company-name {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        
        .company-details {
            font-size: 12px;
            line-height: 1.5;
        }
        
        .logo-cell {
            width: 200px;
            text-align: right;
            padding-left: 20px;
        }
        
        .logo-img {
            max-width: 150px;
            height: auto;
        }
        
        .table-sm {
            width: 100%;
            border-collapse: collapse;
        }
        
        .table-sm th,
        .table-sm td {
            padding: 5px 10px;
            border: none;
            text-align: left;
        }
        
        .table-sm th {
            font-weight: bold;
            width: 150px;
        }
        
        .exam-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        .exam-table th,
        .exam-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            font-size: 11px;
        }
        
        .exam-table th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        
        .exam-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        .document-title {
            font-size: 18px;
            font-weight: bold;
            text-align: center;
            margin: 20px 0;
        }
        
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        
        hr {
            border: none;
            border-top: 1px solid #ddd;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="card-header">
            <table class="company-info-table">
                <tr>
                    <td>
                        <h3 class="company-name">{{$company->company_name}}</h3>
                        <div class="company-details">
                            {{$company->address1}}<br>
                            {{$company->address2}}<br>
                            {{$company->address3}}<br>
                            {{$company->address4}}<br>
                            <strong>C: </strong>{{$company->contact_number}}<br>
                            <strong>F: </strong>{{$company->fax}}<br>
                            <strong>E: </strong>{{$company->email}}<br>
                        </div>
                    </td>
                    <td class="logo-cell">
                        <img src="{{asset('assets/Logo.png')}}" class="logo-img" />
                    </td>
                </tr>
            </table>
        </div>
        <div class="card-body">
            <div class="document-title">EXAMINATION TIMETABLE</div>

            @if($student)
            <table class="table-sm" style="width:100%; margin-bottom: 20px;">
                <tr>
                    <th style="width: 150px">Student Number</th>
                    <td>{{ $student->student_number }}</td>
                </tr>
                <tr>
                    <th style="width: 150px">Allocated Number</th>
                    <td>{{ $student->student_number2 }}</td>
                </tr>
                <tr>
                    <th style="width: 150px">Student Names</th>
                    <td>{{ $student->student_names }} {{ $student->surname }}</td>
                </tr>
                <tr>
                    <th style="width: 150px">Academic Year</th>
                    <td>{{ $currentAcademicYear ? $currentAcademicYear->academic_year : 'N/A' }}</td>
                </tr>
                <tr>
                    <th style="width: 150px">Center</th>
                    <td>{{ $student->center ? $student->center->center_name : 'N/A' }}</td>
                </tr>
            </table>
            @endif

            <hr>

            <table class="exam-table">
            <thead>
                <tr>
                    <th style="width: 15%;">Date</th>
                    <th style="width: 12%;">Time</th>
                    <th style="width: 25%;">Subject</th>
                    <th style="width: 12%;">Code</th>
                    <th style="width: 15%;">Venue</th>
                    <th style="width: 10%;">Duration</th>
                    <th style="width: 11%;">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($examSchedules->sortBy('exam_date') as $schedule)
                    @php
                        $examDate = \Carbon\Carbon::parse($schedule->exam_date);
                        $isUpcoming = $examDate->isFuture();
                        $isToday = $examDate->isToday();
                        $statusClass = $isToday ? 'status-today' : ($isUpcoming ? 'status-upcoming' : 'status-completed');
                        $statusText = $isToday ? 'Today' : ($isUpcoming ? 'Upcoming' : 'Completed');
                    @endphp
                    <tr>
                        <td>
                            <strong>{{ $examDate->format('d M Y') }}</strong><br>
                            <small>{{ $examDate->format('l') }}</small>
                        </td>
                        <td>
                            @if($schedule->classDuration)
                                {{ $schedule->classDuration->start_time }}<br>
                                {{ $schedule->classDuration->end_time }}
                            @else
                                <em>Time TBA</em>
                            @endif
                        </td>
                        <td>{{ $schedule->subject_name }}</td>
                        <td>{{ $schedule->subject_code }}</td>
                        <td>
                            @if($schedule->venue)
                                <strong>{{ $schedule->venue->venue_name }}</strong>
                                @if($schedule->venue->venue_code)
                                    <br><small>{{ $schedule->venue->venue_code }}</small>
                                @endif
                            @else
                                <em>Venue TBA</em>
                            @endif
                        </td>
                        <td>
                            @if($schedule->classDuration && $schedule->classDuration->duration_minutes)
                                {{ $schedule->classDuration->formatted_duration }}
                            @else
                                <em>N/A</em>
                            @endif
                        </td>
                        <td>
                            <span class="status-badge {{ $statusClass }}">{{ $statusText }}</span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            </table>
        </div>
    </div>

    <div class="footer">
        <p>This document was generated automatically from the Student Portal on {{ \Carbon\Carbon::now()->format('d M Y \a\t H:i') }}.</p>
        <p>For any queries regarding your examination schedule, please contact the Academic Office.</p>
    </div>
</body>
</html>
