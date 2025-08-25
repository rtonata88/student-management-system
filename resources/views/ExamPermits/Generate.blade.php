@extends('layouts.app')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Applications</li>
        <li class="breadcrumb-item"><a href="/exam-permits">Exam Permits</a></li>
        <li class="breadcrumb-item active">Generate Permit</li>
        <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <strong>Examination Permit</strong>
                    <div class="card-header-actions">
                        <a href="{{ route('exam-permits.download', $student->id) }}" class="btn btn-sm" 
                           style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                            <i class="fas fa-download me-1"></i>Download PDF
                        </a>
                        <a href="{{ route('exam-permits.print', $student->id) }}" target="_blank" class="btn btn-sm" 
                           style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.375rem 0.75rem;">
                            <i class="fas fa-print me-1"></i>Print
                        </a>
                        <a href="{{ route('exam-permits.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left me-1"></i>Back to Search
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Company Header -->
                    <div class="row mb-4">
                        <div class="col-8">
                            <h3 class="mb-1" style="color: #000; font-weight: bold;">{{ $company->company_name ?? 'EDUCIMS TUTORIALS' }}</h3>
                            <p class="mb-0" style="color: #000;">{{ $company->address ?? 'P.O. Box 123, Windhoek, Namibia' }}</p>
                            <p class="mb-0" style="color: #000;">Phone: {{ $company->phone ?? '+264 81 370 3726' }}</p>
                            <p class="mb-0" style="color: #000;">Email: {{ $company->email ?? 'info@educims.com' }}</p>
                        </div>
                        <div class="col-4 text-end">
                            @if(file_exists(public_path('assets/Logo.png')))
                                <img src="{{ asset('assets/Logo.png') }}" alt="Company Logo" style="max-height: 80px;">
                            @elseif($company && $company->logo && file_exists(storage_path('app/public/' . $company->logo)))
                                <img src="{{ asset('storage/' . $company->logo) }}" alt="Company Logo" style="max-height: 80px;">
                            @else
                                <div class="bg-light p-3 d-inline-block" style="border: 1px solid #ddd;">
                                    <i class="fas fa-building fa-2x text-muted"></i>
                                </div>
                            @endif
                        </div>
                    </div>

                    <hr style="border-top: 2px solid #000;">

                    <!-- Document Title -->
                    <div class="text-center mb-4">
                        <h2 style="color: #000; font-weight: bold; text-decoration: underline;">EXAMINATION PERMIT</h2>
                    </div>

                    <!-- Student Information -->
                    <div class="row mb-4">
                        <div class="col-8">
                            <h5 style="color: #000; font-weight: bold;">Student Information</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <td style="width: 30%; color: #000; font-weight: bold;">Student Number:</td>
                                    <td style="color: #000;">{{ $student->student_number }}</td>
                                </tr>
                                @if($student->student_number2)
                                <tr>
                                    <td style="color: #000; font-weight: bold;">Allocated Number:</td>
                                    <td style="color: #000;">{{ $student->student_number2 }}</td>
                                </tr>
                                @endif
                                <tr>
                                    <td style="color: #000; font-weight: bold;">Full Name:</td>
                                    <td style="color: #000;">{{ $student->student_names }} {{ $student->surname }}</td>
                                </tr>
                                <tr>
                                    <td style="color: #000; font-weight: bold;">Date of Birth:</td>
                                    <td style="color: #000;">{{ $student->date_of_birth ? \Carbon\Carbon::parse($student->date_of_birth)->format('d F Y') : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td style="color: #000; font-weight: bold;">Centre:</td>
                                    <td style="color: #000;">{{ $student->center ? $student->center->center_name : 'N/A' }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-4 text-center">
                            @if($student->photo)
                                <img src="{{ asset('storage/' . $student->photo) }}" alt="Student Photo" 
                                     style="width: 120px; height: 150px; object-fit: cover; border: 2px solid #000;">
                            @else
                                <div style="width: 120px; height: 150px; border: 2px solid #000; display: flex; align-items: center; justify-content: center; background: #f8f9fa;">
                                    <i class="fas fa-user fa-3x text-muted"></i>
                                </div>
                            @endif
                            <p class="mt-2 mb-0" style="color: #000; font-size: 0.8rem;">Student Photo</p>
                        </div>
                    </div>

                    <!-- Examination Schedule -->
                    <div class="mb-4">
                        <h5 style="color: #000; font-weight: bold;">Examination Schedule</h5>
                        @if($examSchedules->count() > 0)
                            <table class="table table-bordered">
                                <thead style="background-color: #f8f9fa;">
                                    <tr>
                                        <th style="color: #000; font-weight: bold;">Date</th>
                                        <th style="color: #000; font-weight: bold;">Time</th>
                                        <th style="color: #000; font-weight: bold;">Subject</th>
                                        <th style="color: #000; font-weight: bold;">Venue</th>
                                        <th style="color: #000; font-weight: bold;">Duration</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($examSchedules as $schedule)
                                    <tr>
                                        <td style="color: #000;">{{ \Carbon\Carbon::parse($schedule->exam_date)->format('d M Y') }}</td>
                                        <td style="color: #000;">
                                            @if($schedule->classDuration)
                                                {{ $schedule->classDuration->start_time ? \Carbon\Carbon::parse($schedule->classDuration->start_time)->format('H:i') : 'TBA' }}
                                                @if($schedule->classDuration->end_time)
                                                    - {{ \Carbon\Carbon::parse($schedule->classDuration->end_time)->format('H:i') }}
                                                @endif
                                            @else
                                                TBA
                                            @endif
                                        </td>
                                        <td style="color: #000;">{{ $schedule->subject_name ?? ($schedule->subject->subject_name ?? 'N/A') }}</td>
                                        <td style="color: #000;">{{ $schedule->venue->venue_name ?? ($schedule->venue->name ?? 'TBA') }}</td>
                                        <td style="color: #000;">
                                            @if($schedule->classDuration && $schedule->classDuration->start_time && $schedule->classDuration->end_time)
                                                @php
                                                    $start = \Carbon\Carbon::parse($schedule->classDuration->start_time);
                                                    $end = \Carbon\Carbon::parse($schedule->classDuration->end_time);
                                                    $duration = $start->diffInMinutes($end);
                                                    $hours = intval($duration / 60);
                                                    $minutes = $duration % 60;
                                                @endphp
                                                {{ $hours > 0 ? $hours . 'h ' : '' }}{{ $minutes > 0 ? $minutes . 'm' : '' }}
                                            @elseif($schedule->classDuration && $schedule->classDuration->duration)
                                                {{ $schedule->classDuration->duration }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                No examination schedule found for this student's registered subjects.
                            </div>
                        @endif
                    </div>

                    <!-- Important Instructions -->
                    <div class="mb-4">
                        <h5 style="color: #000; font-weight: bold;">Important Instructions</h5>
                        <ul style="color: #000;">
                            <li>This permit must be presented at each examination session.</li>
                            <li>Students must arrive at the examination venue 30 minutes before the scheduled time.</li>
                            <li>Valid identification document must be presented along with this permit.</li>
                            <li>Mobile phones and electronic devices are strictly prohibited in the examination room.</li>
                            <li>Students must occupy their assigned seats as directed by the invigilator.</li>
                            <li>Late arrivals may not be permitted to sit for the examination.</li>
                        </ul>
                    </div>

                    <!-- Signatures -->
                    <div class="row mt-5">
                        <div class="col-6">
                            <div style="border-top: 1px solid #000; padding-top: 10px; text-align: center;">
                                <p style="color: #000; margin: 0; font-weight: bold;">Student Signature</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div style="border-top: 1px solid #000; padding-top: 10px; text-align: center;">
                                <p style="color: #000; margin: 0; font-weight: bold;">Registrar's Office</p>
                                <p style="color: #000; margin: 0; font-size: 0.9rem;">Date: {{ date('d F Y') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="text-center mt-4">
                        <p style="color: #666; font-size: 0.8rem;">
                            This document is computer generated and does not require a signature.
                            <br>Generated on {{ date('d F Y \a\t H:i') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
