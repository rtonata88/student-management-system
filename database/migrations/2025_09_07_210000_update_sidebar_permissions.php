<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\File;

class UpdateSidebarPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Path to the app.blade.php file
        $appBladeFile = resource_path('views/layouts/app.blade.php');
        
        if (File::exists($appBladeFile)) {
            $content = File::get($appBladeFile);
            
            // Fix: Add missing permission wrapper for Payroll Management
            $oldPayrollPattern = '/(\s+)(<li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="\/payroll-management"><span class="c-sidebar-nav-icon"><\/span> Payroll Management<\/a><\/li>)/';
            $newPayrollReplacement = '$1@permission(\'access-payroll-system\')' . "\n" . '$1$2' . "\n" . '$1@endpermission';
            
            // Only apply the fix if the permission wrapper doesn't already exist
            if (strpos($content, '@permission(\'access-payroll-system\')') === false) {
                $content = preg_replace($oldPayrollPattern, $newPayrollReplacement, $content);
                
                // Write the updated content back to the file
                File::put($appBladeFile, $content);
                
                echo "✅ Updated sidebar permissions in app.blade.php - Added permission check for Payroll Management\n";
            } else {
                echo "ℹ️ Sidebar permissions already updated in app.blade.php\n";
            }
        } else {
            echo "⚠️ Warning: app.blade.php file not found at: $appBladeFile\n";
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Path to the app.blade.php file
        $appBladeFile = resource_path('views/layouts/app.blade.php');
        
        if (File::exists($appBladeFile)) {
            $content = File::get($appBladeFile);
            
            // Reverse: Remove permission wrapper from Payroll Management
            $payrollWithPermission = '/(\s+)@permission\(\'access-payroll-system\'\)\s*\n(\s+)(<li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="\/payroll-management"><span class="c-sidebar-nav-icon"><\/span> Payroll Management<\/a><\/li>)\s*\n(\s+)@endpermission/';
            $payrollWithoutPermission = '$1$3';
            
            $content = preg_replace($payrollWithPermission, $payrollWithoutPermission, $content);
            
            // Write the updated content back to the file
            File::put($appBladeFile, $content);
            
            echo "✅ Reverted sidebar permissions in app.blade.php - Removed permission check for Payroll Management\n";
        } else {
            echo "⚠️ Warning: app.blade.php file not found at: $appBladeFile\n";
        }
    }
}
