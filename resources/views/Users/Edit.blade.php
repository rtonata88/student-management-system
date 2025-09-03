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
                    <div class="col-md-4">
                        <div class="form-group">
                            {{Form::label('name', 'Full Names')}}
                            {{Form::text('name', $user->name, ['class' => 'form-control', 'required'])}}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {{Form::label('username', 'Username')}}
                            {{Form::text('username', $user->username, ['class' => 'form-control', 'required'])}}
                        </div>
                    </div>
                    <div class="col-md-4">
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
                                        if (in_array($permission->name, ['MANAGEMENT', 'REGISTRATION MANAGEMENT', 'FINANCE', 'REPORTS', 'ADMINISTRATION', 'SETUP'])) {
                                            return $permission->display_name;
                                        }
                                        
                                        // Group notice board permissions
                                        if (in_array($permission->name, ['view-notice-board', 'create-notice', 'edit-notice', 'delete-notice', 'publish-notice', 'manage-notice-attachments'])) {
                                            return 'NOTICE BOARD MANAGEMENT';
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
                                        if (strpos($permission->name, 'module-allocation') === 0 || in_array($permission->name, ['view-module-allocations', 'create-module-allocations', 'edit-module-allocations', 'delete-module-allocations'])) {
                                            return 'MODULE ALLOCATION';
                                        }
                                        if (strpos($permission->name, 'my-modules') === 0 || in_array($permission->name, ['view-my-modules', 'view-class-list', 'view-attendance', 'create-attendance', 'edit-attendance', 'delete-attendance', 'mark-attendance', 'view-attendance-reports', 'export-attendance', 'view-subject-materials', 'create-subject-materials', 'edit-subject-materials', 'delete-subject-materials', 'upload-subject-materials', 'download-subject-materials', 'publish-subject-materials'])) {
                                            return 'MY MODULES';
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
                                        
                                        // Group cashier related permissions
                                        if (in_array($permission->name, ['view-cashier', 'access-cashier', 'process-cashier-payments', 'view-cashier-receipts', 'print-cashier-receipts', 'manage-cashier-operations'])) {
                                            return 'CASHIER OPERATIONS';
                                        }
                                        
                                        // Group captured payments permissions
                                        if (in_array($permission->name, ['view-captured-payments', 'search-captured-payments', 'reprint-payment-receipts', 'export-captured-payments', 'manage-captured-payments', 'void-payments'])) {
                                            return 'CAPTURED PAYMENTS MANAGEMENT';
                                        }
                                        
                                        // Group student block permissions
                                        if (in_array($permission->name, ['view-student-blocks', 'create-student-blocks', 'edit-student-blocks', 'delete-student-blocks', 'block-students', 'unblock-students', 'bulk-block-students', 'bulk-unblock-students', 'manage-block-exceptions', 'view-block-history', 'export-student-blocks'])) {
                                            return 'STUDENT BLOCK MANAGEMENT';
                                        }
                                        
                                        // Group reports
                                        if (in_array($permission->name, [
                                            // Existing reports
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
                                            'timetable-reports',
                                            
                                            // Academic Reports (alphabetical order)
                                            'academic-performance-report',
                                            'academic-year-summary-report',
                                            'assessment-analysis-report',
                                            'assessment-marks-report',
                                            'assessment-statistics-report',
                                            'attendance-summary-report',
                                            'audit-trail-report',
                                            
                                            // Class and Curriculum Reports
                                            'class-performance-report',
                                            'class-routine-report',
                                            'class-schedule-report',
                                            'curriculum-coverage-report',
                                            
                                            // Data and System Reports
                                            'data-backup-report',
                                            
                                            // Employee Reports
                                            'employee-attendance-report',
                                            'employee-benefits-report',
                                            'employee-directory-report',
                                            'employee-performance-report',
                                            'employee-profile-report',
                                            'enrollment-analysis-report',
                                            'enrollment-statistics-report',
                                            'enrollment-trends-report',
                                            
                                            // Examination Reports
                                            'exam-marks-report',
                                            'exam-results-report',
                                            'exam-schedule-report',
                                            'exam-statistics-report',
                                            'examination-analysis-report',
                                            
                                            // Faculty and Staff Reports
                                            'faculty-timetable-report',
                                            'fee-collection-report',
                                            'fee-defaulters-report',
                                            'fee-structure-report',
                                            'financial-summary-report',
                                            'fleet-cost-analysis-report',
                                            'fleet-driver-performance-report',
                                            'fleet-fuel-consumption-report',
                                            'fleet-maintenance-report',
                                            'fleet-trip-summary-report',
                                            'fleet-utilization-report',
                                            
                                            // Hostel Reports
                                            'hostel-allocation-report',
                                            'hostel-fee-collection-report',
                                            'hostel-maintenance-report',
                                            'hostel-occupancy-report',
                                            'hostel-payment-report',
                                            'hostel-visitor-report',
                                            
                                            // Inventory and Asset Reports
                                            'inventory-movement-report',
                                            'inventory-stock-report',
                                            'inventory-valuation-report',
                                            
                                            // Leave Reports
                                            'leave-balance-report',
                                            'leave-history-report',
                                            'leave-summary-report',
                                            'low-stock-report',
                                            
                                            // Maintenance Reports
                                            'asset-maintenance-report',
                                            'maintenance-cost-report',
                                            'maintenance-history-report',
                                            'maintenance-schedule-report',
                                            
                                            // Outstanding and Overdue Reports
                                            'outstanding-balances-report',
                                            'overdue-maintenance-report',
                                            
                                            // Payment and Payroll Reports
                                            'payment-history-report',
                                            'payroll-summary-report',
                                            'preventive-maintenance-report',
                                            
                                            // Registration and Revenue Reports
                                            'registration-summary-report',
                                            'revenue-analysis-report',
                                            'room-utilization-report',
                                            
                                            // Staff and Stock Reports
                                            'staff-allocation-report',
                                            'stock-adjustment-report',
                                            'student-academic-transcript',
                                            'student-attendance-report',
                                            'student-demographics-report',
                                            'student-fee-statement',
                                            'student-progress-report',
                                            'student-registration-report',
                                            'student-summary-report',
                                            'subject-enrollment-report',
                                            'supplier-performance-report',
                                            'system-activity-report',
                                            'system-performance-report',
                                            
                                            // Timetable and User Reports
                                            'timetable-conflicts-report',
                                            'user-activity-report',
                                            'user-permissions-report',
                                            
                                            // Vehicle and Venue Reports
                                            'vehicle-inspection-report',
                                            'vehicle-service-history-report',
                                            'venue-allocation-report'
                                        ])) {
                                            return 'REPORTS OPERATIONS';
                                        }
                                        
                                        // Group class routine permissions
                                        if (in_array($permission->name, ['view-class-routine', 'create-class-routine', 'edit-class-routine', 'delete-class-routine', 'manage-venues', 'manage-class-durations', 'print-class-routine', 'view-class-duration', 'create-class-duration', 'edit-class-duration', 'delete-class-duration'])) {
                                            return 'CLASS ROUTINE MANAGEMENT';
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
                                        
                                        // Group test marks permissions
                                        if (in_array($permission->name, ['test-marks', 'capture-test-marks', 'view-all-test-marks', 'delete-test-marks'])) {
                                            return 'TEST MARKS MANAGEMENT';
                                        }
                                        
                                        // Group exam marks permissions
                                        if (in_array($permission->name, ['exam-marks', 'capture-exam-marks', 'view-all-exam-marks', 'delete-exam-marks'])) {
                                            return 'EXAM MARKS MANAGEMENT';
                                        }
                                        
                                        // Group examination schedule permissions
                                        if (in_array($permission->name, ['view-examination-schedule', 'create-examination-schedule', 'edit-examination-schedule', 'delete-examination-schedule', 'print-examination-schedule', 'manage-examination-schedule', 'view-venue', 'create-venue', 'edit-venue', 'delete-venue', 'view-time-slot', 'create-time-slot', 'edit-time-slot', 'delete-time-slot'])) {
                                            return 'EXAMINATION SCHEDULE MANAGEMENT';
                                        }
                                        
                                        // Group student cards permissions
                                        if (in_array($permission->name, ['view-student-cards', 'create-student-cards', 'edit-student-cards', 'delete-student-cards', 'generate-student-cards', 'print-student-cards', 'upload-student-photo'])) {
                                            return 'STUDENT CARDS MANAGEMENT';
                                        }
                                        
                                        // Group exam permits permissions
                                        if (in_array($permission->name, ['view-exam-permits', 'search-exam-permits', 'generate-exam-permits', 'download-exam-permits', 'print-exam-permits', 'manage-exam-permits'])) {
                                            return 'EXAM PERMITS MANAGEMENT';
                                        }
                                        
                                        // Group academic records permissions
                                        if (in_array($permission->name, ['view-academic-records', 'search-academic-records', 'generate-academic-records', 'download-academic-records', 'print-academic-records', 'manage-academic-records'])) {
                                            return 'ACADEMIC RECORDS MANAGEMENT';
                                        }
                                        
                                        // Group proof of registration permissions
                                        if (in_array($permission->name, ['view-proof-of-registration', 'search-proof-of-registration', 'generate-proof-of-registration', 'download-proof-of-registration', 'print-proof-of-registration', 'manage-proof-of-registration'])) {
                                            return 'PROOF OF REGISTRATION MANAGEMENT';
                                        }
                                        
                                        // Group student letters permissions
                                        if (in_array($permission->name, ['view-student-letters', 'create-student-letters', 'edit-student-letters', 'delete-student-letters', 'generate-student-letters', 'print-student-letters', 'download-student-letters'])) {
                                            return 'STUDENT LETTERS MANAGEMENT';
                                        }
                                        
                                        // Group online application permissions
                                        if (in_array($permission->name, ['view-online-applications', 'create-online-applications', 'edit-online-applications', 'delete-online-applications', 'approve-online-applications', 'reject-online-applications', 'verify-application-documents', 'download-application-documents', 'manage-online-submissions'])) {
                                            return 'ONLINE APPLICATIONS MANAGEMENT';
                                        }
                                        
                                        // Group student portal permissions
                                        if (in_array($permission->name, ['access-student-portal', 'view-student-profile', 'view-student-academics', 'view-student-finance', 'view-student-subjects', 'access-online-learning', 'view-library-management', 'view-hostel-management', 'access-marketplace'])) {
                                            return 'STUDENT PORTAL ACCESS';
                                        }
                                        
                                        // Group student promotions permissions
                                        if (in_array($permission->name, ['view-student-promotions', 'create-student-promotions', 'edit-student-promotions', 'delete-student-promotions', 'promote-students', 'view-promotion-history', 'export-promotion-reports'])) {
                                            return 'STUDENT PROMOTIONS MANAGEMENT';
                                        }
                                        
                                        // Group marks suppression permissions
                                        if (in_array($permission->name, ['view-marks-suppression', 'create-marks-suppression', 'edit-marks-suppression', 'delete-marks-suppression', 'toggle-marks-suppression', 'manage-marks-suppression'])) {
                                            return 'MARKS SUPPRESSION MANAGEMENT';
                                        }
                                        
                                        // Group setup permissions
                                        if (in_array($permission->name, ['academic-years', 'add-academic-years', 'edit-academic-years', 'centers', 'add-centers', 'edit-centers', 'company', 'edit-company'])) {
                                            return 'SETUP MENU';
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
                                                <strong>{{ strtoupper($category) }}</strong> ({{ $categoryPermissions->count() }} permissions)
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