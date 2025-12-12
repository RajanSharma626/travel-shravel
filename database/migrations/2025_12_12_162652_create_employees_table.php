<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('employee_id')->unique()->nullable();
            $table->string('name');
            $table->date('dob')->nullable();
            $table->string('department')->nullable();
            $table->string('designation')->nullable();
            $table->string('reporting_manager')->nullable();
            $table->string('branch_location')->nullable();
            $table->date('doj')->nullable(); // Date of Joining
            $table->date('dol')->nullable(); // Date of Leaving
            $table->string('emergency_contact')->nullable();
            $table->string('work_email')->unique()->nullable();
            $table->string('crm_access_user_id')->nullable(); // sales1, ops1, ps1, etc.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
