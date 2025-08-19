<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admission Letter - {{$student->student_number2}}</title>
    <style>
        body {
            font-family: 'Times New Roman', serif;
            margin: 0;
            padding: 40px;
            line-height: 1.6;
            color: #333;
        }
        
        .letterhead {
            text-align: center;
            margin-bottom: 40px;
            border-bottom: 3px solid #667eea;
            padding-bottom: 20px;
        }
        
        .institution-name {
            font-size: 24px;
            font-weight: bold;
            color: #667eea;
            margin-bottom: 5px;
        }
        
        .institution-subtitle {
            font-size: 16px;
            color: #666;
            margin-bottom: 10px;
        }
        
        .letter-title {
            font-size: 20px;
            font-weight: bold;
            text-align: center;
            margin: 30px 0;
            color: #333;
            text-decoration: underline;
        }
        
        .date-ref {
            text-align: right;
            margin-bottom: 30px;
            font-size: 14px;
        }
        
        .student-details {
            margin-bottom: 30px;
        }
        
        .student-details p {
            margin: 5px 0;
        }
        
        .letter-body {
            text-align: justify;
            margin-bottom: 40px;
        }
        
        .letter-body p {
            margin-bottom: 15px;
        }
        
        .congratulations {
            background-color: #f8f9ff;
            border-left: 4px solid #667eea;
            padding: 15px;
            margin: 20px 0;
            font-weight: bold;
        }
        
        .signature-section {
            margin-top: 60px;
        }
        
        .signature-line {
            border-bottom: 1px solid #333;
            width: 250px;
            margin: 40px 0 10px 0;
        }
        
        .signature-title {
            font-weight: bold;
        }
        
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #666;
            border-top: 1px solid #eee;
            padding-top: 20px;
        }
        
        .important-note {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
        }
        
        .important-note strong {
            color: #856404;
        }
    </style>
</head>
<body>
    <div class="letterhead">
        <div class="institution-name">EDUCIMS TUTORIALS SYSTEM</div>
        <div class="institution-subtitle">Excellence in Education</div>
        <div class="institution-subtitle">Admissions Office</div>
    </div>
    
    <div class="date-ref">
        <p><strong>Date:</strong> {{ \Carbon\Carbon::now()->format('F d, Y') }}</p>
        <p><strong>Reference:</strong> ADM/{{ date('Y') }}/{{ $student->student_number2 }}</p>
    </div>
    
    <div class="student-details">
        <p><strong>{{ $student->student_names }} {{ $student->surname }}</strong></p>
        @if($student->contact_email)
        <p>{{ $student->contact_email }}</p>
        @endif
        @if($student->contact_number)
        <p>{{ $student->contact_number }}</p>
        @endif
    </div>
    
    <div class="letter-title">LETTER OF ADMISSION</div>
    
    <div class="letter-body">
        <p>Dear {{ $student->student_names }} {{ $student->surname }},</p>
        
        <div class="congratulations">
            CONGRATULATIONS! We are pleased to inform you that you have been granted FULL ADMISSION to EDUCIMS TUTORIALS SYSTEM.
        </div>
        
        <p>Following a thorough review of your application and academic credentials, the Admissions Committee has approved your enrollment for the current academic year {{ date('Y') }}.</p>
        
        <p><strong>Student Details:</strong></p>
        <ul>
            <li><strong>Student Number:</strong> {{ $student->student_number2 }}</li>
            <li><strong>Full Name:</strong> {{ $student->student_names }} {{ $student->surname }}</li>
            @if($student->id_number)
            <li><strong>ID Number:</strong> {{ $student->id_number }}</li>
            @endif
            @if($student->date_of_birth)
            <li><strong>Date of Birth:</strong> {{ \Carbon\Carbon::parse($student->date_of_birth)->format('F d, Y') }}</li>
            @endif
            <li><strong>Admission Status:</strong> Full Admission</li>
            <li><strong>Admission Date:</strong> {{ \Carbon\Carbon::parse($student->status_date)->format('F d, Y') }}</li>
        </ul>
        
        <div class="important-note">
            <strong>Important:</strong> This letter serves as official confirmation of your admission. Please retain this document for your records as it may be required for various administrative purposes.
        </div>
        
        <p><strong>Next Steps:</strong></p>
        <ol>
            <li>Complete your course registration within 30 days of receiving this letter</li>
            <li>Submit all required documentation to the Student Affairs Office</li>
            <li>Attend the mandatory orientation session (details will be communicated separately)</li>
            <li>Ensure all outstanding fees are settled before the commencement of classes</li>
        </ol>
        
        <p>We look forward to welcoming you to our academic community and supporting you throughout your educational journey with us.</p>
        
        <p>Should you have any questions regarding your admission or require further assistance, please do not hesitate to contact our Admissions Office.</p>
        
        <p>Once again, congratulations on your admission, and we wish you every success in your studies.</p>
        
        <p>Yours sincerely,</p>
    </div>
    
    <div class="signature-section">
        <div class="signature-line"></div>
        <div class="signature-title">Admissions Officer</div>
        <p>EDUCIMS TUTORIALS SYSTEM</p>
        <p>Date: {{ \Carbon\Carbon::now()->format('F d, Y') }}</p>
    </div>
    
    <div class="footer">
        <p>This is an official document generated by the EDUCIMS TUTORIALS SYSTEM</p>
        <p>For verification purposes, please contact the Admissions Office</p>
        <p>Generated on: {{ \Carbon\Carbon::now()->format('F d, Y \a\t g:i A') }}</p>
    </div>
</body>
</html>
