<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Permission;

class CreateResultCodesPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create result codes permissions
        $permissions = [
            [
                'name' => 'result-codes',
                'display_name' => 'View Result Codes',
                'description' => 'View result codes list'
            ],
            [
                'name' => 'add-result-codes',
                'display_name' => 'Add Result Codes',
                'description' => 'Create new result codes'
            ],
            [
                'name' => 'edit-result-codes',
                'display_name' => 'Edit Result Codes',
                'description' => 'Edit existing result codes'
            ],
            [
                'name' => 'delete-result-codes',
                'display_name' => 'Delete Result Codes',
                'description' => 'Delete result codes'
            ]
        ];

        foreach ($permissions as $permission) {
            if (!Permission::where('name', $permission['name'])->exists()) {
                Permission::create($permission);
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
        $permissions = ['result-codes', 'add-result-codes', 'edit-result-codes', 'delete-result-codes'];
        
        foreach ($permissions as $permission) {
            Permission::where('name', $permission)->delete();
        }
    }
}
