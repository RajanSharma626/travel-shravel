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
        Schema::table('lead_remarks', function (Blueprint $table) {
            // Add follow_up_time column to store a specific time (nullable)
            if (!Schema::hasColumn('lead_remarks', 'follow_up_time')) {
                $table->time('follow_up_time')->nullable()->after('follow_up_date');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lead_remarks', function (Blueprint $table) {
            if (Schema::hasColumn('lead_remarks', 'follow_up_time')) {
                $table->dropColumn('follow_up_time');
            }
        });
    }
};
