@extends('layouts.print')

@section('breadcrumb')
<div class="c-subheader px-3">
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Assessments</li>
        <li class="breadcrumb-item"><a href="{{ route('examination-schedule.index') }}">Examination Schedule</a></li>
        <li class="breadcrumb-item active">Print Timetable</li>
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
                                {{$company->address2}} <br>
                                {{$company->address3}} <br>
                                {{$company->address4}} <br>
                                <strong>C: </strong> {{$company->contact_number}} <br>
                                <strong>F: </strong>{{$company->fax}} <br>
                                <strong>E: </strong>{{$company->email}} <br>
                            </td>
                            <td width="200px; margin-right:20px;">
                                <img src="{{asset('assets/Logo.png')}}" class="img-fluid" />
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h2 style="margin-bottom: 30px; color: #2c3e50; border-bottom: 2px solid #3498db; padding-bottom: 10px;">
                            EXAMINATION TIMETABLE
                        </h2>
                        <h4 style="color: #7f8c8d; margin-bottom: 20px;">
                            Academic Year: {{ $currentAcademicYear->academic_year }}
                        </h4>
                        
                        @if($center || $examination || $dateFrom || $dateTo)
                            <div style="margin-bottom: 20px; padding: 10px; background-color: #ecf0f1; border-radius: 5px;">
                                @if($center)
                                    <strong>Centre:</strong> {{ $center->center_name }} &nbsp;&nbsp;
                                @endif
                                @if($examination)
                                    <strong>Examination:</strong> {{ $examination->name }} &nbsp;&nbsp;
                                @endif
                                @if($dateFrom && $dateTo)
                                    <strong>Period:</strong> {{ \Carbon\Carbon::parse($dateFrom)->format('M j, Y') }} - {{ \Carbon\Carbon::parse($dateTo)->format('M j, Y') }}
                                @elseif($dateFrom)
                                    <strong>From:</strong> {{ \Carbon\Carbon::parse($dateFrom)->format('M j, Y') }}
                                @elseif($dateTo)
                                    <strong>Until:</strong> {{ \Carbon\Carbon::parse($dateTo)->format('M j, Y') }}
                                @endif
                            </div>
                        @endif
                    </div>
                </div>

                @if($groupedSchedules->count() > 0)
                    @foreach($groupedSchedules as $date => $schedules)
                        <div style="page-break-inside: avoid; margin-bottom: 30px;">
                            <div style="background-color: #3498db; color: white; padding: 10px; margin-bottom: 15px; border-radius: 5px;">
                                <h4 style="margin: 0; text-align: center;">
                                    {{ \Carbon\Carbon::parse($date)->format('l, F j, Y') }}
                                </h4>
                            </div>
                            
                            <table class="table table-bordered" style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
                                <thead>
                                    <tr style="background-color: #f8f9fa;">
                                        <th style="border: 1px solid #dee2e6; padding: 8px; text-align: center; font-weight: bold;">Time</th>
                                        <th style="border: 1px solid #dee2e6; padding: 8px; text-align: center; font-weight: bold;">Subject</th>
                                        <th style="border: 1px solid #dee2e6; padding: 8px; text-align: center; font-weight: bold;">Teacher</th>
                                        <th style="border: 1px solid #dee2e6; padding: 8px; text-align: center; font-weight: bold;">Venue</th>
                                        @if(!$center)
                                            <th style="border: 1px solid #dee2e6; padding: 8px; text-align: center; font-weight: bold;">Centre</th>
                                        @endif
                                        @if(!$examination)
                                            <th style="border: 1px solid #dee2e6; padding: 8px; text-align: center; font-weight: bold;">Exam Type</th>
                                        @endif
                                        <th style="border: 1px solid #dee2e6; padding: 8px; text-align: center; font-weight: bold;">Capacity</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($schedules->sortBy('classDuration.sort_order') as $schedule)
                                        <tr style="{{ $schedule->hasConflicts() ? 'background-color: #fff3cd;' : '' }}">
                                            <td style="border: 1px solid #dee2e6; padding: 8px; text-align: center; font-weight: bold; background-color: #f8f9fa;">
                                                {{ $schedule->time_range }}
                                            </td>
                                            <td style="border: 1px solid #dee2e6; padding: 8px;">
                                                <strong>{{ $schedule->subject_name }}</strong><br>
                                                <small style="color: #6c757d;">{{ $schedule->subject_code }}</small>
                                            </td>
                                            <td style="border: 1px solid #dee2e6; padding: 8px;">
                                                {{ $schedule->teacher_name }}
                                            </td>
                                            <td style="border: 1px solid #dee2e6; padding: 8px;">
                                                <strong>{{ $schedule->venue->venue_name }}</strong><br>
                                                <small style="color: #6c757d;">{{ $schedule->venue->venue_code }}</small>
                                            </td>
                                            @if(!$center)
                                                <td style="border: 1px solid #dee2e6; padding: 8px;">
                                                    {{ $schedule->center->center_name }}
                                                </td>
                                            @endif
                                            @if(!$examination)
                                                <td style="border: 1px solid #dee2e6; padding: 8px; text-align: center;">
                                                    {{ $schedule->examination->name }}
                                                </td>
                                            @endif
                                            <td style="border: 1px solid #dee2e6; padding: 8px; text-align: center;">
                                                {{ $schedule->venue->capacity }} students
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endforeach

                    <!-- Summary Section -->
                    <div style="margin-top: 40px; page-break-inside: avoid;">
                        <h4 style="color: #2c3e50; border-bottom: 1px solid #bdc3c7; padding-bottom: 5px;">
                            Examination Summary
                        </h4>
                        <div style="display: flex; justify-content: space-between; margin-top: 15px;">
                            <div>
                                <strong>Total Examinations:</strong> {{ $groupedSchedules->flatten()->count() }}<br>
                                <strong>Total Days:</strong> {{ $groupedSchedules->count() }}<br>
                                @if($center)
                                    <strong>Centre:</strong> {{ $center->center_name }}<br>
                                @endif
                            </div>
                            <div style="text-align: right;">
                                <strong>Generated on:</strong> {{ now()->format('F j, Y \a\t g:i A') }}<br>
                                <strong>Generated by:</strong> {{ Auth::user()->name }}<br>
                            </div>
                        </div>
                    </div>

                    <!-- Notes Section -->
                    <div style="margin-top: 30px; page-break-inside: avoid;">
                        <h5 style="color: #2c3e50;">Important Notes:</h5>
                        <ul style="color: #7f8c8d; font-size: 0.9em;">
                            <li>All students must arrive at least 15 minutes before the examination time.</li>
                            <li>Students must bring valid identification and required stationery.</li>
                            <li>Mobile phones and electronic devices are strictly prohibited in examination venues.</li>
                            <li>Late arrivals may not be permitted to sit for the examination.</li>
                            @if($groupedSchedules->flatten()->where('hasConflicts', true)->count() > 0)
                                <li style="color: #e74c3c;"><strong>Warning:</strong> Some schedules have conflicts. Please review and resolve before the examination dates.</li>
                            @endif
                        </ul>
                    </div>

                @else
                    <div style="text-align: center; padding: 50px;">
                        <h4 style="color: #7f8c8d;">No examination schedules found for the specified criteria.</h4>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    .card {
        border: none !important;
        box-shadow: none !important;
    }
    
    .page-break {
        page-break-after: always;
    }
    
    .no-print {
        display: none !important;
    }
    
    body {
        font-size: 12px;
    }
    
    table {
        font-size: 11px;
    }
}

.table th, .table td {
    border: 1px solid #dee2e6 !important;
}

.table thead th {
    border-bottom: 2px solid #dee2e6 !important;
}
</style>
@endsection
