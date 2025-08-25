@extends('layouts.print')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Applications</li>
        <li class="breadcrumb-item"><a href="/student-letters">Student Letters</a></li>
        <li class="breadcrumb-item active">
            @php
                $letterTitles = [
                    'testimonial' => 'Testimonial Letter',
                    'completion' => 'Letter of Completion',
                    'achievement' => 'Letter of Achievement',
                    'enrollment' => 'Letter of Enrollment',
                    'conduct' => 'Letter of Good Conduct',
                    'recommendation' => 'Letter of Recommendation',
                    'attendance' => 'Letter of Attendance',
                    'verification' => 'Student Verification Letter'
                ];
            @endphp
            {{ $letterTitles[$letterType] ?? ucwords(str_replace('_', ' ', $letterType)) }}
        </li>
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
                                {{$company->address2}} <br>
                                @if($company->address3)
                                    {{$company->address3}} <br>
                                @endif
                                @if($company->address4)
                                    {{$company->address4}} <br>
                                @endif
                                <strong>C: </strong> {{$company->contact_number}} <br>
                                @if($company->fax_number)
                                    <strong>F: </strong>{{$company->fax_number}} <br>
                                @endif
                                <strong>E: </strong>{{$company->email}} <br>
                            </td>
                            <td width="200px; margin-right:20px;">
                                @if($company->logo && file_exists(storage_path('app/public/' . $company->logo)))
                                    @php
                                        $logoPath = storage_path('app/public/' . $company->logo);
                                        $logoData = base64_encode(file_get_contents($logoPath));
                                        $logoMime = mime_content_type($logoPath);
                                    @endphp
                                    <img src="data:{{ $logoMime }};base64,{{ $logoData }}" style="max-width: 150px; max-height: 100px;" />
                                @elseif(file_exists(public_path('assets/Logo.png')))
                                    @php
                                        $logoPath = public_path('assets/Logo.png');
                                        $logoData = base64_encode(file_get_contents($logoPath));
                                    @endphp
                                    <img src="data:image/png;base64,{{ $logoData }}" style="max-width: 150px; max-height: 100px;" />
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div style="text-align: right; margin-bottom: 30px;">
                            <strong>Date: </strong>{{ date('F j, Y') }}
                        </div>
                        
                        <div style="text-align: center; margin-bottom: 30px;">
                            <h4 style="text-decoration: underline; text-transform: uppercase;">
                                @php
                                    $letterTitles = [
                                        'testimonial' => 'Testimonial Letter',
                                        'completion' => 'Letter of Completion',
                                        'achievement' => 'Letter of Achievement',
                                        'enrollment' => 'Letter of Enrollment',
                                        'conduct' => 'Letter of Good Conduct',
                                        'recommendation' => 'Letter of Recommendation',
                                        'attendance' => 'Letter of Attendance',
                                        'verification' => 'Student Verification Letter'
                                    ];
                                @endphp
                                {{ $letterTitles[$letterType] ?? ucwords(str_replace('_', ' ', $letterType)) }}
                            </h4>
                        </div>
                        
                        <div style="margin-bottom: 20px;">
                            <strong>To Whom It May Concern:</strong>
                        </div>
                        
                        <div style="margin-bottom: 20px; text-align: justify; line-height: 1.6; text-indent: 30px;">
                            {{ $letterContent }}
                        </div>
                        
                        <div style="background: #f8f9fa; padding: 15px; border-left: 4px solid #007bff; margin-bottom: 20px;">
                            <strong>Student Details:</strong><br><br>
                            <table class="table-sm" style="width:100%">
                                <tr>
                                    <th style="width: 150px">Student Name:</th>
                                    <td>{{ $student->student_names }} {{ $student->surname }}</td>
                                </tr>
                                <tr>
                                    <th style="width: 150px">Student Number:</th>
                                    <td>{{ $student->student_number }}</td>
                                </tr>
                                @if($student->student_number2)
                                <tr>
                                    <th style="width: 150px">Allocated Number:</th>
                                    <td>{{ $student->student_number2 }}</td>
                                </tr>
                                @endif
                                @if($student->center)
                                <tr>
                                    <th style="width: 150px">Centre:</th>
                                    <td>{{ $student->center->center_name }}</td>
                                </tr>
                                @endif
                                @if($student->date_of_birth)
                                <tr>
                                    <th style="width: 150px">Date of Birth:</th>
                                    <td>{{ $student->date_of_birth }}</td>
                                </tr>
                                @endif
                            </table>
                        </div>
                        
                        <div style="margin-bottom: 15px; line-height: 1.6;">
                            Should you require any further information, please do not hesitate to contact our office.
                        </div>
                        
                        <div style="margin-bottom: 15px;">
                            Yours sincerely,
                        </div>
                        
                        <div style="margin-top: 30px; margin-bottom: 20px;">
                            <table style="width: 100%;">
                                <tr>
                                    <td style="width: 50%;">
                                        <div style="border-bottom: 1px solid #000; width: 250px; margin-bottom: 10px;"></div>
                                        <strong>Registrar</strong><br>
                                        {{ $company->company_name }}
                                    </td>
                                    <td style="width: 50%; text-align: center;">
                                        <div style="border: 2px dashed #ccc; border-radius: 50%; width: 120px; height: 120px; display: inline-flex; align-items: center; justify-content: center; background: #f8f9fa;">
                                            <div style="font-size: 12px; font-weight: bold; color: #999; text-align: center; line-height: 1.2; display: flex; flex-direction: column; align-items: center; justify-content: center;">
                                                <span>OFFICIAL</span>
                                                <span>STAMP</span>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
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
    
    .card-header {
        background: white !important;
        border: none !important;
    }
    
    body {
        font-family: 'Times New Roman', serif;
        line-height: 1.6;
    }
}
</style>
@endsection
