<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


if(version_compare(PHP_VERSION, '7.2.0', '>=')) {
    error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
}


Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/welcome', 'HomeController@welcome')->name('welcome');

Route::get('/success', function () 
{
    return view('auth.success');
})->name('auth.success');


//Management
Route::resource('/students', 'StudentController');
Route::post('/students/filter', 'StudentController@filter')->name('students.filter');
Route::post('/students/{id}/admission-status', 'StudentController@updateAdmissionStatus')->name('students.admission-status');
Route::get('/students/{id}/admission-status', 'StudentController@getAdmissionStatus')->name('students.get-admission-status');
Route::post('/students/verify-document/{documentId}', 'StudentController@verifyDocument')->name('students.verify-document');

// Manual Admissions
Route::get('/manual-admissions', 'ManualAdmissionsController@index')->name('manual-admissions.index');
Route::post('/manual-admissions/filter', 'ManualAdmissionsController@filter')->name('manual-admissions.filter');
Route::post('/manual-admissions/{id}/admission-status', 'ManualAdmissionsController@updateAdmissionStatus')->name('manual-admissions.admission-status');
Route::get('/manual-admissions/{id}/admission-status', 'ManualAdmissionsController@getAdmissionStatus')->name('manual-admissions.get-admission-status');
Route::get('/manual-admissions/{id}/admission-letter', 'ManualAdmissionsController@generateAdmissionLetter')->name('manual-admissions.admission-letter');

Route::resource('/enrolment', 'RegistrationController');
Route::post('/enrolment/filter', 'RegistrationController@filter')->name('enrolment.filter');
Route::get('enrolment/show-form/{student_id}', 'RegistrationController@showEnrollmentScreen')->name('enrolment.showEnrollmentScreen');
Route::get('enrolment/proof/{student_id}', 'RegistrationController@generateProofOfRegistration')->name('enrolment.proof');
Route::get('enrolment/proof/download/{student_id}', 'RegistrationController@downloadProofOfRegistration')->name('enrolment.proof.download');

Route::resource('/enrolment-adjustment', 'EnrolmentAdjustmentController');
Route::post('/enrolment-adjustment/filter', 'EnrolmentAdjustmentController@filter')->name('enrolment.adjustment.filter');
Route::get('enrolment-adjustment/show-form/{student_id}', 'EnrolmentAdjustmentController@showEnrollmentScreen')->name('enrolment.adjustment.showScreen');

Route::resource('/cancel-registration', 'CancelRegistrationController');
Route::post('/cancel-registration/filter', 'CancelRegistrationController@filter')->name('cancel-registration.filter');
Route::get('cancel/show-form/{student_id}', 'CancelRegistrationController@showCancellationScreen')->name('cancellation.showCancellationScreen');
Route::get('cancel/form/{id}', 'CancelRegistrationController@edit')->name('cancel-subject.edit');
Route::post('cancel/form/{id}', 'CancelRegistrationController@store')->name('cancellation.store');
Route::get('cancel/remove/{student_id}/{module_id}', 'CancelRegistrationController@removeCancellation')->name('cancellation.remove');

//Finance
Route::resource('/invoices', 'InvoiceController');
Route::post('/invoices/filter', 'InvoiceController@filter')->name('invoices.filter');
Route::get('/invoices/print/{student_id}', 'InvoiceController@print')->name('invoices.print');

// Cashier Routes - Protected with permissions
Route::middleware(['auth', 'permission:view-cashier'])->group(function () {
    Route::get('/cashier', 'CashierController@index')->name('cashier.index');
    Route::post('/cashier/search', 'CashierController@search')->name('cashier.search');
});

Route::middleware(['auth', 'permission:process-cashier-payments'])->group(function () {
    Route::get('/cashier/payment/{student}', 'CashierController@paymentForm')->name('cashier.payment-form');
    Route::post('/cashier/payment/{student}', 'CashierController@processPayment')->name('cashier.process-payment');
});

Route::middleware(['auth', 'permission:view-cashier-receipts'])->group(function () {
    Route::get('/cashier/receipt/{payment}', 'CashierController@receipt')->name('cashier.receipt');
});

Route::middleware(['auth', 'permission:print-cashier-receipts'])->group(function () {
    Route::get('/cashier/print/{payment}', 'CashierController@printReceipt')->name('cashier.print-receipt');
});

Route::resource('/payments', 'PaymentController');
Route::post('/payments/filter', 'PaymentController@filter')->name('payments.filter');

// Captured Payments Routes
Route::middleware(['auth', 'permission:view-captured-payments'])->group(function () {
    Route::get('/captured-payments', 'CapturedPaymentsController@index')->name('captured-payments.index');
    Route::match(['GET', 'POST'], '/captured-payments/search', 'CapturedPaymentsController@search')->name('captured-payments.search');
});

Route::middleware(['auth', 'permission:reprint-payment-receipts'])->group(function () {
    Route::post('/captured-payments/reprint', 'CapturedPaymentsController@reprintReceipt')->name('captured-payments.reprint');
});

Route::middleware(['auth', 'permission:void-payments'])->group(function () {
    Route::post('/captured-payments/void', 'CapturedPaymentsController@voidPayment')->name('captured-payments.void');
});

Route::middleware(['auth', 'permission:export-captured-payments'])->group(function () {
    Route::post('/captured-payments/export', 'CapturedPaymentsController@export')->name('captured-payments.export');
});

// Student Block Routes - Protected with permissions
Route::middleware(['auth', 'permission:view-student-blocks'])->group(function () {
    Route::get('/student-blocks', 'StudentBlockController@index')->name('student-blocks.index');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/student-blocks/create', 'StudentBlockController@create')->name('student-blocks.create');
    Route::post('/student-blocks', 'StudentBlockController@store')->name('student-blocks.store');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/student-blocks/bulk-block', 'StudentBlockController@bulkBlock')->name('student-blocks.bulk-block');
    Route::post('student-blocks/bulk-block/process', 'StudentBlockController@processBulkBlock')->name('student-blocks.bulk-block.process');
    Route::post('student-blocks/bulk-unblock/process', 'StudentBlockController@processBulkUnblock')->name('student-blocks.bulk-unblock.process');
});

Route::middleware(['auth', 'permission:unblock-students'])->group(function () {
    Route::patch('/student-blocks/{id}/unblock', 'StudentBlockController@unblockStudent')->name('student-blocks.unblock');
});

Route::middleware(['auth', 'permission:manage-block-exceptions'])->group(function () {
    Route::patch('/student-blocks/{id}/toggle-exception', 'StudentBlockController@toggleException')->name('student-blocks.toggle-exception');
});

Route::middleware(['auth', 'permission:delete-student-blocks'])->group(function () {
    Route::delete('/student-blocks/{id}', 'StudentBlockController@destroy')->name('student-blocks.destroy');
});

Route::resource('/debit-memos', 'DebitMemoController');
Route::post('/debit-memos/filter', 'DebitMemoController@filter')->name('debit-memos.filter');

Route::resource('/credit-memos', 'CreditMemoController');
Route::post('/credit-memos/filter', 'CreditMemoController@filter')->name('credit-memos.filter');

//Reports
Route::get('/student/reports', 'StudentReportController@index')->name('reports.students.index');
Route::post('/student/reports/search','StudentReportController@search')->name('reports.students.search');
Route::get('/student/reports/export', 'StudentReportController@export')->name('reports.students.export');

Route::get('/payment/reports', 'PaymentReportController@index')->name('reports.payments.index');
Route::post('/payment/reports/search', 'PaymentReportController@search')->name('reports.payments.search');
Route::get('/payment/reports/export', 'PaymentReportController@export')->name('reports.payments.export');

Route::get('/accounting/reports', 'InvoiceReportController@index')->name('reports.finance.index');
Route::post('/accounting/reports/search', 'InvoiceReportController@search')->name('reports.finance.search');
Route::get('/accounting/reports/export', 'InvoiceReportController@export')->name('reports.finance.export');

Route::get('/account-summary/reports', 'AccountSummaryController@index')->name('reports.account-summary.index');
Route::post('/account-summary/reports/search', 'AccountSummaryController@search')->name('reports.account-summary.search');
Route::get('/account-summary/reports/export', 'AccountSummaryController@export')->name('reports.account-summary.export');
Route::get('/account-summary/reports/download', 'AccountSummaryController@download')->name('download.account-summary-report');

Route::get('/aging/reports', 'InvoiceReportController@agingReport')->name('reports.finance.aging');
Route::get('/aging/reports/export', 'InvoiceReportController@export')->name('reports.aging.export');

// Online Application Routes (Public - no middleware)
Route::get('/signup', 'OnlineApplicationController@showSignupForm')->name('online-application.signup');
Route::post('/signup', 'OnlineApplicationController@createAccount')->name('online-application.create-account');

// Protected Online Application Routes (Require authentication)
Route::middleware(['auth'])->group(function () {
    Route::get('/student-info', 'OnlineApplicationController@showStudentInfoForm')->name('online-application.student-info');
    Route::post('/student-info', 'OnlineApplicationController@storeStudentInfo')->name('online-application.store-student-info');
    Route::get('/subject-selection', 'OnlineApplicationController@showSubjectSelection')->name('online-application.subject-selection');
    Route::post('/subject-selection', 'OnlineApplicationController@storeSubjectSelection')->name('online-application.store-subject-selection');
    Route::get('/document-upload', 'OnlineApplicationController@showDocumentUpload')->name('online-application.document-upload');
    Route::post('/document-upload', 'OnlineApplicationController@uploadDocument')->name('online-application.upload-document');
    Route::delete('/document/{id}', 'OnlineApplicationController@deleteDocument')->name('online-application.delete-document');
    Route::get('/review', 'OnlineApplicationController@showReview')->name('online-application.review');
    Route::post('/submit', 'OnlineApplicationController@submitApplication')->name('online-application.submit');
    Route::get('/acknowledgement', 'OnlineApplicationController@showAcknowledgement')->name('online-application.acknowledgement');
    Route::get('/download-acknowledgement', 'OnlineApplicationController@downloadAcknowledgement')->name('online-application.download-acknowledgement');
});

// Online Submissions (Admin) - Protected with permissions
Route::middleware(['auth', 'permission:manage-online-submissions'])->group(function () {
    Route::get('/online-submissions', 'OnlineSubmissionsController@index')->name('online-submissions.index');
    Route::post('/online-submissions/filter', 'OnlineSubmissionsController@filter')->name('online-submissions.filter');
    Route::get('/online-submissions/{id}', 'OnlineSubmissionsController@show')->name('online-submissions.show');
    Route::post('/online-submissions/{id}/update-status', 'OnlineSubmissionsController@updateStatus')->name('online-submissions.update-status');
    Route::get('/online-submissions/documents/{id}/download', 'OnlineSubmissionsController@downloadDocument')->name('online-submissions.download-document');
    Route::post('/online-submissions/documents/{id}/verify', 'OnlineSubmissionsController@verifyDocument')->name('online-submissions.verify-document');
});

// Parent Portal Routes
Route::group(['prefix' => 'parent-portal', 'middleware' => ['auth', 'user.type:parent']], function () {
    Route::get('/dashboard', 'ParentPortalController@dashboard')->name('parent-portal.dashboard');
    Route::get('/child/{studentId}/academic-records', 'ParentPortalController@childAcademicRecords')->name('parent-portal.child-academic-records');
    Route::get('/child/{studentId}/payments', 'ParentPortalController@childPayments')->name('parent-portal.child-payments');
});

// Student Portal Routes - Protected with permissions
Route::group(['prefix' => 'student-portal', 'middleware' => ['auth', 'user.type:student']], function () {
    Route::get('/', 'StudentPortalController@index')->name('student-portal.index');
    Route::get('/dashboard', 'StudentPortalController@dashboard')->name('student-portal.dashboard');
    
    // Profile Section
    Route::get('/profile', 'StudentPortalController@profile')->name('student-portal.profile');
    Route::get('/my-info', 'StudentPortalController@myInfo')->name('student-portal.my-info');
    Route::get('/my-documents', 'StudentPortalController@myDocuments')->name('student-portal.my-documents');
    Route::get('/my-applications', 'StudentPortalController@myApplications')->name('student-portal.my-applications');
    
    // Academics Section
    Route::get('/academics', 'StudentPortalController@academics')->name('student-portal.academics');
    Route::get('/academic-records', 'StudentPortalController@academicRecords')->name('student-portal.academic-records');
    Route::get('/assignments', 'StudentPortalController@assignments')->name('student-portal.assignments');
    Route::get('/grades', 'StudentPortalController@grades')->name('student-portal.grades');
    Route::get('/ca-marks', 'StudentPortalController@caMarks')->name('student-portal.ca-marks');
    Route::get('/exam-marks', 'StudentPortalController@examMarks')->name('student-portal.exam-marks');
    Route::get('/class-routine', 'StudentPortalController@classRoutine')->name('student-portal.class-routine');
    Route::get('/class-routine-download', 'StudentPortalController@downloadClassRoutine')->name('student-portal.class-routine.download');
    Route::get('/exam-timetable', 'StudentPortalController@examTimetable')->name('student-portal.exam-timetable');
    Route::get('/exam-timetable-pdf', 'StudentPortalController@examTimetablePdf')->name('student-portal.exam-timetable-pdf');
    Route::get('/academic-script', 'StudentPortalController@academicScript')->name('student-portal.academic-script');
    Route::get('/proof-of-registration', 'StudentPortalController@proofOfRegistration')->name('student-portal.proof-of-registration');
    Route::get('/proof-of-registration-download', 'StudentPortalController@downloadProofOfRegistration')->name('student-portal.academics.proof-of-registration.download');
    
    // Finance Section
    Route::get('/finance', 'StudentPortalController@finance')->name('student-portal.finance');
    Route::get('/my-payments', 'StudentPortalController@myPayments')->name('student-portal.my-payments');
    Route::get('/print-payment-receipt/{paymentId}/{paymentSource}', 'StudentPortalController@printPaymentReceipt')->name('student-portal.print-payment-receipt');
    Route::get('/financial-statement', 'StudentPortalController@financialStatement')->name('student-portal.financial-statement');
    
    // My Subjects
    Route::get('/my-subjects', 'StudentPortalController@mySubjects')->name('student-portal.my-subjects');
    Route::get('/my-attendance/{allocation}', 'StudentPortalController@myAttendance')->name('student-portal.my-attendance');
    Route::get('/subject-materials/{allocation}', 'StudentPortalController@subjectMaterials')->name('student-portal.subject-materials');
    Route::get('/download-subject-material/{material}', 'StudentPortalController@downloadSubjectMaterial')->name('student-portal.download-subject-material');
    
    // Online Learning
    Route::get('/online-learning', 'StudentPortalController@onlineLearning')->name('student-portal.online-learning');
    
    // Library Management
    Route::get('/library-books', 'StudentPortalController@libraryBooks')->name('student-portal.library-books');
    Route::get('/library-fines', 'StudentPortalController@libraryFines')->name('student-portal.library-fines');
    Route::get('/borrow-history', 'StudentPortalController@borrowHistory')->name('student-portal.borrow-history');
    
    // Hostel Management
    Route::get('/hostel-applications', 'StudentPortalController@hostelApplications')->name('student-portal.hostel-applications');
    Route::get('/my-hostel-data', 'StudentPortalController@myHostelData')->name('student-portal.my-hostel-data');
    
    // Market Place
    Route::get('/marketplace', 'StudentPortalController@marketplace')->name('student-portal.marketplace');
    
    // Support Centre
    Route::get('/user-manuals', 'StudentPortalController@userManuals')->name('student-portal.user-manuals');
    Route::get('/video-tutorials', 'StudentPortalController@videoTutorials')->name('student-portal.video-tutorials');
    Route::get('/faq-help', 'StudentPortalController@faqHelp')->name('student-portal.faq-help');
    Route::get('/quick-support', 'StudentPortalController@quickSupport')->name('student-portal.quick-support');
    Route::get('/get-support', 'StudentPortalController@getSupport')->name('student-portal.get-support');
});

// Student Portal Administration Routes
Route::get('/student-portal-administration', 'StudentPortalAdministrationController@index')->name('student-portal-administration.index')->middleware(['auth', 'permission:access-student-portal']);

Route::get('/audit/reports', 'AuditReportController@index')->name('reports.audit');
Route::get('/audit/show/{id}', 'AuditReportController@show')->name('reports.audit.show');
Route::post('/audit/reports/search', 'AuditReportController@search')->name('reports.audit.search');

// Coming Soon Reports Route
Route::get('/reports/coming-soon/{report}', 'ReportsComingSoonController@show')->name('reports.coming-soon');

//Ajax URLs
Route::get('get-subjects', 'HomeController@fetchSubjects');

//LMS setups
Route::resource('/subjects', 'ModuleController');
Route::resource('/company', 'CompanySetupController');
Route::resource('/fees', 'FeesController');
Route::resource('/centers', 'CenterController');
Route::resource('/academic-year', 'AcademicYearController');
Route::get('/academic-year/status/{id}', 'AcademicYearController@updateStatus')->name('academic-year.status');

//Access Management - setups
Route::resource('/users','UsersController', ['except' => ['show']]);
Route::get('/users/show', 'UsersController@show')->name('users.show')->middleware('permission:view-student-passwords');
Route::get('/users/{username}/details', 'UsersController@showSingle')->name('users.details');
Route::get('/users/{username}/change-password', 'UsersController@showChangePassword')->name('users.change-password');
Route::put('/users/{username}/update-password', 'UsersController@updatePassword')->name('users.update-password');

// Student Password Management
Route::get('/users/reset-students', 'UsersController@resetStudents')->name('users.reset-students')->middleware('permission:view-student-passwords');
Route::get('/users/{username}/reset-student-password', 'UsersController@showStudentPasswordReset')->name('users.reset-student-password')->middleware('permission:reset-student-passwords');
Route::put('/users/{username}/update-student-password', 'UsersController@updateStudentPassword')->name('users.update-student-password')->middleware('permission:reset-student-passwords');
Route::resource('/roles','RolesController');

//Employee Management
Route::get('/employee-bio', 'EmployeeController@index')->name('employees.index');
Route::get('/employees/{id}', 'EmployeeController@show')->name('employees.show');
Route::get('/employees/{id}/edit', 'EmployeeController@edit')->name('employees.edit');
Route::put('/employees/{id}', 'EmployeeController@update')->name('employees.update');
Route::delete('/employees/{id}', 'EmployeeController@destroy')->name('employees.destroy');

//Leave Management (Admin)
Route::get('/leave-management', 'LeaveManagementController@index')->name('leave-management.index');
Route::get('/leave-management/create', 'LeaveManagementController@create')->name('leave-management.create');
Route::post('/leave-management', 'LeaveManagementController@store')->name('leave-management.store');
Route::get('/leave-management/{leaveRequest}', 'LeaveManagementController@show')->name('leave-management.show');
Route::get('/leave-management/{leaveRequest}/edit', 'LeaveManagementController@edit')->name('leave-management.edit');
Route::put('/leave-management/{leaveRequest}', 'LeaveManagementController@update')->name('leave-management.update');
Route::delete('/leave-management/{leaveRequest}', 'LeaveManagementController@destroy')->name('leave-management.destroy');
Route::post('/leave-management/{leaveRequest}/approve', 'LeaveManagementController@approve')->name('leave-management.approve');
Route::post('/leave-management/{leaveRequest}/reject', 'LeaveManagementController@reject')->name('leave-management.reject');

//Leave Applications (Employee)
Route::get('/leave-applications', 'LeaveApplicationController@index')->name('leave-applications.index');
Route::get('/leave-applications/create', 'LeaveApplicationController@create')->name('leave-applications.create');
Route::post('/leave-applications', 'LeaveApplicationController@store')->name('leave-applications.store');
Route::get('/leave-applications/{leaveApplication}', 'LeaveApplicationController@show')->name('leave-applications.show');
Route::get('/leave-applications/{leaveApplication}/edit', 'LeaveApplicationController@edit')->name('leave-applications.edit');
Route::put('/leave-applications/{leaveApplication}', 'LeaveApplicationController@update')->name('leave-applications.update');
Route::delete('/leave-applications/{leaveApplication}', 'LeaveApplicationController@destroy')->name('leave-applications.destroy');
Route::post('/leave-applications/{leaveApplication}/cancel', 'LeaveApplicationController@cancel')->name('leave-applications.cancel');

//Payroll Management
Route::middleware(['permission:access-payroll-system'])->group(function () {
    // Dashboard
    Route::get('/payroll', 'PayrollController@index')->name('payroll.index');
    Route::get('/payroll-management', 'PayrollController@index')->name('payroll-management.index');
    
    // Payroll Periods
    Route::get('/payroll/periods', 'PayrollController@periods')->name('payroll.periods');
    Route::get('/payroll/periods/create', 'PayrollController@createPeriod')->name('payroll.periods.create');
    Route::post('/payroll/periods', 'PayrollController@storePeriod')->name('payroll.periods.store');
    Route::get('/payroll/periods/{period}/edit', 'PayrollController@editPeriod')->name('payroll.periods.edit');
    Route::patch('/payroll/periods/{period}', 'PayrollController@updatePeriod')->name('payroll.periods.update');
    Route::delete('/payroll/periods/{period}', 'PayrollController@deletePeriod')->name('payroll.periods.destroy');
    Route::post('/payroll/periods/{period}/process', 'PayrollController@processPeriod')->name('payroll.periods.process');
    
    // Employee Payroll Settings
    Route::get('/payroll/employees', 'PayrollController@employees')->name('payroll.employees.index');
    Route::get('/payroll/employees/create', 'PayrollController@createEmployee')->name('payroll.employees.create');
    Route::post('/payroll/employees', 'PayrollController@storeEmployee')->name('payroll.employees.store');
    Route::get('/payroll/employees/{employee}/edit', 'PayrollController@editEmployee')->name('payroll.employees.edit');
    Route::patch('/payroll/employees/{employee}', 'PayrollController@updateEmployee')->name('payroll.employees.update');
    
    // Pay Slips
    Route::get('/payroll/pay-slips', 'PayrollController@paySlips')->name('payroll.pay-slips');
    Route::get('/payroll/pay-slips/{paySlip}', 'PayrollController@showPaySlip')->name('payroll.pay-slips.show');
    Route::get('/payroll/pay-slips/{paySlip}/print', 'PayrollController@printPaySlip')->name('payroll.pay-slips.print');
    Route::get('/payroll/pay-slips/{paySlip}/download', 'PayrollController@downloadPaySlip')->name('payroll.pay-slips.download');
    Route::post('/payroll/pay-slips/{paySlip}/approve', 'PayrollController@approvePaySlip')->name('payroll.pay-slips.approve');
    
    // Payroll Items
    Route::get('/payroll/items', 'PayrollController@items')->name('payroll.items');
    Route::get('/payroll/items/create', 'PayrollController@createItem')->name('payroll.items.create');
    Route::post('/payroll/items', 'PayrollController@storeItem')->name('payroll.items.store');
    Route::get('/payroll/items/{item}/edit', 'PayrollController@editItem')->name('payroll.items.edit');
    Route::patch('/payroll/items/{item}', 'PayrollController@updateItem')->name('payroll.items.update');
    Route::delete('/payroll/items/{item}', 'PayrollController@deleteItem')->name('payroll.items.destroy');
    
    // Reports
    Route::get('/payroll/reports', 'PayrollController@reports')->name('payroll.reports');
});

//Inventory Management
Route::resource('/inventories', 'InventoryController');
Route::get('/inventories/{inventory}/adjust-stock', 'InventoryController@adjustStock')->name('inventories.adjust-stock');
Route::post('/inventories/{inventory}/adjust-stock', 'InventoryController@processStockAdjustment')->name('inventories.process-stock-adjustment');
Route::get('/inventories/{inventory}/stock-movement', 'InventoryController@stockMovement')->name('inventories.stock-movement');
Route::post('/inventories/{inventory}/stock-movement', 'InventoryController@processStockMovement')->name('inventories.process-stock-movement');
Route::get('/inventory/low-stock', 'InventoryController@lowStock')->name('inventories.low-stock');
Route::get('/inventory/expired', 'InventoryController@expired')->name('inventories.expired');

//Inventory Categories
Route::resource('/inventory-categories', 'InventoryCategoryController');

// Fixed Assets Management
Route::resource('/fixed-assets', 'FixedAssetController');
Route::get('/fixed-assets/{fixedAsset}/schedule-maintenance', 'FixedAssetController@scheduleMaintenance')->name('fixed-assets.schedule-maintenance');
Route::post('/fixed-assets/{fixedAsset}/schedule-maintenance', 'FixedAssetController@storeMaintenanceSchedule')->name('fixed-assets.store-maintenance-schedule');
Route::get('/fixed-assets/reports/maintenance-due', 'FixedAssetController@maintenanceDue')->name('fixed-assets.maintenance-due');
Route::get('/fixed-assets/reports/warranty-expired', 'FixedAssetController@warrantyExpired')->name('fixed-assets.warranty-expired');

// Fixed Asset Categories Management
Route::resource('/fixed-asset-categories', 'FixedAssetCategoryController');

// Maintenance Management
Route::resource('/maintenance', 'MaintenanceController');
Route::post('/maintenance/{maintenance}/approve', 'MaintenanceController@approve')->name('maintenance.approve');
Route::post('/maintenance/{maintenance}/reject', 'MaintenanceController@reject')->name('maintenance.reject');
Route::get('/maintenance/reports/dashboard', 'MaintenanceController@reports')->name('maintenance.reports');
Route::get('/maintenance/reports/overdue', 'MaintenanceController@overdueRequests')->name('maintenance.overdue-requests');
Route::get('/maintenance/reports/completed', 'MaintenanceController@completedRequests')->name('maintenance.completed-requests');

// Maintenance Categories Management
Route::resource('/maintenance-categories', 'MaintenanceCategoryController');

//Access Management - Permissions
Route::resource('/permissions','PermissionsController');
// Route::get('/permissions/{id}/create', 'PermissionsController@create')->name('permissions.createWithId');

//Assessment Management - Module Allocations
Route::resource('module-allocations', 'ModuleAllocationController')->middleware('auth');

// My Modules routes
Route::group(['middleware' => 'auth', 'prefix' => 'my-modules'], function() {
    Route::get('/', 'MyModulesController@index')->name('my-modules.index');
    Route::get('/{allocation}/class-list', 'MyModulesController@classList')->name('my-modules.class-list');
    Route::get('/{allocation}/attendance', 'MyModulesController@attendance')->name('my-modules.attendance');
    Route::get('/{allocation}/mark-attendance', 'MyModulesController@markAttendance')->name('my-modules.mark-attendance');
    Route::post('/{allocation}/store-attendance', 'MyModulesController@storeAttendance')->name('my-modules.store-attendance');
    Route::get('/{allocation}/attendance-data', 'MyModulesController@attendanceData')->name('my-modules.attendance-data');
    
    // Subject Materials routes
    Route::get('/{allocation}/subject-materials', 'MyModulesController@subjectMaterials')->name('my-modules.subject-materials');
    Route::get('/{allocation}/upload-material', 'MyModulesController@uploadMaterial')->name('my-modules.upload-material');
    Route::post('/{allocation}/store-material', 'MyModulesController@storeMaterial')->name('my-modules.store-material');
    Route::get('/edit-material/{material}', 'MyModulesController@editMaterial')->name('my-modules.edit-material');
    Route::put('/update-material/{material}', 'MyModulesController@updateMaterial')->name('my-modules.update-material');
    Route::get('/download-material/{material}', 'MyModulesController@downloadMaterial')->name('my-modules.download-material');
    Route::delete('/delete-material/{material}', 'MyModulesController@deleteMaterial')->name('my-modules.delete-material');
});

// Class Routine Management
Route::middleware('auth')->group(function () {
    Route::get('class-routine', 'ClassRoutineController@index')->name('class-routine.index');
    Route::get('class-routine/create', 'ClassRoutineController@create')->name('class-routine.create');
    Route::post('class-routine', 'ClassRoutineController@store')->name('class-routine.store');
    Route::post('class-routine/check-conflicts', 'ClassRoutineController@checkConflicts')->name('class-routine.check-conflicts');
    Route::get('class-routine/{id}', 'ClassRoutineController@show')->name('class-routine.show');
    Route::get('class-routine/{id}/edit', 'ClassRoutineController@edit')->name('class-routine.edit');
    Route::put('class-routine/{id}', 'ClassRoutineController@update')->name('class-routine.update');
    Route::delete('class-routine/{id}', 'ClassRoutineController@destroy')->name('class-routine.destroy');
    Route::get('/class-routine/print', 'ClassRoutineController@print')->name('class-routine.print');
});

// Class Duration Management Routes
Route::middleware('auth')->group(function () {
    Route::get('class-durations', 'ClassDurationController@index')->name('class-durations.index');
    Route::put('class-durations', 'ClassDurationController@update')->name('class-durations.update');
});

Route::post('/subject-allocations/filter', 'SubjectAllocationController@filter')->name('subject-allocations.filter');
Route::get('/subject-allocations/show-form/{student_id}', 'SubjectAllocationController@showAllocationScreen')->name('subject-allocations.showAllocationScreen');
Route::get('/subject-allocations/un-allocate/{id}', 'SubjectAllocationController@unAllocate')->name('subject-allocations.unAllocate');

//Assessment Management - Class List
Route::resource('/class-lists','ClassListController');

//Assessment Management - Assessment Types
Route::get('/assessment-types','AssessmentTypeController@index');
Route::get('/assessment-types/{subject_allocation_id}','AssessmentTypeController@showAssessmentTypes');
Route::get('/assessment-types/create/{subject_allocation_id}','AssessmentTypeController@create');
Route::get('/assessment-types/edit/{id}','AssessmentTypeController@edit');
Route::post('/assessment-types/store', 'AssessmentTypeController@store');
Route::post('/assessment-types/update/{id}', 'AssessmentTypeController@update')->name('assessment-types.update');

//Assessment Management - Assessments
Route::get('/assessments','AssessmentTypeController@index')->name('assessments.index');
Route::get('/assessments/show-assessments-types/{subject_allocated}','AssessmentController@showAssessmentTypes');
Route::get('/assessments/show-assessments/{assessment_type}','AssessmentController@showAssessments');
Route::get('/assessments/create','AssessmentTypeController@create')->name('assessments.create');
Route::post('/assessments','AssessmentTypeController@store')->name('assessments.store');
Route::get('/assessments/{id}/edit','AssessmentTypeController@edit')->name('assessments.edit');
Route::put('/assessments/{id}','AssessmentTypeController@update')->name('assessments.update');
Route::get('/assessments/{assessment_type_id}/edit/{assessment_id}','AssessmentController@edit');
Route::post('/assessments/store', 'AssessmentController@store');
Route::post('/assessments/update/{id}', 'AssessmentController@update')->name('assessment-items.update');

//Assessment Management - Assessment Weights
Route::get('/assessment-weights', 'AssessmentWeightController@index')->name('assessment-weights.index');
Route::get('/assessment-weights/create', 'AssessmentWeightController@create')->name('assessment-weights.create');
Route::post('/assessment-weights', 'AssessmentWeightController@store')->name('assessment-weights.store');
Route::get('/assessment-weights/{moduleId}/{academicYearId}/edit', 'AssessmentWeightController@edit')->name('assessment-weights.edit');
Route::put('/assessment-weights/{moduleId}/{academicYearId}', 'AssessmentWeightController@update')->name('assessment-weights.update');
Route::delete('/assessment-weights/{moduleId}/{academicYearId}', 'AssessmentWeightController@destroy')->name('assessment-weights.destroy');

//Assessment Management - Exam Paper Weights
Route::get('/exam-paper-weights', 'ExamPaperWeightController@index')->name('exam-paper-weights.index');
Route::get('/exam-paper-weights/create', 'ExamPaperWeightController@create')->name('exam-paper-weights.create');
Route::post('/exam-paper-weights', 'ExamPaperWeightController@store')->name('exam-paper-weights.store');
Route::get('/exam-paper-weights/{moduleId}/{academicYearId}/{assessmentTypeId}/edit', 'ExamPaperWeightController@edit')->name('exam-paper-weights.edit');
Route::put('/exam-paper-weights/{moduleId}/{academicYearId}/{assessmentTypeId}', 'ExamPaperWeightController@update')->name('exam-paper-weights.update');
Route::delete('/exam-paper-weights/{moduleId}/{academicYearId}/{assessmentTypeId}', 'ExamPaperWeightController@destroy')->name('exam-paper-weights.destroy');

//Assessment Management - Assessment Marks
Route::get('/assessment-marks', 'AssessmentMarkController@index'); //show subjects allocated -> assessment types -> assessments
Route::get('/assessment-marks/{subject_allocation_id}', 'AssessmentMarkController@showAssessments'); // assessment types & assessments
Route::get('/assessment-marks/create/{assessment_id}', 'AssessmentMarkController@create');
Route::post('/assessment-marks/store', 'AssessmentMarkController@store')->name('assessment-marks.store');
Route::put('/assessment-marks/update/{assessment_id}', 'AssessmentMarkController@update');

//Assessment Management    // Test Marks Routes
    Route::get('/test-marks', 'TestMarksController@index')->name('test-marks.index')->middleware('permission:test-marks');
    Route::get('/test-marks/{module}/{centre}/{assessmentType}/capture', 'TestMarksController@captureMarks')->name('test-marks.capture')->middleware('permission:capture-test-marks');
    Route::post('/test-marks/{module}/{centre}/{assessmentType}/store', 'TestMarksController@storeMarks')->name('test-marks.store')->middleware('permission:capture-test-marks');
    Route::get('/test-marks/{module}/{centre}/view-all', 'TestMarksController@viewAll')->name('test-marks.view-all')->middleware('permission:view-all-test-marks');
    Route::delete('/test-marks/{testMark}', 'TestMarksController@destroy')->name('test-marks.destroy')->middleware('permission:delete-test-marks');

// Exam Marks Routes
Route::get('/exam-marks', 'ExamMarksController@index')->name('exam-marks.index')->middleware('permission:exam-marks');
Route::get('/exam-marks/{examType}/{module}/{centre}/{examPaper}/capture', 'ExamMarksController@captureMarks')->name('exam-marks.capture')->middleware('permission:capture-exam-marks');
Route::post('/exam-marks/{examType}/{module}/{centre}/{examPaper}/store', 'ExamMarksController@storeMarks')->name('exam-marks.store')->middleware('permission:capture-exam-marks');
Route::get('/exam-marks/{examType}/{module}/{centre}/view-all', 'ExamMarksController@viewAll')->name('exam-marks.view-all')->middleware('permission:view-all-exam-marks');
Route::delete('/exam-marks/{examMark}', 'ExamMarksController@destroy')->name('exam-marks.destroy')->middleware('permission:delete-exam-marks');

Route::resource('/examinations', 'ExaminationController');

// Examination Schedule Routes
Route::get('/examination-schedule', 'ExaminationScheduleController@index')->name('examination-schedule.index')->middleware('permission:view-examination-schedule');
Route::get('/examination-schedule/create', 'ExaminationScheduleController@create')->name('examination-schedule.create')->middleware('permission:create-examination-schedule');
Route::post('/examination-schedule', 'ExaminationScheduleController@store')->name('examination-schedule.store')->middleware('permission:create-examination-schedule');
Route::get('/examination-schedule/{id}/edit', 'ExaminationScheduleController@edit')->name('examination-schedule.edit')->middleware('permission:edit-examination-schedule');
Route::put('/examination-schedule/{id}', 'ExaminationScheduleController@update')->name('examination-schedule.update')->middleware('permission:edit-examination-schedule');
Route::delete('/examination-schedule/{id}', 'ExaminationScheduleController@destroy')->name('examination-schedule.destroy')->middleware('permission:delete-examination-schedule');
Route::get('/examination-schedule/timetable', 'ExaminationScheduleController@timetable')->name('examination-schedule.timetable')->middleware('permission:view-examination-schedule');
Route::get('/examination-schedule/print', 'ExaminationScheduleController@print')->name('examination-schedule.print')->middleware('permission:print-examination-schedule');

// AJAX Routes for Examination Schedule
Route::get('/examination-schedule/get-subject-allocations', 'ExaminationScheduleController@getSubjectAllocations')->name('examination-schedule.get-subject-allocations')->middleware('permission:view-examination-schedule');
Route::get('/examination-schedule/get-modules', 'ExaminationScheduleController@getModules')->name('examination-schedule.get-modules')->middleware('permission:view-examination-schedule');
Route::get('/examination-schedule/get-teachers', 'ExaminationScheduleController@getTeachers')->name('examination-schedule.get-teachers')->middleware('permission:view-examination-schedule');
Route::get('/examination-schedule/get-venues', 'ExaminationScheduleController@getVenues')->name('examination-schedule.get-venues')->middleware('permission:view-examination-schedule');
Route::get('/examination-schedule/check-conflicts', 'ExaminationScheduleController@checkConflicts')->name('examination-schedule.check-conflicts')->middleware('permission:view-examination-schedule');

// Venue Management Routes
Route::resource('venues', 'VenueController')->middleware('permission:view-venue');
Route::post('/venues/{venue}/toggle-status', 'VenueController@toggleStatus')->name('venues.toggle-status')->middleware('permission:edit-venue');

// Time Slots Management Routes
Route::resource('time-slots', 'TimeSlotsController')->middleware('permission:view-time-slot');
Route::post('/time-slots/{timeSlot}/toggle-status', 'TimeSlotsController@toggleStatus')->name('time-slots.toggle-status')->middleware('permission:edit-time-slot');

//Assessment Management - Student Promotions
Route::get('/promotions', 'PromotionsController@index')->name('promotions.index')->middleware('permission:view-student-promotions');
Route::get('/promotions/search', 'PromotionsController@search')->name('promotions.search')->middleware('permission:view-student-promotions');
Route::get('/promotions/{student}/marks', 'PromotionsController@showMarks')->name('promotions.marks')->middleware('permission:promote-students');
Route::post('/promotions/{student}/promote', 'PromotionsController@promote')->name('promotions.promote')->middleware('permission:promote-students');
Route::get('/promotions/{student}/history', 'PromotionsController@history')->name('promotions.history')->middleware('permission:view-promotion-history');

//Assessment Management - Process Final Marks
Route::get('/process-final-marks', 'ProcessFinalMarksController@index')->name('process-final-marks.index');

//Result Codes Management
Route::resource('/result-codes', 'ResultCodeController');
// Grading Scales Management
Route::group(['middleware' => ['auth']], function () {
    Route::resource('grading-scales', 'GradingScaleController');
});

// Promotional Statuses Management
Route::group(['middleware' => ['auth']], function () {
    Route::resource('promotional-statuses', 'PromotionalStatusController');
});
Route::get('/start-page', function(){
    return view('start-page');
});

//Fleet Management Routes
Route::prefix('fleet-management')->name('fleet.')->middleware('permission:fleet-management')->group(function () {
    Route::get('/', 'FleetManagementController@index')->name('dashboard');
    
    // Vehicle Management
    Route::get('/vehicles', 'FleetManagementController@vehicles')->name('vehicles');
    Route::get('/vehicles/create', 'FleetManagementController@createVehicle')->name('vehicles.create');
    Route::post('/vehicles', 'FleetManagementController@storeVehicle')->name('vehicles.store');
    Route::get('/vehicles/{vehicle}/edit', 'FleetManagementController@editVehicle')->name('vehicles.edit');
    Route::put('/vehicles/{vehicle}', 'FleetManagementController@updateVehicle')->name('vehicles.update');
    Route::delete('/vehicles/{vehicle}', 'FleetManagementController@destroyVehicle')->name('vehicles.destroy');
    
    // Driver Management
    Route::get('/drivers', 'FleetManagementController@drivers')->name('drivers');
    Route::get('/drivers/create', 'FleetManagementController@createDriver')->name('drivers.create');
    Route::post('/drivers', 'FleetManagementController@storeDriver')->name('drivers.store');
    Route::get('/drivers/{driver}', 'FleetManagementController@showDriver')->name('drivers.show');
    Route::get('/drivers/{driver}/edit', 'FleetManagementController@editDriver')->name('drivers.edit');
    Route::put('/drivers/{driver}', 'FleetManagementController@updateDriver')->name('drivers.update');
    Route::delete('/drivers/{driver}', 'FleetManagementController@destroyDriver')->name('drivers.destroy');
    
    // Trip Management
    Route::get('/trips', 'FleetManagementController@trips')->name('trips');
    Route::get('/trips/create', 'FleetManagementController@createTrip')->name('trips.create');
    Route::post('/trips', 'FleetManagementController@storeTrip')->name('trips.store');
    Route::get('/trips/{trip}', 'FleetManagementController@showTrip')->name('trips.show');
    Route::get('/trips/{trip}/edit', 'FleetManagementController@editTrip')->name('trips.edit');
    Route::put('/trips/{trip}', 'FleetManagementController@updateTrip')->name('trips.update');
    Route::delete('/trips/{trip}', 'FleetManagementController@destroyTrip')->name('trips.destroy');
    
    // Fuel Management
    Route::get('/fuel', 'FleetManagementController@fuel')->name('fuel');
    Route::get('/fuel/create', 'FleetManagementController@createFuelRecord')->name('fuel.create');
    Route::post('/fuel', 'FleetManagementController@storeFuelRecord')->name('fuel.store');
    
    // Service Management
    Route::get('/services', 'FleetManagementController@services')->name('services');
    Route::get('/services/create', 'FleetManagementController@createService')->name('services.create');
    Route::post('/services', 'FleetManagementController@storeService')->name('services.store');
    Route::get('/services/{service}', 'FleetManagementController@showService')->name('services.show');
    Route::get('/services/{service}/edit', 'FleetManagementController@editService')->name('services.edit');
    Route::put('/services/{service}', 'FleetManagementController@updateService')->name('services.update');
    Route::delete('/services/{service}', 'FleetManagementController@destroyService')->name('services.destroy');
    
    // Vehicle Assignments
    Route::get('/assignments', 'FleetManagementController@assignments')->name('assignments');
    Route::get('/assignments/create', 'FleetManagementController@createAssignment')->name('assignments.create');
    Route::post('/assignments', 'FleetManagementController@storeAssignment')->name('assignments.store');
    Route::get('/assignments/{assignment}', 'FleetManagementController@showAssignment')->name('assignments.show');
    Route::get('/assignments/{assignment}/edit', 'FleetManagementController@editAssignment')->name('assignments.edit');
    Route::put('/assignments/{assignment}', 'FleetManagementController@updateAssignment')->name('assignments.update');
    Route::delete('/assignments/{assignment}', 'FleetManagementController@destroyAssignment')->name('assignments.destroy');
    
    // Reports
    Route::get('/reports', 'FleetManagementController@reports')->name('reports');
    Route::get('/reports/vehicle-utilization', 'FleetManagementController@vehicleUtilizationReport')->name('reports.vehicle-utilization');
    Route::get('/reports/fuel-consumption', 'FleetManagementController@fuelConsumptionReport')->name('reports.fuel-consumption');
    Route::get('/reports/maintenance', 'FleetManagementController@maintenanceReport')->name('reports.maintenance');
    Route::get('/reports/driver-performance', 'FleetManagementController@driverPerformanceReport')->name('reports.driver-performance');
    Route::get('/reports/cost-analysis', 'FleetManagementController@costAnalysisReport')->name('reports.cost-analysis');
    Route::get('/reports/trip-summary', 'FleetManagementController@tripSummaryReport')->name('reports.trip-summary');
});

//Hostel Management Routes
Route::prefix('hostel-administration')->name('hostel.administration.')->group(function () {
    Route::get('/', 'HostelAdministrationController@index')->name('index');
    
    // Hostel Management
    Route::get('/hostels', 'HostelAdministrationController@hostels')->name('hostels');
    Route::get('/hostels/create', 'HostelAdministrationController@createHostel')->name('hostels.create');
    Route::post('/hostels', 'HostelAdministrationController@storeHostel')->name('hostels.store');
    Route::get('/hostels/{hostel}/edit', 'HostelAdministrationController@editHostel')->name('hostels.edit');
    Route::put('/hostels/{hostel}', 'HostelAdministrationController@updateHostel')->name('hostels.update');
    
    // Block Management
    Route::get('/blocks/{hostelId?}', 'HostelAdministrationController@blocks')->name('blocks');
    Route::get('/blocks-create', 'HostelAdministrationController@createBlock')->name('blocks.create');
    Route::post('/blocks', 'HostelAdministrationController@storeBlock')->name('blocks.store');
    
    // Room Management
    Route::get('/rooms/{blockId?}', 'HostelAdministrationController@rooms')->name('rooms');
    Route::get('/rooms-create', 'HostelAdministrationController@createRoom')->name('rooms.create');
    Route::post('/rooms', 'HostelAdministrationController@storeRoom')->name('rooms.store');
    
    // Bed Management
    Route::get('/beds/{roomId?}', 'HostelAdministrationController@beds')->name('beds');
    
    // Student Allocation
    Route::get('/allocations', 'HostelAdministrationController@allocations')->name('allocations');
    Route::get('/allocations/create', 'HostelAdministrationController@createAllocation')->name('allocations.create');
    Route::post('/allocations', 'HostelAdministrationController@storeAllocation')->name('allocations.store');
    
    // Payment Management
    Route::get('/payments', 'HostelAdministrationController@payments')->name('payments');
    Route::get('/payments/create', 'HostelAdministrationController@createPayment')->name('payments.create');
    Route::post('/payments', 'HostelAdministrationController@storePayment')->name('payments.store');
    Route::post('/payments/record', 'HostelAdministrationController@recordPayment')->name('payments.record');
    
    // Fee Structure
    Route::get('/fee-structures', 'HostelAdministrationController@feeStructures')->name('fee-structures');
    
    // Maintenance
    Route::get('/maintenance', 'HostelAdministrationController@maintenance')->name('maintenance');
    
    // Visitors
    Route::get('/visitors', 'HostelAdministrationController@visitors')->name('visitors');
    
    // Reports
    Route::get('/reports', 'HostelAdministrationController@reports')->name('reports');
});

// Student Cards Routes
Route::get('/student-cards', 'StudentCardController@index')->name('student-cards.index')->middleware('permission:view-student-cards');
Route::post('/student-cards/filter', 'StudentCardController@filter')->name('student-cards.filter')->middleware('permission:view-student-cards');
Route::group(['middleware' => ['permission:generate-student-cards']], function () {
    Route::get('/student-cards/generate/{student}', 'StudentCardController@generate')->name('student-cards.generate');
});
Route::group(['middleware' => ['permission:print-student-cards']], function () {
    Route::get('/student-cards/print/{student}', 'StudentCardController@print')->name('student-cards.print');
});
Route::group(['middleware' => ['permission:upload-student-photo']], function () {
    Route::post('/student-cards/{student}/upload-photo', 'StudentCardController@uploadPhoto')->name('student-cards.upload-photo');
});

// Exam Permits Routes
Route::group(['middleware' => ['permission:view-exam-permits']], function () {
    Route::get('/exam-permits', 'ExamPermitsController@index')->name('exam-permits.index');
    Route::post('/exam-permits/filter', 'ExamPermitsController@filter')->name('exam-permits.filter');
});
Route::group(['middleware' => ['permission:generate-exam-permits']], function () {
    Route::get('/exam-permits/generate/{student}', 'ExamPermitsController@generate')->name('exam-permits.generate');
});
Route::group(['middleware' => ['permission:download-exam-permits']], function () {
    Route::get('/exam-permits/download/{student}', 'ExamPermitsController@download')->name('exam-permits.download');
});
Route::group(['middleware' => ['permission:print-exam-permits']], function () {
    Route::get('/exam-permits/print/{student}', 'ExamPermitsController@print')->name('exam-permits.print');
});

// Academic Record Routes
Route::group(['middleware' => ['permission:view-academic-records']], function () {
    Route::get('/academic-records', 'AcademicRecordController@index')->name('academic-records.index');
    Route::post('/academic-records/filter', 'AcademicRecordController@filter')->name('academic-records.filter');
});

Route::group(['middleware' => ['permission:generate-academic-records']], function () {
    Route::get('/academic-records/generate/{student}', 'AcademicRecordController@generate')->name('academic-records.generate');
});

Route::group(['middleware' => ['permission:download-academic-records']], function () {
    Route::get('/academic-records/download/{student}', 'AcademicRecordController@download')->name('academic-records.download');
});

Route::group(['middleware' => ['permission:print-academic-records']], function () {
    Route::get('/academic-records/print/{student}', 'AcademicRecordController@print')->name('academic-records.print');
});

// Proof of Registration Routes
Route::group(['middleware' => ['permission:view-proof-of-registration']], function () {
    Route::get('/proof-of-registration', 'ProofOfRegistrationController@index')->name('proof-of-registration.index');
    Route::post('/proof-of-registration/filter', 'ProofOfRegistrationController@filter')->name('proof-of-registration.filter');
});

Route::group(['middleware' => ['permission:generate-proof-of-registration']], function () {
    Route::get('/proof-of-registration/generate/{student}', 'ProofOfRegistrationController@generate')->name('proof-of-registration.generate');
});

Route::group(['middleware' => ['permission:download-proof-of-registration']], function () {
    Route::get('/proof-of-registration/download/{student}', 'ProofOfRegistrationController@download')->name('proof-of-registration.download');
});

Route::group(['middleware' => ['permission:print-proof-of-registration']], function () {
    Route::get('/proof-of-registration/print/{student}', 'ProofOfRegistrationController@print')->name('proof-of-registration.print');
});

// Student Letters Routes
Route::get('/student-letters', 'StudentLetterController@index')->name('student-letters.index')->middleware('permission:view-student-letters');
Route::post('/student-letters/filter', 'StudentLetterController@filter')->name('student-letters.filter')->middleware('permission:view-student-letters');
Route::get('/student-letters/{student}/generate', 'StudentLetterController@generate')->name('student-letters.generate')->middleware('permission:generate-student-letters');
Route::post('/student-letters/{student}/preview', 'StudentLetterController@preview')->name('student-letters.preview')->middleware('permission:view-student-letters');
Route::post('/student-letters/{student}/download', 'StudentLetterController@download')->name('student-letters.download')->middleware('permission:download-student-letters');

// Notice Board Routes
Route::get('/notice-board', 'NoticeBoardController@index')->name('notice-board.index')->middleware('permission:view-notice-board');
Route::get('/notice-board/create', 'NoticeBoardController@create')->name('notice-board.create')->middleware('permission:create-notice');
Route::post('/notice-board', 'NoticeBoardController@store')->name('notice-board.store')->middleware('permission:create-notice');
Route::get('/notice-board/{id}', 'NoticeBoardController@show')->name('notice-board.show')->middleware('permission:view-notice-board');
Route::get('/notice-board/{id}/edit', 'NoticeBoardController@edit')->name('notice-board.edit')->middleware('permission:edit-notice');
Route::put('/notice-board/{id}', 'NoticeBoardController@update')->name('notice-board.update')->middleware('permission:edit-notice');
Route::delete('/notice-board/{id}', 'NoticeBoardController@destroy')->name('notice-board.destroy')->middleware('permission:delete-notice');
Route::get('/notice-board/{id}/toggle-publish', 'NoticeBoardController@togglePublish')->name('notice-board.toggle-publish')->middleware('permission:publish-notice');
Route::post('/notice-board/{id}/remove-attachment', 'NoticeBoardController@removeAttachment')->name('notice-board.remove-attachment')->middleware('permission:manage-notice-attachments');

// Marks Suppression Routes
Route::get('/marks-suppression', 'MarksSuppressionController@index')->name('marks-suppression.index')->middleware('permission:view-marks-suppression');
Route::get('/marks-suppression/create', 'MarksSuppressionController@create')->name('marks-suppression.create')->middleware('permission:create-marks-suppression');
Route::post('/marks-suppression', 'MarksSuppressionController@store')->name('marks-suppression.store')->middleware('permission:create-marks-suppression');
Route::get('/marks-suppression/{marksSuppression}', 'MarksSuppressionController@show')->name('marks-suppression.show')->middleware('permission:view-marks-suppression');
Route::get('/marks-suppression/{marksSuppression}/edit', 'MarksSuppressionController@edit')->name('marks-suppression.edit')->middleware('permission:edit-marks-suppression');
Route::put('/marks-suppression/{marksSuppression}', 'MarksSuppressionController@update')->name('marks-suppression.update')->middleware('permission:edit-marks-suppression');
Route::delete('/marks-suppression/{marksSuppression}', 'MarksSuppressionController@destroy')->name('marks-suppression.destroy')->middleware('permission:delete-marks-suppression');
Route::patch('/marks-suppression/{marksSuppression}/toggle', 'MarksSuppressionController@toggleSuppression')->name('marks-suppression.toggle')->middleware('permission:edit-marks-suppression');

// Department Management Routes
Route::group(['prefix' => 'departments', 'middleware' => ['auth', 'permission:view-departments']], function () {
    Route::get('/', 'DepartmentController@index')->name('departments.index');
    Route::get('/create', 'DepartmentController@create')->name('departments.create')->middleware('permission:create-departments');
    Route::post('/', 'DepartmentController@store')->name('departments.store')->middleware('permission:create-departments');
    Route::get('/{department}', 'DepartmentController@show')->name('departments.show');
    Route::get('/{department}/edit', 'DepartmentController@edit')->name('departments.edit')->middleware('permission:edit-departments');
    Route::put('/{department}', 'DepartmentController@update')->name('departments.update')->middleware('permission:edit-departments');
    Route::delete('/{department}', 'DepartmentController@destroy')->name('departments.destroy')->middleware('permission:delete-departments');
    Route::patch('/{department}/toggle-status', 'DepartmentController@toggleStatus')->name('departments.toggle-status')->middleware('permission:toggle-department-status');
});

// Designation Management Routes
Route::group(['prefix' => 'designations', 'middleware' => ['auth', 'permission:view-designations']], function () {
    Route::get('/', 'DesignationController@index')->name('designations.index');
    Route::get('/create', 'DesignationController@create')->name('designations.create')->middleware('permission:create-designations');
    Route::post('/', 'DesignationController@store')->name('designations.store')->middleware('permission:create-designations');
    Route::get('/{designation}', 'DesignationController@show')->name('designations.show');
    Route::get('/{designation}/edit', 'DesignationController@edit')->name('designations.edit')->middleware('permission:edit-designations');
    Route::put('/{designation}', 'DesignationController@update')->name('designations.update')->middleware('permission:edit-designations');
    Route::delete('/{designation}', 'DesignationController@destroy')->name('designations.destroy')->middleware('permission:delete-designations');
    Route::patch('/{designation}/toggle-status', 'DesignationController@toggleStatus')->name('designations.toggle-status')->middleware('permission:toggle-designation-status');
});

// Asset Category Management Routes
Route::group(['prefix' => 'asset-categories', 'middleware' => ['auth', 'permission:view-asset-categories']], function () {
    Route::get('/', 'AssetCategoryController@index')->name('asset-categories.index');
    Route::get('/create', 'AssetCategoryController@create')->name('asset-categories.create')->middleware('permission:create-asset-categories');
    Route::post('/', 'AssetCategoryController@store')->name('asset-categories.store')->middleware('permission:create-asset-categories');
    Route::get('/{assetCategory}', 'AssetCategoryController@show')->name('asset-categories.show');
    Route::get('/{assetCategory}/edit', 'AssetCategoryController@edit')->name('asset-categories.edit')->middleware('permission:edit-asset-categories');
    Route::put('/{assetCategory}', 'AssetCategoryController@update')->name('asset-categories.update')->middleware('permission:edit-asset-categories');
    Route::delete('/{assetCategory}', 'AssetCategoryController@destroy')->name('asset-categories.destroy')->middleware('permission:delete-asset-categories');
    Route::patch('/{assetCategory}/toggle-status', 'AssetCategoryController@toggleStatus')->name('asset-categories.toggle-status')->middleware('permission:toggle-asset-category-status');
});

// Leave Type Management Routes
Route::group(['prefix' => 'leave-types', 'middleware' => ['auth', 'permission:view-leave-types']], function () {
    Route::get('/', 'LeaveTypeController@index')->name('leave-types.index');
    Route::get('/create', 'LeaveTypeController@create')->name('leave-types.create')->middleware('permission:create-leave-types');
    Route::post('/', 'LeaveTypeController@store')->name('leave-types.store')->middleware('permission:create-leave-types');
    Route::get('/{leaveType}', 'LeaveTypeController@show')->name('leave-types.show');
    Route::get('/{leaveType}/edit', 'LeaveTypeController@edit')->name('leave-types.edit')->middleware('permission:edit-leave-types');
    Route::put('/{leaveType}', 'LeaveTypeController@update')->name('leave-types.update')->middleware('permission:edit-leave-types');
    Route::delete('/{leaveType}', 'LeaveTypeController@destroy')->name('leave-types.destroy')->middleware('permission:delete-leave-types');
    Route::patch('/{leaveType}/toggle-status', 'LeaveTypeController@toggleStatus')->name('leave-types.toggle-status')->middleware('permission:toggle-leave-type-status');
});

// Statement of Results - Under Development
Route::get('/statement-of-results', function () {
    return view('statement-of-results.coming-soon');
})->name('statement-of-results.index');

// Route::get('richard', function(){
//     return phpinfo();
// });
