<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Permission;

class CreatePayrollPermissions extends Migration
{
    public function up()
    {
        $permissions = [
            // Payroll Dashboard
            [
                'name' => 'view-payroll-dashboard',
                'display_name' => 'View Payroll Dashboard',
                'description' => 'Allow user to view payroll dashboard and overview'
            ],
            
            // Payroll Periods Management
            [
                'name' => 'view-payroll-periods',
                'display_name' => 'View Payroll Periods',
                'description' => 'Allow user to view payroll periods'
            ],
            [
                'name' => 'create-payroll-periods',
                'display_name' => 'Create Payroll Periods',
                'description' => 'Allow user to create new payroll periods'
            ],
            [
                'name' => 'edit-payroll-periods',
                'display_name' => 'Edit Payroll Periods',
                'description' => 'Allow user to edit payroll periods'
            ],
            [
                'name' => 'delete-payroll-periods',
                'display_name' => 'Delete Payroll Periods',
                'description' => 'Allow user to delete payroll periods'
            ],
            [
                'name' => 'process-payroll',
                'display_name' => 'Process Payroll',
                'description' => 'Allow user to process payroll for periods'
            ],
            
            // Employee Payroll Settings
            [
                'name' => 'view-employee-payroll',
                'display_name' => 'View Employee Payroll',
                'description' => 'Allow user to view employee payroll settings'
            ],
            [
                'name' => 'edit-employee-payroll',
                'display_name' => 'Edit Employee Payroll',
                'description' => 'Allow user to edit employee payroll settings'
            ],
            [
                'name' => 'manage-employee-salaries',
                'display_name' => 'Manage Employee Salaries',
                'description' => 'Allow user to manage employee salary information'
            ],
            
            // Payroll Items Management
            [
                'name' => 'view-payroll-items',
                'display_name' => 'View Payroll Items',
                'description' => 'Allow user to view payroll items (earnings, deductions)'
            ],
            [
                'name' => 'create-payroll-items',
                'display_name' => 'Create Payroll Items',
                'description' => 'Allow user to create new payroll items'
            ],
            [
                'name' => 'edit-payroll-items',
                'display_name' => 'Edit Payroll Items',
                'description' => 'Allow user to edit payroll items'
            ],
            [
                'name' => 'delete-payroll-items',
                'display_name' => 'Delete Payroll Items',
                'description' => 'Allow user to delete payroll items'
            ],
            
            // Pay Slips Management
            [
                'name' => 'view-pay-slips',
                'display_name' => 'View Pay Slips',
                'description' => 'Allow user to view pay slips'
            ],
            [
                'name' => 'generate-pay-slips',
                'display_name' => 'Generate Pay Slips',
                'description' => 'Allow user to generate pay slips'
            ],
            [
                'name' => 'approve-pay-slips',
                'display_name' => 'Approve Pay Slips',
                'description' => 'Allow user to approve pay slips'
            ],
            [
                'name' => 'print-pay-slips',
                'display_name' => 'Print Pay Slips',
                'description' => 'Allow user to print pay slips'
            ],
            [
                'name' => 'download-pay-slips',
                'display_name' => 'Download Pay Slips',
                'description' => 'Allow user to download pay slips as PDF'
            ],
            [
                'name' => 'email-pay-slips',
                'display_name' => 'Email Pay Slips',
                'description' => 'Allow user to email pay slips to employees'
            ],
            
            // Payroll Reports
            [
                'name' => 'view-payroll-reports',
                'display_name' => 'View Payroll Reports',
                'description' => 'Allow user to view payroll reports'
            ],
            [
                'name' => 'generate-payroll-reports',
                'display_name' => 'Generate Payroll Reports',
                'description' => 'Allow user to generate payroll reports'
            ],
            [
                'name' => 'export-payroll-reports',
                'display_name' => 'Export Payroll Reports',
                'description' => 'Allow user to export payroll reports'
            ],
            
            // Tax Management
            [
                'name' => 'manage-tax-settings',
                'display_name' => 'Manage Tax Settings',
                'description' => 'Allow user to manage tax settings and calculations'
            ],
            [
                'name' => 'generate-tax-reports',
                'display_name' => 'Generate Tax Reports',
                'description' => 'Allow user to generate tax reports'
            ],
            
            // Bank Transfer Management
            [
                'name' => 'generate-bank-transfers',
                'display_name' => 'Generate Bank Transfers',
                'description' => 'Allow user to generate bank transfer files'
            ],
            [
                'name' => 'view-bank-transfers',
                'display_name' => 'View Bank Transfers',
                'description' => 'Allow user to view bank transfer records'
            ],
            
            // General Payroll Management
            [
                'name' => 'manage-payroll',
                'display_name' => 'Manage Payroll',
                'description' => 'Allow user full payroll management access'
            ],
            [
                'name' => 'access-payroll-system',
                'display_name' => 'Access Payroll System',
                'description' => 'Allow user to access the payroll management system'
            ]
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(
                ['name' => $permission['name']],
                [
                    'display_name' => $permission['display_name'],
                    'description' => $permission['description']
                ]
            );
        }
    }

    public function down()
    {
        $permissions = [
            'view-payroll-dashboard', 'view-payroll-periods', 'create-payroll-periods',
            'edit-payroll-periods', 'delete-payroll-periods', 'process-payroll',
            'view-employee-payroll', 'edit-employee-payroll', 'manage-employee-salaries',
            'view-payroll-items', 'create-payroll-items', 'edit-payroll-items', 'delete-payroll-items',
            'view-pay-slips', 'generate-pay-slips', 'approve-pay-slips', 'print-pay-slips',
            'download-pay-slips', 'email-pay-slips', 'view-payroll-reports', 'generate-payroll-reports',
            'export-payroll-reports', 'manage-tax-settings', 'generate-tax-reports',
            'generate-bank-transfers', 'view-bank-transfers', 'manage-payroll', 'access-payroll-system'
        ];

        Permission::whereIn('name', $permissions)->delete();
    }
}
