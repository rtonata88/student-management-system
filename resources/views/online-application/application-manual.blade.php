@extends('layouts.print')

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
                                <strong>F: </strong>{{$company->fax_number}} <br>
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
                <div class="text-center mb-4">
                    <h2 style="color: #6f42c1; font-weight: bold;">Online Application Manual</h2>
                    <h4 style="color: #007bff;">Step-by-Step Guide to Apply Online</h4>
                    <hr style="border-top: 2px solid #6f42c1; width: 50%;">
                </div>

                <div class="mb-4">
                    <h5 style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; padding: 10px; border-radius: 5px;">
                        <i class="fas fa-user-plus"></i> Step 1: Create Your Account
                    </h5>
                    <div class="ml-3">
                        <p><strong>1.1</strong> Visit the online application signup page</p>
                        <p><strong>1.2</strong> Fill in your personal details:</p>
                        <ul>
                            <li>First Names (required)</li>
                            <li>Surname (required)</li>
                            <li>Email Address (required) - Must be active and unique</li>
                            <li>Password (required) - Minimum 6 characters</li>
                            <li>Confirm Password (required)</li>
                        </ul>
                        <p><strong>1.3</strong> Click "Create Account" to register</p>
                        <p><strong>1.4</strong> You will receive a confirmation and be redirected to login</p>
                        <div class="alert alert-info">
                            <strong>Important:</strong> Ensure you provide an active email address as your admission letter and all official communications will be sent there.
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <h5 style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; padding: 10px; border-radius: 5px;">
                        <i class="fas fa-sign-in-alt"></i> Step 2: Login to Your Account
                    </h5>
                    <div class="ml-3">
                        <p><strong>2.1</strong> Use your email and password to login</p>
                        <p><strong>2.2</strong> You will be taken to the student portal dashboard</p>
                    </div>
                </div>

                <div class="mb-4">
                    <h5 style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; padding: 10px; border-radius: 5px;">
                        <i class="fas fa-user"></i> Step 3: Complete Student Information
                    </h5>
                    <div class="ml-3">
                        <p><strong>3.1</strong> Click on "Student Information" or navigate to the student info form</p>
                        <p><strong>3.2</strong> Your student number will be automatically generated and displayed</p>
                        <p><strong>3.3</strong> Fill in all required fields:</p>
                        <ul>
                            <li>Student Names (required)</li>
                            <li>Surname (required)</li>
                            <li>Initials (required)</li>
                            <li>Allocated Number (auto-filled, read-only)</li>
                            <li>Study Centre (required) - Choose from dropdown</li>
                            <li>Contact Email</li>
                            <li>Contact Number (required) - Format: +264 followed by 9 digits</li>
                            <li>Gender (required)</li>
                            <li>Date of Birth (required) - Format: DDMMYYYY or use calendar picker</li>
                            <li>Birth Certificate Number</li>
                            <li>ID Number</li>
                            <li>Student Photo (required) - Upload image file</li>
                        </ul>
                        <p><strong>3.4</strong> Add Guardian Information (if applicable):</p>
                        <ul>
                            <li>Guardian Names</li>
                            <li>Guardian Surname</li>
                            <li>Relationship</li>
                            <li>Guardian Contact Number - Format: +264 followed by 9 digits</li>
                            <li>Guardian Email</li>
                        </ul>
                        <p><strong>3.5</strong> Click "Save & Continue" to proceed</p>
                        <div class="alert alert-warning">
                            <strong>Note:</strong> Contact numbers must start with +264 and be followed by exactly 9 digits (no leading zero).
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <h5 style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; padding: 10px; border-radius: 5px;">
                        <i class="fas fa-book"></i> Step 4: Select Your Subjects
                    </h5>
                    <div class="ml-3">
                        <p><strong>4.1</strong> Navigate to the subject selection page</p>
                        <p><strong>4.2</strong> Browse available subjects/modules</p>
                        <p><strong>4.3</strong> Select the subjects you wish to study</p>
                        <p><strong>4.4</strong> Review your selections and associated fees</p>
                        <p><strong>4.5</strong> Click "Save & Continue" to proceed</p>
                    </div>
                </div>

                <div class="mb-4">
                    <h5 style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; padding: 10px; border-radius: 5px;">
                        <i class="fas fa-file-upload"></i> Step 5: Upload Required Documents
                    </h5>
                    <div class="ml-3">
                        <p><strong>5.1</strong> Navigate to the document upload page</p>
                        <p><strong>5.2</strong> Upload required documents such as:</p>
                        <ul>
                            <li>Academic transcripts</li>
                            <li>ID copy</li>
                            <li>Birth certificate</li>
                            <li>Any other supporting documents</li>
                        </ul>
                        <p><strong>5.3</strong> Provide document names/descriptions</p>
                        <p><strong>5.4</strong> Ensure all files are in acceptable formats (PDF, DOC, DOCX, JPG, JPEG, PNG)</p>
                        <p><strong>5.5</strong> Click "Save & Continue" to proceed</p>
                        <div class="alert alert-info">
                            <strong>File Requirements:</strong> Maximum file size is 10MB. Accepted formats: PDF, DOC, DOCX, JPG, JPEG, PNG.
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <h5 style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; padding: 10px; border-radius: 5px;">
                        <i class="fas fa-clipboard-check"></i> Step 6: Review Your Application
                    </h5>
                    <div class="ml-3">
                        <p><strong>6.1</strong> Review all sections of your application:</p>
                        <ul>
                            <li>Student Information</li>
                            <li>Selected Subjects</li>
                            <li>Uploaded Documents</li>
                        </ul>
                        <p><strong>6.2</strong> Verify all information is correct and complete</p>
                        <p><strong>6.3</strong> Make any necessary edits by clicking the "Edit" buttons</p>
                        <p><strong>6.4</strong> Read and accept the declaration</p>
                        <p><strong>6.5</strong> Click "Submit Application" to finalize</p>
                        <div class="alert alert-danger">
                            <strong>Important:</strong> Once submitted, you cannot edit your application. Please review carefully before submitting.
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <h5 style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; padding: 10px; border-radius: 5px;">
                        <i class="fas fa-check-circle"></i> Step 7: Application Submitted
                    </h5>
                    <div class="ml-3">
                        <p><strong>7.1</strong> You will receive a confirmation message</p>
                        <p><strong>7.2</strong> Your application status will change to "Under Review"</p>
                        <p><strong>7.3</strong> You will receive email notifications about your application status</p>
                        <p><strong>7.4</strong> Check your student portal regularly for updates</p>
                    </div>
                </div>

                <div class="mb-4">
                    <h5 style="background: linear-gradient(135deg, #dc3545 0%, #fd7e14 100%); color: white; padding: 10px; border-radius: 5px;">
                        <i class="fas fa-exclamation-triangle"></i> Important Notes
                    </h5>
                    <div class="ml-3">
                        <ul>
                            <li>Ensure all information provided is accurate and truthful</li>
                            <li>Keep your login credentials secure</li>
                            <li>Check your email regularly for communications</li>
                            <li>Contact support if you encounter any technical issues</li>
                            <li>Date format for Date of Birth: DDMMYYYY (e.g., 04092025 for September 4, 2025)</li>
                            <li>Phone number format: +264 followed by 9 digits (e.g., +264812345678)</li>
                            <li>Student photos must be clear and professional</li>
                            <li>All required fields must be completed before submission</li>
                        </ul>
                    </div>
                </div>

                <div class="mb-4">
                    <h5 style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white; padding: 10px; border-radius: 5px;">
                        <i class="fas fa-phone"></i> Need Help?
                    </h5>
                    <div class="ml-3">
                        <p>If you need assistance with your online application, please contact:</p>
                        <ul>
                            <li><strong>Phone:</strong> {{$company->contact_number}}</li>
                            <li><strong>Email:</strong> {{$company->email}}</li>
                            <li><strong>Address:</strong> {{$company->address1}}, {{$company->address2}}</li>
                        </ul>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <hr style="border-top: 2px solid #6f42c1;">
                    <p style="color: #6c757d; font-style: italic;">
                        Generated on {{ date('d F Y') }} | {{$company->company_name}}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
