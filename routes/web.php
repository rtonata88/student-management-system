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

Route::resource('/payments', 'PaymentController');
Route::post('/payments/filter', 'PaymentController@filter')->name('payments.filter');

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

Route::get('/audit/reports', 'AuditReportController@index')->name('reports.audit');
Route::get('/audit/show/{id}', 'AuditReportController@show')->name('reports.audit.show');
Route::post('/audit/reports/search', 'AuditReportController@search')->name('reports.audit.search');

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
Route::resource('/users','UsersController');
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
Route::get('/payroll-management', function () {
    return view('payroll.coming-soon');
})->name('payroll-management.index');

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
    Route::get('/class-routine', 'ClassRoutineController@index')->name('class-routine.index');
    Route::get('/class-routine/create', 'ClassRoutineController@create')->name('class-routine.create');
    Route::post('/class-routine', 'ClassRoutineController@store')->name('class-routine.store');
    Route::get('/class-routine/{id}/edit', 'ClassRoutineController@edit')->name('class-routine.edit');
    Route::put('/class-routine/{id}', 'ClassRoutineController@update')->name('class-routine.update');
    Route::delete('/class-routine/{id}', 'ClassRoutineController@destroy')->name('class-routine.destroy');
    Route::get('/class-routine/print', 'ClassRoutineController@print')->name('class-routine.print');
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
    Route::get('/drivers/{driver}/edit', 'FleetManagementController@editDriver')->name('drivers.edit');
    Route::put('/drivers/{driver}', 'FleetManagementController@updateDriver')->name('drivers.update');
    Route::delete('/drivers/{driver}', 'FleetManagementController@destroyDriver')->name('drivers.destroy');
    
    // Trip Management
    Route::get('/trips', 'FleetManagementController@trips')->name('trips');
    Route::get('/trips/create', 'FleetManagementController@createTrip')->name('trips.create');
    Route::post('/trips', 'FleetManagementController@storeTrip')->name('trips.store');
    
    // Fuel Management
    Route::get('/fuel', 'FleetManagementController@fuel')->name('fuel');
    Route::get('/fuel/create', 'FleetManagementController@createFuelRecord')->name('fuel.create');
    Route::post('/fuel', 'FleetManagementController@storeFuelRecord')->name('fuel.store');
    
    // Service Management
    Route::get('/services', 'FleetManagementController@services')->name('services');
    Route::get('/services/create', 'FleetManagementController@createService')->name('services.create');
    Route::post('/services', 'FleetManagementController@storeService')->name('services.store');
    
    // Vehicle Assignments
    Route::get('/assignments', 'FleetManagementController@assignments')->name('assignments');
    Route::get('/assignments/create', 'FleetManagementController@createAssignment')->name('assignments.create');
    Route::post('/assignments', 'FleetManagementController@storeAssignment')->name('assignments.store');
    
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

// Statement of Results - Under Development
Route::get('/statement-of-results', function () {
    return view('statement-of-results.coming-soon');
})->name('statement-of-results.index');

// Route::get('richard', function(){
//     return phpinfo();
// });
