<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('lead_remarks', function (Blueprint $table) {
            if (!Schema::hasColumn('lead_remarks', 'follow_up_at')) {
                $table->dateTime('follow_up_at')->nullable()->after('follow_up_time');
            }
        });

        // Backfill follow_up_at from existing date/time columns where present
        // Works on MySQL/Postgres - use CONCAT for MySQL, for Postgres use TO_TIMESTAMP
        // We'll use a DB-agnostic approach with PHP if needed
        $rows = DB::table('lead_remarks')->select('id', 'follow_up_date', 'follow_up_time')->get();
        foreach ($rows as $row) {
            if ($row->follow_up_date) {
                $time = $row->follow_up_time ? $row->follow_up_time : '00:00:00';
                // create datetime string
                $datetime = $row->follow_up_date . ' ' . $time;
                try {
                    DB::table('lead_remarks')->where('id', $row->id)->update(['follow_up_at' => $datetime]);
                } catch (\Exception $e) {
                    // ignore individual failures
                }
            }
        }

        // Optionally drop old columns
        Schema::table('lead_remarks', function (Blueprint $table) {
            if (Schema::hasColumn('lead_remarks', 'follow_up_time')) {
                $table->dropColumn('follow_up_time');
            }
            if (Schema::hasColumn('lead_remarks', 'follow_up_date')) {
                $table->dropColumn('follow_up_date');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lead_remarks', function (Blueprint $table) {
            if (!Schema::hasColumn('lead_remarks', 'follow_up_date')) {
                $table->date('follow_up_date')->nullable()->after('remark');
            }
            if (!Schema::hasColumn('lead_remarks', 'follow_up_time')) {
                $table->time('follow_up_time')->nullable()->after('follow_up_date');
            }
        });

        // Backfill follow_up_date and follow_up_time from follow_up_at
        $rows = DB::table('lead_remarks')->select('id', 'follow_up_at')->get();
        foreach ($rows as $row) {
            if ($row->follow_up_at) {
                try {
                    $mom = new \DateTime($row->follow_up_at);
                    DB::table('lead_remarks')->where('id', $row->id)->update([
                        'follow_up_date' => $mom->format('Y-m-d'),
                        'follow_up_time' => $mom->format('H:i:s'),
                    ]);
                } catch (\Exception $e) {
                    // ignore
                }
            }
        }

        Schema::table('lead_remarks', function (Blueprint $table) {
            if (Schema::hasColumn('lead_remarks', 'follow_up_at')) {
                $table->dropColumn('follow_up_at');
            }
        });
    }
};
