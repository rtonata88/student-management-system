<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Application Acknowledgement Letter</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background: white;
            color: #333;
        }
        .header {
            display: table;
            width: 100%;
            margin-bottom: 30px;
        }
        .company-info {
            display: table-cell;
            vertical-align: top;
            width: 60%;
        }
        .company-logo {
            display: table-cell;
            vertical-align: top;
            width: 40%;
            text-align: right;
        }
        .company-name {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
        }
        .company-address {
            font-size: 12px;
            line-height: 1.4;
            color: #666;
        }
        .logo {
            max-width: 120px;
            max-height: 80px;
        }
        .divider {
            border-top: 2px solid #333;
            margin: 20px 0;
        }
        .date {
            text-align: right;
            margin-bottom: 30px;
            font-size: 12px;
        }
        .student-details {
            margin-bottom: 30px;
        }
        .reference {
            margin-bottom: 20px;
            font-weight: bold;
        }
        .letter-content {
            line-height: 1.6;
            margin-bottom: 30px;
        }
        .letter-content h3 {
            color: #333;
            margin-bottom: 15px;
        }
        .subjects-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .subjects-table th,
        .subjects-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .subjects-table th {
            background-color: #f5f5f5;
            font-weight: bold;
        }
        .signature-section {
            margin-top: 50px;
        }
        .signature-line {
            border-bottom: 1px solid #333;
            width: 200px;
            margin-bottom: 5px;
        }
        .stamp-box {
            border: 1px solid #333;
            width: 150px;
            height: 100px;
            float: right;
            margin-top: -50px;
            text-align: center;
            padding-top: 40px;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="company-info">
            <div class="company-name">{{ $company->company_name ?? config('app.name', 'Educims') }}</div>
            <div class="company-address">
                {{ $company->address1 ?? 'Tutorial Excellence Center' }}<br>
                {{ $company->address2 ?? '123 Education Street' }}<br>
                {{ $company->address3 ?? 'Academic City, AC 12345' }}<br>
                Phone: {{ $company->contact_number ?? '(011) 123-4567' }}<br>
                Email: {{ $company->email ?? 'info@educims.com' }}
            </div>
        </div>
        <div class="company-logo">
            <img src="{{ public_path('assets/Logo.png') }}" alt="Logo" class="logo">
        </div>
    </div>

    <div class="divider"></div>

    <div class="date">
        Date: {{ now()->format('d F Y') }}
    </div>

    <div class="student-details">
        <strong>{{ $student->student_names ?? $application->user->name }} {{ $student->surname ?? '' }}</strong><br>
        {{ $student->contact_email ?? $application->user->email }}<br>
        {{ $student->contact_number ?? 'Contact not provided' }}
    </div>


    <div class="letter-content">
        <h3 style="text-align: center;">APPLICATION ACKNOWLEDGEMENT LETTER</h3>
        
        <p>Dear {{ $student->student_names ?? $application->user->name }},</p>
        
        <p>We acknowledge receipt of your online application submitted on {{ $application->submitted_at->format('d F Y') }}. 
        Your application number is <strong>{{ $application->application_number }}</strong>.</p>
        
        <p>Your application includes the following subjects:</p>
        
        @if($subjects->isNotEmpty())
            <table class="subjects-table">
                <thead>
                    <tr>
                        <th>Subject Name</th>
                        <th>Subject Code</th>
                        <th>Subject Fee</th>
                    </tr>
                </thead>
                <tbody>
                    @php $totalFee = 0; @endphp
                    @foreach($subjects as $subject)
                        <tr>
                            <td>{{ $subject->subject_name }}</td>
                            <td>{{ $subject->subject_code }}</td>
                            <td>R{{ number_format($subject->subject_fees, 2) }}</td>
                        </tr>
                        @php $totalFee += $subject->subject_fees; @endphp
                    @endforeach
                    <tr style="font-weight: bold; background-color: #f5f5f5;">
                        <td colspan="2">Total Fee</td>
                        <td>R{{ number_format($totalFee, 2) }}</td>
                    </tr>
                </tbody>
            </table>
        @endif
        
        <p><strong>Application Status:</strong> Your application is currently under review by our admissions team.</p>
        
        <p><strong>Next Steps:</strong></p>
        <ul>
            <li>Your application will be reviewed within reasonable time</li>
            <li>You will receive an email notification once your application status changes</li>
            <li>If approved, you will receive enrollment instructions and payment details</li>
            <li>You can check your application status anytime through your student portal</li>
        </ul>
        
        <p><strong>Important Notes:</strong></p>
        <ul>
            <li>Please ensure all required documents have been uploaded</li>
            <li>Keep this acknowledgement letter for your records</li>
            <li>Contact us if you need to make any changes to your application</li>
        </ul>
        
        <p>If you have any questions or concerns, please don't hesitate to contact our admissions office.</p>
        
        <p>Thank you for choosing {{ $company->company_name ?? config('app.name', 'Educims') }} for your educational journey.</p>
        
        <p>Yours sincerely,</p>
    </div>

    <div class="signature-section">
        <div class="signature-line"></div>
        <p><strong>Admissions Officer</strong><br>
        {{ $company->company_name ?? config('app.name', 'Educims') }}</p>
        
        <div class="stamp-box">
            OFFICIAL STAMP
        </div>
    </div>
</body>
</html>
