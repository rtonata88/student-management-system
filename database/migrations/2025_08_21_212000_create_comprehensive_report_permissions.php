<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Permission;

class CreateComprehensiveReportPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create comprehensive report permissions in alphabetical order
        $reportPermissions = [
            // Academic Reports
            'academic-performance-report' => 'Academic Performance Report',
            'academic-year-summary-report' => 'Academic Year Summary Report',
            'assessment-analysis-report' => 'Assessment Analysis Report',
            'assessment-marks-report' => 'Assessment Marks Report',
            'assessment-statistics-report' => 'Assessment Statistics Report',
            'attendance-summary-report' => 'Attendance Summary Report',
            'class-performance-report' => 'Class Performance Report',
            'class-routine-report' => 'Class Routine Report',
            'curriculum-coverage-report' => 'Curriculum Coverage Report',
            
            // Examination Reports
            'exam-marks-report' => 'Exam Marks Report',
            'exam-results-report' => 'Exam Results Report',
            'exam-schedule-report' => 'Exam Schedule Report',
            'exam-statistics-report' => 'Exam Statistics Report',
            'examination-analysis-report' => 'Examination Analysis Report',
            
            // Finance Reports
            'fee-collection-report' => 'Fee Collection Report',
            'fee-defaulters-report' => 'Fee Defaulters Report',
            'fee-structure-report' => 'Fee Structure Report',
            'financial-summary-report' => 'Financial Summary Report',
            'outstanding-balances-report' => 'Outstanding Balances Report',
            'payment-history-report' => 'Payment History Report',
            'revenue-analysis-report' => 'Revenue Analysis Report',
            
            // Fleet Management Reports
            'fleet-cost-analysis-report' => 'Fleet Cost Analysis Report',
            'fleet-driver-performance-report' => 'Fleet Driver Performance Report',
            'fleet-fuel-consumption-report' => 'Fleet Fuel Consumption Report',
            'fleet-maintenance-report' => 'Fleet Maintenance Report',
            'fleet-trip-summary-report' => 'Fleet Trip Summary Report',
            'fleet-utilization-report' => 'Fleet Utilization Report',
            'vehicle-inspection-report' => 'Vehicle Inspection Report',
            'vehicle-service-history-report' => 'Vehicle Service History Report',
            
            // HR Reports
            'employee-attendance-report' => 'Employee Attendance Report',
            'employee-benefits-report' => 'Employee Benefits Report',
            'employee-directory-report' => 'Employee Directory Report',
            'employee-performance-report' => 'Employee Performance Report',
            'employee-profile-report' => 'Employee Profile Report',
            'leave-balance-report' => 'Leave Balance Report',
            'leave-history-report' => 'Leave History Report',
            'leave-summary-report' => 'Leave Summary Report',
            'payroll-summary-report' => 'Payroll Summary Report',
            'staff-allocation-report' => 'Staff Allocation Report',
            
            // Hostel Reports
            'hostel-allocation-report' => 'Hostel Allocation Report',
            'hostel-fee-collection-report' => 'Hostel Fee Collection Report',
            'hostel-maintenance-report' => 'Hostel Maintenance Report',
            'hostel-occupancy-report' => 'Hostel Occupancy Report',
            'hostel-payment-report' => 'Hostel Payment Report',
            'hostel-visitor-report' => 'Hostel Visitor Report',
            
            // Inventory Reports
            'inventory-movement-report' => 'Inventory Movement Report',
            'inventory-stock-report' => 'Inventory Stock Report',
            'inventory-valuation-report' => 'Inventory Valuation Report',
            'low-stock-report' => 'Low Stock Report',
            'stock-adjustment-report' => 'Stock Adjustment Report',
            'supplier-performance-report' => 'Supplier Performance Report',
            
            // Maintenance Reports
            'asset-maintenance-report' => 'Asset Maintenance Report',
            'maintenance-cost-report' => 'Maintenance Cost Report',
            'maintenance-history-report' => 'Maintenance History Report',
            'maintenance-schedule-report' => 'Maintenance Schedule Report',
            'overdue-maintenance-report' => 'Overdue Maintenance Report',
            'preventive-maintenance-report' => 'Preventive Maintenance Report',
            
            // Registration Reports
            'enrollment-analysis-report' => 'Enrollment Analysis Report',
            'enrollment-statistics-report' => 'Enrollment Statistics Report',
            'enrollment-trends-report' => 'Enrollment Trends Report',
            'registration-summary-report' => 'Registration Summary Report',
            'student-demographics-report' => 'Student Demographics Report',
            'subject-enrollment-report' => 'Subject Enrollment Report',
            
            // Student Reports
            'student-academic-transcript' => 'Student Academic Transcript',
            'student-attendance-report' => 'Student Attendance Report',
            'student-fee-statement' => 'Student Fee Statement',
            'student-progress-report' => 'Student Progress Report',
            'student-registration-report' => 'Student Registration Report',
            'student-summary-report' => 'Student Summary Report',
            
            // System Reports
            'audit-trail-report' => 'Audit Trail Report',
            'data-backup-report' => 'Data Backup Report',
            'system-activity-report' => 'System Activity Report',
            'system-performance-report' => 'System Performance Report',
            'user-activity-report' => 'User Activity Report',
            'user-permissions-report' => 'User Permissions Report',
            
            // Timetable Reports
            'class-schedule-report' => 'Class Schedule Report',
            'faculty-timetable-report' => 'Faculty Timetable Report',
            'room-utilization-report' => 'Room Utilization Report',
            'timetable-conflicts-report' => 'Timetable Conflicts Report',
            'venue-allocation-report' => 'Venue Allocation Report',
        ];

        foreach ($reportPermissions as $name => $displayName) {
            if (!Permission::where('name', $name)->exists()) {
                Permission::create([
                    'name' => $name,
                    'display_name' => $displayName,
                    'description' => 'Can view and generate ' . strtolower($displayName)
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $reportPermissions = [
            'academic-performance-report', 'academic-year-summary-report', 'assessment-analysis-report',
            'assessment-marks-report', 'assessment-statistics-report', 'attendance-summary-report',
            'class-performance-report', 'class-routine-report', 'curriculum-coverage-report',
            'exam-marks-report', 'exam-results-report', 'exam-schedule-report', 'exam-statistics-report',
            'examination-analysis-report', 'fee-collection-report', 'fee-defaulters-report',
            'fee-structure-report', 'financial-summary-report', 'outstanding-balances-report',
            'payment-history-report', 'revenue-analysis-report', 'fleet-cost-analysis-report',
            'fleet-driver-performance-report', 'fleet-fuel-consumption-report', 'fleet-maintenance-report',
            'fleet-trip-summary-report', 'fleet-utilization-report', 'vehicle-inspection-report',
            'vehicle-service-history-report', 'employee-attendance-report', 'employee-benefits-report',
            'employee-directory-report', 'employee-performance-report', 'employee-profile-report',
            'leave-balance-report', 'leave-history-report', 'leave-summary-report',
            'payroll-summary-report', 'staff-allocation-report', 'hostel-allocation-report',
            'hostel-fee-collection-report', 'hostel-maintenance-report', 'hostel-occupancy-report',
            'hostel-payment-report', 'hostel-visitor-report', 'inventory-movement-report',
            'inventory-stock-report', 'inventory-valuation-report', 'low-stock-report',
            'stock-adjustment-report', 'supplier-performance-report', 'asset-maintenance-report',
            'maintenance-cost-report', 'maintenance-history-report', 'maintenance-schedule-report',
            'overdue-maintenance-report', 'preventive-maintenance-report', 'enrollment-analysis-report',
            'enrollment-statistics-report', 'enrollment-trends-report', 'registration-summary-report',
            'student-demographics-report', 'subject-enrollment-report', 'student-academic-transcript',
            'student-attendance-report', 'student-fee-statement', 'student-progress-report',
            'student-registration-report', 'student-summary-report', 'audit-trail-report',
            'data-backup-report', 'system-activity-report', 'system-performance-report',
            'user-activity-report', 'user-permissions-report', 'class-schedule-report',
            'faculty-timetable-report', 'room-utilization-report', 'timetable-conflicts-report',
            'venue-allocation-report'
        ];

        foreach ($reportPermissions as $permission) {
            Permission::where('name', $permission)->delete();
        }
    }
}
