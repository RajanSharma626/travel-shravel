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
        Schema::table('employees', function (Blueprint $table) {
            // Add password column if it doesn't exist
            if (!Schema::hasColumn('employees', 'password')) {
                // Try to add after login_work_email, if that fails, add at the end
                try {
                    $table->string('password')->nullable()->after('login_work_email');
                } catch (\Exception $e) {
                    // If after() fails, just add the column
                    $table->string('password')->nullable();
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            if (Schema::hasColumn('employees', 'password')) {
                $table->dropColumn('password');
            }
        });
    }
};
