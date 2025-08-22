<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student ID Card - {{ $student->student_names }} {{ $student->surname }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background: #f5f5f5;
            padding: 20px;
        }

        .print-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .student-card {
            width: 600px;
            height: 380px;
            background: linear-gradient(135deg, #1e88e5 0%, #1976d2 100%);
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            overflow: hidden;
            position: relative;
            font-family: 'Arial', sans-serif;
        }

        .card-header-section {
            background: rgba(255,255,255,0.95);
            padding: 15px 20px;
            border-bottom: 2px solid #1976d2;
        }

        .header-content {
            display: flex;
            align-items: center;
        }

        .school-info {
            display: flex;
            align-items: center;
            width: 100%;
        }

        .school-logo {
            width: 60px;
            height: 60px;
            object-fit: contain;
            margin-right: 15px;
        }

        .logo-placeholder {
            width: 60px;
            height: 60px;
            background: #1976d2;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
            margin-right: 15px;
        }

        .school-details {
            flex: 1;
        }

        .school-name {
            font-size: 18px;
            font-weight: bold;
            color: #1976d2;
            margin: 0;
            text-transform: uppercase;
        }

        .card-type {
            font-size: 14px;
            font-weight: 600;
            color: #333;
            margin: 2px 0;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .academic-year {
            font-size: 12px;
            color: #666;
            margin: 0;
        }

        .card-body-section {
            padding: 20px;
            background: white;
            height: calc(100% - 140px);
        }

        .student-info-row {
            display: flex;
            gap: 20px;
            height: 100%;
        }

        .student-photo {
            width: 120px;
            flex-shrink: 0;
        }

        .photo-img {
            width: 120px;
            height: 150px;
            object-fit: cover;
            border-radius: 8px;
            border: 2px solid #e0e0e0;
        }

        .photo-placeholder {
            width: 120px;
            height: 150px;
            background: #f5f5f5;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #999;
            font-size: 12px;
        }

        .photo-placeholder i {
            font-size: 40px;
            margin-bottom: 10px;
        }

        .student-details {
            flex: 1;
            padding-left: 10px;
        }

        .detail-row {
            margin-bottom: 12px;
            display: flex;
            align-items: flex-start;
        }

        .label {
            font-weight: 600;
            color: #555;
            min-width: 100px;
            font-size: 14px;
        }

        .value {
            color: #333;
            font-size: 14px;
            font-weight: 500;
            flex: 1;
        }

        .qr-code-section {
            width: 100px;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding-top: 10px;
        }

        /* QR Code Styles */
        .qr-code {
            width: 80px;
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #1976d2;
            border-radius: 8px;
            background: white;
            padding: 4px;
        }

        .qr-code canvas {
            border-radius: 4px;
        }

        .qr-label {
            font-size: 10px;
            color: #666;
            text-align: center;
            margin: 5px 0 0 0;
            font-weight: 500;
        }

        .qr-fallback {
            font-size: 10px;
            font-weight: bold;
            color: #1976d2;
            text-align: center;
            line-height: 1.2;
        }

        .card-footer-section {
            background: rgba(255,255,255,0.9);
            padding: 8px 20px;
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
        }

        .footer-text {
            font-size: 10px;
            color: #666;
            text-align: center;
            margin: 0;
            line-height: 1.3;
        }

        .print-actions {
            text-align: center;
            margin-bottom: 20px;
        }

        .btn {
            padding: 10px 20px;
            margin: 0 5px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
        }

        .btn-primary {
            background: #007bff;
            color: white;
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
        }

        @media print {
            body {
                background: white;
                padding: 0;
            }

            .print-actions {
                display: none;
            }

            .print-container {
                min-height: auto;
                padding: 0;
            }

            .student-card {
                width: 85.6mm;
                height: 54mm;
                transform: scale(0.8);
                margin: 0;
                box-shadow: none;
            }
            
            .card-header-section {
                padding: 8px 12px;
            }
            
            .school-name {
                font-size: 12px;
            }
            
            .card-type {
                font-size: 9px;
            }
            
            .academic-year {
                font-size: 8px;
            }
            
            .card-body-section {
                padding: 12px;
            }
            
            .photo-img, .photo-placeholder {
                width: 80px;
                height: 100px;
            }
            
            .label, .value {
                font-size: 9px;
            }
            
            .detail-row {
                margin-bottom: 6px;
            }
            
            .qr-code {
                width: 50px;
                height: 50px;
                padding: 2px;
            }
            
            .qr-label {
                font-size: 7px;
            }
            
            .footer-text {
                font-size: 7px;
            }
        }
    </style>
</head>
<body>
    <div class="print-actions">
        <button onclick="window.print()" class="btn btn-primary">
            <i class="fas fa-print"></i> Print Card
        </button>
        <a href="{{ route('student-cards.generate', $student->id) }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Card
        </a>
    </div>

    <div class="print-container">
        <div class="student-card">
            <!-- Card Header -->
            <div class="card-header-section">
                <div class="header-content">
                    <div class="school-info">
                        @if($company && $company->logo)
                            <img src="{{ asset('storage/' . $company->logo) }}" alt="School Logo" class="school-logo">
                        @else
                            <div class="logo-placeholder">
                                <i class="fas fa-graduation-cap"></i>
                            </div>
                        @endif
                        <div class="school-details">
                            <h3 class="school-name">{{ $company->company_name ?? 'EDUCATIONAL INSTITUTION' }}</h3>
                            <p class="card-type">STUDENT IDENTIFICATION CARD</p>
                            <p class="academic-year">{{ date('Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Body -->
            <div class="card-body-section">
                <div class="student-info-row">
                    <!-- Student Photo -->
                    <div class="student-photo">
                        @if($student->photo)
                            <img src="{{ asset('storage/' . $student->photo) }}" alt="Student Photo" class="photo-img">
                        @else
                            <div class="photo-placeholder">
                                <i class="fas fa-user"></i>
                                <span>No Photo</span>
                            </div>
                        @endif
                    </div>

                    <!-- Student Details -->
                    <div class="student-details">
                        <div class="detail-row">
                            <span class="label">Name:</span>
                            <span class="value">{{ $student->student_names }} {{ $student->surname }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="label">Student #:</span>
                            <span class="value">{{ $student->student_number }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="label">Allocated #:</span>
                            <span class="value">{{ $student->student_number2 ?? 'N/A' }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="label">Centre:</span>
                            <span class="value">
                                @if($student->center)
                                    {{ $student->center->center_name }}
                                @else
                                    Not Available
                                @endif
                            </span>
                        </div>
                        <div class="detail-row">
                            <span class="label">Intake:</span>
                            <span class="value">
                                @if($student->currentRegistration)
                                    {{ $student->currentRegistration->intake ?? 'Current Intake' }}
                                @else
                                    Current Intake
                                @endif
                            </span>
                        </div>
                        <div class="detail-row">
                            <span class="label">Study Mode:</span>
                            <span class="value">
                                @if($student->currentRegistration)
                                    {{ $student->currentRegistration->study_mode ?? 'Full Time' }}
                                @else
                                    Full Time
                                @endif
                            </span>
                        </div>
                    </div>

                    <!-- QR Code -->
                    <div class="qr-code-section">
                        <div class="qr-code">
                            <div id="qrcode"></div>
                        </div>
                        <p class="qr-label">Scan for Verification</p>
                    </div>
                </div>
            </div>

            <!-- Card Footer -->
            <div class="card-footer-section">
                <p class="footer-text">This card remains the property of the institution. If found, kindly return it to the nearest campus.</p>
            </div>
        </div>
    </div>

    <!-- QR Code Library -->
    <script src="https://cdn.jsdelivr.net/npm/qrcode@1.5.3/build/qrcode.min.js" onload="generateQRCode()" onerror="handleQRError()"></script>
    <script>
    function generateQRCode() {
        // Generate QR code with student verification data
        const studentData = {
            name: "{{ $student->student_names }} {{ $student->surname }}",
            studentNumber: "{{ $student->student_number }}",
            allocatedNumber: "{{ $student->student_number2 ?? 'N/A' }}",
            centre: "{{ $student->center ? $student->center->center_name : 'Not Available' }}",
            institution: "{{ $company->company_name ?? 'EDUCATIONAL INSTITUTION' }}",
            year: "{{ date('Y') }}",
            verificationUrl: "{{ url('/verify-student/' . $student->id) }}"
        };
        
        const qrData = JSON.stringify(studentData);
        
        QRCode.toCanvas(document.getElementById('qrcode'), qrData, {
            width: 80,
            height: 80,
            margin: 1,
            color: {
                dark: '#1976d2',
                light: '#ffffff'
            },
            errorCorrectionLevel: 'M'
        }, function (error) {
            if (error) {
                console.error('QR Code generation failed:', error);
                document.getElementById('qrcode').innerHTML = '<div class="qr-fallback">QR<br>CODE</div>';
            }
        });
    }

    function handleQRError() {
        console.error('QRCode library failed to load');
        document.getElementById('qrcode').innerHTML = '<div class="qr-fallback">QR<br>CODE</div>';
    }

    // Fallback if DOM is already loaded
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof QRCode !== 'undefined') {
            generateQRCode();
        } else {
            // Try loading QR code after a delay
            setTimeout(function() {
                if (typeof QRCode !== 'undefined') {
                    generateQRCode();
                } else {
                    handleQRError();
                }
            }, 1000);
        }
    });
    </script>
</body>
</html>
