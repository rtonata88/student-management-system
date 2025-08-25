@extends('layouts.print')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Student</li>
        <li class="breadcrumb-item"><a href="/proof-of-registration">Proof of Registration</a></li>
        <li class="breadcrumb-item active">{{$student->student_names}} {{$student->surname}}</li>
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
                                {{$company->address3}} <br>
                                {{$company->address4}} <br>
                                <strong>C: </strong> {{$company->contact_number}} <br>
                                <strong>F: </strong>{{$company->fax}} <br>
                                <strong>E: </strong>{{$company->email}} <br>
                            </td>
                            <td width="200px; margin-right:20px;">
                                @php
                                    $logoSrc = null;
                                    
                                    // Try company logo first
                                    if($company && $company->logo) {
                                        $logoPath = storage_path('app/public/' . $company->logo);
                                        if (file_exists($logoPath)) {
                                            $logoData = base64_encode(file_get_contents($logoPath));
                                            $logoMimeType = mime_content_type($logoPath);
                                            $logoSrc = 'data:' . $logoMimeType . ';base64,' . $logoData;
                                        }
                                    }
                                    
                                    // Fallback to default logo
                                    if (!$logoSrc) {
                                        $defaultLogoPath = public_path('assets/Logo.png');
                                        if (file_exists($defaultLogoPath)) {
                                            $logoData = base64_encode(file_get_contents($defaultLogoPath));
                                            $logoMimeType = mime_content_type($defaultLogoPath);
                                            $logoSrc = 'data:' . $logoMimeType . ';base64,' . $logoData;
                                        }
                                    }
                                @endphp
                                
                                @if($logoSrc)
                                    <img src="{{ $logoSrc }}" class="img-fluid" style="max-width: 150px; max-height: 100px;" />
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="card-body">
                <div class="text-center mb-4">
                    <h4 style="text-align: center; font-weight: bold; margin: 20px 0;"><strong>PROOF OF REGISTRATION</strong></h4>
                    <p class="text-muted" style="text-align: center;">Academic Year: {{ $currentYear->academic_year }}</p>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered table-sm" style="width:100%; margin-bottom: 20px;">
                            <tbody>
                                <tr>
                                    <th style="width: 20%; background-color: #f8f9fa; padding: 8px; font-weight: bold;">Student Number</th>
                                    <td style="width: 30%; padding: 8px;">{{$student->student_number}}</td>
                                    <th style="width: 20%; background-color: #f8f9fa; padding: 8px; font-weight: bold;">Academic Year</th>
                                    <td style="width: 30%; padding: 8px;">{{ $currentYear->academic_year }}</td>
                                </tr>
                                <tr>
                                    <th style="background-color: #f8f9fa; padding: 8px; font-weight: bold;">Student Names</th>
                                    <td style="padding: 8px;">{{$student->student_names}}</td>
                                    <th style="background-color: #f8f9fa; padding: 8px; font-weight: bold;">Status</th>
                                    <td style="padding: 8px;"><span class="badge badge-success" style="background-color: #28a745; color: white; padding: 4px 8px; border-radius: 4px; font-size: 11px;">{{ $registration->registration_status }}</span></td>
                                </tr>
                                <tr>
                                    <th style="background-color: #f8f9fa; padding: 8px; font-weight: bold;">Surname</th>
                                    <td style="padding: 8px;">{{$student->surname}}</td>
                                    <th style="background-color: #f8f9fa; padding: 8px; font-weight: bold;">Total Subjects</th>
                                    <td style="padding: 8px;">{{ $registered_modules->count() }}</td>
                                </tr>
                                <tr>
                                    <th style="background-color: #f8f9fa; padding: 8px; font-weight: bold;">Date of Birth</th>
                                    <td style="padding: 8px;">{{ $student->date_of_birth ? \Carbon\Carbon::parse($student->date_of_birth)->format('d M Y') : 'N/A' }}</td>
                                    <th style="background-color: #f8f9fa; padding: 8px; font-weight: bold;">Total Fees</th>
                                    <td style="padding: 8px; font-weight: bold; color: #28a745;">N${{ number_format($registered_modules->sum('amount'), 2, '.', ',') }}</td>
                                </tr>
                                <tr>
                                    <th style="background-color: #f8f9fa; padding: 8px; font-weight: bold;">Center</th>
                                    <td style="padding: 8px;">{{$student->center->center_name ?? 'N/A'}}</td>
                                    <th style="background-color: #f8f9fa; padding: 8px; font-weight: bold;">Registration Date</th>
                                    <td style="padding: 8px;">{{ \Carbon\Carbon::parse($registration->registration_date)->format('d M Y') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <hr>
                
                @if($registered_modules->count() > 0)
                <h5><strong>Registered Subjects</strong></h5>
                <table class="table table-responsive-sm table-bordered table-sm" style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Subject Code</th>
                            <th>Subject Name</th>
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
                            <td>{{ $module->module->subject_code ?? 'N/A' }}</td>
                            <td>{{ $module->module->subject_name ?? 'N/A' }}</td>
                            <td>{{ $module->subject_symbol ?? 'N/A' }}</td>
                            <td>{{ $module->system ?? 'N/A' }}</td>
                            <td>N${{ number_format($module->amount ?? 0, 2, '.', ',') }}</td>
                            <td><span class="badge badge-success">{{ $module->registration_status }}</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr style="background-color: #f8f9fa; font-weight: bold;">
                            <td colspan="5" class="text-right"><strong>Total Amount:</strong></td>
                            <td><strong>N${{ number_format($registered_modules->sum('amount'), 2, '.', ',') }}</strong></td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
                @endif

                <div class="mt-4 p-3" style="background-color: #f8f9fa; border-left: 4px solid #007bff;">
                    <h6><strong>Declaration</strong></h6>
                    <p>
                        This is to certify that <strong>{{ $student->student_names }} {{ $student->surname }}</strong> 
                        (Student Number: <strong>{{ $student->student_number }}</strong>) is officially registered 
                        at {{ $company->company_name ?? 'this institution' }} for the academic year 
                        <strong>{{ $currentYear->academic_year }}</strong>.
                    </p>
                    <p class="mb-0">
                        The student is enrolled for {{ $registered_modules->count() }} subject(s) with a total 
                        registration fee of <strong>N${{ number_format($registered_modules->sum('amount'), 2, '.', ',') }}</strong>.
                    </p>
                </div>

                <div class="text-center mt-4" style="font-size: 12px; color: #666;">
                    <p>This document was generated on {{ \Carbon\Carbon::now()->format('d M Y \a\t H:i') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
