<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFixedAssetCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('fixed_asset_categories')) {
            Schema::create('fixed_asset_categories', function (Blueprint $table) {
                $table->id();
                $table->string('name')->unique();
                $table->text('description')->nullable();
                $table->string('color', 7)->default('#007bff');
                $table->decimal('depreciation_rate', 5, 2)->default(0.00); // Annual depreciation percentage
                $table->integer('useful_life_years')->default(5); // Expected useful life in years
                $table->boolean('active')->default(true);
                $table->timestamps();
                
                $table->index(['active', 'name']);
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
        Schema::dropIfExists('fixed_asset_categories');
    }
}
