@extends('layouts.app')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{route('employees.index')}}">Human Resources</a></li>
        <li class="breadcrumb-item"><a href="{{route('employees.index')}}">Employee Bio</a></li>
        <li class="breadcrumb-item">{{ $user->employeeProfile ? 'Edit' : 'Create' }} Profile</li>
        <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">{{ $user->employeeProfile ? 'Update' : 'Create' }} Employee Profile: {{ $user->name }}</h5>
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

                <form method="POST" action="{{route('employees.update', $user->id)}}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <!-- Basic Employment Information -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h6 class="border-bottom pb-2 mb-3"><strong>Employment Information</strong></h6>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="employee_number">Employee Number</label>
                                @if(!$user->employeeProfile && $generatedEmployeeNumber)
                                    <input type="text" class="form-control" id="employee_number" name="employee_number" 
                                           value="{{ old('employee_number', $generatedEmployeeNumber) }}" readonly>
                                    <small class="form-text text-muted">
                                        <i class="fas fa-info-circle"></i> Auto-generated employee number
                                    </small>
                                @else
                                    <input type="text" class="form-control" id="employee_number" name="employee_number" 
                                           value="{{ old('employee_number', $user->employeeProfile->employee_number ?? '') }}">
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="department">Department</label>
                                <select class="form-control" id="department" name="department">
                                    <option value="">Select Department</option>
                                    @foreach($departments as $department)
                                        <option value="{{ $department->name }}" {{ old('department', $user->employeeProfile->department ?? '') == $department->name ? 'selected' : '' }}>
                                            {{ $department->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="position">Position</label>
                                <select class="form-control" id="position" name="position">
                                    <option value="">Select Position</option>
                                    @foreach($designations as $designation)
                                        <option value="{{ $designation->name }}" {{ old('position', $user->employeeProfile->position ?? '') == $designation->name ? 'selected' : '' }}>
                                            {{ $designation->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="employment_type">Employment Type</label>
                                <select class="form-control" id="employment_type" name="employment_type">
                                    <option value="">Select Employment Type</option>
                                    <option value="Full-time" {{ old('employment_type', $user->employeeProfile->employment_type ?? '') == 'Full-time' ? 'selected' : '' }}>Full-time</option>
                                    <option value="Part-time" {{ old('employment_type', $user->employeeProfile->employment_type ?? '') == 'Part-time' ? 'selected' : '' }}>Part-time</option>
                                    <option value="Contract" {{ old('employment_type', $user->employeeProfile->employment_type ?? '') == 'Contract' ? 'selected' : '' }}>Contract</option>
                                    <option value="Temporary" {{ old('employment_type', $user->employeeProfile->employment_type ?? '') == 'Temporary' ? 'selected' : '' }}>Temporary</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="hire_date">Hire Date</label>
                                <input type="date" class="form-control" id="hire_date" name="hire_date" 
                                       value="{{ old('hire_date', $user->employeeProfile && $user->employeeProfile->hire_date ? $user->employeeProfile->hire_date->format('Y-m-d') : '') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="salary">Salary</label>
                                <input type="number" step="0.01" min="0" class="form-control" id="salary" name="salary" 
                                       value="{{ old('salary', $user->employeeProfile->salary ?? '') }}"
                                       pattern="[0-9]+(\.[0-9]{1,2})?" title="Please enter a valid salary amount (numbers only, up to 2 decimal places)">
                            </div>
                        </div>
                    </div>

                    <!-- Personal Information -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h6 class="border-bottom pb-2 mb-3">Personal Information</h6>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="id_number">ID Number</label>
                                <input type="text" class="form-control" id="id_number" name="id_number" 
                                       value="{{ old('id_number', $user->employeeProfile->id_number ?? '') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="passport_number">Passport Number</label>
                                <input type="text" class="form-control" id="passport_number" name="passport_number" 
                                       value="{{ old('passport_number', $user->employeeProfile->passport_number ?? '') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="date_of_birth">Date of Birth</label>
                                <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" 
                                       value="{{ old('date_of_birth', $user->employeeProfile && $user->employeeProfile->date_of_birth ? $user->employeeProfile->date_of_birth->format('Y-m-d') : '') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="gender">Gender</label>
                                <select class="form-control" id="gender" name="gender">
                                    <option value="">Select Gender</option>
                                    <option value="Male" {{ old('gender', $user->employeeProfile->gender ?? '') == 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ old('gender', $user->employeeProfile->gender ?? '') == 'Female' ? 'selected' : '' }}>Female</option>
                                    <option value="Other" {{ old('gender', $user->employeeProfile->gender ?? '') == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="marital_status">Marital Status</label>
                                <select class="form-control" id="marital_status" name="marital_status">
                                    <option value="">Select Marital Status</option>
                                    <option value="Single" {{ old('marital_status', $user->employeeProfile->marital_status ?? '') == 'Single' ? 'selected' : '' }}>Single</option>
                                    <option value="Married" {{ old('marital_status', $user->employeeProfile->marital_status ?? '') == 'Married' ? 'selected' : '' }}>Married</option>
                                    <option value="Divorced" {{ old('marital_status', $user->employeeProfile->marital_status ?? '') == 'Divorced' ? 'selected' : '' }}>Divorced</option>
                                    <option value="Widowed" {{ old('marital_status', $user->employeeProfile->marital_status ?? '') == 'Widowed' ? 'selected' : '' }}>Widowed</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nationality">Nationality</label>
                                <select class="form-control" id="nationality" name="nationality">
                                    <option value="">Select Nationality</option>
                                    <option value="Namibia" {{ old('nationality', $user->employeeProfile->nationality ?? 'Namibia') == 'Namibia' ? 'selected' : '' }}>Namibia</option>
                                    <option value="Angola" {{ old('nationality', $user->employeeProfile->nationality ?? '') == 'Angola' ? 'selected' : '' }}>Angola</option>
                                    <option value="Botswana" {{ old('nationality', $user->employeeProfile->nationality ?? '') == 'Botswana' ? 'selected' : '' }}>Botswana</option>
                                    <option value="Comoros" {{ old('nationality', $user->employeeProfile->nationality ?? '') == 'Comoros' ? 'selected' : '' }}>Comoros</option>
                                    <option value="Democratic Republic of Congo" {{ old('nationality', $user->employeeProfile->nationality ?? '') == 'Democratic Republic of Congo' ? 'selected' : '' }}>Democratic Republic of Congo</option>
                                    <option value="Eswatini" {{ old('nationality', $user->employeeProfile->nationality ?? '') == 'Eswatini' ? 'selected' : '' }}>Eswatini</option>
                                    <option value="Lesotho" {{ old('nationality', $user->employeeProfile->nationality ?? '') == 'Lesotho' ? 'selected' : '' }}>Lesotho</option>
                                    <option value="Madagascar" {{ old('nationality', $user->employeeProfile->nationality ?? '') == 'Madagascar' ? 'selected' : '' }}>Madagascar</option>
                                    <option value="Malawi" {{ old('nationality', $user->employeeProfile->nationality ?? '') == 'Malawi' ? 'selected' : '' }}>Malawi</option>
                                    <option value="Mauritius" {{ old('nationality', $user->employeeProfile->nationality ?? '') == 'Mauritius' ? 'selected' : '' }}>Mauritius</option>
                                    <option value="Mozambique" {{ old('nationality', $user->employeeProfile->nationality ?? '') == 'Mozambique' ? 'selected' : '' }}>Mozambique</option>
                                    <option value="Seychelles" {{ old('nationality', $user->employeeProfile->nationality ?? '') == 'Seychelles' ? 'selected' : '' }}>Seychelles</option>
                                    <option value="South Africa" {{ old('nationality', $user->employeeProfile->nationality ?? '') == 'South Africa' ? 'selected' : '' }}>South Africa</option>
                                    <option value="Tanzania" {{ old('nationality', $user->employeeProfile->nationality ?? '') == 'Tanzania' ? 'selected' : '' }}>Tanzania</option>
                                    <option value="Zambia" {{ old('nationality', $user->employeeProfile->nationality ?? '') == 'Zambia' ? 'selected' : '' }}>Zambia</option>
                                    <option value="Zimbabwe" {{ old('nationality', $user->employeeProfile->nationality ?? '') == 'Zimbabwe' ? 'selected' : '' }}>Zimbabwe</option>
                                    <option value="Africa" {{ old('nationality', $user->employeeProfile->nationality ?? '') == 'Africa' ? 'selected' : '' }}>Africa</option>
                                    <option value="International" {{ old('nationality', $user->employeeProfile->nationality ?? '') == 'International' ? 'selected' : '' }}>International</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="home_language">Home Language</label>
                                <select class="form-control" id="home_language" name="home_language">
                                    <option value="">Select Home Language</option>
                                    <option value="English" {{ old('home_language', $user->employeeProfile->home_language ?? '') == 'English' ? 'selected' : '' }}>English</option>
                                    <option value="Afrikaans" {{ old('home_language', $user->employeeProfile->home_language ?? '') == 'Afrikaans' ? 'selected' : '' }}>Afrikaans</option>
                                    <option value="Oshiwambo" {{ old('home_language', $user->employeeProfile->home_language ?? '') == 'Oshiwambo' ? 'selected' : '' }}>Oshiwambo</option>
                                    <option value="Otjiherero" {{ old('home_language', $user->employeeProfile->home_language ?? '') == 'Otjiherero' ? 'selected' : '' }}>Otjiherero</option>
                                    <option value="Nama/Damara" {{ old('home_language', $user->employeeProfile->home_language ?? '') == 'Nama/Damara' ? 'selected' : '' }}>Nama/Damara</option>
                                    <option value="Rukwangali" {{ old('home_language', $user->employeeProfile->home_language ?? '') == 'Rukwangali' ? 'selected' : '' }}>Rukwangali</option>
                                    <option value="Silozi" {{ old('home_language', $user->employeeProfile->home_language ?? '') == 'Silozi' ? 'selected' : '' }}>Silozi</option>
                                    <option value="Setswana" {{ old('home_language', $user->employeeProfile->home_language ?? '') == 'Setswana' ? 'selected' : '' }}>Setswana</option>
                                    <option value="Oshikwanyama" {{ old('home_language', $user->employeeProfile->home_language ?? '') == 'Oshikwanyama' ? 'selected' : '' }}>Oshikwanyama</option>
                                    <option value="Thimbukushu" {{ old('home_language', $user->employeeProfile->home_language ?? '') == 'Thimbukushu' ? 'selected' : '' }}>Thimbukushu</option>
                                    <option value="German" {{ old('home_language', $user->employeeProfile->home_language ?? '') == 'German' ? 'selected' : '' }}>German</option>
                                    <option value="Portuguese" {{ old('home_language', $user->employeeProfile->home_language ?? '') == 'Portuguese' ? 'selected' : '' }}>Portuguese</option>
                                    <option value="Others" {{ old('home_language', $user->employeeProfile->home_language ?? '') == 'Others' ? 'selected' : '' }}>Others</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="profile_photo">Profile Photo</label>
                                <input type="file" class="form-control-file" id="profile_photo" name="profile_photo" accept="image/*">
                                @if($user->employeeProfile && $user->employeeProfile->profile_photo)
                                <small class="form-text text-muted">Current photo will be replaced if you upload a new one.</small>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h6 class="border-bottom pb-2 mb-3"><strong>Contact Information</strong></h6>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="personal_email">Personal Email</label>
                                <input type="email" class="form-control" id="personal_email" name="personal_email" 
                                       value="{{ old('personal_email', $user->employeeProfile->personal_email ?? $user->email) }}"
                                       pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" 
                                       title="Please enter a valid email address">
                                <small class="form-text text-muted">Defaults to user account email: {{ $user->email }}</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="work_phone">Work Phone</label>
                                <input type="tel" class="form-control" id="work_phone" name="work_phone" 
                                       value="{{ old('work_phone', $user->employeeProfile->work_phone ?? '') }}"
                                       pattern="^\+264[0-9]{8,9}$" placeholder="+264XXXXXXXX"
                                       title="Phone number must start with +264 followed by 8-9 digits">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="personal_phone">Personal Phone</label>
                                <input type="tel" class="form-control" id="personal_phone" name="personal_phone" 
                                       value="{{ old('personal_phone', $user->employeeProfile->personal_phone ?? '') }}"
                                       pattern="^\+264[0-9]{8,9}$" placeholder="+264XXXXXXXX"
                                       title="Phone number must start with +264 followed by 8-9 digits">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="alternative_personal_phone">Alternative Personal Phone</label>
                                <input type="tel" class="form-control" id="alternative_personal_phone" name="alternative_personal_phone" 
                                       value="{{ old('alternative_personal_phone', $user->employeeProfile->alternative_personal_phone ?? '') }}"
                                       pattern="^\+264[0-9]{8,9}$" placeholder="+264XXXXXXXX"
                                       title="Phone number must start with +264 followed by 8-9 digits">
                            </div>
                        </div>
                    </div>

                    <!-- Emergency Contact -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h6 class="border-bottom pb-2 mb-3"><strong>Emergency Contact</strong></h6>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="emergency_contact_name">Emergency Contact Name</label>
                                <input type="text" class="form-control" id="emergency_contact_name" name="emergency_contact_name" 
                                       value="{{ old('emergency_contact_name', $user->employeeProfile->emergency_contact_name ?? '') }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="emergency_contact_phone">Emergency Contact Phone</label>
                                <input type="tel" class="form-control" id="emergency_contact_phone" name="emergency_contact_phone" 
                                       value="{{ old('emergency_contact_phone', $user->employeeProfile->emergency_contact_phone ?? '') }}"
                                       pattern="^\+264[0-9]{8,9}$" placeholder="+264XXXXXXXX"
                                       title="Phone number must start with +264 followed by 8-9 digits">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="emergency_contact_relationship">Relationship</label>
                                <select class="form-control" id="emergency_contact_relationship" name="emergency_contact_relationship">
                                    <option value="">Select Relationship</option>
                                    <option value="Spouse" {{ old('emergency_contact_relationship', $user->employeeProfile->emergency_contact_relationship ?? '') == 'Spouse' ? 'selected' : '' }}>Spouse</option>
                                    <option value="Parent" {{ old('emergency_contact_relationship', $user->employeeProfile->emergency_contact_relationship ?? '') == 'Parent' ? 'selected' : '' }}>Parent</option>
                                    <option value="Family Member" {{ in_array(old('emergency_contact_relationship', $user->employeeProfile->emergency_contact_relationship ?? ''), ['Sister', 'Brother', 'Aunt', 'Uncle', 'Cousin', 'Grandparent', 'Mother', 'Father', 'Son', 'Daughter', 'Child', 'Family Member']) ? 'selected' : '' }}>Family Member</option>
                                    <option value="Guardian" {{ old('emergency_contact_relationship', $user->employeeProfile->emergency_contact_relationship ?? '') == 'Guardian' ? 'selected' : '' }}>Guardian</option>
                                    <option value="Friend" {{ old('emergency_contact_relationship', $user->employeeProfile->emergency_contact_relationship ?? '') == 'Friend' ? 'selected' : '' }}>Friend</option>
                                    <option value="Colleague" {{ old('emergency_contact_relationship', $user->employeeProfile->emergency_contact_relationship ?? '') == 'Colleague' ? 'selected' : '' }}>Colleague</option>
                                    <option value="Other" {{ old('emergency_contact_relationship', $user->employeeProfile->emergency_contact_relationship ?? '') == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Address Information -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h6 class="border-bottom pb-2 mb-3"><strong>Address Information</strong></h6>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="residential_address">Residential Address</label>
                                <textarea class="form-control" id="residential_address" name="residential_address" rows="3">{{ old('residential_address', $user->employeeProfile->residential_address ?? '') }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="postal_address">Postal Address</label>
                                <textarea class="form-control" id="postal_address" name="postal_address" rows="3">{{ old('postal_address', $user->employeeProfile->postal_address ?? '') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Second row for city and region fields -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="residential_city">Residential City</label>
                                <select class="form-control" id="residential_city" name="residential_city">
                                    <option value="">Select City/Town</option>
                                    <option value="Windhoek" {{ old('residential_city', $user->employeeProfile->residential_city ?? '') == 'Windhoek' ? 'selected' : '' }}>Windhoek</option>
                                    <option value="Swakopmund" {{ old('residential_city', $user->employeeProfile->residential_city ?? '') == 'Swakopmund' ? 'selected' : '' }}>Swakopmund</option>
                                    <option value="Walvis Bay" {{ old('residential_city', $user->employeeProfile->residential_city ?? '') == 'Walvis Bay' ? 'selected' : '' }}>Walvis Bay</option>
                                    <option value="Oshakati" {{ old('residential_city', $user->employeeProfile->residential_city ?? '') == 'Oshakati' ? 'selected' : '' }}>Oshakati</option>
                                    <option value="Rundu" {{ old('residential_city', $user->employeeProfile->residential_city ?? '') == 'Rundu' ? 'selected' : '' }}>Rundu</option>
                                    <option value="Rehoboth" {{ old('residential_city', $user->employeeProfile->residential_city ?? '') == 'Rehoboth' ? 'selected' : '' }}>Rehoboth</option>
                                    <option value="Katima Mulilo" {{ old('residential_city', $user->employeeProfile->residential_city ?? '') == 'Katima Mulilo' ? 'selected' : '' }}>Katima Mulilo</option>
                                    <option value="Otjiwarongo" {{ old('residential_city', $user->employeeProfile->residential_city ?? '') == 'Otjiwarongo' ? 'selected' : '' }}>Otjiwarongo</option>
                                    <option value="Ondangwa" {{ old('residential_city', $user->employeeProfile->residential_city ?? '') == 'Ondangwa' ? 'selected' : '' }}>Ondangwa</option>
                                    <option value="Okahandja" {{ old('residential_city', $user->employeeProfile->residential_city ?? '') == 'Okahandja' ? 'selected' : '' }}>Okahandja</option>
                                    <option value="Ongwediva" {{ old('residential_city', $user->employeeProfile->residential_city ?? '') == 'Ongwediva' ? 'selected' : '' }}>Ongwediva</option>
                                    <option value="Otavi" {{ old('residential_city', $user->employeeProfile->residential_city ?? '') == 'Otavi' ? 'selected' : '' }}>Otavi</option>
                                    <option value="Grootfontein" {{ old('residential_city', $user->employeeProfile->residential_city ?? '') == 'Grootfontein' ? 'selected' : '' }}>Grootfontein</option>
                                    <option value="Tsumeb" {{ old('residential_city', $user->employeeProfile->residential_city ?? '') == 'Tsumeb' ? 'selected' : '' }}>Tsumeb</option>
                                    <option value="Gobabis" {{ old('residential_city', $user->employeeProfile->residential_city ?? '') == 'Gobabis' ? 'selected' : '' }}>Gobabis</option>
                                    <option value="Henties Bay" {{ old('residential_city', $user->employeeProfile->residential_city ?? '') == 'Henties Bay' ? 'selected' : '' }}>Henties Bay</option>
                                    <option value="Mariental" {{ old('residential_city', $user->employeeProfile->residential_city ?? '') == 'Mariental' ? 'selected' : '' }}>Mariental</option>
                                    <option value="Keetmanshoop" {{ old('residential_city', $user->employeeProfile->residential_city ?? '') == 'Keetmanshoop' ? 'selected' : '' }}>Keetmanshoop</option>
                                    <option value="Aranos" {{ old('residential_city', $user->employeeProfile->residential_city ?? '') == 'Aranos' ? 'selected' : '' }}>Aranos</option>
                                    <option value="Lüderitz" {{ old('residential_city', $user->employeeProfile->residential_city ?? '') == 'Lüderitz' ? 'selected' : '' }}>Lüderitz</option>
                                    <option value="Oranjemund" {{ old('residential_city', $user->employeeProfile->residential_city ?? '') == 'Oranjemund' ? 'selected' : '' }}>Oranjemund</option>
                                    <option value="Karasburg" {{ old('residential_city', $user->employeeProfile->residential_city ?? '') == 'Karasburg' ? 'selected' : '' }}>Karasburg</option>
                                    <option value="Outapi" {{ old('residential_city', $user->employeeProfile->residential_city ?? '') == 'Outapi' ? 'selected' : '' }}>Outapi</option>
                                    <option value="Opuwo" {{ old('residential_city', $user->employeeProfile->residential_city ?? '') == 'Opuwo' ? 'selected' : '' }}>Opuwo</option>
                                    <option value="Otjinene" {{ old('residential_city', $user->employeeProfile->residential_city ?? '') == 'Otjinene' ? 'selected' : '' }}>Otjinene</option>
                                    <option value="Usakos" {{ old('residential_city', $user->employeeProfile->residential_city ?? '') == 'Usakos' ? 'selected' : '' }}>Usakos</option>
                                    <option value="Karibib" {{ old('residential_city', $user->employeeProfile->residential_city ?? '') == 'Karibib' ? 'selected' : '' }}>Karibib</option>
                                    <option value="Maltahöhe" {{ old('residential_city', $user->employeeProfile->residential_city ?? '') == 'Maltahöhe' ? 'selected' : '' }}>Maltahöhe</option>
                                    <option value="Bethanie" {{ old('residential_city', $user->employeeProfile->residential_city ?? '') == 'Bethanie' ? 'selected' : '' }}>Bethanie</option>
                                    <option value="Khorixas" {{ old('residential_city', $user->employeeProfile->residential_city ?? '') == 'Khorixas' ? 'selected' : '' }}>Khorixas</option>
                                    <option value="Other" {{ old('residential_city', $user->employeeProfile->residential_city ?? '') == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="residential_province">Residential Region</label>
                                <select class="form-control" id="residential_province" name="residential_province">
                                    <option value="">Select Region</option>
                                    <option value="Erongo" {{ old('residential_province', $user->employeeProfile->residential_province ?? '') == 'Erongo' ? 'selected' : '' }}>Erongo</option>
                                    <option value="Hardap" {{ old('residential_province', $user->employeeProfile->residential_province ?? '') == 'Hardap' ? 'selected' : '' }}>Hardap</option>
                                    <option value="Karas" {{ old('residential_province', $user->employeeProfile->residential_province ?? '') == 'Karas' ? 'selected' : '' }}>Karas</option>
                                    <option value="Kavango East" {{ old('residential_province', $user->employeeProfile->residential_province ?? '') == 'Kavango East' ? 'selected' : '' }}>Kavango East</option>
                                    <option value="Kavango West" {{ old('residential_province', $user->employeeProfile->residential_province ?? '') == 'Kavango West' ? 'selected' : '' }}>Kavango West</option>
                                    <option value="Khomas" {{ old('residential_province', $user->employeeProfile->residential_province ?? '') == 'Khomas' ? 'selected' : '' }}>Khomas</option>
                                    <option value="Kunene" {{ old('residential_province', $user->employeeProfile->residential_province ?? '') == 'Kunene' ? 'selected' : '' }}>Kunene</option>
                                    <option value="Ohangwena" {{ old('residential_province', $user->employeeProfile->residential_province ?? '') == 'Ohangwena' ? 'selected' : '' }}>Ohangwena</option>
                                    <option value="Omaheke" {{ old('residential_province', $user->employeeProfile->residential_province ?? '') == 'Omaheke' ? 'selected' : '' }}>Omaheke</option>
                                    <option value="Omusati" {{ old('residential_province', $user->employeeProfile->residential_province ?? '') == 'Omusati' ? 'selected' : '' }}>Omusati</option>
                                    <option value="Oshana" {{ old('residential_province', $user->employeeProfile->residential_province ?? '') == 'Oshana' ? 'selected' : '' }}>Oshana</option>
                                    <option value="Oshikoto" {{ old('residential_province', $user->employeeProfile->residential_province ?? '') == 'Oshikoto' ? 'selected' : '' }}>Oshikoto</option>
                                    <option value="Otjozondjupa" {{ old('residential_province', $user->employeeProfile->residential_province ?? '') == 'Otjozondjupa' ? 'selected' : '' }}>Otjozondjupa</option>
                                    <option value="Zambezi" {{ old('residential_province', $user->employeeProfile->residential_province ?? '') == 'Zambezi' ? 'selected' : '' }}>Zambezi</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Third row for postal fields -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="postal_city">Postal City</label>
                                <input type="text" class="form-control" id="postal_city" name="postal_city" 
                                       value="{{ old('postal_city', $user->employeeProfile->postal_city ?? '') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="postal_province">Postal Region</label>
                                <select class="form-control" id="postal_province" name="postal_province">
                                    <option value="">Select Region</option>
                                    <option value="Erongo" {{ old('postal_province', $user->employeeProfile->postal_province ?? '') == 'Erongo' ? 'selected' : '' }}>Erongo</option>
                                    <option value="Hardap" {{ old('postal_province', $user->employeeProfile->postal_province ?? '') == 'Hardap' ? 'selected' : '' }}>Hardap</option>
                                    <option value="Karas" {{ old('postal_province', $user->employeeProfile->postal_province ?? '') == 'Karas' ? 'selected' : '' }}>Karas</option>
                                    <option value="Kavango East" {{ old('postal_province', $user->employeeProfile->postal_province ?? '') == 'Kavango East' ? 'selected' : '' }}>Kavango East</option>
                                    <option value="Kavango West" {{ old('postal_province', $user->employeeProfile->postal_province ?? '') == 'Kavango West' ? 'selected' : '' }}>Kavango West</option>
                                    <option value="Khomas" {{ old('postal_province', $user->employeeProfile->postal_province ?? '') == 'Khomas' ? 'selected' : '' }}>Khomas</option>
                                    <option value="Kunene" {{ old('postal_province', $user->employeeProfile->postal_province ?? '') == 'Kunene' ? 'selected' : '' }}>Kunene</option>
                                    <option value="Ohangwena" {{ old('postal_province', $user->employeeProfile->postal_province ?? '') == 'Ohangwena' ? 'selected' : '' }}>Ohangwena</option>
                                    <option value="Omaheke" {{ old('postal_province', $user->employeeProfile->postal_province ?? '') == 'Omaheke' ? 'selected' : '' }}>Omaheke</option>
                                    <option value="Omusati" {{ old('postal_province', $user->employeeProfile->postal_province ?? '') == 'Omusati' ? 'selected' : '' }}>Omusati</option>
                                    <option value="Oshana" {{ old('postal_province', $user->employeeProfile->postal_province ?? '') == 'Oshana' ? 'selected' : '' }}>Oshana</option>
                                    <option value="Oshikoto" {{ old('postal_province', $user->employeeProfile->postal_province ?? '') == 'Oshikoto' ? 'selected' : '' }}>Oshikoto</option>
                                    <option value="Otjozondjupa" {{ old('postal_province', $user->employeeProfile->postal_province ?? '') == 'Otjozondjupa' ? 'selected' : '' }}>Otjozondjupa</option>
                                    <option value="Zambezi" {{ old('postal_province', $user->employeeProfile->postal_province ?? '') == 'Zambezi' ? 'selected' : '' }}>Zambezi</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="residential_postal_code">Residential Postal Code</label>
                                <input type="text" class="form-control" id="residential_postal_code" name="residential_postal_code" 
                                       value="{{ old('residential_postal_code', $user->employeeProfile->residential_postal_code ?? '') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="postal_code">Postal Code</label>
                                <input type="text" class="form-control" id="postal_code" name="postal_code" 
                                       value="{{ old('postal_code', $user->employeeProfile->postal_code ?? '') }}">
                            </div>
                        </div>
                    </div>

                    <!-- Banking Information -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h6 class="border-bottom pb-2 mb-3"><strong>Banking Information</strong></h6>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="bank_name">Bank Name</label>
                                <select class="form-control" id="bank_name" name="bank_name">
                                    <option value="">Select Bank</option>
                                    <option value="Bank Windhoek" {{ old('bank_name', $user->employeeProfile->bank_name ?? '') == 'Bank Windhoek' ? 'selected' : '' }}>Bank Windhoek</option>
                                    <option value="First National Bank (FNB)" {{ old('bank_name', $user->employeeProfile->bank_name ?? '') == 'First National Bank (FNB)' ? 'selected' : '' }}>First National Bank (FNB)</option>
                                    <option value="Standard Bank Namibia" {{ old('bank_name', $user->employeeProfile->bank_name ?? '') == 'Standard Bank Namibia' ? 'selected' : '' }}>Standard Bank Namibia</option>
                                    <option value="Nedbank Namibia" {{ old('bank_name', $user->employeeProfile->bank_name ?? '') == 'Nedbank Namibia' ? 'selected' : '' }}>Nedbank Namibia</option>
                                    <option value="Banco Nacional de Angola (BNA)" {{ old('bank_name', $user->employeeProfile->bank_name ?? '') == 'Banco Nacional de Angola (BNA)' ? 'selected' : '' }}>Banco Nacional de Angola (BNA)</option>
                                    <option value="Letshego Bank Namibia" {{ old('bank_name', $user->employeeProfile->bank_name ?? '') == 'Letshego Bank Namibia' ? 'selected' : '' }}>Letshego Bank Namibia</option>
                                    <option value="SME Bank" {{ old('bank_name', $user->employeeProfile->bank_name ?? '') == 'SME Bank' ? 'selected' : '' }}>SME Bank</option>
                                    <option value="Agribank of Namibia" {{ old('bank_name', $user->employeeProfile->bank_name ?? '') == 'Agribank of Namibia' ? 'selected' : '' }}>Agribank of Namibia</option>
                                    <option value="Development Bank of Namibia" {{ old('bank_name', $user->employeeProfile->bank_name ?? '') == 'Development Bank of Namibia' ? 'selected' : '' }}>Development Bank of Namibia</option>
                                    <option value="Bank of Namibia" {{ old('bank_name', $user->employeeProfile->bank_name ?? '') == 'Bank of Namibia' ? 'selected' : '' }}>Bank of Namibia</option>
                                    <option value="Capricorn Group" {{ old('bank_name', $user->employeeProfile->bank_name ?? '') == 'Capricorn Group' ? 'selected' : '' }}>Capricorn Group</option>
                                    <option value="Other" {{ old('bank_name', $user->employeeProfile->bank_name ?? '') == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="bank_branch">Bank Branch</label>
                                <input type="text" class="form-control" id="bank_branch" name="bank_branch" 
                                       value="{{ old('bank_branch', $user->employeeProfile->bank_branch ?? '') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="account_number">Account Number</label>
                                <input type="text" class="form-control" id="account_number" name="account_number" 
                                       value="{{ old('account_number', $user->employeeProfile->account_number ?? '') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="account_type">Account Type</label>
                                <select class="form-control" id="account_type" name="account_type">
                                    <option value="">Select Account Type</option>
                                    <option value="Savings" {{ old('account_type', $user->employeeProfile->account_type ?? '') == 'Savings' ? 'selected' : '' }}>Savings</option>
                                    <option value="Cheque" {{ old('account_type', $user->employeeProfile->account_type ?? '') == 'Cheque' ? 'selected' : '' }}>Cheque</option>
                                    <option value="Current" {{ old('account_type', $user->employeeProfile->account_type ?? '') == 'Current' ? 'selected' : '' }}>Current</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Tax Information -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h6 class="border-bottom pb-2 mb-3">Tax Information</h6>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tax_number">Tax Number</label>
                                <input type="text" class="form-control" id="tax_number" name="tax_number" 
                                       value="{{ old('tax_number', $user->employeeProfile->tax_number ?? '') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="uif_number">Social Security Number</label>
                                <input type="text" class="form-control" id="uif_number" name="uif_number" 
                                       value="{{ old('uif_number', $user->employeeProfile->uif_number ?? '') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="medical_aid_name">Medical Aid Name</label>
                                <input type="text" class="form-control" id="medical_aid_name" name="medical_aid_name" 
                                       value="{{ old('medical_aid_name', $user->employeeProfile->medical_aid_name ?? '') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="medical_aid_number">Medical Aid Number</label>
                                <input type="text" class="form-control" id="medical_aid_number" name="medical_aid_number" 
                                       value="{{ old('medical_aid_number', $user->employeeProfile->medical_aid_number ?? '') }}">
                            </div>
                        </div>
                    </div>

                    <!-- Additional Information -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h6 class="border-bottom pb-2 mb-3">Additional Information</h6>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="notes">Notes</label>
                                <textarea class="form-control" id="notes" name="notes" rows="4">{{ old('notes', $user->employeeProfile->notes ?? '') }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" 
                                           {{ old('is_active', $user->employeeProfile->is_active ?? true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">
                                        Active Employee
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            {{ $user->employeeProfile ? 'Update' : 'Create' }} Profile
                        </button>
                        <a href="{{route('employees.index')}}" class="btn btn-secondary">Cancel</a>
                        @if($user->employeeProfile)
                        <a href="{{route('employees.show', $user->id)}}" class="btn btn-info">View Profile</a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

<style>
:root {
    --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --primary-color: #667eea;
    --secondary-color: #764ba2;
    --hover-gradient: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
    --info-gradient: linear-gradient(135deg, #36d1dc 0%, #5b86e5 100%);
}

/* Primary button with gradient */
.btn-primary {
    background: var(--primary-gradient) !important;
    border: none !important;
    color: white !important;
    transition: all 0.3s ease;
    font-weight: 500;
}

.btn-primary:hover {
    background: var(--hover-gradient) !important;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
    color: white !important;
}

/* Secondary button styling */
.btn-secondary {
    background: linear-gradient(135deg, #6c757d 0%, #495057 100%) !important;
    border: none !important;
    color: white !important;
    transition: all 0.3s ease;
}

.btn-secondary:hover {
    background: linear-gradient(135deg, #5a6268 0%, #343a40 100%) !important;
    transform: translateY(-1px);
    color: white !important;
}

/* Info button styling */
.btn-info {
    background: var(--info-gradient) !important;
    border: none !important;
    color: white !important;
    transition: all 0.3s ease;
}

.btn-info:hover {
    background: linear-gradient(135deg, #2bc0cc 0%, #4a7bd1 100%) !important;
    transform: translateY(-1px);
    color: white !important;
}

/* Card styling */
.card {
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    border: none;
    border-radius: 10px;
}

.card-header {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-bottom: 1px solid #dee2e6;
    border-radius: 10px 10px 0 0 !important;
}

/* Form styling */
.form-control:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

.form-group label {
    font-weight: 500;
    color: #495057;
}
</style>
