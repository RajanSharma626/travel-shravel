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
            if (!Schema::hasColumn('leads', 'address_line')) {
                $table->string('address_line')->nullable()->after('address');
            }
            if (!Schema::hasColumn('leads', 'city')) {
                $table->string('city')->nullable()->after('address_line');
            }
            if (!Schema::hasColumn('leads', 'state')) {
                $table->string('state')->nullable()->after('city');
            }
            if (!Schema::hasColumn('leads', 'country')) {
                $table->string('country')->nullable()->after('state');
            }
            if (!Schema::hasColumn('leads', 'pin_code')) {
                $table->string('pin_code', 20)->nullable()->after('country');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            if (Schema::hasColumn('leads', 'address_line')) {
                $table->dropColumn('address_line');
            }
            if (Schema::hasColumn('leads', 'city')) {
                $table->dropColumn('city');
            }
            if (Schema::hasColumn('leads', 'state')) {
                $table->dropColumn('state');
            }
            if (Schema::hasColumn('leads', 'country')) {
                $table->dropColumn('country');
            }
            if (Schema::hasColumn('leads', 'pin_code')) {
                $table->dropColumn('pin_code');
            }
        });
    }
};
