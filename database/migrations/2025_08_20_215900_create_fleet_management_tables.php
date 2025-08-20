<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFleetManagementTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Vehicle Categories
        if (!Schema::hasTable('vehicle_categories')) {
            Schema::create('vehicle_categories', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->text('description')->nullable();
                $table->boolean('active')->default(true);
                $table->timestamps();
            });
        }

        // Vehicles
        if (!Schema::hasTable('vehicles')) {
            Schema::create('vehicles', function (Blueprint $table) {
                $table->id();
                $table->string('registration_number')->unique();
                $table->string('make');
                $table->string('model');
                $table->year('year');
                $table->string('color')->nullable();
                $table->string('engine_number')->nullable();
                $table->string('chassis_number')->nullable();
                $table->integer('seating_capacity');
                $table->decimal('fuel_capacity', 8, 2);
                $table->enum('fuel_type', ['petrol', 'diesel', 'electric', 'hybrid']);
                $table->enum('status', ['active', 'maintenance', 'retired', 'accident'])->default('active');
                $table->date('purchase_date')->nullable();
                $table->decimal('purchase_price', 12, 2)->nullable();
                $table->date('insurance_expiry')->nullable();
                $table->date('license_expiry')->nullable();
                $table->integer('current_odometer')->default(0);
                $table->foreignId('category_id')->constrained('vehicle_categories');
                $table->text('notes')->nullable();
                $table->timestamps();
            });
        }

        // Drivers
        if (!Schema::hasTable('drivers')) {
            Schema::create('drivers', function (Blueprint $table) {
                $table->id();
                $table->string('employee_number')->unique();
                $table->string('first_name');
                $table->string('last_name');
                $table->string('license_number')->unique();
                $table->string('license_class');
                $table->date('license_expiry');
                $table->string('phone')->nullable();
                $table->string('email')->nullable();
                $table->date('date_of_birth');
                $table->text('address')->nullable();
                $table->date('hire_date');
                $table->enum('status', ['active', 'inactive', 'suspended'])->default('active');
                $table->text('notes')->nullable();
                $table->timestamps();
            });
        }

        // Trip Logs
        if (!Schema::hasTable('trip_logs')) {
            Schema::create('trip_logs', function (Blueprint $table) {
                $table->id();
                $table->foreignId('vehicle_id')->constrained('vehicles');
                $table->foreignId('driver_id')->constrained('drivers');
                $table->string('trip_purpose');
                $table->string('destination');
                $table->datetime('departure_time');
                $table->datetime('arrival_time')->nullable();
                $table->integer('start_odometer');
                $table->integer('end_odometer')->nullable();
                $table->decimal('fuel_consumed', 8, 2)->nullable();
                $table->integer('passengers_count')->default(0);
                $table->text('notes')->nullable();
                $table->timestamps();
            });
        }

        // Fuel Records
        if (!Schema::hasTable('fuel_records')) {
            Schema::create('fuel_records', function (Blueprint $table) {
                $table->id();
                $table->foreignId('vehicle_id')->constrained('vehicles');
                $table->date('fuel_date');
                $table->decimal('liters', 8, 2);
                $table->decimal('cost_per_liter', 8, 2);
                $table->decimal('total_cost', 10, 2);
                $table->integer('odometer_reading');
                $table->string('fuel_station');
                $table->string('receipt_number')->nullable();
                $table->text('notes')->nullable();
                $table->timestamps();
            });
        }

        // Vehicle Services/Maintenance
        if (!Schema::hasTable('vehicle_services')) {
            Schema::create('vehicle_services', function (Blueprint $table) {
                $table->id();
                $table->foreignId('vehicle_id')->constrained('vehicles');
                $table->string('service_type');
                $table->date('service_date');
                $table->integer('odometer_reading');
                $table->decimal('cost', 10, 2);
                $table->string('service_provider');
                $table->text('description');
                $table->date('next_service_date')->nullable();
                $table->integer('next_service_odometer')->nullable();
                $table->text('parts_replaced')->nullable();
                $table->text('notes')->nullable();
                $table->enum('status', ['scheduled', 'in_progress', 'completed', 'cancelled'])->default('scheduled');
                $table->timestamps();
            });
        }

        // Vehicle Assignments (which driver is assigned to which vehicle)
        if (!Schema::hasTable('vehicle_assignments')) {
            Schema::create('vehicle_assignments', function (Blueprint $table) {
                $table->id();
                $table->foreignId('vehicle_id')->constrained('vehicles');
                $table->foreignId('driver_id')->constrained('drivers');
                $table->date('assigned_date');
                $table->date('unassigned_date')->nullable();
                $table->boolean('is_primary')->default(false);
                $table->text('notes')->nullable();
                $table->timestamps();
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
        Schema::dropIfExists('vehicle_assignments');
        Schema::dropIfExists('vehicle_services');
        Schema::dropIfExists('fuel_records');
        Schema::dropIfExists('trip_logs');
        Schema::dropIfExists('drivers');
        Schema::dropIfExists('vehicles');
        Schema::dropIfExists('vehicle_categories');
    }
}
