<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayrollTables extends Migration
{
    public function up()
    {
        // Create payroll_periods table
        if (!Schema::hasTable('payroll_periods')) {
            Schema::create('payroll_periods', function (Blueprint $table) {
                $table->id();
                $table->string('period_name');
                $table->date('start_date');
                $table->date('end_date');
                $table->date('pay_date');
                $table->enum('status', ['draft', 'processing', 'completed', 'cancelled'])->default('draft');
                $table->text('description')->nullable();
                $table->decimal('total_gross_pay', 15, 2)->default(0);
                $table->decimal('total_deductions', 15, 2)->default(0);
                $table->decimal('total_net_pay', 15, 2)->default(0);
                $table->unsignedInteger('created_by')->nullable();
                $table->unsignedInteger('updated_by')->nullable();
                $table->timestamps();
                
                $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
                $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
            });
        }

        // Create payroll_items table
        if (!Schema::hasTable('payroll_items')) {
            Schema::create('payroll_items', function (Blueprint $table) {
                $table->id();
                $table->string('item_name');
                $table->string('item_code')->unique();
                $table->enum('item_type', ['earning', 'deduction', 'allowance', 'tax']);
                $table->enum('calculation_method', ['fixed', 'percentage', 'hourly', 'formula']);
                $table->decimal('default_amount', 10, 2)->nullable();
                $table->decimal('percentage_rate', 5, 2)->nullable();
                $table->text('formula')->nullable();
                $table->boolean('is_taxable')->default(false);
                $table->boolean('is_active')->default(true);
                $table->text('description')->nullable();
                $table->unsignedInteger('created_by')->nullable();
                $table->unsignedInteger('updated_by')->nullable();
                $table->timestamps();
                
                $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
                $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
            });
        }

        // Create employee_payroll_settings table
        if (!Schema::hasTable('employee_payroll_settings')) {
            Schema::create('employee_payroll_settings', function (Blueprint $table) {
                $table->id();
                $table->unsignedInteger('user_id');
                $table->string('employee_number')->unique();
                $table->decimal('basic_salary', 10, 2);
                $table->enum('pay_frequency', ['monthly', 'bi-weekly', 'weekly']);
                $table->string('bank_name')->nullable();
                $table->string('account_number')->nullable();
                $table->string('account_type')->nullable();
                $table->string('tax_number')->nullable();
                $table->decimal('tax_rate', 5, 2)->default(0);
                $table->json('allowances')->nullable();
                $table->json('deductions')->nullable();
                $table->boolean('is_active')->default(true);
                $table->unsignedInteger('created_by')->nullable();
                $table->unsignedInteger('updated_by')->nullable();
                $table->timestamps();
                
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
                $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
            });
        }

        // Create pay_slips table
        if (!Schema::hasTable('pay_slips')) {
            Schema::create('pay_slips', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('payroll_period_id');
                $table->unsignedInteger('user_id');
                $table->string('slip_number')->unique();
                $table->decimal('basic_salary', 10, 2);
                $table->decimal('gross_pay', 10, 2);
                $table->decimal('total_allowances', 10, 2)->default(0);
                $table->decimal('total_deductions', 10, 2)->default(0);
                $table->decimal('tax_amount', 10, 2)->default(0);
                $table->decimal('net_pay', 10, 2);
                $table->json('earnings_breakdown');
                $table->json('deductions_breakdown');
                $table->text('notes')->nullable();
                $table->enum('status', ['draft', 'approved', 'paid'])->default('draft');
                $table->timestamp('approved_at')->nullable();
                $table->timestamp('paid_at')->nullable();
                $table->unsignedInteger('approved_by')->nullable();
                $table->unsignedInteger('created_by')->nullable();
                $table->timestamps();
                
                $table->foreign('payroll_period_id')->references('id')->on('payroll_periods')->onDelete('cascade');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->foreign('approved_by')->references('id')->on('users')->onDelete('set null');
                $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            });
        }

        // Create payroll_reports table
        if (!Schema::hasTable('payroll_reports')) {
            Schema::create('payroll_reports', function (Blueprint $table) {
                $table->id();
                $table->string('report_name');
                $table->enum('report_type', ['payroll_summary', 'tax_report', 'bank_transfer', 'employee_summary']);
                $table->unsignedBigInteger('payroll_period_id')->nullable();
                $table->date('report_date');
                $table->json('report_data');
                $table->string('file_path')->nullable();
                $table->unsignedInteger('generated_by');
                $table->timestamps();
                
                $table->foreign('payroll_period_id')->references('id')->on('payroll_periods')->onDelete('set null');
                $table->foreign('generated_by')->references('id')->on('users')->onDelete('cascade');
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('payroll_reports');
        Schema::dropIfExists('pay_slips');
        Schema::dropIfExists('employee_payroll_settings');
        Schema::dropIfExists('payroll_items');
        Schema::dropIfExists('payroll_periods');
    }
}
