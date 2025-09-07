<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateFixedAssetsCategoryForeignKey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('fixed_assets') && !Schema::hasColumn('fixed_assets', 'category_id')) {
            Schema::table('fixed_assets', function (Blueprint $table) {
            // Drop the existing foreign key constraint
            $table->dropForeign(['category_id']);
            
            // Add new foreign key constraint to asset_categories table
            $table->foreign('category_id')->references('id')->on('asset_categories')->onDelete('restrict');
        });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fixed_assets', function (Blueprint $table) {
            // Drop the current foreign key constraint
            $table->dropForeign(['category_id']);
            
            // Restore the original foreign key constraint to fixed_asset_categories
            $table->foreign('category_id')->references('id')->on('fixed_asset_categories')->onDelete('restrict');
        });
    }
}
