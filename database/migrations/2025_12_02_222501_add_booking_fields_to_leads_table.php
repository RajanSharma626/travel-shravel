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
        Schema::table('leads', function (Blueprint $table) {
            if (!Schema::hasColumn('leads', 'created_by')) {
                $table->foreignId('created_by')->nullable()->after('assigned_user_id')->constrained('users')->onDelete('set null');
            }
            if (!Schema::hasColumn('leads', 'booked_by')) {
                $table->foreignId('booked_by')->nullable()->after('created_by')->constrained('users')->onDelete('set null');
            }
            if (!Schema::hasColumn('leads', 'booked_on')) {
                $table->timestamp('booked_on')->nullable()->after('booked_by');
            }
            if (!Schema::hasColumn('leads', 'reassigned_to')) {
                $table->foreignId('reassigned_to')->nullable()->after('booked_on')->constrained('users')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            if (Schema::hasColumn('leads', 'reassigned_to')) {
                $table->dropForeign(['reassigned_to']);
                $table->dropColumn('reassigned_to');
            }
            if (Schema::hasColumn('leads', 'booked_on')) {
                $table->dropColumn('booked_on');
            }
            if (Schema::hasColumn('leads', 'booked_by')) {
                $table->dropForeign(['booked_by']);
                $table->dropColumn('booked_by');
            }
            if (Schema::hasColumn('leads', 'created_by')) {
                $table->dropForeign(['created_by']);
                $table->dropColumn('created_by');
            }
        });
    }
};
