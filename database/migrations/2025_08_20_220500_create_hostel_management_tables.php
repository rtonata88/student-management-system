<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHostelManagementTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create hostels table
        if (!Schema::hasTable('hostels')) {
            Schema::create('hostels', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('code')->unique();
                $table->text('description')->nullable();
                $table->text('address');
                $table->string('phone')->nullable();
                $table->string('email')->nullable();
                $table->string('warden_name')->nullable();
                $table->string('warden_phone')->nullable();
                $table->integer('total_capacity')->default(0);
                $table->enum('gender', ['male', 'female', 'mixed'])->default('mixed');
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }

        // Create hostel_blocks table
        if (!Schema::hasTable('hostel_blocks')) {
            Schema::create('hostel_blocks', function (Blueprint $table) {
                $table->id();
                $table->foreignId('hostel_id')->constrained('hostels')->onDelete('cascade');
                $table->string('name');
                $table->string('code');
                $table->text('description')->nullable();
                $table->integer('floor_count')->default(1);
                $table->integer('total_rooms')->default(0);
                $table->enum('gender', ['male', 'female', 'mixed'])->default('mixed');
                $table->boolean('is_active')->default(true);
                $table->timestamps();
                
                $table->unique(['hostel_id', 'code']);
            });
        }

        // Create hostel_rooms table
        if (!Schema::hasTable('hostel_rooms')) {
            Schema::create('hostel_rooms', function (Blueprint $table) {
                $table->id();
                $table->foreignId('hostel_id')->constrained('hostels')->onDelete('cascade');
                $table->foreignId('block_id')->constrained('hostel_blocks')->onDelete('cascade');
                $table->string('room_number');
                $table->string('room_type')->default('standard'); // standard, deluxe, suite
                $table->integer('floor_number')->default(1);
                $table->integer('bed_capacity')->default(2);
                $table->integer('occupied_beds')->default(0);
                $table->decimal('room_fee', 10, 2)->default(0);
                $table->boolean('has_bathroom')->default(true);
                $table->boolean('has_ac')->default(false);
                $table->boolean('has_wifi')->default(true);
                $table->text('amenities')->nullable(); // JSON field for additional amenities
                $table->enum('status', ['available', 'occupied', 'maintenance', 'reserved'])->default('available');
                $table->boolean('is_active')->default(true);
                $table->timestamps();
                
                $table->unique(['hostel_id', 'block_id', 'room_number']);
            });
        }

        // Create hostel_beds table
        if (!Schema::hasTable('hostel_beds')) {
            Schema::create('hostel_beds', function (Blueprint $table) {
                $table->id();
                $table->foreignId('hostel_id')->constrained('hostels')->onDelete('cascade');
                $table->foreignId('block_id')->constrained('hostel_blocks')->onDelete('cascade');
                $table->foreignId('room_id')->constrained('hostel_rooms')->onDelete('cascade');
                $table->string('bed_number');
                $table->enum('bed_type', ['single', 'bunk_top', 'bunk_bottom'])->default('single');
                $table->decimal('bed_fee', 10, 2)->default(0);
                $table->enum('status', ['available', 'occupied', 'maintenance', 'reserved'])->default('available');
                $table->boolean('is_active')->default(true);
                $table->timestamps();
                
                $table->unique(['room_id', 'bed_number']);
            });
        }

        // Create hostel_allocations table
        if (!Schema::hasTable('hostel_allocations')) {
            Schema::create('hostel_allocations', function (Blueprint $table) {
                $table->id();
                $table->unsignedInteger('student_id');
                $table->unsignedBigInteger('hostel_id');
                $table->unsignedBigInteger('block_id');
                $table->unsignedBigInteger('room_id');
                $table->unsignedBigInteger('bed_id');
                $table->date('allocation_date');
                $table->date('check_in_date')->nullable();
                $table->date('check_out_date')->nullable();
                $table->date('expected_checkout_date')->nullable();
                $table->decimal('monthly_fee', 10, 2)->default(0);
                $table->decimal('security_deposit', 10, 2)->default(0);
                $table->enum('status', ['active', 'checked_out', 'transferred', 'terminated'])->default('active');
                $table->text('remarks')->nullable();
                $table->unsignedInteger('allocated_by');
                $table->timestamps();
                
                $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
                $table->foreign('hostel_id')->references('id')->on('hostels')->onDelete('cascade');
                $table->foreign('block_id')->references('id')->on('hostel_blocks')->onDelete('cascade');
                $table->foreign('room_id')->references('id')->on('hostel_rooms')->onDelete('cascade');
                $table->foreign('bed_id')->references('id')->on('hostel_beds')->onDelete('cascade');
                $table->foreign('allocated_by')->references('id')->on('users');
            });
        }

        // Create hostel_fee_structures table
        if (!Schema::hasTable('hostel_fee_structures')) {
            Schema::create('hostel_fee_structures', function (Blueprint $table) {
                $table->id();
                $table->foreignId('hostel_id')->constrained('hostels')->onDelete('cascade');
                $table->string('fee_type'); // monthly, semester, annual
                $table->string('room_type')->default('standard');
                $table->decimal('amount', 10, 2);
                $table->decimal('security_deposit', 10, 2)->default(0);
                $table->text('description')->nullable();
                $table->date('effective_from');
                $table->date('effective_to')->nullable();
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }

        // Create hostel_payments table
        if (!Schema::hasTable('hostel_payments')) {
            Schema::create('hostel_payments', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('allocation_id');
                $table->unsignedInteger('student_id');
                $table->string('payment_type'); // monthly_fee, security_deposit, maintenance, fine
                $table->decimal('amount', 10, 2);
                $table->date('payment_date');
                $table->date('due_date')->nullable();
                $table->string('payment_method')->nullable(); // cash, bank_transfer, online, etc.
                $table->string('payment_reference')->nullable();
                $table->enum('status', ['pending', 'paid', 'overdue', 'cancelled'])->default('pending');
                $table->text('remarks')->nullable();
                $table->unsignedInteger('received_by')->nullable();
                $table->timestamps();
                
                $table->foreign('allocation_id')->references('id')->on('hostel_allocations')->onDelete('cascade');
                $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
                $table->foreign('received_by')->references('id')->on('users');
            });
        }

        // Create hostel_maintenance table
        if (!Schema::hasTable('hostel_maintenance')) {
            Schema::create('hostel_maintenance', function (Blueprint $table) {
                $table->id();
                $table->foreignId('hostel_id')->constrained('hostels')->onDelete('cascade');
                $table->foreignId('block_id')->nullable()->constrained('hostel_blocks')->onDelete('cascade');
                $table->foreignId('room_id')->nullable()->constrained('hostel_rooms')->onDelete('cascade');
                $table->string('maintenance_type'); // electrical, plumbing, cleaning, repair, etc.
                $table->text('description');
                $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');
                $table->date('reported_date');
                $table->date('scheduled_date')->nullable();
                $table->date('completed_date')->nullable();
                $table->decimal('estimated_cost', 10, 2)->nullable();
                $table->decimal('actual_cost', 10, 2)->nullable();
                $table->enum('status', ['reported', 'scheduled', 'in_progress', 'completed', 'cancelled'])->default('reported');
                $table->unsignedInteger('reported_by');
                $table->unsignedInteger('assigned_to')->nullable();
                $table->text('remarks')->nullable();
                $table->timestamps();
                
                $table->foreign('reported_by')->references('id')->on('users');
                $table->foreign('assigned_to')->references('id')->on('users');
            });
        }

        // Create hostel_visitors table
        if (!Schema::hasTable('hostel_visitors')) {
            Schema::create('hostel_visitors', function (Blueprint $table) {
                $table->id();
                $table->unsignedInteger('student_id');
                $table->unsignedBigInteger('hostel_id');
                $table->string('visitor_name');
                $table->string('visitor_phone')->nullable();
                $table->string('relationship'); // parent, sibling, friend, etc.
                $table->datetime('visit_date');
                $table->datetime('check_in_time')->nullable();
                $table->datetime('check_out_time')->nullable();
                $table->text('purpose')->nullable();
                $table->enum('status', ['scheduled', 'checked_in', 'checked_out', 'cancelled'])->default('scheduled');
                $table->unsignedInteger('approved_by')->nullable();
                $table->text('remarks')->nullable();
                $table->timestamps();
                
                $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
                $table->foreign('hostel_id')->references('id')->on('hostels')->onDelete('cascade');
                $table->foreign('approved_by')->references('id')->on('users');
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
        Schema::dropIfExists('hostel_visitors');
        Schema::dropIfExists('hostel_maintenance');
        Schema::dropIfExists('hostel_payments');
        Schema::dropIfExists('hostel_fee_structures');
        Schema::dropIfExists('hostel_allocations');
        Schema::dropIfExists('hostel_beds');
        Schema::dropIfExists('hostel_rooms');
        Schema::dropIfExists('hostel_blocks');
        Schema::dropIfExists('hostels');
    }
}
