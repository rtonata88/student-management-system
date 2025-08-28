<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Class Routine - {{ $center ? $center->center_name : 'All Centers' }} - {{ $academicYear ? $academicYear->academic_year : 'All Years' }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #333;
        }
        .header h2 {
            margin: 5px 0;
            font-size: 18px;
            color: #666;
        }
        .info-section {
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
        }
        .info-item {
            font-weight: bold;
        }
        .timetable {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .timetable th,
        .timetable td {
            border: 1px solid #333;
            padding: 8px;
            text-align: center;
            vertical-align: top;
        }
        .timetable th {
            background-color: #f5f5f5;
            font-weight: bold;
            font-size: 11px;
        }
        .timetable td {
            font-size: 10px;
            min-height: 40px;
        }
        .time-slot {
            font-weight: bold;
            background-color: #f9f9f9;
            width: 120px;
        }
        .class-item {
            background-color: #e8f4fd;
            border-radius: 3px;
            padding: 3px;
            margin: 1px 0;
            border-left: 3px solid #007bff;
        }
        .subject-name {
            font-weight: bold;
            color: #333;
            font-size: 9px;
        }
        .teacher-name {
            color: #666;
            font-size: 8px;
        }
        .venue-name {
            color: #28a745;
            font-size: 8px;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ccc;
            padding-top: 10px;
        }
        @media print {
            body {
                margin: 0;
                padding: 10px;
            }
            .header {
                page-break-inside: avoid;
            }
            .timetable {
                page-break-inside: avoid;
            }
        }
        .no-classes {
            color: #999;
            font-style: italic;
            font-size: 9px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Class Routine</h1>
        <h2>{{ $center ? $center->center_name : 'All Centers' }}</h2>
        @if($academicYear)
            <p>Academic Year: {{ $academicYear->academic_year }}</p>
        @endif
    </div>

    <div class="info-section">
        <div class="info-item">Generated: {{ now()->format('F d, Y - H:i') }}</div>
        <div class="info-item">Total Schedules: {{ $schedules->count() }}</div>
    </div>

    @php
        $daysOfWeek = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
        $dayLabels = [
            'monday' => 'Monday',
            'tuesday' => 'Tuesday', 
            'wednesday' => 'Wednesday',
            'thursday' => 'Thursday',
            'friday' => 'Friday',
            'saturday' => 'Saturday',
            'sunday' => 'Sunday'
        ];

        // Get all unique time slots based on start_time
        $timeSlots = $schedules->groupBy('start_time')->map(function($group) {
            return $group->first();
        })->sortBy('start_time');
        
        // Group schedules by day and time
        $timetableData = [];
        foreach($daysOfWeek as $day) {
            $timetableData[$day] = [];
            foreach($timeSlots as $timeSlot) {
                $timetableData[$day][$timeSlot->start_time] = $schedules->filter(function($schedule) use ($day, $timeSlot) {
                    return $schedule->day_of_week === $day && $schedule->start_time === $timeSlot->start_time;
                });
            }
        }
    @endphp

    @if($schedules->count() > 0)
        <table class="timetable">
            <thead>
                <tr>
                    <th class="time-slot">Time</th>
                    @foreach($daysOfWeek as $day)
                        <th>{{ $dayLabels[$day] }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($timeSlots as $timeSlot)
                    <tr>
                        <td class="time-slot">
                            <strong>{{ $timeSlot->time_range }}</strong>
                        </td>
                        @foreach($daysOfWeek as $day)
                            <td>
                                @if($timetableData[$day][$timeSlot->start_time]->count() > 0)
                                    @foreach($timetableData[$day][$timeSlot->start_time] as $schedule)
                                        <div class="class-item">
                                            <div class="subject-name">{{ $schedule->subjectAllocation->module->module_name ?? 'N/A' }}</div>
                                            <div class="teacher-name">{{ $schedule->subjectAllocation->user->name ?? 'N/A' }}</div>
                                            <div class="venue-name">{{ $schedule->venue->venue_name ?? 'N/A' }}</div>
                                            @if($schedule->notes)
                                                <div style="font-size: 7px; color: #999;">{{ Str::limit($schedule->notes, 30) }}</div>
                                            @endif
                                        </div>
                                    @endforeach
                                @else
                                    <div class="no-classes">No classes</div>
                                @endif
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div style="text-align: center; padding: 50px; color: #666;">
            <h3>No class schedules found for the selected criteria.</h3>
        </div>
    @endif

    <div class="footer">
        <p>This routine is effective as of {{ now()->format('F d, Y') }}. Please check for updates regularly.</p>
        <p>Generated from Academic Management System</p>
    </div>

    <script>
        // Auto-print when page loads
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>
