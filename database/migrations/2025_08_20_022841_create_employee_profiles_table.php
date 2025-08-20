<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('employee_profiles')) {
            Schema::create('employee_profiles', function (Blueprint $table) {
                $table->id();
                $table->unsignedInteger('user_id');
                $table->string('employee_number')->unique()->nullable();
                $table->string('department')->nullable();
                $table->string('position')->nullable();
                $table->string('employment_type')->nullable(); // Full-time, Part-time, Contract
                $table->date('hire_date')->nullable();
                $table->decimal('salary', 10, 2)->nullable();
                
                // Personal Information
                $table->string('id_number')->nullable();
                $table->string('passport_number')->nullable();
                $table->date('date_of_birth')->nullable();
                $table->string('gender')->nullable();
                $table->string('marital_status')->nullable();
                $table->string('nationality')->nullable();
                $table->string('home_language')->nullable();
                
                // Contact Information
                $table->string('personal_email')->nullable();
                $table->string('work_phone')->nullable();
                $table->string('personal_phone')->nullable();
                $table->string('emergency_contact_name')->nullable();
                $table->string('emergency_contact_phone')->nullable();
                $table->string('emergency_contact_relationship')->nullable();
                
                // Address Information
                $table->text('residential_address')->nullable();
                $table->string('residential_city')->nullable();
                $table->string('residential_province')->nullable();
                $table->string('residential_postal_code')->nullable();
                $table->text('postal_address')->nullable();
                $table->string('postal_city')->nullable();
                $table->string('postal_province')->nullable();
                $table->string('postal_code')->nullable();
                
                // Banking Information
                $table->string('bank_name')->nullable();
                $table->string('bank_branch')->nullable();
                $table->string('account_number')->nullable();
                $table->string('account_type')->nullable();
                
                // Tax Information
                $table->string('tax_number')->nullable();
                $table->string('uif_number')->nullable();
                $table->string('medical_aid_name')->nullable();
                $table->string('medical_aid_number')->nullable();
                
                // Qualifications
                $table->json('qualifications')->nullable(); // Store as JSON array
                $table->json('certifications')->nullable(); // Store as JSON array
                $table->json('skills')->nullable(); // Store as JSON array
                
                // Employment History
                $table->json('employment_history')->nullable(); // Store as JSON array
                
                // Additional Information
                $table->text('notes')->nullable();
                $table->boolean('is_active')->default(true);
                $table->string('profile_photo')->nullable();
                
                $table->timestamps();
                
                // Foreign key constraint
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                
                // Indexes
                $table->index('user_id');
                $table->index('employee_number');
                $table->index('department');
                $table->index('is_active');
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
        Schema::dropIfExists('employee_profiles');
    }
}
