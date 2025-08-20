<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Permission;

class CreateAdditionalReportPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    {
    {
    {
        $permissions = [
            // Assessment Reports
            'assessment-report' => 'Can view and generate assessment report',
            
            // Attendance Reports
            'attendance-report' => 'Can view and generate attendance report',
            
            // Employee Reports
            'employee-report' => 'Can view and generate employee report',
            
            // Hostel Reports
            'hostel-reports' => 'Can view and generate hostel report',
            
            // Inventory Reports
            'inventory-reports' => 'Can view and generate inventory report',
            
            // Leave Reports
            'leave-reports' => 'Can view and generate leave report',
            
            // Maintenance Reports
            'maintenance-reports' => 'Can view and generate maintenance report',
            
            // Payroll Reports
            'payroll-reports' => 'Can view and generate payroll report',
            
            // Timetable Reports
            'timetable-reports' => 'Can view and generate timetable report',
        ];

        foreach ($permissions as $name => $description) {
            if (!Permission::where('name', $name)->exists()) {
                Permission::create([
                    'name' => $name,
                    'display_name' => ucwords(str_replace('-', ' ', $name)),
                    'description' => $description
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $permissions = [
            'assessment-report',
            'attendance-report',
            'employee-report',
            'hostel-reports',
            'inventory-reports',
            'leave-reports',
            'maintenance-reports',
            'payroll-reports',
            'timetable-reports',
        ];

        foreach ($permissions as $permission) {
            Permission::where('name', $permission)->delete();
        }
    }
}
