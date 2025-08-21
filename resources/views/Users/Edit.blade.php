@extends('layouts.app')
@section('breadcrumb')
<div class="c-subheader px-3">
    <!-- Breadcrumb-->
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item">Access Management</li>
        <li class="breadcrumb-item"><a href="{{route('users.index')}}">Users</a> </li>
        <li class="breadcrumb-item active">Edit </li>
        <!-- Breadcrumb Menu-->
    </ol>
</div>
@endsection
@section('content')
<div class="row">
    <div class="offset-2 col-sm-12 col-md-8">
        <div class="card">
            <div class="card-header">
                <strong>Users</strong>
            </div>
            <div class="card-body">
                @if ($errors->any())
                @foreach ($errors->all() as $error)
                <p class="text-danger">{{ $error }}</p>
                @endforeach
                @endif

                {!! Form::model($user, array('route'=>array('users.update', $user->id), 'autocomplete'=>"none", 'class'=>'form-vertical form-material', 'method'=>'PATCH')) !!}

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {{Form::label('name', 'Full Names')}}
                            {{Form::text('name', $user->name, ['class' => 'form-control', 'required'])}}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {{Form::label('email', 'Email')}}
                            {{Form::text('email', $user->email, ['class' => 'form-control', 'required'])}}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {{Form::label('password', 'Password')}}
                            {{Form::password('password', ['class' => 'form-control', 'autocomplete'=>"none"])}}
                            <span class="text-help text-info">
                                The password field can be left blank. Only fill it in if you wish to change/update the user's password.
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {{Form::label('password_confirmation', 'Confirm Password')}}
                            {{Form::password('password_confirmation', ['class' => 'form-control'])}}
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {{Form::label('permissions', 'Access Levels', array('class' => 'control-label'))}}
                            
                            <!-- Select All/None buttons -->
                            <div class="mb-3">
                                <button type="button" class="btn btn-sm btn-secondary" onclick="selectAllPermissions()">Select All</button>
                                <button type="button" class="btn btn-sm btn-secondary" onclick="selectNonePermissions()">Select None</button>
                            </div>
                            
                            <div class="accordion" id="permissionsAccordion">
                                @php
                                    // Group permissions by category
                                    $groupedPermissions = $permissions->groupBy(function($permission) {
                                        // Group by main menu categories first
                                        if (in_array($permission->name, ['MANAGEMENT', 'REGISTRATION_MANAGEMENT', 'FINANCE', 'REPORTS', 'ADMINISTRATION', 'SETUP'])) {
                                            return $permission->display_name;
                                        }
                                        
                                        // Group by prefix patterns for modules (future-proof for when they're added)
                                        if (strpos($permission->name, 'inventory-') === 0) {
                                            return 'INVENTORY MANAGEMENT';
                                        }
                                        if (strpos($permission->name, 'fixed-assets-') === 0) {
                                            return 'FIXED ASSETS MANAGEMENT';
                                        }
                                        if (strpos($permission->name, 'maintenance-') === 0) {
                                            return 'MAINTENANCE MANAGEMENT';
                                        }
                                        if (strpos($permission->name, 'fleet-') === 0) {
                                            return 'FLEET MANAGEMENT';
                                        }
                                        if (strpos($permission->name, 'leave-') === 0 || strpos($permission->name, 'employee-') === 0 || strpos($permission->name, 'hr-') === 0 || in_array($permission->name, ['employee-bio', 'leave-management', 'leave-applications'])) {
                                            return 'HUMAN RESOURCES';
                                        }
                                        if (strpos($permission->name, 'hostel-') === 0 || in_array($permission->name, ['HOSTEL_MANAGEMENT', 'hostel-administration'])) {
                                            return 'HOSTEL MANAGEMENT';
                                        }
                                        if (strpos($permission->name, 'asset-') === 0) {
                                            return 'ASSET MANAGEMENT';
                                        }
                                        if (strpos($permission->name, 'admission-') === 0 || strpos($permission->name, 'admissions-') === 0 || strpos($permission->name, 'manual-admissions') === 0) {
                                            return 'ADMISSIONS MANAGEMENT';
                                        }
                                        
                                        // Group student related permissions
                                        if (in_array($permission->name, ['students', 'add-student', 'edit-student', 'show-student'])) {
                                            return 'STUDENT MANAGEMENT';
                                        }
                                        
                                        // Group fees related permissions
                                        if (in_array($permission->name, ['fees', 'add-fees', 'edit-fees', 'show-fees'])) {
                                            return 'FEES MANAGEMENT';
                                        }
                                        
                                        // Group subjects related permissions
                                        if (in_array($permission->name, ['subjects', 'add-subjects', 'edit-subjects', 'show-subjects'])) {
                                            return 'SUBJECTS MANAGEMENT';
                                        }
                                        
                                        // Group enrollment related permissions
                                        if (in_array($permission->name, ['enrolment', 'confirm-enrolment', 'cancel-enrolment', 'confirm-cancel', 'remove-cancelation'])) {
                                            return 'ENROLLMENT MANAGEMENT';
                                        }
                                        
                                        // Group finance related permissions
                                        if (in_array($permission->name, ['invoice', 'print-invoice', 'payments', 'add-payment', 'debit-memos', 'add-debit-order', 'credit-memos', 'add-credit-memos'])) {
                                            return 'FINANCE OPERATIONS';
                                        }
                                        
                                        // Group reports
                                        if (in_array($permission->name, [
                                            'student-report', 
                                            'finance-report',
                                            'assessment-report',
                                            'attendance-report',
                                            'employee-report',
                                            'hostel-reports',
                                            'inventory-reports',
                                            'leave-reports',
                                            'maintenance-reports',
                                            'payroll-reports',
                                            'timetable-reports'
                                        ])) {
                                            return 'REPORTS OPERATIONS';
                                        }
                                        
                                        // Group user management
                                        if (in_array($permission->name, ['access-management-menu', 'users', 'add-user', 'edit-users'])) {
                                            return 'USER MANAGEMENT';
                                        }
                                        
                                        // Group assessment type permissions
                                        if (in_array($permission->name, ['assessments', 'add-assessment-types', 'edit-assessment-types', 'delete-assessment-types'])) {
                                            return 'ASSESSMENT TYPES MANAGEMENT';
                                        }
                                        
                                        // Group assessment weights permissions
                                        if (in_array($permission->name, ['assessment-weights', 'add-assessment-weights', 'edit-assessment-weights', 'delete-assessment-weights'])) {
                                            return 'ASSESSMENT WEIGHTS MANAGEMENT';
                                        }
                                        
                                        // Group exam paper weights permissions
                                        if (in_array($permission->name, ['exam-paper-weights', 'add-exam-paper-weights', 'edit-exam-paper-weights', 'delete-exam-paper-weights'])) {
                                            return 'EXAM PAPER WEIGHTS MANAGEMENT';
                                        }
                                        
                                        // Group examination permissions
                                        if (in_array($permission->name, ['examinations', 'add-examinations', 'edit-examinations', 'delete-examinations'])) {
                                            return 'EXAMINATIONS MANAGEMENT';
                                        }
                                        
                                        // Group result codes permissions
                                        if (in_array($permission->name, ['result-codes', 'add-result-codes', 'edit-result-codes', 'delete-result-codes'])) {
                                            return 'RESULT CODES MANAGEMENT';
                                        }
                                        
                                        // Group grading scales permissions
                                        if (in_array($permission->name, ['grading-scales', 'add-grading-scales', 'edit-grading-scales', 'delete-grading-scales'])) {
                                            return 'GRADING SCALES MANAGEMENT';
                                        }
                                        
                                        // Group promotional statuses permissions
                                        if (in_array($permission->name, ['promotional-statuses', 'add-promotional-statuses', 'edit-promotional-statuses', 'delete-promotional-statuses'])) {
                                            return 'PROMOTIONAL STATUSES MANAGEMENT';
                                        }
                                        
                                        // Group setup permissions
                                        if (in_array($permission->name, ['academic-years', 'add-academic-years', 'edit-academic-years', 'centers', 'add-centers', 'edit-centers', 'company', 'edit-company'])) {
                                            return 'SYSTEM SETUP';
                                        }
                                        
                                        // Group dashboard and general permissions
                                        if (in_array($permission->name, ['dashboard'])) {
                                            return 'DASHBOARD & GENERAL';
                                        }
                                        
                                        return 'GENERAL';
                                    });
                                    
                                    // Sort categories alphabetically
                                    $groupedPermissions = $groupedPermissions->sortKeys();
                                    
                                    $index = 0;
                                @endphp
                                
                                @foreach($groupedPermissions as $category => $categoryPermissions)
                                <div class="card">
                                    <div class="card-header" id="heading{{ $index }}">
                                        <h2 class="mb-0">
                                            <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse{{ $index }}" aria-expanded="false" aria-controls="collapse{{ $index }}" style="background: linear-gradient(135deg, #321fdb 0%, #2eb85c 100%); color: white; border: none; border-radius: 8px; padding: 12px 20px; margin-bottom: 2px; text-decoration: none;">
                                                <strong>{{ $category }}</strong> ({{ $categoryPermissions->count() }} permissions)
                                            </button>
                                        </h2>
                                    </div>
                                    <div id="collapse{{ $index }}" class="collapse" aria-labelledby="heading{{ $index }}" data-parent="#permissionsAccordion">
                                        <div class="card-body">
                                            <div class="mb-2">
                                                <button type="button" class="btn btn-sm" style="background: linear-gradient(135deg, #321fdb 0%, #2eb85c 100%); color: white; border: none; margin-right: 8px;" onclick="selectCategoryPermissions('{{ $index }}', true)">Select All in Category</button>
                                                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="selectCategoryPermissions('{{ $index }}', false)">Deselect All in Category</button>
                                            </div>
                                            <table class="table table-sm table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Display Name</th>
                                                        <th>Description</th>
                                                        <th class="text-center" width="120">Assign</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($categoryPermissions as $permission)
                                                    <tr>
                                                        <td><strong>{{ $permission->display_name }}</strong></td>
                                                        <td>{{ $permission->description }}</td>
                                                        <td class="text-center">
                                                            <input type="checkbox" 
                                                                   value="{{ $permission->id }}" 
                                                                   @if(in_array($permission->id, $assigned_permissions ?? [])) checked @endif 
                                                                   name="permissions[]"
                                                                   class="category-{{ $index }}-checkbox">
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                @php $index++; @endphp
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                function selectAllPermissions() {
                    document.querySelectorAll('input[name="permissions[]"]').forEach(function(checkbox) {
                        checkbox.checked = true;
                    });
                }

                function selectNonePermissions() {
                    document.querySelectorAll('input[name="permissions[]"]').forEach(function(checkbox) {
                        checkbox.checked = false;
                    });
                }

                function selectCategoryPermissions(categoryIndex, select) {
                    document.querySelectorAll('.category-' + categoryIndex + '-checkbox').forEach(function(checkbox) {
                        checkbox.checked = select;
                    });
                }
                </script>
                <button type="submit" class="btn btn-success"> Save</button>
                <a href="/users" class="btn"> Cancel</a>

                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection