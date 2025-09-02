@extends('layouts.student-portal')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white;">
                    <h4 class="mb-0"><i class="fas fa-user-graduate"></i> Complete Your Student Information</h4>
                    <small>Step 2 of 5 - Please fill in all required information</small>
                </div>
                
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('online-application.store-student-info') }}" method="POST">
                        @csrf
                        
                        <!-- Student Information Section -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5><i class="fas fa-user"></i> Student Information</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th style="background-color: rgba(227, 227, 227, 0.5); width: 30%;">Student Number</th>
                                            <td>
                                                <input type="text" class="form-control" value="Auto-generated after submission" readonly style="background-color: #f8f9fa; color: #6c757d;">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="background-color: rgba(227, 227, 227, 0.5);">Student Names <span class="text-danger">*</span></th>
                                            <td>
                                                <input type="text" name="student_names" class="form-control" placeholder="Student names" value="{{ old('student_names', $student->student_names ?? '') }}" required>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="background-color: rgba(227, 227, 227, 0.5);">Surname <span class="text-danger">*</span></th>
                                            <td>
                                                <input type="text" name="surname" class="form-control" placeholder="Surname" value="{{ old('surname', $student->surname ?? '') }}" required>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="background-color: rgba(227, 227, 227, 0.5);">Initials <span class="text-danger">*</span></th>
                                            <td>
                                                <input type="text" name="initials" class="form-control" placeholder="Initials" value="{{ old('initials', $student->initials ?? '') }}" required>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="background-color: rgba(227, 227, 227, 0.5);">Center <span class="text-danger">*</span></th>
                                            <td>
                                                <select name="center_id" class="form-control" required>
                                                    <option value="">Select Center</option>
                                                    @foreach($centers as $id => $name)
                                                        <option value="{{ $id }}" {{ old('center_id', $student->center_id ?? '') == $id ? 'selected' : '' }}>{{ $name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="background-color: rgba(227, 227, 227, 0.5);">Email</th>
                                            <td>
                                                <input type="email" name="contact_email" class="form-control" placeholder="Email" value="{{ old('contact_email', $student->contact_email ?? '') }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="background-color: rgba(227, 227, 227, 0.5);">Contact Number <span class="text-danger">*</span></th>
                                            <td>
                                                <input type="text" name="contact_number" class="form-control" placeholder="Contact number" value="{{ old('contact_number', $student->contact_number ?? '') }}" required>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="background-color: rgba(227, 227, 227, 0.5);">Gender <span class="text-danger">*</span></th>
                                            <td>
                                                <select name="gender" class="form-control" required>
                                                    <option value="">Select Gender</option>
                                                    <option value="Male" {{ old('gender', $student->gender ?? '') == 'Male' ? 'selected' : '' }}>Male</option>
                                                    <option value="Female" {{ old('gender', $student->gender ?? '') == 'Female' ? 'selected' : '' }}>Female</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="background-color: rgba(227, 227, 227, 0.5);">Date of Birth</th>
                                            <td>
                                                <input type="date" name="date_of_birth" class="form-control" value="{{ old('date_of_birth', $student->date_of_birth ?? '') }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="background-color: rgba(227, 227, 227, 0.5);">Birth Certificate</th>
                                            <td>
                                                <input type="text" name="birth_certificate" class="form-control" placeholder="Birth certificate number" value="{{ old('birth_certificate', $student->birth_certificate ?? '') }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="background-color: rgba(227, 227, 227, 0.5);">ID Number</th>
                                            <td>
                                                <input type="number" name="id_number" class="form-control" placeholder="ID number" value="{{ old('id_number', $student->id_number ?? '') }}">
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Guardian Information Section -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5><i class="fas fa-users"></i> Guardian Information</h5>
                            </div>
                            <div class="card-body">
                                <h6 class="text-primary">Primary Guardian <span class="text-danger">*</span></h6>
                                <div class="table-responsive mb-4">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th style="background-color: rgba(227, 227, 227, 0.5); width: 30%;">Name <span class="text-danger">*</span></th>
                                            <td>
                                                @php
                                                    $guardianNames = $student && $student->guardian_names ? json_decode($student->guardian_names, true) : [];
                                                @endphp
                                                <input type="text" name="guardian_names[]" class="form-control" placeholder="Guardian name" value="{{ old('guardian_names.0', $guardianNames[0] ?? '') }}" required>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="background-color: rgba(227, 227, 227, 0.5);">Surname <span class="text-danger">*</span></th>
                                            <td>
                                                @php
                                                    $guardianSurnames = $student && $student->guardian_surname ? json_decode($student->guardian_surname, true) : [];
                                                @endphp
                                                <input type="text" name="guardian_surname[]" class="form-control" placeholder="Surname" value="{{ old('guardian_surname.0', $guardianSurnames[0] ?? '') }}" required>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="background-color: rgba(227, 227, 227, 0.5);">Relationship <span class="text-danger">*</span></th>
                                            <td>
                                                @php
                                                    $relationships = $student && $student->relationship ? json_decode($student->relationship, true) : [];
                                                    $currentRelationship = old('relationship.0', $relationships[0] ?? '');
                                                @endphp
                                                <select name="relationship[]" class="form-control" required>
                                                    <option value="">Select Relationship</option>
                                                    <option value="Father" {{ $currentRelationship == 'Father' ? 'selected' : '' }}>Father</option>
                                                    <option value="Mother" {{ $currentRelationship == 'Mother' ? 'selected' : '' }}>Mother</option>
                                                    <option value="Cousin" {{ $currentRelationship == 'Cousin' ? 'selected' : '' }}>Cousin</option>
                                                    <option value="Aunt" {{ $currentRelationship == 'Aunt' ? 'selected' : '' }}>Aunt</option>
                                                    <option value="Uncle" {{ $currentRelationship == 'Uncle' ? 'selected' : '' }}>Uncle</option>
                                                    <option value="Sister" {{ $currentRelationship == 'Sister' ? 'selected' : '' }}>Sister</option>
                                                    <option value="Brother" {{ $currentRelationship == 'Brother' ? 'selected' : '' }}>Brother</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="background-color: rgba(227, 227, 227, 0.5);">Contact Number <span class="text-danger">*</span></th>
                                            <td>
                                                @php
                                                    $guardianContacts = $student && $student->guardian_contact_number ? json_decode($student->guardian_contact_number, true) : [];
                                                @endphp
                                                <input type="text" name="guardian_contact_number[]" class="form-control" placeholder="Contact number" value="{{ old('guardian_contact_number.0', $guardianContacts[0] ?? '') }}" required>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="background-color: rgba(227, 227, 227, 0.5);">Contact Email</th>
                                            <td>
                                                @php
                                                    $guardianEmails = $student && $student->guardian_contact_email ? json_decode($student->guardian_contact_email, true) : [];
                                                @endphp
                                                <input type="email" name="guardian_contact_email[]" class="form-control" placeholder="Contact email" value="{{ old('guardian_contact_email.0', $guardianEmails[0] ?? '') }}">
                                            </td>
                                        </tr>
                                    </table>
                                </div>

                                <h6 class="text-secondary">Secondary Guardian (Optional)</h6>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th style="background-color: rgba(227, 227, 227, 0.5); width: 30%;">Name</th>
                                            <td>
                                                <input type="text" name="guardian_names[]" class="form-control" placeholder="Guardian name" value="{{ old('guardian_names.1', $guardianNames[1] ?? '') }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="background-color: rgba(227, 227, 227, 0.5);">Surname</th>
                                            <td>
                                                <input type="text" name="guardian_surname[]" class="form-control" placeholder="Surname" value="{{ old('guardian_surname.1', $guardianSurnames[1] ?? '') }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="background-color: rgba(227, 227, 227, 0.5);">Relationship</th>
                                            <td>
                                                @php
                                                    $currentRelationship2 = old('relationship.1', $relationships[1] ?? '');
                                                @endphp
                                                <select name="relationship[]" class="form-control">
                                                    <option value="">Select Relationship</option>
                                                    <option value="Father" {{ $currentRelationship2 == 'Father' ? 'selected' : '' }}>Father</option>
                                                    <option value="Mother" {{ $currentRelationship2 == 'Mother' ? 'selected' : '' }}>Mother</option>
                                                    <option value="Cousin" {{ $currentRelationship2 == 'Cousin' ? 'selected' : '' }}>Cousin</option>
                                                    <option value="Aunt" {{ $currentRelationship2 == 'Aunt' ? 'selected' : '' }}>Aunt</option>
                                                    <option value="Uncle" {{ $currentRelationship2 == 'Uncle' ? 'selected' : '' }}>Uncle</option>
                                                    <option value="Sister" {{ $currentRelationship2 == 'Sister' ? 'selected' : '' }}>Sister</option>
                                                    <option value="Brother" {{ $currentRelationship2 == 'Brother' ? 'selected' : '' }}>Brother</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="background-color: rgba(227, 227, 227, 0.5);">Contact Number</th>
                                            <td>
                                                <input type="text" name="guardian_contact_number[]" class="form-control" placeholder="Contact number" value="{{ old('guardian_contact_number.1', $guardianContacts[1] ?? '') }}">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="background-color: rgba(227, 227, 227, 0.5);">Contact Email</th>
                                            <td>
                                                <input type="email" name="guardian_contact_email[]" class="form-control" placeholder="Contact email" value="{{ old('guardian_contact_email.1', $guardianEmails[1] ?? '') }}">
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Navigation Buttons -->
                        <div class="card">
                            <div class="card-footer text-center">
                                <button type="submit" class="btn btn-lg mr-3" style="background: linear-gradient(135deg, #6f42c1 0%, #007bff 100%); color: white; border: none; border-radius: 6px; padding: 0.75rem 2rem;">
                                    <i class="fas fa-arrow-right"></i> Continue to Subject Selection
                                </button>
                                <a href="{{ route('login') }}" class="btn btn-secondary btn-lg" style="padding: 0.75rem 2rem;">
                                    <i class="fas fa-times"></i> Cancel
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
